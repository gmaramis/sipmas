<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PengaturanController extends Controller
{
    public function index()
    {
        return view('layouts.admin.pengaturan');
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }
        $user->save();

        return back()->with('success', 'Profil admin berhasil diperbarui!');
    }

    public function sistemUpdate(Request $request)
    {
        // Simpan pengaturan sistem ke file .env atau database sesuai kebutuhan
        // Contoh sederhana: simpan ke config('app') menggunakan env()
        $request->validate([
            'instansi' => 'required|string|max:255',
            'alamat' => 'required|string|max:500',
            'telepon' => 'required|string|max:50',
        ]);
        // Untuk demo, simpan ke session (seharusnya ke database atau file config)
        session([
            'instansi' => $request->instansi,
            'alamat' => $request->alamat,
            'telepon' => $request->telepon,
        ]);
        return back()->with('success', 'Pengaturan sistem berhasil diperbarui!');
    }
} 