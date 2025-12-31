@extends('admin.layouts.app')

@section('contents')
    <div class="container xl">

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Kyc Requests</h3>
                <div class="card-actions">
                    <a href="{{ url()->previous() }}" class="btn btn-primary btn-3">
                        <!-- Download SVG icon from http://tabler.io/icons/icon/plus -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="icon icon-2">
                            <path d="M12 5l0 14"></path>
                            <path d="M5 12l14 0"></path>
                        </svg>
                        Back
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-vcenter card-table">
                        <tbody>
                            <tr>
                                <td>Full Name</td>
                                <td>{{ $Kyc_request->full_name }}</td>
                            </tr>
                            <tr>
                                <td>Date of Birth</td>
                                <td>{{ $Kyc_request->date_of_birth }}</td>
                            </tr>
                            <tr>
                                <td>Gender</td>
                                <td>{{ $Kyc_request->gender }}</td>
                            </tr>
                            <tr>
                                <td>Full Address</td>
                                <td>{{ $Kyc_request->full_address }}</td>
                            </tr>
                            <tr>
                                <td>Document Type</td>
                                <td>{{ $Kyc_request->document_type }}</td>
                            </tr>
                            <tr>
                                <td>Document Scan Copy</td>
                                <td><a class="btn btn-primary" href="{{ route('admin.kyc.download', $Kyc_request) }}">Download</a></td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td class="text-secondary"><span class="badge bg-{{ $Kyc_request->status->color() }}-lt"> {{ $Kyc_request->status->label() }}</span></td>
                            </tr>
                            <tr>
                                <td>Change Status</td>
                                <td>
                                    <form action="{{ route('admin.kyc.update', $Kyc_request) }}" method="Post">
                                        @csrf
                                        @method('Put')
                                        <div class="input-group">
                                            <select name="status" id="" class="form-control">
                                                <option value="pending">Pending</option>
                                                <option value="approved">Approved</option>
                                                <option value="rejected">Rejected</option>
                                            </select>
                                            <button class="btn btn-primary" type="submit">Update</button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
