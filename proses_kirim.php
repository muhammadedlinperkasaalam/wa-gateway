<!-- proses_kirim.php -->
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $number = $_POST['number'];
    $message = $_POST['message'];

    // Endpoint API Node.js yang sudah kita buat
    $url = 'http://localhost:3000/api/send';

    // Data yang akan dikirim (Format JSON)
    $data = array(
        'number' => $number,
        'message' => $message
    );

    $ch = curl_init($url);

    // Setel cURL
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json'
    ));

    // Eksekusi cURL
    $response = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    $result = json_decode($response, true);

    echo "<div style='font-family: Arial; text-align:center; margin-top:50px;'>";
    if ($httpcode == 200 && $result['status'] == true) {
        echo "<h2 style='color:green;'>✅ Pesan Berhasil Dikirim!</h2>";
    } else {
        echo "<h2 style='color:red;'>❌ Gagal mengirim pesan.</h2>";
        echo "<p>Pesan Error: " . ($result['message'] ?? 'Tidak diketahui (Cek apakah WA sudah login)') . "</p>";
    }

    echo "<br><a href='kirim.php' style='padding: 10px 20px; background: #007bff; color: white; text-decoration:none; border-radius: 5px;'>Kembali</a>";
    echo "</div>";
} else {
    echo "Akses tidak sah.";
}
?>