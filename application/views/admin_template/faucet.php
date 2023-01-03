<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Faucet settings</h4>
                <?php
                if (isset($_SESSION['message'])) {
                    echo $_SESSION['message'];
                }
                ?>
                <form action="<?= site_url('admin/update/faucet') ?>" method="POST">
                
                    <div class="form-group row mb-4">
                        <label class="col-sm-3 col-form-label">Antibotlinks</label>
                        <div class="col-sm-9">
                            <select class="form-control form-control-sm" name="antibotlinks" id="antibotlinks">
                                <option value="on" <?= ($settings['antibotlinks'] == 'on') ? 'selected' : '' ?>>On</option>
                                <option value="off" <?= ($settings['antibotlinks'] == 'off') ? 'selected' : '' ?>>Off</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-sm-3 col-form-label">Top ad</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" rows="6" name="top_ad"><?= $settings['top_ad'] ?></textarea>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-sm-3 col-form-label">Left ad</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" rows="6" name="left_ad"><?= $settings['left_ad'] ?></textarea>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-sm-3 col-form-label">Right ad</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" rows="6" name="right_ad"><?= $settings['right_ad'] ?></textarea>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-sm-3 col-form-label">Footer ad</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" rows="6" name="footer_ad"><?= $settings['footer_ad'] ?></textarea>
                        </div>
                    </div>
                    <input type="hidden" name="<?= $csrf_name ?>" value="<?= $csrf_hash ?>">

                    <div class="form-group row justify-content-end">
                        <div class="col-sm-9">
                            <div>
                                <button type="submit" class="btn btn-primary w-md">Update</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>