<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlockedDate;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->integer('month', now()->month);
        $year  = $request->integer('year',  now()->year);

        // Clamp to reasonable range
        $current   = Carbon::createFromDate($year, $month, 1);
        $prevMonth = $current->copy()->subMonth();
        $nextMonth = $current->copy()->addMonth();

        // All blocked dates as Y-m-d strings for JS
        $blockedDates = BlockedDate::orderBy('date')
            ->get(['date', 'reason'])
            ->map(fn($b) => [
                'date'   => $b->date->format('Y-m-d'),
                'reason' => $b->reason,
            ]);

        // Group consecutive blocked dates into ranges for the list
        $blocks = BlockedDate::orderBy('date')->get();

        return view('admin.calendar', compact(
            'current', 'prevMonth', 'nextMonth', 'blockedDates', 'blocks'
        ));
    }

    public function block(Request $request)
    {
        $request->validate([
            'start'  => 'required|date',
            'end'    => 'required|date|after_or_equal:start',
            'reason' => 'nullable|string|max:200',
        ]);

        $period = CarbonPeriod::create($request->start, $request->end);
        foreach ($period as $date) {
            BlockedDate::firstOrCreate(
                ['date'   => $date->toDateString()],
                ['reason' => $request->reason]
            );
        }

        return back()->with('cal_success', 'Date bloccate con successo.');
    }

    public function unblock(BlockedDate $blockedDate)
    {
        $blockedDate->delete();
        return back()->with('cal_success', 'Data sbloccata.');
    }

    public function unblockRange(Request $request)
    {
        $request->validate([
            'start' => 'required|date',
            'end'   => 'required|date|after_or_equal:start',
        ]);

        BlockedDate::whereBetween('date', [$request->start, $request->end])->delete();

        return back()->with('cal_success', 'Periodo sbloccato con successo.');
    }
}
