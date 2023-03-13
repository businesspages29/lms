@extends('layouts.app')
@section('content')
    <div class="container mt-2">
        <div class="d-flex justify-content-between mb-2">
            <div>
                <h3>
                    Survey
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
            <form id="user-form" action="{{ route('survey.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    @foreach ($questions as $question)
                        <div class="question-start">
                            {{ $question->answerOptions }}
                            <x-forms.select-field label="{{ $question->content }}" name="{{ $question->id }}"
                                :options="[]" />
                        </div>
                    @endforeach

                </div>
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary ml-3">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection
