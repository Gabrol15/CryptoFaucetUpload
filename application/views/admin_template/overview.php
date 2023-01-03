<div class="row">
    <div class="col-md-4 mb-3 mb-xl-3">
        <div class="card">
            <div class="card-body">
                <div class="media">
                    <div class="media-body">
                        <p class="lh-1 mb-1 font-weight-bold"><?= $info['totalUser'] ?></p>
                        <p class="mb-0">users</p>
                    </div>
                    <div class="align-self-center">
                            <i class="fas fa-users fa-2x text-primary"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3 mb-xl-3">
        <div class="card">
            <div class="card-body">        
                <div class="media">
                    <div class="media-body">
                        <p class="lh-1 mb-1 font-weight-bold"><?= $info['activeToday'] ?></p>
                        <p class="mb-0">users active today</p>
                    </div>
                    <div class="align-self-center">
                            <i class="fas fa-user-check text-primary fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>                
    </div>
    <div class="col-md-4 mb-3 mb-xl-3">
        <div class="card">
            <div class="card-body">        
                <div class="media">
                    <div class="media-body">
                        <p class="lh-1 mb-1 font-weight-bold"><?= $info['registerToday'] ?></p>
                        <p class="mb-0">new users today</p>
                    </div>

                    <div class="align-self-center">
                            <i class="fas fa-user-plus fa-2x text-primary"></i>
                    </div>
                </div>
            </div>
        </div>                
    </div>
</div>
<div class="layout-px-spacing">
    <div class="row layout-top-spacing">
        <div class="col-md-6">
            <!-- begin general -->
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">General Settings</h3>
                    <?php
                    if (isset($_SESSION['message'])) {
                        echo $_SESSION['message'];
                    }
                    ?>
                </div>
                <div class="card-body">
                    <form action="<?= site_url('admin/update/overview') ?>" method="post">
                        <div class="form-group">
                            <label for="status">Website Status(off for maintenance)</label>
                            <select class="form-control" name="status">
                                <option value="on" <?= ($settings['status'] == 'on') ? 'selected' : '' ?>>On</option>
                                <option value="off" <?= ($settings['status'] == 'off') ? 'selected' : '' ?>>Off</option>
                            </select>
                        </div>
                    <div class="form-group">
                        <label for="PTC status">PTC status</label>
                            <select class="form-control" name="ptc_status">
                                <option value="on" <?= ($settings['ptc_status'] == 'on') ? 'selected' : '' ?>>On</option>
                                <option value="off" <?= ($settings['ptc_status'] == 'off') ? 'selected' : '' ?>>Off</option>
                            </select>
                    </div>
                   <div class="form-group">
                        <label for="Shortlink status">Shortlink status</label>
                            <select class="form-control" name="shortlink_status">
                                <option value="on" <?= ($settings['shortlink_status'] == 'on') ? 'selected' : '' ?>>On</option>
                                <option value="off" <?= ($settings['shortlink_status'] == 'off') ? 'selected' : '' ?>>Off</option>
                            </select>
                    </div>
                    <div class="form-group">
                        <label for="Autofaucet status">Autofaucet status</label>
                            <select class="form-control" name="autofaucet_status">
                                <option value="on" <?= ($settings['autofaucet_status'] == 'on') ? 'selected' : '' ?>>On</option>
                                <option value="off" <?= ($settings['autofaucet_status'] == 'off') ? 'selected' : '' ?>>Off</option>
                            </select>
                    </div>
                    <div class="form-group">
                        <label for="Achievement status">Achievement status</label>
                            <select class="form-control" name="achievement_status">
                                <option value="on" <?= ($settings['achievement_status'] == 'on') ? 'selected' : '' ?>>On</option>
                                <option value="off" <?= ($settings['achievement_status'] == 'off') ? 'selected' : '' ?>>Off</option>
                            </select>
                    </div>
                        <div class="form-group">
                            <label for="Faucet Name">Faucet Name</label>
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-globe-asia"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="name" value="<?= $settings['name'] ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Faucet Description</label>
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="far fa-newspaper"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="description" value="<?= $settings['description'] ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Admin Username</label>
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="admin_username" value="<?= $settings['admin_username'] ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Minimum Balance Withdraw (USD)</label>
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-users"></i></span>
                                    </div>
                                    <input type="number" class="form-control" name="min_wd" value="<?= $settings['min_wd'] ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Referral Comission (%)</label>
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-users"></i></span>
                                    </div>
                                    <input type="number" class="form-control" name="referral" value="<?= $settings['referral'] ?>">
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="<?= $csrf_name ?>" value="<?= $csrf_hash ?>" />
                        <button class="btn btn-success btn-lg btn-block" name="overview"><i class="fas fa-check"></i> Update</button>
                    </form>
                </div>
            </div>
            <!-- end general -->
            <!-- begin email -->
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Email Settings</h3>
                    <?php
                    if (isset($_SESSION['message'])) {
                        echo $_SESSION['message'];
                    }
                    ?>
                </div>
                <div class="card-body">
                    <form action="<?= site_url('admin/update/overview') ?>" method="post">
                        <div class="form-group">
                            <label for="email_confirmation"><i class="far fa-envelope"></i> Email Confirmation</label>
                            <select class="form-control" name="email_confirmation">
                                <option value="on" <?= ($settings['email_confirmation'] == 'on') ? 'selected' : '' ?>>on</option>
                                <option value="off" <?= ($settings['email_confirmation'] == 'off') ? 'selected' : '' ?>>off</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="mail_service"><i class="far fa-envelope"></i> Email Service</label>
                            <select class="form-control" name="mail_service">
                                <option value="mail" <?= ($settings['mail_service'] == 'mail') ? 'selected' : '' ?>>Mail Function</option>
                                <option value="smtp" <?= ($settings['mail_service'] == 'smtp') ? 'selected' : '' ?>>SMTP</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label">SMTP Host (If you are using SMTP mail)</label>
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-server"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="smtp_host" value="<?= $settings['smtp_host'] ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">SMTP Port (If you are using SMTP mail)</label>
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-network-wired"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="smtp_port" value="<?= $settings['smtp_port'] ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">SMPT Username (If you are using SMTP mail)</label>
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="far fa-user"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="smtp_username" value="<?= $settings['smtp_username'] ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">SMTP Password (If you are using SMTP mail)</label>
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                                    </div>
                                    <input type="password" class="form-control" name="smtp_password" value="<?= $settings['smtp_password'] ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Site Email</label>
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">@</span>
                                    </div>
                                    <input type="email" class="form-control" name="site_email" value="<?= $settings['site_email'] ?>">
                                </div>
                            </div>
                        </div>
                        <small>It should be admin@yourfauceturl.com</small>
                        <div class="form-group">
                            <label class="control-label">Admin Email</label>
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">@</span>
                                    </div>
                                    <input type="email" class="form-control" name="admin_email" value="<?= $settings['admin_email'] ?>">
                                </div>
                            </div>
                        </div>
                        <small>Your personal email address.</small>
                        <input type="hidden" name="<?= $csrf_name ?>" value="<?= $csrf_hash ?>" />
                        <button class="btn btn-success btn-lg btn-block" name="overview"><i class="fas fa-check"></i> Update</button>
                    </form>
                </div>
            </div>
            <!-- end general -->

        </div>
        <div class="col-md-6">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Security Settings</h3>
                </div>
                <div class="card-body">
                    <form action="<?= site_url('admin/update/overview') ?>" method="post">
                        <div class="form-group">
                            <label for="firewall"><i class="fas fa-shield-alt"></i> Firewall</label>
                            <select class="form-control" name="firewall">
                                <option value="on" <?= ($settings['firewall'] == 'on') ? 'selected' : '' ?>>On</option>
                                <option value="off" <?= ($settings['firewall'] == 'off') ? 'selected' : '' ?>>Off</option>
                            </select>
                        </div>
                        <small>User has to solve a random captcha after 25-30 minutes!</small>
                        <hr>
                        <div class="form-group">
                            <label for="proxy_detection"><i class="fas fa-shield-alt"></i> Proxy Detection</label>
                            <select class="form-control" name="proxy_detection">
                                <option value="on" <?= ($settings['proxy_detection'] == 'on') ? 'selected' : '' ?>>On</option>
                                <option value="off" <?= ($settings['proxy_detection'] == 'off') ? 'selected' : '' ?>>Off</option>
                            </select>
                        </div>
                        <small>Proxy detection doesn't need API, and unlimited use! <b>Note: don't use with cloudflare</b></small>
                        <hr>
                        <div class="form-group">
                            <label class="control-label">Captcha fail limit</label>
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-robot"></i></span>
                                    </div>
                                    <input type="number" class="form-control" name="captcha_fail_limit" value="<?= $settings['captcha_fail_limit'] ?>" required>
                                </div>
                            </div>
                        </div>
                        <small>Users are banned if they make too many captcha fails in a row.</small>
                        <hr>
                        <p>Availabe captcha systems: <code>recaptchav3</code>|<code>recaptchav2</code>|<code>solvemedia</code>|<code>hcaptcha</code>, each captcha seperated by <code>|</code></p>

                        <div class="form-group">
                            <label class="control-label">Faucet Captcha</label>
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-globe-asia"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="faucet_captcha" value="<?= $settings['faucet_captcha'] ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Login Captcha</label>
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-globe-asia"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="login_captcha" value="<?= $settings['login_captcha'] ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Recaptcha V3 Site Key</label>
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-globe-asia"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="recaptcha_v3_site_key" value="<?= $settings['recaptcha_v3_site_key'] ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Recaptcha V3 Secret Key</label>
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-globe-asia"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="recaptcha_v3_secret_key" value="<?= $settings['recaptcha_v3_secret_key'] ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Recaptcha V2 Site Key (Don't work along with Hcaptcha)</label>
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-globe-asia"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="recaptcha_v2_site_key" value="<?= $settings['recaptcha_v2_site_key'] ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Recaptcha V2 Secret Key</label>
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-globe-asia"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="recaptcha_v2_secret_key" value="<?= $settings['recaptcha_v2_secret_key'] ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Hcaptcha Site Key (Don't work along with Recaptcha V2)</label>
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-globe-asia"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="hcaptcha_site_key" value="<?= $settings['hcaptcha_site_key'] ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Hcaptcha Secret Key</label>
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-globe-asia"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="hcaptcha_secret_key" value="<?= $settings['hcaptcha_secret_key'] ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Solvemedia C Key</label>
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-globe-asia"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="c_key" value="<?= $settings['c_key'] ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Solvemedia V Key</label>
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-globe-asia"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="v_key" value="<?= $settings['v_key'] ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Solvemedia H Key</label>
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-globe-asia"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="h_key" value="<?= $settings['h_key'] ?>">
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="<?= $csrf_name ?>" value="<?= $csrf_hash ?>" />
                        <button class="btn btn-success btn-lg btn-block" name="overview"><i class="fas fa-check"></i> Update</button>
                    </form>
                </div>
            </div>

            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Admin Login</h3>
                </div>
                <div class="card-body">
                    <form action="<?= site_url('admin/update/overview') ?>" method="POST">
                        <div class="form-group">
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="far fa-user"></i></span>
                                    </div>
                                    <input type="text" name="username" class="form-control" value="<?= $settings['username'] ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    </div>
                                    <input type="password" name="password" class="form-control" value="" required>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="<?= $csrf_name ?>" value="<?= $csrf_hash ?>" />
                        <button class="btn btn-success btn-lg btn-block" name="overview"><i class="fas fa-check"></i> Update</button>
                    </form>
                </div>
            </div>
            <!-- end services -->
        </div>

    </div>

</div>