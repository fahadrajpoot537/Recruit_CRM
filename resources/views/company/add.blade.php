@extends('layouts.app')

@section('content')

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-12">

            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            <div class="card border-0 shadow-lg rounded-4">
                <div class="card-header bg-gradient text-white"
                    style="background: linear-gradient(45deg, #007bff, #6610f2);">
                    <h4 class="mb-0">
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
                                <input type="text" class="form-control shadow-sm" name="name" id="name" required>
                            </div>

                            <div class="col-md-6">
                                <label for="contact" class="form-label">Contact</label>
                                <input type="text" class="form-control shadow-sm" name="contact" id="contact">
                            </div>

                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control shadow-sm" name="email" id="email">
                            </div>

                            <div class="col-md-6">
                                <label for="postal_code" class="form-label">Postal Code</label>
                                <input type="text" class="form-control shadow-sm" name="postal_code" id="postal_code">
                            </div>

                            <div class="col-12">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" class="form-control shadow-sm" name="address" id="address">
                            </div>

                            <div class="col-md-4">
                                <label for="city" class="form-label">City</label>
                                <input type="text" class="form-control shadow-sm" name="city" id="city">
                            </div>

                            <div class="col-md-4">
                                <label for="state" class="form-label">State</label>
                                <input type="text" class="form-control shadow-sm" name="state" id="state">
                            </div>

                            <div class="col-md-4">
                                <label for="country" class="form-label">Country</label>
                                <input type="text" class="form-control shadow-sm" name="country" id="country">
                            </div>
                            <div class="col-md-6">
                                <label for="contractpname" class="form-label">Contract Person Name</label>
                                <input type="text" class="form-control shadow-sm" name="contractpname"
                                    id="contractpname">
                            </div>

                            <div class="col-md-6">
                                <label for="company_description" class="form-label">Company Description</label>
                                <input type="text" class="form-control shadow-sm" name="company_description"
                                    id="company_description">
                            </div>

                            <div class="col-md-6">
                                <label for="head_office" class="form-label">Head Office</label>
                                <input type="text" class="form-control shadow-sm" name="head_office" id="head_office">
                            </div>

                            <div class="col-md-6">
                                <label for="no_of_employes" class="form-label">Number of Employees</label>
                                <input type="text" class="form-control shadow-sm" name="no_of_employes"
                                    id="no_of_employes">
                            </div>

                            <div class="col-md-6">
                                <label for="no_of_offices" class="form-label">Number of Offices</label>
                                <input type="text" class="form-control shadow-sm" name="no_of_offices"
                                    id="no_of_offices">
                            </div>

                            <div class="col-md-6">
                                <label for="industry" class="form-label">Industry</label>
                                <select name="industry" class="form-control">
                                    <option value="">-- Select Industry --</option>
                                    <option value="Information Technology">Information Technology</option>
                                    <option value="Healthcare">Healthcare</option>
                                    <option value="Finance">Finance</option>
                                    <option value="Education">Education</option>
                                    <option value="Retail">Retail</option>
                                    <option value="Manufacturing">Manufacturing</option>
                                    <option value="Construction">Construction</option>
                                    <option value="Real Estate">Real Estate</option>
                                    <option value="Telecommunications">Telecommunications</option>
                                    <option value="Transportation & Logistics">Transportation & Logistics</option>
                                    <option value="Hospitality">Hospitality</option>
                                    <option value="Legal">Legal</option>
                                    <option value="Government">Government</option>
                                    <option value="Marketing & Advertising">Marketing & Advertising</option>
                                    <option value="Media & Entertainment">Media & Entertainment</option>
                                    <option value="Oil & Gas">Oil & Gas</option>
                                    <option value="Energy & Utilities">Energy & Utilities</option>
                                    <option value="Agriculture">Agriculture</option>
                                    <option value="Non-Profit">Non-Profit</option>
                                    <option value="Aerospace & Defense">Aerospace & Defense</option>
                                    <option value="Automotive">Automotive</option>
                                    <option value="Food & Beverage">Food & Beverage</option>
                                    <option value="Pharmaceuticals">Pharmaceuticals</option>
                                    <option value="Banking">Banking</option>
                                    <option value="Insurance">Insurance</option>
                                    <option value="E-commerce">E-commerce</option>
                                    <option value="Environmental Services">Environmental Services</option>
                                    <option value="Human Resources">Human Resources</option>
                                    <option value="Fashion & Apparel">Fashion & Apparel</option>
                                    <option value="Biotechnology">Biotechnology</option>
                                    <option value="Consulting">Consulting</option>
                                    <option value="Security & Surveillance">Security & Surveillance</option>
                                    <option value="Marine">Marine</option>
                                    <option value="Printing & Publishing">Printing & Publishing</option>
                                    <option value="Mining & Metals">Mining & Metals</option>
                                    <option value="Events & Conferences">Events & Conferences</option>
                                    <option value="Customer Service">Customer Service</option>
                                    <option value="Sports & Recreation">Sports & Recreation</option>
                                </select>

                            </div>

                            <div class="col-md-6">
                                <label for="facebook" class="form-label">Facebook</label>
                                <input type="text" class="form-control shadow-sm" name="facebook" id="facebook">
                            </div>

                            <div class="col-md-6">
                                <label for="linkedln" class="form-label">LinkedIn</label>
                                <input type="text" class="form-control shadow-sm" name="linkedln" id="linkedln">
                            </div>

                            <div class="col-md-6">
                                <label for="instagram" class="form-label">Instagram</label>
                                <input type="text" class="form-control shadow-sm" name="instagram" id="instagram">
                            </div>

                            <div class="col-md-6">
                                <label for="twitter" class="form-label">Twitter</label>
                                <input type="text" class="form-control shadow-sm" name="twitter" id="twitter">
                            </div>
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-info btn-lg rounded-pill shadow-sm">
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