<?php
session_start();
include 'koneksi.php';
$uname = $_SESSION['uname'];
$level = $_SESSION['level'];
$nama = $_SESSION['nama_desa1'];
$kode = $_SESSION['kode_desa'];
$namakec = $_SESSION['nama_kec1'];
$kodekec = $_SESSION['kode_kec'];
$id=$_SESSION['id'];
?>
<style>
button:hover {
    opacity: 0.8;
    background-color: lightslategray;
    color: black;
    font-weight: 600;
    font-size: medium;
    ;
}

button {
    width: 100px;
}
</style>
<!DOCTYPE html>
<html>

<head>
    <title>Entri Data Desa</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="kop">
        <div class="kotak1">
            <div class="logo1"><img src="images/logo-descan.png" height="50px" /></div>
        </div>
        <div class="kotak2">
            <div class="logo2"><img src="images/logo-bps.png" height="50px" /></div>
            <pre>
                PEMERINTAH KABUPATEN OGAN KOMERING ULU SELATAN
                DAN
                BADAN PUSAT STATISTIK KABUPATEN OGAN KOMERING ULU SELATAN
            </pre>
            <div class="logo3"><img src="images/logo-okus.png" height="50px" /></div>
        </div>
        <div class="kotak3">
            <h3>V-DESCAN25</h3>
        </div>
    </div>
    <div class="judul">
        <h3 style="text-align:center">PENDATAAN POTENSI TINGKAT DUSUN/LINGKUNGAN/RT/RW </h3>
    </div>
    <form method="POST"
        action="action.php?tahun=<?php echo isset($_GET['tahun']) ? htmlspecialchars($_GET['tahun']) : date('Y'); ?>">
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
            <tr>
                <td width="30px" style="text-align:center">105.</td>
                <td style="border-right:none" width="300px">Dusun/Lingkungan/RT/RW</td>
                <td style="border-left:none">:
                    <select name="r105" id="namasls"
                        style="width: 200px; padding: 6px; border: 1px solid #d2b356; border-radius: 4px;">
                        <option value="">--Pilih dusun--</option>
                        <option value="Dusun 1">Dusun 1</option>
                        <option value="Dusun 2">Dusun 2</option>
                        <option value="Dusun 3">Dusun 3</option>
                        <option value="Dusun 4">Dusun 4</option>
                    </select>
                </td>
                <td style="text-align:right">
                    <select name="r105a" id="kodesls"
                        style="width: 200px; padding: 6px; border: 1px solid #d2b356; border-radius: 4px;">
                        <option value="">--Pilih SLS--</option>
                        <option value="000100">001</option>
                        <option value="000200">002</option>
                        <option value="000300">003</option>
                        <option value="000400">004</option>
                    </select>
                </td>

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
                <td style="border-right:none" width="300px">Jumlah Penduduk dan Keluarga:</td>
                <td style="border-left:none;border-right:none" width="100px">a. Laki-laki </td>
                <td style="border-left:none;border-right:none"><input type="text" style="width:50px"
                        name="r301a"></input></td>
                <td style="border-left:none;border-right:none" width="100px">b. Perempuan </td>
                <td style="border-left:none;border-right:none"><input type="text" style="width:50px"
                        name="r301b"></input></td>
                <td style="border-left:none;border-right:none" width="200px">c. Keluarga </td>
                <td style="border-left:none;border-right:none"><input type="text" style="width:50px"
                        name="r301c"></input></td>
            </tr>

            <tr>
                <td width="30px" style="text-align:center" rowspan="5">302.</td>
                <td style="border:none" width="300px" colspan="7">Jumlah Penduduk Berdasarkan Pekerjaan:
                </td>
            </tr>
            <tr>
                <td style="border:none" width="500px">a. ASN(PNS/PPPK)</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r302a"></input></td>
                <td style="border:none" width="500px">e. Petani/Peternak</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r302e"></input></td>
                <td style="border:none" width="500px">i. Pedagang</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r302i"></input></td>
            </tr>
            <tr>
                <td style="border:none" width="500px">b. TNI/POLRI</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r302b"></input></td>
                <td style="border:none" width="500px">f. Pensiunan</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r302f"></input></td>
                <td style="border:none" width="500px">j. Pegawai Swasta</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r302j"></input></td>
            </tr>
            <tr>
                <td style="border:none" width="500px">c. Wiraswasta</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r302c"></input></td>
                <td style="border:none" width="500px">g. Buruh</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r302g"></input></td>
                <td style="border:none" width="500px">k. Dosen</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r302k"></input></td>
            </tr>
            <tr>
                <td style="border:none" width="500px">d. Paramedis</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r302d"></input></td>
                <td style="border:none" width="500px">h. Nelayan</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r302h"></input></td>
                <td style="border:none" width="500px">l. Lainnya</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r302l"></input></td>
            </tr>
            <tr>
                <td width="30px" style="text-align:center">303.</td>
                <td style="border-right:none" width="300px" colspan="6">Jumlah Pengangguran:</td>
                <td style="border-left:none" width="150px"><input type="text" style="width:50px" name="r303"></input>
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
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r401a"></input></td>
                <td style="border:none" width="500px">e.Akademi/Diploma </td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r401e"></input></td>
            </tr>
            <tr>
                <td style="border:none" width="500px">b. SD/MI</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r401b"></input></td>
                <td style="border:none" width="500px">f. Pasca Sarjana</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r401f"></input></td>
            </tr>
            <tr>
                <td style="border:none" width="500px">c. SMP/MTs</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r401c"></input></td>
                <td style="border:none" width="500px">g. Sarjana</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r401g"></input></td>
            </tr>
            <tr>
                <td style="border:none" width="500px">d. SMA/MA/SMK</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r401d"></input></td>

            </tr>
            <tr>
                <td width="30px" style="text-align:center">402.</td>
                <td style="border-right:none" width="300px" colspan="6">Jumlah Penduduk Putus Sekolah:</td>
                <td style="border-left:none" width="150px"><input type="text" style="width:50px" name="r402"></input>
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
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r501a"></input></td>
                <td style="border:none" width="500px">g. Mata Air Terlindungi</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r501g"></input></td>
            </tr>
            <tr>
                <td style="border:none" width="500px">b. Air isi ulang</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r501b"></input></td>
                <td style="border:none" width="500px">h. Mata Air Tak Terlindungi</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r501h"></input></td>
            </tr>
            <tr>
                <td style="border:none" width="500px">c. Leding</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r501c"></input></td>
                <td style="border:none" width="500px">i. Air Permukaan(sungai/danau/waduk)</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r501i"></input></td>
            </tr>
            <tr>
                <td style="border:none" width="500px">d. Sumur Bor/Pompa</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r501d"></input></td>
                <td style="border:none" width="500px">j. Air Hujan</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r501j"></input></td>
            </tr>
            <tr>
                <td style="border:none" width="500px">e. Sumur Terlindungi</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r501e"></input></td>
                <td style="border:none" width="500px">k. lainnya</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r501k"></input></td>
            </tr>
            <tr>
                <td style="border:none" width="500px">f. Sumur tak terlindungi</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r501f"></input></td>

            </tr>

            <tr>
                <td width="30px" style="text-align:center" rowspan="3">502.</td>
                <td style="border-bottom:none" width="300px" colspan="7">Jumlah Tenaga kesehatan yang menetap di
                    Dusun/lingkungan:</td>
            </tr>
            <tr>
                <td style="border:none" width="500px">a. Dokter Umum/Spesialis</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r502a"></input></td>
                <td style="border:none" width="500px">c. Bidan</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r502c"></input></td>
            </tr>
            <tr>
                <td style="border:none" width="500px">b. Dokter Spesialis gigi</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r502b"></input></td>
                <td style="border:none" width="500px">d. Tenaga Kesehatan lainnya</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r502d"></input></td>
            </tr>
            <tr>
                <td width="30px" style="text-align:center">503.</td>
                <td style="border-right:none" width="300px" colspan="6">Jumlah Dukun bayi/Dukun Bersalin yang tinggal di
                    Dusun/Lingkungan:</td>
                <td style="border-left:none" width="150px"><input type="text" style="width:50px" name="r503"></input>
                </td>
            </tr>
            <tr>
                <td width="30px" style="text-align:center">504.</td>
                <td style="border-right:none" width="300px" colspan="6">Jumlah Balita penderita gizi buruk:</td>
                <td style="border-left:none" width="150px"><input type="text" style="width:50px" name="r504"></input>
                </td>
            </tr>
            <tr>
                <td width="30px" style="text-align:center">505.</td>
                <td style="border-right:none" width="300px" colspan="6">Jumlah Penduduk Stunting:</td>
                <td style="border-left:none" width="150px"><input type="text" style="width:50px" name="r505"></input>
                </td>
            </tr>
            <tr>
                <td width="30px" style="text-align:center">506.</td>
                <td style="border-right:none" width="300px" colspan="6">Jumlah Penduduk yang terkena wabah penyakit:
                </td>
                <td style="border-left:none" width="150px"><input type="text" style="width:50px" name="r506"></input>
                </td>
            </tr>
            <tr>
                <td width="30px" style="text-align:center">507.</td>
                <td style="border-right:none" width="300px" colspan="6">Jumlah Penduduk yang pernah mengalami keluhan
                    kesehatan:</td>
                <td style="border-left:none" width="150px"><input type="text" style="width:50px" name="r507"></input>
                </td>
            </tr>
            <tr>
                <td width="30px" style="text-align:center">508.</td>
                <td style="border-right:none" width="300px" colspan="6">Jumlah Penduduk yang memiliki jaminan kesehatan:
                </td>
                <td style="border-left:none" width="150px"><input type="text" style="width:50px" name="r508"></input>
                </td>
            </tr>
            <tr>
                <td width="30px" style="text-align:center">509.</td>
                <td style="border-right:none" width="300px" colspan="6">Jumlah keluarga dengan anggota keluarga perokok:
                </td>
                <td style="border-left:none" width="150px"><input type="text" style="width:50px" name="r509"></input>
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
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r601a"></input></td>
                <td style="border:none" width="500px">e. Pura</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r601e"></input></td>
            </tr>
            <tr>
                <td style="border:none" width="500px">b. Surau/Langgar/Mushola</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r601b"></input></td>
                <td style="border:none" width="500px">f. Wihara</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r601f"></input></td>
            </tr>
            <tr>
                <td style="border:none" width="500px">c. Gereja kristen</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r601c"></input></td>
                <td style="border:none" width="500px">g. kelenteng</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r601g"></input></td>
            </tr>
            <tr>
                <td style="border:none" width="500px">d. Gereja katolik</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r601d"></input></td>
                <td style="border:none" width="500px">h. lainnya</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r601h"></input></td>
            </tr>

            <tr>
                <td width="30px" style="text-align:center" rowspan="6">602.</td>
                <td style="border-bottom:none" width="300px" colspan="7">Jumlah Penduduk penyandang disabilitas di
                    Dusun/lingkungan:</td>
            </tr>
            <tr>
                <td style="border:none" width="500px">a. Tuna netra</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r602a"></input></td>
                <td style="border:none" width="500px">f. Tuna grahita (Mental)</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r602f"></input></td>
            </tr>
            <tr>
                <td style="border:none" width="500px">b. Tuna rungu (Tuli)</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r602b"></input></td>
                <td style="border:none" width="500px">g. Tuna Laras</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r602g"></input></td>
            </tr>
            <tr>
                <td style="border:none" width="500px">c. Tuna Wicara (bisu)</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r602c"></input></td>
                <td style="border:none" width="500px">h. Tuna eks-sakit kusta</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r602h"></input></td>
            </tr>
            <tr>
                <td style="border:none" width="500px">d. Tuna rungu-wicara (tuli-bisu)</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r602d"></input></td>
                <td style="border:none" width="500px">i. Tuna Ganda (fisik-mental)</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r602i"></input></td>
            </tr>
            <tr>
                <td style="border:none" width="500px">e. Tuna Daksa (disabilitas tubuh)</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r602e"></input></td>

            </tr>
            <tr>
                <td width="30px" style="text-align:center">603.</td>
                <td style="border-right:none" width="300px" colspan="5">Jumlah Keluarga penerima bantuan:</td>
                <td style="border-left:none" width="150px"><input type="text" style="width:50px" name="r603"></input>
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
                    <select style="width:100px" name="r701">
                        <option value="yes">Yes</option>
                        <option value="no">No</option>
                    </select>
                </td>
            </tr>

            <tr>
                <td width="30px" style="text-align:center">702.</td>
                <td style="border-right:none" width="300px" colspan="5"> Jumlah Kriminalitas di Dusun/Lingkungan:</td>
                <td style="border-left:none" width="150px"><input type="text" style="width:50px" name="r702"></input>
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
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r801a"></input></td>
                <td style="border:none" width="500px">g. Futsal</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r801g"></input></td>
            </tr>
            <tr>
                <td style="border:none" width="500px">b. Bola Voli</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r801b"></input></td>
                <td style="border:none" width="500px">h. Renang</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r801h"></input></td>
            </tr>
            <tr>
                <td style="border:none" width="500px">c. Bulutangkis</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r801c"></input></td>
                <td style="border:none" width="500px">i. Beladiri (Pencak silat, Karate, dll)</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r801i"></input></td>
            </tr>
            <tr>
                <td style="border:none" width="500px">d. Bola Basket</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r801d"></input></td>
                <td style="border:none" width="500px">j. billiard</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r801j"></input></td>
            </tr>
            <tr>
                <td style="border:none" width="500px">e. Tenis Lapangan</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r801e"></input></td>
                <td style="border:none" width="500px">k. Fitnes, aerobik, dll</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r801k"></input></td>
            </tr>
            <tr>
                <td style="border:none" width="500px">f. Tenis Meja</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r801f"></input></td>
                <td style="border:none" width="500px">l. lainnya</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r801l"></input></td>
            </tr>
            <tr>
                <td width="30px" style="text-align:center">802.</td>
                <td style="border-right:none" width="300px" colspan="3"> Jumlah Pub/diskotek/tempat karaoke yang masih
                    aktif di Dusun/Lingkungan:</td>
                <td style="border-left:none" width="150px"><input type="text" style="width:50px" name="r802"></input>
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
                <td style="border-left:none" width="150px"><input type="text" style="width:50px" name="r901"></input>
                </td>
            </tr>
            <tr>
                <td width="30px" style="text-align:center">902.</td>
                <td style="border-right:none" width="300px" colspan="4"> Jumlah Keluarga yang memiliki sertifikat Rumah:
                </td>
                <td style="border-left:none" width="150px"><input type="text" style="width:50px" name="r902"></input>
                </td>
            </tr>
            <tr>
                <td width="30px" style="text-align:center">903.</td>
                <td style="border-right:none" width="300px" colspan="4"> Jumlah Pangkalan/agen/penjual minyak tanah:
                </td>
                <td style="border-left:none" width="150px"><input type="text" style="width:50px" name="r903"></input>
                </td>
            </tr>
            <tr>
                <td width="30px" style="text-align:center">904.</td>
                <td style="border-right:none" width="300px" colspan="4"> Jumlah Pangkalan/agen/penjual LPG:</td>
                <td style="border-left:none" width="150px"><input type="text" style="width:50px" name="r904"></input>
                </td>
            </tr>
            <tr>
                <td width="30px" style="text-align:center" rowspan="3">905.</td>
                <td style="border-bottom:none" width="300px" colspan="8">Jumlah Sarana lembaga keuangan yang beroperasi
                    di Dusun/Lingkungan:</td>
            </tr>
            <tr>
                <td style="border:none" width="500px">a. Bank Umum Pemerintah</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r905a"></input></td>
                <td style="border:none" width="500px">c. Bank Perkreditan rakyat</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r905c"></input></td>
            </tr>
            <tr>
                <td style="border:none" width="500px">b. Bank Umum Swasta</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r905b"></input></td>
            </tr>
            <tr>
                <td width="30px" style="text-align:center" rowspan="3">906.</td>
                <td style="border-bottom:none" width="300px" colspan="8">Jumlah Koperasi di Dusun/Lingkungan:</td>
            </tr>
            <tr>
                <td style="border:none" width="500px">a. Koperasi Unit Desa (KUD)</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r906a"></input></td>
                <td style="border:none" width="500px">c. Koperasi Simpan Pinjam (Kospin)</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r906c"></input></td>
            </tr>
            <tr>
                <td style="border:none" width="500px">b. Koperasi Industri Kecil & Kopinkra</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r906b"></input></td>
                <td style="border:none" width="500px">d. Koperasi lainnya</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r906d"></input></td>
            </tr>

            <tr>
                <td width="30px" style="text-align:center" rowspan="6">907.</td>
                <td style="border-bottom:none" width="300px" colspan="8">Jumlah sarana dan prasarana ekonomi di
                    Dusun/lingkungan:</td>
            </tr>
            <tr>
                <td style="border:none" width="500px">a. Kelompok Pertokoan</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r907a"></input></td>
                <td style="border:none" width="500px">f. Restoran/rumah makan</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r907f"></input></td>
            </tr>
            <tr>
                <td style="border:none" width="500px">b. Pasar dengan bangunan permanen</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r907b"></input></td>
                <td style="border:none" width="500px">g. Warung/kedai makanan minuman</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r907g"></input></td>
            </tr>
            <tr>
                <td style="border:none" width="500px">c. Pasar dengan bangunan semi permanen</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r907c"></input></td>
                <td style="border:none" width="500px">h. Hotel</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r907h"></input></td>
            </tr>
            <tr>
                <td style="border:none" width="500px">d. Pasar tanpa bangunan </td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r907d"></input></td>
                <td style="border:none" width="500px">i. Penginapan</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r907i"></input></td>
            </tr>
            <tr>
                <td style="border:none" width="500px">e. Minimarket/Swalayan/supermarket</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r907e"></input></td>
                <td style="border:none" width="500px">j. Toko/warung kelontong</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r907j"></input></td>
            </tr>
            <tr>
                <td width="30px" style="text-align:center" rowspan="4">908.</td>
                <td style="border-bottom:none" width="300px" colspan="8">Jumlah sarana penunjang ekonomi di
                    Dusun/Lingkungan:</td>
            </tr>
            <tr>
                <td style="border:none" width="500px">a. Baitul Maal Wa Tamwil (BMT)</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r908a"></input></td>
                <td style="border:none" width="500px">d. Bengkel Mobil/Motor</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r908d"></input></td>
            </tr>
            <tr>
                <td style="border:none" width="500px">b. Pengadaian</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r908b"></input></td>
                <td style="border:none" width="500px">e. Salon kecantikan</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r908e"></input></td>
            </tr>
            <tr>
                <td style="border:none" width="500px">c. Anjungan Tunai Mandiri (ATM)</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r908c"></input></td>
                <td style="border:none" width="500px">f. Agen tiket/travel/biro perjalanan</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r908f"></input></td>
            </tr>


        </table>
        <br>
        <table cellpadding="5" width="1330px">
            <tr>
                <th>BLOK X: CATATAN</th>
            </tr>
            <tr>
                <td height="200px"><textarea style="width:1300px; height:180px;" name="catatan"></textarea></td>
                </td>
            <tr>
                <br>
        </table>
        <br>
        <input type="hidden" name="tahun"
            value="<?php echo isset($_GET['tahun']) ? htmlspecialchars($_GET['tahun']) : $tahun; ?>">
        <button type="submit" name="btn" onclick="alert('Data Berhasil Disimpan')">Save</button>
    </form>

</body>


</html>