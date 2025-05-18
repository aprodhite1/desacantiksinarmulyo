<?php
session_start();
include 'koneksi.php';

// Validate session variables
$uname = isset($_SESSION['uname']) ? $_SESSION['uname'] : '';
$level = isset($_SESSION['level']) ? $_SESSION['level'] : '';
$nama = isset($_SESSION['nama_desa1']) ? $_SESSION['nama_desa1'] : '';
$kode = isset($_SESSION['kode_desa']) ? $_SESSION['kode_desa'] : '';
$namakec = isset($_SESSION['nama_kec1']) ? $_SESSION['nama_kec1'] : '';
$kodekec = isset($_SESSION['kode_kec']) ? $_SESSION['kode_kec'] : '';
$id = isset($_SESSION['id']) ? $_SESSION['id'] : '';

// Validate and sanitize year input
$tahun = isset($_GET['tahun']) ? intval($_GET['tahun']) : date('Y');
if ($tahun < 2000 || $tahun> 2100) {
    $tahun = date('Y'); // Fallback to current year if invalid
    }

?>


<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Entri Data Desa - <?php echo htmlspecialchars($nama); ?></title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/entri-dusun.css">


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

        <form method="POST" action="action-dusun.php?tahun=<?php echo htmlspecialchars($tahun); ?>">

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
                            <option value="Dusun 1">Dusun 1</option>
                            <option value="Dusun 2">Dusun 2</option>
                            <option value="Dusun 3">Dusun 3</option>
                            <option value="Dusun 4">Dusun 4</option>
                            <option value="Dusun 5">Dusun 5</option>
                            <option value="Dusun 6">Dusun 6</option>
                        </select>
                    </td>
                    <td style="text-align:right">
                        <select name="r105a" id="kodesls" required>
                            <option value="">--Pilih kode Dusun--</option>
                            <option value="000100">001</option>
                            <option value="000200">002</option>
                            <option value="000300">003</option>
                            <option value="000400">004</option>
                            <option value="000500">005</option>
                            <option value="000600">006</option>
                        </select>
                    </td>
                </tr>
            </table>

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
                    <td style="border-left:none">: <input type="text" required name="r201" required></td>
                    <td rowspan="4" style="text-align:center">
                        Nama Lengkap : <br>
                        <input type="text" required name="namapengesah" required><br><br>
                        Nomor Handphone : <br>
                        <input type="text" required name="nohppengesah" required><br>
                    </td>
                </tr>
                <tr>
                    <td style="text-align:center">202.</td>
                    <td style="border-right:none">Kode Agen Statistik</td>
                    <td style="border-left:none">: <input type="text" required name="r202" required></td>
                </tr>
                <tr>
                    <td style="text-align:center">203.</td>
                    <td style="border-right:none">Tanggal/Bulan/Tahun Pelaksanaan</td>
                    <td style="border-left:none">: <input type="date" name="r203" required></td>
                </tr>
                <tr>
                    <td style="text-align:center">204.</td>
                    <td style="border-right:none">Nomor Handphone</td>
                    <td style="border-left:none">: <input type="text" required name="r204" required></td>
                </tr>
            </table>

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
                    <td><input type="number" style="width:50px" name="r301a" min="0" required></td>
                    <td>b. Perempuan</td>
                    <td><input type="number" style="width:50px" name="r301b" min="0" required></td>
                    <td>c. Keluarga</td>
                    <td><input type="number" style="width:50px" name="r301c" min="0" required></td>
                </tr>

                <tr>
                    <td width="30px" style="text-align:center" rowspan="5">302.</td>
                    <td style="border:none" width="300px" colspan="7">Jumlah Penduduk Berdasarkan Pekerjaan:
                    </td>
                </tr>
                <tr>
                    <td style="border:none" width="500px">a. ASN(PNS/PPPK)</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r302a"></input>
                    </td>
                    <td style="border:none" width="500px">e. Petani/Peternak</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r302e"></input>
                    </td>
                    <td style="border:none" width="500px">i. Pedagang</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r302i"></input>
                    </td>
                </tr>
                <tr>
                    <td style="border:none" width="500px">b. TNI/POLRI</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r302b"></input>
                    </td>
                    <td style="border:none" width="500px">f. Pensiunan</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r302f"></input>
                    </td>
                    <td style="border:none" width="500px">j. Pegawai Swasta</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r302j"></input>
                    </td>
                </tr>
                <tr>
                    <td style="border:none" width="500px">c. Wiraswasta</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r302c"></input>
                    </td>
                    <td style="border:none" width="500px">g. Buruh</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r302g"></input>
                    </td>
                    <td style="border:none" width="500px">k. Dosen</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r302k"></input>
                    </td>
                </tr>
                <tr>
                    <td style="border:none" width="500px">d. Paramedis</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r302d"></input>
                    </td>
                    <td style="border:none" width="500px">h. Nelayan</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r302h"></input>
                    </td>
                    <td style="border:none" width="500px">l. Lainnya</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r302l"></input>
                    </td>
                </tr>
                <tr>
                    <td width="30px" style="text-align:center" rowspan="3">303.</td>
                    <td style="border:none" width="300px" colspan="7">Jumlah Kepala Keluarga berdasarkan pendidikan
                        terakhir:
                    </td>
                </tr>
                <tr>
                    <td style="border:none" width="500px">a. ≤SD/Sederajat </td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r303a"></input>
                    </td>
                    <td style="border:none" width="500px">c. SMA/Sederajat </td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r303c"></input>
                    </td>
                </tr>
                <tr>
                    <td style="border:none" width="500px">b. SMP/Sederajat</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r303b"></input>
                    </td>
                    <td style="border:none" width="500px">d. >SMA/</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r303d"></input>
                    </td>
                </tr>

                <tr>
                    <td width="30px" style="text-align:center" rowspan="4">304.</td>
                    <td style="border:none" width="300px" colspan="7">Jumlah Penduduk Berdasarkan Agama
                    </td>
                </tr>
                <tr>
                    <td style="border:none" width="500px">a. Islam </td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r304a"></input>
                    </td>
                    <td style="border:none" width="500px">d. Hindu </td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r304d"></input>
                    </td>
                </tr>
                <tr>
                    <td style="border:none" width="500px">b. Kristen</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r304b"></input>
                    </td>
                    <td style="border:none" width="500px">e. Budha</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r304e"></input>
                    </td>
                </tr>
                <tr>
                    <td style="border:none" width="500px">c. Katolik</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r304c"></input>
                    </td>
                    <td style="border:none" width="500px">f. Kepercayaan lainnya</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r304f"></input>
                    </td>
                </tr>
                <tr>
                    <td width="30px" style="text-align:center" rowspan="3">305.</td>
                    <td style="border:none" width="300px" colspan="7">Jumlah Keluarga Menurut Penggunaan Listrik
                    </td>
                </tr>
                <tr>
                    <td style="border:none" width="500px">a. Listrik PLN </td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r305a"></input>
                    </td>
                    <td style="border:none" width="500px">c. Bukan Pengguna Listrik </td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r305c"></input>
                    </td>
                </tr>
                <tr>
                    <td style="border:none" width="500px">b. Listrik Non-PLN</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r305b"></input>
                    </td>
                </tr>
                <tr>
                    <td width="30px" style="text-align:center" rowspan="2">306.</td>
                    <td style="border:none" width="300px" colspan="8">Jumlah Keluarga Menurut Kelayakan Rumah
                    </td>
                </tr>
                <tr>
                    <td style="border:none" width="500px">a. Keluarga dengan Rumah Layak Huni</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r306a"></input>
                    </td>
                    <td style="border:none" width="500px">b. Keluarga dengan Rumah Tidak Layak Huni</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r306b"></input>
                    </td>
                </tr>
            </table>

            <table>
                <tr>
                    <th colspan="8">BLOK IV: PENDIDIKAN DAN KESEHATAN </th>
                </tr>
                <tr>
                    <td width="30px" style="text-align:center" rowspan="5">401.</td>
                    <td style="border:none" width="300px" colspan="7">Jumlah Sarana pendidikan
                    </td>
                </tr>
                <tr>
                    <td style="border:none" width="500px">a. PAUD/TK/RA</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r401a"></input>
                    </td>
                    <td style="border:none" width="500px">e.Pendidikan Akademi/Perguruan Tinggi </td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r401e"></input>
                    </td>
                </tr>
                <tr>
                    <td style="border:none" width="500px">b. SD/MI</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r401b"></input>
                    </td>
                    <td style="border:none" width="500px">f. SDLB/SMPLB/SMALB</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r401f"></input>
                    </td>
                </tr>
                <tr>
                    <td style="border:none" width="500px">c. SMP/MTs</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r401c"></input>
                    </td>
                    <td style="border:none" width="500px">g. Pondok Pesantren</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r401g"></input>
                    </td>
                </tr>
                <tr>
                    <td style="border:none" width="500px">d. SMA/MA/SMK</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r401d"></input>
                    </td>
                    <td style="border:none" width="500px">h. Madrasah Diniyah</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r401h"></input>
                    </td>

                </tr>
                <tr>
                    <td width="30px" style="text-align:center" rowspan="6">402.</td>
                    <td style="border:none" width="300px" colspan="7">Jumlah Sarana Kesehatan
                    </td>
                </tr>
                <tr>
                    <td style="border:none" width="500px">a. Puskemas</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r402a"></input>
                    </td>
                    <td style="border:none" width="500px">f.Tempat praktik bidan </td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r402f"></input>
                    </td>
                </tr>
                <tr>
                    <td style="border:none" width="500px">b. Poliklinik/Balai Pengobatan</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r402b"></input>
                    </td>
                    <td style="border:none" width="500px">g. Poskesdes</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r402g"></input>
                    </td>
                </tr>
                <tr>
                    <td style="border:none" width="500px">c. Tempat Praktik Dokter</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r402c"></input>
                    </td>
                    <td style="border:none" width="500px">h.Toko Khusus Obat/Jamu</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r402h"></input>
                    </td>
                </tr>
                <tr>
                    <td style="border:none" width="500px">d. Apotek</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r402d"></input>
                    </td>
                    <td style="border:none" width="500px">i. Posyandu</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r402i"></input>
                    </td>
                </tr>
                <tr>
                    <td style="border:none" width="500px">e. Rumah Bersalin</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r402e"></input>
                    </td>
                </tr>
                <tr>
                    <td width="30px" style="text-align:center" rowspan="4">403.</td>
                    <td style="border:none" width="300px" colspan="8">Jumlah Tenaga Kesehatan
                    </td>
                </tr>
                <tr>
                    <td style="border:none" width="500px">a. Dokter</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r403a"></input>
                    </td>
                    <td style="border:none" width="500px">d.Dukun Bayi </td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r403d"></input>
                    </td>
                </tr>
                <tr>
                    <td style="border:none" width="500px">b. Dokter Gigi</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r403b"></input>
                    </td>
                    <td style="border:none" width="500px">e. Lainnya</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r403e"></input>
                    </td>
                </tr>
                <tr>
                    <td style="border:none" width="500px">c. Bidan</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r403c"></input>
                    </td>
                </tr>
                <tr>
                    <td width="30px" style="text-align:center">404.</td>
                    <td style="border-right:none" width="300px" colspan="6">Jumlah Penduduk stunting:</td>
                    <td style="border-left:none" width="150px"><input type="number" required style="width:50px"
                            name="r404"></input>
                    </td>
                </tr>

                <tr>
                    <th colspan="8">BLOK V: TEMPAT IBADAH DAN PENYANDANG DISABILITAS</th>
                </tr>
                <tr>
                    <td width="30px" style="text-align:center" rowspan="5">501.</td>
                    <td style="border:none" width="300px" colspan="8">Jumlah Tempat Ibadah:
                    </td>
                </tr>
                <tr>
                    <td style="border:none" width="500px">a. Mesjid</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r501a"></input>
                    </td>
                    <td style="border:none" width="500px">e. Pura</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r501e"></input>
                    </td>
                </tr>
                <tr>
                    <td style="border:none" width="500px">b. Surau/Langgar/Mushola</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r501b"></input>
                    </td>
                    <td style="border:none" width="500px">f. Wihara</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r501f"></input>
                    </td>
                </tr>
                <tr>
                    <td style="border:none" width="500px">c. Gereja kristen</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r501c"></input>
                    </td>
                    <td style="border:none" width="500px">g. kelenteng</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r501g"></input>
                    </td>
                </tr>
                <tr>
                    <td style="border:none" width="500px">d. Gereja katolik</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r501d"></input>
                    </td>
                    <td style="border:none" width="500px">h. lainnya</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r501h"></input>
                    </td>
                </tr>
                <tr>
                    <td width="30px" style="text-align:center" rowspan="7">502.</td>
                    <td style="border-bottom:none" width="300px" colspan="8">Jumlah Penduduk penyandang disabilitas di
                        Dusun/lingkungan:</td>
                </tr>
                <tr>
                    <td style="border:none" width="500px">a. Tuna netra</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r502a"></input>
                    </td>
                    <td style="border:none" width="500px">f. Tuna grahita (Mental)</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r502f"></input>
                    </td>
                </tr>
                <tr>
                    <td style="border:none" width="500px">b. Tuna rungu (Tuli)</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r502b"></input>
                    </td>
                    <td style="border:none" width="500px">g. Tuna Laras</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r502g"></input>
                    </td>
                </tr>
                <tr>
                    <td style="border:none" width="500px">c. Tuna Wicara (bisu)</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r502c"></input>
                    </td>
                    <td style="border:none" width="500px">h. Tuna eks-sakit kusta</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r502h"></input>
                    </td>
                </tr>
                <tr>
                    <td style="border:none" width="500px">d. Tuna rungu-wicara (tuli-bisu)</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r502d"></input>
                    </td>
                    <td style="border:none" width="500px">i. Tuna Ganda (fisik-mental)</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r502i"></input>
                    </td>
                </tr>
                <tr>
                    <td style="border:none" width="500px">e. Tuna Daksa (disabilitas tubuh)</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r502e"></input>
                    </td>
                </tr>
                <tr></tr>
            </table>

            <table>
                <tr>
                    <th colspan="8">BLOK VI: OLAHRAGA DAN HIBURAN</th>
                </tr>
                <tr>
                    <td width="30px" style="text-align:center" rowspan="7">601.</td>
                    <td style="border-bottom:none" width="300px" colspan="7">Jumlah fasilitas/lapangan olahraga :</td>
                </tr>

                <tr>
                    <td style="border:none" width="500px">a. Sepakbola</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r601a"></input>
                    </td>
                    <td style="border:none" width="500px">g. Futsal</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r601g"></input>
                    </td>
                </tr>
                <tr>
                    <td style="border:none" width="500px">b. Bola Voli</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r601b"></input>
                    </td>
                    <td style="border:none" width="500px">h. Renang</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r601h"></input>
                    </td>
                </tr>
                <tr>
                    <td style="border:none" width="500px">c. Bulutangkis</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r601c"></input>
                    </td>
                    <td style="border:none" width="500px">i. Beladiri (Pencak silat, Karate, dll)</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r601i"></input>
                    </td>
                </tr>
                <tr>
                    <td style="border:none" width="500px">d. Bola Basket</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r601d"></input>
                    </td>
                    <td style="border:none" width="500px">j. billiard</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r601j"></input>
                    </td>
                </tr>
                <tr>
                    <td style="border:none" width="500px">e. Tenis Lapangan</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r601e"></input>
                    </td>
                    <td style="border:none" width="500px">k. Fitnes, aerobik, dll</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r601k"></input>
                    </td>
                </tr>
                <tr>
                    <td style="border:none" width="500px">f. Tenis Meja</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r601f"></input>
                    </td>
                    <td style="border:none" width="500px">l. lainnya</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r601l"></input>
                    </td>
                </tr>
                <tr>
                    <td width="30px" style="text-align:center">602.</td>
                    <td style="border-right:none" width="300px" colspan="3"> Jumlah Pub/diskotek/tempat karaoke yang
                        masih
                        aktif di Dusun/Lingkungan:</td>
                    <td style="border-left:none" width="150px"><input type="number" required style="width:50px"
                            name="r602"></input>
                    </td>
                </tr>
            </table>

            <table>
                <tr>
                    <th colspan="8">BLOK VII: EKONOMI</th>
                </tr>
                <tr>
                    <td width="30px" style="text-align:center">701.</td>
                    <td style="border-right:none" width="300px" colspan="4"> Jumlah Pangkalan/Agen/Penjual Minyak Tanah:
                    </td>
                    <td style="border-left:none" width="150px"><input type="number" required style="width:50px"
                            name="r701"></input>
                    </td>
                </tr>
                <tr>
                    <td width="30px" style="text-align:center">702.</td>
                    <td style="border-right:none" width="300px" colspan="4"> Jumlah Pangkalan/Agen/Penjual LPG:
                    </td>
                    <td style="border-left:none" width="150px"><input type="number" required style="width:50px"
                            name="r702"></input>
                    </td>
                </tr>

                <tr>
                    <td width="30px" style="text-align:center" rowspan="3">703.</td>
                    <td style="border-bottom:none" width="300px" colspan="8">Jumlah Sarana lembaga keuangan yang
                        beroperasi
                        di Dusun/Lingkungan:</td>
                </tr>
                <tr>
                    <td style="border:none" width="500px">a. Bank Umum Pemerintah</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r703a"></input>
                    </td>
                    <td style="border:none" width="500px">c. Bank Perkreditan rakyat</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r703c"></input>
                    </td>
                </tr>
                <tr>
                    <td style="border:none" width="500px">b. Bank Umum Swasta</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r703b"></input>
                    </td>
                </tr>
                <tr>
                    <td width="30px" style="text-align:center" rowspan="3">704.</td>
                    <td style="border-bottom:none" width="300px" colspan="8">Jumlah Koperasi di Dusun/Lingkungan:</td>
                </tr>
                <tr>
                    <td style="border:none" width="500px">a. Koperasi Unit Desa (KUD)</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r704a"></input>
                    </td>
                    <td style="border:none" width="500px">c. Koperasi Simpan Pinjam (Kospin)</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r704c"></input>
                    </td>
                </tr>
                <tr>
                    <td style="border:none" width="500px">b. Koperasi Industri Kecil & Kopinkra</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r704b"></input>
                    </td>
                    <td style="border:none" width="500px">d. Koperasi lainnya</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r704d"></input>
                    </td>
                </tr>

                <tr>
                    <td width="30px" style="text-align:center" rowspan="6">705.</td>
                    <td style="border-bottom:none" width="300px" colspan="8">Jumlah sarana dan prasarana ekonomi :</td>
                </tr>
                <tr>
                    <td style="border:none" width="500px">a. Kelompok Pertokoan</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r705a"></input>
                    </td>
                    <td style="border:none" width="500px">f. Restoran/rumah makan</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r705f"></input>
                    </td>
                </tr>
                <tr>
                    <td style="border:none" width="500px">b. Pasar dengan bangunan permanen</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r705b"></input>
                    </td>
                    <td style="border:none" width="500px">g. Warung/kedai makanan minuman</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r705g"></input>
                    </td>
                </tr>
                <tr>
                    <td style="border:none" width="500px">c. Pasar dengan bangunan semi permanen</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r705c"></input>
                    </td>
                    <td style="border:none" width="500px">h. Penginapan</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r705h"></input>
                    </td>
                </tr>
                <tr>
                    <td style="border:none" width="500px">d. Pasar tanpa bangunan </td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r705d"></input>
                    </td>
                    <td style="border:none" width="500px">i. Toko/warung kelontong</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r705i"></input>
                    </td>
                </tr>
                <tr>
                    <td style="border:none" width="500px">e. Minimarket/Swalayan/supermarket</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r705e"></input>
                    </td>
                    <td style="border:none" width="500px">j. Pertamina/Pertashop</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r705j"></input>
                    </td>
                </tr>
                <tr>
                    <td width="30px" style="text-align:center" rowspan="4">706.</td>
                    <td style="border-bottom:none" width="300px" colspan="8">Jumlah sarana penunjang ekonomi:</td>
                </tr>
                <tr>
                    <td style="border:none" width="500px">a. Pengadaian</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r706a"></input>
                    </td>
                    <td style="border:none" width="500px">d. Salon kecantikan</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r706d"></input>
                    </td>
                </tr>
                <tr>
                    <td style="border:none" width="500px">b. Anjungan Tunai Mandiri (ATM)</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r706b"></input>
                    </td>
                    <td style="border:none" width="500px">e. Agen tiket/travel/biro perjalanan</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r706e"></input>
                    </td>
                </tr>
                <tr>
                    <td style="border:none" width="500px">c. Bengkel mobil/Motor</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r706c"></input>
                    </td>
                </tr>
                <tr>
                    <td width="30px" style="text-align:center" rowspan="5">707.</td>
                    <td style="border-bottom:none" width="300px" colspan="8">Jumlah Penduduk menurut Bantuan Sosial
                        Ekonomi
                        yang diterima</td>
                </tr>
                <tr>
                    <td style="border:none" width="500px">a. Bantuan Sosial Sembako/BPNT</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r707a"></input>
                    </td>
                    <td style="border:none" width="500px">e. Program Indonesia Pintar (PIP)</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r707e"></input>
                    </td>
                </tr>
                <tr>
                    <td style="border:none" width="500px">b. Program Keluarga Harapan (PKH)</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r707b"></input>
                    </td>
                    <td style="border:none" width="500px">f. BPJS PBI</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r707f"></input>
                    </td>
                </tr>
                <tr>
                    <td style="border:none" width="500px">c. Bantuan Langsung Tunai (BLT) Desa</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r707c"></input>
                    </td>
                    <td style="border:none" width="500px">g. Program Bantuan Pemerintah Provinsi</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r707g"></input>
                    </td>
                </tr>
                <tr>
                    <td style="border:none" width="500px">d. Subsudi Listrik (gratis/pemotongan biaya)</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r707d"></input>
                    </td>
                    <td style="border:none" width="500px">h. Program Bantuan Pemerintah Kabupaten/Kota</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r707h"></input>
                    </td>
                </tr>
                <tr>
                    <td width="30px" style="text-align:center" rowspan="5">708.</td>
                    <td style="border-bottom:none" width="300px" colspan="8">Jumlah Industri Kecil dan Menengah
                    </td>
                </tr>
                <tr>
                    <td style="border:none" width="500px">a. Industri Makanan</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r708a"></input>
                    </td>
                    <td style="border:none" width="500px">e. Industri Kerajinan</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r708e"></input>
                    </td>
                </tr>
                <tr>
                    <td style="border:none" width="500px">b. Industri alat rumah tangga</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r708b"></input>
                    </td>
                    <td style="border:none" width="500px">f. Rumah makan dan restoran</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r708f"></input>
                    </td>
                </tr>
                <tr>
                    <td style="border:none" width="500px">c. ndustri material bahan bangunan</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r708c"></input>
                    </td>
                    <td style="border:none" width="500px">g. lainnya</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r708g"></input>
                    </td>
                </tr>
                <tr>
                    <td style="border:none" width="500px">d. Industri Alat Pertanian</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r708d"></input>
                    </td>
                </tr>

            </table>

            <table>
                <tr>
                    <th colspan="7">BLOK VIII: PERTANIAN DAN PETERNAKAN</th>
                </tr>
                <tr>
                    <td width="30px" style="text-align:center">801.</td>
                    <td style="border-right:none" width="300px" colspan="5">Luas Sawah (hektar):</td>
                    <td style="border-left:none" width="150px"><input type="number" required style="width:50px"
                            name="r801"></input>
                    </td>
                </tr>
                <tr>
                    <td width="30px" style="text-align:center">802.</td>
                    <td style="border-right:none" width="300px" colspan="5">Luas Tanam Padi (hektar):</td>
                    <td style="border-left:none" width="150px"><input type="number" required style="width:50px"
                            name="r802"></input>
                    </td>
                </tr>
                <tr>
                    <td width="30px" style="text-align:center">803.</td>
                    <td style="border-right:none" width="300px" colspan="5">Luas Tanam Jagung (hektar):</td>
                    <td style="border-left:none" width="150px"><input type="number" required style="width:50px"
                            name="r803"></input>
                    </td>
                </tr>
                <tr>
                    <td width="30px" style="text-align:center">804.</td>
                    <td style="border-right:none" width="300px" colspan="5">Hasil Produksi GKP (Ton):</td>
                    <td style="border-left:none" width="150px"><input type="number" required style="width:50px"
                            name="r804"></input>
                    </td>
                </tr>
                <tr>
                    <td width="30px" style="text-align:center">805.</td>
                    <td style="border-right:none" width="300px" colspan="5">Hasil Produksi Jagung Pipilan Kering(ton):
                    </td>
                    <td style="border-left:none" width="150px"><input type="number" required style="width:50px"
                            name="r805"></input>
                    </td>
                </tr>
                <tr>
                    <td width="30px" style="text-align:center" rowspan="3">806.</td>
                    <td style="border-bottom:none" width="300px" colspan="8">Jumlah Peternak dan Jumlah Hewan Ternak:
                    </td>
                </tr>
                <tr>
                    <td style="border:none" width="500px">a. Jumlah Peternak Sapi</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r806a"></input>
                    </td>
                    <td style="border:none" width="500px">c. Jumlah Peternak Kambing</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r806c"></input>
                    </td>
                </tr>
                <tr>
                    <td style="border:none" width="500px">b. Jumlah Sapi</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r806b"></input>
                    </td>
                    <td style="border:none" width="500px">d. Jumlah Kambing</td>
                    <td style="border:none" width="150px"><input type="number" required style="width:50px"
                            name="r806d"></input>
                    </td>

                </tr>
            </table>

            <table>
                <tr>
                    <th>BLOK X: CATATAN</th>
                </tr>
                <tr>
                    <td><textarea name="catatan" placeholder="Masukkan catatan tambahan jika ada"></textarea></td>
                </tr>
            </table>

            <input type="hidden" name="tahun" value="<?php echo htmlspecialchars($tahun); ?>">
            <button type="submit" name="btn">Simpan Data</button>
        </form>
    </div>
    <script>
    // Add JavaScript validation if needed
    document.querySelector('form').addEventListener('submit', function(e) {
        // Validate dusun selection
        const dusunSelect = document.getElementById('namasls');
        const kodeDusun = document.getElementById('kodesls');

        if (dusunSelect.value === '' || kodeDusun.value === '') {
            alert('Silakan pilih dusun dan kode dusun');
            e.preventDefault();
            return false;
        }

        // You can add more validation here as needed
        return true;
    });

    // Sync dusun name and code selections
    document.getElementById('namasls').addEventListener('change', function() {
        const selectedIndex = this.selectedIndex;
        document.getElementById('kodesls').selectedIndex = selectedIndex;
    });

    document.getElementById('kodesls').addEventListener('change', function() {
        const selectedIndex = this.selectedIndex;
        document.getElementById('namasls').selectedIndex = selectedIndex;
    });
    </script>
</body>


</html>