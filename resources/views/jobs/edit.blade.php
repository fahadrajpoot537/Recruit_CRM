@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <h4 class="mb-0 text-primary">
            <i class="bi bi-building me-2"></i> Edit Company
        </h4>

        <form action="{{ url('/companies/' . $company->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Company Name</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $company->name) }}"
                        required>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Contact</label>
                    <input type="text" name="contact" class="form-control"
                        value="{{ old('contact', $company->contact) }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $company->email) }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label>Postal Code</label>
                    <input type="text" name="postal_code" class="form-control"
                        value="{{ old('postal_code', $company->postal_code) }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label>Address</label>
                    <input type="text" name="address" class="form-control"
                        value="{{ old('address', $company->address) }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label>City</label>
                    <input type="text" name="city" class="form-control" value="{{ old('city', $company->city) }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label>State</label>
                    <input type="text" name="state" class="form-control" value="{{ old('state', $company->state) }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label>Country</label>
                    <input type="text" name="country" class="form-control"
                        value="{{ old('country', $company->country) }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label>Contact Person</label>
                    <input type="text" name="contractpname" class="form-control"
                        value="{{ old('contractpname', $company->contractpname) }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label>Head Office</label>
                    <input type="text" name="head_office" class="form-control"
                        value="{{ old('head_office', $company->head_office) }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label>No. of Employees</label>
                    <input type="text" name="no_of_employes" class="form-control"
                        value="{{ old('no_of_employes', $company->no_of_employes) }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label>No. of Offices</label>
                    <input type="text" name="no_of_offices" class="form-control"
                        value="{{ old('no_of_offices', $company->no_of_offices) }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label>Industry</label>
                    <select name="industry" class="form-control">
                        <option value="">-- Select Industry --</option>
                        @php
                            $industries = [
                                'Information Technology',
                                'Healthcare',
                                'Finance',
                                'Education',
                                'Retail',
                                'Manufacturing',
                                'Construction',
                                'Real Estate',
                                'Telecommunications',
                                'Transportation & Logistics',
                                'Hospitality',
                                'Legal',
                                'Government',
                                'Marketing & Advertising',
                                'Media & Entertainment',
                                'Oil & Gas',
                                'Energy & Utilities',
                                'Agriculture',
                                'Non-Profit',
                                'Aerospace & Defense',
                                'Automotive',
                                'Food & Beverage',
                                'Pharmaceuticals',
                                'Banking',
                                'Insurance',
                                'E-commerce',
                                "Environmental
                    Services",
                                'Human Resources',
                                'Fashion & Apparel',
                                'Biotechnology',
                                'Consulting',
                                'Security & Surveillance',
                                'Marine',
                                'Printing & Publishing',
                                'Mining & Metals',
                                'Events & Conferences',
                                'Customer Service',
                                'Sports & Recreation',
                            ];
                        @endphp

                        @foreach ($industries as $industry)
                            <option value="{{ $industry }}"
                                {{ old('industry', $company->industry) == $industry ? 'selected' : '' }}>
                                {{ $industry }}
                            </option>
                        @endforeach
                    </select>

                </div>

                <div class="col-md-6 mb-3">
                    <label>Facebook</label>
                    <input type="text" name="facebook" class="form-control"
                        value="{{ old('facebook', $company->facebook) }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label>LinkedIn</label>
                    <input type="text" name="linkedln" class="form-control"
                        value="{{ old('linkedln', $company->linkedln) }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label>Instagram</label>
                    <input type="text" name="instagram" class="form-control"
                        value="{{ old('instagram', $company->instagram) }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label>Twitter</label>
                    <input type="text" name="twitter" class="form-control"
                        value="{{ old('twitter', $company->twitter) }}">
                </div>

                <div class="col-12 mb-3">
                    <label>Description</label>
                    <textarea name="company_description" class="form-control" rows="4">{{ old('company_description', $company->company_description) }}</textarea>
                </div>

                <div class="col-12 text-end">
                    <button type="submit" class="btn btn-primary">💾 Save Changes</button>
                </div>
            </div>
        </form>
    </div>
@endsection
