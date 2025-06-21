<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Petugas extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nrp',
        'pangkat',
        'nama',
        'jabatan',
        'unit_kerja',
        'no_hp',
        'alamat',
        'foto',
    ];

    /**
     * Get the user that owns the petugas.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the complaints assigned to this petugas.
     */
    public function assignedComplaints()
    {
        return $this->hasMany(Complaint::class, 'assigned_petugas_id');
    }

    /**
     * Get the total number of complaints handled by this petugas.
     */
    public function getTotalComplaintsHandledAttribute()
    {
        return $this->assignedComplaints()->count();
    }

    /**
     * Get the number of completed complaints by this petugas.
     */
    public function getCompletedComplaintsAttribute()
    {
        return $this->assignedComplaints()->where('status', 'completed')->count();
    }

    /**
     * Get the completion rate of complaints by this petugas.
     */
    public function getCompletionRateAttribute()
    {
        $total = $this->total_complaints_handled;
        if ($total === 0) return 0;
        
        return ($this->completed_complaints / $total) * 100;
    }

    /**
     * Get the average response time for complaints by this petugas.
     */
    public function getAverageResponseTimeAttribute()
    {
        return $this->assignedComplaints()
            ->whereNotNull('processed_at')
            ->selectRaw('AVG(TIMESTAMPDIFF(HOUR, created_at, processed_at)) as avg_time')
            ->first()
            ->avg_time ?? 0;
    }
}
