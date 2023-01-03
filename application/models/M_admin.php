<?php
defined('BASEPATH') or exit('No direct script access allowed');
class M_Admin extends CI_Model
{
	public function getStats()
	{
		$this->db->order_by('date', 'desc');
		$date = date("Y-m-d", time() - 86400 * 15);
		$today = date("Y-m-d", time());
		return $this->db->get_where('faucet_stats', ['date>' => $date, 'date<' => $today])->result_array();
	}

	public function countActiveUsers($today)
	{
		return $this->db->query("SELECT COUNT(*) AS cnt FROM users WHERE last_active >= " . $today)->result_array()[0]['cnt'];
	}

	public function countNewUsers($today)
	{
		return $this->db->query("SELECT COUNT(*) AS cnt FROM users WHERE joined >= " . $today)->result_array()[0]['cnt'];
	}

	public function faucetStat($today)
	{
		return $this->db->query("SELECT COUNT(*) AS cnt, IFNULL(SUM(amount), 0) AS amount FROM withdraw_history WHERE claim_time >= " . $today)->result_array()[0];
	}

	public function info()
	{
		$result['totalUser'] = $this->db->query('SELECT COUNT(id) AS cnt FROM users WHERE 1')->result_array()[0]['cnt'];
		$today = strtotime('today midnight');
		$yesterday = strtotime('yesterday midnight');
		$result['activeToday'] = $this->db->query('SELECT COUNT(id) AS cnt FROM users WHERE last_active > ' . $today)->result_array()[0]['cnt'];
		$result['NotactiveToday'] = $this->db->query('SELECT COUNT(id) AS cnt FROM users WHERE last_active < ' . $today)->result_array()[0]['cnt'];
		
		$result['registerToday'] = $this->db->query('SELECT COUNT(id) AS cnt FROM users WHERE joined > ' . $today)->result_array()[0]['cnt'];
		return $result;
	}

	public function clear_banned()
	{
		$past = time() - 86400;
		$user = $this->db->delete('cheat_logs', array('create_time <=' => $past));	
	}
	public function count_all_users()
	{
		return $this->db->query("SELECT COUNT(*) AS cnt FROM users")->result_array()[0]['cnt'];
	}

	public function get_users($skip)
	{
		$past = time() - 86400;
		$now = strtotime("now");
		$this->db->order_by('id', "desc")->limit(50, $skip);
		return $this->db->get_where('users', array('last_active <' => $past))->result_array();
	}
	
	public function get_referrals($id)
	{
		$this->db->order_by('id', "desc");
		return $this->db->get_where('users', array('referred_by' => $id))->result_array();
	}

	public function get_withdrawal($id)
	{
		$result = $this->db->get_where('withdraw_history', array('id' => $id));
		if (!$result->num_rows()) {
			return false;
		}
		return $result->result_array()[0];
	}
	public function active($id)
	{
		$this->db->where('id', $id);
		$this->db->set('verified', '1');
		$this->db->update('users');
	}

	public function getCurrency()
	{
		return $this->db->get('currencies')->result_array();
	}

	public function addCurrency($name, $currencyName, $code, $api, $wallet, $reward, $energy_reward, $timer, $limit,$min, $price)
	{
		$insert = array(
			'name' => $name,
			'currency_name' => $currencyName,
			'code' => $code,
			'api' => $api,
			'wallet' => $wallet,
			'reward' => $reward,
			'energy_reward' => $energy_reward,
			'timer' => $timer,
			'price' => $price,
			'last_price' => $price,
			'limit_claim' => $limit,
			'min_claim' => $min
		);
		$this->db->insert('currencies', $insert);
	}
	public function updateCurrency($id, $name, $currencyName, $code, $api, $wallet, $reward, $energy_reward, $timer, $limit, $min)
	{
		$this->db->where('id', $id);
		$this->db->set('name', $name);
		$this->db->set('currency_name', $currencyName);
		$this->db->set('code', $code);
		$this->db->set('api', $api);
		$this->db->set('wallet', $wallet);
		$this->db->set('reward', $reward);
		$this->db->set('energy_reward', $energy_reward);
		$this->db->set('timer', $timer);
		$this->db->set('limit_claim', $limit);
		$this->db->set('min_claim', $min);
		$this->db->update('currencies');
	}

	public function get_user($id)
	{
		return $this->db->get_where('users', array('id' => $id))->result_array()[0];
	}

	public function sameIp($ipAddress, $id)
	{
		return $this->db->get_where('users', array('ip_address' => $ipAddress, 'ip_address<>' => 'removed', 'id<>' => $id))->result_array();
	}

	public function addAuthenticator($secret)
	{
		$this->db->set('value', $secret);
		$this->db->where('name', 'authenticator_code');
		$this->db->update('settings');
	}
	
	public function add_link($name, $url, $reward, $energy_reward, $view)
	{
		$insert = array(
			'name' => $name,
			'url' => $url,
			'reward' => $reward,
			'energy_reward' => $energy_reward,
			'view_per_day' => $view
		);
		$this->db->insert('links', $insert);
	}
	public function update_link($id, $name, $url, $reward, $energy_reward, $view)
	{
		$this->db->where('id', $id);
		$this->db->set('name', $name);
		$this->db->set('url', $url);
		$this->db->set('reward', $reward);
		$this->db->set('energy_reward', $energy_reward);
		$this->db->set('view_per_day', $view);
		$this->db->update('links');
	}

	public function getAcceptedAds()
	{
		return $this->db->query("SELECT ptc_ads.*, users.username FROM ptc_ads, users WHERE ptc_ads.owner <> 0 AND (ptc_ads.status = 'active' OR ptc_ads.status = 'paused') AND ptc_ads.owner = users.id ORDER BY id DESC LIMIT 50")->result_array();
	}

	public function countAcceptedAds()
	{
		return $this->db->query("SELECT COUNT(*) AS cnt FROM ptc_ads WHERE ptc_ads.owner <> 0 AND (ptc_ads.status = 'active' OR ptc_ads.status = 'paused')")->result_array()[0]['cnt'];
	}

	public function getPendingAds()
	{
		return $this->db->query("SELECT ptc_ads.*, users.username FROM ptc_ads, users WHERE ptc_ads.owner <> 0 AND ptc_ads.status = 'pending' AND ptc_ads.owner = users.id ORDER BY id DESC LIMIT 50")->result_array();
	}

	public function countPendingAds()
	{
		return $this->db->query("SELECT COUNT(*) AS cnt FROM ptc_ads WHERE ptc_ads.owner <> 0 AND ptc_ads.status = 'pending'")->result_array()[0]['cnt'];
	}

	public function getCompletedAds()
	{
		return $this->db->query("SELECT ptc_ads.*, users.username FROM ptc_ads, users WHERE ptc_ads.owner <> 0 AND ptc_ads.status = 'completed' AND ptc_ads.owner = users.id ORDER BY id DESC LIMIT 50")->result_array();
	}

	public function countCompletedAds()
	{
		return $this->db->query("SELECT COUNT(*) AS cnt FROM ptc_ads WHERE ptc_ads.owner <> 0 AND ptc_ads.status = 'completed'")->result_array()[0]['cnt'];
	}

	public function getAdsByAdmin()
	{
		return $this->db->query("SELECT * FROM ptc_ads WHERE owner = 0 ORDER BY id DESC LIMIT 50")->result_array();
	}

	public function countAdminAds()
	{
		return $this->db->query("SELECT COUNT(*) AS cnt FROM ptc_ads WHERE ptc_ads.owner = 0")->result_array()[0]['cnt'];
	}

	public function addOption($price, $reward, $timer, $minView)
	{
		$this->db->insert('ptc_option', array(
			'price' => $price,
			'reward' => $reward,
			'timer' => $timer,
			'min_view' => $minView
		));
	}
	public function updateOption($optionId, $price, $reward, $timer, $minView)
	{
		$this->db->set('price', $price);
		$this->db->set('reward', $reward);
		$this->db->set('timer', $timer);
		$this->db->set('min_view', $minView);
		$this->db->where('id', $optionId);
		$this->db->update('ptc_option');
	}

	public function getApprovedOfferwall($skip)
	{
		return $this->db->query("SELECT offerwall_history.*, users.username, users.isocode, users.country, users.id AS user_id FROM offerwall_history, users WHERE offerwall_history.status = 2 AND offerwall_history.user_id = users.id ORDER BY id DESC LIMIT 50 OFFSET " . $skip)->result_array();
	}
	public function countApprovedOfferwall()
	{
		return $this->db->query("SELECT COUNT(id) AS cnt FROM offerwall_history WHERE status = 2")->result_array()[0]['cnt'];
	}

}
