<?php

namespace App\Http\Controllers;

use App\Models\MataPelajaran;
use App\Models\Penilaian;
use App\Models\SendTugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.index', [
            'data' => MataPelajaran::all()
        ]);
    }

    public function login()
    {
        return view('dashboard.login');
    }

    public function authentication(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->route('dashboard.index');
        }

        return back()->with('error', 'Email dan Password anda salah');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function peringkat(Request $request)
    {
        $select = MataPelajaran::all();
        $data = null;
        $pelajaran = null;
        if ($request->select) {
            $data = Penilaian::join('send_tugas', 'send_tugas.id', '=', 'penilaians.id_send_tugas')
                ->join('tugas', 'tugas.id', '=', 'send_tugas.id_tugas')
                ->join('mata_pelajarans', 'mata_pelajarans.id', '=', 'tugas.id_mata_pelajaran')
                ->join('users', 'users.id', '=', 'send_tugas.id_user')
                ->where('mata_pelajarans.nama_pelajaran', $request->select)
                ->selectRaw('SUM(penilaians.nilai) / COUNT(send_tugas.id) AS nilai, users.name')
                ->groupBy('users.name')
                ->get();
            $pelajaran = $request->select;
        }

        return view('dashboard.peringkat', [
            'select' => $select,
            'nilai' => $data,
            'pelajaran' => $pelajaran
        ]);
    }

    public function tingkat()
    {
        $tugas = SendTugas::join('tugas', 'tugas.id', '=', 'send_tugas.id_tugas')
            ->join('mata_pelajarans', 'mata_pelajarans.id', '=', 'tugas.id_mata_pelajaran')
            ->join('users', 'users.id', '=', 'send_tugas.id_user')
            ->select('mata_pelajarans.nama_pelajaran',DB::raw('COUNT(send_tugas.id_user) as jumlah_tugas'))
            ->where('users.id', auth()->user()->id)
            ->groupBy('mata_pelajarans.nama_pelajaran')
            ->get();

        return view('dashboard.tingkat',[
            'tugas' => $tugas,
        ]);
        
    }
}
