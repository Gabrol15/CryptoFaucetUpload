<div id="Claim" class="container">
        <div class="text-center mb-3">
            <div class="section-title">
               <h2><a href="<?= base_url('dashboard') ?>" alt="Back"><span><i class="fas fa-arrow-alt-circle-left"></i></span></a> <?= $page ?></h2>    
            </div>
<div class="alert alert-info text-center">Shortlink is a third party web application, we are not responsible for any activities outside the <?= $settings['name'] ?> site, such as banned countries, banned accounts, banned IPs, by shortlink providers. And errors that occur on web shortlinks are beyond our control.</div>
<div class="alert alert-warning text-center">If the Faucet Balance Status is <b class="text-success">Ready</b>, the payment will be sent directly to your linked <b>Faucetpay Email</b>. If the Faucet Balance Status is <b class="text-danger">Empty</b>, the payment will be entered into your <b>Account Balance</b> in <b>USD</b>.</div>
<div class="text-center mb-3">
                <div class="row">
                    <div class="text-info col">
                        <p class="lh-1 mb-1 fw-bold"><?= format_money($totalReward) ?> USD</p>
                        <p class="lh-1 mb-1 fw-bold">Total</p>
                    </div>                                    
                    <div class="text-warning col">
                        <p class="lh-1 mb-1 fw-bold"><?= $totalEnergy ?></p>
                        <p class="lh-1 mb-1 fw-bold">Energy</p>
                    </div>
                    <div class="text-primary col">
                        <p class="lh-1 mb-1 fw-bold"><?= $countAvailableLinks ?> Links</p>
                        <p class="lh-1 mb-1 fw-bold">Available</p>
                    </div>
                </div>
            </div>
<div class="ads">
    <?= $settings['top_ad'] ?>
</div>
<div class="row">
    <?php
    foreach ($availableLinks as $link) { ?>
        <div class="col-sm-6 mb-3">
            <div class="card card-body text-center">
                <h4 class="card-title mt-0"><?= $link['name'] ?></h4>
                <p class="card-text">Earn <?= format_money($link['reward']) ?> USD and <?= $link['energy_reward'] ?> Energy</p>
                <ol>   
                   <?php foreach ($getlink as $links) { ?>
                        <?php if($links['link_id'] == $link['id']) { 
                        $timestamp = strtotime("+1 day",$links['claim_time']);
                        ?>
                <small class="text-start"><li class="text-primary">Claim Cooldown: <?= timespan(time(), $timestamp, 2) ?></li></small>
                        <?php } ?>
                    <?php } ?>
                </ol>
                <button class="btn btn-outline-primary mb-1" type="button" data-bs-toggle="collapse" data-bs-target="#rate<?= $link['id'] ?>" aria-expanded="false" aria-controls="rate<?= $link['id'] ?>">
                  Crypto rate value
                </button>
            <div class="collapse" id="rate<?= $link['id'] ?>">
                <?php foreach($methods as $met) { ?>
                <span class="badge bg-info mb-1"><?= $met['code'] ?> Rate: <?= number_format($link['reward']/$met['price'], 8) ?></span>
                <?php } ?>
            </div>
                <span class="badge bg-primary">Available View: <?= $link['rmnViews'] ?>/<?= $link['view_per_day'] ?></span>
            </div>
            <div class="card-footer">
                <button class="btn btn-outline-primary mb-1" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $link['id'] ?>" aria-expanded="false" aria-controls="collapse<?= $link['id'] ?>">
                  Claim
                </button>
            <div class="collapse" id="collapse<?= $link['id'] ?>">
                <?php foreach($methods as $posts) { ?>   
                    <?php if($user['claims'] < $posts['min_claim']) { ?>
                    <a class="btn btn-danger btn-block mb-2 disabled" href="<?= base_url() . 'links/go/' . $link['id'] . '/'.strtolower($posts['code']) ?>">
                        <img class="currency-dashboard" src="<?= site_url('assets/images/currencies/' . strtolower($posts['code']) . '.png') ?>" />
                        <span>Claim</span>
                    </a>
                    <?php }else{ ?>
                    <a class="btn btn-primary btn-block mb-2 <?= ($link['rmnViews'] <= 0) ? 'disabled' : '' ?>" href="<?= base_url() . 'links/go/' . $link['id'] . '/'.strtolower($posts['code']) ?>">
                        <img class="currency-dashboard" src="<?= site_url('assets/images/currencies/' . strtolower($posts['code']) . '.png') ?>" />
                        <span>Claim</span>
                    </a>
                    <?php } ?>
                <?php } ?>
            </div>
            </div>
        </div>
    <?php } ?>
</div>

<?php if (!count($availableLinks)) {
    echo '<div class="alert alert-warning text-center">There is no link left <i class="far fa-sad-cry fa-2x"></i> <i class="far fa-sad-cry fa-2x"></i> <i class="far fa-sad-cry fa-2x"></i></div>';
}
?>
</div>
<div class="ads">
  <?= $settings['footer_ad'] ?>
</div> 
</div>