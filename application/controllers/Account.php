<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Account extends Member_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_account');
		$this->load->library('form_validation');
	}
	public function index()
	{
		$this->data['page'] = 'Account Setting';

		$this->render('account', $this->data);
	}

	public function update_password()
	{
		$this->form_validation->set_rules('old_password', 'Old Password', 'trim|required|min_length[3]|md5');
		$this->form_validation->set_rules('password', 'New Password', 'trim|required|min_length[3]|md5');
		$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]|md5');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('message', faucet_alert('danger', validation_errors()));
			return redirect(site_url('account'));
		}
		if ($this->input->post('old_password') != $this->data['user']['password']) {
			$this->session->set_flashdata('message', faucet_alert('danger', 'Your current password is incorrect'));
			redirect(site_url('account'));
		}
		$password = $this->db->escape_str($this->input->post('password'));
		$this->m_account->update_password($this->data['user']['id'], $password);
		$this->session->set_flashdata('message', faucet_alert('success', 'Your password has been updated'));
		redirect(site_url('account'));
	}
	
}
