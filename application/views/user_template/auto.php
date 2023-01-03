<div class="container">
    <div class="text-center mb-3">
    <div class="section-title">
        <h2><a href="<?= site_url('dashboard') ?>" alt="Back"><span><i class="fas fa-arrow-alt-circle-left"></i></span></a> <?= $page ?></h2>    
    </div>
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
        <div class="ads">
           <?= $settings['top_ad'] ?>
        </div>
                <div class="text-center row">
                    <div class="col-12 col-md-8 col-lg-6 order-md-2 mb-4 text-center">
                <?php
                if (!isset($error)) { ?>
                        <div class="alert alert-info">
                            Please wait <b id="minute"><?= floor($settings['autofaucet_timer'] / 60) ?></b>:<b id="second"><?= $settings['autofaucet_timer'] % 60 ?></b> to get <?= $settings['autofaucet_reward'] ?> USD
                        </div>
                        
                        <div class="progress br-30">
                            <div class="progress-bar bg-primary" id="progress" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="60"></div>
                        </div>
                        <form action="<?= site_url('auto/verify/'.strtolower($this_page['code'])) ?>" method="POST" id="verify">
                            <input type="hidden" name="token" value="<?= $_SESSION['autoFaucetToken'] ?>">
                        </form>
                        <script>
                            let timer = <?= $settings['autofaucet_timer'] ?>,
                                current = 0;
                            const autoFaucet = setInterval(function() {
                                current += 1;
                                let percent = current * 100 / timer;
                                $('#progress').attr('style', 'width: ' + percent + '%;');
                                $('#progress').attr('aria-valuenow', percent);
                                if (current >= timer) {
                                    clearInterval(autoFaucet);
                                    $('#verify').submit();
                                } else {
                                    let wait = Math.floor(timer - current);
                                    let minutes = Math.floor(wait / 60);
                                    let seconds = wait % 60;
                                    $('#minute').text(minutes);
                                    $('#second').text(seconds);
                                    wait -= 1;
                                }
                            }, 1000);
                        </script>
                <?php } else {
                    echo faucet_alert('danger', 'You don\'t have enough energy for Auto Faucet!');
                } ?>
                </div>
                <div class="col-6 col-md-2 col-lg-3 order-md-1 p-0 left-ads"><?= $settings['left_ad'] ?></div>
                <div class="col-6 col-md-2 col-lg-3 order-md-3 p-0 right-ads"><?= $settings['right_ad'] ?></div>
            </div>
            <div class="ads">
                 <?= $settings['footer_ad'] ?>
            </div> 
              