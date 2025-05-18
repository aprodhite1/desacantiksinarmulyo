<?php
session_start();
include 'koneksi.php';
$uname = $_SESSION['uname'] ?? '';
$level = $_SESSION['level'] ?? '';
$nama = $_SESSION['nama_desa1'] ?? '';
$kode = $_SESSION['kode_desa'] ?? '';
$namakec = $_SESSION['nama_kec1'] ?? '';
$kodekec = $_SESSION['kode_kec'] ?? '';
$id = $_SESSION['id'] ?? '';
$tahun = isset($_GET['tahun']) ? intval($_GET['tahun']) : date('Y');
?>


<!DOCTYPE html>
<html>

<head>
    <title>Entri Data Desa</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/entri-desa.css">

</head>



<body>
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
            <h3>V-DESCAN</h3>
        </div>
    </div>
    <div class="judul">
        <h3 style="text-align:center">PENDATAAN POTENSI TINGKAT DESA TAHUN <?php echo $tahun; ?></h3>
    </div>
    <form method="POST"
        action="action-desa.php?tahun=<?php echo isset($_GET['tahun']) ? htmlspecialchars($_GET['tahun']) : date('Y'); ?>">
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
                <td style="border-left:none">: <?php echo $namakec ?></td>
                <td style="text-align:right"><?php echo $kodekec?></td>
            </tr>
            <tr>
                <td width="30px" style="text-align:center">104.</td>
                <td style="border-right:none" width="300px">Desa/Kelurahan</td>
                <td style="border-left:none">: <?php echo $nama?></td>
                <td style="text-align:right"><?php echo $kode?></td>
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
                <td style="border-left:none">: <input type="text" name="r201"></input></td>
                <td rowspan="4" style="text-align:center">
                    Nama Lengkap : <br>
                    <input type="text" name="namapengesah" style="width:200px"></input><br><br>
                    Nomor Handphone : <br>
                    <input type="text" name="nohppengesah" style="width:200px"></input><br>
                </td>
            </tr>
            <tr>
                <td width="30px" style="text-align:center">202.</td>
                <td style="border-right:none" width="300px">Kode Agen Statistik</td>
                <td style="border-left:none">: <input type="text" name="r202"></input></td>
            </tr>
            <tr>
                <td width="30px" style="text-align:center">203.</td>
                <td style="border-right:none" width="300px">Tanggal/Bulan/Tahun Pelaksanaan</td>
                <td style="border-left:none">: <input type="date" name="r203"></input></td>
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
                <td style="border-right:none" width="300px" colspan="6">Luas Wilayah:</td>
                <td style="border-left:none" width="150px"><input type="number" style="width:150px" name="r301" require
                        min="0"></input>
                </td>
            </tr>

            <tr>
                <td width="30px" style="text-align:center" rowspan="5">302.</td>
                <td style="border-right:none" width="300px" colspan="6">Letak Geografis:</td>
            </tr>
            <tr>
                <td style="border-left:none;border-right:none" width="100px">a. Batas Utara </td>

                <td style="border-left:none;border-right:none"><input type="text" style="width:150px"
                        name="r302a"></input>
                </td>
            </tr>
            <tr>
                <td style="border-left:none;border-right:none" width="100px">b. Batas Selatan </td>
                <td style="border-left:none;border-right:none"><input type="text" style="width:150px"
                        name="r302b"></input>
                </td>
            </tr>
            <tr>
                <td style="border-left:none;border-right:none" width="200px">c. Batas Barat </td>
                <td style="border-left:none;border-right:none"><input type="text" style="width:150px"
                        name="r302c"></input>
                </td>
            </tr>
            <tr>
                <td style="border-left:none;border-right:none" width="200px">d. Batas Timur </td>
                <td style="border-left:none;border-right:none"><input type="text" style="width:150px"
                        name="r302d"></input>
                </td>
            </tr>
        </table>

        <table cellpadding="7" width="1330px">
            <tr>
                <th colspan="8">BLOK IV: PENDIDIKAN </th>
            </tr>
            <tr>
                <td width="30px" style="text-align:center" rowspan="5">401.</td>
                <td style="border:none" width="300px" colspan="4">Jumlah sarana pendidikan menurut jenjang pendidikan
                    di Desa:
                </td>
            </tr>
            <tr>
                <td style="border:none" width="500px">a. PAUD/TK/RA/BA</td>
                <td style="border:none" width="150px"><input type="number" style="width:50px" name="r401a" require
                        min="0"></input></td>
                <td style="border:none" width="500px">e.Akademi/Perguruan Tinggi </td>
                <td style="border:none" width="150px"><input type="number" style="width:50px" name="r401e" require
                        min="0"></input></td>
            </tr>
            <tr>
                <td style="border:none" width="500px">b. SD/MI</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r401b"></input></td>
                <td style="border:none" width="500px">f. SDLB/SMPLB/SMALB</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r401f"></input></td>
            </tr>
            <tr>
                <td style="border:none" width="500px">c. SMP/MTs</td>
                <td style="border:none" width="150px"><input type="number" style="width:50px" name="r401c" require
                        min="0"></input></td>
                <td style="border:none" width="500px">g. Pondok Pesantren</td>
                <td style="border:none" width="150px"><input type="number" style="width:50px" name="r401g" require
                        min="0"></input></td>
            </tr>
            <tr>
                <td style="border:none" width="500px">d. SMA/MA/SMK</td>
                <td style="border:none" width="150px"><input type="number" require min="0" style="width:50px"
                        name="r401d"></input></td>
                <td style="border:none" width="500px">h. Madrasah Diniyah</td>
                <td style="border:none" width="150px"><input type="number" require min="0" style="width:50px"
                        name="r401h"></input></td>
            </tr>

            <tr>
                <td width="30px" style="text-align:center" rowspan="5">402.</td>
                <td style="border:none" width="300px" colspan="4">Jumlah guru menurut jenjang pendidikan di Desa:
                </td>
            </tr>
            <tr>
                <td style="border:none" width="500px">a. PAUD/TK/RA/BA</td>
                <td style="border:none" width="150px"><input type="number" require min="0" style="width:50px"
                        name="r402a"></input></td>
                <td style="border:none" width="500px">e.Akademi/Perguruan Tinggi </td>
                <td style="border:none" width="150px"><input type="number" require min="0" style="width:50px"
                        name="r402e"></input></td>
            </tr>
            <tr>
                <td style="border:none" width="500px">b. SD/MI</td>
                <td style="border:none" width="150px"><input type="number" require min="0" style="width:50px"
                        name="r402b"></input></td>
                <td style="border:none" width="500px">f. SDLB/SMPLB/SMALB</td>
                <td style="border:none" width="150px"><input type="number" require min="0" style="width:50px"
                        name="r402f"></input></td>
            </tr>
            <tr>
                <td style="border:none" width="500px">c. SMP/MTs</td>
                <td style="border:none" width="150px"><input type="number" require min="0" style="width:50px"
                        name="r402c"></input></td>
                <td style="border:none" width="500px">g. Pondok Pesantren</td>
                <td style="border:none" width="150px"><input type="number" require min="0" style="width:50px"
                        name="r402g"></input></td>
            </tr>
            <tr>
                <td style="border:none" width="500px">d. SMA/MA/SMK</td>
                <td style="border:none" width="150px"><input type="number" require min="0" style="width:50px"
                        name="r402d"></input></td>
                <td style="border:none" width="500px">h. Madrasah Diniyah</td>
                <td style="border:none" width="150px"><input type="number" require min="0" style="width:50px"
                        name="r402h"></input></td>
            </tr>
            <tr>
                <td width="30px" style="text-align:center" rowspan="5">403.</td>
                <td style="border:none" width="300px" colspan="4">Jumlah Murid menurut jenjang pendidikan di Desa:
                </td>
            </tr>
            <tr>
                <td style="border:none" width="500px">a. PAUD/TK/RA/BA</td>
                <td style="border:none" width="150px"><input type="number" require min="0" style="width:50px"
                        name="r403a"></input></td>
                <td style="border:none" width="500px">e.Akademi/Perguruan Tinggi </td>
                <td style="border:none" width="150px"><input type="number" require min="0" style="width:50px"
                        name="r403e"></input></td>
            </tr>
            <tr>
                <td style="border:none" width="500px">b. SD/MI</td>
                <td style="border:none" width="150px"><input type="number" require min="0" style="width:50px"
                        name="r403b"></input></td>
                <td style="border:none" width="500px">f. SDLB/SMPLB/SMALB</td>
                <td style="border:none" width="150px"><input type="number" require min="0" style="width:50px"
                        name="r403f"></input></td>
            </tr>
            <tr>
                <td style="border:none" width="500px">c. SMP/MTs</td>
                <td style="border:none" width="150px"><input type="number" require min="0" style="width:50px"
                        name="r403c"></input></td>
                <td style="border:none" width="500px">g. Pondok Pesantren</td>
                <td style="border:none" width="150px"><input type="number" require min="0" style="width:50px"
                        name="r403g"></input></td>
            </tr>
            <tr>
                <td style="border:none" width="500px">d. SMA/MA/SMK</td>
                <td style="border:none" width="150px"><input type="number" require min="0" style="width:50px"
                        name="r403d"></input></td>
                <td style="border:none" width="500px">h. Madrasah Diniyah</td>
                <td style="border:none" width="150px"><input type="number" require min="0" style="width:50px"
                        name="r403h"></input></td>
            </tr>

            <tr>
                <th colspan="8">BLOK V: KESEHATAN</th>
            </tr>
            <tr>
                <td width="30px" style="text-align:center" rowspan="6">501.</td>
                <td style="border-bottom:none" width="300px" colspan="7">Jumlah sarana kesehatan di Desa:</td>
            </tr>
            <tr>
                <td style="border:none" width="500px">a. Rumah sakit</td>
                <td style="border:none" width="150px"><input type="number" require min="0" style="width:50px"
                        name="r501a"></input></td>
                <td style="border:none" width="500px">f. Rumah bersalin</td>
                <td style="border:none" width="150px"><input type="number" require min="0" style="width:50px"
                        name="r501f"></input></td>
            </tr>
            <tr>
                <td style="border:none" width="500px">b. Puskesmas</td>
                <td style="border:none" width="150px"><input type="number" require min="0" style="width:50px"
                        name="r501b"></input></td>
                <td style="border:none" width="500px">g. Tempat praktik bidan</td>
                <td style="border:none" width="150px"><input type="number" require min="0" style="width:50px"
                        name="r501g"></input></td>
            </tr>
            <tr>
                <td style="border:none" width="500px">c. Poliklinik/balai pengobatan</td>
                <td style="border:none" width="150px"><input type="number" require min="0" style="width:50px"
                        name="r501c"></input></td>
                <td style="border:none" width="500px">h. Poskesdes (Pos Kesehatan Desa)</td>
                <td style="border:none" width="150px"><input type="number" require min="0" style="width:50px"
                        name="r501h"></input></td>
            </tr>
            <tr>
                <td style="border:none" width="500px">d. Tempat praktik dokter</td>
                <td style="border:none" width="150px"><input type="number" require min="0" style="width:50px"
                        name="r501d"></input></td>
                <td style="border:none" width="500px">i. Puskesmas pembantu</td>
                <td style="border:none" width="150px"><input type="number" require min="0" style="width:50px"
                        name="r501i"></input></td>
            </tr>
            <tr>
                <td style="border:none" width="500px">e. Apotek</td>
                <td style="border:none" width="150px"><input type="number" require min="0" style="width:50px"
                        name="r501e"></input></td>
                <td style="border:none" width="500px">j. Toko khusus obat/jamu</td>
                <td style="border:none" width="150px"><input type="number" require min="0" style="width:50px"
                        name="r501j"></input></td>
            </tr>
            <tr>
                <td width="30px" style="text-align:center" rowspan="3">502.</td>
                <td style="border-bottom:none" width="300px" colspan="7">Kualitas Ibu Hamil</td>
            </tr>
            <tr>
                <td style="border:none" width="500px">a. Jumlah ibu hamil</td>
                <td style="border:none" width="150px"><input type="number" require min="0" style="width:50px"
                        name="r502a"></input></td>
                <td style="border:none" width="500px">c. Jumlah ibu hamil melahirkan</td>
                <td style="border:none" width="150px"><input type="number" require min="0" style="width:50px"
                        name="r502c"></input></td>
            </tr>
            <tr>
                <td style="border:none" width="500px">b. Jumlah kematian ibu hamil</td>
                <td style="border:none" width="150px"><input type="number" require min="0" style="width:50px"
                        name="r502b"></input></td>
            </tr>
            <tr>
            <tr>
                <td width="30px" style="text-align:center" rowspan="2">503.</td>
                <td style="border-bottom:none" width="300px" colspan="3">Kualitas bayi saat lahir</td>
            </tr>
            <tr>
                <td style="border:none" width="500px">a. lahir Hidup</td>
                <td style="border:none" width="150px"><input type="number" require min="0" style="width:50px"
                        name="r503a"></input></td>
                <td style="border:none" width="500px">b. Lahir Mati</td>
                <td style="border:none" width="150px"><input type="number" require min="0" style="width:50px"
                        name="r503b"></input></td>
            </tr>
            <tr>
                <td width="30px" style="text-align:center" rowspan="2">504.</td>
                <td style="border-bottom:none" width="300px" colspan="7">Jumlah penolong persalinan setahun terakhir
                </td>
            </tr>
            <tr>
                <td style="border:none" width="500px">a. Dokter</td>
                <td style="border:none" width="150px"><input type="number" require min="0" style="width:50px"
                        name="r504a"></input></td>
                <td style="border:none" width="500px">b. Bidan</td>
                <td style="border:none" width="150px"><input type="number" require min="0" style="width:50px"
                        name="r504b"></input></td>
            </tr>
            <tr>
                <td width="30px" style="text-align:center" rowspan="2">505.</td>
                <td style="border-bottom:none" width="300px" colspan="7">Cakupan Imunisasi</td>
            </tr>
            <tr>
                <td style="border:none" width="500px">a. Jumlah Balita</td>
                <td style="border:none" width="150px"><input type="number" require min="0" style="width:50px"
                        name="r505a"></input></td>
                <td style="border:none" width="500px">b. Jumlah balita penerima imunisasi</td>
                <td style="border:none" width="150px"><input type="number" require min="0" style="width:50px"
                        name="r505b"></input></td>
            </tr>
            <tr>
                <td width="30px" style="text-align:center" rowspan="2">506.</td>
                <td style="border-bottom:none" width="300px" colspan="7">Perkembangan pasangan usia subur dan keluarga
                    berencana</td>
            </tr>
            <tr>
                <td style="border:none" width="500px">a. Jumlah pasangan usia subur</td>
                <td style="border:none" width="150px"><input type="number" require min="0" style="width:50px"
                        name="r506a"></input></td>
                <td style="border:none" width="500px">b. Jumlah keluarga pengguna alat/metode KB</td>
                <td style="border:none" width="150px"><input type="number" require min="0" style="width:50px"
                        name="r506b"></input></td>
            </tr>
            <tr>
                <td width="30px" style="text-align:center">507.</td>
                <td style="border-right:none" width="300px" colspan="6">Jumlah Balita penderita gizi buruk:</td>
                <td style="border-left:none" width="150px"><input type="number" require min="0" style="width:50px"
                        name="r507"></input>
                </td>
            </tr>
            <tr>
                <td width="30px" style="text-align:center">508.</td>
                <td style="border-right:none" width="300px" colspan="6">Jumlah Penduduk yang terkena wabah penyakit:
                </td>
                <td style="border-left:none" width="150px"><input type="number" require min="0" style="width:50px"
                        name="r508"></input>
                </td>
            </tr>
            <tr>
                <td width="30px" style="text-align:center">509.</td>
                <td style="border-right:none" width="300px" colspan="6">Jumlah Penduduk yang pernah mengalami keluhan
                    kesehatan:</td>
                <td style="border-left:none" width="150px"><input type="number" require min="0" style="width:50px"
                        name="r509"></input>
                </td>
            </tr>
            <tr>
                <td width="30px" style="text-align:center">510.</td>
                <td style="border-right:none" width="300px" colspan="6">Jumlah Penduduk yang memiliki jaminan kesehatan:
                </td>
                <td style="border-left:none" width="150px"><input type="number" require min="0" style="width:50px"
                        name="r510"></input>
                </td>
            </tr>
        </table>

        <table cellpadding="5" width="1330px">
            <tr>
                <th colspan="7">BLOK VI: POLITIK DAN KEMASYARAKATAN</th>
            </tr>
            <tr>
                <td width="30px" style="text-align:center">601.</td>
                <td style="border-right:none" width="300px" colspan="5">Apakah Kepala Desa dipilih langsung oleh
                    masyarakat desa?</td>
                <td style="border-left:none" width="150px">
                    <select name="r601" style="width:80px">
                        <option value="">-- Pilih --</option>
                        <option value="Iya">Iya</option>
                        <option value="Tidak">Tidak</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td width="30px" style="text-align:center">602.</td>
                <td style="border-right:none" width="300px" colspan="5">Apakah terdapat kepengurusan Lembaga
                    Kemasyarakatan Desa (LKD)?</td>
                <td style="border-left:none" width="150px">
                    <select name="r602" style="width:80px">
                        <option value="">-- Pilih --</option>
                        <option value="Iya">Iya</option>
                        <option value="Tidak">Tidak</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td width="30px" style="text-align:center">603.</td>
                <td style="border-right:none" width="300px" colspan="4"> Jumlah perangkat Badan Permusyawaratan Desa
                    (BPD):
                </td>
                <td style="border-left:none" width="150px"><input type="number" require min="0" style="width:50px"
                        name="r603"></input>
                </td>
            </tr>
        </table>

        <table cellpadding="5" width="1330px">
            <tr>
                <th colspan="7">BLOK VII: PEMERINTAHAN</th>
            </tr>
            <tr>
                <td width="30px" style="text-align:center" rowspan="3">701.</td>
                <td style="border-bottom:none" width="300px" colspan="5">Jumlah perangkat desa:</td>
            </tr>
            <tr>
                <td style="border:none" width="500px">a. Sekretaris Desa</td>
                <td style="border:none" width="150px"><input type="number" require min="0" style="width:50px"
                        name="r701a"></input></td>
                <td style="border:none" width="500px">c. Kaur</td>
                <td style="border:none" width="150px"><input type="number" require min="0" style="width:50px"
                        name="r701c"></input></td>
            </tr>
            <tr>
                <td style="border:none" width="500px">b. Kasi</td>
                <td style="border:none" width="150px"><input type="number" require min="0" style="width:50px"
                        name="r701b"></input></td>
                <td style="border:none" width="500px">d. Kadus</td>
                <td style="border:none" width="150px"><input type="number" require min="0" style="width:50px"
                        name="r701d"></input></td>
            </tr>
            <tr>
                <td width="30px" style="text-align:center">702.</td>
                <td style="border-right:none" width="300px" colspan="5"> Jumlah Dusun/Lingkungan:</td>
                <td style="border-left:none" width="150px"><input type="number" style="width:50px" name="r702"></input>
                </td>
            </tr>
            <tr>
                <td width="30px" style="text-align:center">703.</td>
                <td style="border-right:none" width="300px" colspan="5"> Jumlah Dana APBD tahun 2025:</td>
                <td style="border-left:none" width="150px"><input type="number" require min="0" style="width:150px"
                        name="r703"></input>
                </td>
            </tr>
            <tr>
                <td width="30px" style="text-align:center">704.</td>
                <td style="border-right:none" width="300px" colspan="5">Apakah ada Laporan Pertanggungjawaban?</td>
                <td style="border-left:none" width="150px">
                    <select name="r704" style="width:80px">
                        <option value="">-- Pilih --</option>
                        <option value="Iya">Iya</option>
                        <option value="Tidak">Tidak</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td width="30px" style="text-align:center">705.</td>
                <td style="border-right:none" width="300px" colspan="5">Apakah ada pembinaan dan pengawasan pengelolaan
                    desa?</td>
                <td style="border-left:none" width="150px">
                    <select name="r705" style="width:80px">
                        <option value="">-- Pilih --</option>
                        <option value="Iya">Iya</option>
                        <option value="Tidak">Tidak</option>
                    </select>
                </td>
            </tr>
        </table>

        <table cellpadding="5" width="1330px">
            <tr>
                <th colspan="8">BLOK VIII: EKONOMI</th>
            </tr>
            <tr>
                <td width="30px" style="text-align:center">801.</td>
                <td style="border-right:none" width="300px" colspan="5">Apakah ada transportasi umum di desa (ojek,
                    taksi, dll)</td>
                <td style="border-left:none" width="150px">
                    <select name="r801" style="width:80px">
                        <option value="">-- Pilih --</option>
                        <option value="Iya">Iya</option>
                        <option value="Tidak">Tidak</option>
                    </select>
                </td>
            </tr>

            <tr>
                <td width="30px" style="text-align:center">802.</td>
                <td style="border-right:none" width="300px" colspan="5"> Jumlah penduduk yang memiliki aset sarana
                    produksi (pabrik, traktor, mesin pengolahan, dll):</td>
                <td style="border-left:none" width="150px"><input type="number" require min="0" style="width:50px"
                        name="r802"></input>
                </td>
            </tr>

        </table>

        <table cellpadding="5" width="1330px">
            <tr>
                <th>BLOK IX: CATATAN</th>
            </tr>
            <tr>
                <td height="200px"><textarea style="width:1300px; height:180px;" name="catatan"></textarea></td>
                </td>
            <tr>
                <br>
        </table>

        <input type="hidden" name="tahun"
            value="<?php echo isset($_GET['tahun']) ? htmlspecialchars($_GET['tahun']) : $tahun; ?>">
        <button type="submit" name="btn" id="submitBtn">Save</button>

        <script>
        document.getElementById('submitBtn').addEventListener('click', function(e) {
            // Add any client-side validation here
            if (!validateForm()) {
                e.preventDefault();
                return false;
            }
            return confirm('Apakah Anda yakin data sudah benar?');
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
            // Example validation - require village head election answer
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

</body>


</html>