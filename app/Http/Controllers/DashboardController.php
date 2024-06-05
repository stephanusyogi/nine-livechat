<?php

namespace App\Http\Controllers;

use App\Constants;
use App\Models\Administrator;
use App\Models\Event;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $admin = auth()->user();
        $url = '/';
        return view('admin.dashboard', compact(['admin', 'url']));
    }

    public function getAdminCount()
    {
        $basicCount = Administrator::where('type', 'basic')->count();
        $superCount = Administrator::where('type', 'super')->count();

        return response()->json([
            'basic' => $basicCount,
            'super' => $superCount,
        ]);
    }

    public function getEventCount()
    {
        $totalEvents = Event::count();
        $finishedEvents = Event::where('flag_started', 0)->count();
        $notStartedEvents = Event::whereNull('flag_started')->count();

        return response()->json([
            'total' => $totalEvents,
            'finished' => $finishedEvents,
            'not_started' => $notStartedEvents,
        ]);
    }

    public function getEventsByMonth()
    {

        $eventsByMonth = Event::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->keyBy('month')
            ->toArray();

        // Initialize an array with 0 counts for each month
        $monthlyCounts = array_fill(1, 12, 0);

        // Fill the counts from the query results
        foreach ($eventsByMonth as $month => $data) {
            $monthlyCounts[$month] = $data['count'];
        }

        return response()->json($monthlyCounts);
    }
}
