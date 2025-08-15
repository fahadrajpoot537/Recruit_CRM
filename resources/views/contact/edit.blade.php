@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <h4 class="mb-0 text-primary">
            <i class="bi bi-building me-2"></i> Edit Contact
        </h4>

        <form action="{{ url('/contact/' . $contact->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>First Name</label>
                    <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror"
                        value="{{ old('first_name', $contact->first_name) }}">
                    @error('first_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label>Last Name</label>
                    <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror"
                        value="{{ old('last_name', $contact->last_name) }}">
                    @error('last_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label>Companies</label>
                    <select id="input_tags"
                        class="form-control select2 select2-multiple @error('company_ids') is-invalid @enderror"
                        multiple="multiple" data-placeholder="Choose" name="company_ids[]">
                        @foreach ($companies as $company)
                            <option value="{{ $company->id }}"
                                {{ in_array($company->id, old('company_ids', $contact->companies->pluck('id')->toArray())) ? 'selected' : '' }}>
                                {{ $company->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('company_ids')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label>Title</label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                        value="{{ old('title', $contact->title) }}">
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email', $contact->email) }}">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label>Phone</label>
                    <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                        value="{{ old('phone', $contact->phone) }}">
                    @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label>Facebook Profile URL</label>
                    <input type="url" name="facebook_profile_url"
                        class="form-control @error('facebook_profile_url') is-invalid @enderror"
                        value="{{ old('facebook_profile_url', $contact->facebook_profile_url) }}">
                    @error('facebook_profile_url')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label>Twitter Profile URL</label>
                    <input type="url" name="twitter_profile_url"
                        class="form-control @error('twitter_profile_url') is-invalid @enderror"
                        value="{{ old('twitter_profile_url', $contact->twitter_profile_url) }}">
                    @error('twitter_profile_url')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label>LinkedIn Profile URL</label>
                    <input type="url" name="linkedin_profile_url"
                        class="form-control @error('linkedin_profile_url') is-invalid @enderror"
                        value="{{ old('linkedin_profile_url', $contact->linkedin_profile_url) }}">
                    @error('linkedin_profile_url')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label>Xing Profile URL</label>
                    <input type="url" name="xing_profile_url"
                        class="form-control @error('xing_profile_url') is-invalid @enderror"
                        value="{{ old('xing_profile_url', $contact->xing_profile_url) }}">
                    @error('xing_profile_url')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label>Stage</label>
                    <input type="text" name="stage" class="form-control @error('stage') is-invalid @enderror"
                        value="{{ old('stage', $contact->stage) }}">
                    @error('stage')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label>Locality</label>
                    <input type="text" name="locality" class="form-control @error('locality') is-invalid @enderror"
                        value="{{ old('locality', $contact->locality) }}">
                    @error('locality')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label>City</label>
                    <input type="text" name="city" class="form-control @error('city') is-invalid @enderror"
                        value="{{ old('city', $contact->city) }}">
                    @error('city')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label>State</label>
                    <input type="text" name="state" class="form-control @error('state') is-invalid @enderror"
                        value="{{ old('state', $contact->state) }}">
                    @error('state')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label>Country</label>
                    <input type="text" name="country" class="form-control @error('country') is-invalid @enderror"
                        value="{{ old('country', $contact->country) }}">
                    @error('country')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label>Postal Code</label>
                    <input type="text" name="postal_code"
                        class="form-control @error('postal_code') is-invalid @enderror"
                        value="{{ old('postal_code', $contact->postal_code) }}">
                    @error('postal_code')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 mb-3">
                    <label>Full Address</label>
                    <textarea name="full_address" class="form-control @error('full_address') is-invalid @enderror" rows="3">{{ old('full_address', $contact->full_address) }}</textarea>
                    @error('full_address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 text-end">
                    <button type="submit" class="btn btn-primary">💾 Save Changes</button>
                </div>
            </div>
        </form>

    </div>
    <script>
        $("#input_tags").select2({
            tags: true,
            tokenSeparators: [',', ' ']

        });
    </script>
@endsection
