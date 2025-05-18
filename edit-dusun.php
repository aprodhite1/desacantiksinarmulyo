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
            <h3>PENDATAAN POTENSI TINGKAT DUSUN/LINGKUNGAN/RT/RW TAHUN <?php echo htmlspecialchars($tahun); ?></h3>
        </div>

        <form method="POST" action="edit.php">
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
                <tr>
                    <td style="text-align:center">105.</td>
                    <td style="border-right:none">Dusun/Lingkungan/RT/RW</td>
                    <td style="border-left:none">:
                        <select name="r105" id="namasls" required>
                            <option value="">--Pilih dusun--</option>
                            <option value="Dusun 1"
                                <?php echo ($user_data['r105'] ?? '') == 'Dusun 1' ? 'selected' : ''; ?>>Dusun 1
                            </option>
                            <option value="Dusun 2"
                                <?php echo ($user_data['r105'] ?? '') == 'Dusun 2' ? 'selected' : ''; ?>>Dusun 2
                            </option>
                            <option value="Dusun 3"
                                <?php echo ($user_data['r105'] ?? '') == 'Dusun 3' ? 'selected' : ''; ?>>Dusun 3
                            </option>
                            <option value="Dusun 4"
                                <?php echo ($user_data['r105'] ?? '') == 'Dusun 4' ? 'selected' : ''; ?>>Dusun 4
                            </option>
                            <option value="Dusun 5"
                                <?php echo ($user_data['r105'] ?? '') == 'Dusun 5' ? 'selected' : ''; ?>>Dusun 6
                            </option>
                            <option value="Dusun 6"
                                <?php echo ($user_data['r105'] ?? '') == 'Dusun 6' ? 'selected' : ''; ?>>Dusun 6
                            </option>
                        </select>
                    </td>
                    <td style="text-align:right">
                        <select name="r105a" id="kodesls" required>
                            <option value="">--Pilih kode Dusun--</option>
                            <option value="000100"
                                <?php echo ($user_data['r105a'] ?? '') == '000100' ? 'selected' : ''; ?>>001</option>
                            <option value="000200"
                                <?php echo ($user_data['r105a'] ?? '') == '000200' ? 'selected' : ''; ?>>002</option>
                            <option value="000300"
                                <?php echo ($user_data['r105a'] ?? '') == '000300' ? 'selected' : ''; ?>>003</option>
                            <option value="000400"
                                <?php echo ($user_data['r105a'] ?? '') == '000400' ? 'selected' : ''; ?>>004</option>
                            <option value="000500"
                                <?php echo ($user_data['r105a'] ?? '') == '000500' ? 'selected' : ''; ?>>005</option>
                            <option value="000600"
                                <?php echo ($user_data['r105a'] ?? '') == '000600' ? 'selected' : ''; ?>>006</option>
                        </select>
                    </td>
                </tr>
            </table>

            <!-- Blok II: Keterangan Petugas -->
            <table>
                <tr>
                    <th colspan="4">BLOK II: KETERANGAN PETUGAS</th>
                </tr>
                <tr>
                    <td colspan="2" style="text-align:center; font-weight:bold;">Pencacahan</td>
                    <td colspan="2" style="text-align:center;font-weight:bold;">Pengesahan Ketua Dusun/Lingkungan/RT/RW
                    </td>
                </tr>
                <tr>
                    <td style="text-align:center">201.</td>
                    <td style="border-right:none">Nama Agen Statistik</td>
                    <td style="border-left:none">: <input type="text" name="r201"
                            value="<?php echo htmlspecialchars($user_data['r201'] ?? ''); ?>" required></td>
                    <td rowspan="4" style="text-align:center">
                        Nama Lengkap : <br>
                        <input type="text" name="namapengesah"
                            value="<?php echo htmlspecialchars($user_data['namapengesah'] ?? ''); ?>" required><br><br>
                        Nomor Handphone : <br>
                        <input type="text" name="nohppengesah"
                            value="<?php echo htmlspecialchars($user_data['nohppengesah'] ?? ''); ?>" required><br>
                    </td>
                </tr>
                <tr>
                    <td style="text-align:center">202.</td>
                    <td style="border-right:none">Kode Agen Statistik</td>
                    <td style="border-left:none">: <input type="text" name="r202"
                            value="<?php echo htmlspecialchars($user_data['r202'] ?? ''); ?>" required></td>
                </tr>
                <tr>
                    <td style="text-align:center">203.</td>
                    <td style="border-right:none">Tanggal/Bulan/Tahun Pelaksanaan</td>
                    <td style="border-left:none">: <input type="date" name="r203"
                            value="<?php echo htmlspecialchars($user_data['r203'] ?? ''); ?>" required></td>
                </tr>
                <tr>
                    <td style="text-align:center">204.</td>
                    <td style="border-right:none">Nomor Handphone</td>
                    <td style="border-left:none">: <input type="text" name="r204"
                            value="<?php echo htmlspecialchars($user_data['r204'] ?? ''); ?>" required></td>
                </tr>
            </table>

            <!-- Blok III: Kependudukan dan Ketenagakerjaan -->
            <table>
                <tr>
                    <th colspan="8">BLOK III: KEPENDUDUKAN DAN KETENAGAKERJAAN</th>
                </tr>
                <tr>
                    <td style="text-align:center" rowspan="2">301.</td>
                    <td colspan="7">Jumlah Penduduk dan Keluarga:</td>
                </tr>
                <tr>
                    <td>a. Laki-laki</td>
                    <td><input type="number" style="width:50px" name="r301a" min="0"
                            value="<?php echo htmlspecialchars($user_data['r301a'] ?? ''); ?>" required></td>
                    <td>b. Perempuan</td>
                    <td><input type="number" style="width:50px" name="r301b" min="0"
                            value="<?php echo htmlspecialchars($user_data['r301b'] ?? ''); ?>" required></td>
                    <td>c. Keluarga</td>
                    <td><input type="number" style="width:50px" name="r301c" min="0"
                            value="<?php echo htmlspecialchars($user_data['r301c'] ?? ''); ?>" required></td>
                </tr>
                <tr>
                    <td style="text-align:center" rowspan="5">302.</td>
                    <td colspan="7">Jumlah Penduduk Berdasarkan Pekerjaan:</td>
                </tr>
                <tr>
                    <td>a. ASN(PNS/PPPK)</td>
                    <td><input type="number" style="width:50px" name="r302a" min="0"
                            value="<?php echo htmlspecialchars($user_data['r302a'] ?? ''); ?>"></td>
                    <td>e. Petani/Peternak</td>
                    <td><input type="number" style="width:50px" name="r302e" min="0"
                            value="<?php echo htmlspecialchars($user_data['r302e'] ?? ''); ?>"></td>
                    <td>i. Pedagang</td>
                    <td><input type="number" style="width:50px" name="r302i" min="0"
                            value="<?php echo htmlspecialchars($user_data['r302i'] ?? ''); ?>"></td>
                </tr>
                <tr>
                    <td>b. TNI/POLRI</td>
                    <td><input type="number" style="width:50px" name="r302b" min="0"
                            value="<?php echo htmlspecialchars($user_data['r302b'] ?? ''); ?>"></td>
                    <td>f. Pensiunan</td>
                    <td><input type="number" style="width:50px" name="r302f" min="0"
                            value="<?php echo htmlspecialchars($user_data['r302f'] ?? ''); ?>"></td>
                    <td>j. Pegawai Swasta</td>
                    <td><input type="number" style="width:50px" name="r302j" min="0"
                            value="<?php echo htmlspecialchars($user_data['r302j'] ?? ''); ?>"></td>
                </tr>
                <tr>
                    <td>c. Wiraswasta</td>
                    <td><input type="number" style="width:50px" name="r302c" min="0"
                            value="<?php echo htmlspecialchars($user_data['r302c'] ?? ''); ?>"></td>
                    <td>g. Buruh</td>
                    <td><input type="number" style="width:50px" name="r302g" min="0"
                            value="<?php echo htmlspecialchars($user_data['r302g'] ?? ''); ?>"></td>
                    <td>k. Dosen</td>
                    <td><input type="number" style="width:50px" name="r302k" min="0"
                            value="<?php echo htmlspecialchars($user_data['r302k'] ?? ''); ?>"></td>
                </tr>
                <tr>
                    <td>d. Paramedis</td>
                    <td><input type="number" style="width:50px" name="r302d" min="0"
                            value="<?php echo htmlspecialchars($user_data['r302d'] ?? ''); ?>"></td>
                    <td>h. Nelayan</td>
                    <td><input type="number" style="width:50px" name="r302h" min="0"
                            value="<?php echo htmlspecialchars($user_data['r302h'] ?? ''); ?>"></td>
                    <td>l. Lainnya</td>
                    <td><input type="number" style="width:50px" name="r302l" min="0"
                            value="<?php echo htmlspecialchars($user_data['r302l'] ?? ''); ?>"></td>
                </tr>
                <tr>
                    <td style="text-align:center" rowspan="3">303.</td>
                    <td colspan="7">Jumlah Kepala Keluarga berdasarkan pendidikan terakhir:</td>
                </tr>
                <tr>
                    <td>a. ≤SD/Sederajat</td>
                    <td><input type="number" style="width:50px" name="r303a" min="0"
                            value="<?php echo htmlspecialchars($user_data['r303a'] ?? ''); ?>"></td>
                    <td>c. SMA/Sederajat</td>
                    <td><input type="number" style="width:50px" name="r303c" min="0"
                            value="<?php echo htmlspecialchars($user_data['r303c'] ?? ''); ?>"></td>
                </tr>
                <tr>
                    <td>b. SMP/Sederajat</td>
                    <td><input type="number" style="width:50px" name="r303b" min="0"
                            value="<?php echo htmlspecialchars($user_data['r303b'] ?? ''); ?>"></td>
                    <td>d. >SMA/</td>
                    <td><input type="number" style="width:50px" name="r303d" min="0"
                            value="<?php echo htmlspecialchars($user_data['r303d'] ?? ''); ?>"></td>
                </tr>
                <tr>
                    <td style="text-align:center" rowspan="4">304.</td>
                    <td colspan="7">Jumlah Penduduk Berdasarkan Agama</td>
                </tr>
                <tr>
                    <td>a. Islam</td>
                    <td><input type="number" style="width:50px" name="r304a" min="0"
                            value="<?php echo htmlspecialchars($user_data['r304a'] ?? ''); ?>"></td>
                    <td>d. Hindu</td>
                    <td><input type="number" style="width:50px" name="r304d" min="0"
                            value="<?php echo htmlspecialchars($user_data['r304d'] ?? ''); ?>"></td>
                </tr>
                <tr>
                    <td>b. Kristen</td>
                    <td><input type="number" style="width:50px" name="r304b" min="0"
                            value="<?php echo htmlspecialchars($user_data['r304b'] ?? ''); ?>"></td>
                    <td>e. Budha</td>
                    <td><input type="number" style="width:50px" name="r304e" min="0"
                            value="<?php echo htmlspecialchars($user_data['r304e'] ?? ''); ?>"></td>
                </tr>
                <tr>
                    <td>c. Katolik</td>
                    <td><input type="number" style="width:50px" name="r304c" min="0"
                            value="<?php echo htmlspecialchars($user_data['r304c'] ?? ''); ?>"></td>
                    <td>f. Kepercayaan lainnya</td>
                    <td><input type="number" style="width:50px" name="r304f" min="0"
                            value="<?php echo htmlspecialchars($user_data['r304f'] ?? ''); ?>"></td>
                </tr>
                <tr>
                    <td style="text-align:center" rowspan="3">305.</td>
                    <td colspan="7">Jumlah Keluarga Menurut Penggunaan Listrik</td>
                </tr>
                <tr>
                    <td>a. Listrik PLN</td>
                    <td><input type="number" style="width:50px" name="r305a" min="0"
                            value="<?php echo htmlspecialchars($user_data['r305a'] ?? ''); ?>"></td>
                    <td>c. Bukan Pengguna Listrik</td>
                    <td><input type="number" style="width:50px" name="r305c" min="0"
                            value="<?php echo htmlspecialchars($user_data['r305c'] ?? ''); ?>"></td>
                </tr>
                <tr>
                    <td>b. Listrik Non-PLN</td>
                    <td><input type="number" style="width:50px" name="r305b" min="0"
                            value="<?php echo htmlspecialchars($user_data['r305b'] ?? ''); ?>"></td>
                </tr>
                <tr>
                    <td style="text-align:center" rowspan="2">306.</td>
                    <td colspan="7">Jumlah Keluarga Menurut Kelayakan Rumah</td>
                </tr>
                <tr>
                    <td>a. Keluarga dengan Rumah Layak Huni</td>
                    <td><input type="number" style="width:50px" name="r306a" min="0"
                            value="<?php echo htmlspecialchars($user_data['r306a'] ?? ''); ?>"></td>
                    <td>b. Keluarga dengan Rumah Tidak Layak Huni</td>
                    <td><input type="number" style="width:50px" name="r306b" min="0"
                            value="<?php echo htmlspecialchars($user_data['r306b'] ?? ''); ?>"></td>
                </tr>
            </table>

            <!-- Blok IV: Pendidikan dan Kesehatan -->
            <table>
                <tr>
                    <th colspan="8">BLOK IV: PENDIDIKAN DAN KESEHATAN</th>
                </tr>
                <tr>
                    <td style="text-align:center" rowspan="5">401.</td>
                    <td colspan="7">Jumlah Sarana pendidikan</td>
                </tr>
                <tr>
                    <td>a. PAUD/TK/RA</td>
                    <td><input type="number" style="width:50px" name="r401a" min="0"
                            value="<?php echo htmlspecialchars($user_data['r401a'] ?? ''); ?>"></td>
                    <td>e. Pendidikan Akademi/Perguruan Tinggi</td>
                    <td><input type="number" style="width:50px" name="r401e" min="0"
                            value="<?php echo htmlspecialchars($user_data['r401e'] ?? ''); ?>"></td>
                </tr>
                <tr>
                    <td>b. SD/MI</td>
                    <td><input type="number" style="width:50px" name="r401b" min="0"
                            value="<?php echo htmlspecialchars($user_data['r401b'] ?? ''); ?>"></td>
                    <td>f. SDLB/SMPLB/SMALB</td>
                    <td><input type="number" style="width:50px" name="r401f" min="0"
                            value="<?php echo htmlspecialchars($user_data['r401f'] ?? ''); ?>"></td>
                </tr>
                <tr>
                    <td>c. SMP/MTs</td>
                    <td><input type="number" style="width:50px" name="r401c" min="0"
                            value="<?php echo htmlspecialchars($user_data['r401c'] ?? ''); ?>"></td>
                    <td>g. Pondok Pesantren</td>
                    <td><input type="number" style="width:50px" name="r401g" min="0"
                            value="<?php echo htmlspecialchars($user_data['r401g'] ?? ''); ?>"></td>
                </tr>
                <tr>
                    <td>d. SMA/MA/SMK</td>
                    <td><input type="number" style="width:50px" name="r401d" min="0"
                            value="<?php echo htmlspecialchars($user_data['r401d'] ?? ''); ?>"></td>
                    <td>h. Madrasah Diniyah</td>
                    <td><input type="number" style="width:50px" name="r401h" min="0"
                            value="<?php echo htmlspecialchars($user_data['r401h'] ?? ''); ?>"></td>
                </tr>
                <tr>
                    <td style="text-align:center" rowspan="6">402.</td>
                    <td colspan="7">Jumlah Sarana Kesehatan</td>
                </tr>
                <tr>
                    <td>a. Puskemas</td>
                    <td><input type="number" style="width:50px" name="r402a" min="0"
                            value="<?php echo htmlspecialchars($user_data['r402a'] ?? ''); ?>"></td>
                    <td>f. Tempat praktik bidan</td>
                    <td><input type="number" style="width:50px" name="r402f" min="0"
                            value="<?php echo htmlspecialchars($user_data['r402f'] ?? ''); ?>"></td>
                </tr>
                <tr>
                    <td>b. Poliklinik/Balai Pengobatan</td>
                    <td><input type="number" style="width:50px" name="r402b" min="0"
                            value="<?php echo htmlspecialchars($user_data['r402b'] ?? ''); ?>"></td>
                    <td>g. Poskesdes</td>
                    <td><input type="number" style="width:50px" name="r402g" min="0"
                            value="<?php echo htmlspecialchars($user_data['r402g'] ?? ''); ?>"></td>
                </tr>
                <tr>
                    <td>c. Tempat Praktik Dokter</td>
                    <td><input type="number" style="width:50px" name="r402c" min="0"
                            value="<?php echo htmlspecialchars($user_data['r402c'] ?? ''); ?>"></td>
                    <td>h. Toko Khusus Obat/Jamu</td>
                    <td><input type="number" style="width:50px" name="r402h" min="0"
                            value="<?php echo htmlspecialchars($user_data['r402h'] ?? ''); ?>"></td>
                </tr>
                <tr>
                    <td>d. Apotek</td>
                    <td><input type="number" style="width:50px" name="r402d" min="0"
                            value="<?php echo htmlspecialchars($user_data['r402d'] ?? ''); ?>"></td>
                    <td>i. Posyandu</td>
                    <td><input type="number" style="width:50px" name="r402i" min="0"
                            value="<?php echo htmlspecialchars($user_data['r402i'] ?? ''); ?>"></td>
                </tr>
                <tr>
                    <td>e. Rumah Bersalin</td>
                    <td><input type="number" style="width:50px" name="r402e" min="0"
                            value="<?php echo htmlspecialchars($user_data['r402e'] ?? ''); ?>"></td>
                </tr>
                <tr>
                    <td style="text-align:center" rowspan="4">403.</td>
                    <td colspan="7">Jumlah Tenaga Kesehatan</td>
                </tr>
                <tr>
                    <td>a. Dokter</td>
                    <td><input type="number" style="width:50px" name="r403a" min="0"
                            value="<?php echo htmlspecialchars($user_data['r403a'] ?? ''); ?>"></td>
                    <td>d. Dukun Bayi</td>
                    <td><input type="number" style="width:50px" name="r403d" min="0"
                            value="<?php echo htmlspecialchars($user_data['r403d'] ?? ''); ?>"></td>
                </tr>
                <tr>
                    <td>b. Dokter Gigi</td>
                    <td><input type="number" style="width:50px" name="r403b" min="0"
                            value="<?php echo htmlspecialchars($user_data['r403b'] ?? ''); ?>"></td>
                    <td>e. Lainnya</td>
                    <td><input type="number" style="width:50px" name="r403e" min="0"
                            value="<?php echo htmlspecialchars($user_data['r403e'] ?? ''); ?>"></td>
                </tr>
                <tr>
                    <td>c. Bidan</td>
                    <td><input type="number" style="width:50px" name="r403c" min="0"
                            value="<?php echo htmlspecialchars($user_data['r403c'] ?? ''); ?>"></td>
                </tr>
                <tr>
                    <td style="text-align:center">404.</td>
                    <td colspan="6">Jumlah Penduduk stunting:</td>
                    <td><input type="number" style="width:50px" name="r404" min="0"
                            value="<?php echo htmlspecialchars($user_data['r404'] ?? ''); ?>"></td>
                </tr>
            </table>

            <!-- Blok V: Tempat Ibadah dan Penyandang Disabilitas -->
            <table>
                <tr>
                    <th colspan="8">BLOK V: TEMPAT IBADAH DAN PENYANDANG DISABILITAS</th>
                </tr>
                <tr>
                    <td style="text-align:center" rowspan="5">501.</td>
                    <td colspan="7">Jumlah Tempat Ibadah:</td>
                </tr>
                <tr>
                    <td>a. Mesjid</td>
                    <td><input type="number" style="width:50px" name="r501a" min="0"
                            value="<?php echo htmlspecialchars($user_data['r501a'] ?? ''); ?>"></td>
                    <td>e. Pura</td>
                    <td><input type="number" style="width:50px" name="r501e" min="0"
                            value="<?php echo htmlspecialchars($user_data['r501e'] ?? ''); ?>"></td>
                </tr>
                <tr>
                    <td>b. Surau/Langgar/Mushola</td>
                    <td><input type="number" style="width:50px" name="r501b" min="0"
                            value="<?php echo htmlspecialchars($user_data['r501b'] ?? ''); ?>"></td>
                    <td>f. Wihara</td>
                    <td><input type="number" style="width:50px" name="r501f" min="0"
                            value="<?php echo htmlspecialchars($user_data['r501f'] ?? ''); ?>"></td>
                </tr>
                <tr>
                    <td>c. Gereja kristen</td>
                    <td><input type="number" style="width:50px" name="r501c" min="0"
                            value="<?php echo htmlspecialchars($user_data['r501c'] ?? ''); ?>"></td>
                    <td>g. kelenteng</td>
                    <td><input type="number" style="width:50px" name="r501g" min="0"
                            value="<?php echo htmlspecialchars($user_data['r501g'] ?? ''); ?>"></td>
                </tr>
                <tr>
                    <td>d. Gereja katolik</td>
                    <td><input type="number" style="width:50px" name="r501d" min="0"
                            value="<?php echo htmlspecialchars($user_data['r501d'] ?? ''); ?>"></td>
                    <td>h. lainnya</td>
                    <td><input type="number" style="width:50px" name="r501h" min="0"
                            value="<?php echo htmlspecialchars($user_data['r501h'] ?? ''); ?>"></td>
                </tr>
                <tr>
                    <td style="text-align:center" rowspan="7">502.</td>
                    <td colspan="7">Jumlah Penduduk penyandang disabilitas di Dusun/lingkungan:</td>
                </tr>
                <tr>
                    <td>a. Tuna netra</td>
                    <td><input type="number" style="width:50px" name="r502a" min="0"
                            value="<?php echo htmlspecialchars($user_data['r502a'] ?? ''); ?>"></td>
                    <td>f. Tuna grahita (Mental)</td>
                    <td><input type="number" style="width:50px" name="r502f" min="0"
                            value="<?php echo htmlspecialchars($user_data['r502f'] ?? ''); ?>"></td>
                </tr>
                <tr>
                    <td>b. Tuna rungu (Tuli)</td>
                    <td><input type="number" style="width:50px" name="r502b" min="0"
                            value="<?php echo htmlspecialchars($user_data['r502b'] ?? ''); ?>"></td>
                    <td>g. Tuna Laras</td>
                    <td><input type="number" style="width:50px" name="r502g" min="0"
                            value="<?php echo htmlspecialchars($user_data['r502g'] ?? ''); ?>"></td>
                </tr>
                <tr>
                    <td>c. Tuna Wicara (bisu)</td>
                    <td><input type="number" style="width:50px" name="r502c" min="0"
                            value="<?php echo htmlspecialchars($user_data['r502c'] ?? ''); ?>"></td>
                    <td>h. Tuna eks-sakit kusta</td>
                    <td><input type="number" style="width:50px" name="r502h" min="0"
                            value="<?php echo htmlspecialchars($user_data['r502h'] ?? ''); ?>"></td>
                </tr>
                <tr>
                    <td>d. Tuna rungu-wicara (tuli-bisu)</td>
                    <td><input type="number" style="width:50px" name="r502d" min="0"
                            value="<?php echo htmlspecialchars($user_data['r502d'] ?? ''); ?>"></td>
                    <td>i. Tuna Ganda (fisik-mental)</td>
                    <td><input type="number" style="width:50px" name="r502i" min="0"
                            value="<?php echo htmlspecialchars($user_data['r502i'] ?? ''); ?>"></td>
                </tr>
                <tr>
                    <td>e. Tuna Daksa (disabilitas tubuh)</td>
                    <td><input type="number" style="width:50px" name="r502e" min="0"
                            value="<?php echo htmlspecialchars($user_data['r502e'] ?? ''); ?>"></td>
                </tr>
            </table>

            <!-- Blok VI: Olahraga dan Hiburan -->
            <table>
                <tr>
                    <th colspan="8">BLOK VI: OLAHRAGA DAN HIBURAN</th>
                </tr>
                <tr>
                    <td style="text-align:center" rowspan="7">601.</td>
                    <td colspan="7">Jumlah fasilitas/lapangan olahraga:</td>
                </tr>
                <tr>
                    <td>a. Sepakbola</td>
                    <td><input type="number" style="width:50px" name="r601a" min="0"
                            value="<?php echo htmlspecialchars($user_data['r601a'] ?? ''); ?>"></td>
                    <td>g. Futsal</td>
                    <td><input type="number" style="width:50px" name="r601g" min="0"
                            value="<?php echo htmlspecialchars($user_data['r601g'] ?? ''); ?>"></td>
                </tr>
                <tr>
                    <td>b. Bola Voli</td>
                    <td><input type="number" style="width:50px" name="r601b" min="0"
                            value="<?php echo htmlspecialchars($user_data['r601b'] ?? ''); ?>"></td>
                    <td>h. Renang</td>
                    <td><input type="number" style="width:50px" name="r601h" min="0"
                            value="<?php echo htmlspecialchars($user_data['r601h'] ?? ''); ?>"></td>
                </tr>
                <tr>
                    <td>c. Bulutangkis</td>
                    <td><input type="number" style="width:50px" name="r601c" min="0"
                            value="<?php echo htmlspecialchars($user_data['r601c'] ?? ''); ?>"></td>
                    <td>i. Beladiri (Pencak silat, Karate, dll)</td>
                    <td><input type="number" style="width:50px" name="r601i" min="0"
                            value="<?php echo htmlspecialchars($user_data['r601i'] ?? ''); ?>"></td>
                </tr>
                <tr>
                    <td>d. Bola Basket</td>
                    <td><input type="number" style="width:50px" name="r601d" min="0"
                            value="<?php echo htmlspecialchars($user_data['r601d'] ?? ''); ?>"></td>
                    <td>j. billiard</td>
                    <td><input type="number" style="width:50px" name="r601j" min="0"
                            value="<?php echo htmlspecialchars($user_data['r601j'] ?? ''); ?>"></td>
                </tr>
                <tr>
                    <td>e. Tenis Lapangan</td>
                    <td><input type="number" style="width:50px" name="r601e" min="0"
                            value="<?php echo htmlspecialchars($user_data['r601e'] ?? ''); ?>"></td>
                    <td>k. Fitnes, aerobik, dll</td>
                    <td><input type="number" style="width:50px" name="r601k" min="0"
                            value="<?php echo htmlspecialchars($user_data['r601k'] ?? ''); ?>"></td>
                </tr>
                <tr>
                    <td>f. Tenis Meja</td>
                    <td><input type="number" style="width:50px" name="r601f" min="0"
                            value="<?php echo htmlspecialchars($user_data['r601f'] ?? ''); ?>"></td>
                    <td>l. lainnya</td>
                    <td><input type="number" style="width:50px" name="r601l" min="0"
                            value="<?php echo htmlspecialchars($user_data['r601l'] ?? ''); ?>"></td>
                </tr>
                <tr>
                    <td style="text-align:center">602.</td>
                    <td colspan="6">Jumlah Pub/diskotek/tempat karaoke yang masih aktif di Dusun/Lingkungan:</td>
                    <td><input type="number" style="width:50px" name="r602" min="0"
                            value="<?php echo htmlspecialchars($user_data['r602'] ?? ''); ?>"></td>
                </tr>
            </table>

            <!-- Blok VII: Ekonomi -->
            <table>
                <tr>
                    <th colspan="8">BLOK VII: EKONOMI</th>
                </tr>
                <tr>
                    <td style="text-align:center">701.</td>
                    <td colspan="6">Jumlah Pangkalan/Agen/Penjual Minyak Tanah:</td>
                    <td><input type="number" style="width:50px" name="r701" min="0"
                            value="<?php echo htmlspecialchars($user_data['r701'] ?? ''); ?>"></td>
                </tr>
                <tr>
                    <td style="text-align:center">702.</td>
                    <td colspan="6">Jumlah Pangkalan/Agen/Penjual LPG:</td>
                    <td><input type="number" style="width:50px" name="r702" min="0"
                            value="<?php echo htmlspecialchars($user_data['r702'] ?? ''); ?>"></td>
                </tr>
                <tr>
                    <td style="text-align:center" rowspan="3">703.</td>
                    <td colspan="7">Jumlah Sarana lembaga keuangan yang beroperasi di Dusun/Lingkungan:</td>
                </tr>
                <tr>
                    <td>a. Bank Umum Pemerintah</td>
                    <td><input type="number" style="width:50px" name="r703a" min="0"
                            value="<?php echo htmlspecialchars($user_data['r703a'] ?? ''); ?>"></td>
                    <td>c. Bank Perkreditan rakyat</td>
                    <td><input type="number" style="width:50px" name="r703c" min="0"
                            value="<?php echo htmlspecialchars($user_data['r703c'] ?? ''); ?>"></td>
                </tr>
                <tr>
                    <td>b. Bank Umum Swasta</td>
                    <td><input type="number" style="width:50px" name="r703b" min="0"
                            value="<?php echo htmlspecialchars($user_data['r703b'] ?? ''); ?>"></td>
                </tr>
                <tr>
                    <td style="text-align:center" rowspan="3">704.</td>
                    <td colspan="7">Jumlah Koperasi di Dusun/Lingkungan:</td>
                </tr>
                <tr>
                    <td>a. Koperasi Unit Desa (KUD)</td>
                    <td><input type="number" style="width:50px" name="r704a" min="0"
                            value="<?php echo htmlspecialchars($user_data['r704a'] ?? ''); ?>"></td>
                    <td>c. Koperasi Simpan Pinjam (Kospin)</td>
                    <td><input type="number" style="width:50px" name="r704c" min="0"
                            value="<?php echo htmlspecialchars($user_data['r704c'] ?? ''); ?>"></td>
                </tr>
                <tr>
                    <td>b. Koperasi Industri Kecil & Kopinkra</td>
                    <td><input type="number" style="width:50px" name="r704b" min="0"
                            value="<?php echo htmlspecialchars($user_data['r704b'] ?? ''); ?>"></td>
                    <td>d. Koperasi lainnya</td>
                    <td><input type="number" style="width:50px" name="r704d" min="0"
                            value="<?php echo htmlspecialchars($user_data['r704d'] ?? ''); ?>"></td>
                </tr>
                <tr>
                    <td style="text-align:center" rowspan="6">705.</td>
                    <td colspan="7">Jumlah sarana dan prasarana ekonomi:</td>
                </tr>
                <tr>
                    <td>a. Kelompok Pertokoan</td>
                    <td><input type="number" style="width:50px" name="r705a" min="0"
                            value="<?php echo htmlspecialchars($user_data['r705a'] ?? ''); ?>"></td>
                    <td>f. Restoran/rumah makan</td>
                    <td><input type="number" style="width:50px" name="r705f" min="0"
                            value="<?php echo htmlspecialchars($user_data['r705f'] ?? ''); ?>"></td>
                </tr>
                <tr>
                    <td>b. Pasar dengan bangunan permanen</td>
                    <td><input type="number" style="width:50px" name="r705b" min="0"
                            value="<?php echo htmlspecialchars($user_data['r705b'] ?? ''); ?>"></td>
                    <td>g. Warung/kedai makanan minuman</td>
                    <td><input type="number" style="width:50px" name="r705g" min="0"
                            value="<?php echo htmlspecialchars($user_data['r705g'] ?? ''); ?>"></td>
                </tr>
                <tr>
                    <td>c. Pasar dengan bangunan semi permanen</td>
                    <td><input type="number" style="width:50px" name="r705c" min="0"
                            value="<?php echo htmlspecialchars($user_data['r705c'] ?? ''); ?>"></td>
                    <td>h. Penginapan</td>
                    <td><input type="number" style="width:50px" name="r705h" min="0"
                            value="<?php echo htmlspecialchars($user_data['r705h'] ?? ''); ?>"></td>
                </tr>
                <tr>
                    <td>d. Pasar tanpa bangunan</td>
                    <td><input type="number" style="width:50px" name="r705d" min="0"
                            value="<?php echo htmlspecialchars($user_data['r705d'] ?? ''); ?>"></td>
                    <td>i. Toko/warung kelontong</td>
                    <td><input type="number" style="width:50px" name="r705i" min="0"
                            value="<?php echo htmlspecialchars($user_data['r705i'] ?? ''); ?>"></td>
                </tr>
                <tr>
                    <td>e. Minimarket/Swalayan/supermarket</td>
                    <td><input type="number" style="width:50px" name="r705e" min="0"
                            value="<?php echo htmlspecialchars($user_data['r705e'] ?? ''); ?>"></td>
                    <td>j. Pertamina/Pertashop</td>
                    <td><input type="number" style="width:50px" name="r705j" min="0"
                            value="<?php echo htmlspecialchars($user_data['r705j'] ?? ''); ?>"></td>
                </tr>
                <tr>
                    <td style="text-align:center" rowspan="4">706.</td>
                    <td colspan="7">Jumlah sarana penunjang ekonomi:</td>
                </tr>
                <tr>
                    <td>a. Pengadaian</td>
                    <td><input type="number" style="width:50px" name="r706a" min="0"
                            value="<?php echo htmlspecialchars($user_data['r706a'] ?? ''); ?>"></td>
                    <td>d. Salon kecantikan</td>
                    <td><input type="number" style="width:50px" name="r706d" min="0"
                            value="<?php echo htmlspecialchars($user_data['r706d'] ?? ''); ?>"></td>
                </tr>
                <tr>
                    <td>b. Anjungan Tunai Mandiri (ATM)</td>
                    <td><input type="number" style="width:50px" name="r706b" min="0"
                            value="<?php echo htmlspecialchars($user_data['r706b'] ?? ''); ?>"></td>
                    <td>e. Agen tiket/travel/biro perjalanan</td>
                    <td><input type="number" style="width:50px" name="r706e" min="0"
                            value="<?php echo htmlspecialchars($user_data['r706e'] ?? ''); ?>"></td>
                </tr>
                <tr>
                    <td>c. Bengkel mobil/Motor</td>
                    <td><input type="number" style="width:50px" name="r706c" min="0"
                            value="<?php echo htmlspecialchars($user_data['r706c'] ?? ''); ?>"></td>
                </tr>
                <tr>
                    <td style="text-align:center" rowspan="5">707.</td>
                    <td colspan="7">Jumlah Penduduk menurut Bantuan Sosial Ekonomi yang diterima</td>
                </tr>
                <tr>
                    <td>a. Bantuan Sosial Sembako/BPNT</td>
                    <td><input type="number" style="width:50px" name="r707a" min="0"
                            value="<?php echo htmlspecialchars($user_data['r707a'] ?? ''); ?>"></td>
                    <td>e. Program Indonesia Pintar (PIP)</td>
                    <td><input type="number" style="width:50px" name="r707e" min="0"
                            value="<?php echo htmlspecialchars($user_data['r707e'] ?? ''); ?>"></td>
                </tr>
                <tr>
                    <td>b. Program Keluarga Harapan (PKH)</td>
                    <td><input type="number" style="width:50px" name="r707b" min="0"
                            value="<?php echo htmlspecialchars($user_data['r707b'] ?? ''); ?>"></td>
                    <td>f. BPJS PBI</td>
                    <td><input type="number" style="width:50px" name="r707f" min="0"
                            value="<?php echo htmlspecialchars($user_data['r707f'] ?? ''); ?>"></td>
                </tr>
                <tr>
                    <td>c. Bantuan Langsung Tunai (BLT) Desa</td>
                    <td><input type="number" style="width:50px" name="r707c" min="0"
                            value="<?php echo htmlspecialchars($user_data['r707c'] ?? ''); ?>"></td>
                    <td>g. Program Bantuan Pemerintah Provinsi</td>
                    <td><input type="number" style="width:50px" name="r707g" min="0"
                            value="<?php echo htmlspecialchars($user_data['r707g'] ?? ''); ?>"></td>
                </tr>
                <tr>
                    <td>d. Subsudi Listrik (gratis/pemotongan biaya)</td>
                    <td><input type="number" style="width:50px" name="r707d" min="0"
                            value="<?php echo htmlspecialchars($user_data['r707d'] ?? ''); ?>"></td>
                    <td>h. Program Bantuan Pemerintah Kabupaten/Kota</td>
                    <td><input type="number" style="width:50px" name="r707h" min="0"
                            value="<?php echo htmlspecialchars($user_data['r707h'] ?? ''); ?>"></td>
                </tr>
                <tr>
                    <td style="text-align:center" rowspan="5">708.</td>
                    <td colspan="7">Jumlah Industri Kecil dan Menengah</td>
                </tr>
                <tr>
                    <td>a. Industri Makanan</td>
                    <td><input type="number" style="width:50px" name="r708a" min="0"
                            value="<?php echo htmlspecialchars($user_data['r708a'] ?? ''); ?>"></td>
                    <td>e. Industri Kerajinan</td>
                    <td><input type="number" style="width:50px" name="r708e" min="0"
                            value="<?php echo htmlspecialchars($user_data['r708e'] ?? ''); ?>"></td>
                </tr>
                <tr>
                    <td>b. Industri alat rumah tangga</td>
                    <td><input type="number" style="width:50px" name="r708b" min="0"
                            value="<?php echo htmlspecialchars($user_data['r708b'] ?? ''); ?>"></td>
                    <td>f. Rumah makan dan restoran</td>
                    <td><input type="number" style="width:50px" name="r708f" min="0"
                            value="<?php echo htmlspecialchars($user_data['r708f'] ?? ''); ?>"></td>
                </tr>
                <tr>
                    <td>c. Industri material bahan bangunan</td>
                    <td><input type="number" style="width:50px" name="r708c" min="0"
                            value="<?php echo htmlspecialchars($user_data['r708c'] ?? ''); ?>"></td>
                    <td>g. lainnya</td>
                    <td><input type="number" style="width:50px" name="r708g" min="0"
                            value="<?php echo htmlspecialchars($user_data['r708g'] ?? ''); ?>"></td>
                </tr>
                <tr>
                    <td>d. Industri Alat Pertanian</td>
                    <td><input type="number" style="width:50px" name="r708d" min="0"
                            value="<?php echo htmlspecialchars($user_data['r708d'] ?? ''); ?>"></td>
                </tr>
            </table>

            <!-- Blok VIII: Pertanian dan Peternakan -->
            <table>
                <tr>
                    <th colspan="7">BLOK VIII: PERTANIAN DAN PETERNAKAN</th>
                </tr>
                <tr>
                    <td style="text-align:center">801.</td>
                    <td colspan="5">Luas Sawah (hektar):</td>
                    <td><input type="number" style="width:50px" name="r801" min="0" step="0.01"
                            value="<?php echo htmlspecialchars($user_data['r801'] ?? ''); ?>"></td>
                </tr>
                <tr>
                    <td style="text-align:center">802.</td>
                    <td colspan="5">Luas Tanam Padi (hektar):</td>
                    <td><input type="number" style="width:50px" name="r802" min="0" step="0.01"
                            value="<?php echo htmlspecialchars($user_data['r802'] ?? ''); ?>"></td>
                </tr>
                <tr>
                    <td style="text-align:center">803.</td>
                    <td colspan="5">Luas Tanam Jagung (hektar):</td>
                    <td><input type="number" style="width:50px" name="r803" min="0" step="0.01"
                            value="<?php echo htmlspecialchars($user_data['r803'] ?? ''); ?>"></td>
                </tr>
                <tr>
                    <td style="text-align:center">804.</td>
                    <td colspan="5">Hasil Produksi GKP (Ton):</td>
                    <td><input type="number" style="width:50px" name="r804" min="0" step="0.01"
                            value="<?php echo htmlspecialchars($user_data['r804'] ?? ''); ?>"></td>
                </tr>
                <tr>
                    <td style="text-align:center">805.</td>
                    <td colspan="5">Hasil Produksi Jagung Pipilan Kering(ton):</td>
                    <td><input type="number" style="width:50px" name="r805" min="0" step="0.01"
                            value="<?php echo htmlspecialchars($user_data['r805'] ?? ''); ?>"></td>
                </tr>
                <tr>
                    <td style="text-align:center" rowspan="3">806.</td>
                    <td colspan="8">Jumlah Peternak dan Jumlah Hewan Ternak:</td>
                </tr>
                <tr>
                    <td>a. Jumlah Peternak Sapi</td>
                    <td><input type="number" style="width:50px" name="r806a" min="0"
                            value="<?php echo htmlspecialchars($user_data['r806a'] ?? ''); ?>"></td>
                    <td>c. Jumlah Peternak Kambing</td>
                    <td><input type="number" style="width:50px" name="r806c" min="0"
                            value="<?php echo htmlspecialchars($user_data['r806c'] ?? ''); ?>"></td>
                </tr>
                <tr>
                    <td>b. Jumlah Sapi</td>
                    <td><input type="number" style="width:50px" name="r806b" min="0"
                            value="<?php echo htmlspecialchars($user_data['r806b'] ?? ''); ?>"></td>
                    <td>d. Jumlah Kambing</td>
                    <td><input type="number" style="width:50px" name="r806d" min="0"
                            value="<?php echo htmlspecialchars($user_data['r806d'] ?? ''); ?>"></td>
                </tr>
            </table>

            <!-- Blok X: Catatan -->
            <table>
                <tr>
                    <th>BLOK X: CATATAN</th>
                </tr>
                <tr>
                    <td><textarea name="catatan"
                            placeholder="Masukkan catatan tambahan jika ada"><?php echo htmlspecialchars($user_data['catatan'] ?? ''); ?></textarea>
                    </td>
                </tr>
            </table>

            <button type="submit" name="update">Update Data</button>
        </form>
    </div>

    <script>
    // Sync dusun name and code selections
    document.getElementById('namasls').addEventListener('change', function() {
        const selectedIndex = this.selectedIndex;
        document.getElementById('kodesls').selectedIndex = selectedIndex;
    });

    document.getElementById('kodesls').addEventListener('change', function() {
        const selectedIndex = this.selectedIndex;
        document.getElementById('namasls').selectedIndex = selectedIndex;
    });

    // Form validation
    document.querySelector('form').addEventListener('submit', function(e) {
        const requiredFields = document.querySelectorAll('[required]');
        let isValid = true;

        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                field.style.borderColor = 'red';
                isValid = false;
            } else {
                field.style.borderColor = '';
            }
        });

        if (!isValid) {
            e.preventDefault();
            alert('Silakan lengkapi semua field yang wajib diisi!');
        }
    });
    </script>
</body>

</html>