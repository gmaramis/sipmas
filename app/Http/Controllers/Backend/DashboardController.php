<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\User;
use App\Models\Petugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Check if user has admin role
        if ($user && method_exists($user, 'hasRole') && $user->hasRole('admin')) {
            // Get current month and previous month dates
            $now = Carbon::now();
            $currentMonthStart = $now->copy()->startOfMonth();
            $previousMonthStart = $now->copy()->subMonth()->startOfMonth();
            
            // Current month statistics
            $currentMonthComplaints = Complaint::where('created_at', '>=', $currentMonthStart)->count();
            $previousMonthComplaints = Complaint::whereBetween('created_at', [$previousMonthStart, $currentMonthStart])->count();
            
            // Calculate growth percentage
            $growthPercentage = $previousMonthComplaints > 0 
                ? (($currentMonthComplaints - $previousMonthComplaints) / $previousMonthComplaints) * 100 
                : 100;
            
            // Overall statistics
            $totalComplaints = Complaint::count();
            $completedComplaints = Complaint::where('status', 'completed')->count();
            $completionRate = $totalComplaints > 0 ? ($completedComplaints / $totalComplaints) * 100 : 0;
            
            $processingComplaints = Complaint::whereIn('status', ['pending', 'processed'])->count();
            $averageResponseTime = Complaint::whereNotNull('processed_at')
                ->selectRaw('AVG(TIMESTAMPDIFF(HOUR, created_at, processed_at)) as avg_response_time')
                ->first()
                ->avg_response_time ?? 0;
            
            // Recent complaints
            $recentComplaints = Complaint::with(['user', 'assignedPetugas'])
                ->latest()
                ->take(5)
                ->get();
            
            // Chart data - Monthly statistics for current year
            $monthlyStats = Complaint::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
                ->whereYear('created_at', date('Y'))
                ->groupBy('month')
                ->orderBy('month')
                ->get()
                ->mapWithKeys(function ($item) {
                    $monthNames = [
                        1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr',
                        5 => 'Mei', 6 => 'Jun', 7 => 'Jul', 8 => 'Ags',
                        9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'
                    ];
                    return [$monthNames[$item->month] => $item->count];
                });
            
            // Chart data - Category statistics
            $categoryStats = Complaint::selectRaw('category, COUNT(*) as count')
                ->groupBy('category')
                ->get()
                ->mapWithKeys(function ($item) {
                    return [$item->category => $item->count];
                });
            
            return view('layouts.admin.dashboard', compact(
                'totalComplaints',
                'currentMonthComplaints',
                'growthPercentage',
                'completedComplaints',
                'completionRate',
                'processingComplaints',
                'averageResponseTime',
                'recentComplaints',
                'monthlyStats',
                'categoryStats'
            ));
        }
        
        // Check if user has petugas role
        if ($user && method_exists($user, 'hasRole') && $user->hasRole('petugas')) {
            return view('layouts.petugas.dashboard');
        }
        
        // If no valid role, redirect to home
        return redirect()->route('home')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
} 