<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Faucet extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }

    public function index()
    {
    if (!isset($_SESSION["admin"])) {
        return redirect(site_url('admin'));
    }
        $this->data['page'] = 'Faucet Settings';
        $this->render('faucet', $this->data);
    }
}
