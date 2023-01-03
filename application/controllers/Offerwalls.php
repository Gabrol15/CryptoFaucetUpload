<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Offerwalls extends Member_Controller
{
	public function __construct()
	{
		parent::__construct();

		if ($this->data['settings']['offerwall_status'] != 'on') {
			return redirect(site_url('dashboard'));
		}
	}
	public function index()
	{
		$this->data['page'] = 'Offerwalls';
        $this->data['offerwalls'] = true;
		$this->data['offerwall_history'] = $this->m_core->get_offerwall_history($this->data['user']['id']);
		$this->render('offerwalls', $this->data);
	}
	public function cpx()
	{
		if ($this->data['settings']['cpx_status'] != 'on') {
			return redirect(site_url('offerwalls'));
		}

		$this->data['page'] = 'CPX Research';
		$this->data['iframe'] = '<div style="max-width: 950px; margin: auto" id="fullscreen"></div>
		<script>
const script1 = {
    div_id: "fullscreen",
    theme_style: 1,
    order_by: 2,
    limit_surveys: 12
};
const config = {
	general_config: {
		app_id: ' . $this->data['settings']['cpx_app_id'] . ',
		ext_user_id: "' . $this->data['user']['id'] . '", // string
		 email: "' . $this->data['user']['email'] . '", // string
		 username: "' . $this->data['user']['username'] . '", // string
	   secure_hash: "' . md5($this->data['user']['id'] . '-' . $this->data['settings']['cpx_hash']) . '",
	},
    style_config: {
        text_color: "#2b2b2b",
        survey_box: {
            topbar_background_color: "#ffaf20",
            box_background_color: "white",
            rounded_borders: true,
            stars_filled: "black",
        },
    },
    script_config: [script1],
    debug: false,
     useIFrame: true,
     iFramePosition: 1,
    functions: {
        no_surveys_available: () =>
        {
            console.log("no surveys available function here");
        },
        count_new_surveys: (countsurveys) =>
        {
            console.log("count surveys function here, count:", countsurveys);
        },
        get_all_surveys: (surveys) =>
        {
            console.log("get all surveys function here, surveys: ", surveys);
        },
        get_transaction: (transactions) =>
        {
            console.log("transaction function here, transaction: ", transactions);
        }
  }
  };
window.config = config;
</script>
		<script type="text/javascript" src="https://cdn.cpx-research.com/assets/js/script_tag_v2.0.js"></script>';
		$this->render('offerwalls', $this->data);
	}
	public function wannads()
	{
		if ($this->data['settings']['wannads_status'] != 'on') {
			return redirect(site_url('offerwalls'));
		}

		$this->data['page'] = 'Wannads Offerwall';
		$this->data['iframe'] = '<iframe style="width:100%; height:800px; border:0; padding:0; margin:0;" scrolling="yes" "frameborder="0" src="https://wall.wannads.com/wall?apiKey=' . $this->data['settings']['wannads_api_key'] . '&userId=' . $this->data['user']['id'] . '"></iframe>';
		$this->render('offerwalls', $this->data);
	}
	public function offertoro()
	{
		if ($this->data['settings']['offertoro_status'] != 'on') {
			return redirect(site_url('offerwalls'));
		}

		$this->data['page'] = 'OfferToro Offerwall';
		$this->data['iframe'] = '<iframe src="https://www.offertoro.com/ifr/show/' . $this->data['settings']['offertoro_pub_id'] . '/' . $this->data['user']['id'] . '	/' . $this->data['settings']['offertoro_app_id'] . '" frameborder="0" width="860" height="2400" ></iframe> ';
		$this->render('offerwalls', $this->data);
	}
	public function ayetstudios()
	{
		if ($this->data['settings']['ayetstudios_status'] != 'on') {
			return redirect(site_url('offerwalls'));
		}

		$this->data['page'] = 'AyetStudios Offerwall';
		$this->data['iframe'] = '<iframe src="https://www.ayetstudios.com/offers/web_offerwall/' . $this->data['settings']['ayetstudios_id'] . '?external_identifier=' . $this->data['user']['id'] . '" frameborder="0" width="860" height="2400" ></iframe> ';
		$this->render('offerwalls', $this->data);
	}
	public function offerdaddy()
	{
		if ($this->data['settings']['offerdaddy_status'] != 'on') {
			return redirect(site_url('offerwalls'));
		}

		$this->data['page'] = 'OfferDaddy Offerwall';
		$this->data['iframe'] = '<iframe src="https://www.offerdaddy.com/wall/' . $this->data['settings']['offerdaddy_app_token'] . '/' . $this->data['user']['id'] . '" frameborder="0" width="860" height="2400" ></iframe> ';
		$this->render('offerwalls', $this->data);
	}

	public function pollfish()
	{
		if ($this->data['settings']['pollfish_status'] != 'on') {
			return redirect(site_url('offerwalls'));
		}
		$this->data['page'] = 'Pollfish Offerwall';
		$userId = $this->data['user']['id'];
		$this->data['iframe'] = '<script>
		var pollfishConfig = {
			api_key: "' . $this->data['settings']['pollfish_api'] . '",
			user_id: "' . $userId . '",
			indicator_position: "BOTTOM_RIGHT",
			debug: true,
			ready: pollfishReady,
		  };
		  function pollfishReady(){
			Pollfish.showFullSurvey();
		  }
		  </script><script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
		  <script src="https://storage.googleapis.com/pollfish_production/sdk/webplugin/pollfish.min.js"></script>';
		$this->render('offerwalls', $this->data);
	}
	public function bitswall()
	{
		if ($this->data['settings']['bitswall_status'] != 'on') {
			return redirect(site_url('offerwalls'));
		}

		$this->data['page'] = 'Bitswall Offerwall';
		$this->data['iframe'] = '<iframe style="width:100%;height:800px;border:0;padding:0;margin:0;" scrolling="yes" frameborder="0" src="https://bitswall.net/offerwall/' . $this->data['settings']['bitswall_api'] . '/' . $this->data['user']['id'] . '"></iframe>';
		$this->render('offerwalls', $this->data);
	}
	public function offeroc()
	{
		if ($this->data['settings']['offeroc_status'] != 'on') {
			return redirect(site_url('offerwalls'));
		}

		$this->data['page'] = 'Offeroc Offerwall';
		$this->data['iframe'] = '<iframe style="width:100%;height:800px;border:0;padding:0;margin:0;" scrolling="yes" frameborder="0" src="https://offeroc.com/offerwall/' . $this->data['settings']['offeroc_api'] . '/' . $this->data['user']['id'] . '"></iframe>';
		$this->render('offerwalls', $this->data);
	}
}
