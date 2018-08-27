<?php
class Events extends MY_Controller{
	var $content = "";

	public function __construct()
	{
		$this->load->model('dashboard/dashboardmodel');
	}

	public function index()
	{
		if(!$this->newsession->userdata('isLogin'))
		{ 
			redirect(site_url('welcome'));
			exit();
		}
		else
		{
			$arr_dashboard = $this->dashboardmodel->get_arr_dashboard();
			$this->content = (!$this->content) ? $this->load->view('backend/default', $arr_dashboard, true) : $this->content;
			$data = $this->main->set_content('dashboard', $this->content);
			$this->parser->parse('backend/dashboard', $data);
		}
	}

	public function post($dEvent)
	{
		if($this->newsession->userdata('isLogin'))
		{
			$this->load->model('eventsmodel');
			$arr_obj 					= $this->eventsmodel->get_rooms_events($dEvent);
			$this->content 				= $this->load->view('post', $arr_obj, true);
		}
		$this->index();
	}


}
?>