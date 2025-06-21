<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get user's complaints (pengaduan)
        $complaints = $user->complaints ?? collect(); // Assuming there's a complaints relationship
        
        // Count complaints by status
        $totalComplaints = $complaints->count();
        $pendingComplaints = $complaints->where('status', 'pending')->count();
        $processedComplaints = $complaints->where('status', 'processed')->count();
        $completedComplaints = $complaints->where('status', 'completed')->count();
        
        return view('layouts.user.dashboard', compact(
            'user',
            'complaints',
            'totalComplaints',
            'pendingComplaints',
            'processedComplaints',
            'completedComplaints'
        ));
    }
} 