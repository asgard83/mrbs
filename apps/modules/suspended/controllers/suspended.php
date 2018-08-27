<?php
class Suspended extends MY_Controller{
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
			$set_default['buildings'] = $this->dashboardmodel->get_building();
			$this->content = (!$this->content) ? $this->load->view('backend/default', '', true) : $this->content;
			$data = $this->main->set_content('dashboard', $this->content);
			$this->parser->parse('backend/dashboard', $data);
		}
	}

	public function detail($iBooking_Id)
	{
		if($this->newsession->userdata('isLogin'))
		{
			$this->load->model('suspended/suspendedmodel');
			$arrdata = $this->suspendedmodel->get_obj_booking_rooms($iBooking_Id);
			$this->content = $this->load->view('suspended', $arrdata, true);
		}
		$this->index();
	}

}
?>