<?php
class Request extends MY_Controller{
	var $content = "";

	public function __construct()
	{
		
	}

	public function index()
	{
		echo "Bad Request";
	}

	function get_rooms(){
		if(strtolower($_SERVER['REQUEST_METHOD']) != "post" && !$this->newsession->userdata('isLogin'))
		{
			$msg = array('error' => 'Invalid or Bad Request');
		}
		else
		{
			$this->load->model('dashboard/dashboardmodel');
			$msg = $this->dashboardmodel->set_cb_rooms();
		}
		echo json_encode($msg);
	}

	function get_layout_capacity()
	{

		if(strtolower($_SERVER['REQUEST_METHOD']) != "post" && !$this->newsession->userdata('isLogin'))
		{
			$msg = array('error' => 'Invalid or Bad Request');
		}
		else
		{
			$this->load->model('dashboard/dashboardmodel');
			$msg = $this->dashboardmodel->set_cb_layout_capacity();
		}
		echo json_encode($msg);	
	}

	function get_search_availabity_rooms_()
	{
		if(strtolower($_SERVER['REQUEST_METHOD']) != "post" && $this->newsession->userdata('isLogin'))
		{
			redirect(base_url());
			exit();
		}
		else
		{
			$iBuiling_Id = hashids_encrypt($this->input->post('building_id'),_HASHIDS_,6);
			$iRooms_Id = hashids_encrypt($this->input->post('room_id'),_HASHIDS_,6);
			$arr_json = array('code' => '200',
							  'redirect' => site_url('search/available/'.$iBuiling_Id.'-'.$iRooms_Id.'/'.$this->input->post('txt_schedule')),
							  'error' => '');
			echo json_encode($arr_json);
		}
	}

	function get_search_availabity_rooms()
	{
		if(strtolower($_SERVER['REQUEST_METHOD']) != "post" && $this->newsession->userdata('isLogin'))
		{
			redirect(base_url());
			exit();
		}
		else
		{
			$dTime = strtotime("+1 day", strtotime($this->input->post('txt_schedule')));
			$iCapacity = hashids_encrypt($this->input->post('capacity'),_HASHIDS_,10);
			$iBuiling_Id = empty($this->input->post('building')) ? hashids_encrypt(0,_HASHIDS_,6) : hashids_encrypt($this->input->post('building'),_HASHIDS_,6);
			$arr_json = array('code' => '200',
							  'redirect' => site_url('search/rooms/'.$dTime.'/'.$iCapacity.'-'.$iBuiling_Id),
							  'error' => '');
			echo json_encode($arr_json);
		}
	}

	function get_booking_rooms()
	{
		if(strtolower($_SERVER['REQUEST_METHOD']) != "post" && $this->newsession->userdata('isLogin'))
		{
			redirect(base_url());
			exit();
		}
		else
		{
			$dStart = $this->input->post('dStart');
			$dEnd = $this->input->post('dEnd');
			$iRoom_id = $this->input->post('iRoom_id');
			$arr_json = array('code' => '200',
							  'redirect' => site_url('booking/attempt/'.$dStart.'-'.$dEnd.'/'.$iRoom_id),
							  'error' => '');
			echo json_encode($arr_json);
		}
	}

	function get_quick_finder_events(){
		if(strtolower($_SERVER['REQUEST_METHOD']) != "post")
		{
			$msg = array('title' => 'Autorisasi tidak diperkenankan',
						 'start' => date("Y-m-d"));
		}
		else
		{
			$this->load->model('dashboard/dashboardmodel');
			$msg = $this->dashboardmodel->set_quick_finder_events();
		}
		echo json_encode($msg);
	}

}
?>