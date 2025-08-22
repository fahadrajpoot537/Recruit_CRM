@extends('layouts.app')

@section('content')
    <style>
        .is-invalid {
            border-color: #dc3545 !important;
        }

        .invalid-feedback {
            display: block;
            width: 100%;
            margin-top: 0.25rem;
            font-size: 0.875em;
            color: #dc3545;
        }
    </style>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-12">

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="card border-0 shadow-lg rounded-4">
                    <div class="card-header bg-gradient text-white"
                        style="background: linear-gradient(45deg, #007bff, #6610f2);">
                        <h4 class="mb-0 text-primary">
                            <i class="bi bi-building me-2"></i> Create New Company
                        </h4>
                    </div>
                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('companies.store') }}">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Company Name <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control shadow-sm @error('name') is-invalid @enderror"
                                        name="name" id="name" value="{{ old('name') }}" >
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                @role('super-admin')
                                    <div class="col-md-6">
                                        <label for="type" class="form-label">Recruiter Company</label>
                                        <select class="form-control shadow-sm @error('company_user_id') is-invalid @enderror"
                                            name="company_user_id" id="creator">
                                            <option value="" disabled>-- Select Type --</option>
                                            @foreach ($creators as $creator)
                                                <option value="{{ $creator->id }}"
                                                    {{ old('company_user_id') == $creator->id ? 'selected' : '' }}>
                                                    {{ $creator->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('company_user_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                @endrole

                                <div class="col-md-6">
                                    <label for="type" class="form-label">Company Type <span
                                            class="text-danger">*</span></label>
                                    <select class="form-control shadow-sm @error('type') is-invalid @enderror"
                                        name="type" id="type">
                                        <option value="">-- Select Type --</option>
                                        <option value="resources" {{ old('type') == 'resources' ? 'selected' : '' }}>
                                            Resources</option>
                                        <option value="recruiter" {{ old('type') == 'recruiter' ? 'selected' : '' }}>
                                            Recruiter</option>
                                    </select>
                                    @error('type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="contact" class="form-label">Contact <span
                                            class="text-danger">*</span></label>
                                    <input type="text"
                                        class="form-control shadow-sm @error('contact') is-invalid @enderror" name="contact"
                                        id="contact" value="{{ old('contact') }}">
                                    @error('contact')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="registration" class="form-label">Registration Number <span
                                            class="text-danger">*</span></label>
                                    <input type="text"
                                        class="form-control shadow-sm @error('registration_number') is-invalid @enderror"
                                        name="registration_number" id="registration"
                                        value="{{ old('registration_number') }}">
                                    @error('registration_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email <span
                                            class="text-danger">*</span></label>
                                    <input type="email"
                                        class="form-control shadow-sm @error('email') is-invalid @enderror" name="email"
                                        id="email" value="{{ old('email') }}">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="postal_code" class="form-label">Postal Code</label>
                                    <input type="text"
                                        class="form-control shadow-sm @error('postal_code') is-invalid @enderror"
                                        name="postal_code" id="postal_code" value="{{ old('postal_code') }}">
                                    @error('postal_code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label for="address" class="form-label">Address</label>
                                    <input type="text"
                                        class="form-control shadow-sm @error('address') is-invalid @enderror" name="address"
                                        id="address" value="{{ old('address') }}">
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="city" class="form-label">City</label>
                                    <input type="text" class="form-control shadow-sm @error('city') is-invalid @enderror"
                                        name="city" id="city" value="{{ old('city') }}">
                                    @error('city')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="state" class="form-label">State</label>
                                    <input type="text"
                                        class="form-control shadow-sm @error('state') is-invalid @enderror" name="state"
                                        id="state" value="{{ old('state') }}">
                                    @error('state')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="country" class="form-label">Country</label>
                                    <input type="text"
                                        class="form-control shadow-sm @error('country') is-invalid @enderror"
                                        name="country" id="country" value="{{ old('country') }}">
                                    @error('country')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="contractpname" class="form-label">Contract Person Name</label>
                                    <input type="text"
                                        class="form-control shadow-sm @error('contractpname') is-invalid @enderror"
                                        name="contractpname" id="contractpname" value="{{ old('contractpname') }}">
                                    @error('contractpname')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="company_description" class="form-label">Company Description</label>
                                    <input type="text"
                                        class="form-control shadow-sm @error('company_description') is-invalid @enderror"
                                        name="company_description" id="company_description"
                                        value="{{ old('company_description') }}">
                                    @error('company_description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="head_office" class="form-label">Head Office</label>
                                    <input type="text"
                                        class="form-control shadow-sm @error('head_office') is-invalid @enderror"
                                        name="head_office" id="head_office" value="{{ old('head_office') }}">
                                    @error('head_office')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="no_of_employes" class="form-label">Number of Employees</label>
                                    <input type="text"
                                        class="form-control shadow-sm @error('no_of_employes') is-invalid @enderror"
                                        name="no_of_employes" id="no_of_employes" value="{{ old('no_of_employes') }}">
                                    @error('no_of_employes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="no_of_offices" class="form-label">Number of Offices</label>
                                    <input type="text"
                                        class="form-control shadow-sm @error('no_of_offices') is-invalid @enderror"
                                        name="no_of_offices" id="no_of_offices" value="{{ old('no_of_offices') }}">
                                    @error('no_of_offices')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="industry" class="form-label">Industry</label>
                                    <select name="industry" class="form-control @error('industry') is-invalid @enderror">
                                        <option value="">-- Select Industry --</option>
                                        <option value="Information Technology"
                                            {{ old('industry') == 'Information Technology' ? 'selected' : '' }}>Information
                                            Technology</option>
                                        <option value="Healthcare"
                                            {{ old('industry') == 'Healthcare' ? 'selected' : '' }}>Healthcare</option>
                                        <option value="Finance" {{ old('industry') == 'Finance' ? 'selected' : '' }}>
                                            Finance</option>
                                        <option value="Education" {{ old('industry') == 'Education' ? 'selected' : '' }}>
                                            Education</option>
                                        <option value="Retail" {{ old('industry') == 'Retail' ? 'selected' : '' }}>Retail
                                        </option>
                                        <option value="Manufacturing"
                                            {{ old('industry') == 'Manufacturing' ? 'selected' : '' }}>Manufacturing
                                        </option>
                                        <option value="Construction"
                                            {{ old('industry') == 'Construction' ? 'selected' : '' }}>Construction</option>
                                        <option value="Real Estate"
                                            {{ old('industry') == 'Real Estate' ? 'selected' : '' }}>Real Estate</option>
                                        <option value="Telecommunications"
                                            {{ old('industry') == 'Telecommunications' ? 'selected' : '' }}>
                                            Telecommunications</option>
                                        <option value="Transportation & Logistics"
                                            {{ old('industry') == 'Transportation & Logistics' ? 'selected' : '' }}>
                                            Transportation & Logistics</option>
                                        <option value="Hospitality"
                                            {{ old('industry') == 'Hospitality' ? 'selected' : '' }}>Hospitality</option>
                                        <option value="Legal" {{ old('industry') == 'Legal' ? 'selected' : '' }}>Legal
                                        </option>
                                        <option value="Government"
                                            {{ old('industry') == 'Government' ? 'selected' : '' }}>Government</option>
                                        <option value="Marketing & Advertising"
                                            {{ old('industry') == 'Marketing & Advertising' ? 'selected' : '' }}>Marketing
                                            & Advertising</option>
                                        <option value="Media & Entertainment"
                                            {{ old('industry') == 'Media & Entertainment' ? 'selected' : '' }}>Media &
                                            Entertainment</option>
                                        <option value="Oil & Gas" {{ old('industry') == 'Oil & Gas' ? 'selected' : '' }}>
                                            Oil & Gas</option>
                                        <option value="Energy & Utilities"
                                            {{ old('industry') == 'Energy & Utilities' ? 'selected' : '' }}>Energy &
                                            Utilities</option>
                                        <option value="Agriculture"
                                            {{ old('industry') == 'Agriculture' ? 'selected' : '' }}>Agriculture</option>
                                        <option value="Non-Profit"
                                            {{ old('industry') == 'Non-Profit' ? 'selected' : '' }}>Non-Profit</option>
                                        <option value="Aerospace & Defense"
                                            {{ old('industry') == 'Aerospace & Defense' ? 'selected' : '' }}>Aerospace &
                                            Defense</option>
                                        <option value="Automotive"
                                            {{ old('industry') == 'Automotive' ? 'selected' : '' }}>Automotive</option>
                                        <option value="Food & Beverage"
                                            {{ old('industry') == 'Food & Beverage' ? 'selected' : '' }}>Food & Beverage
                                        </option>
                                        <option value="Pharmaceuticals"
                                            {{ old('industry') == 'Pharmaceuticals' ? 'selected' : '' }}>Pharmaceuticals
                                        </option>
                                        <option value="Banking" {{ old('industry') == 'Banking' ? 'selected' : '' }}>
                                            Banking</option>
                                        <option value="Insurance" {{ old('industry') == 'Insurance' ? 'selected' : '' }}>
                                            Insurance</option>
                                        <option value="E-commerce"
                                            {{ old('industry') == 'E-commerce' ? 'selected' : '' }}>E-commerce</option>
                                        <option value="Environmental Services"
                                            {{ old('industry') == 'Environmental Services' ? 'selected' : '' }}>
                                            Environmental Services</option>
                                        <option value="Human Resources"
                                            {{ old('industry') == 'Human Resources' ? 'selected' : '' }}>Human Resources
                                        </option>
                                        <option value="Fashion & Apparel"
                                            {{ old('industry') == 'Fashion & Apparel' ? 'selected' : '' }}>Fashion &
                                            Apparel</option>
                                        <option value="Biotechnology"
                                            {{ old('industry') == 'Biotechnology' ? 'selected' : '' }}>Biotechnology
                                        </option>
                                        <option value="Consulting"
                                            {{ old('industry') == 'Consulting' ? 'selected' : '' }}>Consulting</option>
                                        <option value="Security & Surveillance"
                                            {{ old('industry') == 'Security & Surveillance' ? 'selected' : '' }}>Security &
                                            Surveillance</option>
                                        <option value="Marine" {{ old('industry') == 'Marine' ? 'selected' : '' }}>Marine
                                        </option>
                                        <option value="Printing & Publishing"
                                            {{ old('industry') == 'Printing & Publishing' ? 'selected' : '' }}>Printing &
                                            Publishing</option>
                                        <option value="Mining & Metals"
                                            {{ old('industry') == 'Mining & Metals' ? 'selected' : '' }}>Mining & Metals
                                        </option>
                                        <option value="Events & Conferences"
                                            {{ old('industry') == 'Events & Conferences' ? 'selected' : '' }}>Events &
                                            Conferences</option>
                                        <option value="Customer Service"
                                            {{ old('industry') == 'Customer Service' ? 'selected' : '' }}>Customer Service
                                        </option>
                                        <option value="Sports & Recreation"
                                            {{ old('industry') == 'Sports & Recreation' ? 'selected' : '' }}>Sports &
                                            Recreation</option>
                                    </select>
                                    @error('industry')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="facebook" class="form-label">Facebook</label>
                                    <input type="text"
                                        class="form-control shadow-sm @error('facebook') is-invalid @enderror"
                                        name="facebook" id="facebook" value="{{ old('facebook') }}">
                                    @error('facebook')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="linkedln" class="form-label">LinkedIn</label>
                                    <input type="text"
                                        class="form-control shadow-sm @error('linkedln') is-invalid @enderror"
                                        name="linkedln" id="linkedln" value="{{ old('linkedln') }}">
                                    @error('linkedln')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="instagram" class="form-label">Instagram</label>
                                    <input type="text"
                                        class="form-control shadow-sm @error('instagram') is-invalid @enderror"
                                        name="instagram" id="instagram" value="{{ old('instagram') }}">
                                    @error('instagram')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="twitter" class="form-label">Website</label>
                                    <input type="text"
                                        class="form-control shadow-sm @error('website') is-invalid @enderror"
                                        name="website" id="website" value="{{ old('website') }}">
                                    @error('website')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-primary btn-lg rounded-pill shadow-sm">
                                    <i class="bi bi-plus-circle me-1"></i> Create Company
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection
