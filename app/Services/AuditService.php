<?php
namespace App\Services;
use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;

class AuditService
{
    public static function log(string $aksi, string $ket): void
    {
        $u = Auth::guard('admin')->user();
        AuditLog::create(['admin_id' => $u?->id, 'username' => $u?->username ?? 'system', 'aksi' => $aksi, 'keterangan' => $ket, 'ip_address' => request()->ip()]);
    }
}