<div class="tab-content mt-7">
    <div class="tab-pane fade show active" id="job_notes" role="tabpanel">
        <div class="d-flex align-items-center justify-content-between mt-5 mb-2">
            <div class="title title-lg mb-0"><span>Notes ({{ $job->notes->count() }})</span></div>
            <a href="JavaScript:void(0);" class="btn btn-xs btn-icon btn-rounded btn-light"
                onclick="showNote('{{ $job->id }}')">
                <span class="icon"><span class="feather-icon"><i data-feather="plus"></i></span></span>
            </a>
        </div>

        @foreach ($job->notes as $note)
            <div class="card card-border note-block bg-black-light-5">
                <div class="card-body">
                    <div class="card-action-wrap">
                        <button
                            class="btn btn-xs btn-icon btn-flush-dark btn-rounded flush-soft-hover dropdown-toggle no-caret"
                            aria-expanded="false" data-bs-toggle="dropdown">
                            <span class="icon"><span class="feather-icon"><i
                                        data-feather="more-vertical"></i></span></span>
                        </button>
                        <div role="menu" class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="javascript:void(0);"
                                onclick="editNote('{{ $note->id }}')">
                                <span class="icon"><span class="feather-icon"><i
                                            data-feather="plus"></i></span></span>
                                Edit
                            </a>
                            <a class="dropdown-item" href="#">
                                <span class="icon"><span class="feather-icon"><i
                                            data-feather="trash-2"></i></span></span> Delete
                            </a>
                        </div>
                    </div>
                    <div class="media align-items-center">
                        <div class="media-head">
                            <div class="avatar avatar-xs avatar-rounded me-3 avatar-md">
                                <img src="{{ asset('dist/img/avatar3.jpg') }}" alt="user" class="avatar-img">
                            </div>
                        </div>
                        <div class="media-body">
                            <div>{{ $note->createdBy?->name }}</div>
                            <div>{{ $note->created_at->format('M d, Y, h:i A') }}</div>
                        </div>
                    </div>
                    <p>{{ $note->note }}</p>
                </div>
            </div>
        @endforeach

        <a href="#" class="btn btn-outline-light btn-block">View more</a>
    </div>
</div>
