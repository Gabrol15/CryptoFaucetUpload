      <ul>
        <li><a href="<?= base_url('dashboard') ?>" class="nav-link <?php if($page == 'Dashboard'){ echo 'active';} ?>" ><i class="bx bx-category"></i> <span>Dashboard</span></a></li>
        <?php if($settings['shortlink_status'] == 'on') { ?>
        <li><a href="<?= site_url('links') ?>" class="nav-link <?php if($page == 'Shortlinks'){ echo 'active';} ?>"><i class="bx bx-link"></i> <span>Shortlinks</span></a></li>
        <?php } ?>
        <?php if($settings['ptc_status'] == 'on') { ?>
        <li><a href="<?= site_url('ads') ?>" class="nav-link <?php if($page == 'PTC Ads'){ echo 'active';} ?>"><i class="bx bx-spreadsheet"></i> <span>PTC Ads</span></a></li>
        <?php } ?>
        <?php if($settings['offerwall_status'] == 'on') { ?>
        <li><a href="<?= site_url('offerwalls') ?>" class="nav-link <?php if($page == 'Offerwalls'){ echo 'active';} ?>"><i class="bx bx-diamond"></i> <span>Offerwalls</span></a></li>
        <?php } ?>
        <?php if($settings['achievement_status'] == 'on') { ?>
        <li><a href="#" data-toggle="modal" data-target="#task" class="nav-link "><i class="bx bx-task"></i> <span>Daily Task</span></a></li>
        <?php } ?>
        <li><a href="#" data-toggle="modal" data-target="#withdraw" class="nav-link" ><i class="bx bx-wallet"></i> <span>Withdraw</span></a></li>
        <li><a href="<?= site_url('deposit') ?>" class="nav-link <?php if($page == 'Deposit'){ echo 'active';} ?>" ><i class="bx bxs-bank"></i> <span>Deposit</span></a></li>
      </ul>