<?php

namespace App\Http\Controllers;

use App\Models\Tugas;
use Illuminate\Http\Request;

class TugasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // dd($request);
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
        $validasi = $request->validate([
            'title' => 'required',
            'deskripsi' => 'required|min:6',
            'tanggal' => 'required|date|after_or_equal:today',
            'waktu' => 'required|date_format:H:i'
        ]);

        $validasi['id_mata_pelajaran'] = $request->id_mata_pelajaran;

        Tugas::create($validasi);

        return redirect()->back()->with('success','Anda berhasil menambah Tugas');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tugas $tugas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tugas $tugas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tugas $tugas)
    {
        $validasi = $request->validate([
            'title' => 'required',
            'deskripsi' => 'required|min:6',
            'tanggal' => 'required|date|after_or_equal:today',
            'waktu' => 'required'
        ]);

        

        Tugas::where('id',$request->id)->update($validasi);

        return redirect()->back()->with('success','Anda berhasil mengedit Tugas');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        Tugas::where('id',$request->tuga)->delete();
        return redirect()->back()->with('success','Anda berhasil menghapus Tugas');
    }
}
