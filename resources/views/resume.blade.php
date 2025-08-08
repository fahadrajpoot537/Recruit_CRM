@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Upload CV</div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('resume.upload') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="resume">Upload CV (PDF/DOC/DOCX)</label>
                            <input type="file" class="form-control-file" id="resume" name="resume" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Parse CV</button>
                    </form>

                    <!-- Add multiple file upload option -->
                    <hr>
                    <form action="{{ route('resume.upload.multiple') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="resumes">Upload Multiple CVs</label>
                            <input type="file" class="form-control-file" id="resumes" name="resumes[]" multiple required>
                        </div>
                        <button type="submit" class="btn btn-primary">Parse Multiple CVs</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Show parsed CVs if any -->
    @if(isset($parsedCvs) && $parsedCvs->count())
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">Parsed CVs</div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Skills</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($parsedCvs as $cv)
                            <tr>
                                <td>{{ $cv->candidate_name }}</td>
                                <td>{{ $cv->email }}</td>
                                <td>{{ $cv->phone_number }}</td>
                                <td>
                                    @foreach(json_decode($cv->skills) as $skill)
                                        <span class="badge badge-primary">{{ $skill }}</span>
                                    @endforeach
                                </td>
                                <td>
                                    <a href="{{ route('resume.view', $cv->id) }}" class="btn btn-sm btn-info">View</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection