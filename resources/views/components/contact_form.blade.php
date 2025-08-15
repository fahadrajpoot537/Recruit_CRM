    <div id="sideModal" class="side-modal">
        <div class="side-modal-content">
            <div class="side-modal-header">
                <h5>Add Contact</h5>
                <button type="button" class="btn-close" id="closeSideModal"></button>
            </div>
            <div class="side-modal-body">
                <form id="contactForm" class="edit-post-form" enctype="multipart/form-data">
                    @csrf
                    <h6 class="border-bottom pb-1 mb-3">Basic Information</h6>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">First Name*</label>
                            <input type="text" class="form-control" name="first_name" placeholder="First Name">
                            <div class="invalid-feedback first_name_error"></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Last Name</label>
                            <input type="text" class="form-control" name="last_name" placeholder="Last Name">
                            <div class="invalid-feedback last_name_error"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Company</label>
                            <select id="input_tags" class="form-control select2 select2-multiple" multiple="multiple"
                                data-placeholder="Choose" name="company_ids[]">
                                @foreach ($companies as $company)
                                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback company_ids_error"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" class="form-control" name="title" placeholder="Job Title / Role">
                            <div class="invalid-feedback title_error"></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" placeholder="Email Address">
                            <div class="invalid-feedback email_error"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text" class="form-control" name="phone" placeholder="Phone Number">
                            <div class="invalid-feedback phone_error"></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Stage</label>
                            <select class="form-control" name="stage">
                                <option value="">Select Stage</option>
                                <option value="Lead">Lead</option>
                                <option value="Prospect">Prospect</option>
                                <option value="Customer">Customer</option>
                                <option value="Partner">Partner</option>
                            </select>
                            <div class="invalid-feedback stage_error"></div>
                        </div>
                    </div>

                    <h6 class="border-bottom pb-1 mb-3">Social Profiles</h6>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Facebook</label>
                            <input type="url" class="form-control" name="facebook_profile_url"
                                placeholder="Facebook URL">
                            <div class="invalid-feedback facebook_profile_url_error"></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Twitter</label>
                            <input type="url" class="form-control" name="twitter_profile_url"
                                placeholder="Twitter URL">
                            <div class="invalid-feedback twitter_profile_url_error"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">LinkedIn</label>
                            <input type="url" class="form-control" name="linkedin_profile_url"
                                placeholder="LinkedIn URL">
                            <div class="invalid-feedback linkedin_profile_url_error"></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Xing</label>
                            <input type="url" class="form-control" name="xing_profile_url" placeholder="Xing URL">
                            <div class="invalid-feedback xing_profile_url_error"></div>
                        </div>
                    </div>

                    <h6 class="border-bottom pb-1 mb-3">Address</h6>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Locality</label>
                            <input type="text" class="form-control" name="locality" placeholder="Locality">
                            <div class="invalid-feedback locality_error"></div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">City</label>
                            <input type="text" class="form-control" name="city" placeholder="City">
                            <div class="invalid-feedback city_error"></div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">State</label>
                            <input type="text" class="form-control" name="state" placeholder="State">
                            <div class="invalid-feedback state_error"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Country</label>
                            <input type="text" class="form-control" name="country" placeholder="Country">
                            <div class="invalid-feedback country_error"></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Postal Code</label>
                            <input type="text" class="form-control" name="postal_code" placeholder="Postal Code">
                            <div class="invalid-feedback postal_code_error"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Full Address</label>
                            <textarea class="form-control" name="full_address" rows="2" placeholder="Full Address"></textarea>
                            <div class="invalid-feedback full_address_error"></div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12 text-end">
                            <button type="submit" class="btn btn-primary">Save Contact</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Initialize when the DOM is loaded
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize select2 for company selection
            if (typeof $ !== 'undefined' && $.fn.select2) {
                $('.select2-multiple').select2({
                    placeholder: "Select companies",
                    allowClear: true
                });
            }
            // Initialize Feather Icons
            if (window.feather) {
                feather.replace();
            }

            // Initialize tooltips
            if (window.bootstrap && bootstrap.Tooltip) {
                const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                tooltipTriggerList.map(function(tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                });
            }
            
        });

        // Helper function to clear validation errors
        function clearValidationErrors(form) {
            // Remove error classes from inputs
            const errorInputs = form.querySelectorAll('.is-invalid');
            errorInputs.forEach(input => {
                input.classList.remove('is-invalid');
            });

            // Clear error messages
            const errorMessages = form.querySelectorAll('.invalid-feedback');
            errorMessages.forEach(message => {
                message.textContent = '';
                message.style.display = 'none';
            });
        }

        // Helper function to display validation errors
        function displayValidationErrors(form, errors) {
            for (const field in errors) {
                const input = form.querySelector(`[name="${field}"]`);
                const errorElement = form.querySelector(`.${field}_error`);

                if (input && errorElement) {
                    // Add error class to input
                    input.classList.add('is-invalid');

                    // Set error message
                    errorElement.textContent = errors[field][0];
                    errorElement.style.display = 'block';
                }
            }

            // Scroll to the first error
            const firstError = form.querySelector('.is-invalid');
            if (firstError) {
                firstError.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
            }
        }

        // Email validation helper
        function validateEmail(email) {
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(email);
        }

        // URL validation helper
        function validateUrl(url) {
            try {
                new URL(url);
                return true;
            } catch (e) {
                return false;
            }
        }

        // Client-side form validation
        function validateForm(form) {
            let isValid = true;

            // Validate  fields
            const requiredFields = form.querySelectorAll('[required]');
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    field.classList.add('is-invalid');
                    const errorElement = form.querySelector(`.${field.name}_error`);
                    if (errorElement) {
                        errorElement.textContent = 'This field is required';
                        errorElement.style.display = 'block';
                    }
                    isValid = false;
                }
            });

            // Validate email format if provided
            const emailField = form.querySelector('[type="email"]');
            if (emailField && emailField.value && !validateEmail(emailField.value)) {
                emailField.classList.add('is-invalid');
                const errorElement = form.querySelector(`.${emailField.name}_error`);
                if (errorElement) {
                    errorElement.textContent = 'Please enter a valid email address';
                    errorElement.style.display = 'block';
                }
                isValid = false;
            }

            // Validate URL fields if provided
            const urlFields = form.querySelectorAll('[type="url"]');
            urlFields.forEach(field => {
                if (field.value && !validateUrl(field.value)) {
                    field.classList.add('is-invalid');
                    const errorElement = form.querySelector(`.${field.name}_error`);
                    if (errorElement) {
                        errorElement.textContent = 'Please enter a valid URL';
                        errorElement.style.display = 'block';
                    }
                    isValid = false;
                }
            });

            return isValid;
        }

        // Function to populate form for editing
        // Function to populate form for editing
        async function editContact(contactId) {
            try {
                Swal.fire({
                    title: 'Loading...',
                    allowOutsideClick: false,
                    didOpen: () => Swal.showLoading()
                });

                const response = await fetch(`/contact/edit/${contactId}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                });

                if (!response.ok) {
                    throw new Error('Failed to load contact data');
                }

                const data = await response.json();
                const contact = data.contact;

                // Clear the form and set edit mode
                const form = document.getElementById('contactForm');
                form.reset();
                form.setAttribute('data-edit-id', contactId);
                clearValidationErrors(form);

                // Populate fields - make sure to handle null values
                const fields = [
                    'first_name', 'last_name', 'title', 'email', 'phone', 'stage',
                    'facebook_profile_url', 'twitter_profile_url', 'linkedin_profile_url', 'xing_profile_url',
                    'locality', 'city', 'state', 'country', 'postal_code', 'full_address'
                ];

                fields.forEach(field => {
                    const input = form.querySelector(`[name="${field}"]`);
                    if (input) {
                        input.value = contact[field] || '';
                    }
                });

                // Handle companies
                if (contact.companies && contact.companies.length > 0) {
                    const companyIds = contact.companies.map(c => c.id);
                    if (typeof $ !== 'undefined' && $.fn.select2) {
                        $('select[name="company_ids[]"]').val(companyIds).trigger('change');
                    }
                }

                // Update modal title
                document.querySelector('.side-modal-header h5').textContent = 'Edit Contact';
                document.getElementById('sideModal').classList.add('show');

                Swal.close();
            } catch (error) {
                console.error('Error loading contact:', error);
                Swal.fire({
                    title: 'Error',
                    text: error.message || 'Failed to load contact data',
                    icon: 'error'
                });
            }
        }

        // Function to update the table row with new contact data
        function updateContactRow(contact) {
            const row = document.querySelector(`tr[data-contact-id="${contact.id}"]`);
            if (!row) return;

            // Update basic fields
            row.querySelector('td:nth-child(2)').textContent = contact.first_name;
            row.querySelector('td:nth-child(3)').textContent = contact.last_name;

            // Update companies
            const companiesCell = row.querySelector('td:nth-child(4)');
            if (contact.companies && contact.companies.length > 0) {
                companiesCell.innerHTML = contact.companies.map(c => c.name).join(', ');
            } else {
                companiesCell.innerHTML = 'N/A';
            }

            // Update other fields
            row.querySelector('td:nth-child(5)').textContent = contact.title || 'N/A';
            row.querySelector('td:nth-child(6)').textContent = contact.email || 'N/A';
            row.querySelector('td:nth-child(7)').textContent = contact.phone || 'N/A';

            // Update social links
            updateSocialLink(row, 8, contact.facebook_profile_url, 'FB');
            updateSocialLink(row, 9, contact.twitter_profile_url, 'TW');
            updateSocialLink(row, 10, contact.linkedin_profile_url, 'IN');
            updateSocialLink(row, 11, contact.xing_profile_url, 'Xing');

            // Update remaining fields
            row.querySelector('td:nth-child(12)').textContent = contact.stage || 'N/A';
            row.querySelector('td:nth-child(13)').textContent = contact.locality || 'N/A';
            row.querySelector('td:nth-child(14)').textContent = contact.city || 'N/A';
            row.querySelector('td:nth-child(15)').textContent = contact.state || 'N/A';
            row.querySelector('td:nth-child(16)').textContent = contact.country || 'N/A';
            row.querySelector('td:nth-child(17)').textContent = contact.postal_code || 'N/A';
            row.querySelector('td:nth-child(18)').textContent = contact.full_address || 'N/A';
        }

        // Helper function to update social links
        function updateSocialLink(row, cellIndex, url, label) {
            const cell = row.querySelector(`td:nth-child(${cellIndex})`);
            if (url) {
                cell.innerHTML = `<a href="${url}" target="_blank" class="hover-zoom">${label}</a>`;
            } else {
                cell.textContent = 'N/A';
            }
        }

        // Updated form submission handler
        document.getElementById('contactForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            const form = e.target;

            // Clear previous errors
            clearValidationErrors(form);

            // Validate form before submission
            if (!validateForm(form)) {
                return;
            }

            const formData = new FormData(form);
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;

            try {
                // Show loading state
                submitBtn.disabled = true;
                submitBtn.innerHTML =
                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...';

                const isEdit = form.hasAttribute('data-edit-id');
                const url = isEdit ? `/contact/${form.getAttribute('data-edit-id')}` :
                    "{{ route('contact.store') }}";

                if (isEdit) {
                    formData.append('_method', 'PUT');
                }

                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: formData
                });

                const contentType = response.headers.get('content-type');
                let data;

                if (contentType && contentType.includes('application/json')) {
                    data = await response.json();
                } else {
                    const text = await response.text();
                    throw new Error(text || 'Invalid response from server');
                }

                if (!response.ok) {
                    if (response.status === 422 && data.errors) {
                        // Validation errors
                        displayValidationErrors(form, data.errors);
                        throw new Error('Please correct the errors in the form');
                    } else {
                        throw new Error(data.message || 'Request failed');
                    }
                }

                // Show success message
                await Swal.fire({
                    title: 'Success!',
                    text: data.message || (isEdit ? 'Contact updated successfully!' :
                        'Contact created successfully!'),
                    icon: 'success',
                    confirmButtonText: 'OK'
                });

                // Close modal
                document.getElementById('sideModal').classList.remove('show');

                // Update the table without refreshing
                if (isEdit) {
                    // Update existing row
                    updateContactRow(data.contact);
                } else {
                    // Add new row to the table
                    addNewContactRow(data.contact);
                }

            } catch (error) {
                if (error.message !== 'Please correct the errors in the form') {
                    Swal.fire({
                        title: 'Error',
                        text: error.message || 'An error occurred while saving the contact',
                        icon: 'error'
                    });
                }
            } finally {
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;
            }
        });

        // Function to add a new contact row to the table
        function addNewContactRow(contact) {
            const tbody = document.querySelector('#datable_1 tbody');
            const row = document.createElement('tr');
            row.setAttribute('data-contact-id', contact.id);

            // Create checkbox cell
            const checkboxCell = document.createElement('td');
            checkboxCell.innerHTML = `
                <input type="checkbox" class="form-check-input contact-checkbox"
                       value="${contact.id}" name="contact_ids[]" id="contact_ids_${contact.id}">
            `;
            row.appendChild(checkboxCell);

            // Add basic fields
            addCell(row, contact.first_name);
            addCell(row, contact.last_name);

            // Add companies
            const companiesCell = document.createElement('td');
            if (contact.companies && contact.companies.length > 0) {
                companiesCell.textContent = contact.companies.map(c => c.name).join(', ');
            } else {
                companiesCell.textContent = 'N/A';
            }
            row.appendChild(companiesCell);

            // Add other fields
            addCell(row, contact.title || 'N/A');
            addCell(row, contact.email || 'N/A');
            addCell(row, contact.phone || 'N/A');

            // Add social links
            addSocialLinkCell(row, contact.facebook_profile_url, 'FB');
            addSocialLinkCell(row, contact.twitter_profile_url, 'TW');
            addSocialLinkCell(row, contact.linkedin_profile_url, 'IN');
            addSocialLinkCell(row, contact.xing_profile_url, 'Xing');

            // Add remaining fields
            addCell(row, contact.stage || 'N/A');
            addCell(row, contact.locality || 'N/A');
            addCell(row, contact.city || 'N/A');
            addCell(row, contact.state || 'N/A');
            addCell(row, contact.country || 'N/A');
            addCell(row, contact.postal_code || 'N/A');
            addCell(row, contact.full_address || 'N/A');

            // Add action buttons
            const actionsCell = document.createElement('td');
            actionsCell.innerHTML = `
                <div class="d-flex align-items-center">
                    <a class="btn btn-icon btn-flush-dark btn-rounded flush-soft-hover"
                        data-bs-toggle="tooltip" data-placement="top" title="Edit"
                        href="javascript:void(0);" onclick="editContact(${contact.id})">
                        <span class="icon"><span class="feather-icon"><i data-feather="edit-2"></i></span></span>
                    </a>
                    <a class="btn btn-icon btn-flush-dark btn-rounded flush-soft-hover del-button"
                        data-bs-toggle="tooltip" data-placement="top" title="Delete"
                        href="javascript:void(0);"
                        onclick="deleteContact(${contact.id}, '${contact.first_name} ${contact.last_name}')">
                        <span class="icon"><span class="feather-icon"><i data-feather="trash"></i></span></span>
                    </a>
                </div>
            `;
            row.appendChild(actionsCell);

            // Add row to the table
            tbody.insertBefore(row, tbody.firstChild);

            // Initialize Feather Icons for the new row
            if (window.feather) {
                feather.replace({
                    selector: 'i[data-feather]',
                    root: row // Only replace within this new row
                });
            }

            // Initialize tooltips for the new row
            if (window.bootstrap && bootstrap.Tooltip) {
                const tooltipTriggerList = [].slice.call(row.querySelectorAll('[data-bs-toggle="tooltip"]'));
                tooltipTriggerList.map(function(tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                });
            }

            // Update count badge
            const countBadge = document.querySelector('.card-header-action h6 .badge');
            if (countBadge) {
                const currentCount = parseInt(countBadge.textContent) || 0;
                countBadge.textContent = currentCount + 1;
            }
        }

        // Helper function to add a simple cell
        function addCell(row, content) {
            const cell = document.createElement('td');
            cell.textContent = content;
            row.appendChild(cell);
        }

        // Helper function to add social link cell
        function addSocialLinkCell(row, url, label) {
            const cell = document.createElement('td');
            if (url) {
                cell.innerHTML = `<a href="${url}" target="_blank" class="hover-zoom">${label}</a>`;
            } else {
                cell.textContent = 'N/A';
            }
            row.appendChild(cell);
        }

        // Updated delete function
        async function deleteContact(contactId, contactName) {
            try {
                // Show confirmation dialog using SweetAlert2
                const result = await Swal.fire({
                    title: 'Are you sure?',
                    text: `Do you want to delete the contact "${contactName}"? This action cannot be undone.`,
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
                    text: 'Please wait while we delete the contact.',
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

                // Make delete request
                const response = await fetch(`/contact/${contactId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': csrfToken.getAttribute('content'),
                        'Accept': 'application/json'
                    },
                    credentials: 'same-origin'
                });

                if (!response.ok) {
                    const errorText = await response.text();
                    throw new Error(errorText || 'Delete request failed');
                }

                const data = await response.json();

                // Show success message using SweetAlert2
                await Swal.fire({
                    title: 'Deleted!',
                    text: 'Contact has been deleted successfully.',
                    icon: 'success',
                    timer: 2000,
                    showConfirmButton: false
                });

                // Remove the row from the table
                const row = document.querySelector(`tr[data-contact-id="${contactId}"]`);
                if (row) {
                    row.remove();

                    // Update count badge
                    const countBadge = document.querySelector('.card-header-action h6 .badge');
                    if (countBadge) {
                        const currentCount = parseInt(countBadge.textContent) || 0;
                        if (currentCount > 0) {
                            countBadge.textContent = currentCount - 1;
                        }
                    }
                }

            } catch (error) {
                console.error('Error deleting contact:', error);
                Swal.fire({
                    title: 'Error',
                    text: error.message || 'Failed to delete contact',
                    icon: 'error'
                });
            }
        }

        // Open modal for new contact
        document.getElementById('openSideModal').addEventListener('click', function() {
            const form = document.getElementById('contactForm');
            form.reset();
            form.removeAttribute('data-edit-id');
            clearValidationErrors(form);

            // Reset select2 if initialized
            if (typeof $ !== 'undefined' && $.fn.select2) {
                $('select[name="company_ids[]"]').val(null).trigger('change');
            }

            // Update modal title
            document.querySelector('.side-modal-header h5').textContent = 'Add Contact';

            // Show modal
            document.getElementById('sideModal').classList.add('show');
        });

        // Close modal
        document.getElementById('closeSideModal').addEventListener('click', function() {
            document.getElementById('sideModal').classList.remove('show');
        });
    </script>
