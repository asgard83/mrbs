<?php
class Search extends MY_Controller{
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

	public function available($iBuilding_Id_iRoom_Id, $dTime)
	{
		if($this->newsession->userdata('isLogin'))
		{
			$this->load->model('searchmodel');
			$arr_iBuilding_Id_iRoom_Id = explode("-", $iBuilding_Id_iRoom_Id);
			$iBuilding_Id = $arr_iBuilding_Id_iRoom_Id[0];
			$iRoom_Id = $arr_iBuilding_Id_iRoom_Id[1];
			$arr_obj = $this->searchmodel->get_availablity_rooms($iBuilding_Id, $iRoom_Id, $dTime);
			$this->content = $this->load->view('available', $arr_obj, true);
		}
		$this->index();
	}

	public function rooms($dTime, $iCapacity_iBuilding_Id)
	{
		if($this->newsession->userdata('isLogin'))
		{
			$this->load->model('searchmodel');
			$arr_iCapacity_iBuilding 	= explode("-", $iCapacity_iBuilding_Id);
			$iCapacity 					= $arr_iCapacity_iBuilding[0];
			$iBuilding_Id 				= $arr_iCapacity_iBuilding[1];
			$arr_obj 					= $this->searchmodel->get_rooms_availablity($dTime, $iCapacity, $iBuilding_Id);
			$this->content 				= $this->load->view('result', $arr_obj, true);
		}
		$this->index();
	}

}
?>