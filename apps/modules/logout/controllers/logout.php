<?php
class logout extends MY_Controller{

	public function index()
	{
		$this->newsession->sess_destroy();
		redirect(base_url());
		exit();
		/*$data = array('USER_LAST_LOGOUT' => date("Y-m-d H:i:s"));
		$this->db->where('USER_ID', $this->newsession->userdata('USER_ID'));
		$this->db->update('sys_users', $data);
		if($this->db->affected_rows() == 1){
			$this->newsession->sess_destroy();
			redirect(base_url());
			exit();
		}*/
	}
}
?>