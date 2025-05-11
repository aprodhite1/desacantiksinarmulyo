<?php
session_start();

if(!isset($_SESSION['uname'])) {
    header("location:login.php?pesan=belum_login");
    exit;
}

include 'koneksi.php';

// Ambil parameter tahun dari URL, default 2025
$tahun = isset($_GET['tahun']) ? intval($_GET['tahun']) : 2025;
$table_name = "data" . $tahun;

// Cek apakah tabel tahun tersebut ada
$result = mysqli_query($conn, "SHOW TABLES LIKE '$table_name'");
if(mysqli_num_rows($result) == 0) {
    $table_name = "data2025"; // Fallback ke 2025 jika tabel tidak ada
    $tahun = 2025;
}

// Query data berdasarkan tahun
$result = mysqli_query($conn, "SELECT * FROM $table_name") or die("Query error: ".mysqli_error($conn));
$first_row = mysqli_fetch_assoc($result);
mysqli_data_seek($result, 0);

// Ambil data session
$uname = $_SESSION['uname'] ?? '';
$level = $_SESSION['level'] ?? '';
$nama = $_SESSION['nama_desa1'] ?? '';
$kode = $_SESSION['kode_desa'] ?? '';
$namakec = $_SESSION['nama_kec1'] ?? '';
$kodekec = $_SESSION['kode_kec'] ?? '';
$id = $_SESSION['id'] ?? '';

// Query data berdasarkan tahun dan nama desa yang sesuai dengan session
$query = "SELECT * FROM $table_name WHERE r104a = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "s", $nama);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$first_row = mysqli_fetch_assoc($result);
mysqli_data_seek($result, 0);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Desa Cantik OKU Selatan - <?php echo htmlspecialchars($nama ?? ''); ?></title>
    <link rel="stylesheet" href="css/adminstyle.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>

    <style>
    body {
        font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        line-height: 1.6;
        color: #333;
        margin: 0;
        padding: 0;
        display: flex;
    }

    .sidebar {
        background: rgb(245, 245, 245);
        color: black;
        padding: 20px;
        width: 250px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .sidebar h3 {
        margin-top: 0;
        padding-bottom: 10px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        font-size: 18px;
    }

    .menu-box {
        padding: 12px 15px;
        margin: 8px 0;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 5px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
    }

    .menu-box-log-out {
        background: rgb(190, 36, 52);
        padding: 12px 15px;
        margin: 8px 0;
        color: white;
        font-weight: bold;
        border-radius: 5px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
    }

    .menu-box-log-out i {
        margin-right: 10px;
        width: 20px;
        text-align: center;
    }

    .menu-box:hover {
        background: rgba(80, 69, 69, 0.2);
        transform: translateX(5px);
    }

    .menu-box.active {
        background: rgba(255, 255, 255, 0.3);
        font-weight: bold;
    }

    .menu-box i {
        margin-right: 10px;
        width: 20px;
        text-align: center;
    }

    .main-content {
        flex: 1;
        padding: 20px;
    }

    h2 {
        color: #2c3e50;
        margin-bottom: 25px;
        padding-bottom: 10px;
        border-bottom: 2px solid #3498db;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin: 25px 0;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    }

    th,
    td {
        padding: 12px 15px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    th {
        background-color: #d2b356;
        color: #fff;
        font-weight: 600;
    }

    tr:nth-child(even) {
        background-color: #f8f9fa;
    }

    tr:hover {
        background-color: #f1f1f1;
    }

    .action-links a {
        display: inline-block;
        padding: 6px 12px;
        margin: 0 5px;
        border-radius: 4px;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .edit-link {
        color: #fff;
        background-color: #28a745;
        border: 1px solid #28a745;
    }

    .edit-link:hover {
        background-color: #218838;
        border-color: #1e7e34;
    }

    .delete-link {
        color: #fff;
        background-color: #dc3545;
        border: 1px solid #dc3545;
    }

    .delete-link:hover {
        background-color: #c82333;
        border-color: #bd2130;
    }

    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }

    .add-btn {
        display: inline-block;
        padding: 10px 15px;
        background-color: #17a2b8;
        color: white;
        text-decoration: none;
        border-radius: 4px;
        transition: background-color 0.3s;
    }

    .add-btn:hover {
        background-color: #138496;
    }

    .import-btn {
        display: inline-block;
        padding: 10px 15px;
        background-color: #28a745;
        color: white;
        text-decoration: none;
        border-radius: 4px;
        transition: background-color 0.3s;
        margin-left: 10px;
    }

    .import-btn:hover {
        background-color: #218838;
    }

    /* Style untuk modal import */
    .modal {
        max-width: 500px;
    }

    .modal h2 {
        margin-top: 0;
    }

    .modal form {
        display: flex;
        flex-direction: column;
    }

    .modal form input[type="file"] {
        margin: 15px 0;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }

    .modal form input[type="submit"] {
        background-color: #28a745;
        color: white;
        border: none;
        padding: 10px 15px;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .modal form input[type="submit"]:hover {
        background-color: #218838;
    }

    .button-group {
        display: flex;
        align-items: center;
    }
    </style>
</head>
<?php
if(isset($_GET['pesan'])) {
    switch($_GET['pesan']) {
        case 'insert_sukses':
            echo '<div class="alert alert-success">Data berhasil disimpan</div>';
            break;
        case 'insert_gagal':
            echo '<div class="alert alert-danger">Gagal menyimpan data</div>';
            break;
        case 'invalid_year':
            echo '<div class="alert alert-warning">Tahun tidak valid</div>';
            break;
    }
}
?>

<body>
    <div class="sidebar">
        <h3>Menu Admin</h3>

        <div class="menu-box" onclick="window.location.href='berita-admin.html'">
            <i class="fa fa-newspaper-o"></i> Kelola Berita
        </div>

        <div class="menu-box" onclick="window.location.href='infografis-admin.html'">
            <i class="fa fa-bar-chart"></i> Kelola Infografis
        </div>

        <div class="menu-box" onclick="window.location.href='data-desa-admin.html'">
            <i class="fa fa-database"></i> Kelola Data Desa
        </div>

        <div class="menu-box" onclick="window.location.href='pengguna-admin.html'">
            <i class="fa fa-users"></i> Kelola Pengguna
        </div>

        <div class="menu-box-log-out" onclick="window.location.href='logout.php'">
            <i class="fa fa-sign-out"></i> Logout
        </div>
    </div>

    <div class="main-content">

        <div class="header">
            <h2>Daftar SLS Desa <?php echo htmlspecialchars($nama ?? ''); ?> (Tahun <?php echo $tahun; ?>)</h2>
            <div>
                <a href="entri.php?tahun=<?php echo $tahun; ?>" class="add-btn">Tambah Data Baru</a>
                <a href="#importModal" rel="modal:open" class="import-btn">Import Excel</a>

            </div>
        </div>
        <div id="importModal" class="modal">
            <h2>Import Data dari Excel</h2>
            <form action="import_excel.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="tahun" value="<?php echo $tahun; ?>">
                <label for="excel_file">Pilih file Excel:</label>
                <input type="file" name="excel_file" id="excel_file" accept=".xlsx,.xls" required>
                <input type="submit" value="Import Data">
            </form>
        </div>
        <label for="tahun">Pilih Tahun</label>
        <select id="tahun" name="tahun" onchange="window.location.href='?tahun=' + this.value">
            <option value="2023" <?php echo $tahun == 2023 ? 'selected' : ''; ?>>2023</option>
            <option value="2024" <?php echo $tahun == 2024 ? 'selected' : ''; ?>>2024</option>
            <option value="2025" <?php echo $tahun == 2025 ? 'selected' : ''; ?>>2025</option>
            <option value="2026" <?php echo $tahun == 2026 ? 'selected' : ''; ?>>2026</option>
            <option value="2027" <?php echo $tahun == 2027 ? 'selected' : ''; ?>>2027</option>
        </select>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Kecamatan</th>
                    <th>Desa</th>
                    <th>Dusun</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if(mysqli_num_rows($result) > 0) {
                    while($user_data = mysqli_fetch_assoc($result)): 
                        $id = htmlspecialchars($user_data['id'] ?? 'N/A');
                        $kecamatan = htmlspecialchars($user_data['r103a'] ?? 'Data tidak tersedia');
                        $desa = htmlspecialchars($user_data['r104a'] ?? 'Data tidak tersedia');
                        $dusun = htmlspecialchars($user_data['r105'] ?? 'Data tidak tersedia');
                        $encoded_id = urlencode($id);
                ?>
                <tr>
                    <td><?php echo $id; ?></td>
                    <td><?php echo $kecamatan; ?></td>
                    <td><?php echo $desa; ?></td>
                    <td><?php echo $dusun; ?></td>
                    <td class="action-links">
                        <a href="edit.php?id=<?php echo $encoded_id; ?>&tahun=<?php echo $tahun; ?>"
                            class="edit-link">Edit</a>
                        <a href="delete.php?id=<?php echo $encoded_id; ?>&tahun=<?php echo $tahun; ?>"
                            class="delete-link"
                            onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</a>
                    </td>
                </tr>
                <?php 
                    endwhile;
                } else {
                    echo '<tr><td colspan="5" style="text-align:center;">Tidak ada data ditemukan untuk tahun ini</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>

</body>

</html>