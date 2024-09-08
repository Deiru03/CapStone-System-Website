<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ChecklistRequirement;

class Requirement extends Model
{
    use HasFactory;

    protected $fillable = ['type', 'name'];

    public function checklistRequirements()
    {
        return $this->hasMany(ChecklistRequirement::class);
    }
}
