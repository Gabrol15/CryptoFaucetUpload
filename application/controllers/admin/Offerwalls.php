<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Offerwalls extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model(['m_cronjob', 'm_offerwall']);
    }
    public function index()
    {
        $this->data['page'] = 'Offerwall settings';
        $this->render('offerwall', $this->data);
    }
    
    public function history()
    {
        $this->data['page'] = 'Offerwalls History';

        $skip = (isset($_GET['per_page']) && is_numeric($_GET['per_page'])) ? $_GET['per_page'] : 0;

        $this->load->library('pagination');
        $this->load->config('pagination');
        $config = $this->config->item('pagination_config');

        $this->data['records'] = $this->m_admin->getApprovedOfferwall($skip);
        $config['base_url'] = site_url('admin/offerwalls/approved/');
        $config['total_rows'] = $this->m_admin->countApprovedOfferwall();

        $config['page_query_string'] = TRUE;
        $this->pagination->initialize($config);
        $this->data['pagination'] = $this->pagination->create_links();
        $this->render('offerwall_history', $this->data);
    }

}
