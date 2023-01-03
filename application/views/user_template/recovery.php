<style>.login-section{min-height:100vh;display:flex;font-family:Roboto,sans-serif;justify-content:center;align-items:center}.login-form{background:#fff;width:450px;height:auto;padding:2rem 2.4rem;border-radius:4px;box-shadow:2px 2px 9px 1px rgba(0,0,0,.1)}.login-header h2{font-weight:400;padding-bottom:.4rem}.login-header p{color:gray;font-weight:400}.form{display:flex;flex-direction:column;gap:.8rem;margin-top:2rem}.form .input-field{display:flex;flex-direction:column;gap:.3rem}.form .input-field input{padding:.7rem;background:#f3f3ff;border:1px solid #eef}.form .input{margin:.8rem 0}.form .input input[type=checkbox]{margin-right:.4rem!important}.option-container{display:flex;gap:.4rem;margin-top:.7rem}.option-container .option-box{padding:.6rem 2rem;border:1px solid;border-radius:4px;background:#f3f3ff;cursor:pointer}.option-container .option-box button{width:100%;height:100%;background:0 0;border:none;font-weight:700;padding:0}.form-action span,.form-text p{color:gray}.form-text{margin-top:1rem}.form-text a{text-decoration:none;color:#7366ff}</style>
  <!-- ======= Recovery Section ======= -->
<?php if (isset($_SESSION['message'])) { echo $_SESSION['message'];} ?>
<section class="d-flex flex-column justify-content-center">
<div class="login-section" data-aos="zoom-in" data-aos-delay="100">
  <div class="login-form">
    <div class="login-header">
      <h2>Recover your password</h2>
      <p>Enter your registered email</p>
    </div>
    <div class="form">
    <form id="recovery" action="<?= site_url('auth/forgot_password') ?>" method="POST">
    <input type="hidden" name="<?= $csrf_name ?>" value="<?= $csrf_hash ?>">
      <div class="input-field mb-3">
        <label for="email">Email Address</label>
        <input type="email" name="email" class="form-control" id="email" placeholder="Enter email" required>
      </div>
        <center><?= $captcha_display ?></center>
    </form>
    <button onclick="document.getElementById('recovery').submit();" type="submit" class="btn btn-primary btn-block">Reset</button>
    </div>
      <div class="form-action">
        <div class="form-text">
          <p>Remember your password? <a href="<?= site_url('login') ?>">Login here</a></p>
        </div>
      </div>
  </div>
</div>
</section>
  <!-- End Recovery -->
  