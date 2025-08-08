@extends('layouts.app')

@section('title', 'CV Parsing Results')

@section('content')
<div class="container mt-4">
    <!-- Summary Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h4 class="mb-1">
                                <i class="fas fa-check-circle me-2"></i>CV Parsing Complete
                            </h4>
                            <p class="mb-0">
                                Successfully processed {{ count($results) }} CV(s)
                                @if(!empty($errors))
                                with {{ count($errors) }} error(s)
                                @endif
                            </p>
                        </div>
                        <div class="col-md-4 text-md-end">
                            <div class="btn-group">
                                <button class="btn btn-light btn-sm" onclick="downloadAllJSON()">
                                    <i class="fas fa-download me-1"></i>Download All JSON
                                </button>
                                <a href="{{ route('cv.index') }}" class="btn btn-success btn-sm">
                                    <i class="fas fa-plus me-1"></i>Upload More CVs
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Error Summary -->
    @if(!empty($errors))
    <div class="row mb-4">
        <div class="col-12">
            <div class="alert alert-danger">
                <h6><i class="fas fa-exclamation-triangle me-1"></i>Processing Errors ({{ count($errors) }}):</h6>
                <ul class="mb-0">
                    @foreach($errors as $error)
                    <li><strong>{{ $error['file'] }}:</strong> {{ $error['error'] }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endif

    <!-- Results Overview Cards -->
    @if(count($results) > 1)
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Processing Overview</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-3">
                            <div class="bg-primary text-white p-3 rounded">
                                <h4>{{ count($results) }}</h4>
                                <small>CVs Processed</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="bg-success text-white p-3 rounded">
                                <h4>{{ collect($results)->filter(function($r) { return !empty($r['fields']['email']); })->count() }}
                                </h4>
                                <small>Emails Found</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="bg-info text-white p-3 rounded">
                                <h4>{{ collect($results)->filter(function($r) { return !empty($r['fields']['contact_number']); })->count() }}
                                </h4>
                                <small>Phone Numbers</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="bg-warning text-white p-3 rounded">
                                <h4>{{ collect($results)->sum(function($r) { return count($r['fields']['skills'] ?? []); }) }}
                                </h4>
                                <small>Total Skills</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Individual CV Results -->
    @foreach($results as $index => $result)
    @php
    $fields = $result['fields'];
    $cv = $result['cv'];
    $fileName = $result['file_name'];
    @endphp

    <div class="cv-result mb-4">
        <div class="card">
            <div class="card-header bg-light">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h5 class="mb-0">
                            <i class="fas fa-file-alt me-2 text-primary"></i>
                            {{ $fileName }}
                            @if(count($results) > 1)
                            <span class="badge bg-primary ms-2">{{ $index + 1 }}/{{ count($results) }}</span>
                            @endif
                        </h5>
                        @if(!empty($fields['first_name']) || !empty($fields['last_name']))
                        <small class="text-muted">
                            <i
                                class="fas fa-user me-1"></i>{{ trim(($fields['first_name'] ?? '') . ' ' . ($fields['last_name'] ?? '')) }}
                        </small>
                        @endif
                    </div>
                    <div class="col-md-4 text-md-end">
                        <div class="btn-group btn-group-sm">
                            <button class="btn btn-outline-primary" onclick="toggleDetails('cv-{{ $index }}')">
                                <i class="fas fa-eye me-1"></i>View Details
                            </button>
                            <button class="btn btn-outline-success"
                                onclick="downloadJSON({{ json_encode($fields) }}, '{{ $fileName }}')">
                                <i class="fas fa-download me-1"></i>JSON
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Summary -->
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <strong>Email:</strong><br>
                        <span class="text-muted">{{ $fields['email'] ?? 'Not found' }}</span>
                    </div>
                    <div class="col-md-3">
                        <strong>Phone:</strong><br>
                        <span class="text-muted">{{ $fields['contact_number'] ?? 'Not found' }}</span>
                    </div>
                    <div class="col-md-3">
                        <strong>Experience:</strong><br>
                        <span class="text-muted">{{ $fields['total_experience'] ?? 'Not specified' }}</span>
                    </div>
                    <div class="col-md-3">
                        <strong>Skills Found:</strong><br>
                        <span class="badge bg-secondary">{{ count($fields['skills'] ?? []) }} skills</span>
                    </div>
                </div>

                @if(!empty($fields['skills']))
                <div class="mt-3">
                    <strong>Key Skills:</strong><br>
                    @foreach(array_slice($fields['skills'], 0, 10) as $skill)
                    <span class="badge bg-light text-dark me-1 mb-1">{{ $skill }}</span>
                    @endforeach
                    @if(count($fields['skills']) > 10)
                    <span class="badge bg-info">+{{ count($fields['skills']) - 10 }} more</span>
                    @endif
                </div>
                @endif
            </div>

            <!-- Detailed Information (Collapsible) -->
            <div id="cv-{{ $index }}-details" class="collapse">
                <div class="card-body border-top">
                    <!-- Personal Information -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="border-bottom pb-2 text-primary">
                                <i class="fas fa-user me-1"></i>Personal Information
                            </h6>
                            <table class="table table-sm table-borderless">
                                <tr>
                                    <td width="40%"><strong>Candidate Ref:</strong></td>
                                    <td>{{ $cv->candidate_ref ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Full Name:</strong></td>
                                    <td>{{ trim(($fields['first_name'] ?? '') . ' ' . ($fields['last_name'] ?? '')) ?: 'Not found' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Email:</strong></td>
                                    <td>{{ $fields['email'] ?? 'Not found' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Phone:</strong></td>
                                    <td>{{ $fields['contact_number'] ?? 'Not found' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Gender:</strong></td>
                                    <td>{{ $fields['gender'] ?? 'Not specified' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Age:</strong></td>
                                    <td>{{ $fields['age'] ?? 'Not specified' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Nationality:</strong></td>
                                    <td>{{ $fields['nationality'] ?? 'Not specified' }}</td>
                                </tr>
                            </table>
                        </div>

                        <div class="col-md-6">
                            <h6 class="border-bottom pb-2 text-primary">
                                <i class="fas fa-map-marker-alt me-1"></i>Address Information
                            </h6>
                            <table class="table table-sm table-borderless">
                                <tr>
                                    <td width="40%"><strong>Address:</strong></td>
                                    <td>{{ $fields['address_line_1'] ?? 'Not found' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Area:</strong></td>
                                    <td>{{ $fields['area'] ?? 'Not found' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>City:</strong></td>
                                    <td>{{ $fields['city'] ?? 'Not found' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Post Code:</strong></td>
                                    <td>{{ $fields['full_post_code'] ?? 'Not found' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Right to Work:</strong></td>
                                    <td>
                                        <span class="badge bg-{{ $fields['right_to_work'] ? 'success' : 'secondary' }}">
                                            {{ $fields['right_to_work'] ? 'Yes' : 'Not specified' }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Driving License:</strong></td>
                                    <td>
                                        <span
                                            class="badge bg-{{ $fields['driving_license'] ? 'success' : 'secondary' }}">
                                            {{ $fields['driving_license'] ? 'Yes' : 'Not specified' }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Languages:</strong></td>
                                    <td>{{ $fields['languages_spoken'] ?? 'Not specified' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!-- Professional Information -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h6 class="border-bottom pb-2 text-primary">
                                <i class="fas fa-briefcase me-1"></i>Professional Information
                            </h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-sm table-borderless">
                                        <tr>
                                            <td width="40%"><strong>Current Organization:</strong></td>
                                            <td>{{ $fields['current_organization'] ?? 'Not specified' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Position Title:</strong></td>
                                            <td>{{ $fields['position_title'] ?? 'Not specified' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Total Experience:</strong></td>
                                            <td>{{ $fields['total_experience'] ?? 'Not specified' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Current Salary:</strong></td>
                                            <td>{{ $fields['current_salary'] ?? 'Not specified' }}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-sm table-borderless">
                                        <tr>
                                            <td width="40%"><strong>Salary Expectation:</strong></td>
                                            <td>{{ $fields['salary_expectation'] ?? 'Not specified' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Notice Period:</strong></td>
                                            <td>{{ $fields['notice_period_days'] ? $fields['notice_period_days'] . ' days' : 'Not specified' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Available From:</strong></td>
                                            <td>{{ $fields['available_from'] ?? 'Not specified' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Willing to Relocate:</strong></td>
                                            <td>
                                                <span
                                                    class="badge bg-{{ $fields['willing_to_relocate'] ? 'success' : 'secondary' }}">
                                                    {{ $fields['willing_to_relocate'] ? 'Yes' : 'Not specified' }}
                                                </span>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Social Profiles -->
                    @if($fields['linkedin'] || $fields['github'])
                    <div class="row mb-4">
                        <div class="col-12">
                            <h6 class="border-bottom pb-2 text-primary">
                                <i class="fas fa-share-alt me-1"></i>Social Profiles
                            </h6>
                            @if($fields['linkedin'])
                            <p><strong>LinkedIn:</strong> <a href="https://{{ $fields['linkedin'] }}" target="_blank"
                                    class="text-decoration-none">{{ $fields['linkedin'] }}</a></p>
                            @endif
                            @if($fields['github'])
                            <p><strong>GitHub:</strong> <a href="https://{{ $fields['github'] }}" target="_blank"
                                    class="text-decoration-none">{{ $fields['github'] }}</a></p>
                            @endif
                        </div>
                    </div>
                    @endif

                    <!-- Summary -->
                    @if($fields['summary'])
                    <div class="row mb-4">
                        <div class="col-12">
                            <h6 class="border-bottom pb-2 text-primary">
                                <i class="fas fa-quote-left me-1"></i>Summary/Profile
                            </h6>
                            <div class="bg-light p-3 rounded">{{ $fields['summary'] }}</div>
                        </div>
                    </div>
                    @endif

                    <!-- Skills -->
                    @if(!empty($fields['skills']))
                    <div class="row mb-4">
                        <div class="col-12">
                            <h6 class="border-bottom pb-2 text-primary">
                                <i class="fas fa-cogs me-1"></i>Skills ({{ count($fields['skills']) }})
                            </h6>
                            <div>
                                @foreach($fields['skills'] as $skill)
                                <span class="badge bg-primary me-1 mb-1">{{ $skill }}</span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Experience -->
                    @if(!empty($fields['experience']))
                    <div class="row mb-4">
                        <div class="col-12">
                            <h6 class="border-bottom pb-2 text-primary">
                                <i class="fas fa-briefcase me-1"></i>Work Experience
                            </h6>
                            @foreach($fields['experience'] as $index => $exp)
                            <div class="mb-3 p-3 bg-light rounded">
                                <h6 class="text-success">Experience {{ $index + 1 }}</h6>
                                <p class="mb-0">{{ $exp }}</p>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Education -->
                    @if(!empty($fields['education']))
                    <div class="row mb-4">
                        <div class="col-12">
                            <h6 class="border-bottom pb-2 text-primary">
                                <i class="fas fa-graduation-cap me-1"></i>Education
                            </h6>
                            @foreach($fields['education'] as $index => $edu)
                            <div class="mb-2 p-3 bg-light rounded">
                                <h6 class="text-info">Education {{ $index + 1 }}</h6>
                                <p class="mb-0">{{ $edu }}</p>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Certifications -->
                    @if(!empty($fields['certifications']))
                    <div class="row mb-4">
                        <div class="col-12">
                            <h6 class="border-bottom pb-2 text-primary">
                                <i class="fas fa-certificate me-1"></i>Certifications
                            </h6>
                            <ul class="list-group list-group-flush">
                                @foreach($fields['certifications'] as $cert)
                                <li class="list-group-item px-0">{{ $cert }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endforeach

    <!-- Bulk Actions -->
    @if(count($results) > 1)
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h6 class="mb-0"><i class="fas fa-tools me-1"></i>Bulk Actions</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <button class="btn btn-outline-primary w-100" onclick="expandAllDetails()">
                                <i class="fas fa-expand me-1"></i>Expand All Details
                            </button>
                        </div>
                        <div class="col-md-6">
                            <button class="btn btn-outline-secondary w-100" onclick="collapseAllDetails()">
                                <i class="fas fa-compress me-1"></i>Collapse All Details
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<script>
function downloadJSON(data, filename = 'cv_parsed_data') {
    const dataStr = "data:text/json;charset=utf-8," + encodeURIComponent(JSON.stringify(data, null, 2));
    const downloadElement = document.createElement('a');
    downloadElement.setAttribute("href", dataStr);
    downloadElement.setAttribute("download", filename.replace(/\.[^/.]+$/, "") + "_parsed.json");
    document.body.appendChild(downloadElement);
    downloadElement.click();
    document.body.removeChild(downloadElement);
}

function downloadAllJSON() {
    const allData = @json(array_map(function($result) {
        return $result['fields'];
    }, $results));
    const dataStr = "data:text/json;charset=utf-8," + encodeURIComponent(JSON.stringify(allData, null, 2));
    const downloadElement = document.createElement('a');
    downloadElement.setAttribute("href", dataStr);
    downloadElement.setAttribute("download", "bulk_cv_parsed_data.json");
    document.body.appendChild(downloadElement);
    downloadElement.click();
    document.body.removeChild(downloadElement);
}

function toggleDetails(cvId) {
    const detailsElement = document.getElementById(cvId + '-details');
    const button = event.target.closest('button');

    if (detailsElement.classList.contains('show')) {
        detailsElement.classList.remove('show');
        button.innerHTML = '<i class="fas fa-eye me-1"></i>View Details';
    } else {
        detailsElement.classList.add('show');
        button.innerHTML = '<i class="fas fa-eye-slash me-1"></i>Hide Details';
    }
}

function expandAllDetails() {
    @for($i = 0; $i < count($results); $i++)
    const details {
        {
            $i
        }
    } = document.getElementById('cv-{{ $i }}-details');
    if (details {
            {
                $i
            }
        }) {
        details {
            {
                $i
            }
        }.classList.add('show');
    }
    @endfor

    document.querySelectorAll('button[onclick^="toggleDetails"]').forEach(btn => {
        btn.innerHTML = '<i class="fas fa-eye-slash me-1"></i>Hide Details';
    });
}

function collapseAllDetails() {
    @for($i = 0; $i < count($results); $i++)
    const details {
        {
            $i
        }
    } = document.getElementById('cv-{{ $i }}-details');
    if (details {
            {
                $i
            }
        }) {
        details {
            {
                $i
            }
        }.classList.remove('show');
    }
    @endfor

    document.querySelectorAll('button[onclick^="toggleDetails"]').forEach(btn => {
        btn.innerHTML = '<i class="fas fa-eye me-1"></i>View Details';
    });
}

// Auto-expand if single CV
@if(count($results) === 1)
document.addEventListener('DOMContentLoaded', function() {
    const singleDetails = document.getElementById('cv-0-details');
    if (singleDetails) {
        singleDetails.classList.add('show');
        const button = document.querySelector('button[onclick="toggleDetails(\'cv-0\')"]');
        if (button) {
            button.innerHTML = '<i class="fas fa-eye-slash me-1"></i>Hide Details';
        }
    }
});
@endif
</script>

<style>
.cv-result {
    border-left: 4px solid #007bff;
}

.cv-result:hover {
    box-shadow: 0 4px 8px rgba(0, 123, 255, 0.15);
    transition: box-shadow 0.3s ease;
}

.collapse.show {
    display: block !important;
}

.badge {
    font-size: 0.8em;
}

.bg-light {
    background-color: #f8f9fa !important;
}

.table-borderless td {
    border: none;
    padding: 0.25rem 0;
}

.list-group-item {
    background-color: transparent;
    border-color: #dee2e6;
}
</style>
@endsection