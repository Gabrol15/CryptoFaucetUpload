<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body text-center">
                <h4 class="card-title mb-4">Achievements settings</h4>
                <?php
                if (isset($_SESSION['message'])) {
                    echo $_SESSION['message'];
                }
                ?>
                <?php foreach ($achievements as $achievement) { ?>
                    <form action="<?= site_url('admin/achievements/edit/' . $achievement['id']) ?>" method="POST">
                        <input type="hidden" name="<?= $csrf_name ?>" id="token" value="<?= $csrf_hash ?>">
                        <div class="form-row mb-4">
                            <div class="col">
                                <label>For</label>
                                <select class="form-control form-control-sm" name="type">
                                    <option value="1" <?= ($achievement['type'] == 1) ? 'selected' : '' ?>>Shortlinks</option>
                                    <option value="2" <?= ($achievement['type'] == 2) ? 'selected' : '' ?>>PTC</option>
                                </select>
                            </div>
                            <div class="col">
                                <label>Condition</label>
                                <input type="number" name="condition" class="form-control" value="<?= $achievement['condition'] ?>" required="">
                            </div>
                            <div class="col">
                                <label>Usd Reward</label>
                                <input type="number" name="reward_usd" min="0.000001" step="0.000001" class="form-control" value="<?= $achievement['reward_usd'] ?>" required="">
                            </div>
                            <div class="col">
                                <label>Energy Reward</label>
                                <input type="number" name="reward_energy" class="form-control" value="<?= $achievement['reward_energy'] ?>" required="">
                            </div>
                            <div class="col">
                                <label>Actions</label>
                                <div style="display: block;">
                                    <button type="submit" class="btn btn-success btn-sm">Save</button>
                                    <a href="<?= site_url('admin/achievements/delete/' . $achievement['id']) ?>" class="btn btn-danger btn-sm">Delete</a>
                                </div>
                            </div>
                        </div>
                    </form>
                <?php } ?>
                <hr>

                <form action="<?= site_url('admin/achievements/add/') ?>" method="POST">
                    <input type="hidden" name="<?= $csrf_name ?>" id="token" value="<?= $csrf_hash ?>">
                    <div class="form-row mb-4">
                        <div class="col">
                            <label>For</label>
                            <select class="form-control form-control-sm" name="type">
                                <option value="1">Shortlinks</option>
                                <option value="2">PTC</option>
                            </select>
                        </div>
                        <div class="col">
                            <label>Condition</label>
                            <input type="number" name="condition" class="form-control" value="" required="">
                        </div>
                        <div class="col">
                            <label>USD Reward</label>
                            <input type="text" min="0.000001" step="0.000001" name="reward_usd" class="form-control" value="" required="">
                        </div>
                        <div class="col">
                            <label>Energy Reward</label>
                            <input type="number" name="reward_energy" class="form-control" value="" required="">
                        </div>
                        <div class="col">
                            <label>Actions</label>
                            <div style="display: block;">
                                <button type="submit" class="btn btn-success btn-sm">Add</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>