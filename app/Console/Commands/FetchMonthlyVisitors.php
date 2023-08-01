<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\MonthlyVisitor;

class FetchMonthlyVisitors extends Command
{
    protected $signature = 'fetch:monthly-visitors';
    protected $description = 'Fetch monthly visitors from session and store in database';

    public function handle()
    {
        // Get the previous month's data
        $lastMonth = Carbon::now()->subMonth()->format('Y-m');
        $key = "visitors:$lastMonth";
        $sessionData = session($key, []);

        // Convert the session data to an array of unique visitors
        $uniqueVisitors = collect($sessionData)->unique('session_id')->values()->all();

        // Store the unique visitors in the database
        foreach ($uniqueVisitors as $visitor) {
            $monthlyVisitor = new MonthlyVisitor();
            $monthlyVisitor->session_id = $visitor['session_id'];
            $monthlyVisitor->ip_address = $visitor['ip_address'];
            $monthlyVisitor->user_agent = $visitor['user_agent'];
            $monthlyVisitor->created_at = $visitor['created_at'];
            $monthlyVisitor->save();
        }

        // Get the count of unique visitors for the previous month
        $monthlyUniqueVisitorsCount = count($uniqueVisitors);

        // Log the monthly unique visitors count
        // \Log::info("Monthly unique visitors count for $lastMonth: $monthlyUniqueVisitorsCount");
    }
}
