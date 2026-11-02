## WhatsApp Gateway (Baileys + PHP Native)

## 1. Kebutuhan Software & Persiapan

Silakan unduh dan instal software berikut jika belum ada di komputer/server Anda:

- **Node.js** (Versi 18 LTS atau terbaru): https://nodejs.org/
- **XAMPP** (Untuk menjalankan PHP & Apache): https://www.apachefriends.org/
- **PM2** (Process Manager agar server JS jalan terus di background). Diinstal via Node.js nanti.
- **Visual Studio Code** (Code Editor): https://code.visualstudio.com/

# Sistem ini terbagi menjadi dua bagian:

1. **Node.js Server:** Berfungsi sebagai mesin utama yang menjalankan Baileys untuk koneksi WhatsApp dan menyediakan API.
2. **PHP Dashboard:** Berfungsi sebagai antarmuka (UI) untuk melihat status, scan QR code, dan mengirim pesan.

## 2. Struktur Folder.

1. Buat folder baru di dalam C:\xampp\htdocs\ dengan nama wa-gateway.
2. Buka Terminal (Command Prompt / PowerShell / Terminal di VS Code) dan arahkan ke folder
```cmd
> cd C:\xampp\htdocs\wa-gateway
```
3. clone repositori dengan perintah cmd di bawah ini
```cmd
> git clone https://github.com/muhammadedlinperkasaalam/wa-gateway.git
> cd server
```
4. Inisialisasi proyek Node.js dan install library yang dibutuhkan:
```cmd
> npm init -y
> npm install @whiskeysockets/baileys pino express cors qrcode
> npm install -g pm2
```
(Catatan: pm2 diinstal secara global dengan -g agar bisa digunakan di mana saja)
## 3. Cara Menjalankan Agar Terus Online (Tanpa Server Lain)
Syarat agar tidak perlu *hosting* tambahan atau server lain adalah dengan memastikan XAMPP Apache menyala, dan file Node.js berjalan di latar belakang (background process).

**Langkah-langkah Eksekusi:**

1. Buka aplikasi **XAMPP Control Panel** dan klik tombol **Start** pada modul **Apache**.
2. Buka Terminal (Command Prompt) lalu arahkan ke folder server JS Anda:
```cmd
> cd C:\xampp\htdocs\wa-gateway\server
```
3. Gunakan PM2 untuk menjalankan file server.js di background:
```cmd
> pm2 start server.js --name "wagateway"
```
Keuntungan pakai PM2: Meskipun jendela terminal cmd ditutup (di-close), Node.js server tetap akan memproses API dan WhatsApp bot Anda. Jika PC restart, PM2 juga bisa disetting untuk auto-start.
4. Buka Browser (Chrome/Firefox/Edge) dan akses:
👉 http://localhost/wa-gateway/index.php
5. Selesai! Anda akan melihat halaman Dashboard. Jika belum login, QR Code otomatis muncul. Buka WhatsApp Anda > Perangkat Tertaut > Scan QR Code tersebut. Setelah berhasil terhubung, halaman akan berganti status menjadi CONNECTED secara realtime, dan Anda bisa mulai menggunakan menu Kirim Pesan.