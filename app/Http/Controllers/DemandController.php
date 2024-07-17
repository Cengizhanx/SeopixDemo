<?php

namespace App\Http\Controllers;

use App\Models\Demand;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Demand as DemandModel;


class DemandController extends Controller
{
    public function create()
    {
        $user = Auth::user();
        $demands = $user->demands()->latest()->get();
        return view('personal.demands', compact('demands'));
    }

    public function store(Request $request)
    {
        // Formdan gelen veriyi işle
        $requestData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            // Diğer gerekli alanlar
        ]);

        // Anonim checkbox kontrolü
        $anonymous = $request->has('anonymous') ? true : false;

        // Kullanıcı ID'sini al
        $userId = auth()->id();
        $userName = auth()->user()->name;

        $currentDateTime = Carbon::now('Europe/Istanbul');

        // İstek oluştur
        $demand = new Demand([
            'title' => $requestData['title'],
            'content' => $requestData['content'],
            'user_id' => $userId,
            'name' => $userName,
            'anonymous' => $anonymous,
            'created_at' => $currentDateTime,
            'updated_at' => $currentDateTime,
        ]);

        $demand->save();

        return redirect()->back()->with('success', 'İstek başarıyla gönderildi.');
    }

    public function index(Request $request)
    {
        // Admin için tüm istekleri al
        $demands = Demand::all();
        $sort_by = $request->query('sort_by', 'created_at'); // Default olarak created_at
        $sort_order = $request->query('sort_order', 'desc'); // Default olarak desc

        $demands = Demand::orderBy($sort_by, $sort_order)->get();

        return view('admin.demand-list', compact('demands', 'sort_by', 'sort_order'));
    }
    public function approve(Request $request, $id)
    {
        $demand = Demand::findOrFail($id);
        $demand->status = 'approved';
        $demand->response = $request->input('response');
        $demand->save();

        return redirect()->back()->with('success', 'İstek onaylandı ve yanıtlandı.');
    }

    public function reject(Request $request, $id)
    {
        $demand = Demand::findOrFail($id);
        $demand->status = 'rejected';
        $demand->response = $request->input('response');
        $demand->save();

        return redirect()->back()->with('success', 'İstek reddedildi ve yanıtlandı.');
    }

    public function delete(Demand $demand, $id)
    {
        $demand = Demand::findOrFail($id);
        $demand->delete();

        return redirect()->back()->with('success', 'İstek silindi.');
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'anonymous' => 'nullable|boolean'
        ]);

        $demand = Demand::where('id', $id)->where('user_id', auth()->id())->where('status', 'pending')->firstOrFail();

        $demand->update([
            'title' => $request->title,
            'content' => $request->content,
            'anonymous' => $request->anonymous ? 1 : 0
        ]);

        return redirect()->route('personal.demands')->with('success', 'İstek başarıyla güncellendi.');
    }

    public function demandFilter(Request $request)
    {
        $year = $request->input('year');
        $month = $request->input('month');
        $sender = $request->input('sender');
        $sort_by = $request->input('sort_by', 'created_at');
        $sort_order = $request->input('sort_order', 'asc');

        $query = Demand::query();

        if ($year) {
            $query->whereYear('created_at', $year);
        }

        if ($month) {
            $query->whereMonth('created_at', $month);
        }

        if ($sender) {
            $query->where('user_id', $sender);
        }

        $demands = $query->orderBy($sort_by, $sort_order)->get();
        $senders = User::all();

        return view('admin.demand-list', compact('demands', 'sort_order', 'senders'));
    }

}
