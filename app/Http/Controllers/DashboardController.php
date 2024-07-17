<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Demand;
use App\Models\Event;
use App\Models\EventPosition;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\DayRequests;
use App\Models\User;
use App\Models\Career;
use Auth;


class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        //Admin
        $totalUsers = User::count();
        $activeRequestsCount = DayRequests::where('status', 'Pending')->count();
        $totalLeaveRequests = DayRequests::count();
        $totalApplications = Career::count();
        $totalDemands = Demand::count();
        $activeDemandCount = Demand::where('status', 'pending')->count();
        $totalEvents = Event::count();

        //Personal

        $userLeaveRequestsCount = DayRequests::where('user_id', $user->id)->count();
        $userActiveLeaveRequestsCount = DayRequests::where('user_id', $user->id)
            ->where('status', 'Pending')
            ->count();
        $userLeaveDemandsCount = Demand::where('user_id', $user->id)->count();
        $userActiveLeaveDemandsCount = Demand::where('user_id', $user->id)
            ->where('status', 'pending')
            ->count();
        
    
        return view('dashboard', compact('totalUsers', 'activeRequestsCount', 'totalLeaveRequests', 'totalApplications', 'totalDemands', 'activeDemandCount', 'totalEvents', 'userLeaveRequestsCount', 'userActiveLeaveRequestsCount', 'userLeaveDemandsCount', 'userActiveLeaveDemandsCount'));
    }
}