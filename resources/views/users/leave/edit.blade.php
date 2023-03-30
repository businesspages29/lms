@extends('layouts.app')
@section('content')
    @php
        $id = request()->route('id');
    @endphp
    <div class="container mt-2">
        <div class="d-flex justify-content-between mb-2">
            <div>
                <h3>
                    @if (request()->route()->getName() == 'leave.create')
                        Add Leave Master
                    @else
                        Edit Leave Master
                    @endif
                </h3>
            </div>
            <div>
                <a class="btn btn-danger"
                    href="{{ route('leave.index', [
                        'id' => $id,
                    ]) }}"> Back</a>
            </div>
        </div>
        @if (session('status'))
            <div class="alert alert-success mb-1 mt-1">
                {{ session('status') }}
            </div>
        @endif
        <div class="card p-3 mt-2">

            <form id="role-form"
                @if (request()->route()->getName() == 'leave.create') action="{{ route('leave.store', [
                    'id' => $id,
                ]) }}" 
                @else
                action="{{ route('leave-master.update', $role->id) }}" @endif
                method="POST" enctype="multipart/form-data">
                @if (request()->route()->getName() != 'leave.create')
                    @method('PUT')
                @endif
                @csrf
                <div class="row">
                    {{-- <x-forms.text-field label="Employee Code" name="employee_code"
                        value="{{ !empty($role->employee_code) ? $role->employee_code : old('employee_code') }}" /> --}}
                    <x-forms.select-field label="Leave Type" name="leave_master_id" :options="leave_option()"
                        value="{{ !empty($user->status) ? $user->status : old('status') }}" />
                    <x-forms.text-field type="date" label="From Date" name="from_date"
                        value="{{ !empty($role->from_date) ? $role->from_date : old('from_date') }}" />
                    <x-forms.text-field type="date" label="To Date" name="to_date"
                        value="{{ !empty($role->to_date) ? $role->to_date : old('to_date') }}" />
                    <x-forms.text-field type="textarea" label="Comment" name="comment"
                        value="{{ !empty($role->comment) ? $role->comment : old('comment') }}" />
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
