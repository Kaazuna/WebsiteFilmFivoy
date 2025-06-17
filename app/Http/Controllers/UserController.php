<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function editProfile()
    {
        $user = User::findOrFail(session('user')['id']);
        return view('profile', compact('user'));
    }
    public function update(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'gender' => 'required',
            
        ]);

        $user = User::findOrFail(session('user')['id']);
        $user-> update($validated);

        session(['user' => $user->toArray()]);

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }
}

