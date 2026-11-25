<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Warga extends Model
{
    protected $table = 'warga';
    protected $guarded = ['id'];
    protected $casts = ['meninggal' => 'boolean'];

    private function refBelongsTo(string $table, string $fk)
    {
        $instance = (new RefModel)->setTable($table);
        return $this->newBelongsTo($instance->newQuery(), $this, $fk, 'id', $table);
    }

    public function jenisKelamin() { return $this->refBelongsTo('jenis_kelamin', 'jenis_kelamin_id'); }
    public function agama() { return $this->refBelongsTo('agama', 'agama_id'); }
    public function statusPernikahan() { return $this->refBelongsTo('status_pernikahan', 'status_pernikahan_id'); }
    public function pendidikan() { return $this->refBelongsTo('pendidikan_terakhir', 'pendidikan_id'); }
    public function pekerjaan() { return $this->refBelongsTo('pekerjaan', 'pekerjaan_id'); }
    public function golonganDarah() { return $this->refBelongsTo('golongan_darah', 'golongan_darah_id'); }
    public function provinsi() { return $this->refBelongsTo('provinsi', 'provinsi_id'); }
    public function kota() { return $this->refBelongsTo('kota_kabupaten', 'kota_id'); }
    public function kecamatan() { return $this->refBelongsTo('kecamatan', 'kecamatan_id'); }
    public function kelurahan() { return $this->refBelongsTo('kelurahan_desa', 'kelurahan_id'); }

    public function dokumenIdentitas() { return $this->hasMany(DokumenIdentitas::class, 'warga_id'); }
    public function latestKk() { return $this->hasOne(DokumenIdentitas::class, 'warga_id')->where('jenis_dokumen', 'KK')->latestOfMany(); }
    public function getMaskedNikAttribute(): string { return str_repeat('•', 12) . substr((string) $this->nik, -4); }
}