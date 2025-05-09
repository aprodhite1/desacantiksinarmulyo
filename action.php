<?php
// Start session and check if user is logged in
session_start();
if(!isset($_SESSION['uname'])) {
    header("Location: login.php?pesan=belum_login");
    exit();
}

include 'koneksi.php';

// Get and validate year parameter
$tahun = isset($_POST['tahun']) ? intval($_POST['tahun']) : date('Y');
$allowed_years = [2023, 2024, 2025, 2026, 2027];
if (!in_array($tahun, $allowed_years)) {
    $tahun = date('Y'); // Default to current year if invalid
}
$table_name = "data" . $tahun;

// Check if table exists, if not create it
$check_table = mysqli_query($conn, "SHOW TABLES LIKE '$table_name'");
if (mysqli_num_rows($check_table) == 0) {
    // Create table if it doesn't exist
    $create_table = "CREATE TABLE $table_name LIKE data2023"; // Assuming 2023 is your base structure
    if (!mysqli_query($conn, $create_table)) {
        header("Location: entri.php?tahun=$tahun&error=table_creation_failed");
        exit();
    }
}

// Get session data
$uname = $_SESSION['uname'] ?? '';
$level = $_SESSION['level'] ?? '';
$nama = $_SESSION['nama_desa1'] ?? '';
$kode = $_SESSION['kode_desa'] ?? '';
$namakec = $_SESSION['nama_kec1'] ?? '';
$kodekec = $_SESSION['kode_kec'] ?? '';
$id = $_SESSION['id'] ?? 0;

if($id <= 0) {
    header("Location: admin.php?tahun=$tahun&pesan=invalid_session");
    exit();
}

// Prepare fixed values
$r101 = '16';
$r102 = '08';
$r103 = $kodekec;
$r103a = $namakec;
$r104 = $kode;
$r104a = $nama;
$r105 = isset($_POST['r105']) ? mysqli_real_escape_string($conn, $_POST['r105']) : '';
$r105a = isset($_POST['r105a']) ? mysqli_real_escape_string($conn, $_POST['r105a']) : '';
$generated_id = $r101 . $r102 . $r103 . $r104 . $r105a;







// List all fields to process
$fields = [
    'r101', 'r102', 'r103', 'r103a', 'r104', 'r104a', 'r105', 'r105a', 'id',
    'r201', 'r202', 'r203', 'r204', 'namapengesah', 'nohppengesah',
    'r301a', 'r301b', 'r301c', 'r302a', 'r302b', 'r302c', 'r302d', 'r302e', 'r302f', 'r302g', 'r302h',
    'r302i', 'r302j', 'r302k', 'r302l', 'r303', 'r401a', 'r401b', 'r401c', 'r401d', 'r401e', 'r401f', 'r401g',
    'r402', 'r501a', 'r501b', 'r501c', 'r501d', 'r501e', 'r501f', 'r501g', 'r501h', 'r501i', 'r501j', 'r501k',
    'r502a', 'r502b', 'r502c', 'r502d', 'r503', 'r504', 'r505', 'r506', 'r507', 'r508', 'r509',
    'r601a', 'r601b', 'r601c', 'r601d', 'r601e', 'r601f', 'r601g', 'r601h',
    'r602a', 'r602b', 'r602c', 'r602d', 'r602e', 'r602f', 'r602g', 'r602h', 'r602i', 'r603',
    'r701', 'r702', 'r801a', 'r801b', 'r801c', 'r801d', 'r801e', 'r801f', 'r801g', 'r801h', 'r801i', 'r801j', 'r801k', 'r801l',
    'r802', 'r901', 'r902', 'r903', 'r904', 'r905a', 'r905b', 'r905c', 'r906a', 'r906b', 'r906c', 'r906d',
    'r907a', 'r907b', 'r907c', 'r907d', 'r907e', 'r907f', 'r907g', 'r907h', 'r907i', 'r907j',
    'r908a', 'r908b', 'r908c', 'r908d', 'r908e', 'r908f', 'catatan'
];
$values = [
    $r101, $r102, $r103, $r103a, $r104, $r104a, $r105, $r105a, $generated_id
];
// Prepare type string (9 fixed fields: i for id, s for others)
$types = 'ssssssssi';


// Add all field values to parameters array
foreach ($fields as $i => $field) {
    if($i < 9) continue; // Skip fixed fields we already added
    
    $values[] = isset($_POST[$field]) ? mysqli_real_escape_string($conn, $_POST[$field]) : '';
    $types .= 's'; // All other fields are strings
}

// Build query
$placeholders = implode(',', array_fill(0, count($values), '?'));
$query = "INSERT INTO $table_name (" . implode(',', $fields) . ") VALUES ($placeholders)";

// Execute prepared statement
$stmt = mysqli_prepare($conn, $query);
if(!$stmt) {
    die("Prepare failed: " . mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt, $types, ...$values);
$success = mysqli_stmt_execute($stmt);

if ($success && mysqli_stmt_affected_rows($stmt) > 0) {
    header("Location: admin.php?tahun=$tahun&pesan=insert_sukses");
} else {
    header("Location: entri.php?tahun=$tahun&pesan=insert_gagal&error=" . urlencode(mysqli_error($conn)));
}
exit();
?>