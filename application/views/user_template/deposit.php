<div class="container">
        <div class="text-center mb-3">
            <div class="section-title">
               <h2><a href="<?= site_url('dashboard') ?>" alt="Back"><span><i class="fas fa-arrow-alt-circle-left"></i></span></a> <?= $page ?></h2>    
            </div>
<h6>
      <div class="card-list text-center">
        <div class="row">
          <div class="col-md-6 mb-4">
            <div class="card card-body bg-primary text-white">
              <div class="title"><i class="fas fa-money-bill"></i> Account Balance</div>
              <div class="fw-bold"><?= format_money($user['balance']) ?> USD</div>
            </div>
          </div>
          <div class="col-md-6 mb-4">
            <div class="card card-body bg-primary text-white">
              <div class="title"><i class="fas fa-money-check"></i> Advertising Balance</div>
              <div class="fw-bold"><?= format_money($user['dep_balance']) ?> USD</div>
            </div>
          </div>
        </div>
      </div>
<?php
if (isset($_SESSION['message'])) {
    echo $_SESSION['message'];
} ?>
<?php
if (isset($message)) {
    echo $message;
} ?>
        </div>
<div class="row">
    <div class="col-lg-12">
        <?php if($settings['faucetpay_deposit_status'] == 'on') { ?>
            <div class="card mb-3">
                <div class="card-body">
                    <h4 class="card-title mb-4 text-center">FaucetPay Deposit</h4>
                    <form action="https://faucetpay.io/merchant/webscr" method="POST" target="_blank" autocomplete="off">
                        <div class="form-group">
                            <label>Amount (USD) :</label>
                            <input type="number" name="amount1" class="form-control" min="<?= $settings['faucetpay_min_deposit'] ?>" step="0.000001">
                        </div>

                        <input type="hidden" name="currency2" value="">
                        <input type="hidden" name="merchant_username" value="<?= $settings['faucetpay_username'] ?>">
                        <input type="hidden" name="item_description" value="Deposit to <?= $settings['name'] ?>">
                        <input type="hidden" name="currency1" value="USD">
                        <input type="hidden" name="custom" value="<?= $user['id'] ?>">
                        <input type="hidden" name="callback_url" value="<?= site_url('confirm/faucetpay') ?>">
                        <input type="hidden" name="success_url" value="<?= site_url('deposit?success=true') ?>">
                        <input type="hidden" name="cancel_url" value="<?= site_url('deposit?success=false') ?>">
                        <div class="mt-4">
                            <button type="submit" class="btn btn-success">Deposit</button>
                        </div>
                        <small>You can pay with other currencies after creating the deposit.</small>
                    </form>

                </div>
            </div>
        <?php } ?>
        <?php if($settings['payeer_status'] == 'on') { ?>
            <div class="card mb-3">
                <div class="card-body">
                    <h4 class="card-title mb-4 text-center">Payeer Deposit</h4>
                    <form action="<?= site_url('/deposit/payeer') ?>" method="POST" autocomplete="off">
                        <div class="form-group">
                            <label>Amount (USD) :</label>
                            <input type="number" name="amount" class="form-control" min="<?= $settings['payeer_min_deposit'] ?>" step="0.001">
                        </div>
                        <input type="hidden" name="<?= $csrf_name ?>" value="<?= $csrf_hash ?>">
                        <div class="mt-4">
                            <button type="submit" class="btn btn-success">Deposit</button>
                        </div>
                    </form>
                </div>
            </div>
        <?php } ?>
        <div class="card">
            <div class="card-body text-center">
                <h4 class="card-title mb-4">Deposit history</h4>
                <?php
                if (isset($_SESSION['message'])) {
                    echo $_SESSION['message'];
                } ?>
                <div class="table-responsive">
                    <table class="table table-striped text-center">
                        <thead>
                            <tr>
                                <th scope="col">Code</th>
                                <th scope="col">Status</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($deposits as $deposit) {
                                if ($deposit['type'] == 1) {
                                    echo '<tr><td scope="row">Faucetpay: ' . $deposit["code"] . '</td><td>' . $deposit["status"] . '</td><td>' . $deposit["amount"] . ' USD</td><td>' . timespan($deposit["create_time"], time(), 2) . ' ago</td></tr>';
                                } else if ($deposit['type'] == 2) {
                                    echo '<tr><td scope="row">Coinbase: <a target="_blank" href="https://commerce.coinbase.com/charges/' . $deposit["code"] . '">' . $deposit["code"] . '</a></td><td>' . $deposit["status"] . '</td><td>' . $deposit["amount"] . ' USD</td><td>' . timespan($deposit["create_time"], time(), 2) . ' ago</td></tr>';
                                } else {
                                    echo '<tr><td scope="row">Payeer: ' . $deposit["code"] . '</td><td>' . $deposit["status"] . '</td><td>' . $deposit["amount"] . ' USD</td><td>' . timespan($deposit["create_time"], time(), 2) . ' ago</td></tr>';
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
      </div>