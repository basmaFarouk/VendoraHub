@extends('admin.layouts.app')

@section('contents')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Create Role</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.roles.store') }}" method="POST">
                @csrf
                <div class="space-y">
                    <div>
                        <label class="form-label"> Role Name </label>
                        <input type="text" placeholder="Enter role name" class="form-control" name="role">
                        <x-input-error :messages="$errors->get('role')" class="mt-2" />
                    </div>

                    <div>
                        <label class="form-label">Select Permissions</label>
                        <select class="form-select select2-multiple" name="permissions[]" multiple="multiple"
                            id="permissionsSelect">
                            @foreach ($permissions as $groupName => $items)
                                <optgroup label="{{ $groupName }}">
                                    @foreach ($items as $permission)
                                        <option value="{{ $permission->id }}">{{ $permission->name }}</option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <button class="btn btn-primary btn-4 w-10" type="submit">
                            Create Role
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
@endsection
