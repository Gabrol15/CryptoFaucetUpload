<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Achievements extends Member_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('m_achievements');
  }

  public function claim($id = 0)
  {

    if (!is_numeric($id)) {
      return redirect(site_url('dashboard'));
    }

    $achievement = $this->m_achievements->getAchievementFromId($id);
    if (!$achievement) {
      return redirect(site_url('dashboard'));
    }

    if (!$this->m_achievements->checkHistory($id, $this->data['user']['id'])) {
    return redirect(site_url('dashboard'));
    }

    if  ($achievement['type'] == 1) {
      if ($achievement['condition'] > $this->m_achievements->checkLink($this->data['user']['id'])) {
    return redirect(site_url('dashboard'));
      }
    } else if ($achievement['type'] == 2) {
      if ($achievement['condition'] > $this->m_achievements->checkPtc($this->data['user']['id'])) {
    return redirect(site_url('dashboard'));
      }
    }

    $this->m_achievements->updateUser($this->data['user']['id'], $achievement['reward_usd'], $achievement['reward_energy']);

    $this->m_achievements->insertHistory($this->data['user']['id'], $achievement['id'], $achievement['reward_usd']);
    $this->session->set_flashdata('sweet_message', faucet_sweet_alert('success', $achievement['reward_usd'] . ' USD and '.$achievement['reward_energy'].' Energy have been added to your balance'));
    return redirect(site_url('dashboard'));
  }
}
