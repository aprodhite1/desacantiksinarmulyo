<?php
// File: delete.php
// Description: Menangani penghapusan data dengan keamanan yang lebih baik

// Mulai session dan cek login
session_start();
if (!isset($_SESSION['uname'])) {
    header("Location: login.php?pesan=belum_login");
    exit();
}

include_once("koneksi.php");

// Validasi parameter ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: admin.php?pesan=invalid_id");
    exit();
}

$id = (int)$_GET['id'];
$tahun = isset($_GET['tahun']) ? intval($_GET['tahun']) : 2025;
$table_name = "data" . $tahun;

// Validasi nama tabel untuk mencegah SQL injection
$allowed_tables = ['data2023', 'data2024', 'data2025'];
if (!in_array($table_name, $allowed_tables)) {
    header("Location: admin.php?pesan=invalid_table");
    exit();
}

// Gunakan prepared statement untuk mencegah SQL injection
$stmt = $conn->prepare("DELETE FROM $table_name WHERE ID = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    header("Location: admin.php?tahun=$tahun&pesan=delete_sukses");
} else {
    header("Location: admin.php?tahun=$tahun&pesan=delete_gagal");
}

$stmt->close();
$conn->close();
exit();
?>