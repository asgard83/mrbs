<?php
class Reference extends MY_Controller{
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
			$set_default = $this->dashboardmodel->get_arr_schedule();
			$this->content = (!$this->content) ? $this->load->view('backend/default', $set_default, true) : $this->content;
			$data = $this->main->set_content('dashboard', $this->content);
			$this->parser->parse('backend/dashboard', $data);
		}
	}

	public function rooms()
	{
		if($this->newsession->userdata('isLogin'))
		{
			$this->load->model('reference/roomsmodel');
			$arrdata = $this->roomsmodel->get_ls_rooms();
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