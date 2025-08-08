@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Resume Parsed Successfully</h2>
    <pre>{{ json_encode($data, JSON_PRETTY_PRINT) }}</pre>
</div>
@endsection
