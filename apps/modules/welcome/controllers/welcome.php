<?php
class Welcome extends MY_Controller{
	var $content = "";
	public function index(){
		if($this->newsession->userdata('isLogin'))
		{ 
			redirect(site_url('dashboard'));
			exit();
		}
		else
		{
			$this->content = (!$this->content) ? $this->load->view('portal/default', '', true) : $this->content;
			$data = $this->main->set_content('signin', $this->content);
			$this->parser->parse('portal/home', $data);
		}
	}
		
}
?>