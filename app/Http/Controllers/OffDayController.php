<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\DayRequests;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class OffDayController extends Controller
{
    public function show(Request $request): View
{
    $query = DayRequests::query();
    $year = $request->input('year');
    $month = $request->input('month');
    $user = $request->input('user');
    
    if ($year) {
        $query->whereYear('start_date', $year);
    }

    if ($month) {
        $query->whereMonth('start_date', $month);
    }

    if ($user) {
        $query->where('user_id', $user);
    }

    $dayRequest = $query->get();
    $users = User::all();

    return view('admin.offday-list', compact('dayRequest', 'users'));
}


    public function addRequest()
    {
        $users = User::all();
        return view('personal.request-offday', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
        ]);

        $user = User::findOrFail(Auth::id());
        $daysRequested = $this->calculateBusinessDays($request->start_date, $request->end_date);

        if ($daysRequested > $user->offday) {
            return back()->withErrors([
                'error' => 'Mevcut izin günlerinizden daha fazla gün talebinde bulunamazsınız.
            Mevcut izin günleriniz: ' . $user->offday . ' gün.'
            ]);
        }

        DayRequests::create([
            'user_id' => Auth::id(),
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'daysRequested' => $daysRequested,
        ]);

        return redirect()->route('personal.request-offday')->with('success', 'İzin talebi başarıyla gönderildi.');
    }

    public function toggleApproved($id)
    {
        $dayRequest = DayRequests::findOrFail($id);

        $dayRequest->status = 'approved';
        $dayRequest->save();

        $user = $dayRequest->user;
        $daysRequested = $this->calculateBusinessDays($dayRequest->start_date, $dayRequest->end_date);

        $user->offday -= $daysRequested;
        $user->save();

        return redirect()->back()->with('status', 'İzin talebi başarıyla onaylandı.');
    }
    public function toggleRejected($id)
    {
        $dayRequest = DayRequests::findOrFail($id);

        $dayRequest->status = 'rejected';

        $dayRequest->save();

        return redirect()->back()->with('status', 'İzin talebi reddedildi.');
    }

    public function myRequests()
    {
        $user = Auth::user();
        $dayRequests = DayRequests::where('user_id', $user->id)->get();

        return view('personal.offday-status', compact('dayRequests'));
    }
    private function calculateBusinessDays($startDate, $endDate)
    {
        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);
        $days = $start->diffInDaysFiltered(function (Carbon $date) {
            return !$date->isWeekend();
        }, $end) + 1;
        return $days;
    }
}


