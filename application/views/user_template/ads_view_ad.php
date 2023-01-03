<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title><?= $ads['name'] ?> | <?= $settings['name'] ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="<?= $settings['description'] ?>" name="description" />
    <meta content="Ourtecads" name="author" />
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <!-- CSS Files -->
    <link href="<?= base_url() ?>newassets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="<?= base_url() ?>newassets/css/now-ui-dashboard.css?v=1.5.0" rel="stylesheet" />
    <link href="<?= base_url() ?>newassets/css/custom.css" rel="stylesheet" />
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- App favicon -->
<?php foreach(glob('assets/upload/favicon/'.'*.{jpg,JPG,jpeg,JPEG,png,PNG,ico,ICO}',GLOB_BRACE) as $image){ $faviconname[] =  basename($image); } ?>
<link rel="shortcut icon" href="<?= base_url('assets/upload/favicon/'.$faviconname[0]) ?>" type="image/png">
<link rel="apple-touch-icon" href="<?= base_url('assets/upload/favicon/'.$faviconname[0]) ?>" type="image/png">
<style>

.float{
	position:fixed;
	width:60px;
	height:60px;
	bottom:40px;
	right:40px;
	background-color:#06C;
	color:#FFF;
	border-radius:50px;
	text-align:center;
	
}

.my-float{
	font-size:24px;
	margin-top:10px;
}

.float1{
	position:fixed;
	width:60px;
	height:60px;
	bottom:110px;
	right:40px;
	background-color:#06C;
	color:#FFF;
	border-radius:50px;
	text-align:center;
	
}

.my-float1{
	font-size:24px;
	margin-top:11px;
}
</style>
</head>

<body data-sidebar="dark" style="overflow: hidden">

<a href="<?= $ads['url'] ?>" target="_blank" class="bg-warning float1">
<p class="my-float1 text-white"><i class="fas fa-external-link-alt"></i></p>
</a>    

<button data-target="#ptcCaptcha" data-toggle="modal" class="bg-primary float" disabled>
<p class="my-float text-white" id="ptcCountdown"></p>
</button>    

    <iframe id="ads" src="<?= $ads['url'] ?>" frameborder="0" style="width: 100%; height: calc(100vh - 5px);" sandbox="allow-same-origin allow-scripts allow-forms"></iframe>
    <div class="modal fade" id="ptcCaptcha" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Complete the captcha to get reward</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="ptcform" action="<?= site_url('/ads/verify/' . $ads['id'].'/'.$this_page['code']) ?>" method="POST">
                        <center>
                            <?= $captcha_display ?>
                        </center>
                        <input type="hidden" name="<?= $csrf_name ?>" value="<?= $csrf_hash ?>">
                        <input type="hidden" name="token" value="<?= $user['token'] ?>">
<center><span id="subbutton" class="text-center btn btn-primary">
<i class="far fa-check-circle"></i> Collect your reward
</span></center>         
                
<script>
$(document).ready(function(){
   $('#subbutton').click(function(){
     $("#ptcform").submit();
    let win = window.open('<?= $ads['url'] ?>', '_blank');
    win.focus();
   });
});
</script>                                       
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        var timer = <?= $ads['timer'] ?>;
        var url = '<?= $ads['url'] ?>';
    </script>
  <script src="<?= base_url() ?>newassets/js/core/jquery.min.js"></script>
  <script src="<?= base_url() ?>newassets/js/core/popper.min.js"></script>
  <script src="<?= base_url() ?>newassets/js/core/bootstrap.min.js"></script>
    <!-- App js -->
    <script src="<?= base_url() ?>assets/js/app.js"></script>
    <script src="<?= base_url() ?>assets/js/webjs/captcha.js"></script>
    <script>
$(document).ready(function () {
    console.log(timer);
    --timer;
    const count = setInterval(() => {
        if (timer < 0) {
        
      $(".float").html(
        '<p class="my-float text-white"><i class="far fa-check-circle"></i></p>'
      );
      $(".float").addClass("bg-success");
      $(".float").removeAttr("disabled");

            clearInterval(count);
        } else {
            if (timer > 1) {
                $('#ptcCountdown').text(`${timer}`);
            } else {
                $('#ptcCountdown').text(`${timer}`);
            }
            if (document.hasFocus())
                --timer;
        }
    }, 1000);
});

$('#verify').click(() => {
    let win = window.open(url, '_blank');
    win.focus();
});    
    </script>
    <?php if (isset($_COOKIE['captcha'])) { ?>
        <script>
            $('option[value=<?= $_COOKIE['captcha'] ?>]').attr('selected', 'selected');
        </script>
    <?php } ?>
    <?php
    if (isset($_SESSION['sweet_message'])) {
        echo $_SESSION['sweet_message'];
    }
    ?>

</body>

</html>