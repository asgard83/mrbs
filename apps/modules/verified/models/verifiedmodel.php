<?php
class VerifiedModel extends CI_Model{
	var $arrext = array('.jpg', '.JPG', '.jpeg', '.JPEG', ".png", ".PNG");
	public function get_obj_booking_rooms($iBooking_Id)
	{
		if($this->newsession->userdata('isLogin') AND ($this->newsession->userdata('SESS_PANGKAT_ID') == '2' OR $this->newsession->userdata('SESS_PANGKAT_ID') == '3' OR $this->newsession->userdata('SESS_PANGKAT_ID') == '4' OR $this->newsession->userdata('SESS_PANGKAT_ID') == '5'))
		{
			$arr_obj_booking = array();
			$arr_obj_booking['action'] = site_url('post/set_booking_process');
			$sql_rooms = "SELECT A.BOOKED_ID, A.BOOKED_ROOM_NAME, A.BOOKED_ROOM_CAPACITY, 
						  B.ROOM_NAME, B.ROOM_PABX, B.ROOM_PIC,
						  B.ROOM_FACILITIES, B.ROOM_PHOTO, A.BOOKED_EVENT_NAME,
						  DATE_FORMAT(A.BOOKED_EVENT_START, '%d-%m-%Y') AS BOOKED_EVENT_START,
						  DATE_FORMAT(A.BOOKED_EVENT_FINISH, '%d-%m-%Y') AS BOOKED_EVENT_FINISH,
						  DATE_FORMAT(A.BOOKED_EVENT_START, '%H:%i') AS TIME_START,
						  DATE_FORMAT(A.BOOKED_EVENT_FINISH, '%H:%i') AS TIME_END,
						  CASE 
						  WHEN A.BOOKED_EVENT_TYPE = 0 THEN 'Internal'
						  ELSE 'External'
						  END AS BOOKED_EVENT_TYPE,
						  A.BOOKED_EVENT_LEADER, A.BOOKED_EVENT_PIC, A.BOOKED_EVENT_INVITATION, A.BOOKED_EVENT_DESCRIPTION,
						  CONCAT(C.USER_FIRST_NAME, ' ', C.USER_LAST_NAME) AS PIC, A.BOOKED_EVENT_PIC_PHONE,
						  A.BOOKED_EVENT_ATTACHMENT, A.BOOKED_SUSPENDED, A.BOOKED_STATUS,
						  A.BOOKED_EVENT_ATTACHMENT_CLOSED, 
						  A.BOOKED_CREATE_BY
						  FROM app_booked A LEFT JOIN app_rooms B ON A.BOOKED_ROOM_ID = B.ROOM_ID
						  LEFT JOIN sys_users C ON A.BOOKED_CREATE_BY = C.USER_ID
						  WHERE A.BOOKED_ID = '".$iBooking_Id."'";
			$bl_data = $this->main->get_result($sql_rooms);
			if($bl_data)
			{
				foreach($sql_rooms->result_array() as $row_rooms)
				{
					$arr_obj_booking['obj_booking'] = $row_rooms;
				}
				$arr_obj_booking['sRules'] = hashids_encrypt($this->main->get_uraian("SELECT REFF_CODE FROM sys_reference WHERE REFF_GROUP = '9999' AND REFF_CODE = 9","REFF_CODE"), _HASHIDS_, 3);
				$arr_obj_booking['obj_log'] = $this->db->query("SELECT A.BOOKED_LOG_ID, A.BOOKED_LOG_SERIAL,
																A.BOOKED_LOG_COMMENT, 
																DATE_FORMAT(A.BOOKED_LOG_CREATE_DATE, '%Y-%m-%d') AS BOOKED_LOG_CREATE_DATE,
																DATE_FORMAT(A.BOOKED_LOG_CREATE_DATE, '%Y-%m-%d') AS LOG_DATE,
																DATE_FORMAT(A.BOOKED_LOG_CREATE_DATE, '%H:%i:%s') AS LOG_TIME,
																TRIM(LTRIM(RTRIM(A.BOOKED_LOG_NAME))) AS USER_NAME
																FROM app_booked_log A 
																WHERE A.BOOKED_LOG_ID = '".$iBooking_Id."'")->result_array();
				$bAppeal = (int)$this->main->get_uraian("SELECT COUNT(*) AS JML FROM app_appeal WHERE APPEAL_BOOKED_ID = '".$iBooking_Id."'","JML");
				if($bAppeal > 0)
				{
					$sQuery_Appeal = "SELECT A.APPEAL_ID, A.APPEAL_ROOM_ID,
									  B.ROOM_NAME, B.ROOM_PABX, B.ROOM_PIC,
									  B.ROOM_FACILITIES, B.ROOM_PHOTO
									  FROM app_appeal A
									  LEFT JOIN app_rooms B ON A.APPEAL_ROOM_ID = B.ROOM_ID
									  WHERE A.APPEAL_BOOKED_ID = '".$iBooking_Id."'";
					$bl_data_appeal = $this->main->get_result($sQuery_Appeal);
					if($bl_data_appeal)
					{
						foreach($sQuery_Appeal->result_array() as $row_appeal)
						{
							$arr_obj_booking['obj_appeal'] = $row_appeal;
						}
					}
				}
			}

			if((int)$this->newsession->userdata('SESS_RT') == 1)
			{
				/**
				 * Proses verifikasi oleh bagian rumah tangga
				 */
				$arr_obj_booking['obj_verified'] = $this->main->set_verified($row_rooms['BOOKED_STATUS'], $this->newsession->userdata('SESS_PANGKAT_ID'), 0);
			}
			else
			{ 
				if((int)$this->newsession->userdata('SESS_TU_PIM') == 1)
				{
					$arr_obj_booking['obj_verified'] = $this->main->set_verified($row_rooms['BOOKED_STATUS'], $this->newsession->userdata('SESS_PANGKAT_ID'), 2);
				}
				else
				{
					$arr_obj_booking['obj_verified'] = $this->main->set_verified($row_rooms['BOOKED_STATUS'], $this->newsession->userdata('SESS_PANGKAT_ID'), 1);
				}
			}
			return $arr_obj_booking;
		}
	}


	function set_store_verified()
	{
		if($this->newsession->userdata('isLogin') AND ($this->newsession->userdata('SESS_PANGKAT_ID') == '2' OR $this->newsession->userdata('SESS_PANGKAT_ID') == '3' OR $this->newsession->userdata('SESS_PANGKAT_ID') == '4'  OR $this->newsession->userdata('SESS_PANGKAT_ID') == '5'))
		{ 
			$response = FALSE;
			if((int)hashids_decrypt($this->input->post('sRules'), _HASHIDS_, 3) == 9)
			{	
				$arr_update = $this->main->post_to_query($this->input->post('obj_data'));
				
				$iCheck_Id = (int)$this->main->get_uraian("SELECT COUNT(*) AS VALID FROM app_booked WHERE BOOKED_ID ='".$arr_update['BOOKED_ID']."'","VALID");
				if($iCheck_Id == 0)
				{
					return array('error' => 'Data pemesanan tidak dikenali');
					die();
				}

				$sBooked_Id 						= $arr_update['BOOKED_ID'];
				$iStatus 							= $arr_update['BOOKED_STATUS'];
				$arr_update['BOOKED_STATUS'] 		= $this->input->post('SESUDAH');
				$arr_update['BOOKED_UPDATE_DATE'] 	= date("Y-m-d H:i:s");
				$arr_update['BOOKED_UPDATE_BY'] 	= $this->newsession->userdata('SESS_PEG_ID');
				if($this->input->post('SESUDAH') == '6')
				{	
					$dir = './mrbs-content/'. date("Y")."/".date("m")."/".date("d");
					if(!empty($_FILES['BOOKED_EVENT_ATTACHMENT_CLOSED']['error'])){
						switch ($_FILES['BOOKED_EVENT_ATTACHMENT_CLOSED']['error']){
						  case '1':
							return array('error' => '404',
								 'message' => 'The uploaded file exceeds the upload_max_filesize directive in php.ini');
							break;
						  case '2':
							return array('error' => '404',
								 'message' => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form');
							break;
						  case '3':
							return array('error' => '404',
										 'message' => 'The uploaded file was only partially uploaded');
							break;
						  case '4':
							return array('error' => '404',
										 'message' => 'The uploded file was not found');
							break;
						  case '6':
							return array('error' => '404',
										 'message' => 'Missing a temporary folder');
							break;
						  case '7':
							return array('error' => '404',
										 'message' => 'Failed to write file to disk');
							break;
						  case '8':
							return array('error' => '404',
										 'message' => 'File upload stopped by extension');
							break;
						  case '999':
						  default:
							return array('error' => '404',
										 'message' => 'No error code avaiable');
						}
					}else if(!in_array($this->main->allowed($_FILES['BOOKED_EVENT_ATTACHMENT_CLOSED']['name']), $this->arrext)){
						return array('error' => '404',
									 'message' => 'Upload file hanya diperbolehkan dalam bentuk .pdf atau .jpg');
						die();
					}else if(empty($_FILES['BOOKED_EVENT_ATTACHMENT_CLOSED']['tmp_name']) || $_FILES['BOOKED_EVENT_ATTACHMENT_CLOSED']['tmp_name'] == 'none'){
						return array('error' => '404',
									 'message' => 'File Upload di temukan');
						die();
					}else{
						if(file_exists($dir) && is_dir($dir)){
							$config['upload_path'] = $dir;
						}else{
							if(mkdir($dir, 0777, true)){
								if(chmod($dir, 0777)){
									$config['upload_path'] = $dir;
								}
							}
						}
						$config['allowed_types'] = 'jpg|jpeg|pdf|png';
						$config['remove_spaces'] = TRUE;
						$ext = pathinfo($_FILES['BOOKED_EVENT_ATTACHMENT_CLOSED']['name'], PATHINFO_EXTENSION);
						$config['file_name'] = "MRBS-" . date("Ymdhis") . "-" . substr(str_shuffle(str_repeat('0123456789', 5)), 0, 5) . "." . $ext;
						$this->load->library('upload', $config);
						$this->upload->display_errors('', '');
						if(!$this->upload->do_upload("BOOKED_EVENT_ATTACHMENT_CLOSED")){
							return array('error' => '404',
										 'message' => $this->upload->display_errors());
						}else{
							$data = $this->upload->data();
							$arr_update['BOOKED_EVENT_ATTACHMENT_CLOSED'] = $dir . '/' . $config['file_name'];
						}
					}
				}
				if((int)$this->input->post('SESUDAH') == 14)
				{
					$arr_update['BOOKED_APPEAL_STATUS'] = 2;
				}
				else
				{
					$arr_update['BOOKED_APPEAL_STATUS'] = 1;
				}

				if($this->input->post('BOOKED_SUSPENDED'))
				{
					if(((int)$iStatus == 9 && (int)$this->input->post('SESUDAH') == 3) OR ((int)$iStatus == 11 && (int)$this->input->post('SESUDAH') == 14)) 
					{
						$sQuery_Rooms = "SELECT ROOM_ID, ROOM_NAME, ROOM_BUILDING_ID, ROOM_FLOOR, ROOM_MIN_CAPACITY, ROOM_MAX_CAPACITY FROM app_rooms WHERE ROOM_ID = ". $this->input->post('APPEAL_ROOM_ID');
						$bl_data_rooms = $this->main->get_result($sQuery_Rooms);
						if($bl_data_rooms)
						{
							foreach($sQuery_Rooms->result_array() as $row_rooms)
							{
								$arr_update['BOOKED_ROOM_ID']	 		= $row_rooms['ROOM_ID'];
								$arr_update['BOOKED_ROOM_BUILDING_ID'] 	= $row_rooms['ROOM_BUILDING_ID'];
								$arr_update['BOOKED_ROOM_FLOOR'] 		= $row_rooms['ROOM_FLOOR'];
								$arr_update['BOOKED_ROOM_NAME'] 		= $row_rooms['ROOM_NAME'];
								$arr_update['BOOKED_ROOM_CAPACITY'] 	= $row_rooms['ROOM_MIN_CAPACITY'] . '-' . $row_rooms['ROOM_MAX_CAPACITY'];

							}
						}
					}

				}

				$this->db->trans_begin();
				$this->db->where('BOOKED_ID', $sBooked_Id);
				$this->db->where('BOOKED_STATUS', $iStatus);
				$this->db->update('app_booked', $arr_update);
				if($this->db->affected_rows() == 1)
				{
					$arr_booking_log = array(
						'BOOKED_LOG_ID' => $arr_update['BOOKED_ID'],
						'BOOKED_LOG_SERIAL' => (int)$this->main->get_uraian("SELECT MAX(BOOKED_LOG_SERIAL) AS MAX_LOG FROM app_booked_log WHERE BOOKED_LOG_ID = '".$arr_update['BOOKED_ID']."'","MAX_LOG") + 1,
						'BOOKED_LOG_COMMENT' => $this->input->post('BOOKED_LOG_COMMENT'),
						'BOOKED_LOG_NIP' => $this->newsession->userdata('SESS_PEG_NIP'),
						'BOOKED_LOG_NAME' => $this->newsession->userdata('SESS_NAMA'),
						'BOOKED_LOG_STATUS' => $this->input->post('SESUDAH'),
						'BOOKED_LOG_CREATE_DATE' => date("Y-m-d H:i:s"),
						'BOOKED_LOG_CREATE_BY' => $this->newsession->userdata('SESS_PEG_ID')
					);
					$this->db->insert('app_booked_log', $arr_booking_log);
					if($this->db->affected_rows() > 0)
					{
						$response = TRUE;
					}
				}

				if($this->db->trans_status() === FALSE || !$response)
				{
					$this->db->trans_rollback();
					return array('error' => '404',
								 'message' => 'Data pemesanan ruangan rapat gagal di proses');
				}else
				{
					$this->db->trans_commit();
					if($this->input->post('SESUDAH') == 9)
					{
						$redirect = site_url('suspended/detail/' . $sBooked_Id);
					}
					else if($this->input->post('SESUDAH') == 13)
					{
						$redirect = site_url('booking/appeal/approved');	
					}
					else if($this->input->post('SESUDAH') == 14)
					{
						$redirect = site_url('booking/appeal/rejected');	
					}
					else
					{
						if($this->newsession->userdata('SESS_RT'))
							$redirect = site_url('booking/verified');
						else
							$redirect = site_url('booking/history');
					}
					return array('error' => '',
								 'message' => 'Data berhasil diproses ...',
								 'returnurl' => $redirect);
				}
			}
		}
	}
}
?>