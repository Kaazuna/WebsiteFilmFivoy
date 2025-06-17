<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Film;
use App\Models\User;


class SukaController extends Controller
{
    public function suka(Film $film)
    {
        if(!session()->has('user')){
            return redirect()->route('login')->with('error', 'Harap login');
        }
        
        $session    = session('user')['id'];
        $user       = User::findOrFail($session);

        if (!$user->sukaFilm()->where('film_id',$film->id)->exists()){
            $user->sukaFilm()->attach($film->id);
        }
        return redirect()->back()->with('success', 'Berhasil like film');
        
    }

    public function filmKesukaan(){
        if(!session()->has('user')){
            return redirect()->route('login')->with('error', 'Harap login');
        }

        $session    = session('user')['id'];
        $user       = User::findOrFail($session);

        $films = $user->sukaFilm()->get();

        return view('favorites', compact('films'));
    }

    public function unlike($id)
    {
        $user = User::findOrFail(session('user')['id']);
        $user->sukaFilm()->detach($id);
        return redirect()->back()->with('success', 'Berhasil batal like film');
    }

    public function FilterSuka(Request $request)
    {
        $userId = session('user')['id'];

        $query = Film::whereHas('sukaFilm', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        });

        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $query->where('judul', 'like', '%' . $searchTerm . '%');
        }

        $films = $query->get();

        return view('favorites', compact('films'));
    }

}
