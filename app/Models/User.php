<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Get the petugas profile associated with the user.
     */
    public function petugas()
    {
        return $this->hasOne(Petugas::class);
    }

    /**
     * Get the complaints made by the user.
     */
    public function complaints()
    {
        return $this->hasMany(Complaint::class);
    }

    /**
     * Get the total number of complaints made by the user.
     */
    public function getTotalComplaintsAttribute()
    {
        return $this->complaints()->count();
    }

    /**
     * Get the number of completed complaints for the user.
     */
    public function getCompletedComplaintsAttribute()
    {
        return $this->complaints()->where('status', 'completed')->count();
    }

    /**
     * Get the number of pending complaints for the user.
     */
    public function getPendingComplaintsAttribute()
    {
        return $this->complaints()->where('status', 'pending')->count();
    }

    /**
     * Get the number of processed complaints for the user.
     */
    public function getProcessedComplaintsAttribute()
    {
        return $this->complaints()->where('status', 'processed')->count();
    }

    /**
     * Get the average response time for user's complaints.
     */
    public function getAverageResponseTimeAttribute()
    {
        return $this->complaints()
            ->whereNotNull('processed_at')
            ->selectRaw('AVG(TIMESTAMPDIFF(HOUR, created_at, processed_at)) as avg_time')
            ->first()
            ->avg_time ?? 0;
    }
}
