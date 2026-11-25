<form method="POST" action="{{ route('warga.store') }}" id="formTambah" class="card form-panel" style="{{ $errors->any() ? '' : 'display:none;' }}">
  @csrf
  <div class="form-section">
    <h3>Identitas Dasar</h3>
    <div class="form-grid">
      <div class="form-field"><label>NIK (16 digit)</label><input name="nik" value="{{ old('nik') }}" required maxlength="16" pattern="[0-9]{16}"></div>
      <div class="form-field"><label>Nama lengkap</label><input name="nama" value="{{ old('nama') }}" required></div>
      <div class="form-field"><label>Tempat lahir</label><input name="tempat_lahir" value="{{ old('tempat_lahir') }}"></div>
      <div class="form-field"><label>Tanggal lahir</label><input name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" type="date"></div>
      <div class="form-field"><label>Jenis kelamin</label>
        <select name="jenis_kelamin_id" required><option value="">Pilih</option>@foreach($jenisKelamins as $r)<option value="{{ $r->id }}" @selected(old('jenis_kelamin_id')==$r->id)>{{ $r->nama }}</option>@endforeach</select>
      </div>
      <div class="form-field"><label>Agama</label>
        <select name="agama_id" required><option value="">Pilih</option>@foreach($agamas as $r)<option value="{{ $r->id }}" @selected(old('agama_id')==$r->id)>{{ $r->nama }}</option>@endforeach</select>
      </div>
    </div>
  </div>
  <div class="form-section">
    <h3>Status Sosial & Domisili</h3>
    <div class="form-grid">
      <div class="form-field"><label>Status pernikahan</label>
        <select name="status_pernikahan_id"><option value="">Pilih</option>@foreach($statusPernikahans as $r)<option value="{{ $r->id }}" @selected(old('status_pernikahan_id')==$r->id)>{{ $r->nama }}</option>@endforeach</select>
      </div>
      <div class="form-field"><label>Hubungan KK</label>
        <select name="hubungan_keluarga">@foreach($familyRoles as $role)<option value="{{ $role }}" @selected(old('hubungan_keluarga','Anggota Keluarga')===$role)>{{ $role }}</option>@endforeach</select>
      </div>
      <div class="form-field"><label>Pendidikan</label>
        <select name="pendidikan_id"><option value="">Pilih</option>@foreach($pendidikans as $r)<option value="{{ $r->id }}" @selected(old('pendidikan_id')==$r->id)>{{ $r->nama }}</option>@endforeach</select>
      </div>
      <div class="form-field"><label>Pekerjaan</label>
        <select name="pekerjaan_id"><option value="">Pilih</option>@foreach($pekerjaans as $r)<option value="{{ $r->id }}" @selected(old('pekerjaan_id')==$r->id)>{{ $r->nama }}</option>@endforeach</select>
      </div>
      <div class="form-field"><label>Golongan darah</label>
        <select name="golongan_darah_id"><option value="">Pilih</option>@foreach($golonganDarahs as $r)<option value="{{ $r->id }}" @selected(old('golongan_darah_id')==$r->id)>{{ $r->nama }}</option>@endforeach</select>
      </div>
      <div class="form-field"><label>Nomor KK (16 digit)</label><input name="nomor_kk" value="{{ old('nomor_kk') }}" maxlength="16" pattern="[0-9]{16}"></div>
      <div class="form-field form-field-wide"><label>Alamat</label><input name="alamat" value="{{ old('alamat') }}"></div>
      <div class="form-field"><label>RT/RW</label><input name="rt_rw" value="{{ old('rt_rw') }}" placeholder="01/02"></div>
      <div class="form-field"><label>Kelurahan</label><input name="kelurahan" value="{{ old('kelurahan') }}"></div>
      <div class="form-field"><label>Kecamatan</label><input name="kecamatan" value="{{ old('kecamatan') }}"></div>
      <div class="form-field"><label>Kota/Kabupaten</label><input name="kota" value="{{ old('kota') }}"></div>
      <div class="form-field"><label>Provinsi</label><input name="provinsi" value="{{ old('provinsi') }}"></div>
    </div>
    <label class="checkbox-inline" style="margin-top:12px;"><input type="checkbox" name="meninggal" value="1" @checked(old('meninggal'))><span>Tandai sudah meninggal</span></label>
  </div>
  <div class="form-actions">
    <button type="submit" class="btn">Simpan Data Warga</button>
    <button type="button" class="btn secondary" onclick="document.getElementById('formTambah').style.display='none'">Batal</button>
  </div>
</form>