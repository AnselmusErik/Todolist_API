<?php
include '../Config/db.php'; // File koneksi database
include '../Controllers/function.php'; // Helper functions

header('Content-Type: application/json');

// Cek metode HTTP
$method = $_SERVER['REQUEST_METHOD'];

session_start();
if (!isset($_SESSION['mahasiswa_id'])) {
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

$mahasiswa_id = $_SESSION['mahasiswa_id'];

switch ($method) {
    case 'GET':
        // Ambil daftar tugas
        $result = getTasks($db, $mahasiswa_id);
        $tasks = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $tasks[] = $row;
        }
        echo json_encode($tasks);
        break;

    case 'POST':
        // Tambahkan tugas baru
        $task = $_POST['task'] ?? '';
        if (empty($task)) {
            echo json_encode(['error' => 'Task cannot be empty']);
            exit;
        }
        $error = addTask($db, $mahasiswa_id, $task);
        if ($error) {
            echo json_encode(['error' => $error]);
        } else {
            echo json_encode(['message' => 'Task added successfully']);
        }
        break;

    case 'PUT':
        // Tandai tugas selesai atau batal
        parse_str(file_get_contents("php://input"), $_PUT);
        $id = $_PUT['id'] ?? null;
        $status = $_PUT['status'] ?? null;
        if ($id && $status) {
            updateTaskStatus($db, $id, $status);
            echo json_encode(['message' => 'Task status updated']);
        } else {
            echo json_encode(['error' => 'Invalid input']);
        }
        break;

    case 'DELETE':
        // Hapus tugas
        parse_str(file_get_contents("php://input"), $_DELETE);
        $id = $_DELETE['id'] ?? null;
        if ($id) {
            deleteTask($db, $id);
            echo json_encode(['message' => 'Task deleted']);
        } else {
            echo json_encode(['error' => 'Invalid input']);
        }
        break;

    default:
        echo json_encode(['error' => 'Method not allowed']);
        break;
}
?>
