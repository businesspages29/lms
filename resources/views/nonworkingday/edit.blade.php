@extends('layouts.app')
@section('content')
    <div class="container mt-2">
        <div class="d-flex justify-content-between mb-2">
            <div>
                <h3>
                    @if (request()->route()->getName() == 'non-working-day.create')
                        Add non-working-day
                    @else
                        Edit non-working-day
                    @endif
                </h3>
            </div>
            <div>
                <a class="btn btn-danger" href="{{ route('non-working-day.index') }}"> Back</a>
            </div>
        </div>
        @if (session('status'))
            <div class="alert alert-success mb-1 mt-1">
                {{ session('status') }}
            </div>
        @endif
        <div class="card p-3 mt-2">

            <form id="role-form"
                @if (request()->route()->getName() == 'non-working-day.create') action="{{ route('non-working-day.store') }}" 
                @else
                action="{{ route('non-working-day.update', $role->id) }}" @endif
                method="POST" enctype="multipart/form-data">
                @if (request()->route()->getName() != 'non-working-day.create')
                    @method('PUT')
                @endif
                @csrf
                <div class="row">
                    <x-forms.text-field type="date" label="Date" name="date"
                        value="{{ !empty($role->date) ? $role->date : old('date') }}" />
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
