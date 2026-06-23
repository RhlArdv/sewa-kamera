<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role'])]
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

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isPelanggan(): bool
    {
        return $this->role === 'pelanggan';
    }

    public function carts(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Cart::class, 'user_id', 'id');
    }

    public function transactions(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Transaction::class, 'user_id', 'id');
    }

    public function pelunasans(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Pelunasan::class, 'user_id', 'id');
    }

    public function notifs(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Notif::class, 'user_id', 'id');
    }

    public function testimonis(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Testimoni::class, 'user_id', 'id');
    }
}