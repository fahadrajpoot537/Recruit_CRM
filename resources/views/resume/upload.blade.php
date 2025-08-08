@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Upload Resume</h2>
    @if($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif
    <form method="POST" action="{{ url('/upload-resume') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="resume">Choose Resume (PDF/DOCX)</label>
            <input type="file" name="resume" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary mt-2">Upload</button>
    </form>
</div>
@endsection
