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
    </style>
    <div class="container py-5">
        <div class="row">
            <div class="col-md-12 mb-md-4 mb-3">
                <div class="card card-border mb-0 h-100">
                    <div class="card-header card-header-action">
                        <h6>Jobs
                            <span class="badge badge-sm badge-light ms-1">{{ $jobs->count() }}</span>
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
                                        <th>Name</th>
                                        <th>Status</th>
                                        <th>Company</th>
                                        <th>Note For Candidates</th>
                                        <th>City</th>
                                        <th>Job Description</th>
                                        <th>Min Experience</th>
                                        <th>Max Experience</th>
                                        <th>Min Salary</th>
                                        <th>Max Salary</th>
                                        <th>Openings</th>
                                        <th>Collaborator</th>
                                        <th>Contact Name</th>
                                        <th>Contact Email</th>
                                        <th>Contact Number</th>
                                        <th>Job Category</th>
                                        <th>State</th>
                                        <th>Country</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Sample row - you would populate this with real data -->
                                    @foreach ($jobs as $job)
                                        <tr data-job-id="{{ $job->id }}">
                                            <td>
                                                <input type="checkbox" class="form-check-input job-checkbox"
                                                    value="{{ $job->id }}" name="job_ids[]"
                                                    id="job_ids_{{ $job->id }}">
                                            </td>
                                            <td>{{ $job->job_title }}</td>
                                            <td><span class="badge badge-soft-success">{{ $job->status }}</span></td>
                                            <td>
                                                {{ $job->company->name }}
                                            </td>
                                            <td><button onclick="NoteForCandidate({{ $job->id }})"
                                                    class="btn btn-icon btn-flush-dark btn-rounded flush-soft-hover"><span
                                                        class="feather-icon"><i data-feather="eye"></i></span></button></td>
                                            <td>{{ $job->city }}</td>
                                            <td><button onclick="JobDescription({{ $job->id }})"
                                                    class="btn btn-icon btn-flush-dark btn-rounded flush-soft-hover"><span
                                                        class="feather-icon"><i data-feather="eye"></i></span></button></td>
                                            <td>{{ $job->min_experience }}</td>
                                            <td>{{ $job->max_experience }}</td>
                                            <td>{{ $job->currency }}{{ $job->min_salary }}</td>
                                            <td>{{ $job->currency }}{{ $job->max_salary }}</td>
                                            <td>{{ $job->no_of_openings }}</td>
                                            <td>
                                                @if ($job->collaborator_id)
                                                    @php
                                                        $collaborator = \App\Models\User::find($job->collaborator_id);
                                                    @endphp
                                                    {{ $collaborator ? $collaborator->name : 'N/A' }}
                                                @else
                                                    N/A
                                                @endif
                                            </td>

                                            <td>{{ $job->primaryContact?->first_name . ' ' . $job->primaryContact?->last_name }}
                                            </td>
                                            <td>{{ $job->primaryContact?->email }}</td>
                                            <td>{{ $job->primaryContact?->phone }}</td>
                                            <td>{{ $job->job_category ? $job->job_category : 'N/A' }}</td>
                                            <td>{{ $job->state }}</td>
                                            <td>{{ $job->country }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <a class="btn btn-icon btn-flush-dark btn-rounded flush-soft-hover"
                                                        data-bs-toggle="tooltip" data-placement="top" title="Edit"
                                                        href="javascript:void(0);" onclick="editJob({{ $job->id }})">
                                                        <span class="icon"><span class="feather-icon"><i
                                                                    data-feather="edit-2"></i></span></span>
                                                    </a>
                                                    <a class="btn btn-icon btn-flush-dark btn-rounded flush-soft-hover del-button"
                                                        data-bs-toggle="tooltip" data-placement="top" title="Delete"
                                                        href="javascript:void(0);"
                                                        onclick="deleteJob({{ $job->id }}, '{{ $job->job_title }}')">
                                                        <span class="icon"><span class="feather-icon"><i
                                                                    data-feather="trash"></i></span></span>
                                                    </a>
                                                    <a class="btn btn-icon btn-flush-dark btn-rounded "
                                                        data-bs-toggle="tooltip" data-placement="top" title="Details"
                                                        href="{{ route('jobs.details', $job->id) }}">
                                                        <span class="icon"><span class="feather-icon"><i
                                                                    data-feather="eye"></i></span></span>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <!-- Add more rows as needed -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('jobs.modal', ['job' => $job])
@endsection
