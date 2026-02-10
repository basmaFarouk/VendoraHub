@extends('vendor-dashboard.layouts.app')

@section('contents')

    <div class="container xl">
        <form class="card" method="POST" action="{{ route('vendor.store-profile.update', 1) }}" enctype="multipart/form-data">
            @csrf
            @method("PUT")
            <div class="card-header">
                <h3 class="card-title">Update Store Profile</h3>
            </div>
            <div class="card-body ">
                <div class="row">
                    <div class="mb-3 col-md-6">
                        <label for="" class="form-label"> Logo</label>
                        <x-input-image image-upload-id="image-upload" name="logo" image-preview-id="image-preview" image-label-id="image-label" name="logo" :image="asset($store->logo ?? '')"/>
                        <x-input-error :messages="$errors->get('logo')" class="mt-2" />

                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label ">Banner</label>
                        <x-input-image image-upload-id="image-upload-two" name="banner" image-preview-id="image-preview-two" image-label-id="image-label-two" name="banner" :image="asset($store->banner ?? '')"/>
                        <x-input-error :messages="$errors->get('banner')" class="mt-2" />
                    </div>
                </div>
                <div class="mb-3 col-md-12">
                    <label class="form-label required">Name</label>
                    <div>
                        <input type="text" class="form-control" placeholder="Enter Name" name="name" value="{{ $store->name ?? '' }}">
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3 col-md-6">
                        <label class="form-label required">Email</label>
                        <div>
                            <input type="email" class="form-control" placeholder="Enter Email" name="email" value="{{ $store->email ?? '' }}">
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label required">Phone</label>
                        <div>
                            <input type="text" class="form-control" placeholder="Enter Phone Number" name="phone" value="{{ $store->phone ?? '' }}">
                            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="mb-3 col-md-12">
                        <label class="form-label required">Short Description</label>
                        <div>
                            <textarea name="short_description" id="" class="form-control">{{ $store->short_description ?? '' }}</textarea>
                            <x-input-error :messages="$errors->get('short_description')" class="mt-2" />
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="mb-3 col-md-12">
                        <label class="form-label required">Long Description</label>
                        <div>
                            <textarea name="long_description" id="editor" class="form-control">{{ $store->long_description ?? '' }}</textarea>
                            <x-input-error :messages="$errors->get('long_description')" class="mt-2" />
                        </div>
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
        $(document).ready(function () {
            $.uploadPreview({
                input_field: "#image-upload",   // Default: .image-upload
                preview_box: "#image-preview",  // Default: .image-preview
                label_field: "#image-label",    // Default: .image-label
                label_default: "Choose File",   // Default: Choose File
                label_selected: "Change File",  // Default: Change File
                no_label: false                 // Default: false
            });

            $.uploadPreview({
                input_field: "#image-upload-two",   // Default: .image-upload
                preview_box: "#image-preview-two",  // Default: .image-preview
                label_field: "#image-label-two",    // Default: .image-label
                label_default: "Choose File",   // Default: Choose File
                label_selected: "Change File",  // Default: Change File
                no_label: false                 // Default: false
            });
        });
    </script>
@endpush
