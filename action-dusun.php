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

// Check if table exists, if not create it with proper structure
$check_table = mysqli_query($conn, "SHOW TABLES LIKE '$table_name'");
if (mysqli_num_rows($check_table) == 0) {
    // Create table with all required columns
    $create_table = "CREATE TABLE $table_name (
        id INT AUTO_INCREMENT PRIMARY KEY,
        tahun INT NOT NULL,
        r101 VARCHAR(2),
        r102 VARCHAR(2),
        r103 VARCHAR(10),
        r103a VARCHAR(100),
        r104 VARCHAR(10),
        r104a VARCHAR(100),
        r105 VARCHAR(100),
        r105a VARCHAR(10),
        generated_id VARCHAR(50),
        r201 VARCHAR(100),
        r202 VARCHAR(20),
        r203 DATE,
        r204 VARCHAR(20),
        namapengesah VARCHAR(100),
        nohppengesah VARCHAR(20),
        r301a INT,
        r301b INT,
        r301c INT,
        r302a INT,
        r302b INT,
        r302c INT,
        r302d INT,
        r302e INT,
        r302f INT,
        r302g INT,
        r302h INT,
        r302i INT,
        r302j INT,
        r302k INT,
        r302l INT,
        r303a INT,
        r303b INT,
        r303c INT,
        r303d INT,
        r304a INT,
        r304b INT,
        r304c INT,
        r304d INT,
        r304e INT,
        r304f INT,
        r305a INT,
        r305b INT,
        r305c INT,
        r306a INT,
        r306b INT,
        r401a INT,
        r401b INT,
        r401c INT,
        r401d INT,
        r401e INT,
        r401f INT,
        r401g INT,
        r401h INT,
        r402a INT,
        r402b INT,
        r402c INT,
        r402d INT,
        r402e INT,
        r402f INT,
        r402g INT,
        r402h INT,
        r402i INT,
        r403a INT,
        r403b INT,
        r403c INT,
        r403d INT,
        r403e INT,
        r404 INT,
        r501a INT,
        r501b INT,
        r501c INT,
        r501d INT,
        r501e INT,
        r501f INT,
        r501g INT,
        r501h INT,
        r502a INT,
        r502b INT,
        r502c INT,
        r502d INT,
        r502e INT,
        r502f INT,
        r502g INT,
        r502h INT,
        r502i INT,
        r601a INT,
        r601b INT,
        r601c INT,
        r601d INT,
        r601e INT,
        r601f INT,
        r601g INT,
        r601h INT,
        r601i INT,
        r601j INT,
        r601k INT,
        r601l INT,
        r602 INT,
        r701 INT,
        r702 INT,
        r703a INT,
        r703b INT,
        r703c INT,
        r704a INT,
        r704b INT,
        r704c INT,
        r704d INT,
        r705a INT,
        r705b INT,
        r705c INT,
        r705d INT,
        r705e INT,
        r705f INT,
        r705g INT,
        r705h INT,
        r705i INT,
        r705j INT,
        r706a INT,
        r706b INT,
        r706c INT,
        r706d INT,
        r706e INT,
        r707a INT,
        r707b INT,
        r707c INT,
        r707d INT,
        r707e INT,
        r707f INT,
        r707g INT,
        r707h INT,
        r708a INT,
        r708b INT,
        r708c INT,
        r708d INT,
        r708e INT,
        r708f INT,
        r708g INT,
        r801 DECIMAL(10,2),
        r802 DECIMAL(10,2),
        r803 DECIMAL(10,2),
        r804 DECIMAL(10,2),
        r805 DECIMAL(10,2),
        r806a INT,
        r806b INT,
        r806c INT,
        r806d INT,
        catatan TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";
    
    if (!mysqli_query($conn, $create_table)) {
        header("Location: entri.php?tahun=$tahun&error=table_creation_failed&message=".urlencode(mysqli_error($conn)));
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

// List all fields to process (must match table structure)
$fields = [
    'r101', 'r102', 'r103', 'r103a', 'r104', 'r104a', 'r105', 'r105a', 'generated_id',
    'r201', 'r202', 'r203', 'r204', 'namapengesah', 'nohppengesah',
    'r301a', 'r301b', 'r301c', 'r302a', 'r302b', 'r302c', 'r302d', 'r302e', 'r302f', 'r302g', 'r302h',
    'r302i', 'r302j', 'r302k', 'r302l', 'r303a', 'r303b', 'r303c', 'r303d', 'r304a', 'r304b', 'r304c',
    'r304d', 'r304e', 'r304f', 'r305a', 'r305b', 'r305c', 'r306a', 'r306b', 'r401a', 'r401b', 'r401c',
    'r401d', 'r401e', 'r401f', 'r401g', 'r401h', 'r402a', 'r402b', 'r402c', 'r402d', 'r402e', 'r402f',
    'r402g', 'r402h', 'r402i', 'r403a', 'r403b', 'r403c', 'r403d', 'r403e', 'r404', 'r501a', 'r501b',
    'r501c', 'r501d', 'r501e', 'r501f', 'r501g', 'r501h', 'r502a', 'r502b', 'r502c', 'r502d', 'r502e',
    'r502f', 'r502g', 'r502h', 'r502i', 'r601a', 'r601b', 'r601c', 'r601d', 'r601e', 'r601f', 'r601g',
    'r601h', 'r601i', 'r601j', 'r601k', 'r601l', 'r602', 'r701', 'r702', 'r703a', 'r703b', 'r703c',
    'r704a', 'r704b', 'r704c', 'r704d', 'r705a', 'r705b', 'r705c', 'r705d', 'r705e', 'r705f', 'r705g',
    'r705h', 'r705i', 'r705j', 'r706a', 'r706b', 'r706c', 'r706d', 'r706e', 'r707a', 'r707b', 'r707c',
    'r707d', 'r707e', 'r707f', 'r707g', 'r707h', 'r708a', 'r708b', 'r708c', 'r708d', 'r708e', 'r708f',
    'r708g', 'r801', 'r802', 'r803', 'r804', 'r805', 'r806a', 'r806b', 'r806c', 'r806d', 'catatan'
];

// Prepare values array
$values = [
    $r101, $r102, $r103, $r103a, $r104, $r104a, $r105, $r105a, $generated_id
];

// Prepare type string (9 fixed fields: s for string, i for integer)
$types = 'sssssssss';

// Add all field values to parameters array
foreach ($fields as $i => $field) {
    if($i < 9) continue; // Skip fixed fields we already added
    
    $values[] = isset($_POST[$field]) ? $_POST[$field] : '';
    
    // Determine type based on field name
    if (strpos($field, 'r30') === 0 || strpos($field, 'r40') === 0 || 
        strpos($field, 'r50') === 0 || strpos($field, 'r60') === 0 ||
        strpos($field, 'r70') === 0 || strpos($field, 'r80') === 0) {
        $types .= 'i'; // Integer for numeric fields
    } elseif (strpos($field, 'r20') === 0 || strpos($field, 'r10') === 0) {
        $types .= 's'; // String for text fields
    } elseif ($field === 'r203') {
        $types .= 's'; // Date field
    } else {
        $types .= 's'; // Default to string
    }
}

// Build query
$placeholders = implode(',', array_fill(0, count($values), '?'));
$query = "INSERT INTO $table_name (" . implode(',', $fields) . ") VALUES ($placeholders)";

// Execute prepared statement
$stmt = mysqli_prepare($conn, $query);
if(!$stmt) {
    header("Location: entri.php?tahun=$tahun&pesan=prepare_failed&error=".urlencode(mysqli_error($conn)));
    exit();
}

mysqli_stmt_bind_param($stmt, $types, ...$values);
$success = mysqli_stmt_execute($stmt);

if ($success && mysqli_stmt_affected_rows($stmt) > 0) {
    header("Location: admin.php?tahun=$tahun&pesan=insert_sukses");
} else {
    header("Location: entri.php?tahun=$tahun&pesan=insert_gagal&error=".urlencode(mysqli_error($conn)));
}
exit();
?>