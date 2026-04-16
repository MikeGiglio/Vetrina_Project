<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlockedDate;
use App\Models\BookingLead;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;

class LeadsController extends Controller
{
    public function index()
    {
        $leads = BookingLead::latest()->paginate(20);

        return view('admin.leads', compact('leads'));
    }

    public function updateStatus(Request $request, BookingLead $lead)
    {
        $request->validate([
            'status' => ['required', 'in:new,contacted,confirmed,cancelled'],
        ]);

        $oldStatus = $lead->status;
        $newStatus = $request->status;

        $lead->update(['status' => $newStatus]);

        // Confermata → blocca le date nel calendario
        if ($newStatus === 'confirmed' && $oldStatus !== 'confirmed') {
            $period = CarbonPeriod::create($lead->arrival, $lead->departure);
            foreach ($period as $date) {
                BlockedDate::firstOrCreate(
                    ['date' => $date->toDateString()],
                    [
                        'reason'  => 'Prenotazione #' . $lead->id . ' — ' . $lead->name,
                        'lead_id' => $lead->id,
                    ]
                );
            }
            $message = 'Prenotazione confermata. Date bloccate nel calendario.';
        }

        // Passaggio da confermata a qualsiasi altro stato → libera le date
        elseif ($oldStatus === 'confirmed' && $newStatus !== 'confirmed') {
            BlockedDate::where('lead_id', $lead->id)->delete();
            $message = 'Stato aggiornato. Date liberate nel calendario.';
        }

        else {
            $message = 'Stato aggiornato.';
        }

        return redirect()->back()->with('success', $message);
    }

    public function destroy(BookingLead $lead)
    {
        BlockedDate::where('lead_id', $lead->id)->delete();
        $lead->delete();

        return redirect()->back()->with('success', 'Prenotazione eliminata.');
    }
}
