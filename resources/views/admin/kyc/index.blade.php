@extends('admin.layouts.app')

@section('contents')
    <div class="container xl">

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Kyc Requests</h3>
                <div class="card-actions">
                    <a href="#" class="btn btn-primary btn-3">
                        <!-- Download SVG icon from http://tabler.io/icons/icon/plus -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="icon icon-2">
                            <path d="M12 5l0 14"></path>
                            <path d="M5 12l14 0"></path>
                        </svg>
                        Add new
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="card-body border-bottom py-3">
                    <form class="d-flex" action="{{ url()->current() }}" method="GET">
                        <div class="text-muted">
                            Search:
                            <div class="ms-2 d-inline-block">
                                <input type="text" class="form-control form-control-md" name="search" value="{{ request('search') }}" placeholder="Name or Email">
                            </div>
                        </div>
                        <div class="ms-3 text-muted">
                            Status:
                            <div class="ms-2 d-inline-block">
                                <select class="form-select form-select-md" name="status">
                                    <option value="">All</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
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
                                <th>Name</th>
                                <th>Email</th>
                                <th>Date of birth</th>
                                <th>Gender</th>
                                <th>Status</th>
                                <th class="w-1"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($kycRequests as $kycRequest)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $kycRequest->full_name }}</td>
                                    <td class="text-secondary">{{ $kycRequest->user->email }}</td>
                                    <td class="text-secondary">{{ $kycRequest->date_of_birth }}</td>
                                    <td class="text-secondary">{{ $kycRequest->gender }}</td>
                                    <td class="text-secondary"><span class="badge bg-{{ $kycRequest->status->color() }}-lt">
                                            {{ $kycRequest->status->label() }}</span></td>
                                    <td>
                                        <a href="{{ route('admin.kyc.show', $kycRequest) }}">View</a>
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
                    {{ $kycRequests->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
