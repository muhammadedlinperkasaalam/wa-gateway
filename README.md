WhatsApp Gateway (Baileys + PHP Native)

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
> cd C:\xampp\htdocs\wa-gateway\server
```
3. clone repositori dengan perintah cmd di bawah ini
```cmd
> git clone https://github.com/muhammadedlinperkasaalam/wa-gateway.git
> cd wa-gateway\server
```
4. buka memakai vs code dengan perinta `code .` memakai Terminal (Command Prompt / PowerShell)
```cmd
> code .
```