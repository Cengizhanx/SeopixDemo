<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function show(): View
    {
        $users = User::where('role', '!=', 'admin')
            ->orWhere('id', '!=', Auth::id())
            ->where('position', '!=', 'CEO')
            ->get();
        return view('admin.personal-list', compact('users'));
    }

    public function toggleRole($id)
    {
        $user = User::findOrFail($id);

        if ($user->role === 'admin') {
            $user->role = 'personal';
        } elseif ($user->role === 'personal') {
            $user->role = 'admin';
        }

        $user->save();

        return redirect()->back()->with('status', 'User role updated successfully!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->back()->with('status', 'User deleted successfully!');
    }
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.personal-edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->all());
        return redirect()->route('admin.personal-list')->with('success', 'Personel bilgileri güncellendi!');
    }
}
