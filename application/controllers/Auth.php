<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->helper('string');
		$this->load->model('m_auth');
		$this->load->library('user_agent');
		$this->data = $this->m_core->getSettings();
	}
	public function index()
	{
	}
	public function register()
	{
	if($this->data['proxy_detection'] == 'on') {
        if ($this->agent->is_browser()){
                $agent = $this->agent->browser().' '.$this->agent->version();
        }elseif ($this->agent->is_robot()){
                $agent = $this->agent->robot();
        }elseif ($this->agent->is_mobile()){
                $agent = $this->agent->mobile();
        }else{
                $agent = 'Unidentified User Agent';
        }
        
        $proxy = check_ip($this->input->ip_address(), $agent);
        if($proxy) {
            $this->session->set_flashdata('message', faucet_alert('danger', 'Proxy Detected!'));
			return redirect(site_url('register'));
        }
	}
//Getting Country, City, Region, Map Location and Internet Service Provider
$url1 = 'https://ipapi.co/' . $this->input->ip_address() . '/json/';
$ch  = curl_init();
curl_setopt($ch, CURLOPT_URL, $url1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
curl_setopt($ch, CURLOPT_ENCODING, 'gzip,deflate');
curl_setopt($ch, CURLOPT_USERAGENT, $agent);
curl_setopt($ch, CURLOPT_REFERER, "https://google.com");
$ipcontent = curl_exec($ch);
curl_close($ch);

$ip_data = @json_decode($ipcontent);
if ($ip_data && !isset($ip_data->{'error'})) {
    $country      = $ip_data->{'country_name'};
    $country_code = $ip_data->{'country_code'};
    $region       = $ip_data->{'region'};
    $city         = $ip_data->{'city'};
    $latitude     = $ip_data->{'latitude'};
    $longitude    = $ip_data->{'longitude'};
    $isp          = $ip_data->{'org'};
    $iso          = $ip_data->{'country_code_iso3'};
} else {
    $country      = "Unknown";
    $country_code = "XX";
    $region       = "Unknown";
    $city         = "Unknown";
    $latitude     = "0";
    $longitude    = "0";
    $isp          = "Unknown";
    $iso          = "N/A";
}
		$captcha = $this->input->post('captcha');
		$Check_captcha = false;
		setcookie('captcha', $captcha, time() + 86400 * 10);
		switch ($captcha) {
			case "recaptchav3":
				$Check_captcha = verifyRecaptchaV3($this->input->post('recaptchav3'), $this->data['recaptcha_v3_secret_key']);
				break;
			case "recaptchav2":
				$Check_captcha = verifyRecaptchaV2($this->input->post('g-recaptcha-response'), $this->data['recaptcha_v2_secret_key']);
				break;
			case "solvemedia":
				$Check_captcha = verifySolvemedia($this->data['v_key'], $this->data['h_key'], $this->input->ip_address(), $this->input->post('adcopy_challenge'), $this->input->post('adcopy_response'));
				break;
			case "hcaptcha":
				$Check_captcha = verifyHcaptcha($this->input->post('h-captcha-response'), $this->data['hcaptcha_secret_key'], $this->input->ip_address());
				break;
		}
		if (!$Check_captcha) {
			$this->session->set_flashdata('message', faucet_alert('danger', 'Invalid Captcha'));
			return redirect(site_url('register'));
		}

		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|max_length[75]|is_unique[users.email]', array('is_unique' => 'This email is registered with another account'));
		$this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[4]|max_length[15]|is_unique[users.username]', array('is_unique' => 'This username already exists'));
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[3]|md5');
		$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]|md5');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('message', faucet_alert('danger', validation_errors()));
			return redirect(site_url('register'));
		}
		if (!preg_match("/^[a-zA-Z]{1,1}[a-zA-Z0-9_]{2,13}[a-zA-Z0-9]{1,1}+$/", $this->input->post('username')) || strpos(strtolower($this->input->post('username')), 'admin')) {
			$this->session->set_flashdata('message', faucet_alert('danger', 'Invalid username'));
			return redirect(site_url('register'));
		}

		if ($this->m_auth->multiple_account()) {
			$this->session->set_flashdata('message', faucet_alert('danger', 'You are not allowed to create multiple accounts!'));
			return redirect(site_url('register'));
		}

		$email = $this->db->escape_str($this->input->post('email'));
		$username = $this->db->escape_str($this->input->post('username'));
		$password = $this->db->escape_str($this->input->post('password'));
		$active_keys = random_string('alnum', 30);

		// referral
		if (!empty($_SESSION['referral'])) {
			$referral = $_SESSION['referral'];
			if (!is_numeric($referral)) {
				$referral = 0;
			} else {
				$referral = $this->db->escape_str($referral);
				if (!$this->m_auth->valid_referral($referral)) {
					$referral = 0;
				}
				unset($_SESSION['referral']);
			}
		} else {
			$referral = 0;
		}

		$referralSource = 'direct';
		if (isset($_COOKIE['Referral_Source']) && filter_var($_COOKIE['Referral_Source'], FILTER_VALIDATE_URL)) {
			$referralSource = $this->db->escape_str($_COOKIE['Referral_Source']);
		}
		
	if($this->data["email_confirmation"] == 'on') {
		$siteName = $this->data['name'];
		$activeUrl = site_url('/active/' . $active_keys);
		$message = <<<EOT
			<table class="body-wrap" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: transparent; margin: 0;">
			<tbody><tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
			<td style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;" valign="top"></td>
			<td class="container" width="600" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;" valign="top">
				<div class="content" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; max-width: 600px; display: block; margin: 0 auto; padding: 20px;">
					<table class="main" width="100%" cellpadding="0" cellspacing="0" itemprop="action" itemscope="" itemtype="http://schema.org/ConfirmAction" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; border-radius: 3px; margin: 0; border: none;">
						<tbody><tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
							<td class="content-wrap" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; color: #495057; font-size: 14px; vertical-align: top; margin: 0;padding: 30px; box-shadow: 0 0.75rem 1.5rem rgba(18,38,63,.03); ;border-radius: 7px; background-color: #fff;" valign="top">
								<meta itemprop="name" content="Confirm Email" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
								<table width="100%" cellpadding="0" cellspacing="0" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
									<tbody><tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
										<td class="content-block" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
											<h1>$siteName</h1>
											<p>Welcome to $siteName. Please confirm your email address by clicking the link below.</p>
										</td>
									</tr>
									<tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
										<td class="content-block" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
											You are not be able to claim or withdraw until you have verified your account.<br>
										</td>
									</tr>
									<tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
										<td class="content-block" itemprop="handler" itemscope="" itemtype="http://schema.org/HttpActionHandler" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
											<a href="$activeUrl" itemprop="url" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; color: #FFF; text-decoration: none; line-height: 2em; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: capitalize; background-color: #1c5cff; margin: 0; border-color: #1c5cff; border-style: solid; border-width: 8px 16px;">Confirm email address</a>
										</td>
									</tr>
									<tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
										<td class="content-block" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
											<b>$siteName</b>
											<p>Support Team</p>
										</td>
									</tr>
								</tbody>
								</table>
							</td>
						</tr>
					</tbody></table>
				</div>
			</td>
		</tr>
	</tbody></table>
EOT;

		if (sendMail($email, 'Active your account', $message, $this->data)) {
			$this->m_auth->register($email, $username, $password, $active_keys, $iso, $country, $referral, $referralSource);
			$sameIp = $this->m_auth->isCheater();
			$firstId = false;
			if ($sameIp) {
				foreach ($sameIp as $cheater) {
					if (!$firstId) {
						$firstId = $this->m_core->insertCheatLog($cheater['id'], 'Multiple account.', 0);
					} else {
						$this->m_core->insertCheatLog($cheater['id'], 'Multiple account.', $firstId);
					}
				}
			}
			$user = $this->m_core->get_user_from_email($email);
			$this->session->set_userdata('FID', $user['id']);

			if ($this->m_core->newIpUser($user['id'])) {
				$this->m_core->insertNewIp($user['id']);
			} else {
				$this->m_core->updateIpLastUse($user['id']);
			}
		} else {
			$this->session->set_flashdata('message', faucet_alert('danger', 'Failed to sent email'));
			return redirect(site_url('register'));
		}
		return redirect(site_url('/dashboard'));
	  } else {
			$this->m_auth->register($email, $username, $password, $active_keys, $iso, $country, $referral, $referralSource);
			$sameIp = $this->m_auth->isCheater();
			$firstId = false;
			if ($sameIp) {
				foreach ($sameIp as $cheater) {
					if (!$firstId) {
						$firstId = $this->m_core->insertCheatLog($cheater['id'], 'Multiple account.', 0);
					} else {
						$this->m_core->insertCheatLog($cheater['id'], 'Multiple account.', $firstId);
					}
				}
			}
			$user = $this->m_core->get_user_from_email($email);
			$this->session->set_userdata('FID', $user['id']);

			if ($this->m_core->newIpUser($user['id'])) {
				$this->m_core->insertNewIp($user['id']);
			} else {
				$this->m_core->updateIpLastUse($user['id']);
			}
		return redirect(site_url('/dashboard'));
	  }
	  
	}
	
	public function login()
	{
	if($this->data['proxy_detection'] == 'on') {
        if ($this->agent->is_browser()){
                $agent = $this->agent->browser().' '.$this->agent->version();
        }elseif ($this->agent->is_robot()){
                $agent = $this->agent->robot();
        }elseif ($this->agent->is_mobile()){
                $agent = $this->agent->mobile();
        }else{
                $agent = 'Unidentified User Agent';
        }
        
        $proxy = check_ip($this->input->ip_address(), $agent);
        if($proxy) {
            $this->session->set_flashdata('message', faucet_alert('danger', 'Proxy Detected!'));
			return redirect(site_url('login'));
        }
	}
		#Check captcha
		$captcha = $this->input->post('captcha');
		$Check_captcha = false;
		setcookie('captcha', $captcha, time() + 86400 * 10);
		switch ($captcha) {
			case "recaptchav3":
				$Check_captcha = verifyRecaptchaV3($this->input->post('recaptchav3'), $this->data['recaptcha_v3_secret_key']);
				break;
			case "recaptchav2":
				$Check_captcha = verifyRecaptchaV2($this->input->post('g-recaptcha-response'), $this->data['recaptcha_v2_secret_key']);
				break;
			case "solvemedia":
				$Check_captcha = verifySolvemedia($this->data['v_key'], $this->data['h_key'], $this->input->ip_address(), $this->input->post('adcopy_challenge'), $this->input->post('adcopy_response'));
				break;
			case "hcaptcha":
				$Check_captcha = verifyHcaptcha($this->input->post('h-captcha-response'), $this->data['hcaptcha_secret_key'], $this->input->ip_address());
				break;
		}
		if (!$Check_captcha) {
			$this->session->set_flashdata('message', faucet_alert('danger', 'Invalid Captcha'));
			return redirect(site_url('login'));
		}

		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|max_length[30]');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[3]|md5');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('message', faucet_alert('danger', validation_errors()));
			return redirect(site_url('login'));
		}
		$email = $this->db->escape_str($this->input->post('email'));
		$password = $this->db->escape_str($this->input->post('password'));

		$user = $this->m_auth->login($email, $password);
		if (!$user) {
			$this->session->set_flashdata('message', faucet_alert('danger', 'Invalid Credentials'));
			return redirect(site_url('login'));
		}

		$sameIp = $this->m_auth->isCheater();
		$firstId = false;
		if ($sameIp) {
			foreach ($sameIp as $cheater) {
				if (!$firstId) {
					$firstId = $this->m_core->insertCheatLog($cheater['id'], 'Multiple account.', 0);
				} else {
					$this->m_core->insertCheatLog($cheater['id'], 'Multiple account.', $firstId);
				}
			}
		}
		$this->session->set_userdata('FID', $user['id']);

		if ($this->m_core->newIpUser($user['id'])) {
			$this->m_core->insertNewIp($user['id']);
		} else {
			$this->m_core->updateIpLastUse($user['id']);
		}

		return redirect(site_url('/dashboard'));
	}

	public function forgot_password()
	{
		#Check captcha
		$captcha = $this->input->post('captcha');
		$Check_captcha = false;
		setcookie('captcha', $captcha, time() + 86400 * 10);
		switch ($captcha) {
			case "recaptchav3":
				$Check_captcha = verifyRecaptchaV3($this->input->post('recaptchav3'), $this->data['recaptcha_v3_secret_key']);
				break;
			case "recaptchav2":
				$Check_captcha = verifyRecaptchaV2($this->input->post('g-recaptcha-response'), $this->data['recaptcha_v2_secret_key']);
				break;
			case "solvemedia":
				$Check_captcha = verifySolvemedia($this->data['v_key'], $this->data['h_key'], $this->input->ip_address(), $this->input->post('adcopy_challenge'), $this->input->post('adcopy_response'));
				break;
			case "hcaptcha":
				$Check_captcha = verifyHcaptcha($this->input->post('h-captcha-response'), $this->data['hcaptcha_secret_key'], $this->input->ip_address());
				break;
		}
		if (!$Check_captcha) {
			$this->session->set_flashdata('message', faucet_alert('danger', 'Invalid Captcha'));
			return redirect(site_url('forgot-password'));
		}
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|max_length[30]');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('message', faucet_alert('danger', validation_errors()));
			return redirect(site_url('forgot-password'));
		}
		$email = $this->db->escape_str($this->input->post('email'));

		$user = $this->m_core->get_user_from_email($email);
		if (!$user) {
			$this->session->set_flashdata('message', faucet_alert('danger', 'Invalid Email'));
			return redirect(site_url('forgot-password'));
		}
		$token = $user['secret'];
		$siteName = $this->data['name'];
		$activeUrl = site_url('/reset-password/' . $token);
		$message = <<<EOT
			<table class="body-wrap" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: transparent; margin: 0;">
			<tbody><tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
			<td style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;" valign="top"></td>
			<td class="container" width="600" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;" valign="top">
				<div class="content" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; max-width: 600px; display: block; margin: 0 auto; padding: 20px;">
					<table class="main" width="100%" cellpadding="0" cellspacing="0" itemprop="action" itemscope="" itemtype="http://schema.org/ConfirmAction" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; border-radius: 3px; margin: 0; border: none;">
						<tbody><tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
							<td class="content-wrap" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; color: #495057; font-size: 14px; vertical-align: top; margin: 0;padding: 30px; box-shadow: 0 0.75rem 1.5rem rgba(18,38,63,.03); ;border-radius: 7px; background-color: #fff;" valign="top">
								<meta itemprop="name" content="Confirm Email" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
								<table width="100%" cellpadding="0" cellspacing="0" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
									<tbody><tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
										<td class="content-block" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
										You requested to reset your password at $siteName. Please confirm your email address by clicking the link below.
										</td>
									</tr>
									<tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
										<td class="content-block" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
										To reset your password, please click this link (or you can copy and paste it in your browser)
										</td>
									</tr>
									<tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
										<td class="content-block" itemprop="handler" itemscope="" itemtype="http://schema.org/HttpActionHandler" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
											<a href="$activeUrl" itemprop="url" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; color: #FFF; text-decoration: none; line-height: 2em; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: capitalize; background-color: #1c5cff; margin: 0; border-color: #1c5cff; border-style: solid; border-width: 8px 16px;">Reset password</a>
										</td>
									</tr>
									<tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
										<td class="content-block" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
											<b>$siteName</b>
											<p>Support Team</p>
										</td>
									</tr>
								</tbody>
								</table>
							</td>
						</tr>
					</tbody></table>
				</div>
			</td>
		</tr>
	</tbody></table>
EOT;
		sendMail($email, 'Reset password', $message, $this->data);
		$this->session->set_flashdata('message', faucet_alert('danger', 'Please check your email for confirmation link'));
		return redirect(site_url('forgot-password'));
	}

	public function reset_password($token = '')
	{
		if (strlen($token) != 30 || !preg_match("/^[a-zA-Z0-9]+$/", $token)) {
			$this->session->set_flashdata('message', faucet_alert('danger', 'Failed'));
			return redirect(site_url('forgot-password'));
		}
		$token = trim($this->db->escape_str($token));
		$user = $this->m_auth->get_user_from_token($token);

		if (!$user) {
			$this->session->set_flashdata('message', faucet_alert('danger', 'Failed'));
			return redirect(site_url('forgot-password'));
		}

		$newPassword = random_string('alnum', 15);
		$this->m_auth->update_password($user['id'], md5($newPassword));
		$siteName = $this->data['name'];
		$activeUrl = site_url('/login');
		$message = <<<EOT
			<table class="body-wrap" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: transparent; margin: 0;">
			<tbody><tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
			<td style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;" valign="top"></td>
			<td class="container" width="600" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;" valign="top">
				<div class="content" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; max-width: 600px; display: block; margin: 0 auto; padding: 20px;">
					<table class="main" width="100%" cellpadding="0" cellspacing="0" itemprop="action" itemscope="" itemtype="http://schema.org/ConfirmAction" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; border-radius: 3px; margin: 0; border: none;">
						<tbody><tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
							<td class="content-wrap" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; color: #495057; font-size: 14px; vertical-align: top; margin: 0;padding: 30px; box-shadow: 0 0.75rem 1.5rem rgba(18,38,63,.03); ;border-radius: 7px; background-color: #fff;" valign="top">
								<meta itemprop="name" content="Confirm Email" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
								<table width="100%" cellpadding="0" cellspacing="0" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
									<tbody><tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
										<td class="content-block" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
										Copy and login use your new password, you can change your password after you login.
										</td>
									</tr>
									<tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
										<td class="content-block" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
										Your temporary password is: <b>$newPassword</b>
										</td>
									</tr>
									<tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
										<td class="content-block" itemprop="handler" itemscope="" itemtype="http://schema.org/HttpActionHandler" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
											<a href="$activeUrl" itemprop="url" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; color: #FFF; text-decoration: none; line-height: 2em; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: capitalize; background-color: #1c5cff; margin: 0; border-color: #1c5cff; border-style: solid; border-width: 8px 16px;">Login</a>
										</td>
									</tr>
									<tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
										<td class="content-block" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
											<b>$siteName</b>
											<p>Support Team</p>
										</td>
									</tr>
								</tbody>
								</table>
							</td>
						</tr>
					</tbody></table>
				</div>
			</td>
		</tr>
	</tbody></table>
EOT;
		sendMail($user['email'], 'Your new password', $message, $this->data);
		$this->session->set_flashdata('message', faucet_alert('success', 'Please check your email for new password'));
		return redirect(site_url('forgot-password'));
	}

	public function logout()
	{
		session_destroy();
		return redirect(site_url('/'));
	}
}
