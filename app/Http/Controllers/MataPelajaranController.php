<?php

namespace App\Http\Controllers;

use App\Models\MataPelajaran;
use App\Models\Tugas;
use Illuminate\Http\Request;

class MataPelajaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.mata-pelajaran.index',[
            'data' => MataPelajaran::paginate(10)
        ]);
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
            'nama_pelajaran' => 'required|unique:mata_pelajarans,nama_pelajaran'
        ]);

        MataPelajaran::create($validasi);

        return redirect()->back()->with('success','Anda berhasil menambahkan Mata Pelajaran');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $data = MataPelajaran::where('nama_pelajaran',$request->mata_pelajaran)->first();
       
    
        return view('mata-pelajaran.show',[
            'data' => Tugas::where('id_mata_pelajaran',$data->id)->get(),
            'pelajaran' => $data
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MataPelajaran $mataPelajaran)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MataPelajaran $mataPelajaran)
    {
        $validasi = $request->validate([
            'nama_pelajaran' => 'required'
        ]);

        MataPelajaran::where('id',$mataPelajaran->id)->update([
            'nama_pelajaran' => $request->nama_pelajaran
        ]);

        return redirect()->back()->with('success','Anda berhasil mengedit Mata Pelajaran');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MataPelajaran $mataPelajaran)
    {
        MataPelajaran::where('id',$mataPelajaran->id)->delete();

        return redirect()->back()->with('success','Anda berhasil menghapus Mata Pelajaran');
    }
}
