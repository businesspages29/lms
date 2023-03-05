@extends('layouts.app')
@section('content')
    <div class="container mt-2">
        <div class="d-flex justify-content-between mb-2">
            <div>
                <h3>
                    @if (request()->route()->getName() == 'roles.create')
                        Add Role
                    @else
                        Edit Role
                    @endif
                </h3>
            </div>
            <div>
                <a class="btn btn-danger" href="{{ route('roles.index') }}"> Back</a>
            </div>
        </div>
        @if (session('status'))
            <div class="alert alert-success mb-1 mt-1">
                {{ session('status') }}
            </div>
        @endif
        <div class="card p-3 mt-2">

            <form id="role-form"
                @if (request()->route()->getName() == 'roles.create') action="{{ route('roles.store') }}" 
                @else
                action="{{ route('roles.update', $role->id) }}" @endif
                method="POST" enctype="multipart/form-data">
                @if (request()->route()->getName() != 'roles.create')
                    @method('PUT')
                @endif
                @csrf
                <div class="row">
                    <x-forms.text-field label="Name" name="name"
                        value="{{ !empty($role->name) ? $role->name : old('name') }}" />
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
        if ($("#role-form").length > 0) {
            $("#role-form").validate({
                rules: {
                    'name': {
                        required: true,
                        maxlength: 10
                    },
                },
            })
        }
    </script>
@endpush
