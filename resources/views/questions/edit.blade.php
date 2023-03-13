@extends('layouts.app')
@section('content')
    <div class="container mt-2">
        <div class="d-flex justify-content-between mb-2">
            <div>
                <h3>
                    @if (request()->route()->getName() == 'questions.create')
                        Add Question
                    @else
                        Edit Question
                    @endif
                </h3>
            </div>
            <div>
                <a class="btn btn-danger" href="{{ route('questions.index') }}"> Back</a>
            </div>
        </div>
        @if (session('status'))
            <div class="alert alert-success mb-1 mt-1">
                {{ session('status') }}
            </div>
        @endif
        <div class="card p-3 mt-2">

            <form id="role-form"
                @if (request()->route()->getName() == 'questions.create') action="{{ route('questions.store') }}" 
                @else
                action="{{ route('questions.update', $question->id) }}" @endif
                method="POST" enctype="multipart/form-data">
                @if (request()->route()->getName() != 'questions.create')
                    @method('PUT')
                @endif
                @csrf
                <div class="row">
                    <x-forms.select-field label="User" name="user_id" :options="$users"
                        value="{{ !empty($user->user_id) ? $user->user_id : old('user_id') }}" />
                    <x-forms.text-field type="number" label="Timer in Seconds" name="timer"
                        value="{{ !empty($question->timer) ? $question->timer : old('timer') }}" />
                    <x-forms.text-field type="textarea" label="Content" name="content"
                        value="{{ !empty($question->content) ? $question->content : old('content') }}" />
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
