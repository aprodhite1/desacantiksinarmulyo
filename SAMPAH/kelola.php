<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Desa Cantik OKU Selatan</title>
  <meta content="Portal Pengelola Desa Cantik Kab. OKU Selatan" name="description">
  <meta content="" name="keywords">
  
  <!-- Favicons -->
  <link href="assets/img/atas.png" rel="icon">

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Source+Sans+Pro:ital,wght@0,300;0,400;0,600;0,700;1,300;1,400;1,600;1,700&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <!-- bootstrap css -->
  <link rel="stylesheet" href="bt/bootstrap.min.css">
  <!-- jQuery library -->
  <script src="bt/jquery.min.js"></script>
  <!-- bootstrap js -->
  <script src="bt/bootstrap.min.js"></script>
  <!-- Variables CSS Files. Uncomment your preferred color scheme -->
  <link href="assets/css/variables.css" rel="stylesheet">
  <!-- <link href="assets/css/variables-blue.css" rel="stylesheet"> -->
  <!-- <link href="assets/css/variables-green.css" rel="stylesheet"> -->
  <!-- <link href="assets/css/variables-orange.css" rel="stylesheet"> -->
  <!-- <link href="assets/css/variables-purple.css" rel="stylesheet"> -->
  <!-- <link href="assets/css/variables-red.css" rel="stylesheet"> -->
  <!-- <link href="assets/css/variables-pink.css" rel="stylesheet"> -->

  <!-- Template Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">
  
  

</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top" data-scrollto-offset="0">
    <div class="container-fluid d-flex align-items-center justify-content-between">

      <a href="index.php" class="logo"><img src="assets/img/logo.png" alt=""><span></span></a>

      <nav id="navbar" class="navbar">
        <ul>

          <li class="dropdown"><a href="index.php">Beranda</a></li>

          <li><a class="nav-link scrollto" href="index.php#about">Tentang</a></li>
          <li><a class="nav-link scrollto" href="index.php#team">Sekretariat</a></li>
          <li><a class="nav-link scrollto" href="index.php#contact">Hubungi Kami</a></li>
          <li class="dropdown"><a href="#"><span>Monitoring</span> <i class="bi bi-chevron-down dropdown-indicator"></i></a>
            <ul>
              <li><a href="monev.php">Progres</a></li>
              <li><a href="juara.php">Parade Juara</a></li>
            </ul>
          </li>
		  <li class="dropdown"><a href="#"><span>Komunitas Statistik</span> <i class="bi bi-chevron-down dropdown-indicator"></i></a>
            <ul>
              <li><a href="struktur.php">Struktur Organisasi</a></li>
              <li><a href="agen.php">Daftar Agen Statistik</a></li>
            </ul>
          </li>
		  <li class="dropdown"><a href="#"><span>Dokumentasi</span> <i class="bi bi-chevron-down dropdown-indicator"></i></a>
            <ul>
              <li><a href="website.php">Website Desa/Kel</a></li>
              <li><a href="foto.php">Foto Kegiatan</a></li>
              <li><a href="video.php">Video Terkait</a></li>
              <li><a href="bahan.php">Bahan Ajar</a></li>
              <li><a href="dokumen.php">Dokumen</a></li>
            </ul>
          </li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle d-none"></i>
      </nav><!-- .navbar -->

      <a class="btn-getstarted scrollto" href="kelola.php">Kelola Output</a>

    </div>
  </header><!-- End Header -->

   <?php
$a=null;
if (isset($_GET['error'])){
If($_GET["error"]=="uname"){$a="Username anda tidak terdaftar";}
If($_GET["error"]=="pswd"){$a="Password anda salah";}}
?>
<main id="main">
    <!-- ======= Breadcrumbs ======= -->
    <div class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h2>Kelola Output</h2>
          <ol>
            <li><a href="index.php">Beranda</a></li>
            <li>Kelola Output</li>
          </ol>
        </div>

      </div>
    </div><!-- End Breadcrumbs --> 

    <!-- ======= Contact Section ======= -->
    <section id="contact" class="contact">
        <div class="container">

        <div class="section-header">
          <h4>Anda Perlu Login Untuk Mengelola Website dan Data Desa Anda</h4>
          <p>Hubungi Pendamping Kecamatan Jika Anda Lupa Informasi Akun Anda. Pendamping Kecamatan dapat Dilihat pada Menu Komunitas Statistik Submenu Daftar Agen Statistik</p>
        </div>

      </div>
      <div class="container" data-aos="fade-up">

        
        <div class="row" data-aos="fade-up" data-aos-delay="100">

          <div class="col-lg-3">
            
          </div>
		  <div class="col-lg-6">
			<p><?echo$a;?></p>
            <form action="log.php" method="post" role="form" class="php-email-form">
              <div class="form-group">
                <input type="text" class="form-control" name="uname" id="uname" placeholder="Username" required>
              </div>
              <div class="form-group">
                <input type="password" class="form-control" name="pswd" id="pswd" placeholder="Password" required>
              </div>
              <div class="text-center"><button type="submit">Login</button></div>
            </form>
           </div>

        </div>

      </div>
    </section><!-- End Contact Section -->

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <div class="footer-legal text-center">
      <div class="container d-flex flex-column flex-lg-row justify-content-center justify-content-lg-between align-items-center">

        <div class="d-flex flex-column align-items-center align-items-lg-start">
          <div class="copyright">
            &copy; Copyright <strong><span>Tim <font color='DarkTurquoise'>Desa Cantik</font></span></strong>. Kab. OKU Selatan
          </div>
        </div>

        <div class="social-links order-first order-lg-last mb-3 mb-lg-0">
          <a href="https://twitter.com/bpskaboku/with_replies" target="_blank" class="twitter"><i class="bi bi-twitter"></i></a>
          <a href="https://www.facebook.com/bpsokus" target="_blank" class="facebook"><i class="bi bi-facebook"></i></a>
          <a href="https://www.instagram.com/bpskabokuselatan/?hl=id" target="_blank" class="instagram"><i class="bi bi-instagram"></i></a>
          <a href="https://www.youtube.com/c/BPSKabupatenOKUSelatan" target="_blank" class="google-plus"><i class="bi bi-youtube"></i></a>
          <a href="https://okuselatankab.bps.go.id" target="_blank" class="linkedin"><i class="bi bi-globe"></i></a>
        </div>

      </div>
    </div>

  </footer><!-- End Footer -->

  <a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>
</body>

</html>