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
$allowed_years = range(date('Y') - 2, date('Y') + 2); // Allow current year ±2 years
if (!in_array($tahun, $allowed_years)) {
    $tahun = date('Y'); // Default to current year if invalid
}
$table_name = "data_desa_" . $tahun;

// Check if table exists, if not create it
$check_table = mysqli_query($conn, "SHOW TABLES LIKE '$table_name'");
if (mysqli_num_rows($check_table) == 0) {
    // Create table if it doesn't exist
    $create_table = "CREATE TABLE $table_name (
        id INT AUTO_INCREMENT PRIMARY KEY,
        r101 VARCHAR(2) NOT NULL,
        r102 VARCHAR(2) NOT NULL,
        r103 VARCHAR(3) NOT NULL,
        r104 VARCHAR(3) NOT NULL,
        r201 VARCHAR(100),
        r202 VARCHAR(20),
        r203 DATE,
        r204 VARCHAR(20),
        r301 DECIMAL(10,2),
        r302a VARCHAR(100),
        r302b VARCHAR(100),
        r302c VARCHAR(100),
        r302d VARCHAR(100),
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
        r403a INT,
        r403b INT,
        r403c INT,
        r403d INT,
        r403e INT,
        r403f INT,
        r403g INT,
        r403h INT,
        r501a INT,
        r501b INT,
        r501c INT,
        r501d INT,
        r501e INT,
        r501f INT,
        r501g INT,
        r501h INT,
        r501i INT,
        r501j INT,
        r502a INT,
        r502b INT,
        r502c INT,
        r503a INT,
        r503b INT,
        r504a INT,
        r504b INT,
        r505a INT,
        r505b INT,
        r506a INT,
        r506b INT,
        r507 INT,
        r508 INT,
        r509 INT,
        r510 INT,
        r601 VARCHAR(5),
        r602 VARCHAR(5),
        r603 INT,
        r701a INT,
        r701b INT,
        r701c INT,
        r701d INT,
        r702 INT,
        r703 INT,
        r704 VARCHAR(5),
        r705 VARCHAR(5),
        r801 VARCHAR(5),
        r802 INT,
        namapengesah VARCHAR(100),
        nohppengesah VARCHAR(20),
        catatan TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";
    
    if (!mysqli_query($conn, $create_table)) {
        header("Location: entri-desa.php?tahun=$tahun&error=table_creation_failed");
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
$user_id = $_SESSION['id'] ?? 0;

if($user_id <= 0) {
    header("Location: admin-desa.php?tahun=$tahun&pesan=invalid_session");
    exit();
}

// Prepare fixed values
$r101 = '16'; // Sumatera Selatan
$r102 = '08'; // OKU Selatan
$r103 = $kodekec;
$r103a = $namakec;
$r104a = $kode;
$r104 = $nama;


// List all fields to process
$fields = [
    'r101', 'r102', 'r103','r103a', 'r104','r104a', 'r201', 'r202', 'r203', 'r204',
    'r301', 'r302a', 'r302b', 'r302c', 'r302d', 
    'r401a', 'r401b', 'r401c', 'r401d', 'r401e', 'r401f', 'r401g', 'r401h',
    'r402a', 'r402b', 'r402c', 'r402d', 'r402e', 'r402f', 'r402g', 'r402h',
    'r403a', 'r403b', 'r403c', 'r403d', 'r403e', 'r403f', 'r403g', 'r403h',
    'r501a', 'r501b', 'r501c', 'r501d', 'r501e', 'r501f', 'r501g', 'r501h', 'r501i', 'r501j',
    'r502a', 'r502b', 'r502c', 'r503a', 'r503b', 'r504a', 'r504b', 'r505a', 'r505b',
    'r506a', 'r506b', 'r507', 'r508', 'r509', 'r510',
    'r601', 'r602', 'r603', 'r701a', 'r701b', 'r701c', 'r701d', 'r702', 'r703', 'r704', 'r705',
    'r801', 'r802', 'namapengesah', 'nohppengesah', 'catatan'
];

// Prepare values array and types string
$values = [$r101, $r102, $r103,$r103a, $r104, $r104a];
$types = 'ssssss'; // First 6 fields are strings

// Process all form fields
foreach ($fields as $field) {
    // Skip fixed fields we already added
    if(in_array($field, ['r101', 'r102', 'r103','r103a','r104','r104a'])) continue;
    
    // Get value from POST or set empty
    $value = isset($_POST[$field]) ? mysqli_real_escape_string($conn, $_POST[$field]) : '';
    
    // For numeric fields, ensure they're valid numbers
    if(strpos($field, 'r40') === 0 || strpos($field, 'r50') === 0 || 
       strpos($field, 'r60') === 0 || strpos($field, 'r70') === 0 ||
       strpos($field, 'r80') === 0 || $field === 'r301' || $field === 'r603') {
        $value = is_numeric($value) ? $value : 0;
    }
    
    $values[] = $value;
    $types .= 's'; // All fields treated as strings in prepared statement
}

// Check if this is an update or insert
if(isset($_POST['id']) && !empty($_POST['id'])) {
    // UPDATE existing record
    $id = intval($_POST['id']);
    
    // Build SET clause
    $set_clause = [];
    foreach ($fields as $field) {
        $set_clause[] = "$field = ?";
    }
    $set_clause = implode(', ', $set_clause);
    
    $query = "UPDATE $table_name SET $set_clause WHERE id = ?";
    $types .= 'i'; // Add type for ID parameter
    $values[] = $id;
} else {
    // INSERT new record
    $placeholders = implode(',', array_fill(0, count($fields), '?'));
    $query = "INSERT INTO $table_name (" . implode(',', $fields) . ") VALUES ($placeholders)";
}

// Execute prepared statement
$stmt = mysqli_prepare($conn, $query);
if(!$stmt) {
    die("Prepare failed: " . mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt, $types, ...$values);
$success = mysqli_stmt_execute($stmt);

if ($success) {
    if(isset($_POST['id']) && !empty($_POST['id'])) {
        $pesan = 'update_sukses';
    } else {
        $pesan = 'insert_sukses';
    }
    header("Location: admin.php?tahun=$tahun&pesan=$pesan");
} else {
    $error = mysqli_error($conn);
    if(isset($_POST['id']) && !empty($_POST['id'])) {
        header("Location: edit-desa.php?tahun=$tahun&id=".$_POST['id']."&pesan=update_gagal&error=" . urlencode($error));
    } else {
        header("Location: entri-desa.php?tahun=$tahun&pesan=insert_gagal&error=" . urlencode($error));
    }
}
exit();
?>