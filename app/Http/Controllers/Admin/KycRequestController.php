<?php

namespace App\Http\Controllers\Admin;

use App\Models\Kyc;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use App\Services\AlertService;
use Illuminate\Support\Facades\Storage;

class KycRequestController extends Controller
{
    public function index(): View {
        $kycRequests = Kyc::paginate(25);
        return view('admin.kyc.index', compact('kycRequests'));
    }

    public function show(Kyc $Kyc_request): View {
        return view('admin.kyc.show', compact('Kyc_request'));
    }

    public function download(Kyc $Kyc_request): mixed {
        return Storage::disk('local')->download($Kyc_request->document_scan_copy);
    }

    public function update(Kyc $Kyc_request, Request $request){
        $Kyc_request->update([
            'status' => $request->status,
        ]);

        AlertService::updated("Kyc Status Updated Successfully");
        return redirect(route('admin.kyc.index'));

    }
}
