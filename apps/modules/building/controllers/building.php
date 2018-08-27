<?php
class Building extends MY_Controller{
	var $content = "";

	public function __construct()
	{
		$this->load->model('dashboard/dashboardmodel');
		$this->load->model('building/buildingmodel');
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
			$set_default['buildings'] = $this->dashboardmodel->get_building();
			$this->content = (!$this->content) ? $this->load->view('backend/default', '', true) : $this->content;
			$data = $this->main->set_content('dashboard', $this->content);
			$this->parser->parse('backend/dashboard', $data);
		}
	}

	function detail($id)
	{
		if($this->newsession->userdata('isLogin'))
		{
			$arrdata = $this->buildingmodel->get_room_building($id);
			$this->content = $this->load->view('building/building_room', $arrdata, true);
			$this->index();
		}
	}
}
?>