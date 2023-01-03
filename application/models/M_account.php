<?php
defined('BASEPATH') or exit('No direct script access allowed');
class M_Account extends CI_Model
{

	public function update_password($user_id, $password)
	{
		$this->db->where('id', $user_id);
		$this->db->set('password', $password);
		$this->db->set('last_active', time());
		$this->db->update('users');
	}

}
