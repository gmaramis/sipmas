<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Petugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class PetugasController extends Controller
{
    public function index(Request $request)
    {
        $petugas = Petugas::with('user')
            ->when($request->search, function($query, $search) {
                $query->where(function($q) use ($search) {
                    $q->where('nama', 'like', "%{$search}%")
                      ->orWhere('nrp', 'like', "%{$search}%")
                      ->orWhere('pangkat', 'like', "%{$search}%")
                      ->orWhere('jabatan', 'like', "%{$search}%")
                      ->orWhereHas('user', function($q) use ($search) {
                          $q->where('email', 'like', "%{$search}%");
                      });
                });
            })
            ->latest()
            ->paginate(10);

        return view('layouts.admin.petugas', compact('petugas'));
    }

    public function show($id)
    {
        $petugas = Petugas::with(['user', 'assignedComplaints'])->findOrFail($id);
        return view('layouts.admin.petugas.show', compact('petugas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'nrp' => 'required|string|unique:petugas,nrp',
            'pangkat' => 'required|string|max:50',
            'jabatan' => 'required|string|max:100',
            'unit_kerja' => 'required|string|max:100',
            'no_hp' => 'required|string|max:20',
            'alamat' => 'required|string|max:500',
            'password' => 'required|string|min:8|confirmed',
        ]);

        DB::beginTransaction();
        try {
            // Create user account
            $user = User::create([
                'name' => $request->nama,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // Assign petugas role
            $user->assignRole('petugas');

            // Create petugas profile
            $user->petugas()->create([
                'nrp' => $request->nrp,
                'pangkat' => $request->pangkat,
                'nama' => $request->nama,
                'jabatan' => $request->jabatan,
                'unit_kerja' => $request->unit_kerja,
                'no_hp' => $request->no_hp,
                'alamat' => $request->alamat,
            ]);

            DB::commit();
            return redirect()->route('admin.petugas')->with('success', 'Petugas berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan! ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $petugas = Petugas::findOrFail($id);
        
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $petugas->user_id,
            'nrp' => 'required|string|unique:petugas,nrp,' . $id,
            'pangkat' => 'required|string|max:50',
            'jabatan' => 'required|string|max:100',
            'unit_kerja' => 'required|string|max:100',
            'no_hp' => 'required|string|max:20',
            'alamat' => 'required|string|max:500',
        ]);

        DB::beginTransaction();
        try {
            // Update user account
            $petugas->user->update([
                'name' => $request->nama,
                'email' => $request->email,
            ]);

            // Update petugas profile
            $petugas->update([
                'nrp' => $request->nrp,
                'pangkat' => $request->pangkat,
                'nama' => $request->nama,
                'jabatan' => $request->jabatan,
                'unit_kerja' => $request->unit_kerja,
                'no_hp' => $request->no_hp,
                'alamat' => $request->alamat,
            ]);

            DB::commit();
            return back()->with('success', 'Data petugas berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan! ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $petugas = Petugas::findOrFail($id);
        
        // Check if petugas has assigned complaints
        if ($petugas->assignedComplaints()->exists()) {
            return back()->with('error', 'Petugas tidak dapat dihapus karena memiliki pengaduan yang ditugaskan!');
        }

        DB::beginTransaction();
        try {
            $user = $petugas->user;
            $petugas->delete();
            $user->delete();

            DB::commit();
            return redirect()->route('admin.petugas')->with('success', 'Petugas berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan! ' . $e->getMessage());
        }
    }
} 