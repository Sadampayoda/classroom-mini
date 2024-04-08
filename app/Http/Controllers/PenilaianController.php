<?php

namespace App\Http\Controllers;

use App\Models\{Tugas,Penilaian, SendTugas};
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class PenilaianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request);
        $validasi = $request->validate([
            'nilai' => 'required|numeric|between:0,100',
            'komentar' => 'max:100'
        ]);

        Penilaian::create([
            'nilai' => $validasi['nilai'],
            'komentar' => $validasi['komentar'],
            'id_send_tugas' => $request->id_send
        ]);

        return redirect()->back()->with('success', 'Anda berhasil Mengirimkan Penilaian');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $data = Tugas::where('id', $request->penilaian)->first();
        $penilaian = SendTugas::select('send_tugas.id as id_send','send_tugas.created_at as kirim', 'tugas.*', 'users.*', 'send_tugas.file as file')->join('tugas', 'tugas.id', '=', 'send_tugas.id_tugas')->join('users', 'users.id', '=', 'send_tugas.id_user')->where('tugas.id', $request->penilaian)->paginate(5);
        
        $penilaian->map(function ($penilaian) {
            $tanggal_deadline = $penilaian->tanggal;
            $waktu_deadline = $penilaian->waktu;


            $tanggal_waktu_deadline = $tanggal_deadline . ' ' . $waktu_deadline;

            $deadline = Carbon::parse($tanggal_waktu_deadline);

            $timestamp_deadline = $deadline->timestamp;
            $timestamp_kumpulan = strtotime($penilaian->kirim);

            // dd($timestamp_deadline,$timestamp_kumpulan);
            if ($timestamp_kumpulan <= $timestamp_deadline) {
                $penilaian->status = 'Tepat waktu';
            } else {
                $penilaian->status = 'Terlambat';
            }
            $cekPenilaian = Penilaian::where('id_send_tugas',$penilaian->id_send)->first();
            $penilaian->cekNilai = Null;
            if($cekPenilaian)
            {
                $penilaian->cekNilai = $cekPenilaian->nilai;
            }
            
        });
        // dd($penilaian);
        return view('guru.nilai.index',[
            'data' => $data,
            'penilaian' => $penilaian
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Penilaian $penilaian)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Penilaian $penilaian)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Penilaian $penilaian)
    {
        //
    }
}
