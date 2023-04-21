@extends('layouts.app')
@section('content')
    <div class="container mt-2">
        <div class="d-flex justify-content-between mb-2">
            <div>
                <h3>
                    @if (request()->route()->getName() == 'bookings.create')
                        Add Booking
                    @else
                        Edit Booking
                    @endif
                </h3>
            </div>
            <div>
                <a class="btn btn-danger" href="{{ route('bookings.index') }}"> Back</a>
            </div>
        </div>
        @if (session('status'))
            <div class="alert alert-success mb-1 mt-1">
                {{ session('status') }}
            </div>
        @endif
        <div class="card p-3 mt-2">

            <form id="booking-form"
                @if (request()->route()->getName() == 'bookings.create') action="{{ route('bookings.store') }}" 
                @else
                action="{{ route('bookings.update', $booking->id) }}" @endif
                method="POST" enctype="multipart/form-data">
                @if (request()->route()->getName() != 'bookings.create')
                    @method('PUT')
                @endif
                @csrf
                <div class="row">
                    <x-forms.text-field label="Name" name="name"
                        value="{{ !empty($booking->name) ? $booking->name : old('name') }}" />
                    <x-forms.text-field type="email" label="Email" name="email"
                        value="{{ !empty($booking->email) ? $booking->email : old('email') }}" />
                    <x-forms.select-field label="Type" name="type" :options="booking_type_option()"
                        value="{{ !empty($booking->type) ? $booking->type : old('type') }}" />
                    <x-forms.select-field label="Slot" name="slot" :options="booking_slot_option()"
                        value="{{ !empty($booking->slot) ? $booking->slot : old('slot') }}" />
                    <x-forms.text-field type="date" label="Date" name="date"
                        value="{{ !empty($booking->date) ? $booking->date : old('date') }}" />
                    <x-forms.text-field type="time" label="Time" name="time"
                        value="{{ !empty($booking->time) ? date('H:i', strtotime($booking->time)) : old('time') }}" />
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
        if ($("#booking-form").length > 0) {
            $("#booking-form").validate({
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
