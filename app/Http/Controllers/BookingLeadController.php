<?php

namespace App\Http\Controllers;

use App\Models\BookingLead;
use Illuminate\Http\Request;

class BookingLeadController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name'         => ['required', 'string', 'max:255'],
            'arrival'      => ['required', 'date'],
            'departure'    => ['required', 'date', 'after:arrival'],
            'guests'       => ['required', 'integer', 'min:1', 'max:20'],
            'arrival_time' => ['nullable', 'string', 'max:100'],
        ]);

        $arrival   = new \DateTime($request->arrival);
        $departure = new \DateTime($request->departure);
        $nights    = (int) $arrival->diff($departure)->days;

        BookingLead::create([
            'name'         => $request->name,
            'arrival'      => $request->arrival,
            'departure'    => $request->departure,
            'nights'       => $nights,
            'arrival_time' => $request->arrival_time,
            'guests'       => $request->guests,
            'ip_address'   => in_array($request->ip(), ['::1','0:0:0:0:0:0:0:1']) ? '127.0.0.1' : $request->ip(),
        ]);

        return response()->json(['ok' => true]);
    }
}
