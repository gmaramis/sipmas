<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'assigned_petugas_id',
        'title',
        'description',
        'category',
        'location',
        'status',
        'photos',
        'processed_at',
        'completed_at',
        'rejected_at',
        'rejection_reason',
    ];

    protected $casts = [
        'photos' => 'array',
        'processed_at' => 'datetime',
        'completed_at' => 'datetime',
        'rejected_at' => 'datetime',
    ];

    /**
     * Get the user that owns the complaint.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the petugas assigned to handle this complaint.
     */
    public function assignedPetugas()
    {
        return $this->belongsTo(Petugas::class, 'assigned_petugas_id');
    }

    /**
     * Get the evidence photos URLs.
     */
    public function getEvidencePhotoUrlsAttribute()
    {
        if (!$this->photos) {
            return [];
        }
        
        return collect($this->photos)->map(function ($photo) {
            return asset('storage/' . $photo);
        })->toArray();
    }

    /**
     * Get the first evidence photo URL.
     */
    public function getFirstEvidencePhotoUrlAttribute()
    {
        if ($this->photos && count($this->photos) > 0) {
            return asset('storage/' . $this->photos[0]);
        }
        return null;
    }

    /**
     * Get the status label for display.
     */
    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'pending' => 'Menunggu',
            'processed' => 'Diproses',
            'completed' => 'Selesai',
            'rejected' => 'Ditolak',
            default => ucfirst($this->status),
        };
    }

    /**
     * Get the status badge class for display.
     */
    public function getStatusBadgeClassAttribute()
    {
        return match($this->status) {
            'pending' => 'bg-yellow-100 text-yellow-800',
            'processed' => 'bg-blue-100 text-blue-800',
            'completed' => 'bg-green-100 text-green-800',
            'rejected' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    /**
     * Get the response time in hours.
     */
    public function getResponseTimeAttribute()
    {
        if (!$this->processed_at) return null;
        
        return $this->processed_at->diffInHours($this->created_at);
    }

    /**
     * Get the completion time in hours.
     */
    public function getCompletionTimeAttribute()
    {
        if (!$this->completed_at) return null;
        
        return $this->completed_at->diffInHours($this->processed_at);
    }

    /**
     * Get the total handling time in hours.
     */
    public function getTotalHandlingTimeAttribute()
    {
        if (!$this->completed_at) return null;
        
        return $this->completed_at->diffInHours($this->created_at);
    }

    /**
     * Scope a query to only include complaints with a specific status.
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope a query to only include complaints from a specific category.
     */
    public function scopeCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Scope a query to only include complaints assigned to a specific petugas.
     */
    public function scopeAssignedTo($query, $petugasId)
    {
        return $query->where('assigned_petugas_id', $petugasId);
    }

    /**
     * Scope a query to only include complaints created within a date range.
     */
    public function scopeDateRange($query, $start, $end)
    {
        return $query->whereBetween('created_at', [$start, $end]);
    }
}
