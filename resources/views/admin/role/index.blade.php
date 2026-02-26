@extends('admin.layouts.app')

@section('contents')
    <div class="container xl">

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Roles</h3>
                <div class="card-actions">
                    <a href="{{ route('admin.roles.create') }}" class="btn btn-primary btn-3">
                        <!-- Download SVG icon from http://tabler.io/icons/icon/plus -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="icon icon-2">
                            <path d="M12 5l0 14"></path>
                            <path d="M5 12l14 0"></path>
                        </svg>
                        Add Role
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="card-body border-bottom py-3">
                    <form class="d-flex" action="{{ url()->current() }}" method="GET">
                        <div class="text-muted">
                            Search:
                            <div class="ms-2 d-inline-block">
                                <input type="text" class="form-control form-control-md" name="search"
                                    value="{{ request('search') }}" placeholder="Name or Email">
                            </div>
                        </div>
                        <div class="ms-3 text-muted">
                            Status:
                            <div class="ms-2 d-inline-block">
                                <select class="form-select form-select-md" name="status">
                                    <option value="">All</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending
                                    </option>
                                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>
                                        Approved</option>
                                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>
                                        Rejected</option>
                                </select>
                            </div>
                        </div>
                        <div class="ms-3">
                            <button type="submit" class="btn btn-primary btn-md">Filter</button>
                            <a href="{{ url()->current() }}" class="btn btn-secondary btn-md">Reset</a>
                        </div>
                    </form>
                </div>
                <div class="table-responsive">
                    <table class="table table-vcenter card-table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th> Role Name</th>
                                <th>Permissions</th>
                                <th class="w-1"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($roles as $role)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $role->name }}</td>
                                    <td> <span class="badge bg-primary-lt">{{ $role->permissions_count }}</span></td>
                                    <td>
                                        @if ($role->name != 'Super Admin')
                                            <a href="{{ route('admin.roles.edit', $role) }}">Edit</a>
                                            <a href="{{ route('admin.roles.destroy', $role) }}"
                                                class="text-danger delete-button"
                                                data-url="{{ route('admin.roles.destroy', $role) }}">Delete</a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center"> No Data Found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="card-footer">
                    {{-- {{ $kycRequests->withQueryString()->links() }} --}}
                </div>
            </div>
        </div>
    </div>
@endsection
