<?php
class AuthenticationModel extends CI_Model{

	public function attempt()
	{
		if ($this->newsession->userdata('keycode_ses') != str_replace(' ', '', $this->input->post('cpth')))
		{
			return array('error' => 'Kode Verifikasi Tidak Sesuai');
			exit();
		}
		else
		{
			$username = 'asgard83';
			$password = 'IndonesiA';
			$data = array(
					'nip'      	=> $this->input->post('uid'),
					'password' 	=> $this->input->post('pwd')
			);
			$data_string = json_encode($data);
			$curl = curl_init('http://192.168.5.22/siasn/services/api/auth/login');
			curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($curl, CURLOPT_HTTPHEADER, array(
				'Content-Type: application/json',
				'Content-Length: ' . strlen($data_string))
			);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
			curl_setopt($curl, CURLOPT_USERPWD, $username . ':' . $password);
			$result = curl_exec($curl);
			curl_close($curl);
			$data = json_decode($result, true);
			if((int)$data['status'] == 200)
			{
				$datsess = array();
				$datsess = $data['data'];
				$datsess['isLogin'] = TRUE;

				$arr_log = array('LOG_ID' => "LOG-".str_replace("-", "", date('Y-m-d')). '-'.rand(pow(10, 10-1), pow(10, 10)-1),
								 'LOG_USER_NAME' => $data['data']['SESS_PEG_NIP'],
								 'LOG_FULL_NAME' => $data['data']['SESS_NAMA'],
								 'LOG_COMMENT' => 'Autentikasi login service SIASN',
								 'LOG_ACTION' => 'login',
								 'LOG_CREATE_AT' => date("Y-m-d H:i:s"));
				$this->db->insert('app_logs', $arr_log);
				if($this->db->affected_rows() > 0)
				{
					$this->newsession->set_userdata($datsess);
					return array('message' => 'Otentikasi pengguna sesuai',
								 'returnurl' => site_url('dashboard'), 
								 'error' => '');
				}
				else
				{
					return array('error' => 'Autentikasi gagal');
				}
			}
			else
			{
				return array('error' => $data['messages']);
			}
		}	
	}


	public function attempt_()
	{
		if ($this->newsession->userdata('keycode_ses') != str_replace(' ', '', $this->input->post('cpth')))
		{
			return array('error' => 'Kode Verifikasi Tidak Sesuai');
			exit();
		 }
		 
		 $pwd = md5($this->input->post('pwd'));
		 $match = FALSE;
		 $next = FALSE;
		 
		 $query = "SELECT A.USER_ID, A.USER_NAME, A.USER_FIRST_NAME, A.USER_LAST_NAME, B.ROLE_ID 
				   FROM sys_users A 
				   LEFT JOIN sys_users_roles B ON A.USER_ID = B.USER_ID
				   WHERE A.USER_NAME = '".$this->input->post('uid')."' 
				   AND A.USER_STATUS = 1";
		 $data = $this->main->get_result($query);
		 if($data){
			 foreach($query->result_array() as $row)
			 {
				 $datsess = $row;
			 }
			 $next = TRUE;
		 }
		 
		 if($next)
		 {
			 $storepwd = $this->main->get_uraian("SELECT USER_PASSWORD FROM sys_users WHERE USER_NAME = '".$this->input->post('uid')."'","USER_PASSWORD");
			 if($storepwd == $pwd)
			 {
				 $match = TRUE;
			 }
		 }
		 
		 if($match)
		 {
			 $data = array('USER_LAST_LOGIN' => date('Y-m-d H:i:s'));
			 $this->db->where('USER_NAME', $this->input->post('uid'));
			 $this->db->where('USER_PASSWORD', $storepwd);
			 $this->db->update('sys_users', $data);
			 if($this->db->affected_rows() == 1)
			 {
				 $datsess['isLogin'] = TRUE;
				 $this->newsession->set_userdata($datsess);
				 return array('message' => 'Otentikasi pengguna sesuai',
							  'returnurl' => site_url('dashboard'),
							  'error' => '');
			 }
			 else
			 {
				 return array('error' => 'Proses otentikasi pengguna gagal.');
			 }
		 }
		 else
		 {
			 return array('error' => 'Otentikasi pengguna tidak sesuai.');
		 }
	}
}
?>