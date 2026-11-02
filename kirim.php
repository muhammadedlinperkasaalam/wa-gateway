<!-- kirim.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kirim Pesan - WA Gateway</title>
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
            <h2 class="mb-4">Kirim Pesan WhatsApp</h2>

            <div class="card shadow-sm col-md-8">
                <div class="card-body">
                    <form action="proses_kirim.php" method="POST">
                        <div class="mb-3">
                            <label for="number" class="form-label">Nomor Tujuan (Contoh: 08123456789)</label>
                            <input type="text" class="form-control" id="number" name="number" required placeholder="08xxxxxx">
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">Pesan yang dikirim</label>
                            <textarea class="form-control" id="message" name="message" rows="4" required placeholder="Tulis pesan Anda di sini..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Kirim Pesan 🚀</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>