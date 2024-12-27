<?php
// Mulai sesi
// session_start();

// // Sambungkan ke database Anda di sini
// $db = mysqli_connect("localhost", "root", "@nse1l", "platformdb");

// function checkSession()
// {
//     if (!isset($_SESSION["username"])) {
//         // Jika belum, alihkan ke halaman login
//         header("Location: login.php");
//         exit;
//     }
// }

// function getNama()
// {
//     global $db;
//     // Dapatkan nama dari sesi
//     $nama = $_SESSION["username"];

//     // Pertama, dapatkan id mahasiswa dari tabel mahasiswa
//     $query = "SELECT id FROM mahasiswa WHERE nama = '$nama'";
//     $result = mysqli_query($db, $query);
//     $row = mysqli_fetch_assoc($result);
//     $mahasiswa_id = $row['id'];

//     return array($nama, $mahasiswa_id);
// }

// function handlePostRequest()
// {
//     global $db;
//     // Dapatkan id mahasiswa
//     list($nama, $mahasiswa_id) = getNama();

//     // Jika form ditambahkan, simpan tugas baru ke database
//     if (isset($_POST["add"])) {
//         $task = $_POST["task"];
//         if (empty($task)) {
//             return 'Wajib isi terlebih dahulu!';
//         } else {
//             $query = "INSERT INTO todolist (task, mahasiswa_id) VALUES ('$task', '$mahasiswa_id')";
//             mysqli_query($db, $query);
//         }
//     }

//     // Jika form selesai disubmit, ubah status tugas
//     if (isset($_POST["done"])) {
//         $id = $_POST["id"];
//         $query = "UPDATE todolist SET status = '1' WHERE id = '$id'";
//         mysqli_query($db, $query);
//     }

//     // Jika form batal disubmit, ubah status tugas
//     if (isset($_POST["cancel"])) {
//         $id = $_POST["id"];
//         $query = "UPDATE todolist SET status = '0' WHERE id = '$id'";
//         mysqli_query($db, $query);
//     }

//     // Jika form hapus disubmit, hapus tugas dari database
//     if (isset($_POST["delete"])) {
//         $id = $_POST["id"];
//         $query = "DELETE FROM todolist WHERE id = '$id'";
//         mysqli_query($db, $query);
//     }

//     return null;
// }

// function getTasks($mahasiswa_id)
// {
//     global $db;
//     // Kemudian, gunakan id mahasiswa untuk mendapatkan semua tugas dari pengguna yang sedang login
//     $query = "SELECT * FROM todolist WHERE mahasiswa_id = '$mahasiswa_id'";
//     $result = mysqli_query($db, $query);

//     return $result;
// }






// Mengecek sesi pengguna
function checkSession()
{
    if (!isset($_SESSION["username"])) {
        header("HTTP/1.1 401 Unauthorized");
        echo json_encode(["error" => "Unauthorized"]);
        exit;
    }
}

// Mengambil nama dan ID mahasiswa berdasarkan sesi pengguna
function getNama($db)
{
    $nama = $_SESSION["username"];
    $query = "SELECT id FROM mahasiswa WHERE nama = '$nama'";
    $result = mysqli_query($db, $query);

    if ($result && $row = mysqli_fetch_assoc($result)) {
        return [$nama, $row['id']];
    }

    return [null, null];
}

// Menambahkan tugas baru
function addTask($db, $mahasiswa_id, $task)
{
    if (empty($task)) {
        return "Task cannot be empty";
    }

    $query = "INSERT INTO todolist (task, mahasiswa_id) VALUES ('$task', '$mahasiswa_id')";
    if (mysqli_query($db, $query)) {
        return null;
    }

    return "Failed to add task: " . mysqli_error($db);
}

// Mengambil daftar tugas
function getTasks($db, $mahasiswa_id)
{
    $query = "SELECT * FROM todolist WHERE mahasiswa_id = '$mahasiswa_id'";
    return mysqli_query($db, $query);
}

// Memperbarui status tugas
function updateTaskStatus($db, $id, $status)
{
    $query = "UPDATE todolist SET status = '$status' WHERE id = '$id'";
    return mysqli_query($db, $query);
}

// Menghapus tugas
function deleteTask($db, $id)
{
    $query = "DELETE FROM todolist WHERE id = '$id'";
    return mysqli_query($db, $query);
}
?>
