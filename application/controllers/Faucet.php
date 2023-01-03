<?php
defined("BASEPATH") or exit("No direct script access allowed");

class Faucet extends Member_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper("string");
        if (!isset($_SESSION['FID'])) { 
        return redirect(site_url());
        }
        $this->load->model("m_faucet");
        $this->load->library("form_validation");
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
                    $this->data["page"] = strip_tags(
                        $this->data["this_page"]["code"].' Faucet'
                    );
                    if (!isset($_SESSION["FID"])) {
                    return redirect(site_url());
                    } else {
                        $checkhis = $this->m_faucet->check_history($this->data["this_page"]["code"], $this->data["user"]["id"]);
                        $gethis = $this->m_faucet->get_claim_history($this->data["this_page"]["code"], $this->data["user"]["id"]);
                        if ($checkhis) {
                        $claimtime = $gethis["claim_time"];
                        }else{
                        $claimtime = 0;
                        }
                        $claimlimit = $this->data["user"]["id"];
                        
                        $this->data["countHistory"] = max(0,$this->data["this_page"]["limit_claim"]-$this->m_faucet->countHistory($this->data["this_page"]["code"],$this->data["user"]["id"]));
                    }
                    $this->data["wait"] = max(0,$this->data["this_page"]["timer"] - time() + $claimtime);
                    $this->data["limit"] = false;
                    if (!$this->m_faucet->check_limit($this->data["this_page"]["code"],
                            $this->data["this_page"]["limit_claim"],$claimlimit)) {
                        $this->data["limit"] = true;
                    }
                    if ($this->data["settings"]["antibotlinks"] == "on") {include APPPATH ."third_party/antibot/antibotlinks.php";
                        $antibotlinks = new antibotlinks(true, "ttf,otf", ["abl_light_colors" => "off","abl_background" => "off","abl_noise" => "on",]);
                        $antibotlinks->generate(3, true);
                        $this->data["antibot_js"] = $antibotlinks->get_js();
                        $this->data["antibot_show_info"] = $antibotlinks->show_info();
                    }
                    $this->data["captcha_display"] = get_captcha($this->data["settings"],base_url(),"faucet_captcha");

                    $this->data["anti_pos"] = [
                        rand(0, 5),
                        rand(0, 5),
                        rand(0, 5),
                    ];
		            $this->data['current'] = $cur;
                    $this->render('faucet', $this->data);
                } else {
                    show_404();
                }
    }

    public function verify($cur = '')
    {
        $slug = $cur;

        $faucet = $this->m_core->getCurrency($slug);
        $api = $faucet["api"];
        $amount = number_format($faucet["reward"]/$faucet["price"],8);
        $amount = $amount * 100000000;
        $currency = $faucet["code"];
        $address = $this->data["user"]["wallet"];
        $ip_address = $this->input->ip_address();
        $referral = false;

        if ($this->input->post("token") != $this->data["user"]["token"]) {$this->session->set_flashdata("sweet_message",faucet_sweet_alert("error", "Invalid Claim"));
            return redirect(site_url("faucet/currency/" . $slug));
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
            return redirect(site_url("faucet/currency/" . $slug));
        }

        $checkhis = $this->m_faucet->check_history($faucet["code"], $this->data["user"]["id"]);
        $gethis = $this->m_faucet->get_claim_history($faucet["code"], $this->data["user"]["id"]);
        if ($checkhis) {$claimtime = $gethis["claim_time"];
        if ($claimtime < $faucet["timer"]) {$this->session->set_flashdata("sweet_message",faucet_sweet_alert("error", "Invalid Claim"));
            return redirect(site_url("faucet/currency/" . $slug));
        }                        
                        }
        $limit = $this->m_faucet->check_limit($faucet["code"],$faucet["limit_claim"],$this->data["user"]["id"]);

        if (!$limit && $this->data["user"]["energy"] < 10) {$this->session->set_flashdata("sweet_message",faucet_sweet_alert("error", "Invalid Claim"));
            return redirect(site_url("faucet/currency/" . $slug));
        }

        if (!$limit) {
            $this->m_faucet->reduce_energy($this->data["user"]["id"]);
        }

        if ($this->data["settings"]["antibotlinks"] == "on") {
            #CHECK ANTIBOTLINKS
            if (
                trim($_POST["antibotlinks"]) !==
                    $_SESSION["antibotlinks"]["solution"] or
                empty($_SESSION["antibotlinks"]["solution"])
            ) {
                if (
                    $this->data["user"]["fail"] ==
                    $this->data["settings"]["captcha_fail_limit"]
                ) {
                    $this->m_core->insertCheatLog(
                        $this->data["user"]["id"],
                        "Too many wrong captcha.",
                        0
                    );
                } elseif ($this->data["user"]["fail"] < 4) {
                    $this->m_core->wrongCaptcha($this->data["user"]["id"]);
                }
                $this->session->set_flashdata(
                    "sweet_message",
                    faucet_sweet_alert("error", "Invalid Anti-Bot Links")
                );
                return redirect(site_url("faucet/currency/" . $slug));
            }
        }
        #Check captcha
        $captcha = $this->input->post("captcha");
        $Check_captcha = false;
        setcookie("captcha", $captcha, time() + 86400 * 10);
        switch ($captcha) {
            case "recaptchav3":
                $Check_captcha = verifyRecaptchaV3(
                    $this->input->post("recaptchav3"),
                    $this->data["settings"]["recaptcha_v3_secret_key"]
                );
                break;
            case "recaptchav2":
                $Check_captcha = verifyRecaptchaV2(
                    $this->input->post("g-recaptcha-response"),
                    $this->data["settings"]["recaptcha_v2_secret_key"]
                );
                break;
            case "solvemedia":
                $Check_captcha = verifySolvemedia(
                    $this->data["settings"]["v_key"],
                    $this->data["settings"]["h_key"],
                    $this->input->ip_address(),
                    $this->input->post("adcopy_challenge"),
                    $this->input->post("adcopy_response")
                );
                break;
            case "hcaptcha":
                $Check_captcha = verifyHcaptcha(
                    $this->input->post("h-captcha-response"),
                    $this->data["settings"]["hcaptcha_secret_key"],
                    $this->input->ip_address()
                );
                break;
        }
        if (!$Check_captcha) {
            if (
                $this->data["user"]["fail"] ==
                $this->data["settings"]["captcha_fail_limit"]
            ) {
                $this->m_core->insertCheatLog(
                    $this->data["user"]["id"],
                    "Too many wrong captcha.",
                    0
                );
            } elseif ($this->data["user"]["fail"] < 4) {
                $this->m_core->wrongCaptcha($this->data["user"]["id"]);
            }
            $this->session->set_flashdata(
                "sweet_message",
                faucet_sweet_alert("error", "Invalid Captcha")
            );
            return redirect(site_url("faucet/currency/" . $slug));
        }

        if ($this->data["settings"]["firewall"] == "on" && time() - $this->data["user"]["last_firewall"] > rand(1500, 2000) ) {
            $this->m_core->firewallLock($this->data["user"]["id"]);
            return redirect(site_url('firewall'));
        }

        if ($this->data["user"]["fail"] > 0) {
            $this->m_core->resetFail($this->data["user"]["id"]);
        }

        $result = faucetpay($address, $ip_address, $amount, $api, $currency, $referral = false);
        if ($result["status"] == 200) {
            $this->m_core->add_energy($this->data["user"]["id"], $faucet["energy_reward"]);
            $this->m_core->insert_wd_history(
                $this->data["user"]["id"],
                $currency,
                $address,
                number_format($amount / 100000000, 8),$faucet["reward"], 1
            );
        if ($this->data["user"]["referred_by"] != 0 && time() - $this->m_core->lastActive($this->data["user"]["referred_by"]) < 86400) {
            $amt = ($faucet["reward"] * $this->data["settings"]["referral"]) / 100;
            if ($amt > 0) {
                $referr = $this->m_core->get_user_from_id($this->data["user"]["referred_by"]);
                $this->m_core->update_ref($referr['id'], $amt);
            }
        }
        $checkhis = $this->m_faucet->check_history($currency, $this->data["user"]["id"]);
          if ($checkhis) {
              $this->m_faucet->update_faucet_history($this->data["user"]["id"],$currency,number_format($amount / 100000000, 8));  
          }else{         
            $this->m_faucet->insert_faucet_history($this->data["user"]["id"],$currency,number_format($amount / 100000000, 8));  
          }          
            $this->m_faucet->update_user($this->data["user"]["id"], $faucet["reward"]);
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
        $this->m_core->update_active($this->data["user"]["id"]);
        return redirect(site_url("faucet/currency/" . $slug));
    }
    
}