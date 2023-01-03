<div class="container">
        <div class="text-center mb-3">
            <div class="section-title">
               <h2><a href="<?= base_url('dashboard') ?>" alt="Back"><span><i class="fas fa-arrow-alt-circle-left"></i></span></a> <?= $page ?></h2>    
            </div>
<div class="alert alert-warning text-center">If the Faucet Balance Status is <b class="text-success">Ready</b>, the payment will be sent directly to your linked <b>Faucetpay Email</b>. If the Faucet Balance Status is <b class="text-danger">Empty</b>, the payment will be entered into your <b>Account Balance</b> in <b>USD</b>.</div>
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
              <div class="title"><i class="fas fa-money-check"></i> Advertising Balance</div>
              <div class="fw-bold"><?= format_money($user['dep_balance']) ?> USD</div>
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
<button type="button" class="btn btn-success mb-2" data-toggle="modal" data-target="#advertise">
  Advertise
</button>
<button type="button" class="btn btn-warning mb-2" data-toggle="modal" data-target="#manage">
  Manage
</button>
<button type="button" class="btn btn-info mb-2" onclick="window.location = '<?= site_url('deposit') ?>'">
  Deposit
</button>
                <div class="row">
                    <div class="text-info col">
                        <p class="lh-1 mb-1 fw-bold"><?= format_money($totalReward) ?> USD</p>
                        <p class="lh-1 mb-1 fw-bold">Total</p>
                    </div>                                    
                    <div class="text-warning col">
                        <p class="lh-1 mb-1 fw-bold"><?= $totalAds ?> Ads</p>
                        <p class="lh-1 mb-1 fw-bold">Available</p>
                    </div>
                </div>
        </div>
<div class="ads">
    <?= $settings['top_ad'] ?>
</div>
<div class="text-center row">
    <?php
    foreach ($ptcAds as $advert) { ?>
        <div class="col-sm-6 mb-3">
                    <div class="card card-body">
                        <h4 class="card-title mt-0"><?= $advert['name'] ?></h4>
                        <p class="card-text"><?= $advert['description'] ?></p>
                        <div class="row text-center">
                            <div class="col-md-6">
                                <span><i class="fas fa-gift"></i>: <?= format_money($advert['reward']) ?> USD</span>
                            </div>
                            <div class="col-md-6">
                                <span><i class="fas fa-stopwatch"></i>: <?= $advert['timer'] ?> sec</span>
                            </div>
                        </div>
                <button class="btn btn-outline-primary mt-1" type="button" data-bs-toggle="collapse" data-bs-target="#rate<?= $advert['id'] ?>" aria-expanded="false" aria-controls="rate<?= $advert['id'] ?>">
                  Crypto rate value
                </button>
            <div class="collapse" id="rate<?= $advert['id'] ?>">
                <?php foreach($methods as $met) { ?>
                <span class="badge bg-info mb-1"><?= $met['code'] ?> Rate: <?= number_format($advert['reward']/$met['price'], 8) ?></span>
                <?php } ?>
            </div>
                    </div>
            <div class="card-footer">
                <button class="btn btn-outline-primary mb-1" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $advert['id'] ?>" aria-expanded="false" aria-controls="collapse<?= $advert['id'] ?>">
                  View
                </button>
            <div class="collapse" id="collapse<?= $advert['id'] ?>">
                <?php foreach($methods as $posts) { ?>   
                    <?php if($user['claims'] < $posts['min_claim']) { ?>
                    <a class="btn btn-danger btn-block mb-2 disabled" href="<?= site_url('ads/view/' . $advert['id'].'/' . strtolower($posts['code'])) ?>">
                        <img class="currency-dashboard" src="<?= site_url('assets/images/currencies/' . strtolower($posts['code']) . '.png') ?>" />
                        <span>View</span>
                    </a>
                    <?php }else{ ?>
                    <a class="btn btn-primary btn-block mb-2" href="<?= site_url('ads/view/' . $advert['id'].'/' . strtolower($posts['code'])) ?>">
                        <img class="currency-dashboard" src="<?= site_url('assets/images/currencies/' . strtolower($posts['code']) . '.png') ?>" />
                        <span>View</span>
                    </a>
                    <?php } ?>
                <?php } ?>
            </div>
            </div>
        </div>
    <?php } ?>
</div>

    <?php if (!count($ptcAds)) {
        echo '<div class="alert alert-warning text-center">There is no Ad left <i class="far fa-sad-cry fa-2x"></i> <i class="far fa-sad-cry fa-2x"></i> <i class="far fa-sad-cry fa-2x"></i></div>';
    }
    ?>

<div class="ads">
  <?= $settings['footer_ad'] ?>
</div> 
</div>
<div class="modal fade" id="advertise" tabindex="-1" role="dialog" aria-labelledby="advertiseLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content text-center">
        <button type="button" class="btn btn-danger btn-sm close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      <div class="modal-body">
          <h4 class="modal-title rounded" id="advertiseLabel"><b>Advertise</b></h4>
                <form action="<?= site_url('/advertise/add') ?>" method="POST">

                    <label>Name</label>
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-globe"></i></span>
                        </div>
                        <input type="text" class="form-control form-control-icon-img" name="name" minlength="1" maxlength="75" autocomplete="off" required>
                    </div>

                    <label>Description</label>
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="far fa-comment-alt"></i>
                            </span>
                        </div>
                        <input type="text" class="form-control form-control-icon-img" name="description" minlength="1" maxlength="75" autocomplete="off" required>
                    </div>

                    <label>Url</label>
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-link"></i>
                            </span>
                        </div>
                        <input type="text" class="form-control form-control-icon-img" name="url" autocomplete="off" required>
                    </div>

                    <label>View</label>
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-eye"></i>
                            </span>
                        </div>
                        <input type="number" class="form-control form-control-icon-img" name="view" min="1" autocomplete="off" required>
                    </div>

                    <div class="form-group">
                        <label for="option">Duration</label>
                        <select class="form-control" id="option" name="option">
                            <?php foreach ($options as $option) { ?>
                                <option value="<?= $option['id'] ?>"><?= $option['timer'] ?> seconds (<?= format_money($option['price']) ?> USD/view, minimum <?= $option['min_view'] ?> views)</option>
                            <?php } ?>
                        </select>
                    </div>
                    <input type="hidden" name="<?= $csrf_name ?>" id="token" value="<?= $csrf_hash ?>">
                    <button type="submit" class="btn btn-success btn-block">Create Campaign</button>
                </form>
        </div>
      </div>
    </div>
  </div>
<div class="modal fade" id="manage" tabindex="-1" role="dialog" aria-labelledby="manageLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content text-center">
        <button type="button" class="btn btn-danger btn-sm close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      <div class="modal-body">
          <h4 class="modal-title rounded" id="manageLabel"><b>Manage your campaigns</b></h4>
                <div class="table-responsive">
                    <table class="table table-striped text-center">
                        <thead>
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Description</th>
                                <th scope="col">Url</th>
                                <th scope="col">Price</th>
                                <th scope="col">Timer</th>
                                <th scope="col">Views</th>
                                <th scope="col">Total View</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($ads as $ad) {
                                echo '
                            <tr>
                            <td scope="row">' . $ad["name"] . '</td>
                            <td>' . $ad["description"] . '</td>
                            <td>' . $ad["url"] . '</td>
                            <td>' . $ad["price"] . '</td>
                            <td>' . $ad["timer"] . '</td>
                            <td>' . $ad["views"] . '</td>
                            <td>' . $ad["total_view"] . '</td>
                            <td>' . $ad["status"] . '</td>
                            <td><a class="btn btn-success btn-sm" href="' . site_url("advertise/start/" . $ad['id']) . '">Start</a>
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#add-' . $ad['id'] . ' ">Add view</button>
<a class="btn btn-warning btn-sm" href="' . site_url("advertise/pause/" . $ad['id']) . '">Pause</a><a class="btn btn-danger btn-sm" href="' . site_url("advertise/delete/" . $ad['id']) . '">Delete</a></td>
                            </tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
      </div>
    </div>
  </div>
</div>
<?php
foreach ($ads as $ad) { ?>

    <div class="modal fade" id="add-<?= $ad['id'] ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
        <button type="button" class="btn btn-danger btn-sm close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Add view to campaign #<?= $ad['id'] ?></h5>
                </div>
                <div class="modal-body">
                    <form action="<?= site_url('advertise/add_view/'.$ad['id']) ?>" method="POST" autocomplete="off">
                        <div class="form-group row mb-4">
                            <input type="hidden" name="<?= $csrf_name ?>" id="token" value="<?= $csrf_hash ?>">
                            <label class="col-sm-3 col-form-label">View</label>
                            <div class="col-sm-9">
                                <input type="number" min="0" max="<?=floor($user['dep_balance']/$ad['price'])?>" class="form-control mb-4" id="view" name="view" required="">
                            </div>
                        </div>

                        <div class="form-group row justify-content-end">
                            <div class="col-sm-9">
                                <div>
                                    <button type="submit" class="btn btn-primary w-md">Add view</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
