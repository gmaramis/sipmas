<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\Petugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PetugasController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $petugas = $user->petugas;
        
        // Get complaints assigned to this petugas
        $assignedComplaints = Complaint::where('assigned_petugas_id', $petugas->id)
            ->with(['user', 'assignedPetugas'])
            ->latest()
            ->take(5)
            ->get();
        
        // Statistics for assigned complaints
        $totalAssigned = Complaint::where('assigned_petugas_id', $petugas->id)->count();
        $pendingAssigned = Complaint::where('assigned_petugas_id', $petugas->id)
            ->where('status', 'pending')
            ->count();
        $processedAssigned = Complaint::where('assigned_petugas_id', $petugas->id)
            ->where('status', 'processed')
            ->count();
        $completedAssigned = Complaint::where('assigned_petugas_id', $petugas->id)
            ->where('status', 'completed')
            ->count();
        
        // Recent complaints (all complaints for overview)
        $recentComplaints = Complaint::with(['user', 'assignedPetugas'])
            ->latest()
            ->take(10)
            ->get();
        
        return view('layouts.petugas.dashboard', compact(
            'user',
            'petugas',
            'assignedComplaints',
            'totalAssigned',
            'pendingAssigned',
            'processedAssigned',
            'completedAssigned',
            'recentComplaints'
        ));
    }

    public function complaints()
    {
        $user = Auth::user();
        $petugas = $user->petugas;
        
        $complaints = Complaint::with(['user', 'assignedPetugas'])
            ->when(request('search'), function($query, $search) {
                $query->where('title', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%")
                      ->orWhere('location', 'like', "%{$search}%");
            })
            ->when(request('category'), function($query, $category) {
                $query->where('category', $category);
            })
            ->when(request('status'), function($query, $status) {
                $query->where('status', $status);
            })
            ->when(request('assigned'), function($query, $assigned) use ($petugas) {
                if ($assigned === 'me') {
                    $query->where('assigned_petugas_id', $petugas->id);
                } elseif ($assigned === 'unassigned') {
                    $query->whereNull('assigned_petugas_id');
                }
            })
            ->latest()
            ->paginate(15);
        
        return view('layouts.petugas.complaints.index', compact('complaints', 'user', 'petugas'));
    }

    public function showComplaint(Complaint $complaint)
    {
        $user = Auth::user();
        $petugas = $user->petugas;
        
        return view('layouts.petugas.complaints.show', compact('complaint', 'user', 'petugas'));
    }

    public function assignComplaint(Request $request, Complaint $complaint)
    {
        $user = Auth::user();
        $petugas = $user->petugas;
        
        $request->validate([
            'action' => 'required|in:assign,unassign',
        ]);
        
        if ($request->action === 'assign') {
            $complaint->update([
                'assigned_petugas_id' => $petugas->id,
                'status' => 'processed',
                'processed_at' => now(),
            ]);
            
            return back()->with('success', 'Pengaduan berhasil ditugaskan kepada Anda.');
        } else {
            $complaint->update([
                'assigned_petugas_id' => null,
                'status' => 'pending',
                'processed_at' => null,
            ]);
            
            return back()->with('success', 'Penugasan pengaduan berhasil dibatalkan.');
        }
    }

    public function updateComplaintStatus(Request $request, Complaint $complaint)
    {
        $request->validate([
            'status' => 'required|in:pending,processed,completed,rejected',
            'admin_response' => 'nullable|string|max:1000',
        ]);
        
        $updateData = [
            'status' => $request->status,
        ];
        
        if ($request->status === 'processed' && !$complaint->processed_at) {
            $updateData['processed_at'] = now();
        } elseif ($request->status === 'completed' && !$complaint->completed_at) {
            $updateData['completed_at'] = now();
        }
        
        if ($request->admin_response) {
            $updateData['admin_response'] = $request->admin_response;
        }
        
        $complaint->update($updateData);
        
        return back()->with('success', 'Status pengaduan berhasil diperbarui.');
    }

    public function statistics()
    {
        $user = Auth::user();
        $petugas = $user->petugas;
        
        // Overall statistics
        $totalComplaints = Complaint::count();
        $pendingComplaints = Complaint::where('status', 'pending')->count();
        $processedComplaints = Complaint::where('status', 'processed')->count();
        $completedComplaints = Complaint::where('status', 'completed')->count();
        $rejectedComplaints = Complaint::where('status', 'rejected')->count();
        
        // Assigned to this petugas
        $assignedToMe = Complaint::where('assigned_petugas_id', $petugas->id)->count();
        $pendingAssigned = Complaint::where('assigned_petugas_id', $petugas->id)
            ->where('status', 'pending')
            ->count();
        $processedAssigned = Complaint::where('assigned_petugas_id', $petugas->id)
            ->where('status', 'processed')
            ->count();
        $completedAssigned = Complaint::where('assigned_petugas_id', $petugas->id)
            ->where('status', 'completed')
            ->count();
        
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
        
        // Recent activity
        $recentActivity = Complaint::with(['user', 'assignedPetugas'])
            ->latest()
            ->take(10)
            ->get();
        
        return view('layouts.petugas.statistics', compact(
            'user',
            'petugas',
            'totalComplaints',
            'pendingComplaints',
            'processedComplaints',
            'completedComplaints',
            'rejectedComplaints',
            'assignedToMe',
            'pendingAssigned',
            'processedAssigned',
            'completedAssigned',
            'categoryStats',
            'monthlyStats',
            'recentActivity'
        ));
    }
} 