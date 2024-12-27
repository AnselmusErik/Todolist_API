<?php
header('Content-Type: application/json');

// Sambungkan ke database
$db = mysqli_connect("localhost", "root", "@nse1l", "platformdb");

// Pastikan metode permintaan adalah POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $username = $data["username"];
    $password = $data["password"];
    $confirm_password = $data["confirm_password"];

    // Validasi input
    if (empty($username) || empty($password) || empty($confirm_password)) {
        echo json_encode(["error" => "Semua field wajib diisi!"]);
        exit;
    }

    if ($password !== $confirm_password) {
        echo json_encode(["error" => "Password dan konfirmasi password tidak cocok!"]);
        exit;
    }

    // Periksa apakah username sudah digunakan
    $query = "SELECT * FROM mahasiswa WHERE nama = '$username'";
    $result = mysqli_query($db, $query);

    if (mysqli_num_rows($result) > 0) {
        echo json_encode(["error" => "Username sudah digunakan!"]);
        exit;
    }

    // Simpan data pengguna ke dalam database
    $query = "INSERT INTO mahasiswa (nama, nim) VALUES ('$username', '$password')";
    $result = mysqli_query($db, $query);

    if ($result) {
        echo json_encode(["message" => "Registrasi berhasil!"]);
    } else {
        echo json_encode(["error" => "Gagal membuat akun!"]);
    }
} else {
    echo json_encode(["error" => "Invalid request method"]);
}
?>
