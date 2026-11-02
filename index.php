<!-- index.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard WA Gateway</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f4f6f9; }
        .sidebar { min-height: 100vh; background-color: #343a40; }
        .sidebar a { color: #fff; text-decoration: none; padding: 15px; display: block; border-bottom: 1px solid #4f5962;}
        .sidebar a:hover { background-color: #495057; }
    </style>
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar col-md-2">
            <h4 class="text-white text-center py-3 border-bottom">WA Gateway</h4>
            <a href="index.php">🏠 Dashboard (Status)</a>
            <a href="kirim.php">✉️ Kirim Pesan</a>
        </div>

        <!-- Content -->
        <div class="col-md-10 p-5">
            <h2 class="mb-4">Status Koneksi WhatsApp</h2>

            <div class="card shadow-sm col-md-6">
                <div class="card-body text-center">
                    <h5 class="card-title mb-3">Status Saat Ini:</h5>
                    <!-- Tempat menampilkan status -->
                    <h3 id="status-text" class="text-secondary">Mengecek koneksi...</h3>

                    <hr>
                    <!-- Tempat menampilkan QR Code jika belum login -->
                    <div id="qr-container" style="display: none;">
                        <p class="text-muted">Scan QR Code di bawah ini menggunakan WhatsApp Anda:</p>
                        <img id="qr-image" src="" alt="QR Code" class="img-fluid border rounded" style="max-width: 250px;">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script untuk Fetch API Status secara realtime -->
    <script>
        function checkStatus() {
            fetch('http://localhost:3000/api/status')
                .then(response => response.json())
                .then(data => {
                    const statusText = document.getElementById('status-text');
                    const qrContainer = document.getElementById('qr-container');
                    const qrImage = document.getElementById('qr-image');

                    if (data.status === 'connected') {
                        statusText.innerHTML = '<span class="text-success">✅ TERHUBUNG (CONNECTED)</span>';
                        qrContainer.style.display = 'none';
                    } else if (data.status === 'qr') {
                        statusText.innerHTML = '<span class="text-warning">⏳ MENUNGGU SCAN QR</span>';
                        qrContainer.style.display = 'block';
                        if (data.qr) {
                            qrImage.src = data.qr;
                        }
                    } else if (data.status === 'terputus') {
                        statusText.innerHTML = '<span class="text-danger">❌ TERPUTUS (DISCONNECTED)</span>';
                        qrContainer.style.display = 'none';
                    } else {
                        statusText.innerHTML = '<span class="text-secondary">Sedang memuat sistem...</span>';
                    }
                })
                .catch(error => {
                    document.getElementById('status-text').innerHTML = '<span class="text-danger">Server Node.js Mati! Harap nyalakan server.</span>';
                });
        }

        // Cek status setiap 3 detik
        setInterval(checkStatus, 3000);
        checkStatus(); // Panggil pertama kali
    </script>
</body>
</html>