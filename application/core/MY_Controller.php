 <?php defined('BASEPATH') or exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->data = array();
		$this->load->driver('cache');
		$this->data['settings'] = $this->m_core->getSettings();
		$this->data['csrf_name'] = $this->security->get_csrf_token_name();
		$this->data['csrf_hash'] = $this->security->get_csrf_hash();
	}
}
class Guess_Controller extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		if($this->data['settings']['status'] == 'off' && current_url() != site_url('maintenance')) {
			return redirect(site_url('maintenance'));
		}

	}
	
	protected function render($template, $data)
	{
		$contents = $this->load->view('user_template/' . $template, $data, TRUE);
		$data['contents'] = $contents;
		$this->load->view('user_template/template', $data);
	}
}

class Admin_Controller extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model(array('m_admin'));
		$this->load->helper('date');
		
$userId = $this->db->escape_str($this->session->userdata('admin'));

			if (!$userId && current_url() != site_url('admin') && current_url() != site_url('admin/auth/login')){
					return redirect(admin);
			} 
	}
	protected function render($template, $data)
	{
		$contents = $this->load->view('admin_template/' . $template, $data, TRUE);
		$data['contents'] = $contents;
		$this->load->view('admin_template/template', $data);
	}
}

class Member_Controller extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
        $this->load->model('m_achievements');
		if($this->data['settings']['status'] == 'off' && current_url() != site_url('maintenance')) {
			return redirect(site_url('maintenance'));
		}

		$userId = $this->db->escape_str($this->session->userdata('FID'));
			if (!$userId && current_url() != site_url() && current_url() != site_url('login') && current_url() != site_url('register') && current_url() != site_url('maintenance') && current_url() != site_url('forgot-password')){
					return redirect(site_url());
			} 
		if ($userId != NULL ){
			
		$user = $this->m_core->get_user_from_id($userId);

		$this->data["referralCount"] = $this->m_core->get_ref($user["id"]);
		
    if($this->data['settings']['achievement_status'] == 'on') {
    $this->data['achievements'] = $this->m_achievements->getAchievements($user["id"]);

    for ($i = 0; $i < count($this->data['achievements']); ++$i) {
      if ($this->data['achievements'][$i]['type'] == 0) {
        $this->data['achievements'][$i]['completed'] = $this->m_achievements->checkFaucet($user["id"]);
        $this->data['achievements'][$i]['description'] = 'Complete ' . $this->data['achievements'][$i]['condition'] . ' faucet claims';
      } else if ($this->data['achievements'][$i]['type'] == 1) {
        $this->data['achievements'][$i]['completed'] = $this->m_achievements->checkLink($user["id"]);
        $this->data['achievements'][$i]['description'] = 'Complete ' . $this->data['achievements'][$i]['condition'] . ' shortlinks';
      } else if ($this->data['achievements'][$i]['type'] == 2) {
        $this->data['achievements'][$i]['completed'] = $this->m_achievements->checkPtc($user["id"]);
        $this->data['achievements'][$i]['description'] = 'View ' . $this->data['achievements'][$i]['condition'] . ' PTC Ads';
      }

      $this->data['achievements'][$i]['progress'] = min(100, $this->data['achievements'][$i]['completed'] * 100 / $this->data['achievements'][$i]['condition']);
        }
    }
		$this->data['user'] = $user;
		
		}
		$this->data['methods'] = $this->db->get('currencies')->result_array();		
		
	}

	protected function render($template, $data)
	{
		$contents = $this->load->view('user_template/' . $template, $data, TRUE);
		$data['contents'] = $contents;
		$this->load->view('user_template/template', $data);
	}
}
