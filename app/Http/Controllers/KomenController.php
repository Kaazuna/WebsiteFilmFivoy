<?php

namespace App\Http\Controllers;

use App\Models\Komen;
use Illuminate\Http\Request;
use App\Models\Film;

class KomenController extends Controller
{
    public function komen(Request $request, Film $film)
    {
        // harus login terlebih dahulu
        if(!session()->has('user')){
            return redirect()->route('login')->with('error', 'Harap login');
        }
        $validasi=[
            'komen' => 'required|string'
        ];
        
        $message_validasi = [
            'komen.string' => 'Komen harus berupa kalimat.'
        ];
        $request->validate($validasi, $message_validasi);
        $komentar           = new Komen();
        $komentar->user_id  = session('user')['id'];
        $komentar->film_id  = $film->id;
        $komentar->komen    = $request->komen;
        $komentar->save();
        
        return back()->with('success','komentar terkirim.');
    }

    public function editKomen(Request $request, $id)
    {
        // harus login terlebih dahulu
        if(!session()->has('user')){
            return redirect()->route('login')->with('error', 'Harap login');
        }

        $validasi=[
            'komen' => 'required|string'
        ];
        
        $message_validasi = [
            'komen.string' => 'Komen harus berupa kalimat.'
        ];
        $request->validate($validasi, $message_validasi);

        // Tidak bisa edit komen orang lain
        $komen = Komen::findOrFail($id);
        if($komen->user_id != session('user')['id']){
            return back()->with('error', 'Tidak bisa edit komen orang lain');
        }

        $komen->komen = $request->komen;
        $komen->save();

        return back()->with('success', 'komentar diperbarui');
        
    }

    public function hapusKomen($id)
    {
        // harus login terlebih dahulu
        if(!session()->has('user')){
            return redirect()->route('login')->with('error', 'Harap login');
        }
        
        // Hanya bisa hapus komentar sendiri
        $komen = Komen::findOrFail($id);

        if(session('user')['role'] == 'admin'){
            $komen->delete();
            return back()->with('success', 'Komentar dihapus oleh admin');
        }

        if($komen->user_id != session('user')['id']){
            return back()->with('error', 'Tidak bisa menghapus komen orang lain');
        }
        

        $komen->delete();
        return back()->with('success', 'komentar berhasil dihapus.');

    }
    public function lapor($id)
    {
        // harus login terlebih dahulu
        if(!session()->has('user')){
            return redirect()->route('login')->with('error', 'Harap login');
        }

        $komen = Komen::findOrFail($id);
        
        // tidak bisa lapor komen sendri
        if($komen->user_id == session('user')['id']){
            return back()->with('success', 'Tidak bisa lapor komen sendiri');
        }
        
        // tidak bisa lapor komen admin
        if($komen->user->role == 'admin') {
            return back()->with('error', 'Tidak bisa lapor komen admin');
        }

        // tidak bisa lapor komen dua kali
        if($komen->lapor) {
            return back()->with('error', 'Komentar sudah pernah dilapaorkan');
        }
        $komen->lapor = true;
        $komen->save();
        return back()->with('success', 'komentar dilaporkan');
    }

    public function daftarLapor()
    {
        if(!session()->has('user') || session('user')['role'] !== 'admin'){
            return redirect()->route('login')->with('error', 'Hanya admin ');
        }

        $lapor = Komen::where('lapor', true)->with('user', 'film')->orderBy('created_at', 'desc')->get();
        return view('report', compact('lapor'));
    }

    public function hapusKomenLapor($id)
    {
        if(session('user')['role'] != 'admin'){
            return redirect()->route('login')->with('error', 'Akses ditolak');
        }

        $komen = Komen::findOrFail($id);
        $komen->delete();

        return back()->with('success', 'Komentar berhasil dihapus oleh admin');
    }

    public function abaikanLaporan($id)
    {
         if(session('user')['role'] != 'admin'){
            return redirect()->route('login')->with('error', 'Akses ditolak');
        }

        $komentar = Komen::findOrFail($id);
        $komentar->lapor = false;
        $komentar->save();

        return back()->with('success', 'Laporan ditolak');
    }
}
