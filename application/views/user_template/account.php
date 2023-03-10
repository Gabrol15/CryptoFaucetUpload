<div class="container">
    <div class="text-center mb-3">
        <div class="section-title">
           <h2><a href="<?= base_url('dashboard') ?>" alt="Back"><span><i class="fas fa-arrow-alt-circle-left"></i></span></a> <?= $page ?></h2>    
        </div>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Change password</h4>
                <form action="<?= site_url('account/update_password') ?>" method="POST">
                    <div class="form-group row mb-4">
                        <input type="hidden" name="<?= $csrf_name ?>" id="token" value="<?= $csrf_hash ?>">
                        <label class="col-sm-3 col-form-label">Current password</label>
                        <div class="col-sm-9">
                            <input type="password" class="form-control mb-4" id="old-password" name="old_password" required="">
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label for="horizontal-email-input" class="col-sm-3 col-form-label">New password</label>
                        <div class="col-sm-9">
                            <input type="password" class="form-control mb-4" id="new-password" name="password" required="">
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label for="horizontal-password-input" class="col-sm-3 col-form-label">Confirm new password</label>
                        <div class="col-sm-9">
                            <input type="password" class="form-control mb-4" id="confirm-new-password" name="confirm_password" required="">
                        </div>
                    </div>

                    <div class="form-group row justify-content-end">
                        <div class="col-sm-9">
                            <div>
                                <button type="submit" class="btn btn-primary w-md">Change</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>