<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'phone',
        'email',
        'address',
        'age',
        'gender',
        'problems',
        'booking_date',
        'booking_time',
        'service_type',
        'notes',
        'status',
    ];

    protected $casts = [
        'booking_date' => 'date',
        'age'          => 'integer',
    ];

    // ── Relationships ──────────────────────────────

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ── Scopes ─────────────────────────────────────

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeAccepted($query)
    {
        return $query->where('status', 'accepted');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    // ── Accessors ──────────────────────────────────

    public function getFormattedDateAttribute(): string
    {
        return $this->booking_date->format('l, F d Y');
    }

    public function getFormattedTimeAttribute(): string
    {
        return \Carbon\Carbon::parse($this->booking_time)->format('h:i A');
    }

    public function getServiceLabelAttribute(): string
    {
        return ucfirst(str_replace('_', ' ', $this->service_type));
    }

    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'accepted' => 'Accepted',
            'rejected' => 'Rejected',
            default    => 'Pending',
        };
    }

    // ── Helpers ────────────────────────────────────

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isAccepted(): bool
    {
        return $this->status === 'accepted';
    }

    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }
}
