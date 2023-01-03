<div class="container">
    <div class="section-title">
        <h2><?php echo $page ?></h2>
    </div>
    <div class="text-primary p-3">
    <h5 class="text-primary"><span id="greeting"></span> <b><?= $user['username'] ?></b> <a href="<?= site_url('profile') ?>" class="btn btn-primary btn-sm">Account setting<i class="mdi mdi-arrow-right ml-1"></i></a></h5>
<script>
    var myDate = new Date();
    var currentHour = myDate.getHours();

    var msg;

    if (currentHour < 12)
        msg = 'Good morning!';
    else if (currentHour >= 12 && currentHour <= 19)
        msg = 'Good afternoon!';
    else if (currentHour >= 19 && currentHour <= 24)
        msg = 'Good night!';

    document.getElementById('greeting').innerHTML = msg;
</script>
    </div>
<?php
if($settings["email_confirmation"] == 'on') {
    if ($user['verified'] == 0) {
  echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
        Please confirm your email address to be able to claim or withdraw, <a href="' . site_url('dashboard/resend') . '">Resend</a>
        <a class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true"><i class="far fa-window-close"></i></span>
        </a>
      </div>';
    }
}
?>
      <div class="card-list text-center">
        <div class="row">
          <div class="col-12 col-md-6 col-lg-4 col-xl-3 mb-4">
            <div class="card card-body bg-primary text-white">
              <div class="title"><i class="fas fa-money-bill"></i> Account Balance</div>
              <div class="fw-bold"><?= format_money($user['balance']) ?> USD</div>
            </div>
          </div>
          <div class="col-12 col-md-6 col-lg-4 col-xl-3 mb-4">
            <div class="card card-body bg-primary text-white">
              <div class="title"><i class="fas fa-bolt"></i> Energy</div>
              <div class="fw-bold"><?= $user['energy'] ?></div>
            </div>
          </div>
          <div class="col-12 col-md-6 col-lg-4 col-xl-3 mb-4">
            <div class="card card-body bg-primary text-white">
              <div class="title"><i class="fas fa-hand-point-up"></i> Total Claims</div>
              <div class="fw-bold"><?= $user['claims'] ?></div>
            </div>
          </div>
          <div class="col-12 col-md-6 col-lg-4 col-xl-3 mb-4">
            <div class="card card-body bg-primary text-white">
              <div class="title"><i class="fas fa-users"></i> Referrals</div>
              <div class="fw-bold"><?= $referralCount ?></div>
            </div>
          </div>
        </div>
      </div>
      <div class="alert alert-info text-center">Invite your friends and earn <?= $settings['referral'] ?>% comission from their earnings to your Account Balance. Your referral links is: <input title="Copy" id="txtref" style="cursor: copy;" onclick="copyb()" type"text" value="<?= site_url().'?r=' . $user['id']; ?>" readonly></div>
<script>
function copyb() {
  var copyText = document.getElementById("txtref");
  copyText.select();
  copyText.setSelectionRange(0, 99999);
  navigator.clipboard.writeText(copyText.value);
  Swal.fire("Success", "The referral link has been successfully copied to the clipboard", "success");
}
</script>
<form action="<?= site_url() ?>dashboard/authorize" method="post">
        <div class="input-group mb-3">
                <input type="hidden" name="<?= $csrf_name ?>" id="token" value="<?= $csrf_hash ?>">
                <input type="hidden" name="token" value="<?= $user['token'] ?>">
            <input class="form-control" type="email" name="wallet" placeholder="Connect Your FaucetPay Email" value="<?= $user['wallet'] ?>">
        <span class="input-group-btn">
            <button type="submit" class="btn btn-primary">Authorize</button>
        </span>
        </div>
</form>
<div class="alert alert-info text-center">Rewards rate refers to the USD price value, rewards can change at any time as the unit price of the available Cryptocurrency moves.</div>
<div class="alert alert-primary text-center">All rewards will be sent directly to your linked faucetpay email.</div>
<div class="row">
<?php foreach($methods as $posts) { ?>
    <div class="col-md-6">
        <div class="card mb-3">
            <div class="card-body">
             <div class="text-center">                    
                <img class="currency-dashboard" src="<?= site_url('assets/images/currencies/' . strtolower($posts['code']) . '.png') ?>" /> <br>              
                  <h3><?= $posts['name'] ?></h3>
                    <?php if($user['claims'] < $posts['min_claim']) { ?>
                        <span class="text-danger">Locked</span>
                        <p class="text-danger">You have to made <?= $posts['min_claim']-$user['claims'] ?> Total Claims to Unlock this currency</p>
                    <?php }else{ ?>
                        <span class="text-success">Unlocked</span><hr>
                    <a href="<?= site_url('faucet/currency/'.strtolower($posts['code'])) ?>" class="btn btn-primary btn-md">
                       <span>Claim <?= $posts['code'] ?></span>
                    </a>
                    <?php if($settings['autofaucet_status'] == 'on') { ?>
                    <a href="<?= site_url('auto/currency/'.strtolower($posts['code'])) ?>" class="btn btn-primary btn-md">
                       <span>Auto Claim <?= $posts['code'] ?></span>
                    </a>
                    <?php } ?>
                    <?php } ?>
                </div>      
            </div>
        </div>
    </div>
<?php } ?>
</div>
</div>
<div class="ads">
  <?= $settings['footer_ad'] ?>
</div>
<div class="card">
    <div class="card-body">
         <h3>Latest Payout History</h3>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">FaucetPay Email</th>
                                        <th scope="col">Amount</th>
                                        <th scope="col">Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($withdrawals_history as $value) {
$string = $value["wallet"];
$output = substr($string, 0, 2) . "******" . substr($string, 8, 50);                                        
                                        echo '<tr><th scope="row">' . $value["id"] . '</th><td>' . $output . '</td><td>' . number_format($value["amount"],8) . ' <img width="25" height="25" src="'.site_url().'assets/images/currencies/' . strtolower($value['method']) . '.png"></td><td>' . timespan($value["claim_time"], time(), 2) . ' ago</td></tr>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>     
  </div>  
</div>


      </div>