-- ============================================
-- INSTALL LENGKAP DATABASE PENDUDUK
-- Cukup import file ini sekali saja di phpMyAdmin
-- ============================================

-- Database dibuat otomatis jika belum ada.
CREATE DATABASE IF NOT EXISTS db_penduduk CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE db_penduduk;
SET FOREIGN_KEY_CHECKS=0;

-- 1. Tabel admin login
DROP TABLE IF EXISTS admin;
CREATE TABLE admin (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    must_change_password TINYINT(1) NOT NULL DEFAULT 0
);
INSERT INTO admin (username, password, must_change_password) VALUES 
('admin', '$2y$10$yE6ZpJg5m0xsAx.26pc4SugF7cBANt9cORtMb27RQHC6WcxfI2GVi', 1);

-- 2. Referensi: provinsi
DROP TABLE IF EXISTS provinsi;
CREATE TABLE provinsi (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nama VARCHAR(100) NOT NULL
);
INSERT INTO provinsi (nama) VALUES
('Jawa Barat'), ('Jawa Tengah'), ('Jawa Timur'), ('DKI Jakarta'),
('Sumatera Utara'), ('Sulawesi Selatan'), ('Bali'), ('Sumatera Barat'),
('Riau'), ('Kalimantan Selatan'), ('Nusa Tenggara Timur'), ('Papua'),
('Aceh'), ('Bengkulu'), ('Jambi');

-- 3. Referensi: kota/kabupaten
DROP TABLE IF EXISTS kota_kabupaten;
CREATE TABLE kota_kabupaten (
    id INT PRIMARY KEY AUTO_INCREMENT,
    provinsi_id INT NOT NULL,
    nama VARCHAR(100) NOT NULL,
    FOREIGN KEY (provinsi_id) REFERENCES provinsi(id)
);
INSERT INTO kota_kabupaten (provinsi_id, nama) VALUES
(1, 'Bandung'), (1, 'Bekasi'), (1, 'Depok'), (1, 'Cimahi'),
(2, 'Semarang'), (2, 'Solo'), (2, 'Cilacap'),
(3, 'Surabaya'), (3, 'Malang'), (3, 'Sidoarjo'),
(4, 'Jakarta Pusat'), (4, 'Jakarta Selatan'), (4, 'Jakarta Utara'),
(5, 'Medan'), (5, 'Pematangsiantar'), (5, 'Sibolga'),
(6, 'Makassar'), (6, 'Palopo'), (6, 'Bone'),
(7, 'Denpasar'), (8, 'Padang'), (9, 'Pekanbaru'),
(10, 'Banjarmasin'), (11, 'Kupang'), (12, 'Jayapura'),
(13, 'Banda Aceh'), (14, 'Bengkulu'), (15, 'Jambi');

-- 4. Referensi: kecamatan
DROP TABLE IF EXISTS kecamatan;
CREATE TABLE kecamatan (
    id INT PRIMARY KEY AUTO_INCREMENT,
    kota_id INT NOT NULL,
    nama VARCHAR(100) NOT NULL,
    FOREIGN KEY (kota_id) REFERENCES kota_kabupaten(id)
);
INSERT INTO kecamatan (kota_id, nama) VALUES
(1, 'Coblong'), (1, 'Lembang'), (1, 'Babakan Ciparay'),
(2, 'Central Jakarta'), (2, 'Menteng'), (2, 'Tanah Abang'),
(4, 'Semarang Barat'), (4, 'Semarang Tengah'), (4, 'Semarang Selatan'),
(5, 'Solo Baru'), (5, 'Solo Lama'),
(8, 'Surabaya Tengah'), (8, 'Surabaya Utara'),
(11, 'Jakarta Pusat'), (11, 'Menteng'),
(14, 'Medan'), (14, 'Pematangsiantar'),
(17, 'Makassar'), (17, 'Palopo'),
(20, 'Denpasar'), (20, 'Gianyar'),
(22, 'Padang'),
(24, 'Banjarmasin'),
(25, 'Kupang'),
(27, 'Banda Aceh'),
(28, 'Bengkulu');

-- 5. Referensi: kelurahan/desa
DROP TABLE IF EXISTS kelurahan_desa;
CREATE TABLE kelurahan_desa (
    id INT PRIMARY KEY AUTO_INCREMENT,
    kecamatan_id INT NOT NULL,
    nama VARCHAR(100) NOT NULL,
    FOREIGN KEY (kecamatan_id) REFERENCES kecamatan(id)
);
INSERT INTO kelurahan_desa (kecamatan_id, nama) VALUES
(1, 'Coblong'), (1, 'Padasuka'), (1, 'Tamansari'),
(2, 'Lembang'), (2, 'Sudiang'),
(4, 'Central Jakarta'), (4, 'Menteng'),
(5, 'Semarang Barat'), (5, 'Semarang Tengah'),
(8, 'Surabaya Tengah'), (8, 'Surabaya Utara'),
(11, 'Jakarta Pusat'), (11, 'Menteng'),
(14, 'Medan'), (14, 'Pematangsiantar'),
(17, 'Makassar'), (17, 'Palopo'),
(20, 'Denpasar'), (20, 'Gianyar'),
(22, 'Padang'),
(24, 'Banjarmasin'),
(25, 'Kupang'),
(27, 'Banda Aceh'),
(28, 'Bengkulu');

-- 6. Referensi: agama
DROP TABLE IF EXISTS agama;
CREATE TABLE agama (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nama VARCHAR(50) NOT NULL
);
INSERT INTO agama (nama) VALUES ('Islam'), ('Kristen'), ('Katholik'), ('Hindu'), ('Buddha'), ('Konghucu');

-- 7. Referensi: jenis kelamin
DROP TABLE IF EXISTS jenis_kelamin;
CREATE TABLE jenis_kelamin (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nama VARCHAR(20) NOT NULL
);
INSERT INTO jenis_kelamin (nama) VALUES ('Laki-laki'), ('Perempuan');

-- 8. Referensi: status pernikahan
DROP TABLE IF EXISTS status_pernikahan;
CREATE TABLE status_pernikahan (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nama VARCHAR(30) NOT NULL
);
INSERT INTO status_pernikahan (nama) VALUES ('Belum Menikah'), ('Menikah'), ('Cerai'), ('Janda/Duda');

-- 9. Referensi: pendidikan terakhir
DROP TABLE IF EXISTS pendidikan_terakhir;
CREATE TABLE pendidikan_terakhir (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nama VARCHAR(50) NOT NULL
);
INSERT INTO pendidikan_terakhir (nama) VALUES ('Tidak Sekolah'), ('SD'), ('SMP'), ('SMA'), ('Diploma'), ('Sarjana'), ('Pasca Sarjana');

-- 10. Referensi: pekerjaan
DROP TABLE IF EXISTS pekerjaan;
CREATE TABLE pekerjaan (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nama VARCHAR(100) NOT NULL
);
INSERT INTO pekerjaan (nama) VALUES ('Petani'), ('PNS'), ('Swasta'), ('Wirausaha'), ('Pelajar/Mahasiswa'), ('Tidak Bekerja'), ('Lainnya');

-- 11. Referensi: golongan darah
DROP TABLE IF EXISTS golongan_darah;
CREATE TABLE golongan_darah (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nama VARCHAR(5) NOT NULL
);
INSERT INTO golongan_darah (nama) VALUES ('A'), ('B'), ('AB'), ('O');

-- 12. Tabel utama: warga
DROP TABLE IF EXISTS warga;
CREATE TABLE warga (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nik CHAR(16) UNIQUE NOT NULL,
    nama VARCHAR(100) NOT NULL,
    tempat_lahir VARCHAR(100),
    tanggal_lahir DATE,
    jenis_kelamin_id INT,
    agama_id INT,
    status_pernikahan_id INT,
    hubungan_keluarga VARCHAR(30) NOT NULL DEFAULT 'Anggota Keluarga',
    meninggal TINYINT(1) NOT NULL DEFAULT 0,
    pendidikan_id INT,
    pekerjaan_id INT,
    golongan_darah_id INT,
    alamat TEXT,
    rt_rw VARCHAR(10),
    kelurahan_id INT,
    kecamatan_id INT,
    kota_id INT,
    provinsi_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (jenis_kelamin_id) REFERENCES jenis_kelamin(id),
    FOREIGN KEY (agama_id) REFERENCES agama(id),
    FOREIGN KEY (status_pernikahan_id) REFERENCES status_pernikahan(id),
    FOREIGN KEY (pendidikan_id) REFERENCES pendidikan_terakhir(id),
    FOREIGN KEY (pekerjaan_id) REFERENCES pekerjaan(id),
    FOREIGN KEY (golongan_darah_id) REFERENCES golongan_darah(id),
    FOREIGN KEY (kelurahan_id) REFERENCES kelurahan_desa(id),
    FOREIGN KEY (kecamatan_id) REFERENCES kecamatan(id),
    FOREIGN KEY (kota_id) REFERENCES kota_kabupaten(id),
    FOREIGN KEY (provinsi_id) REFERENCES provinsi(id)
);

-- 13. Dokumen identitas
DROP TABLE IF EXISTS dokumen_identitas;
CREATE TABLE dokumen_identitas (
    id INT PRIMARY KEY AUTO_INCREMENT,
    warga_id INT NOT NULL,
    jenis_dokumen ENUM('KTP','KK','AKTA','PASSPORT') NOT NULL,
    nomor_dokumen VARCHAR(50) NOT NULL,
    tanggal_terbit DATE,
    expired_date DATE,
    FOREIGN KEY (warga_id) REFERENCES warga(id) ON DELETE CASCADE
);

-- 14. Riwayat pindah
DROP TABLE IF EXISTS riwayat_perindahan;
CREATE TABLE riwayat_perindahan (
    id INT PRIMARY KEY AUTO_INCREMENT,
    warga_id INT NOT NULL,
    asal_kota VARCHAR(100),
    tujuan_kota VARCHAR(100),
    tanggal_pindah DATE,
    alasan TEXT,
    FOREIGN KEY (warga_id) REFERENCES warga(id) ON DELETE CASCADE
);

-- 15. Keluarga
DROP TABLE IF EXISTS keluarga;
CREATE TABLE keluarga (
    id INT PRIMARY KEY AUTO_INCREMENT,
    warga_id INT NOT NULL,
    nama_anggota VARCHAR(100) NOT NULL,
    hubungan ENUM('Ayah','Ibu','Anak','Suami','Istri','Lainnya') NOT NULL,
    FOREIGN KEY (warga_id) REFERENCES warga(id) ON DELETE CASCADE
);

-- 16. Audit Log
DROP TABLE IF EXISTS audit_logs;
CREATE TABLE audit_logs (
    id INT PRIMARY KEY AUTO_INCREMENT,
    waktu TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    aksi VARCHAR(50),
    detail TEXT,
    oleh VARCHAR(100)
);

-- ============================================
-- 30 DATA WARGA DEMO FIKTIF
-- ============================================
INSERT INTO warga (
    nik, nama, tempat_lahir, tanggal_lahir,
    jenis_kelamin_id, agama_id, status_pernikahan_id,
    pendidikan_id, pekerjaan_id, golongan_darah_id,
    alamat, rt_rw, kelurahan_id, kecamatan_id, kota_id, provinsi_id
) VALUES
('3273011405800001', 'Rizky Maulana', 'Bandung', '1980-05-14',
 (SELECT id FROM jenis_kelamin WHERE nama='Laki-laki'),
 (SELECT id FROM agama WHERE nama='Islam'),
 (SELECT id FROM status_pernikahan WHERE nama='Menikah'),
 (SELECT id FROM pendidikan_terakhir WHERE nama='SMA'),
 (SELECT id FROM pekerjaan WHERE nama='Swasta'),
 (SELECT id FROM golongan_darah WHERE nama='O'),
 'Jl. Asia Afrika No. 12', '001/005', 1, 1, 1, 1),

('3273011211050002', 'Dimas Pratama', 'Jakarta', '2005-11-12',
 (SELECT id FROM jenis_kelamin WHERE nama='Laki-laki'),
 (SELECT id FROM agama WHERE nama='Islam'),
 (SELECT id FROM status_pernikahan WHERE nama='Belum Menikah'),
 (SELECT id FROM pendidikan_terakhir WHERE nama='Sarjana'),
 (SELECT id FROM pekerjaan WHERE nama='PNS'),
 (SELECT id FROM golongan_darah WHERE nama='A'),
 'Jl. Sudirman Kavling 5', '002/003', 4, 4, 10, 4),

('3273014909820003', 'Ayu Lestari', 'Semarang', '1982-09-09',
 (SELECT id FROM jenis_kelamin WHERE nama='Perempuan'),
 (SELECT id FROM agama WHERE nama='Kristen'),
 (SELECT id FROM status_pernikahan WHERE nama='Belum Menikah'),
 (SELECT id FROM pendidikan_terakhir WHERE nama='Diploma'),
 (SELECT id FROM pekerjaan WHERE nama='Swasta'),
 (SELECT id FROM golongan_darah WHERE nama='B'),
 'Jl. Pahlawan No. 8', '003/002', 7, 7, 4, 2),

('3273010503830004', 'Fajar Nugraha', 'Surabaya', '1983-03-05',
 (SELECT id FROM jenis_kelamin WHERE nama='Laki-laki'),
 (SELECT id FROM agama WHERE nama='Islam'),
 (SELECT id FROM status_pernikahan WHERE nama='Menikah'),
 (SELECT id FROM pendidikan_terakhir WHERE nama='SMP'),
 (SELECT id FROM pekerjaan WHERE nama='Petani'),
 (SELECT id FROM golongan_darah WHERE nama='AB'),
 'Jl. Diponegoro No. 21', '005/001', 8, 8, 7, 3),

('3273016007840005', 'Nabila Rahma', 'Medan', '1984-07-20',
 (SELECT id FROM jenis_kelamin WHERE nama='Perempuan'),
 (SELECT id FROM agama WHERE nama='Islam'),
 (SELECT id FROM status_pernikahan WHERE nama='Belum Menikah'),
 (SELECT id FROM pendidikan_terakhir WHERE nama='SMA'),
 (SELECT id FROM pekerjaan WHERE nama='Pelajar/Mahasiswa'),
 (SELECT id FROM golongan_darah WHERE nama='O'),
 'Jl. Gatot Subroto No. 15', '001/004', 13, 13, 13, 5),

('3273011211090006', 'Reza Firmansyah', 'Makassar', '2009-11-12',
 (SELECT id FROM jenis_kelamin WHERE nama='Laki-laki'),
 (SELECT id FROM agama WHERE nama='Islam'),
 (SELECT id FROM status_pernikahan WHERE nama='Menikah'),
 (SELECT id FROM pendidikan_terakhir WHERE nama='Sarjana'),
 (SELECT id FROM pekerjaan WHERE nama='Wirausaha'),
 (SELECT id FROM golongan_darah WHERE nama='A'),
 'Jl. Sultan Hasanuddin No. 3', '002/006', 16, 16, 16, 6),

('3273017001860007', 'Salsabila Putri', 'Denpasar', '1986-01-30',
 (SELECT id FROM jenis_kelamin WHERE nama='Perempuan'),
 (SELECT id FROM agama WHERE nama='Hindu'),
 (SELECT id FROM status_pernikahan WHERE nama='Belum Menikah'),
 (SELECT id FROM pendidikan_terakhir WHERE nama='SMA'),
 (SELECT id FROM pekerjaan WHERE nama='Swasta'),
 (SELECT id FROM golongan_darah WHERE nama='B'),
 'Jl. Thamrin No. 7', '004/002', 1, 1, 1, 1),

('3273011805870008', 'Arif Setiawan', 'Yogyakarta', '1987-05-18',
 (SELECT id FROM jenis_kelamin WHERE nama='Laki-laki'),
 (SELECT id FROM agama WHERE nama='Islam'),
 (SELECT id FROM status_pernikahan WHERE nama='Belum Menikah'),
 (SELECT id FROM pendidikan_terakhir WHERE nama='Diploma'),
 (SELECT id FROM pekerjaan WHERE nama='Pelajar/Mahasiswa'),
 (SELECT id FROM golongan_darah WHERE nama='O'),
 'Jl. Malioboro No. 44', '003/003', 1, 1, 1, 1),

('3273016509110009', 'Putri Maharani', 'Palembang', '2011-09-25',
 (SELECT id FROM jenis_kelamin WHERE nama='Perempuan'),
 (SELECT id FROM agama WHERE nama='Islam'),
 (SELECT id FROM status_pernikahan WHERE nama='Menikah'),
 (SELECT id FROM pendidikan_terakhir WHERE nama='SMA'),
 (SELECT id FROM pekerjaan WHERE nama='Tidak Bekerja'),
 (SELECT id FROM golongan_darah WHERE nama='AB'),
 'Jl. Sudirman No. 10', '002/001', 1, 1, 1, 1),

('3273011402810010', 'Bagas Wicaksono', 'Bekasi', '1981-02-14',
 (SELECT id FROM jenis_kelamin WHERE nama='Laki-laki'),
 (SELECT id FROM agama WHERE nama='Islam'),
 (SELECT id FROM status_pernikahan WHERE nama='Belum Menikah'),
 (SELECT id FROM pendidikan_terakhir WHERE nama='SMP'),
 (SELECT id FROM pekerjaan WHERE nama='Swasta'),
 (SELECT id FROM golongan_darah WHERE nama='O'),
 'Jl. Jenderal Ahmad Yani No. 2', '001/003', 2, 2, 2, 1),

('3273010312070011', 'Rendra Saputra', 'Bandung', '2007-12-03',
 (SELECT id FROM jenis_kelamin WHERE nama='Laki-laki'),
 (SELECT id FROM agama WHERE nama='Islam'),
 (SELECT id FROM status_pernikahan WHERE nama='Menikah'),
 (SELECT id FROM pendidikan_terakhir WHERE nama='Sarjana'),
 (SELECT id FROM pekerjaan WHERE nama='PNS'),
 (SELECT id FROM golongan_darah WHERE nama='A'),
 'Jl. Cihampelas No. 55', '005/002', 1, 1, 1, 1),

('3273015706840012', 'Siti Aisyah', 'Solo', '1984-06-17',
 (SELECT id FROM jenis_kelamin WHERE nama='Perempuan'),
 (SELECT id FROM agama WHERE nama='Islam'),
 (SELECT id FROM status_pernikahan WHERE nama='Menikah'),
 (SELECT id FROM pendidikan_terakhir WHERE nama='SMA'),
 (SELECT id FROM pekerjaan WHERE nama='Tidak Bekerja'),
 (SELECT id FROM golongan_darah WHERE nama='B'),
 'Jl. Slamet Riyadi No. 30', '004/004', 5, 5, 5, 2),

('3273010910840013', 'Rudi Hartono', 'Garut', '1984-10-09',
 (SELECT id FROM jenis_kelamin WHERE nama='Laki-laki'),
 (SELECT id FROM agama WHERE nama='Islam'),
 (SELECT id FROM status_pernikahan WHERE nama='Menikah'),
 (SELECT id FROM pendidikan_terakhir WHERE nama='SMP'),
 (SELECT id FROM pekerjaan WHERE nama='Petani'),
 (SELECT id FROM golongan_darah WHERE nama='O'),
 'Jl. Cimahi No. 18', '002/007', 1, 1, 1, 1),

('3273016204860014', 'Rina Oktaviani', 'Malang', '1986-04-22',
 (SELECT id FROM jenis_kelamin WHERE nama='Perempuan'),
 (SELECT id FROM agama WHERE nama='Kristen'),
 (SELECT id FROM status_pernikahan WHERE nama='Belum Menikah'),
 (SELECT id FROM pendidikan_terakhir WHERE nama='Sarjana'),
 (SELECT id FROM pekerjaan WHERE nama='Swasta'),
 (SELECT id FROM golongan_darah WHERE nama='AB'),
 'Jl. Tugu No. 12', '003/005', 8, 8, 8, 3),

('3273015108120015', 'Dian Puspita', 'Palopo', '2012-08-11',
 (SELECT id FROM jenis_kelamin WHERE nama='Perempuan'),
 (SELECT id FROM agama WHERE nama='Islam'),
 (SELECT id FROM status_pernikahan WHERE nama='Menikah'),
 (SELECT id FROM pendidikan_terakhir WHERE nama='SMA'),
 (SELECT id FROM pekerjaan WHERE nama='Wirausaha'),
 (SELECT id FROM golongan_darah WHERE nama='A'),
 'Jl. Andi Djemma No. 5', '001/002', 17, 17, 16, 6),

('3273013012820016', 'Ilham Ramadhan', 'Batam', '1982-12-30',
 (SELECT id FROM jenis_kelamin WHERE nama='Laki-laki'),
 (SELECT id FROM agama WHERE nama='Buddha'),
 (SELECT id FROM status_pernikahan WHERE nama='Belum Menikah'),
 (SELECT id FROM pendidikan_terakhir WHERE nama='Diploma'),
 (SELECT id FROM pekerjaan WHERE nama='Swasta'),
 (SELECT id FROM golongan_darah WHERE nama='B'),
 'Jl. Ahmad Yani No. 25', '002/003', 1, 1, 1, 1),

('3273015403850017', "Nurul Hasanah", 'Cirebon', '1985-03-14',
 (SELECT id FROM jenis_kelamin WHERE nama='Perempuan'),
 (SELECT id FROM agama WHERE nama='Islam'),
 (SELECT id FROM status_pernikahan WHERE nama='Menikah'),
 (SELECT id FROM pendidikan_terakhir WHERE nama='SMA'),
 (SELECT id FROM pekerjaan WHERE nama='Tidak Bekerja'),
 (SELECT id FROM golongan_darah WHERE nama='O'),
 'Jl. Trusmi No. 7', '004/001', 1, 1, 1, 1),

('3273014807100018', 'Nia Anggraini', 'Padang', '2010-07-08',
 (SELECT id FROM jenis_kelamin WHERE nama='Perempuan'),
 (SELECT id FROM agama WHERE nama='Islam'),
 (SELECT id FROM status_pernikahan WHERE nama='Menikah'),
 (SELECT id FROM pendidikan_terakhir WHERE nama='SMP'),
 (SELECT id FROM pekerjaan WHERE nama='Swasta'),
 (SELECT id FROM golongan_darah WHERE nama='AB'),
 'Jl. Sudirman No. 40', '005/006', 1, 1, 1, 1),

('3273011901790019', 'Bambang Prasetyo', 'Pontianak', '1979-01-19',
 (SELECT id FROM jenis_kelamin WHERE nama='Laki-laki'),
 (SELECT id FROM agama WHERE nama='Kristen'),
 (SELECT id FROM status_pernikahan WHERE nama='Belum Menikah'),
 (SELECT id FROM pendidikan_terakhir WHERE nama='Sarjana'),
 (SELECT id FROM pekerjaan WHERE nama='PNS'),
 (SELECT id FROM golongan_darah WHERE nama='A'),
 'Jl. Ahmad Yani No. 14', '001/002', 1, 1, 1, 1),

('3273016705820020', 'Vina Paramita', 'Banjarmasin', '1982-05-27',
 (SELECT id FROM jenis_kelamin WHERE nama='Perempuan'),
 (SELECT id FROM agama WHERE nama='Islam'),
 (SELECT id FROM status_pernikahan WHERE nama='Menikah'),
 (SELECT id FROM pendidikan_terakhir WHERE nama='SMA'),
 (SELECT id FROM pekerjaan WHERE nama='Swasta'),
 (SELECT id FROM golongan_darah WHERE nama='O'),
 'Jl. Lambung Mangkurat No. 9', '003/004', 1, 1, 1, 1),

('3273010309060021', 'Yoga Permana', 'Banda Aceh', '2006-09-03',
 (SELECT id FROM jenis_kelamin WHERE nama='Laki-laki'),
 (SELECT id FROM agama WHERE nama='Islam'),
 (SELECT id FROM status_pernikahan WHERE nama='Menikah'),
 (SELECT id FROM pendidikan_terakhir WHERE nama='Sarjana'),
 (SELECT id FROM pekerjaan WHERE nama='PNS'),
 (SELECT id FROM golongan_darah WHERE nama='B'),
 'Jl. Teuku Umar No. 22', '002/005', 1, 1, 1, 1),

('3273015511840022', 'Maya Safitri', 'Kupang', '1984-11-15',
 (SELECT id FROM jenis_kelamin WHERE nama='Perempuan'),
 (SELECT id FROM agama WHERE nama='Kristen'),
 (SELECT id FROM status_pernikahan WHERE nama='Belum Menikah'),
 (SELECT id FROM pendidikan_terakhir WHERE nama='Diploma'),
 (SELECT id FROM pekerjaan WHERE nama='Swasta'),
 (SELECT id FROM golongan_darah WHERE nama='AB'),
 'Jl. El Tari No. 6', '004/002', 1, 1, 1, 1),

('3273012802860023', 'Rafi Akbar', 'Tangerang', '1986-02-28',
 (SELECT id FROM jenis_kelamin WHERE nama='Laki-laki'),
 (SELECT id FROM agama WHERE nama='Islam'),
 (SELECT id FROM status_pernikahan WHERE nama='Menikah'),
 (SELECT id FROM pendidikan_terakhir WHERE nama='SMA'),
 (SELECT id FROM pekerjaan WHERE nama='Wirausaha'),
 (SELECT id FROM golongan_darah WHERE nama='O'),
 'Jl. MH Thamrin No. 33', '005/001', 1, 1, 1, 1),

('3273015206110024', 'Citra Anggraini', 'Manado', '2011-06-12',
 (SELECT id FROM jenis_kelamin WHERE nama='Perempuan'),
 (SELECT id FROM agama WHERE nama='Kristen'),
 (SELECT id FROM status_pernikahan WHERE nama='Belum Menikah'),
 (SELECT id FROM pendidikan_terakhir WHERE nama='Sarjana'),
 (SELECT id FROM pekerjaan WHERE nama='Swasta'),
 (SELECT id FROM golongan_darah WHERE nama='A'),
 'Jl. Sam Ratulangi No. 19', '001/003', 1, 1, 1, 1),

('3273010510810025', 'Andri Kurnia', 'Cimahi', '1981-10-05',
 (SELECT id FROM jenis_kelamin WHERE nama='Laki-laki'),
 (SELECT id FROM agama WHERE nama='Islam'),
 (SELECT id FROM status_pernikahan WHERE nama='Belum Menikah'),
 (SELECT id FROM pendidikan_terakhir WHERE nama='SMP'),
 (SELECT id FROM pekerjaan WHERE nama='Tidak Bekerja'),
 (SELECT id FROM golongan_darah WHERE nama='O'),
 'Jl. Kolonel Masturi No. 11', '003/002', 1, 1, 1, 1),

('3273015704830026', 'Fitria Ningsih', 'Bogor', '1983-04-17',
 (SELECT id FROM jenis_kelamin WHERE nama='Perempuan'),
 (SELECT id FROM agama WHERE nama='Islam'),
 (SELECT id FROM status_pernikahan WHERE nama='Belum Menikah'),
 (SELECT id FROM pendidikan_terakhir WHERE nama='SMA'),
 (SELECT id FROM pekerjaan WHERE nama='Pelajar/Mahasiswa'),
 (SELECT id FROM golongan_darah WHERE nama='B'),
 'Jl. Pajajaran No. 50', '002/004', 1, 1, 1, 1),

('3273012108100027', 'Fikri Saputra', 'Cilacap', '2010-08-21',
 (SELECT id FROM jenis_kelamin WHERE nama='Laki-laki'),
 (SELECT id FROM agama WHERE nama='Islam'),
 (SELECT id FROM status_pernikahan WHERE nama='Belum Menikah'),
 (SELECT id FROM pendidikan_terakhir WHERE nama='Diploma'),
 (SELECT id FROM pekerjaan WHERE nama='Swasta'),
 (SELECT id FROM golongan_darah WHERE nama='AB'),
 'Jl. Jenderal Sudirman No. 8', '001/001', 6, 6, 6, 2),

('3273014912830028', 'Nisa Amalia', 'Pematangsiantar', '1983-12-09',
 (SELECT id FROM jenis_kelamin WHERE nama='Perempuan'),
 (SELECT id FROM agama WHERE nama='Kristen'),
 (SELECT id FROM status_pernikahan WHERE nama='Belum Menikah'),
 (SELECT id FROM pendidikan_terakhir WHERE nama='SMA'),
 (SELECT id FROM pekerjaan WHERE nama='Swasta'),
 (SELECT id FROM golongan_darah WHERE nama='O'),
 'Jl. Merdeka No. 24', '004/005', 14, 14, 14, 5),

('3273013001840029', 'Doni Firmansyah', 'Sibolga', '1984-01-30',
 (SELECT id FROM jenis_kelamin WHERE nama='Laki-laki'),
 (SELECT id FROM agama WHERE nama='Islam'),
 (SELECT id FROM status_pernikahan WHERE nama='Belum Menikah'),
 (SELECT id FROM pendidikan_terakhir WHERE nama='SMP'),
 (SELECT id FROM pekerjaan WHERE nama='Petani'),
 (SELECT id FROM golongan_darah WHERE nama='A'),
 'Jl. Ahmad Yani No. 3', '003/002', 15, 15, 15, 5),

('3273015405100030', 'Laila Rahma', 'Bone', '2010-05-14',
 (SELECT id FROM jenis_kelamin WHERE nama='Perempuan'),
 (SELECT id FROM agama WHERE nama='Islam'),
 (SELECT id FROM status_pernikahan WHERE nama='Belum Menikah'),
 (SELECT id FROM pendidikan_terakhir WHERE nama='SMA'),
 (SELECT id FROM pekerjaan WHERE nama='Pelajar/Mahasiswa'),
 (SELECT id FROM golongan_darah WHERE nama='B'),
 'Jl. Andi Pangerang No. 17', '002/003', 18, 18, 16, 6);

-- Nomor KK contoh: satu KK dipakai bersama tiap tiga warga demo.
INSERT INTO dokumen_identitas (warga_id, jenis_dokumen, nomor_dokumen)
SELECT id, 'KK', CONCAT('327301', LPAD(4000000000 + FLOOR((id - 1) / 3), 10, '0'))
FROM warga;

-- Peran keluarga dan status perkawinan data demo.
UPDATE warga SET hubungan_keluarga = CASE nik
    WHEN '3273011405800001' THEN 'Suami'
    WHEN '3273011211050002' THEN 'Anak'
    WHEN '3273014909820003' THEN 'Kepala Keluarga'
    WHEN '3273010503830004' THEN 'Kepala Keluarga'
    WHEN '3273016007840005' THEN 'Istri'
    WHEN '3273011211090006' THEN 'Anak'
    WHEN '3273017001860007' THEN 'Kepala Keluarga'
    WHEN '3273011805870008' THEN 'Suami'
    WHEN '3273016509110009' THEN 'Anak'
    WHEN '3273011402810010' THEN 'Kepala Keluarga'
    WHEN '3273010312070011' THEN 'Anak'
    WHEN '3273015706840012' THEN 'Istri'
    WHEN '3273010910840013' THEN 'Kepala Keluarga'
    WHEN '3273016204860014' THEN 'Istri'
    WHEN '3273015108120015' THEN 'Anak'
    WHEN '3273013012820016' THEN 'Kepala Keluarga'
    WHEN '3273015403850017' THEN 'Istri'
    WHEN '3273014807100018' THEN 'Anak'
    WHEN '3273011901790019' THEN 'Kepala Keluarga'
    WHEN '3273016705820020' THEN 'Istri'
    WHEN '3273010309060021' THEN 'Anak'
    WHEN '3273015511840022' THEN 'Kepala Keluarga'
    WHEN '3273012802860023' THEN 'Suami'
    WHEN '3273015206110024' THEN 'Anak'
    WHEN '3273010510810025' THEN 'Kepala Keluarga'
    WHEN '3273015704830026' THEN 'Istri'
    WHEN '3273012108100027' THEN 'Anak'
    WHEN '3273014912830028' THEN 'Kepala Keluarga'
    WHEN '3273013001840029' THEN 'Suami'
    WHEN '3273015405100030' THEN 'Anak'
    ELSE 'Anggota Keluarga' END;
UPDATE warga SET status_pernikahan_id = CASE WHEN hubungan_keluarga = 'Anak' THEN (SELECT id FROM status_pernikahan WHERE nama = 'Belum Menikah' LIMIT 1) ELSE (SELECT id FROM status_pernikahan WHERE nama = 'Menikah' LIMIT 1) END;
-- Contoh satu warga meninggal untuk fitur admin.
UPDATE warga SET meninggal = 0;
UPDATE warga SET meninggal = 1 WHERE nik = '3273015706840012';

SET FOREIGN_KEY_CHECKS=1;

SELECT 'Database dan 30 data penduduk berhasil diinstal' AS info;
-- Selesai. Login: admin / kelompok 2

