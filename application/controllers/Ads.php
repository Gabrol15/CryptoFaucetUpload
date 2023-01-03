<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ads extends Member_Controller
{
	public function __construct()
	{
		parent::__construct();
		if ($this->data['settings']['ptc_status'] != 'on') {
			return redirect(site_url('dashboard'));
		}
        if (!isset($_SESSION['FID'])) { 
        return redirect(site_url());
        }		
		$this->load->model('m_ptc');
		$this->load->model('m_advertise');
	}

	public function index()
	{
		$this->data['page'] = 'PTC Ads';
	if($this->data["settings"]["email_confirmation"] == 'on') {
		if ($this->data['user']['verified'] == 0) {
			$this->session->set_flashdata('sweet_message', faucet_sweet_alert('error', 'Please verify your email'));
			return redirect(site_url('/dashboard'));
		}
	}
        if ($this->data["user"]["wallet"] == '') {
            $this->session->set_flashdata("sweet_message", faucet_sweet_alert('error', 'Please connect your FaucetPay Email before claim'));
            return redirect(site_url('dashboard'));
        }
		$this->data['totalReward'] = 0;

		$this->data['ptcAds'] = $this->m_ptc->availableAds($this->data['user']['id']);
		$this->data['totalAds'] = count($this->data['ptcAds']);

		foreach ($this->data['ptcAds'] as $ad) {
			$this->data['totalReward'] += $ad['reward'];
		}
		$this->data['options'] = $this->m_advertise->getOptions();
		$this->data['ads'] = $this->m_advertise->getAds($this->data['user']['id']);

		$this->render('ads1', $this->data);
	}

	public function view($id = 0, $cur = '')
	{
        $slug = $cur;
        $faucet = $this->m_core->getCurrency($slug);
		if (!is_numeric($id)) {
			$this->session->set_flashdata('message', faucet_alert('danger', 'Invalid Ad'));
			return redirect(site_url('/ads'));
		}
        if ($this->m_core->findCheatLog($this->data["user"]["id"])) 
        {
            $log = $this->m_core->get_cheater($this->data["user"]["id"]);
            if($log['log'] == 'Invalid claim.') {
            $this->session->set_flashdata(
                "sweet_message",
                faucet_sweet_alert("error", "Your account is banned for 24 hours because of Invalid Claim.")
            );
            }else if($log['log'] == 'Multiple account.') {
            $this->session->set_flashdata(
                "sweet_message",
                faucet_sweet_alert("error", "Your account is banned for 24 hours because of Multiple Accounts, contact admin to delete other account, or you will get banned again.")
            );
            }
            return redirect(site_url('/ads'));
        }
        if (
            $this->data["settings"]["firewall"] == "on" &&
            time() - $this->data["user"]["last_firewall"] > rand(1500, 2000)
        ) {
            $this->m_core->firewallLock($this->data["user"]["id"]);
            return redirect(site_url('/firewall'));
        }
        $totsclaim = $this->data["user"]["claims"];
        if ($totsclaim < $faucet["min_claim"]) {
            $this->session->set_flashdata(
                "sweet_message",
                faucet_sweet_alert('error', 'You have to made '. $faucet['min_claim'] .' Total Claims to Unlock this currency')
            );
            return redirect(site_url('/ads'));
        }
        
	   $this->data["this_page"] = $this->m_core->getCurrency($slug);

		$this->data['ads'] = $this->m_ptc->get_ads_from_id($id);

		if (!$this->data['ads']) {
			$this->session->set_flashdata('message', faucet_alert('danger', 'Invalid Ad'));
			return redirect(site_url('/ads'));
		}

		#Captcha
		$this->data['captcha_display'] = get_captcha($this->data['settings'], base_url(), 'faucet_captcha');
		$this->session->set_userdata(array('start_view' => time()));
		$this->load->view('user_template/ads_view_ad', $this->data);
	}

	public function verify($id = 0, $cur ='')
	{
		$this->load->helper('string');
        $slug = $cur;
        $faucet = $this->m_core->getCurrency($slug);
		$startTime = $this->session->start_view;
		$this->session->unset_userdata('start_view');

		// is id mumeric
		if (!is_numeric($id)) {
			$this->session->set_flashdata('message', faucet_alert('danger', 'Invalid Click'));
			return redirect(site_url('/ads'));
		}

		$ad = $this->m_ptc->get_ads_from_id($id);

		// does ad exist and view time valid
		if (!$ad || time() - $startTime < $ad['timer']) {
			$this->session->set_flashdata('message', faucet_alert('danger', 'Invalid Click'));
			return redirect(site_url('/ads'));
		}

		if ($ad['views'] >= $ad['total_view']) {
			$this->session->set_flashdata('message', faucet_alert('danger', 'This Ad has reached maximum views'));
			return redirect(site_url('/ads'));
		}

		if ($this->input->post('token') != $this->data['user']['token']) {
			$this->session->set_flashdata('message', faucet_alert('danger', 'Invalid Claim'));
			return redirect(site_url('/ads'));
		}
        if ($this->m_core->findCheatLog($this->data["user"]["id"])) {
            $this->session->set_flashdata(
                "message",
                faucet_alert(
                    "danger",
                    "Your account is banned for 24 hours because of Cheating."
                )
            );
            return redirect(site_url('/ads'));
        }
		#Check captcha
		$captcha = $this->input->post('captcha');
		$Check_captcha = false;
		setcookie('captcha', $captcha, time() + 86400 * 10);
		switch ($captcha) {
			case "recaptchav3":
				$Check_captcha = verifyRecaptchaV3($this->input->post('recaptchav3'), $this->data['settings']['recaptcha_v3_secret_key']);
				break;
			case "recaptchav2":
				$Check_captcha = verifyRecaptchaV2($this->input->post('g-recaptcha-response'), $this->data['settings']['recaptcha_v2_secret_key']);
				break;
			case "solvemedia":
				$Check_captcha = verifySolvemedia($this->data['settings']['v_key'], $this->data['settings']['h_key'], $this->input->ip_address(), $this->input->post('adcopy_challenge'), $this->input->post('adcopy_response'));
				break;
			case "hcaptcha":
				$Check_captcha = verifyHcaptcha($this->input->post('h-captcha-response'), $this->data['settings']['hcaptcha_secret_key'], $this->input->ip_address());
				break;
		}
		if (!$Check_captcha) {
			if ($this->data['user']['fail'] == $this->data['settings']['captcha_fail_limit']) {
				$this->m_core->insertCheatLog($this->data['user']['id'], 'Too many wrong captcha.', 0);
			} else if ($this->data['user']['fail'] < 4) {
				$this->m_core->wrongCaptcha($this->data['user']['id']);
			}
			$this->session->set_flashdata('message', faucet_alert('danger', 'Invalid Captcha'));
			return redirect(site_url('ads'));
		}

		$check = $this->m_ptc->verify($this->data['user']['id'], $id);

		if (!$check) {
			$this->session->set_flashdata('message', faucet_alert('danger', 'Invalid Ad'));
			return redirect(site_url('/ads'));
		}
		
        $api = $faucet["api"];
        $amount = number_format($ad['reward']/$faucet["price"],8);
        $amount = $amount * 100000000;
        $currency = $faucet["code"];
        $address = $this->data["user"]["wallet"];
        $ip_address = $this->input->ip_address();
        $referral = false;
        
        $result = faucetpay($address, $ip_address, $amount, $api, $currency, $referral = false);
        if ($this->data["user"]["fail"] > 0) {
            $this->m_core->resetFail($this->data["user"]["id"]);
        }

        if ($result["status"] == 200) {
            $this->m_core->insert_wd_history(
                $this->data["user"]["id"],
                $currency,
                $address,
                number_format($amount / 100000000, 8),$ad['reward'], 4
            );

            $this->m_ptc->update_user($this->data["user"]["id"], $ad['reward']);
            $this->session->set_flashdata(
                "sweet_message",
                faucet_sweet_alert(
                    "success",
                    number_format($amount / 100000000, 8) .
                        " " .
                        $faucet["code"] .
                        " has been sent to your FaucetPay account!"
                )
            );
        } else {
            $this->m_ptc->update_user($this->data["user"]["id"], $ad['reward']);
		    $this->m_ptc->update_balance($this->data['user']['id'], $ad['reward']);
            $this->m_core->insert_wd_history(
                $this->data["user"]["id"],
                'USD',
                $address,
                number_format($amount / 100000000, 8),$ad['reward'] , 5
            );
		    $this->m_ptc->update_user($this->data['user']['id'], $ad['reward']);
            $this->session->set_flashdata('sweet_message', faucet_sweet_alert('success', format_money($ad['reward']) . ' USD has been added to your balance'));
        }

		$this->m_ptc->addView($ad['id']);
		if ($ad['views'] + 1 == $ad['total_view']) {
			$this->m_ptc->completed($ad['id']);
		}
		$this->m_ptc->insert_history($this->data['user']['id'], $ad['id'], $ad['reward']);

        if ($this->data["user"]["referred_by"] != 0 && time() - $this->m_core->lastActive($this->data["user"]["referred_by"]) < 86400) {
            $amt = ($ad["reward"] * $this->data["settings"]["referral"]) / 100;
            if ($amt > 0) {
                $referr = $this->m_core->get_user_from_id($this->data["user"]["referred_by"]);
                $this->m_core->update_ref($referr['id'], $amt);
            }
        }

		if ($this->data['user']['fail'] > 0) {
			$this->m_core->resetFail($this->data['user']['id']);
		}
		$this->m_core->update_active($this->data["user"]["id"]);
		return redirect(site_url('/ads'));
	}
}
