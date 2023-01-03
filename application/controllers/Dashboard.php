<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends Member_Controller
{
	public function __construct()
	{
		parent::__construct();
        $this->load->helper('string');
		$this->load->library('form_validation');
	}
	public function index()
	{
		$this->data['page'] = 'Dashboard';
        $this->data['withdrawals_history'] = $this->m_core->get_wd_history();
		$this->render('dashboard', $this->data); 		 
	}

	public function authorize()
	{
        $this->form_validation->set_rules(
            "wallet",
            "Wallet",
            "trim|required|valid_email|max_length[75]"
        );

        $wallet = $this->db->escape_str($this->input->post("wallet"));
        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata(
                "sweet_message",
                faucet_sweet_alert("error", "Invalid Email")
            );
            return redirect(site_url('/dashboard'));
        }
		$sameWallet = $this->m_core->checkSameWallet($this->data['user']['id'], $wallet);

		if ($sameWallet) {
            $this->session->set_flashdata(
                "sweet_message",
                faucet_sweet_alert("error", "This wallet is already linked to another account!")
            );
			return redirect(site_url('/dashboard'));
		}
        $api = "90332fc9fc6cd179235a0f1cb1b1bf38179653b6";
        $address = $wallet;
        $ip_address = $this->input->ip_address();

        $param = [
            "api_key" => $api,
            "address" => $address
        ];
        $url = "https://faucetpay.io/api/v1/checkaddress";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, count($param));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
        $result = json_decode(curl_exec($ch), true);
        curl_close($ch);                

        if ($result["status"] == 200) {
            $this->m_core->update_wallet($this->data['user']['id'], $wallet);
            $this->session->set_flashdata(
                'sweet_message',
                faucet_sweet_alert('success', 'Your wallet was successfully linked')
            );
            return redirect(site_url('/dashboard'));
        }else{
            $this->session->set_flashdata(
                'sweet_message',
                faucet_sweet_alert('error', 'Your email is not registered to FaucetPay.<br><a href="https://faucetpay.io/?r=3732157" target="_blank">Register to FaucetPay Here</a>')
            );
            return redirect(site_url('/dashboard'));
        }

	}

	public function resend()
	{
		if ($this->data['user']['verified'] == 1) {
			return redirect(site_url('/dashboard'));
		}
		$siteName = $this->data['settings']['name'];
		$activeUrl = site_url('/active/' . $this->data['user']['secret']);
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

		if (sendMail($this->data['user']['email'], 'Active your account', $message, $this->data['settings'])) {
			$this->session->set_flashdata('sweet_message', faucet_sweet_alert('success', 'Email sent'));
		} else {
			$this->session->set_flashdata('sweet_message', faucet_sweet_alert('error', 'Failed to sent email'));
		}
		return redirect(site_url('/dashboard'));
	}

    public function withdraw()
    {
        $cur = $this->db->escape_str($this->input->post("currency"));
        $slug = $cur;

        $amm = $this->db->escape_str($this->input->post("amount"));

        if ($amm > $this->data["user"]["balance"]) {
            $this->session->set_flashdata(
                'sweet_message',
                faucet_sweet_alert('error', 'You do not have enough funds to withdraw')
            );
            return redirect(site_url('dashboard'));
        }else if ($amm == 0) {
            $this->session->set_flashdata(
                "sweet_message",
                faucet_sweet_alert("error", "Please enter amount of withdraw")
            );
            return redirect(site_url('dashboard'));
        }
        
        $min = $this->data['settings']['min_wd'];
        if ($amm < $this->data['settings']['min_wd']) {
            $this->session->set_flashdata(
                "sweet_message",
                faucet_sweet_alert("error", "Minimum Account Balance Withdraw is $min USD.")
            );
            return redirect(site_url('dashboard'));
        }

        $faucet = $this->m_core->getCurrency($slug);
        $api = $faucet["api"];
        $amount = number_format($amm/$faucet["price"],8);
        $amount = $amount * 100000000;
        $currency = $faucet["code"];
        $address = $this->data["user"]["wallet"];
        $ip_address = $this->input->ip_address();
        $referral = false;
        
        if ($this->input->post("token") != $this->data["user"]["token"]) {
            $this->session->set_flashdata(
                "sweet_message",
                faucet_sweet_alert("error", "Invalid Claim")
            );
            return redirect(site_url('dashboard'));
        }

        if ($this->m_core->findCheatLog($this->data["user"]["id"])) {
            $this->session->set_flashdata(
                "message",
                faucet_alert(
                    "danger",
                    "Your account is banned for 24 hours because of Cheating."
                )
            );
            return redirect(site_url('dashboard'));
        }

        $totsclaim = $this->data["user"]["claims"];
        if ($totsclaim < $faucet["min_claim"]) {
            $this->session->set_flashdata(
                'sweet_message',
                faucet_sweet_alert('error', 'You have to made '. $faucet["min_claim"] .' Total Claims to Unlock this currency')
            );
            return redirect(site_url());
        }

        $param = [
            "api_key" => $api,
            "amount" => $amount,
            "to" => $address,
            "currency" => $currency,
            "referral" => $referral,
            "ip_address" => $ip_address,
        ];
        $url = "https://faucetpay.io/api/v1/send";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, count($param));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
        $result = json_decode(curl_exec($ch), true);
        curl_close($ch);
        
        if ($result["status"] == 200) {
        $this->m_core->reduce_balance($this->data['user']['id'], number_format($amm, 6));
            $this->m_core->insert_wd_history(
                $this->data["user"]["id"],
                $currency,
                $address,
                number_format($amount / 100000000, 8),$amm, 3
            );
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
                faucet_sweet_alert("error", $result["message"])
            );
        }
        $this->m_core->update_active($this->data["user"]["id"]);
            return redirect(site_url('dashboard'));
    }
    
}
