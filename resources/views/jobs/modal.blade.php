
    <div id="candidateNote" class="side-modal">
        <div class="side-modal-content">
            <div class="side-modal-header">
                <h5>Note</h5>
                <button type="button" class="btn-close" id="close_candidateNote"></button>
            </div>
            <div class="side-modal-body">
                <div id="note_for_candidate">
                </div>
            </div>
        </div>
    </div>

    <div id="sideModal_JobDescription" class="side-modal">
        <div class="side-modal-content">
            <div class="side-modal-header">
                <h5>Job Description</h5>
                <button type="button" class="btn-close" id="closeSideModalDescription"></button>
            </div>
            <div class="side-modal-body">
                <div id="job_description">
                </div>
            </div>
        </div>
    </div>
    <div id="sideModal" class="side-modal">
        <div class="side-modal-content">
            <div class="side-modal-header">
                <h5>Add Job</h5>
                <button type="button" class="btn-close" id="closeSideModal"></button>
            </div>
            <div class="side-modal-body">
                <form id="jobForm" enctype="multipart/form-data">
                    @csrf
                    <h6 class="border-bottom pb-1 mb-3">Basic Information</h6>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Job Title*</label>
                            <input type="text" class="form-control" name="job_title" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Number of Openings*</label>
                            <input type="number" class="form-control" name="no_of_openings" min="1" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Company*</label>
                            <select class="form-select select2" name="company_id" required>
                                <option value="">Select Company</option>
                                @isset($companies)
                                    @foreach ($companies as $company)
                                        <option value="{{ $company->id }}">{{ $company->name }}</option>
                                    @endforeach
                                @endisset
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Target Company</label>
                            <select class="form-select" name="target_company_id">
                                <option value="">Select Company</option>
                                @isset($target_companies)
                                    @foreach ($target_companies as $company)
                                        <option value="{{ $company->id }}">{{ $company->name }}</option>
                                    @endforeach
                                @endisset
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Primary Contact*</label>
                            <select class="form-select select2" name="primary_contact_id">
                                <option value="">Select Contact</option>

                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Secondary Contact</label>

                            <select id="input_tags1" class="form-select select2 select2-multiple"
                                name="secondary_contacts[]" multiple="multiple" data-placeholder="Secondary Contact">

                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Job Description*</label>
                        <div class="card card-border rounded-top-start-0">
                            <div class="card-body">
                                <div class="tab-content mt-0">
                                    <div class="tab-pane fade show active" id="tab_classic">
                                        <div class="tinymce-wrap">
                                            <textarea id="classic" name="job_description"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- <textarea class="form-control " name="job_description" rows="4" required></textarea> --}}
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Location Type*</label>
                            <select class="form-select" name="location_type" required>
                                <option value="Onsite">Onsite</option>
                                <option value="Remote">Remote</option>
                                <option value="Hybrid">Hybrid</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Job Type*</label>
                            <input type="text" class="form-control" name="job_type"
                                placeholder="Full-time / Contract" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Job Category</label>
                            <input type="text" class="form-control" name="job_category"
                                placeholder="e.g., Engineering">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Salary Type</label>
                            <select class="form-select" name="salary_type">
                                <option value="">Select</option>
                                <option value="Annual">Annual</option>
                                <option value="Monthly">Monthly</option>
                                <option value="Weekly">Weekly</option>
                                <option value="Daily">Daily</option>
                                <option value="Hourly">Hourly</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Min Experience*</label>
                            <select class="form-select" name="min_experience" required>
                                <option value="0">Fresher</option>
                                @for ($i = 1; $i <= 21; $i++)
                                    <option value="{{ $i }}">{{ $i <= 20 ? $i . ' Years' : '20+ Years' }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Max Experience*</label>
                            <select class="form-select" name="max_experience" required>
                                <option value="0">Fresher</option>
                                @for ($i = 1; $i <= 21; $i++)
                                    <option value="{{ $i }}">{{ $i <= 20 ? $i . ' Years' : '20+ Years' }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Currency*</label>
                            <select name="currency" class="form-select">
                                <option value="">Select Currency</option>
                                <option value="$">$ - United States Dollar</option>
                                <option value="€">€ - Euro</option>
                                <option value="£">£ - British Pound</option>
                                <option value="¥">¥ - Japanese Yen</option>
                                <option value="C$">C$ - Canadian Dollar</option>
                                <option value="A$">A$ - Australian Dollar</option>
                                <option value="CHF">CHF - Swiss Franc</option>
                                <option value="¥">¥ - Chinese Yuan</option>
                                <option value="₹">₹ - Indian Rupee</option>
                                <option value="R$">R$ - Brazilian Real</option>
                                <option value="R">R - South African Rand</option>
                                <option value="kr">kr - Swedish Krona</option>
                                <option value="kr">kr - Norwegian Krone</option>
                                <option value="$">$ - Mexican Peso</option>
                                <option value="₽">₽ - Russian Ruble</option>
                                <option value="$">$ - Singapore Dollar</option>
                                <option value="$">$ - Hong Kong Dollar</option>
                                <option value="₩">₩ - South Korean Won</option>
                                <option value="$">$ - New Zealand Dollar</option>
                                <option value="₺">₺ - Turkish Lira</option>
                                <option value="د.إ">د.إ - UAE Dirham</option>
                                <option value="ر.س">ر.س - Saudi Riyal</option>
                                <option value="£">£ - Egyptian Pound</option>
                                <option value="฿">฿ - Thai Baht</option>
                                <option value="Rp">Rp - Indonesian Rupiah</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Min Salary*</label>
                            <input type="number" class="form-control" name="min_salary" min="0">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Max Salary*</label>
                            <input type="number" class="form-control" name="max_salary" min="0">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Educational Qualification</label>
                            <select class="form-select" name="educational_qualification">
                                <option value="">Not available</option>
                                <option value="High School Diploma">High School Diploma</option>
                                <option value="Bachelor Degree">Bachelor Degree</option>
                                <option value="Master Degree">Master Degree</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Educational Specialization</label>
                            <input type="text" class="form-control" name="educational_specialization">
                        </div>
                    </div>
                    <!-- Skills Input -->
                    <div class="form-group row">
                        <div class="form-group col-lg-12">
                            <label class="form-label">Skills</label>
                            <div class="skills-input-container">
                                <input type="text" class="form-control" id="skillsInput"
                                    placeholder="Type skill and press Enter">
                                <div id="skillsContainer" class="skills-tags-container mt-2"></div>
                                <input type="hidden" name="skills" id="skillsHiddenInput">
                            </div>
                        </div>
                    </div>

                    <h6 class="border-bottom pb-1 mb-3">Location</h6>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Locality*</label>
                            <input type="text" class="form-control" name="locality">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">City*</label>
                            <input type="text" class="form-control" name="city">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">State*</label>
                            <input type="text" class="form-control" name="state">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Country*</label>
                            <input type="text" class="form-control" name="country">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Postal Code*</label>
                            <input type="text" class="form-control" name="postal_code">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Full Address*</label>
                            <textarea class="form-control" name="full_address" rows="2"></textarea>
                        </div>
                    </div>

                    <h6 class="border-bottom pb-1 mb-3">Team & Attachments</h6>
                    <div class="row">
                        <div class="col-md-6 mb-3">
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
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Attachments</label>
                            <input type="file" class="form-control" name="attachments">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Note For Candidates</label>
                            <textarea class="form-control" name="note_for_candidates" rows="3"></textarea>
                        </div>
                    </div>

                    <!-- Application Questions -->
                    <div class="form-group row">
                        <div class="form-group col-lg-12">
                            <label class="form-label">Job Application Form
                                Questions</label>
                            <a href="javascript:void(0);" id="addQuestionBtn" class="btn btn-sm btn-primary ms-3">
                                <span>
                                    <span class="icon">
                                        <span class="feather-icon">
                                            <i data-feather="plus"></i>
                                        </span>
                                    </span>
                                    <span class="btn-text">Add Question</span>
                                </span>
                            </a>
                            <div id="questionsContainer" style="display: none; margin-top: 10px;">
                                <!-- Questions will be added here -->
                            </div>
                        </div>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-success">Save Job</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        // Initialize TinyMCE when the DOM is loaded
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof tinymce !== 'undefined') {
                tinymce.init({
                    selector: '#classic',
                    plugins: 'lists link image table code help wordcount',
                    toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright | bullist numlist outdent indent | link image',
                    height: 300,
                    setup: function(editor) {
                        editor.on('init', function() {
                            console.log('TinyMCE initialized successfully');
                        });
                    }
                });
            }
        });
        // Debug: Check CSRF token on page load
        document.addEventListener('DOMContentLoaded', async function() {
            const csrfToken = document.querySelector('meta[name="csrf-token"]');
            if (csrfToken) {
                console.log('CSRF Token found:', csrfToken.getAttribute('content'));
            } else {
                console.error('CSRF Token meta tag not found');
            }

            // Test session and CSRF
            console.log('Testing session and CSRF...');
            const sessionTest = await testSession();
            if (sessionTest) {
                console.log('Session test completed successfully');
            } else {
                console.error('Session test failed');
            }

            // Set up bulk delete functionality
            setupBulkDelete();
        });

        // Function to set up bulk delete functionality
        function setupBulkDelete() {
            // Add event listeners to all job checkboxes
            const jobCheckboxes = document.querySelectorAll('.job-checkbox');
            jobCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', handleCheckboxSelection);
            });

            // Add event listener to bulk delete button
            const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
            if (bulkDeleteBtn) {
                bulkDeleteBtn.addEventListener('click', bulkDeleteJobs);
            }

            // Add event listener to select all checkbox
            const selectAllCheckbox = document.querySelector('.check-select-all');
            if (selectAllCheckbox) {
                selectAllCheckbox.addEventListener('change', function() {
                    const isChecked = this.checked;
                    jobCheckboxes.forEach(checkbox => {
                        checkbox.checked = isChecked;
                    });
                    handleCheckboxSelection();
                });
            }
        }

        // Function to refresh CSRF token
        async function refreshCsrfToken() {
            try {
                const response = await fetch('/csrf-token', {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                if (response.ok) {
                    const data = await response.json();
                    const csrfMeta = document.querySelector('meta[name="csrf-token"]');
                    if (csrfMeta) {
                        csrfMeta.setAttribute('content', data.token);
                        console.log('CSRF token refreshed');
                        return true;
                    }
                }
            } catch (error) {
                console.error('Failed to refresh CSRF token:', error);
            }
            return false;
        }

        // Function to test session and CSRF
        async function testSession() {
            try {
                const response = await fetch('/test-session', {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                if (response.ok) {
                    const data = await response.json();
                    console.log('Session test result:', data);
                    return data;
                }
            } catch (error) {
                console.error('Failed to test session:', error);
            }
            return null;
        }

        // Function to delete a job
        async function deleteJob(jobId, jobTitle) {
            try {
                // Show confirmation dialog using SweetAlert2
                const result = await Swal.fire({
                    title: 'Are you sure?',
                    text: `Do you want to delete the job "${jobTitle}"? This action cannot be undone.`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                });

                if (!result.isConfirmed) {
                    return;
                }

                // Show loading state
                Swal.fire({
                    title: 'Deleting...',
                    text: 'Please wait while we delete the job.',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                console.log('Deleting job ID:', jobId); // Debug log

                // Get CSRF token
                const csrfToken = document.querySelector('meta[name="csrf-token"]');
                if (!csrfToken) {
                    throw new Error('CSRF token not found. Please refresh the page.');
                }

                // Make delete request
                const response = await fetch(`/jobs/${jobId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': csrfToken.getAttribute('content'),
                        'Accept': 'application/json'
                    },
                    credentials: 'same-origin'
                });

                console.log('Delete response status:', response.status); // Debug log

                if (!response.ok) {
                    const errorText = await response.text();
                    console.error('Delete error response:', errorText); // Debug log
                    throw new Error(errorText || 'Delete request failed');
                }

                const data = await response.json();
                console.log('Delete response data:', data); // Debug log

                // Show success message using SweetAlert2
                await Swal.fire({
                    title: 'Deleted!',
                    text: 'Job has been deleted successfully.',
                    icon: 'success',
                    timer: 2000,
                    showConfirmButton: false
                });

                // Remove the row from the table
                const row = document.querySelector(`tr[data-job-id="${jobId}"]`);
                if (row) {
                    row.remove();
                } else {
                    // If row not found, refresh the page
                    window.location.reload();
                }

            } catch (error) {
                console.error('Error deleting job:', error);

                if (error.message.includes('419')) {
                    console.log('Attempting to refresh CSRF token...');
                    const refreshed = await refreshCsrfToken();
                    if (refreshed) {
                        alert('CSRF token refreshed. Please try deleting again.');
                    } else {
                        alert('CSRF token expired. Please refresh the page and try again.');
                    }
                } else {
                    alert('Failed to delete job: ' + error.message);
                }
            }
        }

        // Function to handle checkbox selection for bulk delete
        function handleCheckboxSelection() {
            const checkboxes = document.querySelectorAll('.job-checkbox:checked');
            const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');

            if (checkboxes.length > 0) {
                bulkDeleteBtn.style.display = 'inline-block';
                bulkDeleteBtn.textContent = `Delete Selected (${checkboxes.length})`;
            } else {
                bulkDeleteBtn.style.display = 'none';
            }
        }

        // Function to handle bulk delete
        async function bulkDeleteJobs() {
            try {
                // Get all checked checkboxes
                const checkboxes = document.querySelectorAll('input[type="checkbox"]:checked');
                const jobIds = [];

                checkboxes.forEach(checkbox => {
                    if (checkbox.value && checkbox.value !== 'on') {
                        jobIds.push(checkbox.value);
                    }
                });

                if (jobIds.length === 0) {
                    Swal.fire({
                        title: 'No Selection',
                        text: 'Please select at least one job to delete.',
                        icon: 'info'
                    });
                    return;
                }

                // Show confirmation dialog
                const result = await Swal.fire({
                    title: 'Are you sure?',
                    text: `Do you want to delete ${jobIds.length} selected job(s)? This action cannot be undone.`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete them!',
                    cancelButtonText: 'Cancel'
                });

                if (!result.isConfirmed) {
                    return;
                }

                // Show loading state
                Swal.fire({
                    title: 'Deleting...',
                    text: 'Please wait while we delete the selected jobs.',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Get CSRF token
                const csrfToken = document.querySelector('meta[name="csrf-token"]');
                if (!csrfToken) {
                    throw new Error('CSRF token not found. Please refresh the page.');
                }

                // Make bulk delete request
                const response = await fetch('/jobs/bulk-delete', {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': csrfToken.getAttribute('content'),
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        job_ids: jobIds
                    }),
                    credentials: 'same-origin'
                });

                if (!response.ok) {
                    const errorText = await response.text();
                    throw new Error(errorText || 'Bulk delete request failed');
                }

                const data = await response.json();

                // Show success message
                await Swal.fire({
                    title: 'Deleted!',
                    text: `${jobIds.length} job(s) have been deleted successfully.`,
                    icon: 'success',
                    timer: 2000,
                    showConfirmButton: false
                });

                // Refresh the page to show updated data
                window.location.reload();

            } catch (error) {
                console.error('Error in bulk delete:', error);

                if (error.message.includes('419')) {
                    console.log('Attempting to refresh CSRF token...');
                    const refreshed = await refreshCsrfToken();
                    if (refreshed) {
                        alert('CSRF token refreshed. Please try deleting again.');
                    } else {
                        alert('CSRF token expired. Please refresh the page and try again.');
                    }
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Failed to delete jobs: ' + error.message,
                        icon: 'error'
                    });
                }
            }
        }

        // Open side modal for new job
        document.getElementById('openSideModal').addEventListener('click', function() {
            const form = document.getElementById('jobForm');
            const modalTitle = document.querySelector('.side-modal-header h5');

            // Reset form and change title
            form.reset();
            form.removeAttribute('data-edit-id');
            modalTitle.textContent = 'Add Job';

            // Open modal
            document.getElementById('sideModal').classList.add('show');
        });

        // Close side modal
        document.getElementById('closeSideModal').addEventListener('click', function() {
            document.getElementById('sideModal').classList.remove('show');
        });
        // Close Description side modal
        document.getElementById('closeSideModalDescription').addEventListener('click', function() {
            document.getElementById('sideModal_JobDescription').classList.remove('show');
        });
        // Close Note for Candidate side modal
        document.getElementById('close_candidateNote').addEventListener('click', function() {
            document.getElementById('candidateNote').classList.remove('show');
        });

        // Close modal on outside click
        window.addEventListener('click', function(e) {
            const modal = document.getElementById('sideModal');
            if (e.target === modal) {
                modal.classList.remove('show');
            }
        });
        // Edit job functionality
        async function editJob(jobId) {
            try {
                // Show loading state
                const swalInstance = Swal.fire({
                    title: 'Loading...',
                    allowOutsideClick: false,
                    didOpen: () => Swal.showLoading()
                });

                const response = await fetch(`/jobs/${jobId}/edit`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);

                const {
                    job,
                    questions
                } = await response.json();
                if (!job) throw new Error("Job data not found");

                // Populate form fields
                const form = document.getElementById('jobForm');
                const fieldsToPopulate = [
                    'job_title', 'no_of_openings', 'company_id', 'target_company_id',
                    'location_type', 'job_type', 'job_category', 'salary_type',
                    'min_experience', 'max_experience', 'currency', 'min_salary',
                    'max_salary', 'educational_qualification', 'educational_specialization',
                    'locality', 'city', 'state', 'country', 'postal_code', 'full_address',
                    'note_for_candidates', 'collaborator', 'skills', 'attachments', 'primary_contact_id',
                    'secondary_contacts'
                ];

                fieldsToPopulate.forEach(key => {
                    const input = form.querySelector(`[name="${key}"]`);
                    if (input) {
                        input.value = job[key] || '';
                    }
                });

                // Handle select2 fields
                if (typeof $ !== 'undefined' && $.fn.select2) {
                    $('[name="company_id"]').val(job.company_id).trigger('change');
                    $('[name="target_company_id"]').val(job.target_company_id).trigger('change');
                }

                // Handle collaborators (multi-select)
                if (job.collaborators && Array.isArray(job.collaborators)) {
                    const collaboratorSelect = form.querySelector('[name="collaborator[]"]');
                    if (collaboratorSelect) {
                        job.collaborators.forEach(collab => {
                            const option = collaboratorSelect.querySelector(`option[value="${collab.id}"]`);
                            if (option) option.selected = true;
                        });
                        if (typeof $ !== 'undefined' && $.fn.select2) {
                            $(collaboratorSelect).trigger('change');
                        }
                    }
                }

                //Handle secondary contact
                if (job.contacts && Array.isArray(job.contacts)) {

                    const secondarySelect = form.querySelector('[name="secondary_contacts[]"]');
                    if (secondarySelect) {
                        job.contacts.forEach(collab => {
                            console.log(collab.contact_id);
                            const option = secondarySelect.querySelector(
                                `option[value="${collab.contact_id}"]`);
                            if (option) option.selected = true;
                        });
                        if (typeof $ !== 'undefined' && $.fn.select2) {
                            $(secondarySelect).trigger('change');
                        }
                    }
                }

                // Handle skills
                if (job.skills) {
                    const skillsArray = job.skills.split(',')
                        .map(skill => skill.trim())
                        .filter(skill => skill.length > 0);

                    skillsArray.forEach(skill => {
                        addSkillTag(skill);
                    });
                    updateSkillsHiddenInput();
                }

                // Skill management functions
                function addSkillTag(skill) {
                    const skillsContainer = document.getElementById('skillsContainer');

                    // Check if skill already exists
                    const existingSkills = Array.from(skillsContainer.querySelectorAll('.skill-tag'))
                        .map(tag => tag.textContent.replace('×', '').trim());

                    if (existingSkills.includes(skill)) return;

                    const skillTag = document.createElement('span');
                    skillTag.className = 'skill-tag';
                    skillTag.innerHTML = `
        ${skill}
        <span class="remove-skill">×</span>
    `;

                    skillsContainer.appendChild(skillTag);

                    // Add remove handler
                    skillTag.querySelector('.remove-skill').addEventListener('click', function() {
                        skillTag.remove();
                        updateSkillsHiddenInput();
                    });
                }

                function updateSkillsHiddenInput() {
                    const skillsContainer = document.getElementById('skillsContainer');
                    const hiddenInput = document.getElementById('skillsHiddenInput');

                    const skills = Array.from(skillsContainer.querySelectorAll('.skill-tag'))
                        .map(tag => tag.textContent.replace('×', '').trim())
                        .filter(skill => skill.length > 0)
                        .join(',');

                    hiddenInput.value = skills;
                }

                // Handle new skill input
                document.getElementById('skillsInput').addEventListener('keydown', function(e) {
                    if (['Enter', ','].includes(e.key) && this.value.trim()) {
                        e.preventDefault();
                        addSkillTag(this.value.trim());
                        this.value = '';
                        updateSkillsHiddenInput();
                    }
                });

                // Handle application questions
                const questionsContainer = document.getElementById('questionsContainer');
                if (questions && questions.length > 0) {
                    questionsContainer.style.display = 'block';
                    questionsContainer.innerHTML = ''; // Clear existing questions

                    questions.forEach((question, index) => {
                        const questionDiv = document.createElement('div');
                        questionDiv.className = 'question-group mb-2';
                        questionDiv.innerHTML = `
                    <div class="input-group">
                        <input type="text" class="form-control" name="questions[]"
                               value="${question}"
                               placeholder="Enter question ${index + 1}" required>
                        <button class="btn btn-outline-danger remove-question" type="button">
                            <span class="icon">
                                <span class="feather-icon">
                                    <i data-feather="x"></i>
                                </span>
                            </span>
                        </button>
                    </div>
                `;
                        questionsContainer.appendChild(questionDiv);
                    });

                    // Initialize Feather icons for new elements
                    if (window.feather) {
                        feather.replace();
                    }
                }

                // Set edit mode
                form.setAttribute('data-edit-id', jobId);
                document.querySelector('.side-modal-header h5').textContent = 'Edit Job';

                // Open modal first
                document.getElementById('sideModal').classList.add('show');

                // Handle TinyMCE after modal is visible
                const initTinyMCE = () => {
                    if (typeof tinymce !== 'undefined') {
                        const editor = tinymce.get('classic');
                        if (editor) {
                            editor.setContent(job.job_description || '');
                        } else {
                            tinymce.init({
                                selector: '#classic',
                                setup: editor => {
                                    editor.on('init', () => {
                                        editor.setContent(job.job_description || '');
                                    });
                                }
                            });
                        }
                    } else {
                        document.getElementById('classic').value = job.job_description || '';
                    }
                };

                setTimeout(initTinyMCE, 300);
                await swalInstance.close();

            } catch (error) {
                console.error('Edit error:', error);
                Swal.fire('Error', 'Failed to load job details', 'error');
            }
        }
        // job description
        async function JobDescription(jobId) {
            try {
                // Show loading state
                const swalInstance = Swal.fire({
                    title: 'Loading...',
                    allowOutsideClick: false,
                    didOpen: () => Swal.showLoading()
                });

                console.log(jobId);
                const response = await fetch(`/jobs?id=${jobId}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);

                const job = await response.json();
                console.log(job.jobs.job_description);

                // Open modal first
                document.getElementById('sideModal_JobDescription').classList.add('show');

                // Set the job description - using vanilla JS
                const jobDescElement = document.getElementById('job_description');
                if (jobDescElement) {
                    // Check if it's an input/textarea or a div/span
                    if (jobDescElement.tagName === 'INPUT' || jobDescElement.tagName === 'TEXTAREA') {
                        jobDescElement.value = job.jobs.job_description;
                    } else {
                        jobDescElement.innerHTML = job.jobs.job_description; // Changed to innerHTML
                    }
                } else {
                    console.error('Element with ID job_description not found');
                }

                await swalInstance.close();
            } catch (error) {
                console.error('Edit error:', error);
                Swal.fire('Error', 'Failed to load job details', 'error');
            }
        }
        async function NoteForCandidate(jobId) {
            try {
                // Show loading state
                const swalInstance = Swal.fire({
                    title: 'Loading...',
                    allowOutsideClick: false,
                    didOpen: () => Swal.showLoading()
                });

                console.log(jobId);
                const response = await fetch(`/jobs?id=${jobId}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);

                const job = await response.json();
                console.log(job.jobs.note_for_candidates);

                // Open modal first
                document.getElementById('candidateNote').classList.add('show');

                // Set the job description - using vanilla JS
                const jobDescElement = document.getElementById('note_for_candidate');
                if (jobDescElement) {
                    // Check if it's an input/textarea or a div/span
                    if (jobDescElement.tagName === 'INPUT' || jobDescElement.tagName === 'TEXTAREA') {
                        jobDescElement.value = job.jobs.note_for_candidates;
                    } else {
                        jobDescElement.innerHTML = job.jobs.note_for_candidates; // Changed to innerHTML
                    }
                } else {
                    console.error('Element with ID note for candidate not found');
                }

                await swalInstance.close();
            } catch (error) {
                console.error('Edit error:', error);
                Swal.fire('Error', 'Failed to load job details', 'error');
            }
        }
        // Form submit to handle both create and edit
        document.getElementById('jobForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const form = e.target;
            const editId = form.getAttribute('data-edit-id');
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;

            try {
                // Disable submit button and show loading
                submitBtn.disabled = true;
                submitBtn.innerHTML =
                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> ' +
                    (editId ? 'Updating...' : 'Saving...');

                // Safely get TinyMCE content with multiple fallbacks
                let jobDescription = '';
                try {
                    if (typeof tinymce !== 'undefined') {
                        const editor = tinymce.get('classic');
                        if (editor) {
                            jobDescription = editor.getContent();
                        } else {
                            // Fallback to direct textarea value if editor not available
                            jobDescription = document.getElementById('classic').value;
                            console.warn('TinyMCE editor not found, using textarea value directly');
                        }
                    } else {
                        jobDescription = document.getElementById('classic').value;
                        console.warn('TinyMCE not loaded, using textarea value directly');
                    }
                } catch (error) {
                    console.error('Error getting TinyMCE content:', error);
                    jobDescription = document.getElementById('classic').value;
                }

                // Prepare form data
                const formData = new FormData(form);
                formData.set('job_description', jobDescription);

                // Set the appropriate URL and method
                const url = editId ? `/jobs/${editId}` : "{{ route('jobs.store') }}";
                const method = 'POST'; // Laravel works with POST for PUT/PATCH via _method

                if (editId) {
                    formData.append('_method', 'PUT');
                }

                // Get CSRF token
                const csrfToken = document.querySelector('meta[name="csrf-token"]');
                if (!csrfToken) {
                    throw new Error('CSRF token not found');
                }

                // Submit the form
                const response = await fetch(url, {
                    method: method,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': csrfToken.getAttribute('content'),
                        'Accept': 'application/json'
                    },
                    body: formData,
                    credentials: 'same-origin'
                });

                // Handle response
                if (!response.ok) {
                    const errorData = await response.json().catch(() => ({}));
                    let errorMessage = 'Request failed';

                    if (errorData.errors) {
                        // Handle validation errors
                        errorMessage = Object.values(errorData.errors).join('\n');
                    } else if (errorData.message) {
                        errorMessage = errorData.message;
                    } else if (errorData.error) {
                        errorMessage = errorData.error;
                    }

                    throw new Error(errorMessage);
                }

                const data = await response.json();

                // Show success message with SweetAlert
                await Swal.fire({
                    title: 'Success!',
                    text: data.message || (editId ? 'Job updated successfully!' :
                        'Job created successfully!'),
                    icon: 'success',
                    confirmButtonText: 'OK'
                });

                // Reset form and close modal
                form.reset();
                form.removeAttribute('data-edit-id');
                document.getElementById('sideModal').classList.remove('show');

                // Refresh the page to show changes
                window.location.reload();

            } catch (err) {
                console.error('Submission error:', err);

                if (err.message.includes('419')) {
                    // CSRF token mismatch
                    const refreshed = await refreshCsrfToken();
                    if (refreshed) {
                        await Swal.fire({
                            title: 'Session Expired',
                            text: 'Please try submitting again.',
                            icon: 'warning'
                        });
                    } else {
                        await Swal.fire({
                            title: 'Session Expired',
                            text: 'Please refresh the page and try again.',
                            icon: 'error'
                        });
                    }
                } else {
                    // Show detailed error message
                    await Swal.fire({
                        title: 'Error',
                        text: err.message || (editId ? 'Failed to update job' : 'Failed to create job'),
                        icon: 'error'
                    });
                }
            } finally {
                // Re-enable submit button
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.textContent = originalText;
                }
            }
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Tagify
            const input = document.getElementById('skillsInput');
            const tagify = new Tagify(input, {
                whitelist: [], // You can predefine skills here if needed
                dropdown: {
                    enabled: 0 // Disable dropdown
                },
                originalInputValueFormat: valuesArr => valuesArr.map(item => item.value).join(',')
            });

            // Add skill when Enter is pressed
            input.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' && input.value.trim()) {
                    e.preventDefault();

                    // Create a new skill tag
                    const skill = input.value.trim();
                    const skillTag = document.createElement('span');
                    skillTag.className = 'badge badge-soft-primary py-2 px-3';
                    skillTag.innerHTML = `
                ${skill}
                <span class="remove-skill" style="cursor:pointer; margin-left:5px;">×</span>
            `;

                    // Add to skills container
                    document.getElementById('skillsContainer').appendChild(skillTag);

                    // Clear input
                    input.value = '';

                    // Add remove functionality
                    skillTag.querySelector('.remove-skill').addEventListener('click', function() {
                        skillTag.remove();
                    });
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // Initialize select2 for multiple selection
            $('.select2-multiple').select2({
                tags: true,
                placeholder: "Select secondary contacts",
                allowClear: true
            });

            // Company select change event
            $('select[name="company_id"]').on('change', function() {
                const companyId = $(this).val();
                const primaryContactSelect = $('select[name="primary_contact_id"]');
                const secondaryContactSelect = $('#input_tags1'); // Changed to use ID selector

                // Clear existing options and add default
                primaryContactSelect.empty().append('<option value="">Select Contact</option>');
                secondaryContactSelect.empty().append(
                    '<option value=""></option>'); // Empty option for placeholder

                if (companyId) {
                    // Fetch contacts for the selected company
                    fetchContacts(companyId, primaryContactSelect, secondaryContactSelect);
                }
            });

            function fetchContacts(companyId, primarySelect, secondarySelect) {
                // AJAX request to get contacts for the company
                $.ajax({
                    url: '/contact/get-contacts-by-company',
                    method: 'GET',
                    data: {
                        company_id: companyId
                    },
                    success: function(response) {
                        if (response.contacts && response.contacts.length > 0) {
                            // Clear existing options (keeping the placeholder)
                            primarySelect.find('option:not(:first)').remove();
                            secondarySelect.find('option').not(':first').remove();

                            // Add contacts to both dropdowns
                            response.contacts.forEach(function(contact) {
                                const optionText = contact.first_name + ' ' + contact.last_name;
                                const optionValue = contact.id;

                                // Add to primary contact (single select)
                                primarySelect.append(new Option(optionText, optionValue));

                                // Add to secondary contacts (multiple select)
                                secondarySelect.append(new Option(optionText, optionValue));
                            });

                            // Refresh select2 instances
                            primarySelect.trigger('change');
                            secondarySelect.trigger('change');
                        }
                    },
                    error: function(xhr) {
                        console.error('Error fetching contacts:', xhr.responseText);
                    }
                });
            }

            // Prevent selecting the same contact as primary and secondary
            $('select[name="primary_contact_id"]').on('change', function() {
                const selectedValue = $(this).val();
                const secondarySelect = $('#input_tags1');

                // Enable all options first
                secondarySelect.find('option').prop('disabled', false);

                if (selectedValue) {
                    // Disable the selected primary contact in secondary dropdown
                    secondarySelect.find('option[value="' + selectedValue + '"]').prop('disabled', true);

                    // Remove if already selected
                    const selectedValues = secondarySelect.val() || [];
                    const index = selectedValues.indexOf(selectedValue);
                    if (index !== -1) {
                        selectedValues.splice(index, 1);
                        secondarySelect.val(selectedValues).trigger('change');
                    }
                }

                secondarySelect.trigger('change.select2');
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const addQuestionBtn = document.getElementById('addQuestionBtn');
            const questionsContainer = document.getElementById('questionsContainer');
            let questionCount = 0;

            addQuestionBtn.addEventListener('click', function(e) {
                e.preventDefault();

                // Show container if it's hidden
                if (questionsContainer.style.display === 'none') {
                    questionsContainer.style.display = 'block';
                }

                // Create new question input
                questionCount++;
                const questionDiv = document.createElement('div');
                questionDiv.className = 'question-group mb-2';
                questionDiv.innerHTML = `
            <div class="input-group">
                <input type="text" class="form-control" name="questions[]" placeholder="Enter question ${questionCount}" required>
                <button class="btn btn-outline-danger remove-question" type="button">
                    <span class="icon"><span class="feather-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></span></span>
                </button>
            </div>
        `;

                questionsContainer.appendChild(questionDiv);

                // Initialize Feather icons
                if (window.feather) {
                    feather.replace();
                }
            });

            // Handle question removal
            questionsContainer.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-question') || e.target.closest(
                        '.remove-question')) {
                    e.preventDefault();
                    const questionGroup = e.target.closest('.question-group');
                    questionGroup.remove();

                    // Renumber remaining questions
                    const remainingQuestions = questionsContainer.querySelectorAll('.question-group');
                    remainingQuestions.forEach((group, index) => {
                        const input = group.querySelector('input');
                        input.placeholder = `Enter question ${index + 1}`;
                    });

                    questionCount = remainingQuestions.length;

                    // Hide container if no questions left
                    if (questionsContainer.children.length === 0) {
                        questionsContainer.style.display = 'none';
                        questionCount = 0;
                    }
                }
            });
        });
    </script>
