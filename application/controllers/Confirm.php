<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Confirm extends Guess_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_deposit');
		$this->load->model('m_offerwall');
		$this->load->library('user_agent');
		$this->data['whitelist_ips'] = [
			'coinbase' => [],
			'faucetpay' => [],
			'wannads' => [
				'34.250.159.173',
				'34.244.210.150',
				'52.212.236.135',
				'34.251.83.149'
			],
			'cpx' => [
				'188.40.3.73'
			],
			'offertoro' => [
				'54.175.173.245'
			],
			'ayetstudios' => [
				'35.165.166.40',
				'35.166.159.131',
				'52.40.3.140'
			],
			'personaly' => [
				'159.203.84.146',
				'52.200.142.249'
			],
			'bitswall' => [
				'188.165.198.204',
				'2001:41d0:2:8fcc::'
			],
			'payeer' => [
				'185.71.65.92',
				'185.71.65.189',
				'149.202.17.210'
			]
		];
	}

	public function faucetpay()
	{
		$token = $this->input->post('token');
		$payment_info = @json_decode(get_data('https://faucetpay.io/merchant/get-payment/' . $token), TRUE);
        $token_status = $payment_info['valid'];
		
$merchant_username = $payment_info['merchant_username'];
$amount1 = $payment_info['amount1'];
$currency1 = $payment_info['currency1'];
$amount2 = $payment_info['amount2'];
$currency2 = $payment_info['currency2'];
$custom = $payment_info['custom'];
$trans = $payment_info['transaction_id'];
$username = $this->data['settings']['faucetpay_username'];

		if ($token_status == true && $merchant_username == $username && $currency1 == 'USD' && $amount1 >= $this->data['settings']['faucetpay_min_deposit']) {
				$this->m_deposit->updateUser($custom, $amount1);
				$this->m_deposit->addDeposit($custom, $amount1, $trans, 1, 'Confirmed');
		}
	}

	public function payeer()
	{
		if (!in_array($this->input->ip_address(), $this->data['whitelist_ips']['payeer'])) {
			echo 'ok';
			die();
		}
		if (isset($_POST['m_operation_id']) && isset($_POST['m_sign'])) {
			$arHash = array(
				$_POST['m_operation_id'],
				$_POST['m_operation_ps'],
				$_POST['m_operation_date'],
				$_POST['m_operation_pay_date'],
				$_POST['m_shop'],
				$_POST['m_orderid'],
				$_POST['m_amount'],
				$_POST['m_curr'],
				$_POST['m_desc'],
				$_POST['m_status']
			);

			if (isset($_POST['m_params'])) {
				$arHash[] = $_POST['m_params'];
			}

			$arHash[] = $this->data['settings']['payeer_secret'];

			$sign_hash = strtoupper(hash('sha256', implode(':', $arHash)));

			if ($_POST['m_sign'] == $sign_hash && $_POST['m_status'] == 'success' && $_POST['m_amount'] >= $this->data['settings']['payeer_min_deposit']) {
				$orderId = $this->db->escape_str($_POST['m_orderid']);
				$this->m_deposit->updateStatus($orderId, 'Confirmed');
				$this->m_deposit->depositSuccess($orderId);
				die($_POST['m_orderid'] . '|success');
			}

			die($_POST['m_orderid'] . '|error');
		}
	}

	public function offeroc()
	{
    
    $secret = $this->data['settings']['offeroc_secret']; 

    $userId = isset($_REQUEST['subId']) ? $this->db->escape_str($_REQUEST['subId']) : null;
    $transactionId = isset($_REQUEST['transId']) ? $this->db->escape_str($_REQUEST['transId']) : null;
    $reward = isset($_REQUEST['reward']) ? $this->db->escape_str($_REQUEST['reward']) : null;
    $country = isset($_REQUEST['country']) ? $this->db->escape_str($_REQUEST['country']) : null;
    $signature = isset($_REQUEST['signature']) ? $this->db->escape_str($_REQUEST['signature']) : null;

    $md5 = md5($userId.$transactionId.$reward.$secret);
    if($md5 != $signature) {
        echo "ERROR: Signature doesn't match";
        return;
    }
    
    if($this->data['settings']['proxy_detection'] == 'on') {
        if ($this->agent->is_browser()){
            $agent = $this->agent->browser().' '.$this->agent->version();
        }elseif ($this->agent->is_robot()){
            $agent = $this->agent->robot();
        }elseif ($this->agent->is_mobile()){
            $agent = $this->agent->mobile();
        }else{
            $agent = 'Unidentified User Agent';
        }
        
        $proxy = check_ip($userIp, $agent);
        if($proxy) {
            echo "ERROR: Proxy";
            return;
        }
    }
        
    $trans = $this->m_offerwall->getTransaction($transactionId, 'offeroc');
    if(!$trans){
		$this->m_offerwall->insertTransaction($userId, 'offeroc', $userIp, $reward, $transactionId, 2, time());
		$this->m_offerwall->updateUserBalance($userId, $reward);
			echo "OK";
        }else{
              echo "BUM";
        }

	}

	public function wannads()
	{
		if (!in_array($this->input->ip_address(), $this->data['whitelist_ips']['wannads'])) {
			echo 'ok';
			die();
		}
		$userId = isset($_GET['subId']) ? $this->db->escape_str($_GET['subId']) : null;
		$transactionId = isset($_GET['transId']) ? $this->db->escape_str($_GET['transId']) : null;
		$reward = isset($_GET['reward']) ? $this->db->escape_str($_GET['reward']) : null;
		$signature = isset($_GET['signature']) ? $this->db->escape_str($_GET['signature']) : null;
		$action = isset($_GET['status']) ? $this->db->escape_str($_GET['status']) : null;
		$userIp = isset($_GET['userIp']) ? $this->db->escape_str($_GET['userIp']) : "0.0.0.0";

		if (md5($userId . $transactionId . $reward . $this->data['settings']['wannads_secret_key']) != $signature) {
			echo "ERROR: Signature doesn't match";
			return;
		}

    if($this->data['settings']['proxy_detection'] == 'on') {
        if ($this->agent->is_browser()){
            $agent = $this->agent->browser().' '.$this->agent->version();
        }elseif ($this->agent->is_robot()){
            $agent = $this->agent->robot();
        }elseif ($this->agent->is_mobile()){
            $agent = $this->agent->mobile();
        }else{
            $agent = 'Unidentified User Agent';
        }
        
        $proxy = check_ip($userIp, $agent);
        if($proxy) {
            echo "ERROR: Proxy";
            return;
        }
    }

		$trans = $this->m_offerwall->getTransaction($transactionId, 'wannads');
		if ($action == 2) {
			$this->m_offerwall->reduceUserBalance($userId, abs($reward));
			$this->m_offerwall->insertTransaction($userId, 'wannads', $userIp, $reward, $transactionId, 1, time());
			echo "OK";
		} else {
			if (!$trans) {
					$offerId = $this->m_offerwall->insertTransaction($userId, 'wannads', $userIp, $reward, $transactionId, 2, time());
					$this->m_offerwall->updateUserBalance($userId, $reward);
				echo "OK";
			} else {
				echo "DUP";
			}
		}
	}

	public function offertoro()
	{
		if (!in_array($this->input->ip_address(), $this->data['whitelist_ips']['offertoro'])) {
			echo 'ok';
			die();
		}
		$secret = $this->data['settings']['offertoro_app_secret'];

		$userId = isset($_GET['user_id']) ? $this->db->escape_str($_GET['user_id']) : 2;
		$transactionId = isset($_GET['oid']) ? $this->db->escape_str($_GET['oid']) : null;
		$offerId = isset($_GET['oid']) ? $this->db->escape_str($_GET['oid']) : null;
		$reward = isset($_GET['amount']) ? $this->db->escape_str($_GET['amount']) : null;
		$ipAddress = isset($_GET['ip_address']) ? $this->db->escape_str($_GET['ip_address']) : null;
		$signature = isset($_GET['sig']) ? $this->db->escape_str($_GET['sig']) : null;

		if (md5($offerId . '-' . $userId . '-' . $secret) != $signature) {
			echo 0;
			return;
		}

    if($this->data['settings']['proxy_detection'] == 'on') {
        if ($this->agent->is_browser()){
            $agent = $this->agent->browser().' '.$this->agent->version();
        }elseif ($this->agent->is_robot()){
            $agent = $this->agent->robot();
        }elseif ($this->agent->is_mobile()){
            $agent = $this->agent->mobile();
        }else{
            $agent = 'Unidentified User Agent';
        }
        
        $proxy = check_ip($ipAddress, $agent);
        if($proxy) {
            echo "ERROR: Proxy";
            return;
        }
    }

		if ($reward < 0) {
			$this->m_offerwall->reduceUserBalance($userId, abs($reward));
			$this->m_offerwall->insertTransaction($userId, 'Offertoro', $ipAddress, $reward, $transactionId, 1, time());
			echo 1;
		} else {
			$trans = $this->m_offerwall->getTransaction($transactionId, 'offertoro');
			if (!$trans) {
					$offerId = $this->m_offerwall->insertTransaction($userId, 'offertoro', $ipAddress, $reward, $transactionId, 2, time());
					$this->m_offerwall->updateUserBalance($userId, $reward);
				echo 1;
			} else {
				echo 1;
			}
		}
	}

	public function cpx()
	{
		if (!in_array($this->input->ip_address(), $this->data['whitelist_ips']['cpx'])) {
			echo 'ok';
			die();
		}
		$secret = $this->data['settings']['cpx_hash'];
		$userId = isset($_GET['user_id']) ? $this->db->escape_str($_GET['user_id']) : null;
		$action = isset($_GET['status']) ? $this->db->escape_str($_GET['status']) : null;
		$transactionId = isset($_GET['trans_id']) ? $this->db->escape_str($_GET['trans_id']) : null;
		$reward = isset($_GET['amount_local']) ? $this->db->escape_str($_GET['amount_local']) : null;
		$userIp = isset($_GET['ip_click']) ? $this->db->escape_str($_GET['ip_click']) : "0.0.0.0";
		$signature = isset($_GET['hash']) ? $this->db->escape_str($_GET['hash']) : null;

		if (md5($transactionId . '-' . $secret) != $signature) {
			echo "ERROR: Signature doesn't match";
			return;
		}

    if($this->data['settings']['proxy_detection'] == 'on') {
        if ($this->agent->is_browser()){
            $agent = $this->agent->browser().' '.$this->agent->version();
        }elseif ($this->agent->is_robot()){
            $agent = $this->agent->robot();
        }elseif ($this->agent->is_mobile()){
            $agent = $this->agent->mobile();
        }else{
            $agent = 'Unidentified User Agent';
        }
        
        $proxy = check_ip($userIp, $agent);
        if($proxy) {
            echo "ERROR: Proxy";
            return;
        }
    }

		$trans = $this->m_offerwall->getTransaction($transactionId, 'CPX Research');
		if ($action == 2) {
			$this->m_offerwall->reduceUserBalance($userId, abs($reward));
			$this->m_offerwall->insertTransaction($userId, 'CPX Research', $userIp, $reward, $transactionId, 1, time());
			echo "OK";
		} else {
			if (!$trans) {
					$offerId = $this->m_offerwall->insertTransaction($userId, 'CPX Research', $userIp, $reward, $transactionId, 2, time());
					$this->m_offerwall->updateUserBalance($userId, $reward);
				echo "OK";
			} else {
				echo "DUP";
			}
		}
	}

	public function ayetstudios()
	{
		if (!in_array($this->input->ip_address(), $this->data['whitelist_ips']['ayetstudios'])) {
			echo 'ok';
			die();
		}
		$userId = isset($_REQUEST['uid']) ? $this->db->escape_str($_REQUEST['uid']) : null;
		$transactionId = isset($_REQUEST['transaction_id']) ? $this->db->escape_str($_REQUEST['transaction_id']) : null;
		$action = isset($_REQUEST['is_chargeback']) ? $this->db->escape_str($_REQUEST['is_chargeback']) : null;
		$reward = isset($_REQUEST['currency_amount']) ? $this->db->escape_str($_REQUEST['currency_amount']) : null;
		$userIp = isset($_REQUEST['ip']) ? $this->db->escape_str($_REQUEST['ip']) : "not available";
		$signature = isset($_SERVER['HTTP_X_AYETSTUDIOS_SECURITY_HASH']) ? $this->db->escape_str($_SERVER['HTTP_X_AYETSTUDIOS_SECURITY_HASH']) : null;

		ksort($_REQUEST, SORT_STRING);
		$sortedQueryString = http_build_query($_REQUEST, '', '&');
		$securityHash = hash_hmac('sha256', $sortedQueryString, $this->data['settings']['ayetstudios_api']);
		if ($securityHash != $signature) {
			echo "invalid signature";
			return;
		}

    if($this->data['settings']['proxy_detection'] == 'on') {
        if ($this->agent->is_browser()){
            $agent = $this->agent->browser().' '.$this->agent->version();
        }elseif ($this->agent->is_robot()){
            $agent = $this->agent->robot();
        }elseif ($this->agent->is_mobile()){
            $agent = $this->agent->mobile();
        }else{
            $agent = 'Unidentified User Agent';
        }
        
        $proxy = check_ip($userIp, $agent);
        if($proxy) {
            echo "ERROR: Proxy";
            return;
        }
    }

		$trans = $this->m_offerwall->getTransaction($transactionId, 'AyetStudios');
		if ($action == 1) {
			$this->m_offerwall->reduceUserBalance($userId, abs($reward));
			$this->m_offerwall->insertTransaction($userId, 'AyetStudios', $userIp, $reward, $transactionId, 1, time());
			echo "ok";
		} else {
			if (!$trans) {
					$offerId = $this->m_offerwall->insertTransaction($userId, 'AyetStudios', $userIp, $reward, $transactionId, 2, time());
					$this->m_offerwall->updateUserBalance($userId, $reward);
				echo "ok";
			} else {
				echo "ok";
			}
		}
	}
	public function odaddy()
	{
		$transactionId = $this->db->escape_str(urldecode($_GET["transaction_id"]));
		$offer_id = $this->db->escape_str(urldecode($_GET["offer_id"]));
		$reward = $this->db->escape_str(urldecode($_GET["amount"]));
		$userId = $this->db->escape_str(urldecode($_GET["userid"]));
		$signature = urldecode($_GET["signature"]);

		//Check the signature
		$validationSignature = md5($transactionId . "/" . $offer_id . "/" . $this->data['settings']['offerdaddy_app_key']);

		if ($validationSignature != trim($signature)) {
			echo "0";
			die();
		}

		$trans = $this->m_offerwall->getTransaction($transactionId, 'OfferDady');
		if ($reward < 0) {
			$this->m_offerwall->reduceUserBalance($userId, abs($reward));
			$this->m_offerwall->insertTransaction($userId, 'OfferDady', 'not available', $reward, $transactionId, 1, time());
			echo "1";
		} else {
			if (!$trans) {
					$offerId = $this->m_offerwall->insertTransaction($userId, 'OfferDady', 'not available', $reward, $transactionId, 2, time());
					$this->m_offerwall->updateUserBalance($userId, $reward);
				echo "1";
			} else {
				echo "1";
			}
		}
	}

	public function pollfish()
	{
		$transactionId = isset($_GET['tx_id']) ? $this->db->escape_str($_GET['tx_id']) : null;
		$reward = isset($_GET['reward_value']) ? $this->db->escape_str($_GET['reward_value']) : null;
		$status = isset($_GET['status']) ? $this->db->escape_str($_GET['status']) : null;
		$userId = isset($_GET['request_uuid']) ? $this->db->escape_str($_GET['request_uuid']) : null;
		$userIp = isset($_GET['user_ip']) ? $this->db->escape_str($_GET['user_ip']) : "not available";
		$signature = isset($_GET['signature']) ? $this->db->escape_str($_GET['signature']) : "null";

		$cpa = rawurldecode($_GET["cpa"]);
		$device_id = rawurldecode($_GET["device_id"]);
		$reward_name = rawurldecode($_GET["reward_name"]);
		$timestamp = rawurldecode($_GET["timestamp"]);

		$data = $cpa . ":" . $device_id;
		if (!empty($userId)) {
			$data = $data . ":" . $userId;
		}
		$data = $data . ":" . $reward_name . ":" . $reward . ":" . $status . ":" . $timestamp . ":" . $transactionId;

		$computedSignature = base64_encode(hash_hmac("sha1", $data, $this->data['settings']['pollfish_secret'], true));
		if ($signature == $computedSignature) {
			if ($status == 'eligible') {
					$offerId = $this->m_offerwall->insertTransaction($userId, 'Pollfish', $userIp, $reward, $transactionId, 2, time());
					$this->m_offerwall->updateUserBalance($userId, $reward);
				echo "1";
			} else {
				$this->m_offerwall->insertTransaction($userId, 'Pollfish', $userIp, $reward, $transactionId, 1, time());
			}
		}
	}
	
	public function bitswall()
	{
		if (!in_array($this->input->ip_address(), $this->data['whitelist_ips']['bitswall'])) {
			echo 'ok';
			die();
		}
        $bsecret = $this->data['settings']['bitswall_secret'];
        
		$userId = isset($_REQUEST['subId']) ? $this->db->escape_str($_REQUEST['subId']) : null;
		$transactionId = isset($_REQUEST['transId']) ? $this->db->escape_str($_REQUEST['transId']) : null;
		$reward = isset($_REQUEST['reward']) ? $this->db->escape_str($_REQUEST['reward']) : null;
		$userIp = isset($_REQUEST['userIp']) ? $this->db->escape_str($_REQUEST['userIp']) : "0.0.0.0";
		$signature = isset($_REQUEST['signature']) ? $this->db->escape_str($_REQUEST['signature']) : null;

		if (md5($userId . $transactionId . $reward . $bsecret) != $signature) {
			echo "ERROR: Signature doesn't match";
			return;
		}

    if($this->data['settings']['proxy_detection'] == 'on') {
        if ($this->agent->is_browser()){
            $agent = $this->agent->browser().' '.$this->agent->version();
        }elseif ($this->agent->is_robot()){
            $agent = $this->agent->robot();
        }elseif ($this->agent->is_mobile()){
            $agent = $this->agent->mobile();
        }else{
            $agent = 'Unidentified User Agent';
        }
        
        $proxy = check_ip($userIp, $agent);
        if($proxy) {
            echo "ERROR: Proxy";
            return;
        }
    }

		$trans = $this->m_offerwall->getTransaction($transactionId, 'Bitswall');
		if (!$trans) {
				$offerId = $this->m_offerwall->insertTransaction($userId, 'Bitswall', $userIp, $reward, $transactionId, 2, time());
				$this->m_offerwall->updateUserBalance($userId, $reward);
			echo "ok";
		} else {
			echo "BUM";
		}
	}	

}
