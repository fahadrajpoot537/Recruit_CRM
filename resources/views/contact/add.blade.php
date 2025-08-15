@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="blogapp-content">
                    <div class="blogapp-content">
                        <div class="blogapp-detail-wrap">
                            <header class="blog-header">
                                <div class="d-flex align-items-center">
                                    <a class="blogapp-title link-dark" href="#">
                                        <h1>Add Contact</h1>
                                    </a>
                                </div>
                            </header>
                            <div class="blog-body">
                                <div data-simplebar class="nicescroll-bar">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-xxl-12 col-lg-12">
                                                <form class="edit-post-form contactform"
                                                    action="{{ route('contact.store') }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    @csrf

                                                    <!-- Contact Basic Information -->
                                                    <div class="form-group row">
                                                        <div class="form-group col-lg-6">
                                                            <label class="form-label">First Name*</label>
                                                            <input type="text" class="form-control" name="first_name"
                                                                value="{{ old('first_name') }}" placeholder="First Name"
                                                                required>
                                                        </div>
                                                        <div class="form-group col-lg-6">
                                                            <label class="form-label">Last Name</label>
                                                            <input type="text" class="form-control" name="last_name"
                                                                value="{{ old('last_name') }}" placeholder="Last Name">
                                                        </div>
                                                    </div>

                                                    <!-- Multiple Company Selection -->
                                                    <div class="form-group row">
                                                        <div class="form-group col-lg-12">
                                                            <label class="form-label">Company</label>

                                                            <select id="input_tags"
                                                                class="form-control select2 select2-multiple"
                                                                multiple="multiple" data-placeholder="Choose"
                                                                multiple="multiple" name="company_ids[]">
                                                                <!-- Options would be populated dynamically -->
                                                                @foreach ($companies as $company)
                                                                    <option value="{{ $company->id }}">{{ $company->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>


                                                        </div>
                                                    </div>

                                                    <!-- Title, Email, Phone -->
                                                    <div class="form-group row">
                                                        <div class="form-group col-lg-6">
                                                            <label class="form-label">Title</label>
                                                            <input type="text" class="form-control" name="title"
                                                                value="{{ old('title') }}" placeholder="Job Title / Role">
                                                        </div>
                                                        <div class="form-group col-lg-6">
                                                            <label class="form-label">Email</label>
                                                            <input type="email" class="form-control" name="email"
                                                                value="{{ old('email') }}" placeholder="Email Address">
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <div class="form-group col-lg-6">
                                                            <label class="form-label">Phone</label>
                                                            <input type="text" class="form-control" name="phone"
                                                                value="{{ old('phone') }}" placeholder="Phone Number">
                                                        </div>
                                                        <div class="form-group col-lg-6">
                                                            <label class="form-label">Stage</label>
                                                            <input type="text" class="form-control" name="stage"
                                                                value="{{ old('stage') }}"
                                                                placeholder="Stage (Lead, Client, etc.)">
                                                        </div>
                                                    </div>

                                                    <!-- Social Profiles -->
                                                    <div class="form-group row">
                                                        <div class="form-group col-lg-6">
                                                            <label class="form-label">Facebook</label>
                                                            <input type="url" class="form-control"
                                                                name="facebook_profile_url"
                                                                value="{{ old('facebook_profile_url') }}"
                                                                placeholder="Facebook URL">
                                                        </div>
                                                        <div class="form-group col-lg-6">
                                                            <label class="form-label">Twitter</label>
                                                            <input type="url" class="form-control"
                                                                name="twitter_profile_url"
                                                                value="{{ old('twitter_profile_url') }}"
                                                                placeholder="Twitter URL">
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <div class="form-group col-lg-6">
                                                            <label class="form-label">LinkedIn</label>
                                                            <input type="url" class="form-control"
                                                                name="linkedin_profile_url"
                                                                value="{{ old('linkedin_profile_url') }}"
                                                                placeholder="LinkedIn URL">
                                                        </div>
                                                        <div class="form-group col-lg-6">
                                                            <label class="form-label">Xing</label>
                                                            <input type="url" class="form-control"
                                                                name="xing_profile_url"
                                                                value="{{ old('xing_profile_url') }}"
                                                                placeholder="Xing URL">
                                                        </div>
                                                    </div>

                                                    <!-- Address -->
                                                    <div class="form-group row">
                                                        <div class="form-group col-lg-4">
                                                            <label class="form-label">Locality</label>
                                                            <input type="text" class="form-control" name="locality"
                                                                value="{{ old('locality') }}" placeholder="Locality">
                                                        </div>
                                                        <div class="form-group col-lg-4">
                                                            <label class="form-label">City</label>
                                                            <input type="text" class="form-control" name="city"
                                                                value="{{ old('city') }}" placeholder="City">
                                                        </div>
                                                        <div class="form-group col-lg-4">
                                                            <label class="form-label">State</label>
                                                            <input type="text" class="form-control" name="state"
                                                                value="{{ old('state') }}" placeholder="State">
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <div class="form-group col-lg-6">
                                                            <label class="form-label">Country</label>
                                                            <input type="text" class="form-control" name="country"
                                                                value="{{ old('country') }}" placeholder="Country">
                                                        </div>
                                                        <div class="form-group col-lg-6">
                                                            <label class="form-label">Postal Code</label>
                                                            <input type="text" class="form-control" name="postal_code"
                                                                value="{{ old('postal_code') }}"
                                                                placeholder="Postal Code">
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <div class="form-group col-lg-12">
                                                            <label class="form-label">Full Address</label>
                                                            <textarea class="form-control" name="full_address" rows="2" placeholder="Full Address">{{ old('full_address') }}</textarea>
                                                        </div>
                                                    </div>

                                                    <!-- Submit -->
                                                    <div class="form-group row mt-4">
                                                        <div class="col-lg-12 text-end">
                                                            <button type="submit" class="btn btn-primary">Save
                                                                Contact</button>
                                                        </div>
                                                    </div>
                                                </form>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
       
        <script>
            $("#input_tags").select2({
                tags: true,
                tokenSeparators: [',', ' ']

            });
        </script>

    @endsection
