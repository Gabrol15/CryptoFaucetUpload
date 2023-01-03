<?php
defined("BASEPATH") or exit("No direct script access allowed");

class Home extends Member_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper("string");
        $this->load->model("m_home");
        $this->load->library("form_validation");
    if (isset($_SESSION['FID'])) { 
    return redirect(site_url('dashboard'));
    }		
    }
    public function index()
    {
		if($this->data['settings']['status'] == 'off') {
			return redirect(site_url('maintenance'));
		}

        $this->data["totaluser"] = $this->m_home->total_user();
        $this->data["totalwd"] = $this->m_home->countWithdrawals();
        $this->data["totalearn"] = $this->m_home->get_earning();

            $this->data["page"] = 'Home';
            if (isset($_GET["r"])) {
                $this->session->set_userdata("referral", $_GET["r"]);
            }
            $this->render("home", $this->data);
    }
    
	public function login()
	{
		$this->data['captcha_display'] = get_captcha($this->data['settings'], base_url(), 'login_captcha');
		$this->data['page'] = 'Login';
		$this->render("login", $this->data);
	}

	public function register()
	{
		$this->data['captcha_display'] = get_captcha($this->data['settings'], base_url(), 'login_captcha');
		$this->data['page'] = 'Register';
		$this->render("register", $this->data);
	}

	public function forgot_password()
	{
		$this->data['captcha_display'] = get_captcha($this->data['settings'], base_url(), 'login_captcha');
		$this->data['page'] = 'Forgot Password';
		$this->render("recovery", $this->data);
	}
}