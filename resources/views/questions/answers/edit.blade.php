@extends('layouts.app')
@section('content')
    <div class="container mt-2">
        <div class="d-flex justify-content-between mb-2">
            <div>
                <h3>
                    @if (request()->route()->getName() == 'answers.create')
                        Add Answers
                    @else
                        Edit Answers
                    @endif
                </h3>
            </div>
            <div>
                <a class="btn btn-danger" href="{{ route('answers.index', $question->id) }}"> Back</a>
            </div>
        </div>
        @if (session('status'))
            <div class="alert alert-success mb-1 mt-1">
                {{ session('status') }}
            </div>
        @endif
        <div class="card p-3 mt-2">

            <form id="role-form"
                @if (request()->route()->getName() == 'answers.create') action="{{ route('answers.store', $question->id) }}" 
                @else
                action="{{ route('answers.update', $answer->id) }}" @endif
                method="POST" enctype="multipart/form-data">
                @if (request()->route()->getName() != 'answers.create')
                    @method('PUT')
                @endif
                @csrf
                <div class="row">
                    <input type="hidden" name="question_id" value="{{ $question->id }}">
                    <x-forms.text-field class="col-md-12" type="textarea" label="Content" name="content"
                        value="{{ !empty($answer->content) ? $answer->content : old('content') }}" />
                    <x-forms.select-field label="Correct" name="is_correct" :options="[
                        'false' => 'False',
                        'true' => 'True',
                    ]"
                        value="{{ !empty($answer->is_correct) ? $answer->is_correct : old('is_correct') }}" />
                </div>
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary ml-3">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('js')
    {{-- <script>
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
    </script> --}}
@endpush
