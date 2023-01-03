<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auto extends Member_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->data['settings']['autofaucet_status'] != 'on') {
            return redirect(site_url('dashboard'));
        }
        if (!isset($_SESSION['FID'])) { 
        return redirect(site_url());
        }		
        $this->load->helper('string');
        $this->load->model('m_auto');
        $this->data['csrf_name'] = $this->security->get_csrf_token_name();
        $this->data['csrf_hash'] = $this->security->get_csrf_hash();
    }

    public function currency($cur = '')
    {
        $this->data["this_page"] = $this->m_core->getCurrency($cur);
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
        $faucet = $this->m_core->getCurrency($cur);
        $totsclaim = $this->data["user"]["claims"];
        if ($totsclaim < $faucet["min_claim"]) {
            $this->session->set_flashdata("sweet_message", faucet_sweet_alert('error', 'You have to made '. $faucet['min_claim'] .' Total Claims to Unlock this currency'));
            return redirect(site_url('dashboard'));
        }
        if ($this->data["this_page"]) {
                    $this->data["page"] = 'Auto Claim '.strip_tags(
                        $this->data["this_page"]["code"]);
                    if (!isset($_SESSION["FID"])) {
                    return redirect(site_url());
                    }
        if ($this->data['user']['energy'] < $this->data['settings']['autofaucet_cost']) {
            $this->data['error'] = true;
        } else {
            $this->session->set_userdata('autoFaucetStart', time());
            $this->session->set_userdata('autoFaucetToken', random_string('alnum', 20));
        }
        $this->render('auto', $this->data);
        } else {
            show_404();
        }
    }

    public function verify($cur = '')
    {
        $slug = $cur;

        $faucet = $this->m_core->getCurrency($slug);
        $api = $faucet["api"];
        $amount = number_format($this->data['settings']['autofaucet_reward']/$faucet["price"],8);
        $amount = $amount * 100000000;
        $currency = $faucet["code"];
        $address = $this->data["user"]["wallet"];
        $ip_address = $this->input->ip_address();
        $referral = false;
        
        if ($this->input->post('token') != $this->session->autoFaucetToken) {
            $this->session->set_flashdata('message', faucet_alert('danger', 'Invalid Claim'));
            return redirect(site_url('/auto/currency/'.$slug));
        }

        if ($this->session->autoFaucetStart == NULL || time() - $this->session->autoFaucetStart < $this->data['settings']['autofaucet_timer']) {
            $this->session->set_flashdata('message', faucet_alert('danger', 'Invalid Claim'));
            return redirect(site_url('/auto/currency/'.$slug));
        }

        if (time() - $this->data['user']['last_auto'] < $this->data['settings']['autofaucet_timer']) {
            $this->session->set_flashdata('message', faucet_alert('danger', 'Invalid Claim'));
            return redirect(site_url('/auto/currency/'.$slug));
        }

        $this->session->set_userdata('autoFaucetStart', time() + 100000);


        if ($this->data['user']['energy'] < $this->data['settings']['autofaucet_cost']) {
            $this->session->set_flashdata('message', faucet_alert('danger', 'Invalid Claim'));
            return redirect(site_url('/auto/currency/'.$slug));
        }

        $result = faucetpay($address, $ip_address, $amount, $api, $currency, $referral = false);
        if ($result["status"] == 200) {
        $this->m_auto->update_user($this->data['user']['id'], $this->data['settings']['autofaucet_reward'], $this->data['settings']['autofaucet_cost']);
            $this->m_core->insert_wd_history(
                $this->data["user"]["id"],
                $currency,
                $address,
                number_format($amount / 100000000, 8),$this->data['settings']['autofaucet_reward'], 7
            );
        if ($this->data["user"]["referred_by"] != 0 && time() - $this->m_core->lastActive($this->data["user"]["referred_by"]) < 86400) {
            $amt = ($this->data['settings']['autofaucet_reward'] * $this->data["settings"]["referral"]) / 100;
            if ($amt > 0) {
                $referr = $this->m_core->get_user_from_id($this->data["user"]["referred_by"]);
                $this->m_core->update_ref($referr['id'], $amt);
            }
        }
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
            $this->session->set_flashdata(
                "sweet_message",
                faucet_sweet_alert("warning", $result["message"])
            );
        }
        return redirect(site_url('/auto/currency/'.$slug));
    }
}
