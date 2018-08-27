<?php
class Rooms extends MY_Controller{
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

	public function create($iRoom_Id)
	{
		if($this->newsession->userdata('isLogin'))
		{
			$this->load->model('roomsmodel');
			$arr_obj = $this->roomsmodel->get_obj_rooms($iRoom_Id);
			$this->content = $this->load->view('create', $arr_obj, true);
		}
		$this->index();
	}

}
?>