<?php

namespace App\Http\Controllers;

use App\Models\MataPelajaran;
use App\Models\User;
use Illuminate\Http\Request;


class SearchController extends Controller
{
    public function user(Request $request)
    {
        $data =  User::where('name', 'like', '%' . $request->search . '%')->paginate(10);
        if ($request->search == '') {
            $data = User::paginate(10);
        }
        return view('admin.user.search', [
            'data' => $data
        ]);
    }

    public function mata_pelajaran(Request $request)
    {
        $data =  MataPelajaran::where('nama_pelajaran', 'like', '%' . $request->search . '%')->paginate(10);
        if ($request->search == '') {
            $data = MataPelajaran::paginate(10);
        }
        return view('admin.mata-pelajaran.search', [
            'data' => $data
        ]);
    }
}
