<?php
session_start();

header('Content-Type: application/json');

// Pastikan metode permintaan adalah POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_destroy();
    echo json_encode(["message" => "Logout successful"]);
} else {
    echo json_encode(["error" => "Invalid request method"]);
}
?>
