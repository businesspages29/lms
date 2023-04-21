@extends('layouts.app')
@section('content')
    <div class="container mt-2">
        <div class="d-flex justify-content-between mb-2">
            <div>
                <h3>Booking</h3>
            </div>
            <div>
                <a class="btn btn-danger" href="{{ route('bookings.index') }}"> Back</a>
            </div>
        </div>
        <div class="card p-3 mt-2">
            <div>
                <b>Name: </b> {{ $booking->name }}
            </div>
            <div>
                <b>Email: </b> {{ $booking->email }}
            </div>
            <div>
                <b>Date Time: </b> {{ $booking->date }} | {{ $booking->time }}
            </div>
            <div>
                <b>Time Slot: </b> {{ $booking->type }} | {{ $booking->slot }}
            </div>
        </div>
    </div>
@endsection
