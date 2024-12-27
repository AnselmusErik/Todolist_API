<?php  
include '../Config/db.php';  

header('Content-Type: application/json');  

session_start();  

if ($_SERVER['REQUEST_METHOD'] === 'POST') {  
    // Ambil input dari body request  
    $username = $_POST['username'] ?? null;  
    $password = $_POST['password'] ?? null;  

    // Validasi input  
    if (!$username || !$password) {  
        echo json_encode(["error" => "Username dan password harus diisi"]);  
        exit;  
    }  

    // Gunakan prepared statement untuk menghindari SQL Injection  
    $stmt = $db->prepare("SELECT * FROM mahasiswa WHERE nama = ?");  
    $stmt->bind_param("s", $username);  
    $stmt->execute();  
    $result = $stmt->get_result();  

    // Periksa apakah pengguna ditemukan  
    if ($result->num_rows > 0) {  
        $user = $result->fetch_assoc();  

        // Verifikasi password  
        if ($password === $user['nim']) { // Pastikan NIM yang disimpan di database adalah password  
            // Jika login berhasil, simpan username ke sesi  
            $_SESSION["username"] = $username;  
            echo json_encode(["message" => "Login berhasil"]);  
        } else {  
            echo json_encode(["error" => "Password tidak valid"]);  
        }  
    } else {  
        echo json_encode(["error" => "Username tidak ditemukan"]);  
    }  

    // Tutup statement dan koneksi  
    $stmt->close();  
    $db->close();  
} else {  
    echo json_encode(["error" => "Metode permintaan tidak valid"]);  
}  
?>