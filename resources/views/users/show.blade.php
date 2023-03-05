@extends('layouts.app')
@section('content')
    <div class="container mt-2">
        <div class="d-flex justify-content-between mb-2">
            <div>
                <h3>Employee</h3>
            </div>
            <div>
                <a class="btn btn-danger" href="{{ route('users.index') }}"> Back</a>
            </div>
        </div>
        <div class="card p-3 mt-2">
            <div>
                <b>Name: </b> {{ $user->name }}
            </div>
            <div>
                <b>Email: </b> {{ $user->email }}
            </div>
            <div>
                <b>Phone: </b> {{ $user->phone_number }}
            </div>
            <div>
                <b>Role: </b> {{ $user->role->name }}
            </div>
            <div>
                <b>Status: </b> {{ $user->status_name }}
            </div>
        </div>
    @endsection
