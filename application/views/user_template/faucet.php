<div id="Claim" class="container">
        <div class="text-center mb-3">
            <div class="section-title">
               <h2><a href="<?= base_url('dashboard') ?>" alt="Back"><span><i class="fas fa-arrow-alt-circle-left"></i></span></a> Claim <span class="text-info typed" data-typed-items="<?= $this_page['name'] ?>"></span></h2>    
            </div>
    <?php include 'include/faucetheader.php'; ?>
<?php if (!$limit && !$wait) { ?>  
                <div class="row">
                    <div class="text-info col">
                        <p class="lh-1 mb-1 fw-bold"><?= number_format($this_page['reward']/$this_page['price'],8) ?> <?= $this_page['code'] ?></p>
                        <?php if($this_page['timer'] >= 60 && $this_page['timer'] < 120) { ?>
                        <p class="lh-1 mb-1 fw-bold"><?= floor($this_page['timer'] / 60) ?> Minute</p> 
                        <?php }else if($this_page['timer'] >= 120) { ?>
                        <p class="lh-1 mb-1 fw-bold"><?= floor($this_page['timer'] / 60) ?> Minutes</p>                           
                        <?php }else if($this_page['timer'] < 60 && $this_page['timer'] > 1) { ?>
                        <p class="lh-1 mb-1 fw-bold"><?= $this_page['timer'] ?> Seconds</p>
                        <?php }else if($this_page['timer'] < 2) { ?>
                        <p class="lh-1 mb-1 fw-bold"><?= $this_page['timer'] ?> Second</p>      
                        <?php } ?>                                                              
                    </div>
                    <div class="text-warning col">
                        <p class="lh-1 mb-1 fw-bold">+<?= $this_page['energy_reward'] ?></p>
                        <p class="lh-1 mb-1 fw-bold">Energy</p>
                    </div>
                    <div class="text-primary col">
                        <p class="lh-1 mb-1 fw-bold"><?= $countHistory ?>/<?= $this_page['limit_claim'] ?></p>
                        <p class="lh-1 mb-1 fw-bold">claims left</p>
                    </div>
                </div>
             <?php } ?>
        </div>
<div class="ads">
    <?= $settings['top_ad'] ?>
</div>
<div class="text-center row">
    <div class="col-12 col-md-8 col-lg-6 order-md-2 mb-4 text-center">
<?php if (!$limit && !$wait) { ?>
 
                                <?php if($user['claims'] < $this_page['min_claim']) { ?>
                                    <span class="text-danger">Locked</span>
                                    <p class="text-danger">You have to made <?= $this_page['min_claim'] ?> Total Claims to Unlock this currency</p>
                                <?php }else{ ?>
                                    <span class="text-success">Unlocked</span>
            <form id="fauform" class="rounded" action="<?= site_url('/faucet/verify/'.strtolower($this_page['code'])) ?>" method="POST">
                <div class="atb">
                    <?php
                    if ($anti_pos[0] == 0) {
                        echo '<div class="antibotlinks"></div>';
                    }
                    if ($anti_pos[1] == 0) {
                        echo '<div class="antibotlinks"></div>';
                    }
                    if ($anti_pos[2] == 0) {
                        echo '<div class="antibotlinks"></div>';
                    }
                    ?>
                </div>
                <?php if ($settings['antibotlinks'] == 'on') {
                    echo $antibot_show_info;
                }
                ?>
                <div class="atb">
                    <?php
                    if ($anti_pos[0] == 1) {
                        echo '<div class="antibotlinks"></div>';
                    }
                    if ($anti_pos[1] == 1) {
                        echo '<div class="antibotlinks"></div>';
                    }
                    if ($anti_pos[2] == 1) {
                        echo '<div class="antibotlinks"></div>';
                    }
                    ?>
                </div>
                <input type="hidden" name="<?= $csrf_name ?>" id="token" value="<?= $csrf_hash ?>">
                <input type="hidden" name="token" value="<?= $user['token'] ?>">               
                <div class="atb">
                    <?php
                    if ($anti_pos[0] == 2) {
                        echo '<div class="antibotlinks"></div>';
                    }
                    if ($anti_pos[1] == 2) {
                        echo '<div class="antibotlinks"></div>';
                    }
                    if ($anti_pos[2] == 2) {
                        echo '<div class="antibotlinks"></div>';
                    }
                    ?>
                </div>
                <center>
                    <?= $captcha_display ?>
                </center>
                <div class="atb">
                    <?php
                    if ($anti_pos[0] == 3) {
                        echo '<div class="antibotlinks"></div>';
                    }
                    if ($anti_pos[1] == 3) {
                        echo '<div class="antibotlinks"></div>';
                    }
                    if ($anti_pos[2] == 3) {
                        echo '<div class="antibotlinks"></div>';
                    }
                    ?>
                </div>
                <div class="atb">
                    <?php
                    if ($anti_pos[0] == 4) {
                        echo '<div class="antibotlinks"></div>';
                    }
                    if ($anti_pos[1] == 4) {
                        echo '<div class="antibotlinks"></div>';
                    }
                    if ($anti_pos[2] == 4) {
                        echo '<div class="antibotlinks"></div>';
                    }
                    ?>
                </div>
            
                <div class="atb">
                    <?php
                    if ($anti_pos[0] == 5) {
                        echo '<div class="antibotlinks"></div>';
                    }
                    if ($anti_pos[1] == 5) {
                        echo '<div class="antibotlinks"></div>';
                    }
                    if ($anti_pos[2] == 5) {
                        echo '<div class="antibotlinks"></div>';
                    }
                    ?>
                </div>
<button class="btn btn-primary" type="submit">
 Claim Now
</button> 
            </form>
                                <?php } ?>
<?php }else{ ?>
<div class="ads">
    <?= $settings['top_ad'] ?>
</div>
<?php } ?>
    </div>
    <div class="col-6 col-md-2 col-lg-3 order-md-1 p-0 left-ads"><?= $settings['left_ad'] ?></div>
    <div class="col-6 col-md-2 col-lg-3 order-md-3 p-0 right-ads"><?= $settings['right_ad'] ?></div>
</div>
<div class="ads">
  <?= $settings['footer_ad'] ?>
</div> 
                         
<?php $cur = strtolower($this_page['code']); ?>
<script>
var curr = '<?= $cur ?>';
</script>
      </div>