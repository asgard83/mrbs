<?php
class Post extends MY_Controller{
	var $content = "";

	public function __construct()
	{
		
	}

	public function index()
	{
		echo "Bad Request";
	}

	function set_booking_confirm(){
		if(strtolower($_SERVER['REQUEST_METHOD']) != "post" && !$this->newsession->userdata('isLogin'))
		{
			$msg = array('error' => 'Invalid or Bad Request');
		}
		else
		{
			$this->load->model('booking/bookingmodel');
			$msg = $this->bookingmodel->set_store_booking();
		}
		echo json_encode($msg);
	}

	function set_reference_rooms(){
		if(strtolower($_SERVER['REQUEST_METHOD']) != "post" && !$this->newsession->userdata('isLogin'))
		{
			$msg = array('error' => 'Invalid or Bad Request');
		}
		else
		{
			$this->load->model('rooms/roomsmodel');
			$msg = $this->roomsmodel->set_store_rooms();
		}
		echo json_encode($msg);
	}

	function set_booking_process(){
		if(strtolower($_SERVER['REQUEST_METHOD']) != "post" && !$this->newsession->userdata('isLogin'))
		{
			$msg = array('error' => 'Invalid or Bad Request');
		}
		else
		{
			$this->load->model('verified/verifiedmodel');
			$msg = $this->verifiedmodel->set_store_verified();
		}
		echo json_encode($msg);
	}

	function set_suspend_process()
	{
		if(strtolower($_SERVER['REQUEST_METHOD']) != "post" && !$this->newsession->userdata('isLogin'))
		{
			$msg = array('error' => 'Invalid or Bad Request');
		}
		else
		{
			$this->load->model('suspended/suspendedmodel');
			$msg = $this->suspendedmodel->set_store_suspend();
		}
		echo json_encode($msg);
	}
	

}
?>