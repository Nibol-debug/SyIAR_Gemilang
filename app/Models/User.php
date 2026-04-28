<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
//use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role', 'branch_id'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    function isAdminCabang(): bool
    {
        return $this->role === 'admin_cabang';
    }

    function isInstruktur(): bool
    {
        return $this->role === 'instruktur';
    }

    function isManajemen(): bool
    {
        return $this->role === 'manajemen';
    }

    function isPeserta(): bool
    {
        return $this->role === 'peserta';
    }
}
