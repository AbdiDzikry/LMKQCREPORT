# Panduan Deploy Laravel ke Vercel + Supabase

Panduan ini menjelaskan langkah-langkah untuk mendeploy aplikasi LMK QC Report ke **Vercel** dengan database **Supabase**.

## 1. Persiapan Database (Supabase)
1. Buat project baru di [Supabase](https://supabase.com/).
2. Masuk ke **Project Settings** > **Database**.
3. Cari bagian **Connection string** dan pilih tab **URI**.
4. Simpan URI tersebut (contoh: `postgres://postgres.xxxx:password@aws-0-ap-southeast-1.pooler.supabase.com:5432/postgres`).

## 2. Konfigurasi Vercel
1. Install Vercel CLI jika belum ada: `npm install -g vercel`.
2. Jalankan perintah `vercel` di root project.
3. Ikuti petunjuk di terminal (Login, Link project, dll).
4. **PENTING**: Saat ditanya tentang Environment Variables, tambahkan variabel berikut di dashboard Vercel:

| Key | Value |
| --- | --- |
| `DB_CONNECTION` | `pgsql` |
| `DB_HOST` | (Gunakan **Session Pooler** dari Supabase, port **6543**) |
| `DB_PORT` | `6543` |
| `DB_DATABASE` | `postgres` |
| `DB_USERNAME` | `postgres.xxxxxxx` |
| `DB_PASSWORD` | (Password database Anda) |
| `DB_URL` | (Opsional: Masukkan URI lengkap dengan port 6543) |
| `APP_KEY` | (Gunakan `base64:...` dari `php artisan key:generate --show`) |
| `APP_ENV` | `production` |
| `APP_DEBUG` | `false` |

> [!TIP]
> **PENTING**: Di Supabase, gunakanlah opsi **"Transaction Mode"** atau **"Session Mode"** pada port **6543**. Ini sangat penting untuk lingkungan *Serverless* seperti Vercel agar database Anda tidak cepat penuh karena terlalu banyak koneksi yang terbuka.

## 3. Penyesuaian Aplikasi (Optimalisasi 2025)
- **Session & Cache**: Karena Vercel adalah *Read-Only*, sistem tidak bisa menulis file ke folder `storage`.
  - Atur `SESSION_DRIVER=cookie` (Simpan session di browser user).
  - Atur `CACHE_STORE=array` atau gunakan **Upstash Redis** jika butuh cache yang persisten.
- **Log**: Atur `LOG_CHANNEL=stderr` agar log Laravel muncul di panel **Logs** Vercel.

## 4. Jalankan Migrasi
Karena Vercel tidak mendukung akses SSH langsung untuk menjalankan `php artisan migrate`, Anda bisa melakukannya secara lokal dengan mengarahkan `.env` lokal ke DB Supabase sementara, lalu jalankan:
```bash
php artisan migrate --force
```

## 5. Deployment Akhir
Setelah semua env diset, jalankan:
```bash
vercel --prod
```
Aplikasi Anda akan live di URL yang diberikan Vercel!
