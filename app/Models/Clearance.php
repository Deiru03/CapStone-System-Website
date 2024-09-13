<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Clearance extends Model
{
    use HasFactory;

    // Fillable attributes for mass assignment
    protected $fillable = ['user_id', 'clearance_status', 'checked_by'];

    // Define the relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Get a user-friendly label for the clearance status
    public function getClearanceStatusLabelAttribute()
    {
        return ucfirst($this->clearance_status); // Capitalizes the first letter of the clearance status
    }

    // Scope to get pending clearances
    public function scopePending($query)
    {
        return $query->where('clearance_status', 'Pending');
    }
}
