<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title><?php echo $page ?> | <?php echo $settings['name'] ?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <meta content="<?php echo $settings['description'] ?>" name="description" />
    <meta name=”robots” content=”noindex,nofollow”>     

    <meta content="Cryptocoins" name="author" />

    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <!-- CSS Files -->
    <link href="<?= base_url() ?>newassets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="<?= base_url() ?>newassets/css/now-ui-dashboard.css?v=1.5.0" rel="stylesheet" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="<?php echo base_url() ?>assets/images/favicon.ico">

    <script src='<?= base_url() ?>assets/js/webjs/sweetalert.min.js'></script>
<style>
.ads {text-align: center !important;margin: 5px;}.left-ads {text-align: right;margin: 5px 0px 5px 0px;}.right-ads {text-align: left;margin: 5px 0px 5px 0px;}.antibotlinks {display: inline-block;}.atb {display: block;text-align: center;}.media-body {word-break: break-all;}.currency-dashboard {max-width: 25px;}
</style>
</head>
<body class="">
<?php if(isset($_SESSION['admin'])) { ?>
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-transparent  bg-primary  navbar-absolute">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <a class="navbar-brand" href="<?= base_url() ?>"><?php echo $settings['name'] ?></a>
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end" id="navigation">
            <ul class="navbar-nav">
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="now-ui-icons ui-2_settings-90"></i>
                  <p>
                    <span class="d-lg-none d-md-block">Settings</span>
                  </p>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                            <a href="<?= site_url('admin/overview') ?>" class="dropdown-item">
                                Overview
                            </a>
                            <a href="<?= site_url('admin/images') ?>" class="dropdown-item">
                                Images Settings
                            </a>
                            <a href="<?= site_url('admin/currencies') ?>" class="dropdown-item">
                                Manage Currency
                            </a>
                            <a href="<?= site_url('admin/faucet') ?>" class="dropdown-item">
                                Faucet Settings
                            </a>
                            <a href="<?= site_url('admin/auto') ?>" class="dropdown-item">
                                Auto Faucet Settings
                            </a>
                            <a href="<?= site_url('admin/achievements') ?>" class="dropdown-item">
                                Achievements Settings
                            </a>
                            <a href="<?= site_url('admin/links') ?>" class="dropdown-item">
                                Shortlinks Settings
                            </a>
                            <a href="<?= site_url('admin/deposit') ?>" class="dropdown-item">
                                Deposit Settings
                            </a>
                </div>
              </li>
              <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">              
                  <i class="now-ui-icons business_chart-bar-32"></i>
                  <p>
                    <span class="d-lg-none d-md-block">Advertiser</span>
                  </p>
               </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                                <a href="<?= site_url('admin/advertise/options') ?>" class="dropdown-item">Options</a>
                                <a href="<?= site_url('admin/advertise') ?>" class="dropdown-item">Create campaign</a>
                                <a href="<?= site_url('admin/advertise/accepted') ?>" class="dropdown-item">Accepted campaigns</a>
                                <a href="<?= site_url('admin/advertise/pending') ?>" class="dropdown-item">Pending campaigns</a>
                                <a href="<?= site_url('admin/advertise/completed') ?>" class="dropdown-item">Completed campaigns</a>
                                <a href="<?= site_url('admin/advertise/admin') ?>" class="dropdown-item">Created by admin campaigns</a>
                </div>
              
              </li>
              <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">              
                  <i class="now-ui-icons users_single-02"></i>
                  <p>
                    <span class="d-lg-none d-md-block">Account</span>
                  </p>
               </a>
              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
              <a class="dropdown-item text-danger" href="<?= site_url('auth/logout') ?>"><i class="bx bx-power-off text-danger"></i> <span key="t-logout">Logout</span></a>
              </div>
              </li>
            </ul>
          </div>
        </div>
      </nav>
      <!-- End Navbar -->
<div class="panel-header panel-header-sm text-center text-white mb-2">
    <h2 class="text-center"><?php echo $page ?></h2>
</div>
<?php }else{ ?>
<div class="panel-header panel-header-md text-center text-white mb-2">
    <h1 class="text-center"><?php echo $settings['name'] ?> Admin Dashboard</h1>
</div>
<?php } ?>
        <div class="content mt-2">
                <div class="container-fluid">
                <?php
                if (isset($_SESSION['message'])) {
                    echo $_SESSION['message'];
                }
                ?>
                    <?= $contents ?>
                    <!-- end row -->
                </div>

            <!-- End Page-content -->
      <footer class="footer">
        <div class=" container-fluid ">
          <div class="copyright" id="copyright">
            &copy; <script>
              document.getElementById('copyright').appendChild(document.createTextNode(new Date().getFullYear()))
            </script>, <a href="<?= base_url() ?>" target="_blank"> <?php echo $settings['name'] ?></a>.
          </div>
        </div>
      </footer>
        </div>
        <!-- end main content-->
  <!--   Core JS Files   -->
  <script src="<?= base_url() ?>newassets/js/core/jquery.min.js"></script>
  <script src="<?= base_url() ?>newassets/js/core/popper.min.js"></script>
  <script src="<?= base_url() ?>newassets/js/core/bootstrap.min.js"></script>
  <!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="<?= base_url() ?>newassets/js/now-ui-dashboard.min.js?v=1.5.0" type="text/javascript"></script>
    <script type="text/javascript">
        var site_url = "<?= base_url() ?>";
    </script>
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
</body>

</html>