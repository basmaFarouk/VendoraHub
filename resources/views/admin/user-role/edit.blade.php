@extends('admin.layouts.app')

@section('contents')
    <div class="container-xl">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Update User</h3>
                <div class="card-actions">
                    <a href="{{ route('admin.user-role.index') }}" class="btn btn-primary">Back</a>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.user-role.update', $admin) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label required">Name</label>
                                <input type="text" class="form-control" name="name" placeholder="" value="{{ $admin->name }}">
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label required">Email</label>
                                <input type="text" class="form-control" name="email" placeholder="" value="{{ $admin->email }}">
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label required">Password</label>
                                <input type="text" class="form-control" name="password" placeholder="" value="">
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label required">Confirm Password</label>
                                <input type="text" class="form-control" name="password_confirmation" placeholder="" value="">
                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label required">Role</label>
                                <select name="role" id="" class="form-control">
                                    <option value="">Select</option>
                                    @foreach($roles as $role)
                                        @if($role->name == 'Super Admin') @continue @endif
                                        <option @selected(in_array($role->name, $admin->getRoleNames()->toArray())) value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('role')" class="mt-2" />
                            </div>
                        </div>

                                                <div>
                            <button class="btn btn-primary btn-4 w-10" type="submit">
                                Update User
                                <!-- Download SVG icon from http://tabler.io/icons/icon/arrow-right -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="icon icon-right icon-2">
                                    <path d="M5 12l14 0"></path>
                                    <path d="M13 18l6 -6"></path>
                                    <path d="M13 6l6 6"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
    </div>
@endsection
