<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Kyc;
use App\Enums\KycStatus;
use Illuminate\Http\Request;
use App\Services\AlertService;
use App\Traits\FileUploadTrait;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class KycController extends Controller
{
    use FileUploadTrait;
    public function index(): RedirectResponse|View {
        if(auth('web')->user()->kyc?->status == KycStatus::Pending || auth('web')->user()->kyc?->status == KycStatus::Approved) {
            return redirect(route('vendor.dashboard'));
        }
        return view('frontend.pages.kyc');
    }

    public function store(Request $request) {
        $request->validate([
            'full_name' => ['required', 'max:255','string'],
            'date_of_birth' => ['required', 'date'],
            'gender' => ['required', 'in:male,female'],
            'full_address' => ['required', 'string', 'max:255'],
            'document_type' => ['required', 'string', 'max:255'],
            'document_scan_copy' => ['required', 'mimes:png,pdf,csv,docx', 'max:10000'],

        ]);

        if(Kyc::where('user_id',auth('web')->user()->id)->exists()) {
            $kyc = Kyc::where('user_id', auth('web')->user()->id)->first();
        }else{
            $kyc = new Kyc();
        }
        $kyc->full_name = $request->full_name;
        $kyc->status = KycStatus::Pending;
        $kyc->date_of_birth = $request->date_of_birth;
        $kyc->gender = $request->gender;
        $kyc->user_id = auth('web')->user()->id;
        $kyc->full_address = $request->full_address;
        $kyc->document_type = $request->document_type;
        $filePath = $this->uploadPrivateFile($request->file('document_scan_copy'));
        $kyc->document_scan_copy = $filePath;
        $kyc->save();

        AlertService::created('Your Kyc has been Submitted Successfully! Please wait for Admin Approval');

        return redirect()->route('vendor.dashboard');
    }
}
