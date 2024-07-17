<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventPosition;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $userPosition = $user->position;

        // Get all events
        $events = Event::all();

        return view('auth.events', compact('events', 'userPosition'));
    }

    public function eventControl(Request $request)
    {
        $eventsQuery = Event::query();

        // Check if 'all' is selected
        if ($request->position !== 'all') {
            $eventsQuery->whereHas('positions', function ($query) use ($request) {
                $query->where('position', $request->position);
            });
        }

        $events = $eventsQuery->whereDate('start_time', '>=', $request->start)
            ->whereDate('finish_time', '<=', $request->end)
            ->get();

        // Convert events to JSON format
        $eventArray = [];
        foreach ($events as $event) {
            $eventArray[] = [
                'id' => $event->id,
                'title' => $event->title,
                'start' => $event->start_time->format('Y-m-d\TH:i:s'),
                'end' => $event->finish_time->format('Y-m-d\TH:i:s'),
                'content' => $event->content,
                'createdBy' => $event->user->name . ' ' . $event->user->surname,
                'status' => $event->status // Add this line to include status
            ];
        }

        return response()->json($eventArray);
    }

    public function createEvent(Request $request)
    {
        $event = new Event();
        $event->title = $request->input('title');
        $event->start_time = Carbon::parse($request->input('start'));
        $event->finish_time = Carbon::parse($request->input('end'));
        $event->content = $request->input('content');
        $event->user_id = Auth::id();
        $event->status = 0; // Default status when creating an event
        $event->save();

        $selectedPositions = $request->input('visible_to', []);
        foreach ($selectedPositions as $position) {
            $event->positions()->create(['position' => $position]);
        }

        $user = Auth::user();
        return response()->json([
            'event_id' => $event->id,
            'created_by' => $user->name,
            'status' => $event->status // Return status as well
        ]);
    }

    public function eventPositions($eventId)
    {
        $event = Event::findOrFail($eventId);
        $positions = $event->positions()->pluck('position')->toArray();

        return response()->json([
            'positions' => $positions
        ]);
    }

    public function destroy($id)
    {
        $event = Event::findOrFail($id);

        if ($event->user_id !== auth()->id()) {
            return response()->json(['message' => 'Bu etkinliği silme yetkiniz yok'], 403);
        }

        $event->delete();

        return response()->json(['message' => 'Etkinlik başarıyla silindi']);
    }

    public function updateStatus(Request $request, $id)
    {
        $status = $request->input('status') ? 1 : 0;

        $event = Event::find($id);
        if ($event) {
            $event->status = $status;
            $event->save();
            return response()->json(['success' => true, 'status' => $status]); // Return status in response
        }

        return response()->json(['success' => false], 404);
    }
    public function moveEvent(Request $request, $id)
{
    $event = Event::find($id);
    
    if (!$event) {
        return response()->json(['success' => false], 404);
    }

    // Yeni tarihi ayarla (sadece tarih kısmını al)
    $newDate = Carbon::parse($request->input('date'));
    $event->start_time = $newDate->copy()->setTime($event->start_time->hour, $event->start_time->minute);
    $event->finish_time = $newDate->copy()->setTime($event->finish_time->hour, $event->finish_time->minute);
    
    $event->save();

    return response()->json(['success' => true]);
}

}
