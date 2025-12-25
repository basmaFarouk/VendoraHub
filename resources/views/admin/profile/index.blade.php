@extends('admin.layouts.app')

@section('contents')

    <div class="container xl">
        <form class="card" method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method("PUT")
            <div class="card-header">
                <h3 class="card-title">Update Profile</h3>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <x-input-image id="image-preview" name="avatar" :image=" asset(auth('admin')->user()->avatar)" />
                    <x-input-error :messages="$errors->get('avatar')" class="mt-2" />
                </div>
                <div class="mb-3">
                    <label class="form-label required">Name</label>
                    <div>
                        <input type="text" class="form-control" placeholder="Enter Name"
                            name="name" value="{{ auth('admin')->user()->name }}">
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label required">Email address</label>
                    <div>
                        <input type="email" class="form-control" aria-describedby="emailHelp" placeholder="Enter email"
                            name="email" value="{{ auth('admin')->user()->email }}">
                        <small class="form-hint">We'll never share your email with anyone else.</small>

                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>
                </div>
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>

        <form class="card mt-5" method="POST" action="{{ route('admin.password.update') }}">
            @csrf
            @method('Put')
            <div class="card-header">
                <h3 class="card-title">Update Password</h3>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label required">Current Password</label>
                    <div>
                        <input type="password" class="form-control" name="current_password" placeholder="Current Password">
                        <small class="form-hint">
                            Please Enter Your Current Password
                        </small>
                        <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label required"> New Password</label>
                    <div>
                        <input type="password" name="password" class="form-control" placeholder="New Password">
                        <small class="form-hint">
                            Your password must be 8-20 characters long, contain letters and numbers, and must not contain
                            spaces, special characters, or emoji.
                        </small>
                        <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label required">Confirm Password</label>
                    <div>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password">
                        <small class="form-hint">
                            Your password must be 8-20 characters long, contain letters and numbers, and must not contain
                            spaces, special characters, or emoji.
                        </small>
                        <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                    </div>
                </div>
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>
    </div>

@endsection

@push('scripts')
    <script type="text/javascript">
    $(document).ready(function() {
    $.uploadPreview({
        input_field: "#image-upload",   // Default: .image-upload
        preview_box: "#image-preview",  // Default: .image-preview
        label_field: "#image-label",    // Default: .image-label
        label_default: "Choose File",   // Default: Choose File
        label_selected: "Change File",  // Default: Change File
        no_label: false                 // Default: false
    });
    });
    </script>
@endpush
