<?php
// Start session and check login
session_start();
if(!isset($_SESSION['uname'])) {
    header("Location: login.php?pesan=belum_login");
    exit();
}

include_once("koneksi.php");

// Get year parameter and validate
$tahun = isset($_GET['tahun']) ? intval($_GET['tahun']) : 2025;
$allowed_years = [2023, 2024, 2025, 2026, 2027, 2028, 2029, 2030];
if(!in_array($tahun, $allowed_years)) {
    $tahun = 2025; // Default to 2025 if invalid year
}
$table_name = "data" . $tahun;

// Validate and sanitize ID
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if($id <= 0) {
    header("Location: admin.php?tahun=$tahun&pesan=invalid_id");
    exit();
}

// Fetch user data using prepared statement
$stmt = $conn->prepare("SELECT * FROM $table_name WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows == 0) {
    header("Location: admin.php?tahun=$tahun&pesan=data_not_found");
    exit();
}

$user_data = $result->fetch_assoc();

// Process form submission
if(isset($_POST['update'])) {
    // Initialize all variables with default values
    $fields = [
        'r105', 'r105a', 'r201', 'r202', 'r203', 'r204', 'namapengesah', 'nohppengesah',
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
        header("Location: admin.php?tahun=$tahun&pesan=update_sukses");
    } else {
        header("Location: admin.php?tahun=$tahun&pesan=update_gagal");
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
        padding: 12px 15px;
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
        margin-top: 20px;
        transition: background-color 0.3s, transform 0.2s;
        display: block;
        margin-left: auto;
        margin-right: auto;
    }

    button[type="submit"]:hover {
        background-color: #c0a04d;
        transform: translateY(-2px);
    }

    button[type="submit"]:active {
        transform: translateY(0);
    }

    .form-section {
        margin-bottom: 30px;
    }

    .form-section-title {
        font-size: 18px;
        font-weight: 600;
        color: var(--secondary-color);
        margin-bottom: 15px;
        padding-bottom: 8px;
        border-bottom: 2px solid var(--primary-color);
    }

    .input-group {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
    }

    .input-label {
        min-width: 250px;
        margin-right: 15px;
    }

    .input-field {
        flex: 1;
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
        }

        .input-group {
            flex-direction: column;
            align-items: flex-start;
        }

        .input-label {
            margin-bottom: 5px;
            margin-right: 0;
        }

        input[type="text"],
        input[type="date"],
        input[type="number"],
        textarea,
        select {
            max-width: 100%;
        }
    }

    /* Alert message */
    .alert {
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 4px;
        font-weight: 500;
    }

    .alert-success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

    .alert-warning {
        background-color: #fff3cd;
        color: #856404;
        border: 1px solid #ffeeba;
    }
    </style>
</head>

<body>

    <!-- Your existing HTML form structure -->

    <div class="kop">
        <div class="kotak1">
            <img src="images/logo-descan.png" height="50px" />
            <img src="images/logo-bps.png" height="50px" />
            <img src="images/logo-okus.png" height="50px" />
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
        <h3 style="text-align:center">PENDATAAN POTENSI TINGKAT DUSUN/LINGKUNGAN/RT/RW TAHUN <?php echo $tahun; ?></h3>
    </div>
    <form name="update_user" method="post" action="edit.php">
        <table cellpadding="5" width="1330px">
            <tr>
                <th colspan="4">BLOK I: KETERANGAN TEMPAT</th>
            </tr>
            <tr>
                <td width="30px" style="text-align:center">101.</td>
                <td style="border-right:none" width="300px">Provinsi</td>
                <td style="border-left:none">: Sumatera Selatan</td>
                <td style="text-align:right">16</td>
            </tr>
            <tr>
                <td width="30px" style="text-align:center">102.</td>
                <td style="border-right:none" width="300px">Kabupaten/Kota</td>
                <td style="border-left:none">: Ogan Komering Ulu Selatan</td>
                <td style="text-align:right">08</td>
            </tr>
            <tr>
                <td width="30px" style="text-align:center">103.</td>
                <td style="border-right:none" width="300px">Kecamatan</td>
                <td style="border-left:none">: <?php echo "$namakec"?></td>
                <td style="text-align:right"><?php echo"$kodekec"?></td>
            </tr>
            <tr>
                <td width="30px" style="text-align:center">104.</td>
                <td style="border-right:none" width="300px">Desa/Kelurahan</td>
                <td style="border-left:none">: <?php echo"$nama"?></td>
                <td style="text-align:right"><?php echo"$kode"?></td>
            </tr>
            <tr>
                <td width="30px" style="text-align:center">105.</td>
                <td style="border-right:none" width="300px">Dusun/Lingkungan/RT/RW</td>
                <td style="border-left:none">: <?php echo htmlspecialchars($user_data['r105a'] ?? '');?></td>
                <td style="text-align:right"><?php echo htmlspecialchars($user_data['r105'] ?? '');?></td>


            </tr>
        </table>
        <br>

        <table cellpadding="5" width="1330px">
            <tr>
                <th colspan="4">BLOK II: KETERANGAN PETUGAS</th>
            </tr>
            <tr>
                <td colspan="3" style="text-align:center; font-weight:bold;">Pencacahan</td>
                <td style="text-align:center;font-weight:bold;" width="300px">Pengesahan Ketua Dusun/Lingkungan/RT/RW
                </td>
            </tr>
            <tr>
                <td width="30px" style="text-align:center">201.</td>
                <td style="border-right:none" width="300px">Nama Agen Statistik</td>
                <td style="border-left:none">: <input type="text" name="r201"
                        value=<?php echo htmlspecialchars($user_data['r201'] ?? '');?>></input>
                </td>
                <td rowspan="4" style="text-align:center">
                    Nama Lengkap : <br>
                    <input type="text" name="namapengesah" style="width:200px"
                        value=<?php echo htmlspecialchars($user_data['namapengesah'] ?? '');?>></input><br><br>
                    Nomor Handphone : <br>
                    <input type="text" name="nohppengesah" style="width:200px"
                        value=<?php echo htmlspecialchars($user_data['nohppengesah'] ?? '');?>></input><br>
                </td>
            </tr>
            <tr>
                <td width="30px" style="text-align:center">202.</td>
                <td style="border-right:none" width="300px">Kode Agen Statistik</td>
                <td style="border-left:none">: <input type="text" name="r202"
                        value=<?php echo htmlspecialchars($user_data['r202'] ?? '');?>></input></td>
            </tr>
            <tr>
                <td width="30px" style="text-align:center">203.</td>
                <td style="border-right:none" width="300px">Tanggal/Bulan/Tahun Pelaksanaan</td>
                <td style="border-left:none">: <input type="date" name="r203"
                        value=<?php echo htmlspecialchars($user_data['r203'] ?? '');?>></input></td>
            </tr>
            <tr>
                <td width="30px" style="text-align:center">204.</td>
                <td style="border-right:none" width="300px">Nomor Handphone</td>
                <td style="border-left:none">: <input type="text" name="r204"></input></td>
            </tr>
        </table>
        <br>
        <table cellpadding="5" width="1330px">
            <tr>
                <th colspan="8">BLOK III: KEPENDUDUKAN DAN KETENAGAKERJAAN</th>
            </tr>
            <tr>
                <td width="30px" style="text-align:center">301.</td>
                <td style="border-right:none" width="300px">Jumlah Penduduk dan Keluarga:</td>
                <td style="border-left:none;border-right:none" width="100px">a. Laki-laki </td>
                <td style="border-left:none;border-right:none"><input type="text" style="width:50px" name="r301a"
                        value=<?php echo htmlspecialchars($user_data['r301a'] ?? '');?>></input></td>
                <td style="border-left:none;border-right:none" width="100px">b. Perempuan </td>
                <td style="border-left:none;border-right:none"><input type="text" style="width:50px" name="r301b"
                        value=<?php echo htmlspecialchars($user_data['r301b'] ?? '');?>></input></td>
                <td style="border-left:none;border-right:none" width="200px">c. Keluarga </td>
                <td style="border-left:none;border-right:none"><input type="text" style="width:50px" name="r301c"
                        value=<?php echo htmlspecialchars($user_data['r301c'] ?? '');?>></input></td>
            </tr>

            <tr>
                <td width="30px" style="text-align:center" rowspan="5">302.</td>
                <td style="border:none" width="300px" colspan="7">Jumlah Penduduk Berdasarkan Pekerjaan:
                </td>
            </tr>
            <tr>
                <td style="border:none" width="500px">a. ASN(PNS/PPPK)</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r302a"
                        value=<?php echo htmlspecialchars($user_data['r302a'] ?? '');?>></input></td>
                <td style="border:none" width="500px">e. Petani/Peternak</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r302e"
                        value=<?php echo htmlspecialchars($user_data['r302e'] ?? '');?>></input></td>
                <td style="border:none" width="500px">i. Pedagang</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r302i"
                        value=<?php echo htmlspecialchars($user_data['r302i'] ?? '');?>></input></td>
            </tr>
            <tr>
                <td style="border:none" width="500px">b. TNI/POLRI</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r302b"
                        value=<?php echo htmlspecialchars($user_data['r302b'] ?? '');?>></input></td>
                <td style="border:none" width="500px">f. Pensiunan</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r302f"
                        value=<?php echo htmlspecialchars($user_data['r302f'] ?? '');?>></input></td>
                <td style="border:none" width="500px">j. Pegawai Swasta</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r302j"
                        value=<?php echo htmlspecialchars($user_data['r302j'] ?? '');?>></input></td>
            </tr>
            <tr>
                <td style="border:none" width="500px">c. Wiraswasta</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r302c"
                        value=<?php echo htmlspecialchars($user_data['r302c'] ?? '');?>></input></td>
                <td style="border:none" width="500px">g. Buruh</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r302g"
                        value=<?php echo htmlspecialchars($user_data['r302g'] ?? '');?>></input></td>
                <td style="border:none" width="500px">k. Dosen</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r302k"
                        value=<?php echo htmlspecialchars($user_data['r302k'] ?? '');?>></input></td>
            </tr>
            <tr>
                <td style="border:none" width="500px">d. Paramedis</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r302d"
                        value=<?php echo htmlspecialchars($user_data['r302d'] ?? '');?>></input></td>
                <td style="border:none" width="500px">h. Nelayan</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r302h"
                        value=<?php echo htmlspecialchars($user_data['r302h'] ?? '');?>></input></td>
                <td style="border:none" width="500px">l. Lainnya</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r302l"
                        value=<?php echo htmlspecialchars($user_data['r302l'] ?? '');?>></input></td>
            </tr>
            <tr>
                <td width="30px" style="text-align:center">303.</td>
                <td style="border-right:none" width="300px" colspan="6">Jumlah Pengangguran:</td>
                <td style="border-left:none" width="150px"><input type="text" style="width:50px" name="r303"
                        value=<?php echo htmlspecialchars($user_data['r303'] ?? '');?>></input>
                </td>
            </tr>


        </table>
        <br>
        <table cellpadding="7" width="1330px">
            <tr>
                <th colspan="8">BLOK IV: PENDIDIKAN </th>
            </tr>
            <tr>
                <td width="30px" style="text-align:center" rowspan="5">401.</td>
                <td style="border:none" width="300px" colspan="4">Jumlah Kepala Keluarga berdasarkan pendidikan
                    terakhir:
                </td>
            </tr>
            <tr>
                <td style="border:none" width="500px">a. Tidak tamat SD</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r401a"
                        value=<?php echo htmlspecialchars($user_data['r401a'] ?? '');?>></input></td>
                <td style="border:none" width="500px">e.Akademi/Diploma </td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r401e"
                        value=<?php echo htmlspecialchars($user_data['r401e'] ?? '');?>></input></td>
            </tr>
            <tr>
                <td style="border:none" width="500px">b. SD/MI</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r401b"
                        value=<?php echo htmlspecialchars($user_data['r401b'] ?? '');?>></input></td>
                <td style="border:none" width="500px">f. Pasca Sarjana</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r401f"
                        value=<?php echo htmlspecialchars($user_data['r401f'] ?? '');?>></input></td>
            </tr>
            <tr>
                <td style="border:none" width="500px">c. SMP/MTs</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r401c"
                        value=<?php echo htmlspecialchars($user_data['r401c'] ?? '');?>></input></td>
                <td style="border:none" width="500px">g. Sarjana</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r401g"
                        value=<?php echo htmlspecialchars($user_data['r401g'] ?? '');?>></input></td>
            </tr>
            <tr>
                <td style="border:none" width="500px">d. SMA/MA/SMK</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r401d"
                        value=<?php echo htmlspecialchars($user_data['r401d'] ?? '');?>></input></td>

            </tr>
            <tr>
                <td width="30px" style="text-align:center">402.</td>
                <td style="border-right:none" width="300px" colspan="6">Jumlah Penduduk Putus Sekolah:</td>
                <td style="border-left:none" width="150px"><input type="text" style="width:50px" name="r402"
                        value=<?php echo htmlspecialchars($user_data['r402'] ?? '');?>></input>
                </td>
            </tr>

            <tr>
                <th colspan="8">BLOK V: KESEHATAN</th>
            </tr>
            <tr>
                <td width="30px" style="text-align:center" rowspan="7">501.</td>
                <td style="border:none" width="300px" colspan="5">Jumlah Keluarga berdasarkan sumber air minum utama:
                </td>
            </tr>
            <tr>
                <td style="border:none" width="500px">a. Air Kemasan Bermerek</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r501a"
                        value=<?php echo htmlspecialchars($user_data['r501a'] ?? '');?>></input></td>
                <td style="border:none" width="500px">g. Mata Air Terlindungi</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r501g"
                        value=<?php echo htmlspecialchars($user_data['r501g'] ?? '');?>></input></td>
            </tr>
            <tr>
                <td style="border:none" width="500px">b. Air isi ulang</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r501b"
                        value=<?php echo htmlspecialchars($user_data['r501b'] ?? '');?>></input></td>
                <td style="border:none" width="500px">h. Mata Air Tak Terlindungi</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r501h"
                        value=<?php echo htmlspecialchars($user_data['r501h'] ?? '');?>></input></td>
            </tr>
            <tr>
                <td style="border:none" width="500px">c. Leding</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r501c"
                        value=<?php echo htmlspecialchars($user_data['r501c'] ?? '');?>></input></td>
                <td style="border:none" width="500px">i. Air Permukaan(sungai/danau/waduk)</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r501i"
                        value=<?php echo htmlspecialchars($user_data['r501i'] ?? '');?>></input></td>
            </tr>
            <tr>
                <td style="border:none" width="500px">d. Sumur Bor/Pompa</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r501d"
                        value=<?php echo htmlspecialchars($user_data['r501d'] ?? '');?>></input></td>
                <td style="border:none" width="500px">j. Air Hujan</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r501j"
                        value=<?php echo htmlspecialchars($user_data['r501j'] ?? '');?>></input></td>
            </tr>
            <tr>
                <td style="border:none" width="500px">e. Sumur Terlindungi</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r501e"
                        value=<?php echo htmlspecialchars($user_data['r501e'] ?? '');?>></input></td>
                <td style="border:none" width="500px">k. lainnya</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r501k"
                        value=<?php echo htmlspecialchars($user_data['r501k'] ?? '');?>></input></td>
            </tr>
            <tr>
                <td style="border:none" width="500px">f. Sumur tak terlindungi</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r501f"
                        value=<?php echo htmlspecialchars($user_data['r501f'] ?? '');?>></input></td>

            </tr>

            <tr>
                <td width="30px" style="text-align:center" rowspan="3">502.</td>
                <td style="border-bottom:none" width="300px" colspan="7">Jumlah Tenaga kesehatan yang menetap di
                    Dusun/lingkungan:</td>
            </tr>
            <tr>
                <td style="border:none" width="500px">a. Dokter Umum/Spesialis</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r502a"
                        value=<?php echo htmlspecialchars($user_data['r502a'] ?? '');?>></input></td>
                <td style="border:none" width="500px">c. Bidan</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r502c"
                        value=<?php echo htmlspecialchars($user_data['r502c'] ?? '');?>></input></td>
            </tr>
            <tr>
                <td style="border:none" width="500px">b. Dokter Spesialis gigi</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r502b"
                        value=<?php echo htmlspecialchars($user_data['r502b'] ?? '');?>></input></td>
                <td style="border:none" width="500px">d. Tenaga Kesehatan lainnya</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r502d"
                        value=<?php echo htmlspecialchars($user_data['r502d'] ?? '');?>></input></td>
            </tr>
            <tr>
                <td width="30px" style="text-align:center">503.</td>
                <td style="border-right:none" width="300px" colspan="6">Jumlah Dukun bayi/Dukun Bersalin yang tinggal di
                    Dusun/Lingkungan:</td>
                <td style="border-left:none" width="150px"><input type="text" style="width:50px" name="r503"
                        value=<?php echo htmlspecialchars($user_data['r503'] ?? '');?>></input>
                </td>
            </tr>
            <tr>
                <td width="30px" style="text-align:center">504.</td>
                <td style="border-right:none" width="300px" colspan="6">Jumlah Balita penderita gizi buruk:</td>
                <td style="border-left:none" width="150px"><input type="text" style="width:50px" name="r504"
                        value=<?php echo htmlspecialchars($user_data['r504'] ?? '');?>></input>
                </td>
            </tr>
            <tr>
                <td width="30px" style="text-align:center">505.</td>
                <td style="border-right:none" width="300px" colspan="6">Jumlah Penduduk Stunting:</td>
                <td style="border-left:none" width="150px"><input type="text" style="width:50px" name="r505"
                        value=<?php echo htmlspecialchars($user_data['r505'] ?? '');?>></input>
                </td>
            </tr>
            <tr>
                <td width="30px" style="text-align:center">506.</td>
                <td style="border-right:none" width="300px" colspan="6">Jumlah Penduduk yang terkena wabah penyakit:
                </td>
                <td style="border-left:none" width="150px"><input type="text" style="width:50px" name="r506"
                        value=<?php echo htmlspecialchars($user_data['r506'] ?? '');?>></input>
                </td>
            </tr>
            <tr>
                <td width="30px" style="text-align:center">507.</td>
                <td style="border-right:none" width="300px" colspan="6">Jumlah Penduduk yang pernah mengalami keluhan
                    kesehatan:</td>
                <td style="border-left:none" width="150px"><input type="text" style="width:50px" name="r507"
                        value=<?php echo htmlspecialchars($user_data['r507'] ?? '');?>></input>
                </td>
            </tr>
            <tr>
                <td width="30px" style="text-align:center">508.</td>
                <td style="border-right:none" width="300px" colspan="6">Jumlah Penduduk yang memiliki jaminan kesehatan:
                </td>
                <td style="border-left:none" width="150px"><input type="text" style="width:50px" name="r508"
                        value=<?php echo htmlspecialchars($user_data['r508'] ?? '');?>></input>
                </td>
            </tr>
            <tr>
                <td width="30px" style="text-align:center">509.</td>
                <td style="border-right:none" width="300px" colspan="6">Jumlah keluarga dengan anggota keluarga perokok:
                </td>
                <td style="border-left:none" width="150px"><input type="text" style="width:50px" name="r509"
                        value=<?php echo htmlspecialchars($user_data['r509'] ?? '');?>></input>
                </td>
            </tr>

        </table>
        <br>
        <table cellpadding="5" width="1330px">
            <tr>
                <th colspan="7">BLOK VI: SOSIAL DAN BUDAYA</th>
            </tr>
            <tr>
                <td width="30px" style="text-align:center" rowspan="5">601.</td>
                <td style="border-bottom:none" width="300px" colspan="7">Jumlah Tempat ibadah di Dusun/Lingkungan:</td>
            </tr>
            <tr>
                <td style="border:none" width="500px">a. Mesjid</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r601a"
                        value=<?php echo htmlspecialchars($user_data['r601a'] ?? '');?>></input></td>
                <td style="border:none" width="500px">e. Pura</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r601e"
                        value=<?php echo htmlspecialchars($user_data['r601e'] ?? '');?>></input></td>
            </tr>
            <tr>
                <td style="border:none" width="500px">b. Surau/Langgar/Mushola</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r601b"
                        value=<?php echo htmlspecialchars($user_data['r601b'] ?? '');?>></input></td>
                <td style="border:none" width="500px">f. Wihara</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r601f"
                        value=<?php echo htmlspecialchars($user_data['r601f'] ?? '');?>></input></td>
            </tr>
            <tr>
                <td style="border:none" width="500px">c. Gereja kristen</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r601c"
                        value=<?php echo htmlspecialchars($user_data['r601c'] ?? '');?>></input></td>
                <td style="border:none" width="500px">g. kelenteng</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r601g"
                        value=<?php echo htmlspecialchars($user_data['r601g'] ?? '');?>></input></td>
            </tr>
            <tr>
                <td style="border:none" width="500px">d. Gereja katolik</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r601d"
                        value=<?php echo htmlspecialchars($user_data['r601d'] ?? '');?>></input></td>
                <td style="border:none" width="500px">h. lainnya</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r601h"
                        value=<?php echo htmlspecialchars($user_data['r601h'] ?? '');?>></input></td>
            </tr>

            <tr>
                <td width="30px" style="text-align:center" rowspan="6">602.</td>
                <td style="border-bottom:none" width="300px" colspan="7">Jumlah Penduduk penyandang disabilitas di
                    Dusun/lingkungan:</td>
            </tr>
            <tr>
                <td style="border:none" width="500px">a. Tuna netra</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r602a"
                        value=<?php echo htmlspecialchars($user_data['r602a'] ?? '');?>></input></td>
                <td style="border:none" width="500px">f. Tuna grahita (Mental)</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r602f"
                        value=<?php echo htmlspecialchars($user_data['r602f'] ?? '');?>></input></td>
            </tr>
            <tr>
                <td style="border:none" width="500px">b. Tuna rungu (Tuli)</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r602b"
                        value=<?php echo htmlspecialchars($user_data['r602b'] ?? '');?>></input></td>
                <td style="border:none" width="500px">g. Tuna Laras</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r602g"
                        value=<?php echo htmlspecialchars($user_data['r602g'] ?? '');?>></input></td>
            </tr>
            <tr>
                <td style="border:none" width="500px">c. Tuna Wicara (bisu)</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r602c"
                        value=<?php echo htmlspecialchars($user_data['r602c'] ?? '');?>></input></td>
                <td style="border:none" width="500px">h. Tuna eks-sakit kusta</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r602h"
                        value=<?php echo htmlspecialchars($user_data['r602h'] ?? '');?>></input></td>
            </tr>
            <tr>
                <td style="border:none" width="500px">d. Tuna rungu-wicara (tuli-bisu)</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r602d"
                        value=<?php echo htmlspecialchars($user_data['r602d'] ?? '');?>></input></td>
                <td style="border:none" width="500px">i. Tuna Ganda (fisik-mental)</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r602i"
                        value=<?php echo htmlspecialchars($user_data['r602i'] ?? '');?>></input></td>
            </tr>
            <tr>
                <td style="border:none" width="500px">e. Tuna Daksa (disabilitas tubuh)</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r602e"
                        value=<?php echo htmlspecialchars($user_data['r602e'] ?? '');?>></input></td>

            </tr>
            <tr>
                <td width="30px" style="text-align:center">603.</td>
                <td style="border-right:none" width="300px" colspan="5">Jumlah Keluarga penerima bantuan:</td>
                <td style="border-left:none" width="150px"><input type="text" style="width:50px" name="r603"
                        value=<?php echo htmlspecialchars($user_data['r603'] ?? '');?>></input></td>
                </td>
            </tr>
        </table>
        <br>
        <table cellpadding="5" width="1330px">
            <tr>
                <th colspan="7">BLOK VII: KEAMANAN DAN KETERTIBAN</th>
            </tr>
            <tr>
                <td width="30px" style="text-align:center">701.</td>
                <td style="border-right:none" width="300px" colspan="5"> Apakah terdapat pos ronda di Dusun/Lingkungan?
                </td>
                <td style="border-left:none" width="150px">
                    <select name="r701">
                        <option value="yes" <?php echo ($user_data['r701'] ?? '') == 'yes' ? 'selected' : ''; ?>>Yes
                        </option>
                        <option value="no" <?php echo ($user_data['r701'] ?? '') == 'no' ? 'selected' : ''; ?>>No
                        </option>
                    </select>
                </td>
            </tr>

            <tr>
                <td width="30px" style="text-align:center">702.</td>
                <td style="border-right:none" width="300px" colspan="5"> Jumlah Kriminalitas di Dusun/Lingkungan:</td>
                <td style="border-left:none" width="150px"><input type="text" style="width:50px" name="r702"
                        value=<?php echo htmlspecialchars($user_data['r702'] ?? '');?>></input></td>
                </td>
            </tr>
        </table>
        <br>
        <table cellpadding="5" width="1330px">
            <tr>
                <th colspan="8">BLOK VIII: OLAHRAGA DAN HIBURAN</th>
            </tr>
            <tr>
                <td width="30px" style="text-align:center" rowspan="7">801.</td>
                <td style="border-bottom:none" width="300px" colspan="8">Jumlah fasilitas/lapangan olahraga di
                    Dusun/Lingkungan:</td>
            </tr>
            <tr>
                <td style="border:none" width="500px">a. Sepakbola</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r801a"
                        value=<?php echo htmlspecialchars($user_data['r801a'] ?? '');?>></input></td>
                <td style="border:none" width="500px">g. Futsal</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r801g"
                        value=<?php echo htmlspecialchars($user_data['r801g'] ?? '');?>></input></td>
            </tr>
            <tr>
                <td style="border:none" width="500px">b. Bola Voli</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r801b"
                        value=<?php echo htmlspecialchars($user_data['r801b'] ?? '');?>></input></td>
                <td style="border:none" width="500px">h. Renang</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r801h"
                        value=<?php echo htmlspecialchars($user_data['r801h'] ?? '');?>></input></td>
            </tr>
            <tr>
                <td style="border:none" width="500px">c. Bulutangkis</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r801c"
                        value=<?php echo htmlspecialchars($user_data['r801c'] ?? '');?>></input></td>
                <td style="border:none" width="500px">i. Beladiri (Pencak silat, Karate, dll)</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r801i"
                        value=<?php echo htmlspecialchars($user_data['r801i'] ?? '');?>></input></td>
            </tr>
            <tr>
                <td style="border:none" width="500px">d. Bola Basket</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r801d"
                        value=<?php echo htmlspecialchars($user_data['r801d'] ?? '');?>></input></td>
                <td style="border:none" width="500px">j. billiard</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r801j"
                        value=<?php echo htmlspecialchars($user_data['r801j'] ?? '');?>></input></td>
            </tr>
            <tr>
                <td style="border:none" width="500px">e. Tenis Lapangan</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r801e"
                        value=<?php echo htmlspecialchars($user_data['r801e'] ?? '');?>></input></td>
                <td style="border:none" width="500px">k. Fitnes, aerobik, dll</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r801k"
                        value=<?php echo htmlspecialchars($user_data['r801k'] ?? '');?>></input></td>
            </tr>
            <tr>
                <td style="border:none" width="500px">f. Tenis Meja</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r801f"
                        value=<?php echo htmlspecialchars($user_data['r801f'] ?? '');?>></input></td>
                <td style="border:none" width="500px">l. lainnya</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r801l"
                        value=<?php echo htmlspecialchars($user_data['r801l'] ?? '');?>></input></td>
            </tr>
            <tr>
                <td width="30px" style="text-align:center">802.</td>
                <td style="border-right:none" width="300px" colspan="3"> Jumlah Pub/diskotek/tempat karaoke yang masih
                    aktif di Dusun/Lingkungan:</td>
                <td style="border-left:none" width="150px"><input type="text" style="width:50px" name="r802"
                        value=<?php echo htmlspecialchars($user_data['r802'] ?? '');?>></input></td>
                </td>
            </tr>

        </table>
        <br>
        <table cellpadding="5" width="1330px">
            <tr>
                <th colspan="8">BLOK IX: EKONOMI</th>
            </tr>
            <tr>
                <td width="30px" style="text-align:center">901.</td>
                <td style="border-right:none" width="300px" colspan="4"> Jumlah Keluarga yang memiliki sertifikat tanah:
                </td>
                <td style="border-left:none" width="150px"><input type="text" style="width:50px" name="r901"
                        value=<?php echo htmlspecialchars($user_data['r901'] ?? '');?>></input></td>
                </td>
            </tr>
            <tr>
                <td width="30px" style="text-align:center">902.</td>
                <td style="border-right:none" width="300px" colspan="4"> Jumlah Keluarga yang memiliki sertifikat Rumah:
                </td>
                <td style="border-left:none" width="150px"><input type="text" style="width:50px" name="r902"
                        value=<?php echo htmlspecialchars($user_data['r902'] ?? '');?>></input></td>
                </td>
            </tr>
            <tr>
                <td width="30px" style="text-align:center">903.</td>
                <td style="border-right:none" width="300px" colspan="4"> Jumlah Pangkalan/agen/penjual minyak tanah:
                </td>
                <td style="border-left:none" width="150px"><input type="text" style="width:50px" name="r903"
                        value=<?php echo htmlspecialchars($user_data['r903'] ?? '');?>></input></td>
                </td>
            </tr>
            <tr>
                <td width="30px" style="text-align:center">904.</td>
                <td style="border-right:none" width="300px" colspan="4"> Jumlah Pangkalan/agen/penjual LPG:</td>
                <td style="border-left:none" width="150px"><input type="text" style="width:50px" name="r904"
                        value=<?php echo htmlspecialchars($user_data['r904'] ?? '');?>></input></td>
                </td>
            </tr>
            <tr>
                <td width="30px" style="text-align:center" rowspan="3">905.</td>
                <td style="border-bottom:none" width="300px" colspan="8">Jumlah Sarana lembaga keuangan yang beroperasi
                    di Dusun/Lingkungan:</td>
            </tr>
            <tr>
                <td style="border:none" width="500px">a. Bank Umum Pemerintah</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r905a"
                        value=<?php echo htmlspecialchars($user_data['r905a'] ?? '');?>></input></td>
                <td style="border:none" width="500px">c. Bank Perkreditan rakyat</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r905c"
                        value=<?php echo htmlspecialchars($user_data['r905c'] ?? '');?>></input></td>
            </tr>
            <tr>
                <td style="border:none" width="500px">b. Bank Umum Swasta</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r905b"
                        value=<?php echo htmlspecialchars($user_data['r905b'] ?? '');?>></input></td>
            </tr>
            <tr>
                <td width="30px" style="text-align:center" rowspan="3">906.</td>
                <td style="border-bottom:none" width="300px" colspan="8">Jumlah Koperasi di Dusun/Lingkungan:</td>
            </tr>
            <tr>
                <td style="border:none" width="500px">a. Koperasi Unit Desa (KUD)</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r906a"
                        value=<?php echo htmlspecialchars($user_data['r906a'] ?? '');?>></input></td>
                <td style="border:none" width="500px">c. Koperasi Simpan Pinjam (Kospin)</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r906c"
                        value=<?php echo htmlspecialchars($user_data['r906c'] ?? '');?>></input></td>
            </tr>
            <tr>
                <td style="border:none" width="500px">b. Koperasi Industri Kecil & Kopinkra</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r906b"
                        value=<?php echo htmlspecialchars($user_data['r906b'] ?? '');?>></input></td>
                <td style="border:none" width="500px">d. Koperasi lainnya</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r906d"
                        value=<?php echo htmlspecialchars($user_data['r906d'] ?? '');?>></input></td>
            </tr>

            <tr>
                <td width="30px" style="text-align:center" rowspan="6">907.</td>
                <td style="border-bottom:none" width="300px" colspan="8">Jumlah sarana dan prasarana ekonomi di
                    Dusun/lingkungan:</td>
            </tr>
            <tr>
                <td style="border:none" width="500px">a. Kelompok Pertokoan</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r907a"
                        value=<?php echo htmlspecialchars($user_data['r907a'] ?? '');?>></input></td>
                <td style="border:none" width="500px">f. Restoran/rumah makan</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r907f"
                        value=<?php echo htmlspecialchars($user_data['r907f'] ?? '');?>></input></td>
            </tr>
            <tr>
                <td style="border:none" width="500px">b. Pasar dengan bangunan permanen</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r907b"
                        value=<?php echo htmlspecialchars($user_data['r907b'] ?? '');?>></input></td>
                <td style="border:none" width="500px">g. Warung/kedai makanan minuman</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r907g"
                        value=<?php echo htmlspecialchars($user_data['r907g'] ?? '');?>></input></td>
            </tr>
            <tr>
                <td style="border:none" width="500px">c. Pasar dengan bangunan semi permanen</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r907c"
                        value=<?php echo htmlspecialchars($user_data['r907c'] ?? '');?>></input></td>
                <td style="border:none" width="500px">h. Hotel</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r907h"
                        value=<?php echo htmlspecialchars($user_data['r907h'] ?? '');?>></input></td>
            </tr>
            <tr>
                <td style="border:none" width="500px">d. Pasar tanpa bangunan </td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r907d"
                        value=<?php echo htmlspecialchars($user_data['r907d'] ?? '');?>></input></td>
                <td style="border:none" width="500px">i. Penginapan</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r907i"
                        value=<?php echo htmlspecialchars($user_data['r907i'] ?? '');?>></input></td>
            </tr>
            <tr>
                <td style="border:none" width="500px">e. Minimarket/Swalayan/supermarket</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r907e"
                        value=<?php echo htmlspecialchars($user_data['r907e'] ?? '');?>></input></td>
                <td style="border:none" width="500px">j. Toko/warung kelontong</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r907j"
                        value=<?php echo htmlspecialchars($user_data['r907j'] ?? '');?>></input></td>
            </tr>
            <tr>
                <td width="30px" style="text-align:center" rowspan="4">908.</td>
                <td style="border-bottom:none" width="300px" colspan="8">Jumlah sarana penunjang ekonomi di
                    Dusun/Lingkungan:</td>
            </tr>
            <tr>
                <td style="border:none" width="500px">a. Baitul Maal Wa Tamwil (BMT)</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r908a"
                        value=<?php echo htmlspecialchars($user_data['r908a'] ?? '');?>></input></td>
                <td style="border:none" width="500px">d. Bengkel Mobil/Motor</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r908d"
                        value=<?php echo htmlspecialchars($user_data['r908d'] ?? '');?>></input></td>
            </tr>
            <tr>
                <td style="border:none" width="500px">b. Pengadaian</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r908b"
                        value=<?php echo htmlspecialchars($user_data['r908b'] ?? '');?>></input></td>
                <td style="border:none" width="500px">e. Salon kecantikan</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r908e"
                        value=<?php echo htmlspecialchars($user_data['r908e'] ?? '');?>></input></td>
            </tr>
            <tr>
                <td style="border:none" width="500px">c. Anjungan Tunai Mandiri (ATM)</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r908c"
                        value=<?php echo htmlspecialchars($user_data['r908c'] ?? '');?>></input></td>
                <td style="border:none" width="500px">f. Agen tiket/travel/biro perjalanan</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r908f"
                        value=<?php echo htmlspecialchars($user_data['r908f'] ?? '');?>></input></td>
            </tr>


        </table>
        <br>
        <table cellpadding="5" width="1330px">
            <tr>
                <th>BLOK X: CATATAN</th>
            </tr>
            <tr>
                <td height="200px"><textarea style="width:1300px; height:180px;" name="catatan"
                        value=<?php echo htmlspecialchars($user_data['catatan'] ?? '');?>></textarea></td>
                </td>
            <tr>
                <br>
        </table>
        <br>
        <button type="submit" name="update" onclick="alert('Data Berhasil Diupdate')">Update</button>
    </form>








    <!-- Add hidden fields for ID and year -->
    <input type="hidden" name="id" value="<?php echo $id; ?>">
    <input type="hidden" name="tahun" value="<?php echo $tahun; ?>">


</body>

</html>