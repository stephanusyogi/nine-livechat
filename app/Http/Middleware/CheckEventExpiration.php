<?php

namespace App\Http\Middleware;

use App\Models\Event;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class CheckEventExpiration
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        date_default_timezone_set('Asia/Jakarta');
        $currentDateTime = Carbon::now();

        $events = Event::where('flag_expired', 1)->get();
        $statusForgetSession = false;
        foreach ($events as $event) {
            $eventEndDateTime = Carbon::createFromFormat('Y-m-d H:i:s', $event->date . ' ' . $event->time_end);

            // Check if the current date and time is past the event end date and time
            if ($currentDateTime->greaterThan($eventEndDateTime)) {
                // Update the flag_started to 0
                $event->flag_started = 0;
                $event->save();

                $statusForgetSession = true;
            }
        }

        if ($statusForgetSession) {
            Session::forget('senderName');
            Session::forget('randomStringSender');
        }

        return $next($request);
    }
}
