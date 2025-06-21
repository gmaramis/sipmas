<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\User;
use App\Models\Petugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatistikController extends Controller
{
    public function index()
    {
        // Overall statistics
        $totalComplaints = Complaint::count();
        $pendingComplaints = Complaint::where('status', 'pending')->count();
        $processedComplaints = Complaint::where('status', 'processed')->count();
        $completedComplaints = Complaint::where('status', 'completed')->count();
        $rejectedComplaints = Complaint::where('status', 'rejected')->count();

        // User statistics
        $totalUsers = User::role('user')->count();
        $totalPetugas = Petugas::count();

        // Category statistics
        $categoryStats = Complaint::selectRaw('category, COUNT(*) as count')
            ->groupBy('category')
            ->get();

        // Monthly statistics for current year
        $monthlyStats = Complaint::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Response time statistics
        $responseTimeStats = Complaint::whereNotNull('processed_at')
            ->selectRaw('
                CASE 
                    WHEN TIMESTAMPDIFF(HOUR, created_at, processed_at) < 1 THEN "< 1 jam"
                    WHEN TIMESTAMPDIFF(HOUR, created_at, processed_at) < 3 THEN "1-3 jam"
                    WHEN TIMESTAMPDIFF(HOUR, created_at, processed_at) < 6 THEN "3-6 jam"
                    WHEN TIMESTAMPDIFF(HOUR, created_at, processed_at) < 12 THEN "6-12 jam"
                    ELSE "> 12 jam"
                END as response_time,
                COUNT(*) as count
            ')
            ->groupBy('response_time')
            ->get();

        // Location statistics (based on most common locations)
        $locationStats = Complaint::selectRaw('location, COUNT(*) as count')
            ->groupBy('location')
            ->orderByDesc('count')
            ->limit(5)
            ->get();

        // Recent activity
        $recentComplaints = Complaint::with(['user', 'assignedPetugas'])
            ->latest()
            ->take(10)
            ->get();

        // Calculate growth percentages
        $lastMonthComplaints = Complaint::whereMonth('created_at', '=', now()->subMonth()->month)->count();
        $thisMonthComplaints = Complaint::whereMonth('created_at', '=', now()->month)->count();
        $complaintGrowth = $lastMonthComplaints > 0 
            ? (($thisMonthComplaints - $lastMonthComplaints) / $lastMonthComplaints) * 100 
            : 0;

        return view('layouts.admin.statistik', compact(
            'totalComplaints',
            'pendingComplaints',
            'processedComplaints',
            'completedComplaints',
            'rejectedComplaints',
            'totalUsers',
            'totalPetugas',
            'categoryStats',
            'monthlyStats',
            'responseTimeStats',
            'locationStats',
            'recentComplaints',
            'complaintGrowth'
        ));
    }
} 