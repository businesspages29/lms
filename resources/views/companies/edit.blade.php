@extends('layouts.app')
@section('content')
    <div class="container mt-2">
        <div class="d-flex justify-content-between mb-2">
            <div>
                <h3>
                    @if (request()->route()->getName() == 'companies.create')
                        Add Company
                    @else
                        Edit Company
                    @endif
                </h3>
            </div>
            <div>
                <a class="btn btn-danger" href="{{ route('companies.index') }}"> Back</a>
            </div>
        </div>
        @if (session('status'))
            <div class="alert alert-success mb-1 mt-1">
                {{ session('status') }}
            </div>
        @endif
        <div class="card p-3 mt-2">
            <form id="user-form"
                @if (request()->route()->getName() == 'companies.create') action="{{ route('companies.store') }}" 
                @else
                action="{{ route('companies.update', $company->id) }}" @endif
                method="POST" enctype="multipart/form-data">
                @if (request()->route()->getName() != 'companies.create')
                    @method('PUT')
                @endif
                @csrf
                @if (!empty($company->logo_url))
                    <div class="row">
                        <img class="w-25 h-auto" src="{{ $company->logo_url }}" alt="">
                    </div>
                @endif
                <div class="row">
                    <x-forms.text-field type="file" label="logo" name="logo" />
                    <x-forms.text-field label="Name" name="name"
                        value="{{ !empty($company->name) ? $company->name : old('name') }}" />
                    <x-forms.text-field label="Email " name="email"
                        value="{{ !empty($company->email) ? $company->email : old('email') }}" />
                    <x-forms.text-field label="Website " name="website"
                        value="{{ !empty($company->website) ? $company->website : old('website') }}" />
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
                        required: false,
                        email: true
                    },
                },
            })
        }
    </script>
@endpush
