<?php

namespace App\Models;

Use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // Added line as per colleague's instructions
        'user_type', // Added line
        'program', // Added line as 09/02/2024
        'units', // Added line as 09/08/2024
        'position', // Added line as 09/02/2024 //Status yan actually
        'clearance_status', // This column was added 09/13/2024
        'last_update', // This column was added 09/13/2024
        'checked_by', // This column was added 09/13/2024
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
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function clearance()
    {
        return $this->hasOne(Clearance::class); // Adjust based on your actual relationship
    }
}
