# EventRent — Sistem Informasi Penyewaan Perlengkapan Acara

Aplikasi web penyewaan perlengkapan acara berbasis **Laravel 11** dan **MySQL** (Proyek Perangkat Lunak — Kelompok 2).

---

## 🛠️ Panduan Instalasi Awal (Setelah Clone)

1. **Clone repositori ke komputer lokal:**
   ```bash
   git clone https://github.com/Shabir2784/TugasUploadFileText.Kelompok2
   cd TugasUploadFileText.Kelompok2
   ```

2. **Install dependensi PHP & Frontend:**
   ```bash
   composer install
   npm install && npm run build
   ```

3. **Konfigurasi Environment & Database:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   Buka file `.env`, lalu sesuaikan nama database (`DB_DATABASE=eventrent`), username, dan password MySQL lokal Anda.

4. **Jalankan Migrasi, Seeder & Storage Link:**
   ```bash
   php artisan migrate --seed
   php artisan storage:link
   ```

5. **Jalankan Server Lokal:**
   ```bash
   php artisan serve
   ```

---

## 🤝 Panduan Kerja Sama Tim Menggunakan Git & GitHub

### Aturan Dasar Kelompok
- **DILARANG `git push` langsung ke branch `main`.** Branch `main` hanya untuk kode yang sudah selesai dan teruji.
- Selalu kerjakan tugas di **branch masing-masing** sesuai fitur/modul di SDD.
- Selalu lakukan `git pull` sebelum mulai ngoding agar kode tetap sinkron dengan anggota lain.

---

### Alur Kerja Harian (Step-by-Step)

#### 1. Ambil Update Terbaru dari `main`
Sebelum membuat fitur baru, pastikan branch `main` di laptop Anda paling baru:
```bash
git checkout main
git pull origin main
```

#### 2. Buat Branch Baru Sesuai Fitur
Gunakan format penamaan `fitur/<nama-fitur>` atau `fix/<nama-perbaikan>`:
```bash
git checkout -b fitur/katalog-produk
```

#### 3. Cek Perubahan & Simpan ke Commit
Setelah selesai ngoding satu bagian fitur, cek file apa saja yang berubah:
```bash
git status
```
Tambahkan file dan buat pesan commit yang jelas (gunakan awalan `feat:`, `fix:`, `style:`, atau `docs:`):
```bash
git add .
git commit -m "feat: menambahkan filter kategori pada halaman katalog"
```

#### 4. Push Branch ke GitHub
Kirim branch Anda ke repositori GitHub:
```bash
git push -u origin fitur/katalog-produk
```
*(Untuk push berikutnya di branch yang sama, cukup ketik `git push`)*

#### 5. Buat Pull Request (PR)
1. Buka halaman repositori di **GitHub**.
2. Klik tombol hijau **Compare & pull request** yang muncul di bagian atas.
3. Pastikan arah merge adalah **`base: main` ← `compare: fitur/nama-fitur`**.
4. Isi deskripsi singkat apa yang dikerjakan, lalu klik **Create pull request**.
5. Beri tahu Project Manager / anggota tim untuk melakukan review dan **Merge pull request**.

---

## 🆘 Mengatasi Masalah Umum Git

### A. Mengatasi Merge Conflict
Jika saat Pull Request muncul peringatan *conflict*:
```bash
# 1. Pastikan berada di branch fitur Anda
git checkout fitur/nama-fitur

# 2. Tarik perubahan terbaru dari main ke branch Anda
git pull origin main
```
Buka file yang ditandai merah di VS Code, pilih kode yang benar (*Accept Current* / *Accept Incoming* / *Accept Both*), lalu simpan:
```bash
git add .
git commit -m "fix: menyelesaikan merge conflict dengan main"
git push
```

### B. Pindah Branch Saat Kerja Belum Selesai (`git stash`)
Jika Anda harus pindah branch mendadak tetapi kode saat ini belum siap di-commit:
```bash
git stash          # Menyimpan sementara perubahan yang belum di-commit
git checkout main  # Pindah branch dengan aman
```
Untuk memunculkan kembali pekerjaan yang disimpan tadi:
```bash
git checkout fitur/nama-fitur
git stash pop
```

### C. Perintah Pengecekan Cepat
- `git branch` — Melihat daftar branch lokal dan posisi branch aktif saat ini.
- `git log --oneline -n 5` — Melihat 5 riwayat commit terakhir secara ringkas.

### ⚡ Shortcut Pindah & Buat Branch (`git switch`)

- **Buat branch baru sekaligus langsung pindah ke dalamnya:**
  ```bash
  git switch -c fitur/nama-fitur
  ```
  *(Menggantikan `git checkout -b fitur/nama-fitur`)*

- **Pindah ke branch yang sudah ada:**
  ```bash
  git switch main
  ```

- **Bolak-balik cepat ke branch sebelumnya (Toggle):**
  ```bash
  git switch -
  ```
  *(Sangat berguna saat Anda sering berpindah antara `main` dan branch fitur tanpa mengetik ulang nama branchnya)*