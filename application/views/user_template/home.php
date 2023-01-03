  <!-- ======= Hero Section ======= -->
  <section id="hero" class="d-flex flex-column justify-content-center">
    <div class="container" data-aos="zoom-in" data-aos-delay="100">
      <h1><?= $settings['name']; ?></h1>
      <p><span class="typed" data-typed-items="High Paying, Instant Withdraw"></span></p>
      <p class="mb-2"><?= $settings['description']; ?></p>
        <a class="btn btn-primary" href="<?= site_url('login'); ?>">Login</a>
        <a class="btn btn-secondary" href="<?= site_url('register'); ?>">Register</a>
      <div class="social-links">
          <h5>Supported Currencies</h5>
          <?php foreach($methods as $method) { ?> 
            <?php echo ' <img width="50" height="50" src="'.site_url().'assets/images/currencies/' . strtolower($method['code']) . '.png">' ?>
          <?php } ?>
      </div>
    </div>
  </section>
  <!-- End Hero -->

  <main id="main">
    <!-- ======= User Section ======= -->
    <section id="user" class="facts">
      <div class="container" data-aos="fade-up">
        <div class="section-title">
          <h2>User Statistics</h2>
        </div>

        <div class="row">

          <div class="col-md-4">
            <div class="count-box">
              <i class="bi bi-emoji-smile"></i>
              <span data-purecounter-start="0" data-purecounter-end="<?= $totaluser ?>" data-purecounter-duration="1" class="purecounter"></span>
              <p>Happy Users</p>
            </div>
          </div>

          <div class="col-md-4 mt-5 mt-md-0">
            <div class="count-box">
              <i class="bx bx-wallet"></i>
              <span data-purecounter-start="0" data-purecounter-end="<?= $totalwd ?>" data-purecounter-duration="1" class="purecounter"></span>
              <p>Claims Made</p>
            </div>
          </div>

          <div class="col-md-4 mt-5 mt-lg-0">
            <div class="count-box">
              <i class="bx bx-money"></i>
              <span data-purecounter-start="0" data-purecounter-end="<?= format_money($totalearn) ?>" data-purecounter-duration="1" class="purecounter"></span>
              <p>USD Earned</p>
            </div>
          </div>

        </div>

      </div>
    </section><!-- End User Section -->

    <!-- ======= Features Section ======= -->
    <section id="features" class="services">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2>Our features</h2>
        </div>

        <div class="row">
          <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4" data-aos="zoom-in" data-aos-delay="100">
            <div class="icon-box iconbox-blue">
              <div class="icon">
                <svg width="100" height="100" viewBox="0 0 600 600" xmlns="http://www.w3.org/2000/svg">
                  <path stroke="none" stroke-width="0" fill="#f5f5f5" d="M300,541.5067337569781C382.14930387511276,545.0595476570109,479.8736841581634,548.3450877840088,526.4010558755058,480.5488172755941C571.5218469581645,414.80211281144784,517.5187510058486,332.0715597781072,496.52539010469104,255.14436215662573C477.37192572678356,184.95920475031193,473.57363656557914,105.61284051026155,413.0603344069578,65.22779650032875C343.27470386102294,18.654635553484475,251.2091493199835,5.337323636656869,175.0934190732945,40.62881213300186C97.87086631185822,76.43348514350839,51.98124368387456,156.15599469081315,36.44837278890362,239.84606092416172C21.716077023791087,319.22268207091537,43.775223500013084,401.1760424656574,96.891909868211,461.97329694683043C147.22146801428983,519.5804099606455,223.5754009179313,538.201503339737,300,541.5067337569781"></path>
                </svg>
                <i class="bx bx-coin"></i>
              </div>
              <h4>Claim Faucet</h4>
                <p class="text-center">
                    We provide free claims in different currencies, and each claim will be sent directly to your FaucetPay address.
                </p>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4" data-aos="zoom-in" data-aos-delay="200">
            <div class="icon-box iconbox-orange ">
              <div class="icon">
                <svg width="100" height="100" viewBox="0 0 600 600" xmlns="http://www.w3.org/2000/svg">
                  <path stroke="none" stroke-width="0" fill="#f5f5f5" d="M300,541.5067337569781C382.14930387511276,545.0595476570109,479.8736841581634,548.3450877840088,526.4010558755058,480.5488172755941C571.5218469581645,414.80211281144784,517.5187510058486,332.0715597781072,496.52539010469104,255.14436215662573C477.37192572678356,184.95920475031193,473.57363656557914,105.61284051026155,413.0603344069578,65.22779650032875C343.27470386102294,18.654635553484475,251.2091493199835,5.337323636656869,175.0934190732945,40.62881213300186C97.87086631185822,76.43348514350839,51.98124368387456,156.15599469081315,36.44837278890362,239.84606092416172C21.716077023791087,319.22268207091537,43.775223500013084,401.1760424656574,96.891909868211,461.97329694683043C147.22146801428983,519.5804099606455,223.5754009179313,538.201503339737,300,541.5067337569781"></path>
                </svg>
                <i class="bx bxs-bolt-circle"></i>
              </div>
              <h4>Auto Claim Faucet</h4>
                <p class="text-center">
                    Gather energy, then relax by letting Auto Claim run, get paid to your FaucetPay account automatically.
                </p>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4" data-aos="zoom-in" data-aos-delay="300">
            <div class="icon-box iconbox-pink">
              <div class="icon">
                <svg width="100" height="100" viewBox="0 0 600 600" xmlns="http://www.w3.org/2000/svg">
                  <path stroke="none" stroke-width="0" fill="#f5f5f5" d="M300,541.5067337569781C382.14930387511276,545.0595476570109,479.8736841581634,548.3450877840088,526.4010558755058,480.5488172755941C571.5218469581645,414.80211281144784,517.5187510058486,332.0715597781072,496.52539010469104,255.14436215662573C477.37192572678356,184.95920475031193,473.57363656557914,105.61284051026155,413.0603344069578,65.22779650032875C343.27470386102294,18.654635553484475,251.2091493199835,5.337323636656869,175.0934190732945,40.62881213300186C97.87086631185822,76.43348514350839,51.98124368387456,156.15599469081315,36.44837278890362,239.84606092416172C21.716077023791087,319.22268207091537,43.775223500013084,401.1760424656574,96.891909868211,461.97329694683043C147.22146801428983,519.5804099606455,223.5754009179313,538.201503339737,300,541.5067337569781"></path>
                </svg>
                <i class="bx bx-link"></i>
              </div>
              <h4>Shortlinks</h4>
                <p class="text-center">
                    Complete shortlinks, and get paid, we pay high for shortlinks, prepare your coffee and relax completing shortlinks.
                </p>
            </div>
          </div>
          
          <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4" data-aos="zoom-in" data-aos-delay="400">
            <div class="icon-box iconbox-teal">
              <div class="icon">
                <svg width="100" height="100" viewBox="0 0 600 600" xmlns="http://www.w3.org/2000/svg">
                  <path stroke="none" stroke-width="0" fill="#f5f5f5" d="M300,541.5067337569781C382.14930387511276,545.0595476570109,479.8736841581634,548.3450877840088,526.4010558755058,480.5488172755941C571.5218469581645,414.80211281144784,517.5187510058486,332.0715597781072,496.52539010469104,255.14436215662573C477.37192572678356,184.95920475031193,473.57363656557914,105.61284051026155,413.0603344069578,65.22779650032875C343.27470386102294,18.654635553484475,251.2091493199835,5.337323636656869,175.0934190732945,40.62881213300186C97.87086631185822,76.43348514350839,51.98124368387456,156.15599469081315,36.44837278890362,239.84606092416172C21.716077023791087,319.22268207091537,43.775223500013084,401.1760424656574,96.891909868211,461.97329694683043C147.22146801428983,519.5804099606455,223.5754009179313,538.201503339737,300,541.5067337569781"></path>
                </svg>
                <i class="bx bx-broadcast"></i>
              </div>
              <h4>Paid to click</h4>
                <p class="text-center">
                    Our advertisers pay you to see their ads, you only need to take about 1 minute to get paid.
                </p>
            </div>
          </div>
          
          <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4" data-aos="zoom-in" data-aos-delay="500">
            <div class="icon-box iconbox-yellow">
              <div class="icon">
                <svg width="100" height="100" viewBox="0 0 600 600" xmlns="http://www.w3.org/2000/svg">
                  <path stroke="none" stroke-width="0" fill="#f5f5f5" d="M300,541.5067337569781C382.14930387511276,545.0595476570109,479.8736841581634,548.3450877840088,526.4010558755058,480.5488172755941C571.5218469581645,414.80211281144784,517.5187510058486,332.0715597781072,496.52539010469104,255.14436215662573C477.37192572678356,184.95920475031193,473.57363656557914,105.61284051026155,413.0603344069578,65.22779650032875C343.27470386102294,18.654635553484475,251.2091493199835,5.337323636656869,175.0934190732945,40.62881213300186C97.87086631185822,76.43348514350839,51.98124368387456,156.15599469081315,36.44837278890362,239.84606092416172C21.716077023791087,319.22268207091537,43.775223500013084,401.1760424656574,96.891909868211,461.97329694683043C147.22146801428983,519.5804099606455,223.5754009179313,538.201503339737,300,541.5067337569781"></path>
                </svg>
                <i class="bx bx-user-check"></i>
              </div>
              <h4>Affiliate</h4>
                <p class="text-center">
                    Invite your relatives and friends to join and earn with us, get <?= $settings['referral'] ?>% commission of their earnings.
                </p>
            </div>
          </div>
          
          <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4" data-aos="zoom-in" data-aos-delay="500">
            <div class="icon-box iconbox-red">
              <div class="icon">
                <svg width="100" height="100" viewBox="0 0 600 600" xmlns="http://www.w3.org/2000/svg">
                  <path stroke="none" stroke-width="0" fill="#f5f5f5" d="M300,541.5067337569781C382.14930387511276,545.0595476570109,479.8736841581634,548.3450877840088,526.4010558755058,480.5488172755941C571.5218469581645,414.80211281144784,517.5187510058486,332.0715597781072,496.52539010469104,255.14436215662573C477.37192572678356,184.95920475031193,473.57363656557914,105.61284051026155,413.0603344069578,65.22779650032875C343.27470386102294,18.654635553484475,251.2091493199835,5.337323636656869,175.0934190732945,40.62881213300186C97.87086631185822,76.43348514350839,51.98124368387456,156.15599469081315,36.44837278890362,239.84606092416172C21.716077023791087,319.22268207091537,43.775223500013084,401.1760424656574,96.891909868211,461.97329694683043C147.22146801428983,519.5804099606455,223.5754009179313,538.201503339737,300,541.5067337569781"></path>
                </svg>
                <i class="bx bx-task"></i>
              </div>
              <h4>Daily Achievement</h4>
                <p class="text-center">
                    Complete daily Achievement with different missions and get rewards  to earn more.
                </p>
            </div>
          </div>
          
        </div>
      </div>
    </section><!-- End Features Section -->

    <!-- ======= Terms Section ======= -->
    <section id="terms" class="section-bg">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2>Terms and Conditions</h2>
          <p>By using any of the Services or signing up to use an account through <?= $settings['name']; ?> (the “Website”) or any of our associated websites (including, without limitation, the technology and the platform integrated therein), Chats and/or any and all related applications (collectively, the “<?= $settings['name']; ?> Site”), you agree that you have read, understood and accept all of the terms and conditions contained in this Agreement, as well as all of the terms and conditions of our Privacy Policy which is hereby incorporated by reference and forms part of this Agreement.</p>
        </div>
     <h4>1. User Account</h4>
     <hr> 
          <ol>
      <li>You are not allowed to register or use your account throught proxy, vpn's, hide my "ass", Lan Groups, Internet caffe, etc.</li>
      <br> 
      <li>You are not allowed to create or use multiple accounts, use fake infos or share theirs payment processors between them and others members.</li>
      <br> 
      <li>You are not allowed to login more than one account on the same computer or IP address. This includes family, friends, co-workers and using your account on public computers.</li>
      <br> 
      <li>You are not allowed to use any VPS / Proxy server to access or use this website. We expect you to use this website from your personal device, using your real IP address. If you use VPS / Proxy Server, your payout request will be rejected and your account will be suspended.</li>
      <br> 
      <li>Any attempts to overload our server will lead to the permanent suspension of your account.</li>
      <br> 
      <li>If you bring directly or indirectly any kind of prejudicial to our website, his owner and to the staff team will lead to the permanent suspension of your account.</li>
     </ol>
     <hr> 
     <h4>2. Referrals</h4>
     <hr> 
     <ol>
      <li>You are allowed to refer an unlimited number of members.</li>
      <br> 
      <li>We dont allow using services that are selling referrals, our staff will verify and if you account will be suspected of breaking this rulle, this will lead to the permanent suspension of your account.</li>
      <br> 
      <li>You agree not to be compensated by the loss of any referrals referred by inactivity which they maybe either deleted or suspended by inactivity.</li>
      <br> 
      <li>You are never allowed to change your upline which will remain private.</li> 
     </ol>
     <hr> 
     <h4>3. Payments &amp; Purchase</h4>
     <hr> 
     <ol>
      <li>All your orders are final and non refundable.</li>
      <br> 
      <li>All payments should be done through our website only.</li>
     
     </ol>
     <hr> 

     <h4>4. Refund Policy</h4>
     <hr> 
     <ol>
     <li>The purchase of any Subscription from this website are non-refundable.</li>
     </ol>
     <hr> 
     <h4>5. Anticheat &amp; Account Suspension</h4>
     <hr> 
     <ol>
      <li>You should know that each time you wanna do a "fishy" and "happy" thing our system will save this log.</li>
      <br> 
      <li>You should know that if you try to "hack", "sql injection", "xss passthrought" and others "happy" things this will lead to the permanent suspension of your account.</li>
      <br> 
      <li>You must not Interfere with our system to prevent optimum security and/or reliability.</li>
      <br> 
      <li>We reserve the rights to give to suspend your account for any valid reason from our tos, or related to it.</li>
      <br> 
      <li>If your account is suspended for any reasson you cannot ask a refund, your account will be "wiped" (stats, referrals).</li>
      <br> 
      <li>You may not create or use any type of emulator, or a program to automate the process of clicking.</li>
     </ol>
     <hr> 
     <h4>6. Liability</h4>
     <hr> 
     <ol>
      <li>We won't be liable or any kind of delays or failures that are not directly related to us and therefore beyond our control.</li>
      <br> 
      <li>We won't be held responsible for any of its users, advertisers or advertisements, this include every 3rd party company we depend.</li>
      <br> 
      <li>We are not responsable for any tax payment for you on what you receive from us. Is your responsability to declare what you've received and pay your country taxes.</li>
      <br> 
      <li>We upon request can suspend your account if you dont agree our terms and your account will be suspended.</li>
      <br> 
      <li>We are not responsable for the investments you make.</li>
      <br> 
      <li>We are not responsable for the activity of Direct, Rented Referrals, and by buying or renting them you are fully aware of that.</li>
      <br> 
      <li>We have the right to change this agreement without any prior notice to our members, we will send out a notice to all of our members the new terms and/or terms that have changed.</li>
     </ol>
      </div>
    </section><!-- End Portfolio Section -->
