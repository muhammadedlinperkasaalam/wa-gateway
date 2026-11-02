// server/server.js
const express = require('express');
const cors = require('cors');
const qrcode = require('qrcode');
const pino = require('pino');
const { default: makeWASocket, useMultiFileAuthState, DisconnectReason } = require('@whiskeysockets/baileys');

const app = express();
app.use(cors());
app.use(express.json());
app.use(express.urlencoded({ extended: true }));

let sock;
let qrCodeData = null;
let connectionStatus = 'menunggu'; // status: menunggu, qr, connected

async function connectToWhatsApp() {
    const { state, saveCreds } = await useMultiFileAuthState('auth_info_baileys');

    sock = makeWASocket({
        auth: state,
        printQRInTerminal: true,
        logger: pino({ level: "silent" }) // Matikan log bawaan yang berisik
    });

    sock.ev.on('creds.update', saveCreds);

    sock.ev.on('connection.update', async (update) => {
        const { connection, lastDisconnect, qr } = update;

        if (qr) {
            connectionStatus = 'qr';
            // Convert string QR ke Base64 Image
            qrCodeData = await qrcode.toDataURL(qr);
        }

        if (connection === 'close') {
            connectionStatus = 'terputus';
            const shouldReconnect = (lastDisconnect.error)?.output?.statusCode !== DisconnectReason.loggedOut;
            console.log('Koneksi terputus. Alasan:', lastDisconnect.error);

            if (shouldReconnect) {
                console.log('Mencoba menyambungkan kembali...');
                connectToWhatsApp();
            } else {
                console.log('Device dikeluarkan (Logged Out). Hapus folder auth_info_baileys untuk scan ulang.');
                qrCodeData = null;
            }
        } else if (connection === 'open') {
            console.log('Koneksi WhatsApp Berhasil Terhubung!');
            connectionStatus = 'connected';
            qrCodeData = null;
        }
    });
}

// Jalankan fungsi koneksi
connectToWhatsApp();

// --- ENDPOINT API ---

// 1. Endpoint untuk Cek Status & Ambil QR (Digunakan oleh PHP Dashboard)
app.get('/api/status', (req, res) => {
    res.json({
        status: connectionStatus,
        qr: qrCodeData
    });
});

// 2. Endpoint untuk Mengirim Pesan (Digunakan oleh PHP Form)
app.post('/api/send', async (req, res) => {
    const { number, message } = req.body;

    if (connectionStatus !== 'connected') {
        return res.status(400).json({ status: false, message: 'WhatsApp belum terhubung!' });
    }

    try {
        // Format nomor: pastikan menggunakan awalan kode negara dan akhiran @s.whatsapp.net
        // Contoh dari 0812... menjadi 62812...@s.whatsapp.net
        let formattedNumber = number.replace(/\D/g, '');
        if (formattedNumber.startsWith('0')) {
            formattedNumber = '62' + formattedNumber.slice(1);
        }
        formattedNumber = formattedNumber + '@s.whatsapp.net';

        // Kirim Pesan
        await sock.sendMessage(formattedNumber, { text: message });
        res.json({ status: true, message: 'Pesan berhasil dikirim!' });
    } catch (error) {
        console.error(error);
        res.status(500).json({ status: false, message: 'Gagal mengirim pesan', error: error.toString() });
    }
});

const PORT = 3000;
app.listen(PORT, () => {
    console.log(`Server API berjalan di http://localhost:${PORT}`);
});