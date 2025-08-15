@extends('layouts.app')

@section('content')
    <style>
        /* Side modal base styles */
        .side-modal {
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

        /* Show modal */
        .side-modal.show {
            right: 0;
        }

        .side-modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem;
            border-bottom: 1px solid #dee2e6;
        }

        .side-modal-body {
            padding: 1rem;
        }

        .form-check-input {
            position: absolute;
            opacity: 0;
        }

        .hover-zoom {
            display: inline-block;
            transition: transform 0.3s ease;
            cursor: pointer;
        }

        .hover-zoom:hover {
            transform: scale(1.3);
        }

        /* Validation error styles */
        .is-invalid {
            border-color: #dc3545 !important;
        }

        .invalid-feedback {
            display: none;
            width: 100%;
            margin-top: 0.25rem;
            font-size: 0.875em;
            color: #dc3545;
        }

        .is-invalid ~ .invalid-feedback {
            display: block;
        }
    </style>
    <div class="container py-5">
        <div class="row">
            <div class="col-md-12 mb-md-4 mb-3">
                <div class="card card-border mb-0 h-100">
                    <div class="card-header card-header-action">
                        <h6>Contacts
                            <span class="badge badge-sm badge-light ms-1">{{ $contacts->count() }}</span>
                        </h6>
                        <div class="card-action-wrap">
                            <button class="btn btn-sm btn-outline-light"><span><span class="icon"><span
                                            class="feather-icon"><i data-feather="upload"></i></span></span><span
                                        class="btn-text">import</span></span></button>
                            <button id="bulkDeleteBtn" type="button" class="btn btn-sm btn-danger ms-2"
                                style="display: none;"><span><span class="icon"><span class="feather-icon"><i
                                                data-feather="trash-2"></i></span></span><span class="btn-text">Delete
                                        Selected</span></span></button>
                            <button id="openSideModal" type="button" class="btn btn-sm btn-primary ms-3"><span><span
                                        class="icon"><span class="feather-icon"><i
                                                data-feather="plus"></i></span></span><span class="btn-text">Add
                                        new</span></span></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="contact-list-view">
                            <table id="datable_1" class="table nowrap w-100 mb-5">
                                <thead>
                                    <tr>
                                        <th><span class="form-check fs-6 mb-0">
                                                <input type="checkbox" class="form-check-input check-select-all"
                                                    id="customCheck1">
                                                <label class="form-check-label" for="customCheck1"></label>
                                            </span></th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Companies</th>
                                        <th>Title</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Facebook</th>
                                        <th>Twitter</th>
                                        <th>LinkedIn</th>
                                        <th>Xing</th>
                                        <th>Stage</th>
                                        <th>Locality</th>
                                        <th>City</th>
                                        <th>State</th>
                                        <th>Country</th>
                                        <th>Postal Code</th>
                                        <th>Full Address</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($contacts as $contact)
                                        <tr data-contact-id="{{ $contact->id }}">
                                            <td>
                                                <input type="checkbox" class="form-check-input contact-checkbox"
                                                    value="{{ $contact->id }}" name="contact_ids[]"
                                                    id="contact_ids_{{ $contact->id }}">
                                            </td>
                                            <td>{{ $contact->first_name }}</td>
                                            <td>{{ $contact->last_name }}</td>
                                            <td>
                                                @if ($contact->companies && $contact->companies->count())
                                                    @foreach ($contact->companies as $company)
                                                        {{ $company->name }}@if (!$loop->last)
                                                            ,
                                                        @endif
                                                    @endforeach
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td>{{ $contact->title ?? 'N/A' }}</td>
                                            <td>{{ $contact->email ?? 'N/A' }}</td>
                                            <td>{{ $contact->phone ?? 'N/A' }}</td>
                                            <td>
                                                @if ($contact->facebook_profile_url)
                                                    <a href="{{ $contact->facebook_profile_url }}" target="_blank"
                                                        class="hover-zoom">FB</a>
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td>
                                                @if ($contact->twitter_profile_url)
                                                    <a href="{{ $contact->twitter_profile_url }}" target="_blank"
                                                        class="hover-zoom">TW</a>
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td>
                                                @if ($contact->linkedin_profile_url)
                                                    <a href="{{ $contact->linkedin_profile_url }}" target="_blank"
                                                        class="hover-zoom">IN</a>
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td>
                                                @if ($contact->xing_profile_url)
                                                    <a href="{{ $contact->xing_profile_url }}" target="_blank"
                                                        class="hover-zoom">Xing</a>
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td>{{ $contact->stage ?? 'N/A' }}</td>
                                            <td>{{ $contact->locality ?? 'N/A' }}</td>
                                            <td>{{ $contact->city ?? 'N/A' }}</td>
                                            <td>{{ $contact->state ?? 'N/A' }}</td>
                                            <td>{{ $contact->country ?? 'N/A' }}</td>
                                            <td>{{ $contact->postal_code ?? 'N/A' }}</td>
                                            <td>{{ $contact->full_address ?? 'N/A' }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <a class="btn btn-icon btn-flush-dark btn-rounded flush-soft-hover"
                                                        data-bs-toggle="tooltip" data-placement="top" title="Edit"
                                                        href="javascript:void(0);"
                                                        onclick="editContact({{ $contact->id }})">
                                                        <span class="icon"><span class="feather-icon"><i
                                                                    data-feather="edit-2"></i></span></span>
                                                    </a>
                                                    <a class="btn btn-icon btn-flush-dark btn-rounded flush-soft-hover del-button"
                                                        data-bs-toggle="tooltip" data-placement="top" title="Delete"
                                                        href="javascript:void(0);"
                                                        onclick="deleteContact({{ $contact->id }}, '{{ $contact->first_name }} {{ $contact->last_name }}')">
                                                        <span class="icon"><span class="feather-icon"><i
                                                                    data-feather="trash"></i></span></span>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@include('components.contact_form', ['contact' => $contact, 'companies' => $companies])

@endsection
