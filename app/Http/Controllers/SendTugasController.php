<?php

namespace App\Http\Controllers;

use App\Models\Penilaian;
use App\Models\SendTugas;
use App\Models\Tugas;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class SendTugasController extends Controller
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
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validasi = $request->validate([
            'id_tugas' => 'required|numeric',
            'file' => 'required|file|mimes:pdf|max:4048',
        ]);

        $fileName = time() . '.' . $request->file->extension();
        $request->file->move('image/tugas', $fileName);

        SendTugas::create([
            'id_tugas' => $request->id_tugas,
            'file' => $fileName,
            'id_user' => auth()->user()->id
        ]);

        return redirect()->back()->with('success', 'Anda berhasil mengirimkan file tugas');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $item = SendTugas::select('send_tugas.id as id_send', 'tugas.*', 'users.*', 'send_tugas.file as file')->join('tugas', 'tugas.id', '=', 'send_tugas.id_tugas')->join('users', 'users.id', '=', 'send_tugas.id_user')->where('tugas.id', $request->send_tuga)->where('users.id', auth()->user()->id)->first();
        // dd($item);
        $data = Tugas::where('id', $request->send_tuga)->first();

        $status = null;
        if ($item) {

            $tanggal_deadline = $data->tanggal;
            $waktu_deadline = $data->waktu;


            $tanggal_waktu_deadline = $tanggal_deadline . ' ' . $waktu_deadline;
            // dd($data->created_at);

            $deadline = Carbon::parse($tanggal_waktu_deadline);

            $timestamp_deadline = $deadline->timestamp;
            $timestamp_kumpulan = strtotime($item->created_at);

            // dd($timestamp_deadline,$timestamp_kumpulan);
            if ($timestamp_kumpulan <= $timestamp_deadline) {
                $status = 'Tepat waktu';
            } else {
                $status = 'Terlambat';
            }
        }
        
        $nilai = null;
        if($item)
        {
            $nilai = Penilaian::where('id_send_tugas',$item->id_send)->first();
            
        }


        return view('mata-pelajaran.create', [
            'data' => $data,
            'item' => $item,
            'status' => $status,
            'nilai' => $nilai,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SendTugas $sendTugas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SendTugas $sendTugas)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $data = SendTugas::findOrFail($request->send_tuga);



        



        $filePath = public_path('image/tugas/' . $data->file);


        if (File::exists($filePath)) {
            File::delete($filePath);
        }

        $data->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus.');
    }
}
