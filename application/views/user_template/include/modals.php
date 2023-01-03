<?php if($settings['achievement_status'] == 'on') { ?>
<div class="modal fade" id="task" tabindex="-1" role="dialog" aria-labelledby="taskLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content text-center">
        <button type="button" class="btn btn-danger btn-sm close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>    
      <div class="modal-body">
          <h4 class="modal-title rounded" id="taskLabel"><b>Daily Task</b></h4>
                <?= faucet_alert('info', 'Progress will refresh at 00:00 UTC daily') ?>
                <div class="table-responsive">
                    <table class="table table-centered">
                        <thead>
                            <tr>
                                <th>Task</th>
                                <th>Reward</th>
                                <th>Progress</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($achievements as $achievement) { ?>
                                <tr>
                                    <td><?= $achievement['description'] ?></td>
                                    <td>
                                        <span class="text-primary fw-bold"><i class="fas fa-money-bill"></i> : +<?= format_money($achievement['reward_usd']) ?> USD</span>
                                        <span class="text-warning fw-bold"><i class="fas fa-bolt"></i> : +<?= $achievement['reward_energy'] ?></span>
                                    </td>
                                    <td>
                                        <div class="progress" style="height: 20px;">
                                            <div class="progress-bar" role="progressbar" style="width: <?= $achievement['progress'] ?>%;" aria-valuenow="<?= $achievement['progress'] ?>" aria-valuemin="0" aria-valuemax="100"><?= $achievement['completed'] ?>/ <?= $achievement['condition'] ?></div>
                                        </div>
                                    </td>
                                    <td>
                                        <form action="<?= site_url('achievements/claim/' . $achievement['id']) ?>" method="POST">
                                            <input type="hidden" name="<?= $csrf_name ?>" value="<?= $csrf_hash ?>">
                                            <?php if ($achievement['completed'] >= $achievement['condition']) { ?>
                                                <button type="submit" class="btn rounded btn-primary">Claim</i></button>
                                            <?php } else { ?>
                                                <button type="submit" class="btn rounded btn-primary disabled">Claim</button>
                                            <?php } ?>
                                        </form>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
      </div>
    </div>
  </div>
</div>
<?php } ?>
<div class="modal fade" id="withdraw" tabindex="-1" role="dialog" aria-labelledby="withdrawLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content text-center">
        <button type="button" class="btn btn-danger btn-sm close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>    
      <div class="modal-body">
          <h4 class="modal-title rounded" id="withdrawLabel"><b>Withdraw Account Balance</b></h4>
        <div class="card card-body bg-light">
            <small>Minimum Account Balance Withdraw is: <?= $settings['min_wd'] ?> USD</small>
            <p><b>Account Balance: <?= format_money($user['balance']) ?> USD</b></p>
            <form action="<?= site_url('withdraw') ?>" method="POST">
                <input type="hidden" name="<?= $csrf_name ?>" id="token" value="<?= $csrf_hash ?>">
                <input type="hidden" name="token" value="<?= $user['token'] ?>">
                <div class="form-group">
                <input type="number" class="form-control" name="amount" min="0.0001" step="0.0001" value="<?= format_money($user['balance']) ?>" required>
                <?php foreach($methods as $method) { ?>
                    <div class="form-check form-check-radio form-check-inline">
                      <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="currency" id="inlineRadio<?= $method['id'] ?>" value="<?= $method['code'] ?>" required> <?= $method['name'] ?>
                        <span class="form-check-sign"></span>
                      </label>
                    </div>
                <?php } ?>

                </div>
                <button type="submit" class="btn btn-info btn-round">Withdraw</button>
            </form>
        </div>
      </div>
    </div>
  </div>
</div>