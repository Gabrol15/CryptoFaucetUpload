<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Advertise extends Member_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('string');
		$this->load->model('m_advertise');
	}

	public function add()
	{
		$this->load->library('form_validation');
		$this->load->helper('security');

		$this->form_validation->set_rules('name', 'Name', 'trim|required|min_length[1]|max_length[75]|xss_clean');
		$this->form_validation->set_rules('description', 'Description', 'trim|required|min_length[0]|max_length[75]|xss_clean');
		$this->form_validation->set_rules('url', 'Url', 'trim|required|min_length[10]|max_length[100]|valid_url|xss_clean');
		$this->form_validation->set_rules('view', 'View', 'trim|required|greater_than[0]|integer');
		$this->form_validation->set_rules('option', 'Option', 'trim|required|integer');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('sweet_message', faucet_sweet_alert('error', validation_errors()));
			return redirect(site_url('/ads'));
		}

		$name = strip_tags($this->db->escape_str($this->input->post('name')));
		$description = strip_tags($this->db->escape_str($this->input->post('description')));
		$url = $this->db->escape_str($this->input->post('url'));
		$view = $this->db->escape_str($this->input->post('view'));
		$option = $this->db->escape_str($this->input->post('option'));

		if (!filter_var($url, FILTER_VALIDATE_URL)) {
			$this->session->set_flashdata('sweet_message', faucet_sweet_alert('error', 'Invalid Url'));
			return redirect(site_url('/ads'));
		}

		$getOption = $this->m_advertise->validOption($option);
		if (!$getOption) {
			$this->session->set_flashdata('sweet_message', faucet_sweet_alert('error', '??? :D ???'));
			return redirect(site_url('/ads'));
		}
		if ($getOption['min_view'] > $view) {
			$this->session->set_flashdata('sweet_message', faucet_sweet_alert('error', 'You have to purchase at least ' . $getOption['min_view'] . ' views'));
			return redirect(site_url('/ads'));
		}

		$cost = $view * $getOption['price'];
		if ($cost > $this->data['user']['dep_balance']) {
			$this->session->set_flashdata('sweet_message', faucet_sweet_alert('error', 'You don\'t have enough money'));
			return redirect(site_url('/ads'));
		}

		$this->m_advertise->add($this->data['user']['id'], $name, $description, $getOption['reward'], $getOption['timer'], $url, $view, $getOption['id']);
		$this->m_advertise->reduceBalance($this->data['user']['id'], $cost);
        
        $this->session->set_flashdata('message', faucet_sweet_alert('success', 'Your Ads is pending for admin approval.'));
		redirect(site_url('ads'));
	}

	public function add_view($adId)
	{
		if (!is_numeric($adId)) {
			return redirect(site_url('/ads'));
		}
		$this->load->library('form_validation');
		$this->form_validation->set_rules('view', 'View', 'trim|required|greater_than[0]|integer');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('sweet_message', faucet_sweet_alert('error', validation_errors()));
			return redirect(site_url('/ads'));
		}
		$view = $this->db->escape_str($this->input->post('view'));
		$ad = $this->m_advertise->validAds($this->data['user']['id'], $adId);
		if (!$ad) {
			return redirect(site_url('/ads'));
		}

		$amount = $ad['price'] * $view;
		if ($this->data['user']['dep_balance'] < $amount) {
			return redirect(site_url('/ads'));
		}

		$this->m_advertise->addView($adId, $view);
		$this->m_advertise->reduceBalance($this->data['user']['id'], $amount);
		$this->session->set_flashdata('message', faucet_sweet_alert('success', 'You have added views to campaign #' . $adId . ' successful.'));
		return redirect(site_url('/ads'));
	}

	public function pause($id = 0)
	{
		if (!is_numeric($id)) {
			return redirect(site_url('/ads'));
		}

		$ad = $this->m_advertise->validAds($this->data['user']['id'], $id);
		if (!$ad) {
			return redirect(site_url('/ads'));
		}

		if ($ad['status'] == 'pending') {
			$this->session->set_flashdata('sweet_message', faucet_sweet_alert('error', 'You have to wait for admin to approve this ad'));
			return redirect(site_url('/ads'));
		}
		$this->m_advertise->pause($id);
        $this->session->set_flashdata('message', faucet_sweet_alert('success', 'Your campaign #' . $id . ' has been paused.'));
		return redirect(site_url('/ads'));
	}

	public function start($id = 0)
	{
		if (!is_numeric($id)) {
			return redirect(site_url('/ads'));
		}

		$ad = $this->m_advertise->validAds($this->data['user']['id'], $id);
		if (!$ad) {
			return redirect(site_url('/ads'));
		}

		if ($ad['status'] == 'pending') {
			$this->session->set_flashdata('sweet_message', faucet_sweet_alert('error', 'You have to wait for admin to approve this ad'));
			return redirect(site_url('/ads'));
		}
		$this->m_advertise->start($id);
        $this->session->set_flashdata('message', faucet_sweet_alert('success', 'Your campaign #' . $id . ' has been started.'));
		return redirect(site_url('/ads'));
	}

	public function delete($id = 0)
	{
		if (!is_numeric($id)) {
			return redirect(site_url('/ads'));
		}

		$ad = $this->m_advertise->validAds($this->data['user']['id'], $id);
		if (!$ad) {
			return redirect(site_url('/ads'));
		}

		$refund = ($ad['total_view'] - $ad['views']) * $ad['reward'];
		$this->m_advertise->delete($id, $ad['owner'], $refund);
        $this->session->set_flashdata('message', faucet_sweet_alert('success', 'Your campaign #' . $id . ' has been deleted.'));
		return redirect(site_url('/ads'));
	}
}
