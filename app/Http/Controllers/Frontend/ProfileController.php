<?php

namespace App\Http\Controllers\Frontend;

use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use App\Services\AlertService;
use Illuminate\Http\RedirectResponse;

class ProfileController extends Controller
{
    use FileUploadTrait;
    public function index():View {
        return view('frontend.dashboard.account.index');
    }

    public function profileUpdate(Request $request): RedirectResponse  {
        $request->validate([
            'name' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email', 'unique:users,email,' . auth('web')->user()->id],
            'avatar' => ['nullable', 'image','max:2048'],
        ]);

        $filePath = $this->uploadFile($request->file('avatar'));

        $user = auth('web')->user();
        $filePath ? $user->avatar = $filePath : null;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        AlertService::updated("Profile Updated Successfully");
        return redirect()->back();
    }

    public function passwordUpdate(Request $request) {
        $request->validate([
            'current_password' => ['required', 'string', 'current_password'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        $user = auth('web')->user();
        $user->password = bcrypt($request->password);
        $user->save();

        AlertService::updated();
        return redirect()->back();
    }
}
