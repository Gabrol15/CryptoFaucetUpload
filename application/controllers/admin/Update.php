<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Update extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }

    public function index($from)
    {
    if (!isset($_SESSION["admin"])) {
        return redirect(site_url('admin'));
    }

        foreach (array_keys($this->m_core->getSettings()) as $key) {
            $newValue = $this->input->post($key);
            if ($key == 'password') {
                $newValue = hash("sha256", $this->input->post($key));
            }
            if (isset($_POST[$key]) && $_POST[$key] != $this->data['settings'][$key]) {
                $this->db->set('value', $newValue);
                $this->db->where('name', $key);
                $this->db->update('settings');
            }
        }
        return redirect(site_url('/admin/' . $from));
    }


    public function favicon()
    {
        $config = [
            'upload_path' => './assets/images',
            'allowed_types' => 'ico',
            'max_size' => 10240,
            'max_width' => 1024,
            'max_height' => 768,
            'file_name' => 'favicon.ico',
            'overwrite' => TRUE
        ];

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('favicon')) {
            $this->session->set_flashdata('message', faucet_alert('danger', $this->upload->display_errors()));
        } else {
            $this->session->set_flashdata('message', faucet_alert('success', 'Upload success!'));
        }
        redirect(site_url('admin/settings'));
    }

    public function logo()
    {
        $config = [
            'upload_path' => './assets/images',
            'allowed_types' => 'png',
            'max_size' => 10240,
            'max_width' => 1024,
            'max_height' => 768,
            'file_name' => 'logo.png',
            'overwrite' => TRUE
        ];

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('logo')) {
            $this->session->set_flashdata('message', faucet_alert('danger', $this->upload->display_errors()));
        } else {
            $this->session->set_flashdata('message', faucet_alert('success', 'Upload success!'));
        }
        redirect(site_url('admin/settings'));
    }
}
