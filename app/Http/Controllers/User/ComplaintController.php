<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ComplaintController extends Controller
{
    public function index()
    {
        $complaints = Auth::user()->complaints()->latest()->paginate(10);
        return view('layouts.user.complaints.index', compact('complaints'));
    }

    public function create()
    {
        return view('layouts.user.complaints.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|in:kriminal,lalu_lintas,narkoba,korupsi,lainnya',
            'location' => 'required|string|max:255',
            'evidence_photos.*' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Max 2MB per photo
            'evidence_photos' => 'required|array|min:1|max:5', // Min 1, Max 5 photos
        ]);

        // Handle multiple file uploads
        $photoPaths = [];
        if ($request->hasFile('evidence_photos')) {
            foreach ($request->file('evidence_photos') as $photo) {
                $photoPath = $photo->store('complaints/evidence', 'public');
                $photoPaths[] = $photoPath;
            }
        }

        // Create complaint
        $complaint = Auth::user()->complaints()->create([
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category,
            'location' => $request->location,
            'evidence_photos' => $photoPaths,
            'status' => 'pending',
        ]);

        return redirect()->route('user.complaints.index')
            ->with('success', 'Pengaduan berhasil diajukan! Kami akan segera memproses pengaduan Anda.');
    }

    public function show(Complaint $complaint)
    {
        // Ensure user can only view their own complaints
        if ($complaint->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('layouts.user.complaints.show', compact('complaint'));
    }

    public function edit(Complaint $complaint)
    {
        // Ensure user can only edit their own pending complaints
        if ($complaint->user_id !== Auth::id() || $complaint->status !== 'pending') {
            abort(403, 'Unauthorized action.');
        }

        return view('layouts.user.complaints.edit', compact('complaint'));
    }

    public function update(Request $request, Complaint $complaint)
    {
        // Ensure user can only update their own pending complaints
        if ($complaint->user_id !== Auth::id() || $complaint->status !== 'pending') {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|in:kriminal,lalu_lintas,narkoba,korupsi,lainnya',
            'location' => 'required|string|max:255',
            'evidence_photos.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'evidence_photos' => 'nullable|array|max:5',
        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category,
            'location' => $request->location,
        ];

        // Handle file uploads if new photos are provided
        if ($request->hasFile('evidence_photos')) {
            // Delete old photos if exist
            if ($complaint->evidence_photos) {
                foreach ($complaint->evidence_photos as $oldPhoto) {
                    Storage::disk('public')->delete($oldPhoto);
                }
            }
            
            $photoPaths = [];
            foreach ($request->file('evidence_photos') as $photo) {
                $photoPath = $photo->store('complaints/evidence', 'public');
                $photoPaths[] = $photoPath;
            }
            $data['evidence_photos'] = $photoPaths;
        }

        $complaint->update($data);

        return redirect()->route('user.complaints.index')
            ->with('success', 'Pengaduan berhasil diperbarui!');
    }

    public function destroy(Complaint $complaint)
    {
        // Ensure user can only delete their own pending complaints
        if ($complaint->user_id !== Auth::id() || $complaint->status !== 'pending') {
            abort(403, 'Unauthorized action.');
        }

        // Delete photos if exist
        if ($complaint->evidence_photos) {
            foreach ($complaint->evidence_photos as $photo) {
                Storage::disk('public')->delete($photo);
            }
        }

        $complaint->delete();

        return redirect()->route('user.complaints.index')
            ->with('success', 'Pengaduan berhasil dihapus!');
    }
} 