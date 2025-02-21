<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.user-manajement.index',[
            'data' => User::paginate(10),
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
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'foto' => 'image|mimes:jpeg,png,jpg,gif|max:2048', 
            'nim' => 'required',
            'role' => 'required'
        ]);

    
        if ($request->hasFile('foto')) {
            $fotoName = time() . '.' . $request->foto->extension();
            $request->foto->move('image/users', $fotoName);
            $validatedData['foto'] = $fotoName;
            
        }

        
        $validatedData['password'] = bcrypt($request->password);

        
        User::create($validatedData);

        
        return redirect()->route('user-manejement.index')->with('success', 'User berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'nim' => 'required',
            'foto' => 'image|mimes:jpeg,png,jpg,gif|max:2048', 
            'role' => 'required'
        ]);

        
        $user->name = $request->name;
        $user->email = $request->email;
        $user->nim = $request->nim;
        $user->role = $request->role;
        

        
        if ($request->hasFile('foto')) {
            
            if ($user->foto) {
                Storage::delete('public/users/' . $user->foto);
            }
            $fotoName = time() . '.' . $request->foto->extension();
            $request->foto->move('image/users', $fotoName);
            $user->foto = $fotoName;
        }

        
        $user->save();

        
        return redirect()->route('user-manejement.index')->with('success', 'Data pengguna berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = User::findOrFail($id);



        



        $filePath = public_path('image/tugas/' . $data->file);


        if (File::exists($filePath)) {
            File::delete($filePath);
        }

        $data->delete();
        
        return redirect()->route('user-manejement.index')->with('success', 'User berhasil dihapus.');
    }
}
