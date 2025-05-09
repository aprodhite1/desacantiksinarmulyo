<?php
session_start();
include 'koneksi.php';
$uname = $_SESSION['uname'];
$level = $_SESSION['level'];
$nama = $_SESSION['nama_desa'];
$kode = $_SESSION['kode_desa'];
$namakec = $_SESSION['nama_kec1'];
$kodekec = $_SESSION['kode_kec'];
$id=$_SESSION['id'];
?>
<!DOCTYPE html>
<html>

<head>
    <title>Entri Data Desa</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
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
            <h3>VD-DESCAN23</h3>
        </div>
    </div>
    <div class="judul">
        <h3 style="text-align:center">PENDATAAN POTENSI TINGKAT DUSUN/LINGKUNGAN/RT/RW TAHUN 2023</h3>
    </div>
    <form method="POST" action="action.php">
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
                <td style="border-left:none">: <?php echo"$namakec"?></td>
                <td style="text-align:right"><?php echo"$kodekec"?></td>
            </tr>
            <tr>
                <td width="30px" style="text-align:center">104.</td>
                <td style="border-right:none" width="300px">Desa/Kelurahan</td>
                <td style="border-left:none">: <?php echo"$nama"?></td>
                <td style="text-align:right"><?php echo"$kode"?></td>
            </tr>
        </table>
        <br>

        <table cellpadding="5" width="1330px">
            <tr>
                <th colspan="4">BLOK II: KETERANGAN PETUGAS</th>
            </tr>
            <tr>
                <td colspan="3" style="text-align:center; font-weight:bold;">Pencacahan</td>
                <td style="text-align:center;font-weight:bold;" width="300px">Pengesahan Kepala Desa/Lurah
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
                <th colspan="5">BLOK III: PENDIDIKAN </th>
            </tr>
            <tr>
                <td width="30px" style="text-align:center" rowspan="5">301.</td>
                <td style="border:none" width="300px" colspan="4">Jumlah sarana pendidikan menurut jenjang pendidikan di
                    Desa:
                </td>
            </tr>
            <tr>
                <td style="border:none" width="500px">a. PAUD/TK/RA/BA</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r301a"></input></td>
                <td style="border:none" width="500px">e.Akademi/Perguruan Tinggi </td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r301e"></input></td>
            </tr>
            <tr>
                <td style="border:none" width="500px">b. SD/MI</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r301b"></input></td>
                <td style="border:none" width="500px">f. SDLB/SMP/SMALB</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r301f"></input></td>
            </tr>
            <tr>
                <td style="border:none" width="500px">c. SMP/MTs</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r301c"></input></td>
                <td style="border:none" width="500px">g. Pondok Pesantren</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r301g"></input></td>
            </tr>
            <tr>
                <td style="border:none" width="500px">d. SMA/MA/SMK</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r301d"></input></td>
                <td style="border:none" width="500px">h. Madrasah Diniyah</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r301h"></input></td>
            </tr>
            <tr>
                <td width="30px" style="text-align:center" rowspan="5">302.</td>
                <td style="border-bottom:none" width="300px" colspan="4">Jumlah guru menurut jenjang pendidikan di Desa:
                </td>
            </tr>
            <tr>
                <td style="border:none" width="500px">a. PAUD/TK/RA/BA</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r302a"></input></td>
                <td style="border:none" width="500px">e.Akademi/Perguruan Tinggi </td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r302e"></input></td>
            </tr>
            <tr>
                <td style="border:none" width="500px">b. SD/MI</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r302b"></input></td>
                <td style="border:none" width="500px">f. SDLB/SMP/SMALB</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r302f"></input></td>
            </tr>
            <tr>
                <td style="border:none" width="500px">c. SMP/MTs</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r302c"></input></td>
                <td style="border:none" width="500px">g. Pondok Pesantren</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r302g"></input></td>
            </tr>
            <tr>
                <td style="border:none" width="500px">d. SMA/MA/SMK</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r302d"></input></td>
                <td style="border:none" width="500px">h. Madrasah Diniyah</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r302h"></input></td>
            </tr>

            <tr>
                <td width="30px" style="text-align:center" rowspan="5">303.</td>
                <td style="border-bottom:none" width="300px" colspan="4">Jumlah murid menurut jenjang pendidikan di
                    Desa:
                </td>
            </tr>
            <tr>
                <td style="border:none" width="500px">a. PAUD/TK/RA/BA</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r303a"></input></td>
                <td style="border:none" width="500px">e.Akademi/Perguruan Tinggi </td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r303e"></input></td>
            </tr>
            <tr>
                <td style="border:none" width="500px">b. SD/MI</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r303b"></input></td>
                <td style="border:none" width="500px">f. SDLB/SMP/SMALB</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r303f"></input></td>
            </tr>
            <tr>
                <td style="border:none" width="500px">c. SMP/MTs</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r303c"></input></td>
                <td style="border:none" width="500px">g. Pondok Pesantren</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r303g"></input></td>
            </tr>
            <tr>
                <td style="border:none" width="500px">d. SMA/MA/SMK</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r303d"></input></td>
                <td style="border:none" width="500px">h. Madrasah Diniyah</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r303h"></input></td>
            </tr>

        </table>
        <br>

        <table cellpadding="5" width="1330px">
            <tr>
                <th colspan="5">BLOK IV: KESEHATAN </th>
            </tr>
            <tr>
                <td width="30px" style="text-align:center" rowspan="6">401.</td>
                <td style="border:none" width="300px" colspan="4">Jumlah sarana kesehatan di Desa/Kelurahan:
                </td>
            </tr>
            <tr>
                <td style="border:none" width="500px">a. Rumah sakit</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r401a"></input></td>
                <td style="border:none" width="500px">f. Rumah bersalin </td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r401e"></input></td>
            </tr>
            <tr>
                <td style="border:none" width="500px">b. Puskesmas</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r401b"></input></td>
                <td style="border:none" width="500px">g. Tempat praktik bidan</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r401f"></input></td>
            </tr>
            <tr>
                <td style="border:none" width="500px">c. Poliklinik/balai pengobatan</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r401c"></input></td>
                <td style="border:none" width="500px">h. Poskesdes (Pos Kesehatan Desa)</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r401g"></input></td>
            </tr>
            <tr>
                <td style="border:none" width="500px">d. Tempat praktik dokter</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r401d"></input></td>
                <td style="border:none" width="500px">i. Polindes (Pos Bersalin Desa)</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r401g"></input></td>
            </tr>
            <tr>
                <td style="border:none" width="500px">e. Apotek</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r401d"></input></td>
                <td style="border:none" width="500px">j. Toko khusus obat/jamu</td>
                <td style="border:none" width="150px"><input type="text" style="width:50px" name="r401g"></input></td>
            </tr>
            <tr>
                <td width="30px" style="text-align:center">402.</td>
                <td style="border-right:none" width="300px" colspan="3">Angka Harapan Hidup:</td>
                <td style="border-left:none" width="150px"><input type="text" style="width:50px" name="r402"></input>
                </td>
            </tr>
        </table>
        <br>
        <table cellpadding="5" width="1330px">
            <tr>
                <th colspan="5">BLOK V: POLITIK DAN KEMASYARAKATAN </th>
            </tr>
            <tr>
                <td width="30px" style="text-align:center">501.</td>
                <td style="border-right:none" width="300px" colspan="3">Angka Harapan Hidup:</td>
                <td style="border-left:none" width="150px">
                    <select style="width:100px" name="r501">
                        <option value="yes">Yes</option>
                        <option value="no">No</option>
                    </select>
                </td>

            </tr>
            <tr>
                <td width="30px" style="text-align:center">502.</td>
                <td style="border-right:none" width="300px" colspan="3">Angka Harapan Hidup:</td>
                <td style="border-left:none" width="150px">
                    <select style="width:100px" name="r502">
                        <option value="yes">Yes</option>
                        <option value="no">No</option>
                    </select>
                </td>
                </td>
            </tr>
            <tr>
                <td width="30px" style="text-align:center">503.</td>
                <td style="border-right:none" width="300px" colspan="3">Jumlah perangkat Badan Permusyawaratan Desa
                    (BPD):</td>
                <td style="border-left:none" width="150px"><input type="text" style="width:50px" name="r503"></input>
                </td>
            </tr>

            <table cellpadding="5" width="1330px">
                <tr>
                    <th colspan="5">BLOK VI: PEMERINTAHAN </th>
                </tr>
                <tr>
                    <td width="30px" style="text-align:center">601.</td>
                    <td style="border-right:none" width="300px" colspan="3">Jumlah perangkat Desa :</td>
                    <td style="border-left:none" width="150px"><input type="text" style="width:50px"
                            name="r601"></input>
                    </td>
                </tr>
                <tr>
                    <td width="30px" style="text-align:center">602.</td>
                    <td style="border-right:none" width="300px" colspan="3">Jumlah Dusun/Lingkungan :</td>
                    <td style="border-left:none" width="150px"><input type="text" style="width:50px"
                            name="r602"></input>
                    </td>
                </tr>
                <tr>
                    <td width="30px" style="text-align:center">603.</td>
                    <td style="border-right:none" width="300px" colspan="3">Jumlah APBD:</td>
                    <td style="border-left:none" width="300px"><input type="text" style="width:300px"
                            name="r603"></input>
                    </td>
                </tr>
                <tr>
                    <td width="30px" style="text-align:center">604.</td>
                    <td style="border-right:none" width="300px" colspan="3">Apakah ada Laporan pertanggungjawaban?:</td>
                    <td style="border-left:none" width="150px">
                        <select style="width:100px" name="r604">
                            <option value="yes">Yes</option>
                            <option value="no">No</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td width="30px" style="text-align:center">605.</td>
                    <td style="border-right:none" width="300px" colspan="3">Apakah ada Pembinaan dan Pengawasan
                        pengelolaan Desa?:</td>
                    <td style="border-left:none" width="150px">
                        <select style="width:100px" name="r605">
                            <option value="yes">Yes</option>
                            <option value="no">No</option>
                        </select>
                    </td>
                </tr>
            </table>
            <table cellpadding="5" width="1330px">
                <tr>
                    <th colspan="5">BLOK VII: EKONOMI </th>
                </tr>
                <tr>
                    <td width="30px" style="text-align:center">701.</td>
                    <td style="border-right:none" width="300px" colspan="3">Apakah ada Transportasi umum di
                        desa(ojek,taksi,dll)?:</td>
                    <td style="border-left:none" width="150px">
                        <select style="width:100px" name="r701">
                            <option value="yes">Yes</option>
                            <option value="no">No</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td width="30px" style="text-align:center">702.</td>
                    <td style="border-right:none" width="300px" colspan="3">Jumlah Penduduk yang memiliki aset sarana
                        produksi (Pabrik,Traktor, Mesin pengelolahan, dll) :</td>
                    <td style="border-left:none" width="150px"><input type="text" style="width:50px"
                            name="r702"></input>
                    </td>
                </tr>


                <table cellpadding="5" width="1330px">
                    <tr>
                        <th>BLOK VIII: CATATAN</th>
                    </tr>
                    <tr>
                        <td height="200px"><textarea style="width:1300px; height:180px;" name="catatan"></textarea>
                        </td>
                        </td>
                    <tr>
                        <br>
                </table>
                <br>
                <button type="submit" name="btn" onclick="alert('Data Berhasil Disimpan')">Save</button>
    </form>

</body>

</html>