<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Film;
use App\Models\Genre;
use App\Models\User;

class TambahFilmController extends Controller
{
    public function manageAndSearch(Request $request)
    {
        $query = Film::query();

        if ($request->has('search') && $request->search != '') {
            $query->where('judul', 'like', '%' . $request->search . '%');
        }

        $films = $query->get();
        $genres = Genre::all();

        return view('managefilm', compact('films', 'genres'));
    }
    public function tambahFilm(Request $request)
    {
        $rule_validasi = [
            'judul'     => 'required',
            'foto'      => 'required|image|mimes:jpg,jpeg,png|max:1024',
            'deskripsi' => 'required',
            'views'     => 'required|integer',
            'genre'     => 'required|array',     
            'genre.*'   => 'exists:genres,id',    
        ];

        $message_validasi = [
            'foto.required' => 'foto harus di isi',            
            'foto.image'    => 'File harus berupa gambar.',
            'foto.mimes'    => 'Format gambar harus jpg, jpeg, atau png.',
            'foto.max'      => 'Ukuran foto tidak boleh lebih dari 1 MB.',

            'views.required'    => 'views harus diisi',
            'views.integer'     => 'views harus berupa angka',
            'deskripsi.required'=> 'deskripsi harus di isi',
            'judul.required'    => 'judul harus di isi',
            'genre.required'    => 'Genre harus dipilih minimal satu',
            'genre.array'       => 'Format genre tidak valid',
            'genre.*.exists'    => 'Genre yang dipilih tidak valid',
            
        ];

        $request->validate($rule_validasi , $message_validasi);
        // path foto
        $path =$request->file('foto')->store('foto', 'public');
        $film           = new Film();        
        $film->judul    = $request->judul;
        $film->foto     = $path;
        $film->deskripsi= $request->deskripsi;
        $film->views    = $request->views;

        $film->save();

        $film->genres()->sync($request->genre);
        return redirect()->route('get.tambah')->with('status', 'Berhasil tambah film!');
        
    }
    public function edit($id, $judul)
    {        
        $film      = Film::findOrFail($id);
        if ($film->judul !== $judul){
            return redirect()->route('get.edit', ['id'=>$id, 'judul'=> $film->judul]);
        }

        $films     = Film::with('genres')->latest()->get();        
        $genres    = Genre::all();
        return view('managefilm', compact( 'film','films','genres'));
    }
    public function edit_film(Request $request, $id){
        $rule_validasi = [
            'judul'     => 'required',
            'deskripsi' => 'required',
            'views'     => 'required|integer',
            'genre'     => 'required|array', 
            'genre.*'   => 'exists:genres,id',
        ];

        if ($request->hasFile('foto')) {
            $rule_validasi['foto'] = 'image|mimes:jpg,jpeg,png|max:1024';
        }

        $message_validasi = [
            'foto.required' => 'foto harus di isi',            
            'foto.image'    => 'File harus berupa gambar.',
            'foto.mimes'    => 'Format gambar harus jpg, jpeg, atau png.',
            'foto.max'      => 'Ukuran foto tidak boleh lebih dari 1 MB.',

            'views.required'    => 'views harus diisi',
            'views.integer'     => 'views harus berupa angka',
            'deskripsi.required'=> 'deskripsi harus di isi',
            'judul.required'    => 'judul harus di isi',
            'genre.required'    => 'Genre harus dipilih minimal satu',
            'genre.array'       => 'Format genre tidak valid',
            'genre.*' => 'integer|exists:genres,id',
            
        ];

        $request->validate($rule_validasi , $message_validasi);
                
        $film           = Film::findOrFail($id);        
        $film->judul    = $request->judul;        
        $film->deskripsi= $request->deskripsi;
        $film->views    = $request->views;

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('foto', 'public');
            $film->foto = $path;
        }
        $film->save();

        $film->genres()->sync($request->genre);        
        return redirect()->route('get.tambah')->with('status', 'Berhasil edit film!');

    }
    
    public function delete($id)
    {
        $delete_film = Film::findOrFail($id);
        
        $delete_film->delete();
        return back()->with('status', 'Berhasil hapus film');        
    }

    public function dashboardUser(Request $request)
    {
        $cari = $request->query('search');
        $idGenre = $request->query('genre_id');

        $genres = Genre::with('films')->get();

        if ($cari) {
            $films = Film::where('judul', 'like', "%{$cari}%")->get();        
        } elseif ($idGenre) {
            $films = Genre::findOrFail($idGenre)->films;
        } else {
            $films = Film::with('genres')->get();
        }

        return view('dashboard', ['films' => $films, 'genres' =>$genres]);
    }

    public function view($id)
    {
        $film = Film::with('genres')->findOrFail($id);
        $sudahSuka = false;
        if(session()->has('user')&& session('user')['role'] === 'user'){
            $user = User::findOrFail(session('user')['id']);
            $sudahSuka = $user->sukaFilm->contains($film->id);
        }
        return view('views', compact('film', 'sudahSuka'));
    }

    public function showAll(Request $request)
    {
        $search = $request->query('search');

        $query = Film::query();

        if (!empty($search)) {
            $query->where('judul', 'like', '%' . $search . '%');
        }

        $films = $query->latest()->get();
        $genres = Genre::all();

        return view('films.all-films', compact('films', 'genres'));
    }

    public function showByGenre(Request $request ,$id)
    {
        $genre = Genre::findOrFail($id);

        $search = $request->query('search');

        if ($search) {
            $films = $genre->films()->where('judul', 'like', '%' . $search . '%')->get();
        } else {
            $films = $genre->films;
        }

        return view('films.filmgenre', compact('genre', 'films'));
    }
}

