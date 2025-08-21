@extends('layouts.app')

@section('content')
    <style>
        /* Side modal base styles */
        .side-modal {
            position: fixed;
            top: 0;
            right: -50%;
            width: 35%;
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
        <div class="card shadow-sm rounded-3">
            <!-- Header Section -->
            <div class="card-body border-bottom d-flex justify-content-between align-items-center flex-wrap">
                <div class="d-flex justify-content-between align-items-center flex-wrap w-100">
                    <!-- Left Side -->
                    <div class="d-flex align-items-center">
                        <!-- Job Icon -->
                        <span class="avatar avatar-md me-3 avatar-icon avatar-soft-warning avatar-rounded">

                            <span class="initial-wrap avatar-img">
                                <i class="bi bi-briefcase"></i>
                            </span>

                        </span>
                        <div>
                            <!-- Job Title -->
                            <h5 class="fw-bold mb-1">{{ $job->job_title }}</h5>

                            <!-- Status Dropdown -->
                            <div class="dropdown d-inline-block me-2">
                                <span class="badge bg-success px-3 py-2 dropdown-toggle" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    Open
                                </span>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">Close</a></li>
                                    <li><a class="dropdown-item" href="#">Hold</a></li>
                                </ul>
                            </div>

                            <!-- Company & Location -->
                            <div class="mt-2 text-muted small">
                                <i class="bi bi-building"></i> {{ $job->company->name }} &nbsp; | &nbsp;
                                <i class="bi bi-geo-alt"></i> {{ $job->locality }}
                            </div>
                        </div>
                    </div>


                    <!-- Right Side (Action Icons) -->
                    <div class="d-flex align-items-center mt-3 mt-md-0">
                        <button class="btn btn-icon btn-light rounded-circle me-2">
                            <i class="bi bi-stars"></i>
                        </button>
                        <button class="btn btn-icon btn-light rounded-circle me-2">
                            <i class="bi bi-fire"></i>
                        </button>
                        <button class="btn btn-icon btn-light rounded-circle me-2" onclick="editJob({{ $job->id }})">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-icon btn-light rounded-circle">
                            <i class="bi bi-three-dots"></i>
                        </button>
                    </div>
                </div>



            </div>
            <div class="card-body border-top d-flex justify-content-between align-items-center flex-wrap">
                <!-- Left Side (Job Contacts) -->
                <div class="d-flex align-items-center">
                    <span class="fw-bold text-uppercase small me-3">Job Contact(s)</span>

                    <!-- Contact Avatar(s) -->

                    <div class="avatar avatar-icon avatar-soft-warning avatar-sm avatar-rounded">
                        <span class="initial-wrap">
                            <i class="bi bi-people"></i>
                        </span>
                    </div>
                </div>

                <!-- Right Side (Posted By & Date) -->
                <div class="d-flex align-items-center mt-2 mt-md-0">
                    <small class="text-muted d-flex align-items-center me-3">
                        <i class="bi bi-person-circle me-1"></i>
                        {{ $job->primaryContact?->first_name . ' ' . $job->primaryContact?->last_name }}
                        <i class="bi bi-pencil ms-1 me-1"> </i>
                        Posted by: {{ $job->createdBy?->name }}
                    </small>


                    <small class="text-muted d-flex align-items-center">
                        <i class="bi bi-clock me-1"></i>
                        {{ $job->created_at->format('M d, Y, h:i A') }}

                    </small>
                </div>
            </div>


            <!-- Job Details Section -->
            <div class="card-body">
                <div class="row g-4">
                    <!-- Left Column -->
                    <div class="col-md-6">
                        <ul class="list-unstyled">
                            <li><strong>Note For Candidates:</strong>
                                @if ($job->note_for_candidates != null)
                                    <a href="JavaScript:void(0);" onclick="NoteForCandidate({{ $job->id }})">📄</a>
                                @else
                                    N/A
                                @endif
                            </li>
                            <li><strong>Job Type:</strong> {{ $job->job_type }}</li>
                            <li><strong>Maximum Experience:</strong> {{ $job->max_experience }} Years</li>
                            <li><strong>Job Location Type:</strong> {{ $job->location_type }}</li>
                            <li><strong>Collaborator:</strong>
                                @if (!$job->collaborators->isEmpty())
                                    @foreach ($job->collaborators as $collaborator)
                                        {{ $collaborator->user->name }}@if (!$loop->last)
                                            ,
                                        @endif
                                    @endforeach
                                @else
                                    N/A
                                @endif
                            </li>

                            <li><strong>Country:</strong>{{ $job->country }}</li>
                            <li><strong>Locality:</strong> {{ $job->locality }}</li>
                            <li><strong>Bill Rate:</strong> Rs 0</li>
                        </ul>
                    </div>

                    <!-- Right Column -->
                    <div class="col-md-6">
                        <ul class="list-unstyled">
                            <li><strong>Job Description:</strong>
                                @if ($job->job_description != null)
                                    <a href="JavaScript:void(0);" onclick="JobDescription({{ $job->id }})">📄</a>
                                @else
                                    N/A
                                @endif
                            </li>
                            <li><strong>Job Category:</strong> {{ $job->job_category }}</li>
                            <li><strong>Educational Qualification:</strong> {{ $job->educational_qualification }}</li>
                            <li><strong>Educational Specialization:</strong> {{ $job->educational_specialization }}</li>
                            <li><strong>State:</strong> {{ $job->state }}</li>
                            <li><strong>Full Address:</strong> {{ $job->full_address }}</li>
                            <li><strong>Minimum Experience:</strong> {{ $job->min_experience }} Years</li>
                            <li><strong>Salary Range:</strong> {{ $job->currency }}{{ $job->min_salary }} –
                                {{ $job->currency }}{{ $job->max_salary }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="contact-more-info">
                    <ul class="nav nav-tabs nav-line nav-icon nav-light" role="tablist">

                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" data-bs-toggle="tab" href="#job_notes" role="tab"
                                aria-controls="job_notes" aria-selected="false" tabindex="-1">
                                <span class="nav-icon-wrap">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-digit"
                                        width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                        stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M14 3v4a1 1 0 0 0 1 1h4"></path>
                                        <rect x="9" y="12" width="3" height="5" rx="1"></rect>
                                        <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z">
                                        </path>
                                        <path d="M15 12v5"></path>
                                    </svg>
                                </span>
                                <span class="nav-link-text">Notes</span>
                            </a>


                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link " data-bs-toggle="tab" href="#job_tasks" aria-controls="job_tasks"
                                 role="tab">
                                <span class="nav-icon-wrap">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-list"
                                        width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <circle cx="9" cy="6" r="6"></circle>
                                        <line x1="9" y1="12" x2="9" y2="18"></line>
                                        <line x1="15" y1="12" x2="15" y2="18"></line>
                                        <line x1="9" y1="6" x2="15" y2="6"></line>
                                    </svg>
                                </span>
                                <span class="nav-link-text">Tasks</span>
                            </a>
                        </li>

                    </ul>
                    <div id="notesContainer">
                        @include('jobs.notes_block', ['job' => $job])

                    </div>
                    <div class="tab-content mt-7">
                        <div class="tab-pane fade" id="job_tasks" role="tabpanel">
                            <h5>Tasks</h5>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
     @include('jobs.modal', ['job' => $job])
    <div id="sideModal_note" class="side-modal">
        <div class="side-modal-content">
            <div class="side-modal-header">
                <h5>Note</h5>
                <button type="button" class="btn-close" id="closeSideModalNote"></button>
            </div>
            <div class="side-modal-body">
                <form id="noteForm">
                    <input type="hidden" name="job_id" value="{{ $job->id }}">
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <div class="form-label-group">
                                <label>Write a Note</label>
                                <small class="text-muted">1200</small>
                            </div>

                            <textarea name="note" class="form-control" placeholder="Write an internal note"></textarea>

                            {{-- <textarea class="form-control" rows="8" placeholder="Write an internal note"></textarea> --}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Type</label>
                            <select class="form-select" name="type">
                                <option>--select--</option>
                                <option value="Call">Call</option>
                                <option value="To Do">To Do</option>

                            </select>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Collaborator</label>
                            <select id="input_tags" class="form-control select2 select2-multiple" multiple="multiple"
                                data-placeholder="Choose" multiple="multiple" name="collaborator[]">
                                <!-- Options would be populated dynamically -->
                                <?php $users = \App\Models\User::all(); ?>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <button type="submit" class=" btn btn-primary mt-2">Save</button>
                    {{-- <button  type="button"  id="closeSideModalNote" class=" btn btn-secondary mt-2">Close</button> --}}
                </form>
            </div>
        </div>
    </div>
    <script>
        async function showNote(jobId) {
            try { // Open modal
                document.getElementById('sideModal_note').classList.add(
                    'show'); // Save jobId to form (hidden input for reference)
                let hidden = document.querySelector("#noteForm input[name='job_id']");
                if (!hidden) {
                    hidden = document.createElement("input");
                    hidden.type = "hidden";
                    hidden.name = "job_id";
                    hidden.value = jobId;
                    document.getElementById("noteForm").appendChild(hidden);
                } else {
                    hidden.value = jobId;
                }
            } catch (error) {
                console.error('Error while fetching note:', error);
                Swal.fire('Error', 'Failed to load job details', 'error');
            }
        }
        // Edit note functionality
        async function editNote(noteId) {
            try {
                // Show loading state
                const swalInstance = Swal.fire({
                    title: 'Loading...',
                    allowOutsideClick: false,
                    didOpen: () => Swal.showLoading()
                });

                const response = await fetch(`/jobs/notes/${noteId}/edit`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);

                const data = await response.json();
                if (!data) throw new Error("Note data not found");

                // Populate form fields
                const form = document.getElementById('noteForm');
                const fieldsToPopulate = [
                    'note', 'type', 'collaborator'
                ];

                fieldsToPopulate.forEach(key => {
                    const input = form.querySelector(`[name="${key}"]`);
                    if (input) {
                        input.value = data.note[key] || '';
                    }
                });


                // Handle collaborators (multi-select)
                // Handle collaborators (multi-select)
                if (data.collaborators && Array.isArray(data.collaborators)) {
                    const collaboratorSelect = form.querySelector('[name="collaborator[]"]');
                    if (collaboratorSelect) {
                        // Clear previous selections
                        [...collaboratorSelect.options].forEach(opt => opt.selected = false);

                        data.collaborators.forEach(collabId => {
                            const option = collaboratorSelect.querySelector(`option[value="${collabId}"]`);
                            if (option) option.selected = true;
                        });

                        // Re-initialize Select2 if active
                        if (typeof $ !== 'undefined' && $.fn.select2) {
                            $(collaboratorSelect).trigger('change');
                        }
                    }
                }

                // Set edit mode
                form.setAttribute('data-edit-id', noteId);
                document.querySelector('.side-modal-header h5').textContent = 'Edit Note';

                // Open modal first
                document.getElementById('sideModal_note').classList.add('show');
                await swalInstance.close();

            } catch (error) {
                console.error('Edit error:', error);
                Swal.fire('Error', 'Failed to load job details', 'error');
            }
        }
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const form = document.getElementById("noteForm");
            const modal = document.getElementById("sideModal_note");
            const closeBtn = document.getElementById("closeSideModalNote");

            // Close modal
            closeBtn.addEventListener("click", function() {
                modal.classList.remove("show");
            });

            // Handle form submission
            form.addEventListener("submit", async function(e) {
                e.preventDefault();

                const submitBtn = form.querySelector("button[type='submit']");
                const editId = form.getAttribute('data-edit-id');
                const originalText = submitBtn.textContent;
                submitBtn.disabled = true;
                submitBtn.textContent = "Saving...";

                try {
                    // Gather form data
                    const formData = new FormData(form);
                    // Set the appropriate URL and method
                    const url = editId ? `/jobs/notes/${editId}` : "{{ route('job_notes.store') }}";
                    const method = 'POST'; // Laravel works with POST for PUT/PATCH via _method

                    if (editId) {
                        formData.append('_method', 'PUT');
                    }
                    let response = await fetch(url, {
                        method: method,
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
                                .content,
                            "X-Requested-With": "XMLHttpRequest",
                            "Accept": "application/json"
                        },
                        body: formData
                    });

                    let data = await response.json();

                    if (response.ok) {
                        // Replace notes block with fresh HTML from server
                        let notesContainer = document.getElementById("notesContainer");
                        notesContainer.innerHTML = data.html;

                        // Reset and close modal
                        form.reset();
                        form.removeAttribute("data-edit-id");
                        modal.classList.remove("show");

                        // Re-init feather icons
                        if (typeof feather !== 'undefined') {
                            feather.replace();
                        }

                        Swal.fire("Success!", data.message || "Note saved successfully!", "success");
                    } else {
                        Swal.fire("Error", data.message || "Unable to save note.", "error");
                    }
                } catch (error) {
                    console.error("Submission error:", error);
                    Swal.fire("Error", "Something went wrong.", "error");
                } finally {
                    submitBtn.disabled = false;
                    submitBtn.textContent = originalText;
                }
            });
        });
    </script>
@endsection
