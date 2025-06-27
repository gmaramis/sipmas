<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        assert($user instanceof User);
        $complaints = $user->complaints()->latest()->take(5)->get();
        
        // Statistics
        $totalComplaints = $user->complaints()->count();
        $pendingComplaints = $user->complaints()->where('status', 'pending')->count();
        $processedComplaints = $user->complaints()->where('status', 'processed')->count();
        $completedComplaints = $user->complaints()->where('status', 'completed')->count();
        
        return view('layouts.user.dashboard', compact('user', 'complaints', 'totalComplaints', 'pendingComplaints', 'processedComplaints', 'completedComplaints'));
    }

    public function profile()
    {
        $user = Auth::user();
        assert($user instanceof User);
        return view('layouts.user.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        assert($user instanceof User);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();
        assert($user instanceof User);

        // Pastikan password diambil sebagai string
        $currentHashedPassword = (string) $user->password;
        
        if (!Hash::check($request->current_password, $currentHashedPassword)) {
            return back()->withErrors(['current_password' => 'Password saat ini tidak sesuai.']);
        }

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return back()->with('success', 'Password berhasil diperbarui!');
    }
} 