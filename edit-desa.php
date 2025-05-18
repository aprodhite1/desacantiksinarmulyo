<?php
// Start session and check login
session_start();
if(!isset($_SESSION['uname'])) {
    header("Location: login.php?pesan=belum_login");
    exit();
}

include_once("koneksi.php");

// Get year parameter and validate
$tahun = isset($_GET['tahun']) ? intval($_GET['tahun']) : date('Y');
$allowed_years = range(date('Y') - 2, date('Y') + 2); // Allow current year ±2 years
if(!in_array($tahun, $allowed_years)) {
    $tahun = date('Y'); // Default to current year if invalid
}
$table_name = "data" . $tahun;

// Validate and sanitize ID
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if($id <= 0) {
    header("Location: admin-desa.php?tahun=$tahun&pesan=invalid_id");
    exit();
}

// Fetch village data using prepared statement
$stmt = $conn->prepare("SELECT * FROM $table_name WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows == 0) {
    header("Location: admin-desa.php?tahun=$tahun&pesan=data_not_found");
    exit();
}

$desa_data = $result->fetch_assoc();

// Process form submission
if(isset($_POST['update'])) {
    // Initialize all variables with default values
    $fields = [
        'r101', 'r102', 'r103','r103a', 'r104','r104a', 'r105', 'r201', 'r202', 'r203', 'r204',
        'r301', 'r302a', 'r302b', 'r302c', 'r302d', 'r401a', 'r401b', 'r401c',
        'r401d', 'r401e', 'r401f', 'r401g', 'r401h', 'r402a', 'r402b', 'r402c',
        'r402d', 'r402e', 'r402f', 'r402g', 'r402h', 'r403a', 'r403b', 'r403c',
        'r403d', 'r403e', 'r403f', 'r403g', 'r403h', 'r501a', 'r501b', 'r501c',
        'r501d', 'r501e', 'r501f', 'r501g', 'r501h', 'r501i', 'r501j', 'r502a',
        'r502b', 'r502c', 'r503a', 'r503b', 'r504a', 'r504b', 'r505a', 'r505b',
        'r506a', 'r506b', 'r507', 'r508', 'r509', 'r510', 'r601', 'r602', 'r603',
        'r701a', 'r701b', 'r701c', 'r701d', 'r702', 'r703', 'r704', 'r705', 'r801',
        'r802', 'catatan', 'namapengesah', 'nohppengesah'
    ];
    
    $params = [];
    $types = '';
    $set_clause = '';
    
    foreach($fields as $field) {
        ${$field} = isset($_POST[$field]) ? mysqli_real_escape_string($conn, $_POST[$field]) : '';
        $params[] = ${$field};
        $types .= 's';
        $set_clause .= "$field = ?, ";
    }
    
    // Remove trailing comma
    $set_clause = rtrim($set_clause, ', ');
    
    // Add ID to params
    $params[] = $id;
    $types .= 'i';
    
    // Prepare and execute update query
    $update_stmt = $conn->prepare("UPDATE $table_name SET $set_clause WHERE id = ?");
    $update_stmt->bind_param($types, ...$params);
    
    if($update_stmt->execute()) {
        header("Location: admin-desa.php?tahun=$tahun&pesan=update_sukses");
    } else {
        header("Location: admin-desa.php?tahun=$tahun&pesan=update_gagal");
    }
    exit();
}

// Get session data
$uname = $_SESSION['uname'] ?? '';
$level = $_SESSION['level'] ?? '';
$nama = $_SESSION['nama_desa1'] ?? '';
$kode = $_SESSION['kode_desa'] ?? '';
$namakec = $_SESSION['nama_kec1'] ?? '';
$kodekec = $_SESSION['kode_kec'] ?? '';
$user_id = $_SESSION['id'] ?? '';
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <title>Edit Data Desa - <?php echo htmlspecialchars($nama); ?> (<?php echo $tahun; ?>)</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <style>
    :root {
        --primary-color: #d2b356;
        --secondary-color: #2c3e50;
        --accent-color: #3498db;
        --light-gray: #f8f9fa;
        --medium-gray: #e9ecef;
        --dark-gray: #495057;
        --success-color: #28a745;
        --danger-color: #dc3545;
        --warning-color: #ffc107;
        --info-color: #17a2b8;
    }

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        line-height: 1.6;
        color: var(--secondary-color);
        background-color: #f5f5f5;
        margin: 0;
        padding: 20px;
    }

    .container {
        max-width: 1400px;
        margin: 0 auto;
        background-color: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    }

    .kop {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 20px;
        border-bottom: 2px solid var(--primary-color);
        flex-wrap: wrap;
    }

    .kotak2 pre {
        margin: 0;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        font-size: 14px;
        color: var(--secondary-color);
    }

    .judul h3 {
        text-align: center;
        color: var(--secondary-color);
        margin-bottom: 30px;
        padding-bottom: 15px;
        border-bottom: 2px solid var(--primary-color);
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 30px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
    }

    th {
        background-color: var(--primary-color);
        color: white;
        font-weight: 600;
        padding: 15px;
        text-align: left;
    }

    td {
        padding: 10px 15px;
        border-bottom: 1px solid var(--medium-gray);
        vertical-align: top;
    }

    tr:nth-child(even) {
        background-color: var(--light-gray);
    }

    tr:hover {
        background-color: rgba(210, 179, 86, 0.1);
    }

    input[type="text"],
    input[type="date"],
    input[type="number"],
    textarea,
    select {
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        width: 100%;
        max-width: 200px;
        transition: border-color 0.3s;
        background-color: white;
        font-family: inherit;
        font-size: inherit;
    }

    input[type="text"]:focus,
    input[type="date"]:focus,
    input[type="number"]:focus,
    textarea:focus,
    select:focus {
        border-color: var(--primary-color);
        outline: none;
        box-shadow: 0 0 0 3px rgba(210, 179, 86, 0.2);
    }

    textarea {
        min-height: 100px;
        resize: vertical;
        width: 100%;
    }

    select {
        appearance: none;
        background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 10px center;
        background-size: 1em;
    }

    button[type="submit"] {
        background-color: var(--primary-color);
        color: white;
        padding: 12px 24px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
        font-weight: 600;
        margin: 20px auto;
        transition: background-color 0.3s, transform 0.2s;
        display: block;
    }

    button[type="submit"]:hover {
        background-color: #c0a04d;
        transform: translateY(-2px);
    }

    button[type="submit"]:active {
        transform: translateY(0);
    }

    /* Responsive design */
    @media (max-width: 768px) {
        .kop {
            flex-direction: column;
            text-align: center;
        }

        .kotak1,
        .kotak2,
        .kotak3 {
            margin-bottom: 15px;
            width: 100%;
            text-align: center;
        }

        table {
            display: block;
            overflow-x: auto;
            white-space: nowrap;
        }

        input[type="text"],
        input[type="date"],
        input[type="number"],
        textarea,
        select {
            max-width: 100%;
        }
    }

    /* Logo container */
    .logo-container {
        display: flex;
        gap: 15px;
        align-items: center;
        flex-wrap: wrap;
        justify-content: center;
    }
    </style>
</head>

<body>
    <div class="container">
        <div class="kop">
            <div class="kotak1 logo-container">
                <img src="images/logo-descan.png" height="50" alt="Logo Descan">
                <img src="images/logo-bps.png" height="50" alt="Logo BPS">
                <img src="images/logo-okus.png" height="50" alt="Logo OKUS">
            </div>
            <div class="kotak2">
                <pre>
PEMERINTAH KABUPATEN OGAN KOMERING ULU SELATAN
DAN
BADAN PUSAT STATISTIK KABUPATEN OGAN KOMERING ULU SELATAN
                </pre>
            </div>
            <div class="kotak3">
                <h3>V-DESCAN23</h3>
            </div>
        </div>

        <div class="judul">
            <h3>PENDATAAN POTENSI TINGKAT DESA TAHUN <?php echo htmlspecialchars($tahun); ?></h3>
        </div>

        <form method="POST" action="">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input type="hidden" name="tahun" value="<?php echo $tahun; ?>">

            <!-- Blok I: Keterangan Tempat -->
            <table>
                <tr>
                    <th colspan="4">BLOK I: KETERANGAN TEMPAT</th>
                </tr>
                <tr>
                    <td style="text-align:center">101.</td>
                    <td style="border-right:none">Provinsi</td>
                    <td style="border-left:none">: Sumatera Selatan</td>
                    <td style="text-align:right">16</td>
                </tr>
                <tr>
                    <td style="text-align:center">102.</td>
                    <td style="border-right:none">Kabupaten/Kota</td>
                    <td style="border-left:none">: Ogan Komering Ulu Selatan</td>
                    <td style="text-align:right">08</td>
                </tr>
                <tr>
                    <td style="text-align:center">103.</td>
                    <td style="border-right:none">Kecamatan</td>
                    <td style="border-left:none">: <?php echo htmlspecialchars($namakec); ?></td>
                    <td style="text-align:right"><?php echo htmlspecialchars($kodekec); ?></td>
                </tr>
                <tr>
                    <td style="text-align:center">104.</td>
                    <td style="border-right:none">Desa/Kelurahan</td>
                    <td style="border-left:none">: <?php echo htmlspecialchars($nama); ?></td>
                    <td style="text-align:right"><?php echo htmlspecialchars($kode); ?></td>
                </tr>
            </table>

            <!-- Blok II: Keterangan Petugas -->
            <table>
                <tr>
                    <th colspan="4">BLOK II: KETERANGAN PETUGAS</th>
                </tr>
                <tr>
                    <td colspan="2" style="text-align:center; font-weight:bold;">Pencacahan</td>
                    <td colspan="2" style="text-align:center;font-weight:bold;">Pengesahan Kepala Desa
                    </td>
                </tr>
                <tr>
                    <td style="text-align:center">201.</td>
                    <td style="border-right:none">Nama Agen Statistik</td>
                    <td style="border-left:none">: <input type="text" name="r201"
                            value="<?php echo htmlspecialchars($desa_data['r201'] ?? ''); ?>" required></td>
                    <td rowspan="4" style="text-align:center">
                        Nama Lengkap : <br>
                        <input type="text" name="namapengesah"
                            value="<?php echo htmlspecialchars($desa_data['namapengesah'] ?? ''); ?>" required><br><br>
                        Nomor Handphone : <br>
                        <input type="text" name="nohppengesah"
                            value="<?php echo htmlspecialchars($desa_data['nohppengesah'] ?? ''); ?>" required><br>
                    </td>
                </tr>
                <tr>
                    <td style="text-align:center">202.</td>
                    <td style="border-right:none">Kode Agen Statistik</td>
                    <td style="border-left:none">: <input type="text" name="r202"
                            value="<?php echo htmlspecialchars($desa_data['r202'] ?? ''); ?>" required></td>
                </tr>
                <tr>
                    <td style="text-align:center">203.</td>
                    <td style="border-right:none">Tanggal/Bulan/Tahun Pelaksanaan</td>
                    <td style="border-left:none">: <input type="date" name="r203"
                            value="<?php echo htmlspecialchars($desa_data['r203'] ?? ''); ?>" required></td>
                </tr>
                <tr>
                    <td style="text-align:center">204.</td>
                    <td style="border-right:none">Nomor Handphone</td>
                    <td style="border-left:none">: <input type="text" name="r204"
                            value="<?php echo htmlspecialchars($desa_data['r204'] ?? ''); ?>" required></td>
                </tr>
            </table>

            <!-- Blok III: Kependudukan -->
            <table>
                <tr>
                    <th colspan="8">BLOK III: KEPENDUDUKAN</th>
                </tr>
                <tr>
                    <td style="text-align:center">301.</td>
                    <td style="border-right:none" colspan="6">Luas Wilayah (hektar):</td>
                    <td style="border-left:none"><input type="number" style="width:50px" name="r301" min="0" step="0.01"
                            value="<?php echo htmlspecialchars($desa_data['r301'] ?? ''); ?>" required></td>
                </tr>
                <tr>
                    <td style="text-align:center" rowspan="5">302.</td>
                    <td colspan="7">Letak Geografis:</td>
                </tr>
                <tr>
                    <td style="border-left:none;border-right:none">a. Batas Utara</td>
                    <td style="border-left:none;border-right:none"><input type="text" style="width:150px" name="r302a"
                            value="<?php echo htmlspecialchars($desa_data['r302a'] ?? ''); ?>"></td>
                </tr>
                <tr>
                    <td style="border-left:none;border-right:none">b. Batas Selatan</td>
                    <td style="border-left:none;border-right:none"><input type="text" style="width:150px" name="r302b"
                            value="<?php echo htmlspecialchars($desa_data['r302b'] ?? ''); ?>"></td>
                </tr>
                <tr>
                    <td style="border-left:none;border-right:none">c. Batas Barat</td>
                    <td style="border-left:none;border-right:none"><input type="text" style="width:150px" name="r302c"
                            value="<?php echo htmlspecialchars($desa_data['r302c'] ?? ''); ?>"></td>
                </tr>
                <tr>
                    <td style="border-left:none;border-right:none">d. Batas Timur</td>
                    <td style="border-left:none;border-right:none"><input type="text" style="width:150px" name="r302d"
                            value="<?php echo htmlspecialchars($desa_data['r302d'] ?? ''); ?>"></td>
                </tr>
            </table>

            <!-- Blok IV: Pendidikan -->
            <table>
                <tr>
                    <th colspan="8">BLOK IV: PENDIDIKAN</th>
                </tr>
                <tr>
                    <td style="text-align:center" rowspan="5">401.</td>
                    <td colspan="7">Jumlah sarana pendidikan menurut jenjang pendidikan di Desa:</td>
                </tr>
                <tr>
                    <td>a. PAUD/TK/RA/BA</td>
                    <td><input type="number" style="width:50px" name="r401a" min="0"
                            value="<?php echo htmlspecialchars($desa_data['r401a'] ?? ''); ?>"></td>
                    <td>e. Akademi/Perguruan Tinggi</td>
                    <td><input type="number" style="width:50px" name="r401e" min="0"
                            value="<?php echo htmlspecialchars($desa_data['r401e'] ?? ''); ?>"></td>
                </tr>
                <tr>
                    <td>b. SD/MI</td>
                    <td><input type="number" style="width:50px" name="r401b" min="0"
                            value="<?php echo htmlspecialchars($desa_data['r401b'] ?? ''); ?>"></td>
                    <td>f. SDLB/SMPLB/SMALB</td>
                    <td><input type="number" style="width:50px" name="r401f" min="0"
                            value="<?php echo htmlspecialchars($desa_data['r401f'] ?? ''); ?>"></td>
                </tr>
                <tr>
                    <td>c. SMP/MTs</td>
                    <td><input type="number" style="width:50px" name="r401c" min="0"
                            value="<?php echo htmlspecialchars($desa_data['r401c'] ?? ''); ?>"></td>
                    <td>g. Pondok Pesantren</td>
                    <td><input type="number" style="width:50px" name="r401g" min="0"
                            value="<?php echo htmlspecialchars($desa_data['r401g'] ?? ''); ?>"></td>
                </tr>
                <tr>
                    <td>d. SMA/MA/SMK</td>
                    <td><input type="number" style="width:50px" name="r401d" min="0"
                            value="<?php echo htmlspecialchars($desa_data['r401d'] ?? ''); ?>"></td>
                    <td>h. Madrasah Diniyah</td>
                    <td><input type="number" style="width:50px" name="r401h" min="0"
                            value="<?php echo htmlspecialchars($desa_data['r401h'] ?? ''); ?>"></td>
                </tr>
                <tr>
                    <td style="text-align:center" rowspan="5">402.</td>
                    <td colspan="7">Jumlah guru menurut jenjang pendidikan di Desa:</td>
                </tr>
                <tr>
                    <td>a. PAUD/TK/RA/BA</td>
                    <td><input type="number" style="width:50px" name="r402a" min="0"
                            value="<?php echo htmlspecialchars($desa_data['r402a'] ?? ''); ?>"></td>
                    <td>e. Akademi/Perguruan Tinggi</td>
                    <td><input type="number" style="width:50px" name="r402e" min="0"
                            value="<?php echo htmlspecialchars($desa_data['r402e'] ?? ''); ?>"></td>
                </tr>
                <tr>
                    <td>b. SD/MI</td>
                    <td><input type="number" style="width:50px" name="r402b" min="0"
                            value="<?php echo htmlspecialchars($desa_data['r402b'] ?? ''); ?>"></td>
                    <td>f. SDLB/SMPLB/SMALB</td>
                    <td><input type="number" style="width:50px" name="r402f" min="0"
                            value="<?php echo htmlspecialchars($desa_data['r402f'] ?? ''); ?>"></td>
                </tr>
                <tr>
                    <td>c. SMP/MTs</td>
                    <td><input type="number" style="width:50px" name="r402c" min="0"
                            value="<?php echo htmlspecialchars($desa_data['r402c'] ?? ''); ?>"></td>
                    <td>g. Pondok Pesantren</td>
                    <td><input type="number" style="width:50px" name="r402g" min="0"
                            value="<?php echo htmlspecialchars($desa_data['r402g'] ?? ''); ?>"></td>
                </tr>
                <tr>
                    <td>d. SMA/MA/SMK</td>
                    <td><input type="number" style="width:50px" name="r402d" min="0"
                            value="<?php echo htmlspecialchars($desa_data['r402d'] ?? ''); ?>"></td>
                    <td>h. Madrasah Diniyah</td>
                    <td><input type="number" style="width:50px" name="r402h" min="0"
                            value="<?php echo htmlspecialchars($desa_data['r402h'] ?? ''); ?>"></td>
                </tr>
                <tr>
                    <td style="text-align:center" rowspan="5">403.</td>
                    <td colspan="7">Jumlah Murid menurut jenjang pendidikan di Desa:</td>
                </tr>
                <tr>
                    <td>a. PAUD/TK/RA/BA</td>
                    <td><input type="number" style="width:50px" name="r403a" min="0"
                            value="<?php echo htmlspecialchars($desa_data['r403a'] ?? ''); ?>"></td>
                    <td>e. Akademi/Perguruan Tinggi</td>
                    <td><input type="number" style="width:50px" name="r403e" min="0"
                            value="<?php echo htmlspecialchars($desa_data['r403e'] ?? ''); ?>"></td>
                </tr>
                <tr>
                    <td>b. SD/MI</td>
                    <td><input type="number" style="width:50px" name="r403b" min="0"
                            value="<?php echo htmlspecialchars($desa_data['r403b'] ?? ''); ?>"></td>
                    <td>f. SDLB/SMPLB/SMALB</td>
                    <td><input type="number" style="width:50px" name="r403f" min="0"
                            value="<?php echo htmlspecialchars($desa_data['r403f'] ?? ''); ?>"></td>
                </tr>
                <tr>
                    <td>c. SMP/MTs</td>
                    <td><input type="number" style="width:50px" name="r403c" min="0"
                            value="<?php echo htmlspecialchars($desa_data['r403c'] ?? ''); ?>"></td>
                    <td>g. Pondok Pesantren</td>
                    <td><input type="number" style="width:50px" name="r403g" min="0"
                            value="<?php echo htmlspecialchars($desa_data['r403g'] ?? ''); ?>"></td>
                </tr>
                <tr>
                    <td>d. SMA/MA/SMK</td>
                    <td><input type="number" style="width:50px" name="r403d" min="0"
                            value="<?php echo htmlspecialchars($desa_data['r403d'] ?? ''); ?>"></td>
                    <td>h. Madrasah Diniyah</td>
                    <td><input type="number" style="width:50px" name="r403h" min="0"
                            value="<?php echo htmlspecialchars($desa_data['r403h'] ?? ''); ?>"></td>
                </tr>
            </table>

            <!-- Blok V: Kesehatan -->
            <table>
                <tr>
                    <th colspan="8">BLOK V: KESEHATAN</th>
                </tr>
                <tr>
                    <td style="text-align:center" rowspan="6">501.</td>
                    <td colspan="7">Jumlah sarana kesehatan di Desa:</td>
                </tr>
                <tr>
                    <td>a. Rumah sakit</td>
                    <td><input type="number" style="width:50px" name="r501a" min="0"
                            value="<?php echo htmlspecialchars($desa_data['r501a'] ?? ''); ?>"></td>
                    <td>f. Rumah bersalin</td>
                    <td><input type="number" style="width:50px" name="r501f" min="0"
                            value="<?php echo htmlspecialchars($desa_data['r501f'] ?? ''); ?>"></td>
                </tr>
                <tr>
                    <td>b. Puskesmas</td>
                    <td><input type="number" style="width:50px" name="r501b" min="0"
                            value="<?php echo htmlspecialchars($desa_data['r501b'] ?? ''); ?>"></td>
                    <td>g. Tempat praktik bidan</td>
                    <td><input type="number" style="width:50px" name="r501g" min="0"
                            value="<?php echo htmlspecialchars($desa_data['r501g'] ?? ''); ?>"></td>
                </tr>
                <tr>
                    <td>c. Poliklinik/balai pengobatan</td>
                    <td><input type="number" style="width:50px" name="r501c" min="0"
                            value="<?php echo htmlspecialchars($desa_data['r501c'] ?? ''); ?>"></td>
                    <td>h. Poskesdes (Pos Kesehatan Desa)</td>
                    <td><input type="number" style="width:50px" name="r501h" min="0"
                            value="<?php echo htmlspecialchars($desa_data['r501h'] ?? ''); ?>"></td>
                </tr>
                <tr>
                    <td>d. Tempat praktik dokter</td>
                    <td><input type="number" style="width:50px" name="r501d" min="0"
                            value="<?php echo htmlspecialchars($desa_data['r501d'] ?? ''); ?>"></td>
                    <td>i. Puskesmas pembantu</td>
                    <td><input type="number" style="width:50px" name="r501i" min="0"
                            value="<?php echo htmlspecialchars($desa_data['r501i'] ?? ''); ?>"></td>
                </tr>
                <tr>
                    <td>e. Apotek</td>
                    <td><input type="number" style="width:50px" name="r501e" min="0"
                            value="<?php echo htmlspecialchars($desa_data['r501e'] ?? ''); ?>"></td>
                    <td>j. Toko khusus obat/jamu</td>
                    <td><input type="number" style="width:50px" name="r501j" min="0"
                            value="<?php echo htmlspecialchars($desa_data['r501j'] ?? ''); ?>"></td>
                </tr>
                <tr>
                    <td style="text-align:center" rowspan="3">502.</td>
                    <td colspan="7">Kualitas Ibu Hamil</td>
                </tr>
                <tr>
                    <td>a. Jumlah ibu hamil</td>
                    <td><input type="number" style="width:50px" name="r502a" min="0"
                            value="<?php echo htmlspecialchars($desa_data['r502a'] ?? ''); ?>"></td>
                    <td>c. Jumlah ibu hamil melahirkan</td>
                    <td><input type="number" style="width:50px" name="r502c" min="0"
                            value="<?php echo htmlspecialchars($desa_data['r502c'] ?? ''); ?>"></td>
                </tr>
                <tr>
                    <td>b. Jumlah kematian ibu hamil</td>
                    <td><input type="number" style="width:50px" name="r502b" min="0"
                            value="<?php echo htmlspecialchars($desa_data['r502b'] ?? ''); ?>"></td>
                </tr>
                <tr>
                    <td style="text-align:center" rowspan="2">503.</td>
                    <td colspan="7">Kualitas bayi saat lahir</td>
                </tr>
                <tr>
                    <td>a. Lahir Hidup</td>
                    <td><input type="number" style="width:50px" name="r503a" min="0"
                            value="<?php echo htmlspecialchars($desa_data['r503a'] ?? ''); ?>"></td>
                    <td>b. Lahir Mati</td>
                    <td><input type="number" style="width:50px" name="r503b" min="0"
                            value="<?php echo htmlspecialchars($desa_data['r503b'] ?? ''); ?>"></td>
                </tr>
                <tr>
                    <td style="text-align:center" rowspan="2">504.</td>
                    <td colspan="7">Jumlah penolong persalinan setahun terakhir</td>
                </tr>
                <tr>
                    <td>a. Dokter</td>
                    <td><input type="number" style="width:50px" name="r504a" min="0"
                            value="<?php echo htmlspecialchars($desa_data['r504a'] ?? ''); ?>"></td>
                    <td>b. Bidan</td>
                    <td><input type="number" style="width:50px" name="r504b" min="0"
                            value="<?php echo htmlspecialchars($desa_data['r504b'] ?? ''); ?>"></td>
                </tr>
                <tr>
                    <td style="text-align:center" rowspan="2">505.</td>
                    <td colspan="7">Cakupan Imunisasi</td>
                </tr>
                <tr>
                    <td>a. Jumlah Balita</td>
                    <td><input type="number" style="width:50px" name="r505a" min="0"
                            value="<?php echo htmlspecialchars($desa_data['r505a'] ?? ''); ?>"></td>
                    <td>b. Jumlah balita penerima imunisasi</td>
                    <td><input type="number" style="width:50px" name="r505b" min="0"
                            value="<?php echo htmlspecialchars($desa_data['r505b'] ?? ''); ?>"></td>
                </tr>
                <tr>
                    <td style="text-align:center" rowspan="2">506.</td>
                    <td colspan="7">Perkembangan pasangan usia subur dan keluarga berencana</td>
                </tr>
                <tr>
                    <td>a. Jumlah pasangan usia subur</td>
                    <td><input type="number" style="width:50px" name="r506a" min="0"
                            value="<?php echo htmlspecialchars($desa_data['r506a'] ?? ''); ?>"></td>
                    <td>b. Jumlah keluarga pengguna alat/metode KB</td>
                    <td><input type="number" style="width:50px" name="r506b" min="0"
                            value="<?php echo htmlspecialchars($desa_data['r506b'] ?? ''); ?>"></td>
                </tr>
                <tr>
                    <td style="text-align:center">507.</td>
                    <td colspan="6">Jumlah Balita penderita gizi buruk:</td>
                    <td><input type="number" style="width:50px" name="r507" min="0"
                            value="<?php echo htmlspecialchars($desa_data['r507'] ?? ''); ?>"></td>
                </tr>
                <tr>
                    <td style="text-align:center">508.</td>
                    <td colspan="6">Jumlah Penduduk yang terkena wabah penyakit:</td>
                    <td><input type="number" style="width:50px" name="r508" min="0"
                            value="<?php echo htmlspecialchars($desa_data['r508'] ?? ''); ?>"></td>
                </tr>
                <tr>
                    <td style="text-align:center">509.</td>
                    <td colspan="6">Jumlah Penduduk yang pernah mengalami keluhan kesehatan:</td>
                    <td><input type="number" style="width:50px" name="r509" min="0"
                            value="<?php echo htmlspecialchars($desa_data['r509'] ?? ''); ?>"></td>
                </tr>
                <tr>
                    <td style="text-align:center">510.</td>
                    <td colspan="6">Jumlah Penduduk yang memiliki jaminan kesehatan:</td>
                    <td><input type="number" style value="<?php echo htmlspecialchars($desa_data['r510'] ?? ''); ?>">
                    </td>
                </tr>
            </table>

            <!-- Blok VI: Politik dan Kemasyarakatan -->
            <table>
                <tr>
                    <th colspan="7">BLOK VI: POLITIK DAN KEMASYARAKATAN</th>
                </tr>
                <tr>
                    <td style="text-align:center">601.</td>
                    <td style="border-right:none" colspan="5">Apakah Kepala Desa dipilih langsung oleh masyarakat desa?
                    </td>
                    <td style="border-left:none">
                        <select name="r601" style="width:80px">
                            <option value="">-- Pilih --</option>
                            <option value="Iya"
                                <?php echo (isset($desa_data['r601']) && $desa_data['r601'] == 'Iya' ? 'selected' : ''); ?>>
                                Iya</option>
                            <option value="Tidak"
                                <?php echo (isset($desa_data['r601']) && $desa_data['r601'] == 'Tidak' ? 'selected' : ''); ?>>
                                Tidak</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td style="text-align:center">602.</td>
                    <td style="border-right:none" colspan="5">Apakah terdapat kepengurusan Lembaga Kemasyarakatan Desa
                        (LKD)?</td>
                    <td style="border-left:none">
                        <select name="r602" style="width:80px">
                            <option value="">-- Pilih --</option>
                            <option value="Iya"
                                <?php echo (isset($desa_data['r602']) && $desa_data['r602'] == 'Iya' ? 'selected' : ''); ?>>
                                Iya</option>
                            <option value="Tidak"
                                <?php echo (isset($desa_data['r602']) && $desa_data['r602'] == 'Tidak' ? 'selected' : ''); ?>>
                                Tidak</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td style="text-align:center">603.</td>
                    <td style="border-right:none" colspan="4">Jumlah perangkat Badan Permusyawaratan Desa (BPD):</td>
                    <td style="border-left:none"><input type="number" min="0" style="width:50px" name="r603"
                            value="<?php echo htmlspecialchars($desa_data['r603'] ?? ''); ?>"></td>
                </tr>
            </table>

            <!-- Blok VII: Pemerintahan -->
            <table>
                <tr>
                    <th colspan="7">BLOK VII: PEMERINTAHAN</th>
                </tr>
                <tr>
                    <td style="text-align:center" rowspan="3">701.</td>
                    <td style="border-bottom:none" colspan="5">Jumlah perangkat desa:</td>
                </tr>
                <tr>
                    <td style="border:none">a. Sekretaris Desa</td>
                    <td style="border:none"><input type="number" min="0" style="width:50px" name="r701a"
                            value="<?php echo htmlspecialchars($desa_data['r701a'] ?? ''); ?>"></td>
                    <td style="border:none">c. Kaur</td>
                    <td style="border:none"><input type="number" min="0" style="width:50px" name="r701c"
                            value="<?php echo htmlspecialchars($desa_data['r701c'] ?? ''); ?>"></td>
                </tr>
                <tr>
                    <td style="border:none">b. Kasi</td>
                    <td style="border:none"><input type="number" min="0" style="width:50px" name="r701b"
                            value="<?php echo htmlspecialchars($desa_data['r701b'] ?? ''); ?>"></td>
                    <td style="border:none">d. Kadus</td>
                    <td style="border:none"><input type="number" min="0" style="width:50px" name="r701d"
                            value="<?php echo htmlspecialchars($desa_data['r701d'] ?? ''); ?>"></td>
                </tr>
                <tr>
                    <td style="text-align:center">702.</td>
                    <td style="border-right:none" colspan="5">Jumlah Dusun/Lingkungan:</td>
                    <td style="border-left:none"><input type="number" style="width:50px" name="r702"
                            value="<?php echo htmlspecialchars($desa_data['r702'] ?? ''); ?>"></td>
                </tr>
                <tr>
                    <td style="text-align:center">703.</td>
                    <td style="border-right:none" colspan="5">Jumlah Dana APBD tahun <?php echo $tahun; ?>:</td>
                    <td style="border-left:none"><input type="number" min="0" style="width:150px" name="r703"
                            value="<?php echo htmlspecialchars($desa_data['r703'] ?? ''); ?>"></td>
                </tr>
                <tr>
                    <td style="text-align:center">704.</td>
                    <td style="border-right:none" colspan="5">Apakah ada Laporan Pertanggungjawaban?</td>
                    <td style="border-left:none">
                        <select name="r704" style="width:80px">
                            <option value="">-- Pilih --</option>
                            <option value="Iya"
                                <?php echo (isset($desa_data['r704']) && $desa_data['r704'] == 'Iya' ? 'selected' : ''); ?>>
                                Iya</option>
                            <option value="Tidak"
                                <?php echo (isset($desa_data['r704']) && $desa_data['r704'] == 'Tidak' ? 'selected' : ''); ?>>
                                Tidak</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td style="text-align:center">705.</td>
                    <td style="border-right:none" colspan="5">Apakah ada pembinaan dan pengawasan pengelolaan desa?</td>
                    <td style="border-left:none">
                        <select name="r705" style="width:80px">
                            <option value="">-- Pilih --</option>
                            <option value="Iya"
                                <?php echo (isset($desa_data['r705']) && $desa_data['r705'] == 'Iya' ? 'selected' : ''); ?>>
                                Iya</option>
                            <option value="Tidak"
                                <?php echo (isset($desa_data['r705']) && $desa_data['r705'] == 'Tidak' ? 'selected' : ''); ?>>
                                Tidak</option>
                        </select>
                    </td>
                </tr>
            </table>

            <!-- Blok VIII: Ekonomi -->
            <table>
                <tr>
                    <th colspan="8">BLOK VIII: EKONOMI</th>
                </tr>
                <tr>
                    <td style="text-align:center">801.</td>
                    <td style="border-right:none" colspan="5">Apakah ada transportasi umum di desa (ojek, taksi, dll)
                    </td>
                    <td style="border-left:none">
                        <select name="r801" style="width:80px">
                            <option value="">-- Pilih --</option>
                            <option value="Iya"
                                <?php echo (isset($desa_data['r801']) && $desa_data['r801'] == 'Iya' ? 'selected' : ''); ?>>
                                Iya</option>
                            <option value="Tidak"
                                <?php echo (isset($desa_data['r801']) && $desa_data['r801'] == 'Tidak' ? 'selected' : ''); ?>>
                                Tidak</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td style="text-align:center">802.</td>
                    <td style="border-right:none" colspan="5">Jumlah penduduk yang memiliki aset sarana produksi
                        (pabrik, traktor, mesin pengolahan, dll):</td>
                    <td style="border-left:none"><input type="number" min="0" style="width:50px" name="r802"
                            value="<?php echo htmlspecialchars($desa_data['r802'] ?? ''); ?>"></td>
                </tr>
            </table>

            <!-- Blok IX: Catatan -->
            <table>
                <tr>
                    <th>BLOK IX: CATATAN</th>
                </tr>
                <tr>
                    <td height="200px"><textarea style="width:1300px; height:180px;"
                            name="catatan"><?php echo htmlspecialchars($desa_data['catatan'] ?? ''); ?></textarea></td>
                </tr>
            </table>

            <button type="submit" name="update" id="submitBtn">Update Data</button>

            <script>
            document.getElementById('submitBtn').addEventListener('click', function(e) {
                if (!validateForm()) {
                    e.preventDefault();
                    return false;
                }
                return confirm('Apakah Anda yakin ingin memperbarui data?');
            });

            function validateNumericInputs() {
                const numericInputs = document.querySelectorAll('input[type="number"]');
                let isValid = true;

                numericInputs.forEach(input => {
                    if (input.value && isNaN(input.value)) {
                        alert(`Harap masukkan angka yang valid untuk ${input.name}`);
                        isValid = false;
                    }
                });

                return isValid;
            }

            function validateForm() {
                const villageHeadAnswer = document.querySelector('select[name="r601"]').value;
                if (villageHeadAnswer === '') {
                    alert('Harap jawab pertanyaan tentang pemilihan Kepala Desa');
                    return false;
                }
                if (!validateNumericInputs()) {
                    return false;
                }
                return true;
            }
            </script>
        </form>
    </div>
</body>

</html>