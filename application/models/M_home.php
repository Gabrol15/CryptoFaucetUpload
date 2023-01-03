<?php
defined('BASEPATH') or exit('No direct script access allowed');
class M_Home extends CI_Model
{
	public function total_user()
	{
		return $this->db->query("SELECT COUNT(*) AS cnt FROM users")->result_array()[0]['cnt'];
	}
	public function countWithdrawals()
	{
		$lastWithdrawal = $this->db->query("SELECT * FROM withdraw_history ORDER BY id DESC LIMIT 1");
		if($lastWithdrawal->num_rows() == 0) {
			return 0;
		}
		return $lastWithdrawal->result_array()[0]['id'];
	}
	public function get_earning()
	{
		$this->db->select_sum('total_earned');
		return $this->db->get('users')->row()->total_earned;
	}
	
}
