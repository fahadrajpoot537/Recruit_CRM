{{-- resources/views/resume/show.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <!-- Navigation -->
            <div class="mb-3">
                <a href="{{ route('resume.index') }}" class="btn btn-outline-primary">
                    <i class="fas fa-arrow-left me-1"></i>Back to CV List
                </a>
                <button class="btn btn-outline-success" onclick="window.print()">
                    <i class="fas fa-print me-1"></i>Print
                </button>
                <button class="btn btn-outline-info" onclick="exportToJson()">
                    <i class="fas fa-download me-1"></i>Export JSON
                </button>
                <button class="btn btn-outline-danger" onclick="confirmDelete()">
                    <i class="fas fa-trash me-1"></i>Delete CV
                </button>
            </div>

            <!-- CV Header -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h2 class="mb-1">{{ $parsedCv->candidate_name ?: 'Unknown Candidate' }}</h2>
                            <p class="text-muted mb-2">
                                <i class="fas fa-file me-1"></i>{{ $parsedCv->file_name }}
                                <span class="ms-2">
                                    <i class="fas fa-calendar me-1"></i>Parsed on
                                    {{ $parsedCv->created_at->format('M d, Y \a\t H:i') }}
                                </span>
                            </p>

                            <div class="row">
                                @if($parsedCv->email)
                                <div class="col-auto">
                                    <i class="fas fa-envelope text-primary me-1"></i>
                                    <a href="mailto:{{ $parsedCv->email }}">{{ $parsedCv->email }}</a>
                                </div>
                                @endif

                                @if($parsedCv->phone_number)
                                <div class="col-auto">
                                    <i class="fas fa-phone text-primary me-1"></i>
                                    <a href="tel:{{ $parsedCv->phone_number }}">{{ $parsedCv->phone_number }}</a>
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4 text-end">
                            <div class="card bg-light">
                                <div class="card-body py-2">
                                    <div class="row text-center">
                                        <div class="col-6">
                                            <small class="text-muted">Skills</small>
                                            <div class="h5 mb-0">{{ count($skills) }}</div>
                                        </div>
                                        <div class="col-6">
                                            <small class="text-muted">Experience</small>
                                            <div class="h5 mb-0">{{ $parsedCv->total_experience ?? 'N/A' }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Left Column -->
                <div class="col-md-8">
                    <!-- Professional Summary -->
                    @if($parsedCv->summary)
                    <div class="card mb-3">
                        <div class="card-header">
                            <h5><i class="fas fa-file-alt me-2"></i>Professional Summary</h5>
                        </div>
                        <div class="card-body">
                            <p class="mb-0">{{ $parsedCv->summary }}</p>
                        </div>
                    </div>
                    @endif

                    <!-- Work Experience -->
                    @if(!empty($experience))
                    <div class="card mb-3">
                        <div class="card-header">
                            <h5><i class="fas fa-briefcase me-2"></i>Work Experience</h5>
                        </div>
                        <div class="card-body">
                            @foreach($experience as $index => $exp)
                            <div class="mb-4 {{ $index > 0 ? 'border-top pt-3' : '' }}">
                                <div class="row">
                                    <div class="col-md-8">
                                        <h6 class="mb-1">
                                            {{ $exp['job_title'] ?? $exp['formatted'] ?? 'Position not specified' }}
                                        </h6>
                                        <p class="text-primary mb-2">
                                            {{ $exp['organization'] ?? 'Company not specified' }}</p>
                                    </div>
                                    <div class="col-md-4 text-md-end">
                                        @if(isset($exp['dates']))
                                        <small class="text-muted">{{ $exp['dates'] }}</small>
                                        @endif
                                    </div>
                                </div>

                                @if(isset($exp['description']) && $exp['description'])
                                <div class="mt-2">
                                    <p class="mb-0">{{ $exp['description'] }}</p>
                                </div>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Education -->
                    @if(!empty($education))
                    <div class="card mb-3">
                        <div class="card-header">
                            <h5><i class="fas fa-graduation-cap me-2"></i>Education</h5>
                        </div>
                        <div class="card-body">
                            @foreach($education as $index => $edu)
                            <div class="mb-3 {{ $index > 0 ? 'border-top pt-3' : '' }}">
                                <div class="row">
                                    <div class="col-md-8">
                                        <h6 class="mb-1">
                                            {{ $edu['degree'] ?? $edu['formatted'] ?? 'Degree not specified' }}</h6>
                                        <p class="text-primary mb-0">
                                            {{ $edu['organization'] ?? 'Institution not specified' }}</p>
                                    </div>
                                    <div class="col-md-4 text-md-end">
                                        @if(isset($edu['dates']))
                                        <small class="text-muted">{{ $edu['dates'] }}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Certifications -->
                    @if(!empty($certifications))
                    <div class="card mb-3">
                        <div class="card-header">
                            <h5><i class="fas fa-certificate me-2"></i>Certifications</h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                @foreach($certifications as $cert)
                                <li class="list-group-item px-0 py-2">
                                    <i class="fas fa-award text-warning me-2"></i>
                                    {{ is_array($cert) ? ($cert['name'] ?? $cert) : $cert }}
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Right Column -->
                <div class="col-md-4">
                    <!-- Contact Information -->
                    <div class="card mb-3">
                        <div class="card-header">
                            <h6><i class="fas fa-address-card me-2"></i>Contact Information</h6>
                        </div>
                        <div class="card-body">
                            @if($parsedCv->email)
                            <div class="mb-2">
                                <i class="fas fa-envelope text-muted me-2"></i>
                                <a href="mailto:{{ $parsedCv->email }}">{{ $parsedCv->email }}</a>
                            </div>
                            @endif

                            @if($parsedCv->phone_number)
                            <div class="mb-2">
                                <i class="fas fa-phone text-muted me-2"></i>
                                <a href="tel:{{ $parsedCv->phone_number }}">{{ $parsedCv->phone_number }}</a>
                            </div>
                            @endif

                            @if($parsedCv->city || $parsedCv->area)
                            <div class="mb-2">
                                <i class="fas fa-map-marker-alt text-muted me-2"></i>
                                {{ $parsedCv->city ?? $parsedCv->area }}
                            </div>
                            @endif

                            @if($parsedCv->address_line_1)
                            <div class="mb-0">
                                <i class="fas fa-home text-muted me-2"></i>
                                {{ $parsedCv->address_line_1 }}
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Skills -->
                    @if(!empty($skills))
                    <div class="card mb-3">
                        <div class="card-header">
                            <h6><i class="fas fa-cogs me-2"></i>Skills ({{ count($skills) }})</h6>
                        </div>
                        <div class="card-body">
                            @foreach($skills as $skill)
                            <span class="badge bg-primary me-1 mb-2 p-2">{{ $skill }}</span>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Languages -->
                    @if(!empty($languages))
                    <div class="card mb-3">
                        <div class="card-header">
                            <h6><i class="fas fa-language me-2"></i>Languages</h6>
                        </div>
                        <div class="card-body">
                            @foreach($languages as $language)
                            <div class="mb-1">
                                <i class="fas fa-globe text-muted me-2"></i>
                                {{ is_array($language) ? ($language['name'] ?? $language) : $language }}
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Current Position -->
                    @if($parsedCv->position_title || $parsedCv->current_organization)
                    <div class="card mb-3">
                        <div class="card-header">
                            <h6><i class="fas fa-user-tie me-2"></i>Current Position</h6>
                        </div>
                        <div class="card-body">
                            @if($parsedCv->position_title)
                            <h6 class="mb-1">{{ $parsedCv->position_title }}</h6>
                            @endif
                            @if($parsedCv->current_organization)
                            <p class="text-primary mb-0">{{ $parsedCv->current_organization }}</p>
                            @endif
                        </div>
                    </div>
                    @endif

                    <!-- File Information -->
                    <div class="card">
                        <div class="card-header">
                            <h6><i class="fas fa-info-circle me-2"></i>File Information</h6>
                        </div>
                        <div class="card-body">
                            <small>
                                <div class="mb-1"><strong>File Name:</strong> {{ $parsedCv->file_name }}</div>
                                @if($parsedCv->file_size)
                                <div class="mb-1"><strong>File Size:</strong>
                                    {{ number_format($parsedCv->file_size / 1024, 2) }} KB</div>
                                @endif
                                <div class="mb-1"><strong>Parsed:</strong>
                                    {{ $parsedCv->created_at->format('M d, Y H:i') }}</div>
                                <div><strong>Status:</strong>
                                    <span class="badge bg-success">{{ $parsedCv->parsing_status ?? 'Completed' }}</span>
                                </div>
                            </small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Raw Data (Debug) -->
            @if(config('app.debug') && !empty($rawData))
            <div class="card mt-3">
                <div class="card-header">
                    <h6><i class="fas fa-code me-2"></i>Raw Parsed Data (Debug Mode)</h6>
                </div>
                <div class="card-body">
                    <pre
                        style="max-height: 400px; overflow-y: auto; font-size: 0.8em;">{{ json_encode($rawData, JSON_PRETTY_PRINT) }}</pre>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this CV record for
                <strong>{{ $parsedCv->candidate_name ?: 'Unknown Candidate' }}</strong>?
                <br><br>
                This action cannot be undone.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" onclick="deleteCv()">Delete</button>
            </div>
        </div>
    </div>
</div>

<script>
let deleteModal;

document.addEventListener('DOMContentLoaded', function() {
    deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
});

function confirmDelete() {
    deleteModal.show();
}

function deleteCv() {
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '{{ route("resume.destroy", $parsedCv->id) }}';

    const csrfToken = document.createElement('input');
    csrfToken.type = 'hidden';
    csrfToken.name = '_token';
    csrfToken.value = '{{ csrf_token() }}';
    form.appendChild(csrfToken);

    const methodField = document.createElement('input');
    methodField.type = 'hidden';
    methodField.name = '_method';
    methodField.value = 'DELETE';
    form.appendChild(methodField);

    document.body.appendChild(form);
    form.submit();
}

function exportToJson() {
    const data = {
        candidate_name: '{{ $parsedCv->candidate_name }}',
        email: '{{ $parsedCv->email }}',
        phone_number: '{{ $parsedCv->phone_number }}',
        skills: @json($skills),
        experience: @json($experience),
        education: @json($education),
        certifications: @json($certifications),
        summary: '{{ $parsedCv->summary }}',
        current_organization: '{{ $parsedCv->current_organization }}',
        position_title: '{{ $parsedCv->position_title }}',
        created_at: '{{ $parsedCv->created_at->toISOString() }}',
        raw_data: @json($rawData)
    };

    const dataStr = JSON.stringify(data, null, 2);
    const dataBlob = new Blob([dataStr], {
        type: 'application/json'
    });

    const link = document.createElement('a');
    link.href = URL.createObjectURL(dataBlob);
    link.download = '{{ $parsedCv->candidate_name ?: "cv_data" }}_{{ $parsedCv->id }}.json';
    link.click();
}
</script>

<style>
@media print {

    .btn,
    .modal,
    .card-header {
        display: none !important;
    }

    .card {
        border: none !important;
        box-shadow: none !important;
    }

    .container {
        max-width: none !important;
    }
}

.card {
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    border: none;
    margin-bottom: 1rem;
}

.badge {
    font-size: 0.8em;
}

.list-group-item {
    border-left: none;
    border-right: none;
}

.list-group-item:first-child {
    border-top: none;
}

.list-group-item:last-child {
    border-bottom: none;
}

pre {
    background-color: #f8f9fa;
    padding: 1rem;
    border-radius: 0.375rem;
    border: 1px solid #dee2e6;
}
</style>
@endsection