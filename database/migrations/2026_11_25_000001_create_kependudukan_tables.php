<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('username', 50)->unique();
            $table->string('nama_lengkap', 100)->default('Administrator');
            $table->string('password');
            $table->enum('role', ['super_admin', 'admin'])->default('admin');
            $table->boolean('is_active')->default(true);
            $table->timestamp('last_login_at')->nullable();
            $table->timestamps();
        });

        foreach (['jenis_kelamin', 'agama', 'status_pernikahan', 'pendidikan_terakhir', 'pekerjaan', 'golongan_darah', 'provinsi'] as $tbl) {
            Schema::create($tbl, function (Blueprint $table) {
                $table->id();
                $table->string('nama', 100)->unique();
            });
        }

        Schema::create('kota_kabupaten', fn(Blueprint $t) => [$t->id(), $t->foreignId('provinsi_id')->constrained('provinsi')->cascadeOnDelete(), $t->string('nama', 100)]);
        Schema::create('kecamatan', fn(Blueprint $t) => [$t->id(), $t->foreignId('kota_id')->constrained('kota_kabupaten')->cascadeOnDelete(), $t->string('nama', 100)]);
        Schema::create('kelurahan_desa', fn(Blueprint $t) => [$t->id(), $t->foreignId('kecamatan_id')->constrained('kecamatan')->cascadeOnDelete(), $t->string('nama', 100)]);

        Schema::create('warga', function (Blueprint $table) {
            $table->id();
            $table->char('nik', 16)->unique();
            $table->string('nama', 100);
            $table->string('tempat_lahir', 100)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->foreignId('jenis_kelamin_id')->constrained('jenis_kelamin');
            $table->foreignId('agama_id')->constrained('agama');
            $table->foreignId('status_pernikahan_id')->nullable()->constrained('status_pernikahan')->nullOnDelete();
            $table->string('hubungan_keluarga', 50)->default('Anggota Keluarga');
            $table->foreignId('pendidikan_id')->nullable()->constrained('pendidikan_terakhir')->nullOnDelete();
            $table->foreignId('pekerjaan_id')->nullable()->constrained('pekerjaan')->nullOnDelete();
            $table->foreignId('golongan_darah_id')->nullable()->constrained('golongan_darah')->nullOnDelete();
            $table->text('alamat')->nullable();
            $table->string('rt_rw', 15)->nullable();
            $table->foreignId('kelurahan_id')->nullable()->constrained('kelurahan_desa')->nullOnDelete();
            $table->foreignId('kecamatan_id')->nullable()->constrained('kecamatan')->nullOnDelete();
            $table->foreignId('kota_id')->nullable()->constrained('kota_kabupaten')->nullOnDelete();
            $table->foreignId('provinsi_id')->nullable()->constrained('provinsi')->nullOnDelete();
            $table->boolean('meninggal')->default(false);
            $table->timestamps();
        });

        Schema::create('dokumen_identitas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('warga_id')->constrained('warga')->cascadeOnDelete();
            $table->string('jenis_dokumen', 20)->default('KK');
            $table->string('nomor_dokumen', 32)->index();
            $table->timestamps();
        });

        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')->nullable()->constrained('admins')->nullOnDelete();
            $table->string('username', 50)->nullable();
            $table->string('aksi', 50);
            $table->text('keterangan');
            $table->string('ip_address', 45)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        foreach (['audit_logs', 'dokumen_identitas', 'warga', 'kelurahan_desa', 'kecamatan', 'kota_kabupaten', 'provinsi', 'jenis_kelamin', 'agama', 'status_pernikahan', 'pendidikan_terakhir', 'pekerjaan', 'golongan_darah', 'admins'] as $tbl) {
            Schema::dropIfExists($tbl);
        }
    }
};