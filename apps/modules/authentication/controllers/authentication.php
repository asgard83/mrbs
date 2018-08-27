<?php
class Authentication extends MY_Controller{

	public function index()
	{
		
	}

	public function get_login($sess, $isajax)
	{
		if(strtolower($_SERVER['REQUEST_METHOD']) != "post") {
			$msg = array('error' => 'Invalid or Bad Request');
		}
		if($this->newsession->userdata('keycode_ses') != str_replace(' ', '', $this->input->post('cpth')))
		{
			$msg = array('error' => 'Kode Verifikasi Tidak Sesuai');
		}
		else
		{
			$this->load->model('authentication/authenticationmodel');
			$msg = $this->authenticationmodel->attempt();
		}
		echo json_encode($msg);
	}
		
}
?>