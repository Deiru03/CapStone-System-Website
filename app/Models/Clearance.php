<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Clearance extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'status', 'checked_by'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
