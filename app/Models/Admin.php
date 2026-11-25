<?php
namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $fillable = ['username', 'nama_lengkap', 'password', 'role', 'is_active', 'last_login_at'];
    protected $hidden = ['password'];
    protected $casts = ['is_active' => 'boolean', 'last_login_at' => 'datetime'];
    public function isSuperAdmin(): bool { return $this->role === 'super_admin'; }
}