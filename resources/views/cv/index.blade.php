@extends('layouts.app')

@section('title', 'Upload CV - Bulk Only')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">
                        <i class="fas fa-upload me-2"></i>Upload CV(s) for Parsing
                    </h4>
                    <small class="text-muted">Supports multiple CV files</small>
                </div>

                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show">
                            <strong>Error:</strong> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            <strong>Success:</strong> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('cv.store') }}" method="POST" enctype="multipart/form-data" id="cvUploadForm">
                        @csrf

                        <!-- Bulk Upload Section Only -->
                        <div class="mb-3">
                            <label for="cv_files_bulk" class="form-label">
                                <i class="fas fa-paperclip me-1"></i>Select Single Or Multiple CV(s) Files
                            </label>
                            <input type="file"
                                   class="form-control @error('cv_files') is-invalid @enderror"
                                   id="cv_files_bulk"
                                   name="cv_files[]"
                                   accept=".pdf,.docx,.doc,.jpg,.jpeg,.png"
                                   multiple>
                        </div>

                        <div class="mb-3">
                            <div class="alert alert-info">
                                <h6><i class="fas fa-info-circle me-1"></i>Supported Formats & Features:</h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <ul class="mb-0">
                                            <li><strong>PDF:</strong> Text extraction + OCR fallback</li>
                                            <li><strong>Word:</strong> DOCX, DOC files</li>
                                            <li><strong>Images:</strong> JPG, JPEG, PNG with OCR</li>
                                            <li><strong>Size Limit:</strong> 10MB per file</li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <ul class="mb-0">
                                            <li>✓ Multi-language support</li>
                                            <li>✓ Various CV layouts & formats</li>
                                            <li>✓ Enhanced image text extraction</li>
                                            <li>✓ Bulk processing (up to 20 files)</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- File Preview Area -->
                        <div id="filePreview" class="mb-3" style="display: none;">
                            <h6>Selected Files:</h6>
                            <div id="fileList" class="border p-2 rounded bg-light"></div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="terms" required>
                                <label class="form-check-label" for="terms">
                                    I agree that the uploaded CV(s) will be parsed and the extracted information will be stored for recruitment purposes.
                                </label>
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg" id="submitBtn">
                                <span class="spinner-border spinner-border-sm d-none me-2" id="loadingSpinner"></span>
                                <span id="buttonText">
                                    <i class="fas fa-cloud-upload-alt me-1"></i>Upload and Parse CV(s)
                                </span>
                            </button>
                        </div>
                    </form>

                    <div class="mt-4">
                        <div class="accordion" id="parsingInfoAccordion">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#parsingInfo">
                                        <i class="fas fa-robot me-2"></i>What Information Gets Extracted?
                                    </button>
                                </h2>
                                <div id="parsingInfo" class="accordion-collapse collapse" data-bs-parent="#parsingInfoAccordion">
                                    <div class="accordion-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h6>Personal Information:</h6>
                                                <ul class="small">
                                                    <li>Full name (first & last name)</li>
                                                    <li>Email address</li>
                                                    <li>Phone number (multiple formats)</li>
                                                    <li>Complete address with postcode</li>
                                                    <li>Date of birth & age</li>
                                                    <li>Gender & nationality</li>
                                                </ul>
                                            </div>
                                            <div class="col-md-6">
                                                <h6>Professional Details:</h6>
                                                <ul class="small">
                                                    <li>Current organization & position</li>
                                                    <li>Total years of experience</li>
                                                    <li>Salary information</li>
                                                    <li>Notice period & availability</li>
                                                    <li>Willingness to relocate</li>
                                                    <li>Right to work status</li>
                                                </ul>
                                            </div>
                                        </div>

                                        <div class="row mt-3">
                                            <div class="col-md-6">
                                                <h6>Skills & Qualifications:</h6>
                                                <ul class="small">
                                                    <li>Technical skills & technologies</li>
                                                    <li>Programming languages</li>
                                                    <li>Education & qualifications</li>
                                                    <li>Professional certifications</li>
                                                </ul>
                                            </div>
                                            <div class="col-md-6">
                                                <h6>Additional Information:</h6>
                                                <ul class="small">
                                                    <li>Work experience details</li>
                                                    <li>Professional summary</li>
                                                    <li>Social profiles (LinkedIn, GitHub)</li>
                                                    <li>Languages spoken</li>
                                                    <li>Driving license status</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- /.accordion -->
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const filePreview = document.getElementById('filePreview');
    const fileList = document.getElementById('fileList');
    const submitBtn = document.getElementById('submitBtn');
    const buttonText = document.getElementById('buttonText');

    document.getElementById('cv_files_bulk').addEventListener('change', function(e) {
        validateAndPreviewFiles(e.target.files);
    });

    document.getElementById('cvUploadForm').addEventListener('submit', function(e) {
        const files = document.getElementById('cv_files_bulk').files;

        if (files.length === 0) {
            e.preventDefault();
            alert('Please select at least one CV file to upload.');
            return;
        }

        submitBtn.disabled = true;
        document.getElementById('loadingSpinner').classList.remove('d-none');
        buttonText.innerHTML = `<i class="fas fa-spinner fa-spin me-1"></i>Processing ${files.length} CVs...`;
    });

    function validateAndPreviewFiles(files) {
        const maxFileSize = 10 * 1024 * 1024; // 10MB
        const maxFiles = 20;
        const validTypes = ['application/pdf', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/msword', 'image/jpeg', 'image/jpg', 'image/png'];

        let validFiles = [];
        let errors = [];

        if (files.length > maxFiles) {
            errors.push(`Maximum ${maxFiles} files allowed.`);
        }

        for (let i = 0; i < Math.min(files.length, maxFiles); i++) {
            const file = files[i];

            if (file.size > maxFileSize) {
                errors.push(`${file.name}: File size exceeds 10MB limit.`);
                continue;
            }

            if (!validTypes.includes(file.type) && !file.name.match(/\.(pdf|docx?|jpe?g|png)$/i)) {
                errors.push(`${file.name}: Unsupported file format.`);
                continue;
            }

            validFiles.push(file);
        }

        if (errors.length > 0) {
            alert('Validation Errors:\n' + errors.join('\n'));
        }

        if (validFiles.length > 0) {
            showFilePreview(validFiles);
        } else {
            clearFilePreview();
        }
    }

    function showFilePreview(files) {
        let html = '';

        for (let file of files) {
            const size = formatFileSize(file.size);
            const icon = getFileIcon(file.name);

            html += `
                <div class="d-flex align-items-center mb-2 p-2 border rounded">
                    <i class="${icon} me-2 text-primary"></i>
                    <div class="flex-grow-1">
                        <div class="fw-medium">${file.name}</div>
                        <small class="text-muted">${size}</small>
                    </div>
                    <span class="badge bg-success">Valid</span>
                </div>
            `;
        }

        fileList.innerHTML = html;
        filePreview.style.display = 'block';
    }

    function clearFilePreview() {
        filePreview.style.display = 'none';
        fileList.innerHTML = '';
    }

    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    function getFileIcon(filename) {
        const ext = filename.split('.').pop().toLowerCase();
        switch (ext) {
            case 'pdf': return 'fas fa-file-pdf';
            case 'doc':
            case 'docx': return 'fas fa-file-word';
            case 'jpg':
            case 'jpeg':
            case 'png': return 'fas fa-file-image';
            default: return 'fas fa-file';
        }
    }
});
</script>

<style>
.accordion-button:not(.collapsed) {
    background-color: #007D88;
}
#fileList .border {
    background-color: #f8f9fa;
}
.alert-info {
    border-left: 4px solid #0dcaf0;
}
</style>
@endsection
