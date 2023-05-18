@extends('layouts.app')
@section('content')
    <div class="container mt-2">
        <div class="d-flex justify-content-between mb-2">
            <div>
                <h3>Company</h3>
            </div>
            <div>
                <a class="btn btn-danger" href="{{ route('companies.index') }}"> Back</a>
            </div>
        </div>
        <div class="card p-3 mt-2">
            <div>
                <b>Name: </b> {{ $company->name }}
            </div>
            <div>
                <b>Email: </b> {{ $company->email }}
            </div>
        </div>
    </div>
@endsection
