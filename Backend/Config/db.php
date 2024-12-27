<?php
$db = new mysqli('localhost', 'root', '@nse1l', 'platformdb');
if ($db->connect_error) {
    die("Koneksi gagal: " . $db->connect_error);
}
?>
