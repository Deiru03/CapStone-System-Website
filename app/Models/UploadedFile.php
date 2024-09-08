<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UploadedFile extends Model
{
    use HasFactory;
    
    protected $fillable = ['requirement_id', 'file_path'];

    public function requirement()
    {
        return $this->belongsTo(Requirement::class);
    }
}
