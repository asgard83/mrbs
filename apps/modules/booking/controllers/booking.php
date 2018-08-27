<?php
class Booking extends MY_Controller{
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

	public function attempt($dStart_dEnd, $iRoom_id)
	{
		if($this->newsession->userdata('isLogin'))
		{
			$this->load->model('booking/bookingmodel');
			$arr_dStart_dEnd = explode("-", $dStart_dEnd);
			$dStart = $arr_dStart_dEnd[0];
			$dEnd = $arr_dStart_dEnd[1];
			$arrdata = $this->bookingmodel->get_obj_booking_rooms($dStart, $dEnd, $iRoom_id);
			$this->content = $this->load->view('form_booking', $arrdata, true);
		}
		$this->index();
	}

	public function history()
	{
		if($this->newsession->userdata('isLogin'))
		{
			$this->load->model('booking/bookingmodel');
			$arrdata = $this->bookingmodel->get_ls_history();
			if($this->input->post("data-post")){
				echo $arrdata;
			}else{
				$this->content = $this->load->view('list/table', $arrdata, true);
				$this->index();
			}
		}
		else
		{
			redirect(site_url('welcome'));
			exit();
		}
	}

	public function verified()
	{
		if($this->newsession->userdata('isLogin'))
		{
			$this->load->model('booking/bookingmodel');
			$arrdata = $this->bookingmodel->get_ls_verified();
			if($this->input->post("data-post")){
				echo $arrdata;
			}else{
				$this->content = $this->load->view('list/table', $arrdata, true);
				$this->index();
			}
		}
		else
		{
			redirect(site_url('welcome'));
			exit();
		}
	}

	public function canceled()
	{
		if($this->newsession->userdata('isLogin'))
		{
			$this->load->model('booking/bookingmodel');
			$arrdata = $this->bookingmodel->get_ls_canceled();
			if($this->input->post("data-post")){
				echo $arrdata;
			}else{
				$this->content = $this->load->view('list/table', $arrdata, true);
				$this->index();
			}
		}
		else
		{
			redirect(site_url('welcome'));
			exit();
		}
	}

	public function approve()
	{
		if($this->newsession->userdata('isLogin'))
		{
			$this->load->model('booking/bookingmodel');
			$arrdata = $this->bookingmodel->get_ls_approve();
			if($this->input->post("data-post")){
				echo $arrdata;
			}else{
				$this->content = $this->load->view('list/table', $arrdata, true);
				$this->index();
			}
		}
		else
		{
			redirect(site_url('welcome'));
			exit();
		}
	}

	public function finished()
	{
		if($this->newsession->userdata('isLogin'))
		{
			$this->load->model('booking/bookingmodel');
			$arrdata = $this->bookingmodel->get_ls_finish();
			if($this->input->post("data-post")){
				echo $arrdata;
			}else{
				$this->content = $this->load->view('list/table', $arrdata, true);
				$this->index();
			}
		}
		else
		{
			redirect(site_url('welcome'));
			exit();
		}
	}

	public function suspended()
	{
		if($this->newsession->userdata('isLogin'))
		{
			$this->load->model('booking/bookingmodel');
			$arrdata = $this->bookingmodel->get_ls_suspended();
			if($this->input->post("data-post")){
				echo $arrdata;
			}else{
				$this->content = $this->load->view('list/table', $arrdata, true);
				$this->index();
			}
		}
		else
		{
			redirect(site_url('welcome'));
			exit();
		}
	}

	public function appeal($sStep)
	{
		if($this->newsession->userdata('isLogin'))
		{
			$this->load->model('booking/bookingmodel');
			$arrdata = $this->bookingmodel->get_ls_appeal($sStep);
			if($this->input->post("data-post")){
				echo $arrdata;
			}else{
				$this->content = $this->load->view('list/table', $arrdata, true);
				$this->index();
			}
		}
		else
		{
			redirect(site_url('welcome'));
			exit();
		}
	}

	public function rejected()
	{
		if($this->newsession->userdata('isLogin'))
		{
			$this->load->model('booking/bookingmodel');
			$arrdata = $this->bookingmodel->get_ls_rejected();
			if($this->input->post("data-post")){
				echo $arrdata;
			}else{
				$this->content = $this->load->view('list/table', $arrdata, true);
				$this->index();
			}
		}
		else
		{
			redirect(site_url('welcome'));
			exit();
		}
	}

}
?>