<?php
namespace App\Http\Controllers;
use App\Models\Admin;
use App\Models\AuditLog;
use App\Services\AuditService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminManagementController extends Controller
{
    public function index() { return view('superadmin.admins', ['admins' => Admin::orderByRaw("FIELD(role, 'super_admin', 'admin')")->orderBy('username')->get()]); }

    public function store(Request $request)
    {
        $d = $request->validate(['username' => 'required|max:50|unique:admins,username', 'nama_lengkap' => 'required|max:100', 'password' => 'required|min:6', 'role' => 'required|in:admin,super_admin']);
        Admin::create(['username' => $d['username'], 'nama_lengkap' => $d['nama_lengkap'], 'password' => Hash::make($d['password']), 'role' => $d['role'], 'is_active' => true]);
        AuditService::log('TAMBAH_ADMIN', "Menambah {$d['role']}: {$d['username']}");
        return back()->with('success', "Akun {$d['username']} ditambahkan.");
    }

    public function toggleStatus(Admin $admin)
    {
        if ($admin->id === Auth::guard('admin')->id()) return back()->with('error', 'Tidak bisa mengubah akun sendiri.');
        $admin->update(['is_active' => !$admin->is_active]);
        AuditService::log('STATUS_ADMIN', "Ubah status {$admin->username}");
        return back()->with('success', 'Status akun diperbarui.');
    }

    public function changeRole(Request $request, Admin $admin)
    {
        if ($admin->id === Auth::guard('admin')->id()) return back()->with('error', 'Tidak bisa mengubah role sendiri.');
        $request->validate(['role' => 'required|in:admin,super_admin']);
        $admin->update(['role' => $request->role]);
        AuditService::log('UBAH_ROLE', "Ubah role {$admin->username} -> {$request->role}");
        return back()->with('success', 'Role diperbarui.');
    }

    public function destroy(Admin $admin)
    {
        if ($admin->id === Auth::guard('admin')->id()) return back()->with('error', 'Tidak bisa menghapus akun sendiri.');
        AuditService::log('HAPUS_ADMIN', "Hapus akun {$admin->username}");
        $admin->delete();
        return back()->with('success', 'Akun dihapus.');
    }

    public function audit() { return view('superadmin.audit', ['logs' => AuditLog::latest()->paginate(25)]); }

    public function backup()
    {
        AuditService::log('BACKUP_DB', 'Mengunduh backup database');
        $dump = collect(['admins', 'provinsi', 'kota_kabupaten', 'kecamatan', 'kelurahan_desa', 'warga', 'dokumen_identitas', 'audit_logs'])
            ->mapWithKeys(fn($t) => [$t => DB::table($t)->get()]);
        return response()->streamDownload(fn() => print($dump->toJson(JSON_PRETTY_PRINT)), 'backup-' . now()->format('Ymd-His') . '.json');
    }
}