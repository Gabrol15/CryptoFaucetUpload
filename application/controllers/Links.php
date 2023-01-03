<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Links extends Member_Controller
{
	public function __construct()
	{
		parent::__construct();
		if ($this->data['settings']['shortlink_status'] != 'on') {
			return redirect(site_url('dashboard'));
		}
        if (!isset($_SESSION['FID'])) { 
        return redirect(site_url());
        }		
		$this->load->model('m_links');
		$this->load->helper('string');
	}

	public function index()
	{
		$this->data['page'] = 'Shortlinks';
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
		$this->data['availableLinks'] = $this->m_links->availableLinks($this->data['user']['id']);
		$this->data['getlink'] = $this->m_links->get_link_history($this->data['user']['id']);
		    
		$this->data['totalReward'] = 0;
		for ($i = 0; $i < count($this->data['availableLinks']); ++$i) {
			$countHistory = $this->m_links->countHistory($this->data['user']['id'], $this->data['availableLinks'][$i]['id']);
			$this->data['availableLinks'][$i]['rmnViews'] = $this->data['availableLinks'][$i]['view_per_day'] - $countHistory;
			$this->data['totalReward'] += $this->data['availableLinks'][$i]['rmnViews'] * $this->data['availableLinks'][$i]['reward'];
		}
		$this->data['totalEnergy'] = 0;
		for ($i = 0; $i < count($this->data['availableLinks']); ++$i) {
			$countHistory = $this->m_links->countHistory($this->data['user']['id'], $this->data['availableLinks'][$i]['id']);
			$this->data['availableLinks'][$i]['rmnViews'] = $this->data['availableLinks'][$i]['view_per_day'] - $countHistory;
			$this->data['totalEnergy'] += $this->data['availableLinks'][$i]['rmnViews'] * $this->data['availableLinks'][$i]['energy_reward'];
		}

		usort($this->data['availableLinks'], 'sortLinks');
        $this->data['countAvailableLinks'] = $this->m_core->countAllLinksView() - $this->m_core->countLinkHistory($this->data['user']['id']);
		$this->render('links', $this->data);
	}

	public function go($link_id = 0, $cur = '')
	{
		$link_id = $this->db->escape_str($link_id);
        $faucet = $this->m_core->getCurrency($cur);
        $totsclaim = $this->data["user"]["claims"];
        if ($totsclaim < $faucet["min_claim"]) {
            $this->session->set_flashdata(
                "sweet_message",
                faucet_sweet_alert('error', 'You have to made '. $faucet['min_claim'] .' Total Claims to Unlock this currency')
            );
            return redirect(site_url('links'));
        }
		$link_data = $this->m_links->valid_id($link_id, $this->data['user']['id']);
		if (!$link_data) {
			return redirect(site_url('/links'));
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
            return redirect(site_url('/links'));
        }
        if (
            $this->data["settings"]["firewall"] == "on" &&
            time() - $this->data["user"]["last_firewall"] > rand(1500, 2000)
        ) {
            $this->m_core->firewallLock($this->data["user"]["id"]);
            return redirect(site_url('firewall'));
        }

		$key = random_string('alnum', 20);

		// generate short link
		$url = urlencode(site_url('/links/back/'.$key.'/'.$cur));
		$api_url = str_replace('{url}', $url, $link_data['url']);
		$result = @json_decode(get_data($api_url), TRUE);
		if ($result['status'] == 'success') {
			$this->m_links->insert_link($this->data['user']['id'], $key, $link_id, $result['shortenedUrl']);
			echo '<script> location.href = "' . $result['shortenedUrl'] . '"; </script>';
			return redirect($result['shortenedUrl']);
		}
		$this->session->set_flashdata('message', faucet_alert('danger', 'Failed to generate this link <a class="btn btn-warning" href="https://community.ourtecads.com/faucet-room" target="_blank">Report Here</a>'));
		return redirect(site_url('/links'));
	}

	public function verify($key = '', $cur = '')
	{
		if (strlen($key) != 20 || !preg_match("/^[a-zA-Z0-9]+$/", $key)) {
			$this->session->set_flashdata('message', faucet_alert('danger', 'Invalid Keys'));
			return redirect(site_url('/links'));
		}

		$key = trim($this->db->escape_str($key));
		$link = $this->m_links->check_key($key, $this->data['user']['id']);
		if (!$link || $link['ip_address'] != $this->input->ip_address()) {
			$this->session->set_flashdata('message', faucet_alert('danger', 'Invalid Keys'));
			return redirect(site_url('/links'));
		}

		$link_data = $this->m_links->valid_id($link['link_id'], $this->data['user']['id']);
		if (!$link_data) {
			if ($this->data['user']['fail'] == $this->data['settings']['captcha_fail_limit']) {
				$this->m_core->insertCheatLog($this->data['user']['id'], 'Too many wrong captcha.', 0);
			} else if ($this->data['user']['fail'] < 4) {
				$this->m_core->wrongCaptcha($this->data['user']['id']);
			}
			return redirect(site_url('/links'));
		}
        
        $claimtime = time() - $this->data['user']['last_claim'];
                        
        if ($claimtime < 30) {
            $this->m_core->insertCheatLog($this->data['user']['id'], 'Invalid claim.', 0);
            $this->session->set_flashdata(
                "sweet_message",
                faucet_sweet_alert("error", "You are banned for 24 hours because cheating, or use extension to complete shortlinks!")
            );
            return redirect(site_url('/links'));
        }
        
        $faucet = $this->m_core->getCurrency($cur);
        $api = $faucet["api"];
        $amount = number_format($link_data['reward']/$faucet["price"],8);
        $amount = $amount * 100000000;
        $currency = $faucet["code"];
        $address = $this->data['user']['wallet'];
        $ip_address = $this->input->ip_address();
        $referral = false;
        
        $result = faucetpay($address, $ip_address, $amount, $api, $currency, $referral = false);
        if ($this->data["user"]["fail"] > 0) {
            $this->m_core->resetFail($this->data["user"]["id"]);
        }

        if ($result["status"] == 200) {
		$this->m_links->insert_history($this->data['user']['id'], $link_data['reward'], $link_data['id']);
            $this->m_core->insert_wd_history(
                $this->data["user"]["id"],
                $currency,
                $address,
                number_format($amount / 100000000, 8),$link_data['reward'], 2
            );

            $this->m_links->update_user($this->data["user"]["id"], $link_data['reward']);
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
            $this->m_links->update_user($this->data["user"]["id"], $link_data['reward']);
		    $this->m_links->insert_history($this->data['user']['id'], $link_data['reward'], $link_data['id']);
		    $this->m_links->update_balance($this->data['user']['id'], $link_data['reward']);
            $this->m_core->insert_wd_history(
                $this->data["user"]["id"],
                'USD',
                $address,
                number_format($amount / 100000000, 8),$link_data['reward'] , 6
            );
            $this->session->set_flashdata('sweet_message', faucet_sweet_alert('success', format_money($link_data['reward']) . ' USD has been added to your balance'));
        }
        $this->m_core->add_energy($this->data["user"]["id"], $link_data['energy_reward']);
        if ($this->data["user"]["referred_by"] != 0 && time() - $this->m_core->lastActive($this->data["user"]["referred_by"]) < 86400) {
            $amt = ($faucet["reward"] * $this->data["settings"]["referral"]) / 100;
            if ($amt > 0) {
                $referr = $this->m_core->get_user_from_id($this->data["user"]["referred_by"]);
                $this->m_core->update_ref($referr['id'], $amt);
            }
        }
		return redirect(site_url('/links'));
	}

	public function back($key = '', $cur = '')
	{
		if (strlen($key) == 20) {
			return redirect(site_url('/links/verify/' . $key.'/'.$cur));
		}
	}
}
