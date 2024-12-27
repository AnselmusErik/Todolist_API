<?php
header('Content-Type: application/json');

// Sambungkan ke database
$db = mysqli_connect("localhost", "root", "@nse1l", "platformdb");

// Periksa koneksi database
if (!$db) {
    echo json_encode(["error" => "Koneksi ke database gagal: " . mysqli_connect_error()]);
    exit;
}

// Pastikan metode permintaan adalah POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari body request
    $data = json_decode(file_get_contents('php://input'), true);

    // Validasi input
    if (!$data || !isset($data["username"], $data["old_password"], $data["new_password"])) {
        echo json_encode(["error" => "Semua field wajib diisi!"]);
        exit;
    }

    $username = $data["username"];
    $old_password = $data["old_password"];
    $new_password = $data["new_password"];

    // Periksa apakah pengguna dengan username dan password lama ada
    $stmt = $db->prepare("SELECT * FROM mahasiswa WHERE nama = ? AND nim = ?");
    $stmt->bind_param("ss", $username, $old_password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Pengguna ditemukan, update password
        $stmt = $db->prepare("UPDATE mahasiswa SET nim = ? WHERE nama = ?");
        $stmt->bind_param("ss", $new_password, $username);

        if ($stmt->execute()) {
            echo json_encode(["message" => "Password berhasil direset!"]);
        } else {
            echo json_encode(["error" => "Gagal mereset password. Silakan coba lagi."]);
        }
    } else {
        echo json_encode(["error" => "Username tidak ditemukan atau password lama salah!"]);
    }
} else {
    echo json_encode(["error" => "Invalid request method"]);
}

// Tutup koneksi
$db->close();
?>

