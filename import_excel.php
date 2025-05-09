<?php
session_start();

if(!isset($_SESSION['uname'])) {
    header("location:login.php?pesan=belum_login");
    exit;
}

include 'koneksi.php';

// Ambil tahun dari form
$tahun = isset($_POST['tahun']) ? intval($_POST['tahun']) : 2025;
$table_name = "data" . $tahun;

// Cek apakah file diupload
if(isset($_FILES['excel_file']) && $_FILES['excel_file']['error'] == UPLOAD_ERR_OK) {
    $file_info = pathinfo($_FILES['excel_file']['name']);
    $extension = strtolower($file_info['extension']);
    
    // Cek ekstensi file
    if(in_array($extension, ['xlsx', 'xls'])) {
        // Panggil library PHPExcel (gunakan PhpSpreadsheet untuk versi baru)
        require_once 'vendor/autoload.php';
        
        try {
            // Load file Excel
            if($extension == 'xlsx') {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            } else {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
            }
            
            $spreadsheet = $reader->load($_FILES['excel_file']['tmp_name']);
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = $worksheet->toArray();
            
            // Lewati header (baris pertama)
            array_shift($rows);
            
            // Mulai transaksi
            mysqli_begin_transaction($conn);
            
            foreach($rows as $row) {
                // Sesuaikan dengan struktur tabel Anda
                $r103a = mysqli_real_escape_string($conn, $row[0] ?? '');
                $r104a = mysqli_real_escape_string($conn, $row[1] ?? '');
                $r105 = mysqli_real_escape_string($conn, $row[2] ?? '');
                
                $query = "INSERT INTO $table_name (r103a, r104a, r105) VALUES ('$r103a', '$r104a', '$r105')";
                mysqli_query($conn, $query) or die(mysqli_error($conn));
            }
            
            // Commit transaksi jika semua query berhasil
            mysqli_commit($conn);
            header("location:admin.php?tahun=$tahun&pesan=import_success");
        } catch(Exception $e) {
            // Rollback jika ada error
            mysqli_rollback($conn);
            header("location:admin.php?tahun=$tahun&pesan=import_failed");
        }
    } else {
        header("location:admin.php?tahun=$tahun&pesan=invalid_file");
    }
} else {
    header("location:admin.php?tahun=$tahun&pesan=import_failed");
}