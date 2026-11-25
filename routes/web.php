<?php
use App\Http\Controllers\AdminManagementController;
use App\Http\Controllers\PublicPagesController;
use App\Http\Controllers\WargaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

Route::get('/', [WargaController::class, 'index'])->name('warga.index');
Route::get('/statistik', [PublicPagesController::class, 'stats'])->name('stats.index');
Route::get('/populasi', [PublicPagesController::class, 'populasi'])->name('populasi.index');
Route::get('/tentang', [PublicPagesController::class, 'about'])->name('about.index');
Route::get('/keluarga/{kk}', [WargaController::class, 'keluarga'])->name('keluarga.show');

Route::get('/login', fn() => view('auth.login'))->name('login');
Route::post('/login', function (Request $r) {
    $cred = $r->validate(['username' => 'required', 'password' => 'required']);
    if (Auth::guard('admin')->attempt(array_merge($cred, ['is_active' => true]))) {
        $r->session()->regenerate();
        Auth::guard('admin')->user()->update(['last_login_at' => now()]);
        return redirect()->route('warga.index')->with('success', 'Berhasil masuk.');
    }
    return back()->withInput()->withErrors(['username' => 'Login gagal atau akun nonaktif.']);
})->name('login.attempt');

Route::post('/logout', function (Request $r) {
    Auth::guard('admin')->logout();
    $r->session()->invalidate();
    $r->session()->regenerateToken();
    return redirect()->route('warga.index');
})->name('logout');

Route::middleware('admin.auth')->group(function () {
    Route::post('/warga', [WargaController::class, 'store'])->name('warga.store');
    Route::get('/warga/print', [WargaController::class, 'printReport'])->name('warga.print');
    Route::get('/warga/import', [WargaController::class, 'showImport'])->name('warga.import');
    Route::post('/warga/import', [WargaController::class, 'importCsv'])->name('warga.import.store');
    Route::get('/warga/{warga}', [WargaController::class, 'show'])->name('warga.show');
    Route::get('/warga/{warga}/edit', [WargaController::class, 'edit'])->name('warga.edit');
    Route::put('/warga/{warga}', [WargaController::class, 'update'])->name('warga.update');
    Route::delete('/warga/{warga}', [WargaController::class, 'destroy'])->name('warga.destroy');

    Route::get('/ganti-password', fn() => view('auth.change_password'))->name('password.change');
    Route::post('/ganti-password', function (Request $r) {
        $r->validate(['current_password' => 'required', 'password' => 'required|min:6|confirmed']);
        $admin = Auth::guard('admin')->user();
        if (!Hash::check($r->current_password, $admin->password)) return back()->withErrors(['current_password' => 'Password lama salah.']);
        $admin->update(['password' => Hash::make($r->password)]);
        return back()->with('success', 'Password diperbarui.');
    })->name('password.change.update');
});

Route::middleware(['admin.auth', 'super.admin'])->prefix('superadmin')->group(function () {
    Route::get('/admins', [AdminManagementController::class, 'index'])->name('admin.index');
    Route::post('/admins', [AdminManagementController::class, 'store'])->name('admin.store');
    Route::patch('/admins/{admin}/toggle', [AdminManagementController::class, 'toggleStatus'])->name('admin.toggle');
    Route::patch('/admins/{admin}/role', [AdminManagementController::class, 'changeRole'])->name('admin.role');
    Route::delete('/admins/{admin}', [AdminManagementController::class, 'destroy'])->name('admin.destroy');
    Route::get('/audit', [AdminManagementController::class, 'audit'])->name('audit.index');
    Route::get('/backup', [AdminManagementController::class, 'backup'])->name('backup.index');
    Route::patch('/warga/{warga}/toggle-meninggal', [WargaController::class, 'toggleMeninggal'])->name('warga.toggle-meninggal');
});