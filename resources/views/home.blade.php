@extends('layouts.front')
@section('content')
    <div class="container mt-2">
        <div class="d-flex justify-content-between mb-2">
            <div>
                <h3>{{ __('Dashboard') }}</h3>
            </div>
        </div>
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif
        <div class="card-body">
            {{-- {{ __('You are logged in!') }} --}}
            <div class="row">
                <div class="col-md-6">
                    <a href="{{ route('roles.index') }}">
                        <div class="card">
                            <div class="card-body">
                                <b>Role</b> {{ $data['roles_count'] }}
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-6">
                    <a href="{{ route('users.index') }}">
                        <div class="card">
                            <div class="card-body">
                                <b>Active User</b> {{ $data['users_count'] }}
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
