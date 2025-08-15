@extends('layouts.app')

@section('content')
    <style>
        /* Side Modal Base Styles */
        .side-modal {
            border-radius: 5px;
            position: fixed;
            top: 0;
            right: -50%;
            width: 50%;
            height: 100%;
            background: #fff;
            box-shadow: -4px 0 10px rgba(0, 0, 0, 0.3);
            overflow-y: auto;
            transition: right 0.3s ease-in-out;
            z-index: 1050;
        }

        /* Show Modal */
        .side-modal.show {
            right: 0;
        }

        /* Side Modal Header */
        .side-modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem;
            background-color: #3b8fcd;
            border-bottom: 1px solid #dee2e6;

        }

        /* Side Modal Body */
        .side-modal-body {
            padding: 1rem;
        }
    </style>

    <div class="contactapp-wrap">

        <div class="contactapp-content">
            <div class="contactapp-detail-wrap">
                <header class="contact-header">
                    <div class="d-flex align-items-center">
                        <div class="dropdown">
                            <a class="contactapp-title link-dark" data-bs-toggle="dropdown" href="#" role="button"
                                aria-haspopup="true" aria-expanded="false">
                                <h1>Candidates</h1>
                            </a>

                        </div>

                    </div>
                    <div class="contact-options-wrap">
                        <button class="btn btn-primary w-100" id="openSideModal">Add New Candidate</button>
                    </div>

                </header>
                <div class="contact-body">
                    <div data-simplebar class="nicescroll-bar">

                        <div class="contact-list-view">
                            <table id="datable_1" class="table nowrap w-100 mb-5">
                                <thead>
                                    <tr>
                                        <th>
                                            <span class="form-check mb-0">
                                                <input type="checkbox" class="form-check-input check-select-all"
                                                    id="customCheck1">
                                                <label class="form-check-label" for="customCheck1"></label>
                                            </span>
                                        </th>
                                        <th>Name</th>
                                        <th>Email Address</th>
                                        <th>Phone</th>
                                        <th>Tags</th>
                                        <th>Labels</th>
                                        <th>Date Created</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <span class="contact-star marked"></span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="media align-items-center">
                                                <div class="media-head me-2">
                                                    <div class="avatar avatar-xs avatar-rounded">
                                                        <img src="dist/img/avatar1.jpg" alt="user" class="avatar-img">
                                                    </div>
                                                </div>
                                                <div class="media-body">
                                                    <span class="d-block text-high-em">Morgan Freeman</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-truncate">morgan@jampack.com</td>
                                        <td>+145 52 5689</td>
                                        <td><span class="badge badge-soft-violet my-1  me-2">Promotion</span><span
                                                class="badge badge-soft-danger  my-1  me-2">Collaborator</span></td>
                                        <td>Design</td>
                                        <td>13 Jan, 2020</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="d-flex">

                                                    <a class="btn btn-icon btn-flush-dark btn-rounded flush-soft-hover"
                                                        data-bs-toggle="tooltip" data-placement="top" title=""
                                                        data-bs-original-title="Edit" href=""
                                                        id="openbackSideModal"><span class="icon"><span
                                                                class="feather-icon"><i
                                                                    data-feather="edit"></i></span></span></a>
                                                    <a class="btn btn-icon btn-flush-dark btn-rounded flush-soft-hover del-button"
                                                        data-bs-toggle="tooltip" data-placement="top" title=""
                                                        data-bs-original-title="Delete" href="#"><span
                                                            class="icon"><span class="feather-icon"><i
                                                                    data-feather="trash"></i></span></span></a>
                                                </div>
                                                <div class="dropdown">
                                                    <button
                                                        class="btn btn-icon btn-flush-dark btn-rounded flush-soft-hover dropdown-toggle no-caret"
                                                        aria-expanded="false" data-bs-toggle="dropdown"><span
                                                            class="icon"><span class="feather-icon"><i
                                                                    data-feather="more-vertical"></i></span></span></button>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <a class="dropdown-item" href="edit-contact.html"><span
                                                                class="feather-icon dropdown-icon"><i
                                                                    data-feather="edit"></i></span><span>Edit
                                                                Contact</span></a>
                                                        <a class="dropdown-item" href="#"><span
                                                                class="feather-icon dropdown-icon"><i
                                                                    data-feather="trash-2"></i></span><span>Delete</span></a>
                                                        <a class="dropdown-item" href="#"><span
                                                                class="feather-icon dropdown-icon"><i
                                                                    data-feather="copy"></i></span><span>Duplicate</span></a>
                                                        <div class="dropdown-divider"></div>
                                                        <h6 class="dropdown-header dropdown-header-bold">Change Labels</h6>
                                                        <a class="dropdown-item" href="#">Design</a>
                                                        <a class="dropdown-item" href="#">Developer</a>
                                                        <a class="dropdown-item" href="#">Inventory</a>
                                                        <a class="dropdown-item" href="#">Human Resource</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Add Modal --}}
            <div id="sideModal" class="side-modal">
                <div class="side-modal-content">
                    <div class="side-modal-header">
                        <h5>Add Cadidate</h5>
                        <button type="button" class="btn-close" id="closeSideModal"></button>
                    </div>
                    <div class="side-modal-body">
                        <form>
                            <!-- Personal Information -->
                            <h6 class="border-bottom pb-1 mb-3">Personal Information</h6>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">First Name</label>
                                    <input type="text" class="form-control" value="Tony">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Last Name</label>
                                    <input type="text" class="form-control" value="Jorden">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" value="jorder@abc.com">
                                    <small class="text-muted">(Used To Check/Merge Duplicates)</small>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Phone</label>
                                    <input type="text" class="form-control" value="+1-202-555-0194">
                                    <small class="text-muted">(Used To Check/Merge Duplicates)</small>
                                </div>
                            </div>

                            <!-- Location -->
                            <h6 class="border-bottom pb-1 mb-3">Location</h6>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Locality</label>
                                    <input type="text" class="form-control" placeholder="Search or Enter Locality">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">City</label>
                                    <input type="text" class="form-control" placeholder="Search or Enter City">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">State</label>
                                    <input type="text" class="form-control" placeholder="Search or Enter State">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Country</label>
                                    <input type="text" class="form-control" placeholder="Search or Enter Country">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Postal Code</label>
                                    <input type="text" class="form-control" placeholder="Search or Enter Postal Code">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Full Address</label>
                                    <input type="text" class="form-control" placeholder="Street Address">
                                </div>
                            </div>

                            <!-- Work Information -->
                            <h6 class="border-bottom pb-1 mb-3">Employment Information</h6>
                            <div class="mb-3">
                                <label class="form-label">Current Organization</label>
                                <input type="text" class="form-control"
                                    placeholder="Search or type in organization name">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Title</label>
                                <input type="text" class="form-control" value="Java Developer">
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Total Experience (Years)</label>
                                    <input type="number" class="form-control">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Relevant Experience (Years)</label>
                                    <input type="number" class="form-control">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Salary Type</label>
                                    <input type="text" class="form-control" value="Annual Salary">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Currency Type</label>
                                    <input type="text" class="form-control" value="Rupees (₨ - Pakistan)">
                                </div>
                            </div>

                            <!-- Social Profiles -->
                            <h6 class="border-bottom pb-1 mb-3">Social Profiles</h6>
                            <div class="mb-3">
                                <label class="form-label">Facebook Profile URL</label>
                                <input type="url" class="form-control" value="https://www.facebook.com/ryancooper">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Twitter Profile URL</label>
                                <input type="url" class="form-control" value="https://www.twitter.com/ryancooper">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">LinkedIn Profile URL</label>
                                <input type="url" class="form-control" value="https://www.linkedin.com/ryancooper">
                                <small class="text-muted">(Used To Check/Merge Duplicates)</small>
                            </div>

                            <!-- Submit -->
                            <button type="submit" class="btn btn-success mt-3">Save Contact</button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Edit Modal --}}

            <div id="backsideModal" class="side-modal">
                <div class="side-modal-content">
                    <div class="side-modal-header">
                        <h5>Edit Cadidate</h5>
                        <button type="button" class="btn-close" id="closebackSideModal"></button>
                    </div>
                    <div class="side-modal-body">
                        <form>
                            <!-- Personal Information -->
                            <h6 class="border-bottom pb-1 mb-3">Personal Information</h6>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">First Name</label>
                                    <input type="text" class="form-control" value="Tony">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Last Name</label>
                                    <input type="text" class="form-control" value="Jorden">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" value="jorder@abc.com">
                                    <small class="text-muted">(Used To Check/Merge Duplicates)</small>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Phone</label>
                                    <input type="text" class="form-control" value="+1-202-555-0194">
                                    <small class="text-muted">(Used To Check/Merge Duplicates)</small>
                                </div>
                            </div>

                            <!-- Location -->
                            <h6 class="border-bottom pb-1 mb-3">Location</h6>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Locality</label>
                                    <input type="text" class="form-control" placeholder="Search or Enter Locality">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">City</label>
                                    <input type="text" class="form-control" placeholder="Search or Enter City">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">State</label>
                                    <input type="text" class="form-control" placeholder="Search or Enter State">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Country</label>
                                    <input type="text" class="form-control" placeholder="Search or Enter Country">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Postal Code</label>
                                    <input type="text" class="form-control" placeholder="Search or Enter Postal Code">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Full Address</label>
                                    <input type="text" class="form-control" placeholder="Street Address">
                                </div>
                            </div>

                            <!-- Work Information -->
                            <h6 class="border-bottom pb-1 mb-3">Employment Information</h6>
                            <div class="mb-3">
                                <label class="form-label">Current Organization</label>
                                <input type="text" class="form-control"
                                    placeholder="Search or type in organization name">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Title</label>
                                <input type="text" class="form-control" value="Java Developer">
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Total Experience (Years)</label>
                                    <input type="number" class="form-control">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Relevant Experience (Years)</label>
                                    <input type="number" class="form-control">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Salary Type</label>
                                    <input type="text" class="form-control" value="Annual Salary">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Currency Type</label>
                                    <input type="text" class="form-control" value="Rupees (₨ - Pakistan)">
                                </div>
                            </div>

                            <!-- Social Profiles -->
                            <h6 class="border-bottom pb-1 mb-3">Social Profiles</h6>
                            <div class="mb-3">
                                <label class="form-label">Facebook Profile URL</label>
                                <input type="url" class="form-control" value="https://www.facebook.com/ryancooper">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Twitter Profile URL</label>
                                <input type="url" class="form-control" value="https://www.twitter.com/ryancooper">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">LinkedIn Profile URL</label>
                                <input type="url" class="form-control" value="https://www.linkedin.com/ryancooper">
                                <small class="text-muted">(Used To Check/Merge Duplicates)</small>
                            </div>

                            <!-- Submit -->
                            <button type="submit" class="btn btn-success mt-3">Save Contact</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Add Modal Script --}}
    <script>
        // Open side modal
        document.getElementById('openSideModal').addEventListener('click', function() {
            document.getElementById('sideModal').classList.add('show');
        });

        // Close side modal
        document.getElementById('closeSideModal').addEventListener('click', function() {
            document.getElementById('sideModal').classList.remove('show');
        });

        // Close modal on outside click
        window.addEventListener('click', function(e) {
            const modal = document.getElementById('sideModal');
            if (e.target === modal) {
                modal.classList.remove('show');
            }
        });
    </script>
    {{-- Edit Modal Script --}}
    <script>
        // Open side modal
        document.getElementById('openbackSideModal').addEventListener('click', function() {
            document.getElementById('backsideModal').classList.add('show');
        });

        // Close side modal
        document.getElementById('closebackSideModal').addEventListener('click', function() {
            document.getElementById('backsideModal').classList.remove('show');
        });

        // Close modal on outside click
        window.addEventListener('click', function(e) {
            const modal = document.getElementById('backsideModal');
            if (e.target === modal) {
                modal.classList.remove('show');
            }
        });
    </script>
@endsection
