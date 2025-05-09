<?php
//ini adalah membuat sessionnya
session_start();

//menghubungkan dengan koneksi
include 'koneksi.php';

//menangkap data yang dikirim dari form
$uname = trim($_POST['uname']);
$pswd = trim($_POST['pswd']);

// menyeleksi data admin dengan username dan password yang sesuai
$data = mysqli_query($conn, "SELECT * FROM desacantik WHERE uname='$uname'");
if (!$data) {
    die("Query error: " . mysqli_error($conn));
}

// menghitung jumlah data yang ditemukan
$cek = mysqli_num_rows($data);

// jika data lebih dari 0, maka akan disimpan ke dalam session
// jika tidak, alihkan ke halaman login dan tampilkan pesan gagal

if($cek == 0){
    header("location:login.php?pesan=gagal");
    exit;
}
else {
    $row = mysqli_fetch_assoc($data);
    $dbusername = $row['uname'];
    $dbpassword = $row['pswd'];
    $dblevel = $row['level'];
    $dbnama = $row['nama_desa1'];
    $dbkode = $row['kode_desa'];
    $dbnamakec = $row['nama_kec1'];
    $dbkodekec = $row['kode_kec'];
    $dbaktivasi = $row['aktivasi'];
    $dbid = $row['id'];
                
    /*Script ini berfungsi untuk mengecek kebenaran username dan password, 
    jika sudah benar maka program akan membuat session login
    */
    $pass = $pswd;
    if ($uname == $dbusername && ($pass==$dbpassword)){
        $_SESSION['uname'] = $uname;
        $_SESSION['level'] = $dblevel;
        $_SESSION['nama_desa1'] = $dbnama;
        $_SESSION['kode_desa'] = $dbkode;
        $_SESSION['nama_kec1'] = $dbnamakec;
        $_SESSION['kode_kec'] = $dbkodekec;
        $_SESSION['aktivasi'] = $dbaktivasi;
        $_SESSION['id'] = $dbid;
        header("location:admin.php");
        exit;
    } else {
        header("location:login.php?pesan=gagal");
        exit;
    }
}
?>