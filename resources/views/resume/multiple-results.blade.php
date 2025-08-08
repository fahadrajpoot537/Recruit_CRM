@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h2>Multiple CV Parsing Results</h2>
            
            @if(!empty($errors))
            <div class="alert alert-danger">
                <h4>Errors</h4>
                <ul>
                    @foreach($errors as $error)
                        <li><strong>{{ $error['file'] }}</strong>: {{ $error['error'] }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="card">
                <div class="card-header">
                    Successfully Parsed CVs ({{ count($results) }})
                </div>
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
                            @foreach($results as $cv)
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
</div>
@endsection