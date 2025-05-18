<?php
session_start();

if(!isset($_SESSION['uname'])) {
    header("location:login.php?pesan=belum_login");
    exit;
}

include 'koneksi.php';

// Ambil parameter tahun dari URL, default tahun sekarang
$tahun = isset($_GET['tahun']) ? intval($_GET['tahun']) : date('Y');
$table_name = "data_" . $tahun;
$table_desa = "data_desa_" . $tahun;

// Validasi tahun (antara 2020-2030)
if($tahun < 2020 || $tahun > 2030) {
    $tahun = date('Y');
    $table_name = "data_" . $tahun;
    $table_desa = "data_desa_" . $tahun;
}

// Cek apakah tabel tahun tersebut ada
$result = mysqli_query($conn, "SHOW TABLES LIKE '$table_name'");
if(mysqli_num_rows($result) == 0) {
    $table_name = "data" . date('Y'); // Fallback ke tahun sekarang jika tabel tidak ada
    $tahun = date('Y');
}

$result_desa = mysqli_query($conn, "SHOW TABLES LIKE '$table_desa'");
if(mysqli_num_rows($result_desa) == 0) {
    $table_desa = "data_desa_" . date('Y'); // Fallback ke tahun sekarang jika tabel tidak ada
    $tahun = date('Y');
}

// Ambil data session
$uname = $_SESSION['uname'] ?? '';
$level = $_SESSION['level'] ?? '';
$nama_desa = $_SESSION['nama_desa1'] ?? '';
$kode_desa = $_SESSION['kode_desa'] ?? '';
$nama_kec = $_SESSION['nama_kec1'] ?? '';
$kode_kec = $_SESSION['kode_kec'] ?? '';
$user_id = $_SESSION['id'] ?? '';

// Query data desa
$query_desa = "SELECT * FROM $table_desa WHERE 
              (r104 = ? OR r104a = ? )";
$stmt_desa = mysqli_prepare($conn, $query_desa);

if (!$stmt_desa) {
    die("Error preparing statement: " . mysqli_error($conn));
}

// Bind parameter
mysqli_stmt_bind_param($stmt_desa, "ss", $nama_desa, $kode_desa);
// Execute query
if (!mysqli_stmt_execute($stmt_desa)) {
    die("Error executing statement: " . mysqli_stmt_error($stmt_desa));
}

// Dapatkan hasil query
$result_desa = mysqli_stmt_get_result($stmt_desa);

// Verifikasi hasil query
if (!$result_desa) {
    die("Error getting result set: " . mysqli_error($conn));
}

// Pastikan ini bukan objek mysqli_result sebelum digunakan
if (!is_object($result_desa) || get_class($result_desa) !== 'mysqli_result') {
    die("Invalid result set");
}

// Query data dusun
$query = "SELECT * FROM $table_name WHERE r104a= ?"; // 2 placeholder
$stmt = mysqli_prepare($conn, $query);
if ($stmt) {
    mysqli_stmt_bind_param($stmt, "s", $nama_desa); // 2 parameter
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
} else {
    die("Error preparing statement: " . mysqli_error($conn));
}
$debug_query = "SELECT * FROM $table_desa LIMIT 5";
$debug_result = mysqli_query($conn, $debug_query);



?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Desa Cantik OKU Selatan - <?php echo htmlspecialchars($nama_desa ?? 'Admin'); ?></title>
    <link rel="stylesheet" href="css/adminstyle.css">
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
    <style>
    .sample-data {
        background-color: #f8f9fa;
        padding: 15px;
        color: #6c757d;
    }

    .sample-data pre {
        background-color: #e9ecef;
        padding: 10px;
        border-radius: 5px;
        overflow-x: auto;
    }
    </style>

</head>

<body>
    <?php
    if(isset($_GET['pesan'])) {
        $pesan = htmlspecialchars($_GET['pesan']);
        echo '<div class="alert ';
        switch($pesan) {
            case 'insert_sukses':
                echo 'alert-success">Data berhasil disimpan';
                break;
            case 'insert_gagal':
                echo 'alert-danger">Gagal menyimpan data';
                break;
            case 'invalid_year':
                echo 'alert-warning">Tahun tidak valid';
                break;
            default:
                echo 'alert-info">' . $pesan;
        }
        echo '</div>';
    }
    ?>

    <div class="sidebar">
        <div class="profile">
            <i class="fa fa-user-circle"></i>
            <span><?php echo htmlspecialchars($uname); ?></span>
            <small><?php echo htmlspecialchars($level); ?></small>
        </div>

        <h3>Menu Admin</h3>

        <div class="menu-box" onclick="window.location.href='berita-admin.php'">
            <i class="fa fa-newspaper-o"></i> Kelola Berita
        </div>

        <div class="menu-box" onclick="window.location.href='infografis-admin.php'">
            <i class="fa fa-bar-chart"></i> Kelola Infografis
        </div>

        <div class="menu-box active" onclick="window.location.href='admin.php'">
            <i class="fa fa-database"></i> Kelola Data Desa
        </div>

        <?php if($level == 'superadmin'): ?>
        <div class="menu-box" onclick="window.location.href='pengguna-admin.php'">
            <i class="fa fa-users"></i> Kelola Pengguna
        </div>
        <?php endif; ?>

        <div class="menu-box-log-out" onclick="window.location.href='logout.php'">
            <i class="fa fa-sign-out"></i> Logout
        </div>
    </div>

    <div class="main-content">
        <div class="header">
            <h2>Daftar SLS Desa <?php echo htmlspecialchars($nama_desa); ?> (Tahun <?php echo $tahun; ?>)</h2>
            <div class="action-buttons">
                <a href="entri-dusun.php?tahun=<?php echo $tahun; ?>" class="add-btn">
                    <i class="fa fa-plus"></i> Tambah Dusun
                </a>
                <a href="entri-desa.php?tahun=<?php echo $tahun; ?>" class="add-btn">
                    <i class="fa fa-plus"></i> Tambah Desa
                </a>
                <a href="#importModal" rel="modal:open" class="import-btn">
                    <i class="fa fa-upload"></i> Import Excel
                </a>
            </div>
        </div>

        <div id="importModal" class="modal">
            <h2>Import Data dari Excel</h2>
            <form action="import_excel.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="tahun" value="<?php echo $tahun; ?>">
                <div class="form-group">
                    <label for="excel_file">Pilih file Excel:</label>
                    <input type="file" name="excel_file" id="excel_file" accept=".xlsx,.xls" required>
                </div>
                <div class="form-group">
                    <input type="submit" value="Import Data" class="btn-submit">
                    <button type="button" class="btn-cancel" onclick="$.modal.close()">Batal</button>
                </div>
            </form>
        </div>

        <div class="year-selector">
            <label for="tahun">Pilih Tahun:</label>
            <select id="tahun" name="tahun" onchange="window.location.href='?tahun=' + this.value">
                <?php
                $current_year = date('Y');
                for($y = $current_year - 2; $y <= $current_year + 2; $y++):
                ?>
                <option value="<?php echo $y; ?>" <?php echo $tahun == $y ? 'selected' : ''; ?>>
                    <?php echo $y; ?>
                </option>
                <?php endfor; ?>
            </select>
        </div>

        <div class="data-section">
            <h3>Data Desa</h3>
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kecamatan</th>
                            <th>Desa</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            // Pastikan $result_desa valid dan memiliki data
                            if ($result_desa && mysqli_num_rows($result_desa) > 0) {
                                $no = 1;
                                while($data_desa = mysqli_fetch_assoc($result_desa)) {
                                    // Gunakan null coalescing operator untuk menghindari undefined index
                                    $id = $data_desa['id'] ?? null;
                                    $kecamatan = $data_desa['kecamatan'] ?? $data_desa['nama_kecamatan'] ?? $data_desa['r103a'] ?? 'Data tidak tersedia';
                                    $desa = $data_desa['desa'] ?? $data_desa['nama_desa'] ?? $data_desa['r104'] ?? 'Data tidak tersedia';
                                    
                                    // Pastikan ID ada sebelum menampilkan aksi
                                    if ($id !== null) {
                            ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= htmlspecialchars($kecamatan) ?></td>
                            <td><?= htmlspecialchars($desa) ?></td>
                            <td class="action-links">
                                <a href="edit-desa.php?id=<?= $id ?>&tahun=<?= $tahun ?>" class="edit-link">
                                    <i class="fa fa-edit"></i> Edit
                                </a>
                                <a href="delete.php?type=desa&id=<?= $id ?>&tahun=<?= $tahun ?>" class="delete-link"
                                    onclick="return confirm('Hapus data desa <?= addslashes($desa) ?>?')">
                                    <i class="fa fa-trash"></i> Hapus
                                </a>
                            </td>
                        </tr>
                        <?php
                                    }
                                }
                            } else {
                                echo '<tr><td colspan="4" class="no-data">Tidak ada data desa ditemukan</td></tr>';
                            }
                            ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="data-section">
            <h3>Data Dusun</h3>
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kecamatan</th>
                            <th>Desa</th>
                            <th>Dusun</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        

$debug_query = "SELECT * FROM $table_desa WHERE r104 = '$nama_desa' OR r104a = '$kode_desa'";
$debug_result = mysqli_query($conn, $debug_query);

                        if(mysqli_num_rows($result) > 0) {
                            $no = 1;
                            while($data_dusun = mysqli_fetch_assoc($result)): 
                                $id = htmlspecialchars($data_dusun['id'] ?? 'N/A');
                                $kecamatan = htmlspecialchars($data_dusun['r103a'] ?? 'Data tidak tersedia');
                                $desa = htmlspecialchars($data_dusun['r104a'] ?? 'Data tidak tersedia');
                                $dusun = htmlspecialchars($data_dusun['r105'] ?? 'Data tidak tersedia');
                        ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo $kecamatan; ?></td>
                            <td><?php echo $desa; ?></td>
                            <td><?php echo $dusun; ?></td>
                            <td class="action-links">
                                <a href="edit-dusun.php?id=<?php echo $id; ?>&tahun=<?php echo $tahun; ?>"
                                    class="edit-link">
                                    <i class="fa fa-edit"></i> Edit
                                </a>
                                <a href="delete.php?type=dusun&id=<?php echo $id; ?>&tahun=<?php echo $tahun; ?>"
                                    class="delete-link"
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus data dusun ini?')">
                                    <i class="fa fa-trash"></i> Hapus
                                </a>
                            </td>
                        </tr>
                        <?php 
                            endwhile;
                        } else {
                            echo '<tr><td colspan="5" class="no-data">Tidak ada data dusun ditemukan untuk tahun ini</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
    // Auto close alert after 5 seconds
    $(document).ready(function() {
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 5000);
    });
    </script>
</body>

</html>