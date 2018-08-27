<?php
class SuspendedModel extends CI_Model{
	var $arrext = array('.jpg', '.JPG', '.jpeg', '.JPEG', ".png", ".PNG");
	public function get_obj_booking_rooms($iBooking_Id)
	{
		if($this->newsession->userdata('isLogin') AND ($this->newsession->userdata('SESS_PANGKAT_ID') == '3' OR $this->newsession->userdata('SESS_PANGKAT_ID') == '4' OR $this->newsession->userdata('SESS_PANGKAT_ID') == '5') AND (int)$this->newsession->userdata('SESS_RT') == 1)
		{
			$arr_obj_booking = array();
			$arr_obj_booking['action'] = site_url('post/set_suspend_process');
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
						  END AS BOOKED_EVENT_TYPE, A.BOOKED_ROOM_ID,
						  A.BOOKED_EVENT_LEADER, A.BOOKED_EVENT_PIC, A.BOOKED_EVENT_INVITATION, A.BOOKED_EVENT_DESCRIPTION,
						  CONCAT(C.USER_FIRST_NAME, ' ', C.USER_LAST_NAME) AS PIC, A.BOOKED_EVENT_PIC_PHONE,
						  A.BOOKED_EVENT_ATTACHMENT, A.BOOKED_STATUS,
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
				$sParameters = $this->db->query("SELECT A.BOOKED_ROOM_ID, A.BOOKED_ROOM_CAPACITY, DATE_FORMAT(A.BOOKED_EVENT_START, '%d-%m-%Y') AS BOOKED_EVENT
FROM app_booked A WHERE A.BOOKED_ID = '".$iBooking_Id."'")->result_array();
				$arr_capacity = explode("-", $sParameters[0]['BOOKED_ROOM_CAPACITY']);
				
				$sql_building_rooms = "SELECT *, (( EVENT_REAL / 8) * 100) AS PERCENT FROM (SELECT A.ROOM_NAME, A.ROOM_ID, A.ROOM_BUILDING_ID, A.ROOM_PHOTO, A.ROOM_FACILITIES, 
								   A.ROOM_MIN_CAPACITY, A.ROOM_MAX_CAPACITY,
								   IFNULL(SUM(TIME_TO_SEC(TIMEDIFF(B.BOOKED_EVENT_FINISH, B.BOOKED_EVENT_START)) / 3600), 0) AS EVENT_REAL
								   FROM app_rooms A LEFT JOIN app_booked B ON A.ROOM_ID = B.BOOKED_ROOM_ID
								   AND DATE_FORMAT(B.BOOKED_EVENT_START, '%d-%m-%Y') = '".$sParameters[0]['BOOKED_EVENT']."'
								   AND B.BOOKED_STATUS = 1
								   GROUP BY A.ROOM_NAME ORDER BY A.ROOM_MIN_CAPACITY ASC) AS DATA";
				$sql_building_rooms .= " WHERE ROOM_MIN_CAPACITY >= ".$arr_capacity[0]."";
				$sql_building_rooms .= " AND ROOM_ID NOT IN (".$sParameters[0]['BOOKED_ROOM_ID'].")";
				$sql_building_rooms .= " ORDER BY PERCENT DESC";
				$bl_data_building_rooms = $this->main->get_result($sql_building_rooms);
				if($bl_data_building_rooms)
				{
					foreach($sql_building_rooms->result_array() as $row_building_rooms)
					{
						$arr_obj_booking['obj_sql'][] = $row_building_rooms;
					}
				}


			}
			return $arr_obj_booking;
		}
	}

	function set_store_suspend()
	{
		if($this->newsession->userdata('isLogin') AND ($this->newsession->userdata('SESS_PANGKAT_ID') == '3' OR $this->newsession->userdata('SESS_PANGKAT_ID') == '4' OR $this->newsession->userdata('SESS_PANGKAT_ID') == '5') AND (int)$this->newsession->userdata('SESS_RT') == 1)
		{
			$response = FALSE;
			if((int)hashids_decrypt($this->input->post('sRules'), _HASHIDS_, 3) == 9)
			{
				$arr_appeal['APPEAL_ID'] 				= substr(md5(date("YmdHis")), 0, 15);
				$arr_appeal['APPEAL_BOOKED_ID'] 		= $this->input->post('BOOKED_ID');
				$arr_appeal['APPEAL_BOOKED_ROOM_ID'] 	= $this->input->post('BOOKED_ROOM_ID');
				$arr_appeal['APPEAL_ROOM_ID'] 			= join("", $_POST['recomendation']);
				$arr_appeal['APPEAL_COMMENT'] 			= $this->input->post('COMMENT');
				$arr_appeal['APPEAL_CREATE_BY'] 		= $this->newsession->userdata('SESS_PEG_ID');
				$arr_appeal['APPEAL_CREATE_AT'] 		= date("Y-m-d H:i:s");
				$arr_appeal['APPEAL_UPDATE_AT'] 		= date("Y-m-d H:i:s");
				$this->db->trans_begin();
				$this->db->insert('app_appeal', $arr_appeal);
				if($this->db->affected_rows() > 0)
				{
					$arr_booking['BOOKED_SUSPENDED'] = 1;
					$this->db->where('BOOKED_ID', $this->input->post('BOOKED_ID'));
					$this->db->update('app_booked', $arr_booking);
					if($this->db->affected_rows() == 1)
					{
						$arr_booking_log = array(
							'BOOKED_LOG_ID' => $this->input->post('BOOKED_ID'),
							'BOOKED_LOG_SERIAL' => (int)$this->main->get_uraian("SELECT MAX(BOOKED_LOG_SERIAL) AS MAX_LOG FROM app_booked_log WHERE BOOKED_LOG_ID = '".$this->input->post('BOOKED_ID')."'","MAX_LOG") + 1,
							'BOOKED_LOG_COMMENT' => $this->input->post('COMMENT'),
							'BOOKED_LOG_NIP' => $this->newsession->userdata('SESS_PEG_NIP'),
							'BOOKED_LOG_NAME' => $this->newsession->userdata('SESS_NAMA'),
							'BOOKED_LOG_STATUS' => 1,
							'BOOKED_LOG_CREATE_DATE' => date("Y-m-d H:i:s"),
							'BOOKED_LOG_CREATE_BY' => $this->newsession->userdata('SESS_PEG_ID')
						);
						$this->db->insert('app_booked_log', $arr_booking_log);
						if($this->db->affected_rows() > 0)
						{
							$response = TRUE;
						}
					}
				}

				if($this->db->trans_status() === FALSE || !$response)
				{
					$this->db->trans_rollback();
					return array('error' => 'Rekomendasi pemindahan ruangan rapat gagal.');
				}else
				{
					$this->db->trans_commit();
					return array('error' => '',
								 'message' => 'Rekomendasi pemindahan ruangan rapat berhasil.',
								 'returnurl' => site_url('booking/verified'));
				}
			}
		}
	}

}
?>