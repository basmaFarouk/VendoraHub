<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Services\AlertService;
use App\Http\Controllers\Controller;
use App\Traits\FileUploadTrait;
use Illuminate\Http\RedirectResponse;

class ProfileController extends Controller
{
    use FileUploadTrait;
    public function index() {
        return view('admin.profile.index');
    }

    public function profileUpdate(Request $request): RedirectResponse  {

        $request->validate([
            'name' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email', 'unique:admins,email,' . auth('admin')->user()->id],
            'avatar' => ['nullable', 'image','max:2048'],
        ]);


        $user = auth('admin')->user();
        if($request->hasFile('avatar')) {

            $filePath = $this->uploadFile($request->file('avatar'));
            $filePath ? $user->avatar = $filePath : null;
        }
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        AlertService::updated("Profile Updated Successfully");
        return redirect()->back();
    }
}
