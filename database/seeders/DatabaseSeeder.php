<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $sqlDir = database_path('sql');
        $sqlFiles = [
            'install.sql',
            'upgrade_admin_security.sql',
            'upgrade_demo_family_roles.sql',
            'upgrade_demo_nik_consistency.sql',
            'upgrade_demo_records.sql',
        ];

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        foreach ($sqlFiles as $file) {
            $path = "{$sqlDir}/{$file}";
            if (!file_exists($path)) {
                continue;
            }

            $sql = file_get_contents($path);
            // Lewati statement ALTER TABLE dari file upgrade jika kolom sudah ada di install.sql
            $sql = preg_replace('/ALTER\s+TABLE\s+`?admin`?\s+ADD\s+COLUMN\s+`?must_change_password`?[^;]*;/i', '', $sql);

            if (trim($sql) !== '') {
                DB::unprepared($sql);
            }
        }

        // Pastikan kolom tambahan Laravel tersedia pada tabel admins
        if (Schema::hasTable('admins')) {
            if (!Schema::hasColumn('admins', 'nama_lengkap')) {
                DB::statement("ALTER TABLE admins ADD COLUMN nama_lengkap VARCHAR(100) NOT NULL DEFAULT 'Administrator' AFTER username");
            }
            if (!Schema::hasColumn('admins', 'role')) {
                DB::statement("ALTER TABLE admins ADD COLUMN role ENUM('super_admin', 'admin') NOT NULL DEFAULT 'admin' AFTER password");
            }
            if (!Schema::hasColumn('admins', 'is_active')) {
                DB::statement("ALTER TABLE admins ADD COLUMN is_active TINYINT(1) NOT NULL DEFAULT 1 AFTER role");
            }
            if (!Schema::hasColumn('admins', 'last_login_at')) {
                DB::statement("ALTER TABLE admins ADD COLUMN last_login_at TIMESTAMP NULL DEFAULT NULL AFTER is_active");
            }
            if (!Schema::hasColumn('admins', 'created_at')) {
                DB::statement("ALTER TABLE admins ADD COLUMN created_at TIMESTAMP NULL DEFAULT NULL");
                DB::statement("ALTER TABLE admins ADD COLUMN updated_at TIMESTAMP NULL DEFAULT NULL");
            }
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        Admin::updateOrCreate(
            ['username' => 'admin'],
            [
                'nama_lengkap' => 'Super Administrator',
                'password' => Hash::make('kelompok 2'),
                'role' => 'super_admin',
                'is_active' => true,
            ]
        );

        Admin::updateOrCreate(
            ['username' => 'operator'],
            [
                'nama_lengkap' => 'Admin Operator Kependudukan',
                'password' => Hash::make('operator123'),
                'role' => 'admin',
                'is_active' => true,
            ]
        );
    }
}