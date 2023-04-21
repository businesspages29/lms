<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use Validator;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            return datatables()->of(Booking::select('*'))
                ->addColumn('action', 'bookings.action')
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('bookings.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('bookings.edit');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'type' => 'required',
            'slot' => 'required',
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
        ]);

        $input = $request->except('_token');
        $check = booking_slot_check($input['time']);
        $input['slot'] = "evening";
        if ($check) {
            $input['slot'] = "morning";
        }
        $validator->after(function ($validator) use ($input) {
            $halfcheck = Booking::whereDate('date', '=', $input['date'])->type('half')->exists();
            $fullcheck = Booking::whereDate('date', '=', $input['date'])->type('full')->exists();
            // dd($input,$halfcheck,$fullcheck);
            if($halfcheck){
                $booking = Booking::whereDate('date', '=', $input['date'])->type('half')->slot($input['slot'])->first();
                $morningcheck = Booking::whereDate('date', '=', $input['date'])->type('half')->slot('morning')->exists();
                $eveningcheck = Booking::whereDate('date', '=', $input['date'])->type('half')->slot('evening')->exists();
                if ($input['type'] == "full") {
                    $validator->errors()->add('type', 'Full day booking is not possible for this slot.');
                }else if($morningcheck && $eveningcheck){
                    $validator->errors()->add('date', 'Full day booking is please try anthor date.');
                }else if(!empty($booking)  && $booking->type != "full" && $booking->slot == $input['slot']){
                    $validator->errors()->add('slot', 'Another type of booking is already made for this slot. (Morning - 06:00 AM to 05:59 PM & Evening  - 06:00 PM to 05:59 AM)');
                }
            }else if($fullcheck){
                $validator->errors()->add('type', 'Full day booking is not possible for this slot.');
            }
        });
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)
                ->withInput();
        }
        $input['user_id'] = auth()->id();
        Booking::create($input);
        return redirect()->route('bookings.index')
            ->with('success', 'Booking has been created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $booking = Booking::findOrFail($id);
            return view('bookings.show', compact('booking'));
        } catch (\Exception $e) {
            abort(404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $booking = Booking::findOrFail($id);
            return view('bookings.edit', compact('booking'));
        } catch (\Exception $e) {
            abort(404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'type' => 'required',
            'slot' => 'required',
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
        ]);
        $input = $request->except('_token');
        $check = booking_slot_check($input['time']);
        $input['slot'] = "evening";
        if ($check) {
            $input['slot'] = "morning";
        }
        $validator->after(function ($validator) use ($input,$id) {
            $halfcheck = Booking::whereDate('date', '=', $input['date'])->type('half')->NotId($id)->exists();
            $fullcheck = Booking::whereDate('date', '=', $input['date'])->type('full')->NotId($id)->exists();
            if($halfcheck){
                $booking = Booking::whereDate('date', '=', $input['date'])->type('half')->slot($input['slot'])->NotId($id)->first();
                
                $morningcheck = Booking::whereDate('date', '=', $input['date'])->type('half')->slot('morning')->NotId($id)->exists();
                $eveningcheck = Booking::whereDate('date', '=', $input['date'])->type('half')->slot('evening')->NotId($id)->exists();
                if ($input['type'] == "full") {
                    $validator->errors()->add('type', 'Full day booking is not possible for this slot.');
                }else if($morningcheck && $eveningcheck){
                    $validator->errors()->add('date', 'Full day booking is please try anthor date.');
                }else if(!empty($booking)  && $booking->type != "full" && $booking->slot == $input['slot']){
                    $validator->errors()->add('slot', 'Another type of booking is already made for this slot. (Morning - 06:00 AM to 05:59 PM & Evening  - 06:00 PM to 05:59 AM)');
                }
            }else if($fullcheck){
                $validator->errors()->add('type', 'Full day booking is not possible for this slot.');
            }
        });
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)
                ->withInput();
        }
        $input['user_id'] = auth()->id();
        try {
            $booking = Booking::findOrFail($id);
            if ($booking) {
                $booking->update($input);
            }
            return redirect()->route('bookings.index')
                ->with('success', 'Booking Has Been updated successfully');
        } catch (\Exception $e) {
            abort(404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request) // string $id
    {
        $input = $request->only('id');
        $booking = Booking::where('id', $input['id']);
        if ($booking) {
            $booking->delete();
        }
        return Response()->json($booking);
    }
}
