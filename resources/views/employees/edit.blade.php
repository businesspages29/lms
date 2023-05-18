@extends('layouts.app')
@section('content')
    <div class="container mt-2">
        <div class="d-flex justify-content-between mb-2">
            <div>
                <h3>
                    @if (request()->route()->getName() == 'employees.create')
                        Add Employee
                    @else
                        Edit Employees
                    @endif
                </h3>
            </div>
            <div>
                <a class="btn btn-danger" href="{{ route('employees.index') }}"> Back</a>
            </div>
        </div>
        @if (session('status'))
            <div class="alert alert-success mb-1 mt-1">
                {{ session('status') }}
            </div>
        @endif
        <div class="card p-3 mt-2">
            <form id="user-form"
                @if (request()->route()->getName() == 'employees.create') action="{{ route('employees.store') }}" 
                @else
                action="{{ route('employees.update', $employee->id) }}" @endif
                method="POST" enctype="multipart/form-data">
                @if (request()->route()->getName() != 'employees.create')
                    @method('PUT')
                @endif
                @csrf
                <div class="row">
                    <x-forms.text-field label="First Name" name="first_name"
                        value="{{ !empty($employee->first_name) ? $employee->first_name : old('first_name') }}" />
                    <x-forms.text-field label="Last Name" name="last_name"
                        value="{{ !empty($employee->last_name) ? $employee->last_name : old('last_name') }}" />
                    <x-forms.text-field type="email" label="Email " name="email"
                        value="{{ !empty($employee->email) ? $employee->email : old('email') }}" />
                    <x-forms.text-field label="Phone " name="phone"
                        value="{{ !empty($employee->phone) ? $employee->phone : old('phone') }}" />
                    <x-forms.select-field label="Company" name="company_id" :options="$companies"
                        value="{{ !empty($employee->company_id) ? $employee->company_id : old('company_id') }}" />

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
                    'first_name': {
                        required: true,
                        maxlength: 15
                    },
                    'last_name': {
                        required: true,
                        maxlength: 15
                    },
                    'email': {
                        email: true
                    },
                    'phone': {
                        matches: "[0-9]+", // <-- no such method called "matches"!
                        minlength: 10,
                        maxlength: 10
                    },
                },
            })
        }
    </script>
@endpush
