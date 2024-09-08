<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\FacultyController;
use App\Models\User;

class ChecklistRequirement extends Model
{
    use HasFactory;
    
    protected $fillable = ['requirement_id', 'name', 'complied', 'not_complied', 'not_applicable'];

    public function requirement()
    {
        return $this->belongsTo(Requirement::class);
    }
}
