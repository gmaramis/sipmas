<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\Petugas;
use Illuminate\Http\Request;

class PengaduanController extends Controller
{
    public function index(Request $request)
    {
        $complaints = Complaint::with(['user', 'assignedPetugas'])
            ->when($request->search, function($query, $search) {
                $query->where(function($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%")
                      ->orWhere('location', 'like', "%{$search}%")
                      ->orWhereHas('user', function($q) use ($search) {
                          $q->where('name', 'like', "%{$search}%");
                      });
                });
            })
            ->when($request->category, function($query, $category) {
                $query->where('category', $category);
            })
            ->when($request->status, function($query, $status) {
                $query->where('status', $status);
            })
            ->when($request->date, function($query, $date) {
                $query->whereDate('created_at', $date);
            })
            ->latest()
            ->paginate(10);

        // Get statistics for filters
        $categories = Complaint::distinct('category')->pluck('category');
        $statuses = ['pending', 'processed', 'completed', 'rejected'];
        
        return view('layouts.admin.pengaduan', compact('complaints', 'categories', 'statuses'));
    }

    public function show($id)
    {
        $complaint = Complaint::with(['user', 'assignedPetugas'])->findOrFail($id);
        $petugas = Petugas::all();
        return view('layouts.admin.detail-pengaduan', compact('complaint', 'petugas'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processed,completed,rejected',
            'admin_response' => 'nullable|string|max:1000',
            'petugas_id' => 'nullable|exists:petugas,id',
        ]);

        $complaint = Complaint::findOrFail($id);
        
        $updateData = [
            'status' => $request->status,
        ];

        if ($request->status === 'processed') {
            if ($request->petugas_id) {
                $updateData['assigned_petugas_id'] = $request->petugas_id;
            }
            if (!$complaint->processed_at) {
                $updateData['processed_at'] = now();
            }
        } elseif ($request->status === 'completed' && !$complaint->completed_at) {
            $updateData['completed_at'] = now();
        }

        if ($request->has('admin_response')) {
            $updateData['admin_response'] = $request->admin_response;
        }

        $complaint->update($updateData);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Status pengaduan berhasil diperbarui.'
            ]);
        }

        return back()->with('success', 'Status pengaduan berhasil diperbarui.');
    }

    public function assignPetugas(Request $request, $id)
    {
        $request->validate([
            'petugas_id' => 'required|exists:petugas,id'
        ]);

        $complaint = Complaint::findOrFail($id);
        $complaint->update([
            'assigned_petugas_id' => $request->petugas_id,
            'status' => 'processed',
            'processed_at' => now()
        ]);

        return back()->with('success', 'Petugas berhasil ditugaskan untuk menangani pengaduan ini.');
    }

    public function kategori()
    {
        return view('layouts.admin.pengaduan'); // Sementara redirect ke pengaduan
    }
} 