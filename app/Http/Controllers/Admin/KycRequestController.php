<?php

namespace App\Http\Controllers\Admin;

use App\Enums\KycStatus;
use App\Models\Kyc;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use App\Services\AlertService;
use App\Services\MailService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class KycRequestController extends Controller implements HasMiddleware
{
    static function Middleware(): array
    {
        return [
            new Middleware('permission:KYC Management')
        ];
    }
    public function index(Request $request): View
    {
        $kycRequests = Kyc::query()
            ->with('user')
            ->when($request->search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('full_name', 'like', "%{$search}%")
                        ->orWhereHas('user', function ($subQ) use ($search) {
                            $subQ->where('email', 'like', "%{$search}%");
                        });
                });
            })
            ->when($request->status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->latest()
            ->paginate(25);
        return view('admin.kyc.index', compact('kycRequests'));
    }

    public function show(Kyc $Kyc_request): View
    {
        return view('admin.kyc.show', compact('Kyc_request'));
    }

    public function download(Kyc $Kyc_request): mixed
    {
        return Storage::disk('local')->download($Kyc_request->document_scan_copy);
    }

    public function update(Kyc $Kyc_request, Request $request)
    {
        $Kyc_request->update([
            'status' => $request->status,
        ]);

        if ($Kyc_request->status == KycStatus::Approved) {
            $body = 'Congratulations Your Kyc has been approved';
        } else {
            $body = 'Sorry Your Kyc has been rejected';
        }

        MailService::send(
            to: $Kyc_request->user->email,
            subject: 'Kyc Status Updated',
            body: $body
        );

        AlertService::updated("Kyc Status Updated Successfully");
        return redirect(route('admin.kyc.index'));
    }
}
