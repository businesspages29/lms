@extends('layouts.app')
@section('content')
    <div class="container mt-2">
        <div class="d-flex justify-content-between mb-2">
            <div>
                <h3>
                    @if (request()->route()->getName() == 'users.create')
                        Add User
                    @else
                        Edit User
                    @endif
                </h3>
            </div>
            <div>
                <a class="btn btn-danger" href="{{ route('users.index') }}"> Back</a>
            </div>
        </div>
        @if (session('status'))
            <div class="alert alert-success mb-1 mt-1">
                {{ session('status') }}
            </div>
        @endif
        <div class="card p-3 mt-2">
            <form id="user-form"
                @if (request()->route()->getName() == 'users.create') action="{{ route('users.store') }}" 
                @else
                action="{{ route('users.update', $user->id) }}" @endif
                method="POST" enctype="multipart/form-data">
                @if (request()->route()->getName() != 'users.create')
                    @method('PUT')
                @endif
                @csrf
                <div class="row">
                    <x-forms.text-field label="Name" name="name"
                        value="{{ !empty($user->name) ? $user->name : old('name') }}" />
                    <x-forms.text-field label="Email " name="email"
                        value="{{ !empty($user->email) ? $user->email : old('email') }}" />
                    <x-forms.text-field label="Password " name="password" type="password" />
                </div>
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary ml-3">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('js')
    <script>
        if ($("#user-form").length > 0) {
            $("#user-form").validate({
                rules: {
                    'name': {
                        required: true,
                        maxlength: 15
                    },
                    'email': {
                        required: true,
                        maxlength: 15,
                        email: true
                    },
                    'password': {
                        required: false,
                        maxlength: 15,
                    },
                },
            })
        }
    </script>
@endpush
