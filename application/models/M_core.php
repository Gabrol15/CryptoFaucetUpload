<?php
defined('BASEPATH') or exit('No direct script access allowed');
class M_Core extends CI_Model
{
   public function get_ref($id)
    {
        return $this->db->get_where('users', array('referred_by' => $id))->num_rows();
    }	
	public function update_ref($id, $amount)
	{
		$this->db->where('id', $id);
		$this->db->set('balance', 'balance+' . $amount, FALSE);
		$this->db->update('users');
	}
    public function checkSameWallet($userId, $wallet)
    {
        $check = $this->db->get_where('withdraw_history', array('wallet' => $wallet, 'user_id<>' => $userId));
        if ($check->num_rows() == 0) {
            return false;
        }
        return $check->result_array();
    }
    public function update_wallet($user_id, $wallet)
    {
        $this->db->where('id', $user_id);
        $this->db->set('wallet', $wallet);
        $this->db->update('users');
    }
    public function add_energy($user_id, $energy)
    {
        $this->db->where('id', $user_id);
        $this->db->set('energy', 'energy+'.$energy, false);
        $this->db->update('users');
    }
	public function getSettings()
	{
		$settings = $this->db->get('settings')->result_array();
		foreach ($settings as $value) {
			$result[$value['name']] = $value['value'];
		}
		return $result;
	}
	public function update_active($id)
	{
		$this->db->where('id', $id);
		$this->db->set('ip_address', $this->input->ip_address());
		$this->db->set('last_active', time());
		$this->db->set('token', random_string('alnum', 30));
		$this->db->update('users');
	}	
    public function reduce_balance($id, $amount)
    {
        $this->db->where('id', $id);
        $this->db->set('balance', 'balance-' . $amount, FALSE);
        $this->db->set('last_active', time());
        $this->db->update('users');
    }
    public function insert_wd_history($uid, $method, $wallet, $amount, $usd, $type)
    {
        $insert = array(
            'method' => $method,
            'wallet' => $wallet,
            'user_id' => $uid,
            'type' => $type,
            'ip_address' => $this->input->ip_address(),
            'amount' => $amount,
            'amountusd' => $usd,
            'claim_time' => time()
        );
        $this->db->insert('withdraw_history', $insert);
    }
    
	public function get_wd_history()
	{
		return $this->db->query("SELECT * FROM withdraw_history ORDER BY id DESC LIMIT 20")->result_array();
	}
	public function get_cheater($id)
	{
		return $this->db->query("SELECT * FROM cheat_logs WHERE user_id = $id")->result_array()[0];
	}

    public function findCheatLog($userId)
    {
        $check = $this->db->get_where('cheat_logs', ['user_id' => $userId]);
        return $check->num_rows() != 0;
    }	
	
	public function counalltHistory()
	{
		$lastWithdrawal = $this->db->query("SELECT * FROM withdraw_history ORDER BY id DESC LIMIT 1");
		if($lastWithdrawal->num_rows() == 0) {
			return 0;
		}
		return $lastWithdrawal->result_array()[0]['id'];
	}
	
	public function countLinkHistory($user_id)
	{
		$past = time() - 86400;
		$ip_address = $this->input->ip_address();
		return $this->db->query("SELECT COUNT(link_id) as cnt FROM link_history WHERE claim_time>$past AND (ip_address='$ip_address' OR user_id=$user_id)")->result_array()[0]['cnt'];
	}
	
	public function countAllLinksView()
	{
		return $this->db->query("SELECT IFNULL(SUM(view_per_day), 0) as cnt FROM links")->result_array()[0]['cnt'];
	}

	public function get_user_from_id($id)
	{
		$user = $this->db->get_where('users', array('id' => $id));
		if ($user->num_rows() == 0) {
			return false;
		}
		return $user->result_array()[0];
	}
	public function get_user_from_email($email)
	{
		$user = $this->db->get_where('users', array('email' => $email));
		if ($user->num_rows() == 0) {
			return false;
		}
		return $user->result_array()[0];
	}

	public function lastActive($userId)
	{
		return $this->db->query("SELECT last_active FROM users WHERE id = " . $userId)->result_array()[0]['last_active'];
	}

	public function updateIsocode($id, $isocode, $country)
	{
		$this->db->where('id', $id);
		$this->db->set('isocode', $isocode);
		$this->db->set('country', $country);
		$this->db->update('users');
	}

	public function claim_fail($id, $status)
	{
		if (is_numeric($status)) {
			if ($status >= 4) {
				$this->db->set('status', 'Cheating');
			} else {
				$this->db->set('status', $status + 1);
			}
			$this->db->where('id', $id);
			$this->db->update('users');
		}
	}

	public function newIp()
	{
		$ipAddress = $this->input->ip_address();
		$check = $this->db->query("SELECT COUNT(*) as cnt FROM ip_addresses WHERE ip_address='" . $ipAddress . "'")->result_array()[0]['cnt'];
		return ($check == 0);
	}

	public function newIpUser($userId)
	{
		$check = $this->db->query("SELECT COUNT(*) as cnt FROM ip_addresses WHERE user_id = " . $userId)->result_array()[0]['cnt'];
		return ($check == 0);
	}

	public function insertNewIp($userId)
	{
		$insert = [
			'user_id' => $userId,
			'ip_address' => $this->input->ip_address(),
			'last_use' => time()
		];
		$this->db->insert('ip_addresses', $insert);
	}

	public function updateIpLastUse($userId)
	{
		$this->db->set('last_use', time());
		$this->db->set('ip_address', $this->input->ip_address());
		$this->db->where('user_id', $userId);
		$this->db->update('ip_addresses');
	}

	public function getCurrency($code)
	{
		$currency = $this->db->get_where('currencies', array('code' => $code));
		if ($currency->num_rows() == 0) {
			return false;
		}
		return $currency->result_array()[0];
	}

	public function insertCheatLog($userId, $log, $relateId, $ipAddress = false)
	{
		if (!$ipAddress) {
			$ipAddress = $this->input->ip_address();
		}
		$insert = [
			'user_id' => $userId,
			'log' => $log,
			'ip_address' => $ipAddress,
			'relate_id' => $relateId,
			'create_time' => time()
		];
		$this->db->insert('cheat_logs', $insert);
		return $this->db->insert_id();
	}

	public function getCurrencies()
	{
		return $this->db->get('currencies')->result_array();
	}
	public function firewallLock($userId)
	{
		$this->db->set('status', 'firewall');
		$this->db->where('id', $userId);
		$this->db->update('users');
	}
	public function unlockFirewall($userId)
	{
		$this->db->set('status', 'ok');
		$this->db->set('last_firewall', time());
		$this->db->where('id', $userId);
		$this->db->update('users');
	}
	public function wrongCaptcha($userId)
	{
		$this->db->set('fail', 'fail+1', FALSE);
		$this->db->where('id', $userId);
		$this->db->update('users');
	}
	public function resetFail($userId)
	{
		$this->db->set('fail', '0');
		$this->db->where('id', $userId);
		$this->db->update('users');
	}
	
	public function get_offerwall_history($id)
	{
		$this->db->order_by('claim_time', "desc")->limit(20);
		return $this->db->get_where('offerwall_history', array('user_id' => $id))->result_array();
	}

}
