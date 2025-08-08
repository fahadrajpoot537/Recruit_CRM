@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0 text-uppercase text-white">
                        <i class="bi bi-building me-2"></i>
                        <b>{{ $company->name ?? 'Company Details' }}</b>
                    </h4>
                </div>

                <div class="card-body p-4">
                    <div class="row row-cols-1 row-cols-md-2 gy-4">

                        <div><strong>📞 Contact:</strong> <span class="ms-2">{{ $company->contact ?? 'N/A' }}</span>
                        </div>
                        <div><strong>✉️ Type:</strong> <span class="ms-2">{{ $company->type ?? 'N/A' }}</span></div>
                        <div><strong>✉️ Email:</strong> <span class="ms-2">{{ $company->email ?? 'N/A' }}</span></div>

                        <div><strong>🏷️ Postal Code:</strong> <span
                                class="ms-2">{{ $company->postal_code ?? 'N/A' }}</span></div>
                        <div><strong>📍 Address:</strong> <span class="ms-2">{{ $company->address ?? 'N/A' }}</span>
                        </div>

                        <div><strong>🏙️ City:</strong> <span class="ms-2">{{ $company->city ?? 'N/A' }}</span></div>
                        <div><strong>🌆 State:</strong> <span class="ms-2">{{ $company->state ?? 'N/A' }}</span></div>
                        <div><strong>🌍 Country:</strong> <span class="ms-2">{{ $company->country ?? 'N/A' }}</span>
                        </div>

                        <div><strong>👤 Contract Person:</strong> <span
                                class="ms-2">{{ $company->contractpname ?? 'N/A' }}</span></div>
                        <div><strong>🏢 Head Office:</strong> <span
                                class="ms-2">{{ $company->head_office ?? 'N/A' }}</span></div>
                        <div><strong>👥 No. of Employees:</strong> <span
                                class="ms-2">{{ $company->no_of_employes ?? 'N/A' }}</span></div>
                        <div><strong>🏬 No. of Offices:</strong> <span
                                class="ms-2">{{ $company->no_of_offices ?? 'N/A' }}</span></div>
                        <div><strong>🏭 Industry:</strong> <span class="ms-2">{{ $company->industry ?? 'N/A' }}</span>
                        </div>


                        @php
                        $socialLinks = [
                        '🌐 Facebook' => $company->facebook,
                        '🔗 LinkedIn' => $company->linkedln,
                        '📸 Instagram' => $company->instagram,
                        '🐦 Twitter' => $company->twitter,
                        ];
                        @endphp

                        @foreach ($socialLinks as $label => $url)
                        <div>
                            <strong>{{ $label }}:</strong>
                            @if (!empty($url))
                            <a href="{{ $url }}" target="_blank" class="ms-2 text-decoration-none">{{ $url }}</a>
                            @else
                            <span class="ms-2">N/A</span>
                            @endif
                        </div>
                        @endforeach
                    </div>
                    <div class="col-12 mt-4">
                        <strong>📝 Description:</strong>
                        <p class="ms-2 mt-1 mb-0">{{ $company->company_description ?? 'N/A' }}</p>
                    </div>
                </div>

                <div class="card-footer text-end">
                    @if ($company->creators->contains(Auth::id()))
                    <a href="{{ route('companies.edit', $company->id) }}" class="btn btn-primary me-2">
                        ✏️ Edit
                    </a>
                    @endif
                    <a href="{{ route('companies.index') }}" class="btn btn-outline-primary">← Back to List</a>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection