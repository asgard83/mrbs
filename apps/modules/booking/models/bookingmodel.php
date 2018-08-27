<?php
class BookingModel extends CI_Model{

	public function get_room_building($building_id, $room_id)
	{
		$query = "SELECT A.TYPE_ROOM, A.TYPE_ROOM_CAPACITY, B.REFF_COMMENT 
FROM app_rooms_type A LEFT JOIN sys_reference B ON A.TYPE_ROOM = B.REFF_CODE AND B.REFF_GROUP = '0004'
WHERE A.ROOM_ID = '".$room_id."'";

		$data = $this->main->get_result($query);
		if($data)
		{
			foreach($query->result_array() as $row)
			{
				$response['obj'] = $row;
			}
		}

		$response['building_name'] = $this->main->get_uraian("SELECT BUILDING_NAME FROM sys_building WHERE BUILDING_ID = '".$building_id."'","BUILDING_NAME");
		$response['room_name'] = $this->main->get_uraian("SELECT ROOM_NAME FROM app_rooms WHERE ROOM_ID = '".$room_id."' AND ROOM_BUILDING_ID = '".$building_id."'", "ROOM_NAME");
		return $response;
	}	

	public function get_obj_booking_rooms($dStart, $dEnd, $iRoom_id)
	{
		if($this->newsession->userdata('isLogin'))
		{
			$arr_obj_booking = array();
			$arr_obj_booking['action'] = site_url('post/set_booking_confirm');
			$arr_obj_booking['room_name'] = $this->main->get_uraian("SELECT CONCAT(B.BUILDING_NAME, ', Lt ', A.ROOM_FLOOR, ' - RR ', A.ROOM_NAME) AS ROOMS_NAME FROM app_rooms A LEFT JOIN sys_building B ON A.ROOM_BUILDING_ID = B.BUILDING_ID WHERE A.ROOM_ID = ".hashids_decrypt($iRoom_id, _HASHIDS_,9)."","ROOMS_NAME");
			$arr_obj_booking['room_type'] = $this->main->set_combobox("SELECT A.TYPE_ROOM, B.REFF_COMMENT FROM app_rooms_type A LEFT JOIN sys_reference B
ON A.TYPE_ROOM = B.REFF_CODE AND B.REFF_DESCRIPTION = 'ROOM_TYPE' WHERE A.ROOM_ID = ".hashids_decrypt($iRoom_id, _HASHIDS_,9)."", "TYPE_ROOM", "REFF_COMMENT", TRUE);
			$arr_obj_booking['repeat_type'] = $this->main->set_combobox("SELECT REFF_CODE, REFF_COMMENT FROM sys_reference WHERE REFF_GROUP = '0005' AND REFF_STATUS = 1 ORDER BY REFF_ORDER", "REFF_CODE", "REFF_COMMENT", FALSE);
			$arr_obj_booking['meeting_type'] = $this->main->set_combobox("SELECT REFF_CODE, REFF_COMMENT FROM sys_reference WHERE REFF_GROUP = '0006' AND REFF_STATUS = 1 ORDER BY REFF_ORDER", "REFF_CODE", "REFF_COMMENT", TRUE);
			$arr_obj_booking['dStart'] = $dStart;
			$arr_obj_booking['dEnd'] = $dEnd;
			$arr_obj_booking['iRoom_id'] = $iRoom_id;
			$arr_obj_booking['sRules'] = hashids_encrypt($this->main->get_uraian("SELECT REFF_CODE FROM sys_reference WHERE REFF_GROUP = '9999' AND REFF_CODE = 1","REFF_CODE"), _HASHIDS_, 3);
			$sql_rooms = "SELECT * FROM app_rooms WHERE ROOM_ID = ".hashids_decrypt($iRoom_id, _HASHIDS_,9)."";
			$bl_data = $this->main->get_result($sql_rooms);
			if($bl_data)
			{
				foreach($sql_rooms->result_array() as $row_rooms)
				{
					$arr_obj_booking['obj_rooms'] = $row_rooms;
				}
			}
			return $arr_obj_booking;
		}
	}

	public function set_store_booking()
	{ 
		if($this->newsession->userdata('isLogin'))
		{  
			$response = FALSE;
			if((int)hashids_decrypt($this->input->post('sRules'), _HASHIDS_, 3) == 1)
			{ 
				$arr_booking = $this->main->post_to_query($_POST['obj_booking']);
				$arr_booking['BOOKED_ROOM_ID'] = (int)hashids_decrypt($arr_booking['BOOKED_ROOM_ID'], _HASHIDS_, 9);
				$arr_booking['BOOKED_ID'] = substr(md5(date("YmdHis")), 0, 10);
				$arr_booking['BOOKED_STATUS'] = 1;
				$arr_booking['BOOKED_CREATE_DATE'] = date("Y-m-d H:i:s");
				$arr_booking['BOOKED_EVENT_COLOR'] = ($arr_booking['BOOKED_EVENT_TYPE'] == 0 ? '#01579b' : '#b71c1c');
				$arr_booking['BOOKED_NIP'] = $this->newsession->userdata('SESS_PEG_NIP');
				$arr_booking['BOOKED_NAME'] = $this->newsession->userdata('SESS_NAMA');
				$arr_booking['BOOKED_SATKER'] = $this->newsession->userdata('SESS_SATKER_ID');
				$arr_booking['BOOKED_UNIT_NAME'] = $this->newsession->userdata('SESS_NAMA_SATKER');
				$arr_booking['BOOKED_CREATE_BY'] = $this->newsession->userdata('SESS_PEG_ID');
				$sql_rooms = "SELECT A.BUILDING_ID, A.BUILDING_NAME, B.ROOM_ID, B.ROOM_NAME, B.ROOM_FLOOR FROM sys_building A LEFT JOIN app_rooms B
ON A.BUILDING_ID = B.ROOM_BUILDING_ID WHERE B.ROOM_ID = ".$arr_booking['BOOKED_ROOM_ID']."";
				$data_rooms = $this->main->get_result($sql_rooms);
				if($data_rooms)
				{
					foreach($sql_rooms->result_array() as $row_rooms)
					{
						$arr_booking['BOOKED_ROOM_BUILDING_ID'] = $row_rooms['BUILDING_ID'];
						$arr_booking['BOOKED_ROOM_NAME'] = $row_rooms['ROOM_NAME'];
						$arr_booking['BOOKED_ROOM_FLOOR'] = $row_rooms['ROOM_FLOOR'];
					}
				}
				$arr_booking['BOOKED_ROOM_CAPACITY'] = $this->main->get_uraian("SELECT CONCAT(A.ROOM_MIN_CAPACITY, '-', A.ROOM_MAX_CAPACITY) AS TYPE_ROOM_CAPACITY FROM app_rooms A WHERE A.ROOM_ID = ".$arr_booking['BOOKED_ROOM_ID']."","TYPE_ROOM_CAPACITY");
				$this->db->trans_begin();
				$this->db->insert('app_booked', $arr_booking);
				if($this->db->affected_rows() > 0)
				{
					$arr_booking_log = array(
						'BOOKED_LOG_ID' => $arr_booking['BOOKED_ID'],
						'BOOKED_LOG_SERIAL' => (int)$this->main->get_uraian("SELECT MAX(BOOKED_LOG_SERIAL) AS MAX_LOG FROM app_booked_log WHERE BOOKED_LOG_ID = '".$arr_booking['BOOKED_ID']."'","MAX_LOG") + 1,
						'BOOKED_LOG_COMMENT' => 'Pemesanan ruang rapat',
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

				if($this->db->trans_status() === FALSE || !$response)
				{
					$this->db->trans_rollback();
					return array('error' => 'Pemesanan ruangan rapat gagal');
				}else
				{
					$this->db->trans_commit();
					return array('error' => '',
								 'message' => 'Pemesanan ruangan rapat berhasil disimpan',
								 'returnurl' => site_url('dashboard'));
				}
			}
		}
	}

	public function get_ls_history()
	{
		if($this->newsession->userdata('isLogin'))
		{
			$table = $this->newtable;
			$query = "SELECT A.BOOKED_ID, CONCAT('Ruang Rapat - ', A.BOOKED_ROOM_NAME) AS 'Ruangan Rapat',
					  A.BOOKED_EVENT_NAME AS 'Nama Rapat', DATE_FORMAT(A.BOOKED_EVENT_START, '%d-%m-%Y') AS 'Tanggal',
					  CONCAT(DATE_FORMAT(A.BOOKED_EVENT_START, '%H:%i:%s'), ' - ', DATE_FORMAT(A.BOOKED_EVENT_FINISH, '%H:%i:%s')) AS 'Waktu', B.REFF_COMMENT AS 'Status'
					  FROM app_booked A 
					  LEFT JOIN sys_reference B ON A.BOOKED_STATUS = B.REFF_CODE AND B.REFF_DESCRIPTION = 'STATUS_RUANGAN'
					  WHERE A.BOOKED_CREATE_BY = '".$this->newsession->userdata('SESS_PEG_ID')."'";
			$table->columns(array("A.BOOKED_ID", 
								  "CONCAT('Ruang Rapat - ', A.BOOKED_ROOM_NAME)",
								  "A.BOOKED_EVENT_NAME", 
								  "DATE_FORMAT(A.BOOKED_EVENT_START, '%d-%m-%Y')",
								  "CONCAT(DATE_FORMAT(A.BOOKED_EVENT_START, '%H:%i:%s'), ' - ', DATE_FORMAT(A.BOOKED_EVENT_FINISH, '%H:%i:%s'))", 
								  "B.REFF_COMMENT"));
			$this->newtable->width(array('Ruang Rapat' => 250,
										 'Nama Rapat' => 350,
										 'Tanggal' => 75,
										 'Waktu' => 100,
										 'Status' => 150));
			$this->newtable->search(array(array("CONCAT('Ruang Rapat - ', A.BOOKED_ROOM_NAME)", 'Ruang Rapat'),
										  array("A.BOOKED_EVENT_NAME", 'Nama Rapat')
										  ));
			$table->keys(array("BOOKED_ID"));
			$table->hiddens(array("BOOKED_ID")); 
			$table->menu(array('Preview' => array('GET', site_url().'verified/booking', '1', 'mdi-action-open-in-new', 'blue darken-1')));
			$table->cidb($this->db);
			$table->ciuri($this->uri->segment_array());
			$table->action(site_url('booking/history'));
			$table->detail(site_url().'get/history');
			$table->orderby(1);
			$table->sortby("ASC");
			$table->show_search(TRUE);
			$table->show_chk(TRUE);
			$table->single(FALSE);
			$table->hashids(FALSE);
			$table->expandrow(TRUE);
			$table->postmethod(TRUE);
			$table->tbtarget("history_list");
			$table->judul('History Pemesanan Ruangan Rapat');
			$arrdata = array('table' => $table->generate($query));
			if($this->input->post("data-post")) return $table->generate($query);
			else return $arrdata;
		}
		
	}

	public function get_ls_verified()
	{
		if($this->newsession->userdata('isLogin') AND (int)$this->newsession->userdata('SESS_RT') == 1)
		{
			$table = $this->newtable;

			if($this->newsession->userdata('SESS_PANGKAT_ID') == '5')
			{
				$query = "SELECT A.BOOKED_ID, CONCAT('Ruang Rapat - ', A.BOOKED_ROOM_NAME) AS 'Ruangan Rapat',
					  A.BOOKED_EVENT_NAME AS 'Nama Rapat', DATE_FORMAT(A.BOOKED_EVENT_START, '%d-%m-%Y') AS 'Tanggal',
					  CONCAT(DATE_FORMAT(A.BOOKED_EVENT_START, '%H:%i:%s'), ' - ', DATE_FORMAT(A.BOOKED_EVENT_FINISH, '%H:%i:%s')) AS 'Waktu', A.BOOKED_NAME AS 'Nama Pemesan', 
					  B.REFF_COMMENT AS 'Status'
					  FROM app_booked A 
					  LEFT JOIN sys_reference B ON A.BOOKED_STATUS = B.REFF_CODE AND B.REFF_DESCRIPTION = 'STATUS_RUANGAN'
					  WHERE A.BOOKED_STATUS = 1";
			}
			else if($this->newsession->userdata('SESS_PANGKAT_ID') == '3')
			{
				$query = "SELECT A.BOOKED_ID, CONCAT('Ruang Rapat - ', A.BOOKED_ROOM_NAME) AS 'Ruangan Rapat',
					  A.BOOKED_EVENT_NAME AS 'Nama Rapat', DATE_FORMAT(A.BOOKED_EVENT_START, '%d-%m-%Y') AS 'Tanggal',
					  CONCAT(DATE_FORMAT(A.BOOKED_EVENT_START, '%H:%i:%s'), ' - ', DATE_FORMAT(A.BOOKED_EVENT_FINISH, '%H:%i:%s')) AS 'Waktu', A.BOOKED_NAME AS 'Nama Pemesan', 
					  B.REFF_COMMENT AS 'Status'
					  FROM app_booked A 
					  LEFT JOIN sys_reference B ON A.BOOKED_STATUS = B.REFF_CODE AND B.REFF_DESCRIPTION = 'STATUS_RUANGAN'
					  LEFT JOIN sys_users C ON A.BOOKED_CREATE_BY = C.USER_ID
					  WHERE A.BOOKED_STATUS = 2";
			}
			$table->columns(array("A.BOOKED_ID", 
								  "CONCAT('Ruang Rapat - ', A.BOOKED_ROOM_NAME)",
								  "A.BOOKED_EVENT_NAME", 
								  "DATE_FORMAT(A.BOOKED_EVENT_START, '%d-%m-%Y')",
								  "CONCAT(DATE_FORMAT(A.BOOKED_EVENT_START, '%H:%i:%s'), ' - ', DATE_FORMAT(A.BOOKED_EVENT_FINISH, '%H:%i:%s'))", 
								  "A.BOOKED_NAME",
								  "B.REFF_COMMENT"));
			$this->newtable->width(array('Ruang Rapat' => 200,
										 'Nama Rapat' => 350,
										 'Tanggal' => 100,
										 'Waktu' => 150,
										 'Nama Pemesan' => 200,
										 'Status' => 200));
			$this->newtable->search(array(array("CONCAT('Ruang Rapat - ', A.BOOKED_ROOM_NAME)", 'Ruang Rapat'),
										  array("A.BOOKED_EVENT_NAME", 'Nama Rapat')
										  ));
			$table->keys(array("BOOKED_ID"));
			$table->hiddens(array("BOOKED_ID")); 
			$table->menu(array('Preview' => array('GET', site_url().'verified/booking', '1', 'mdi-action-open-in-new', 'blue darken-1')));
			$table->cidb($this->db);
			$table->ciuri($this->uri->segment_array());
			$table->action(site_url('booking/verified'));
			$table->detail(site_url().'get/verified');
			$table->orderby(1);
			$table->sortby("ASC");
			$table->show_search(TRUE);
			$table->show_chk(TRUE);
			$table->single(FALSE);
			$table->hashids(FALSE);
			$table->expandrow(TRUE);
			$table->postmethod(TRUE);
			$table->tbtarget("verified_list");
			$table->judul('Data Pemesanan Ruangan Rapat - Verifikasi');
			$arrdata = array('table' => $table->generate($query));
			if($this->input->post("data-post")) return $table->generate($query);
			else return $arrdata;
		}
		
	}

	public function get_ls_approve()
	{
		if($this->newsession->userdata('isLogin'))
		{
			$table = $this->newtable;
			$query = "SELECT A.BOOKED_ID, CONCAT('Ruang Rapat - ', A.BOOKED_ROOM_NAME) AS 'Ruangan Rapat',
					  A.BOOKED_EVENT_NAME AS 'Nama Rapat', DATE_FORMAT(A.BOOKED_EVENT_START, '%d-%m-%Y') AS 'Tanggal',
					  CONCAT(DATE_FORMAT(A.BOOKED_EVENT_START, '%H:%i:%s'), ' - ', DATE_FORMAT(A.BOOKED_EVENT_FINISH, '%H:%i:%s')) AS 'Waktu', A.BOOKED_NAME AS 'Nama Pemesan', 
					  B.REFF_COMMENT AS 'Status'
					  FROM app_booked A 
					  LEFT JOIN sys_reference B ON A.BOOKED_STATUS = B.REFF_CODE AND B.REFF_DESCRIPTION = 'STATUS_RUANGAN'
					  WHERE A.BOOKED_STATUS = 3";
			if((int)$this->newsession->userdata('SESS_RT') == 0)					  
			{
				$query .= " AND A.BOOKED_CREATE_BY = '".$this->newsession->userdata('SESS_PEG_ID')."'";
			}
			$table->columns(array("A.BOOKED_ID", 
								  "CONCAT('Ruang Rapat - ', A.BOOKED_ROOM_NAME)",
								  "A.BOOKED_EVENT_NAME", 
								  "DATE_FORMAT(A.BOOKED_EVENT_START, '%d-%m-%Y')",
								  "CONCAT(DATE_FORMAT(A.BOOKED_EVENT_START, '%H:%i:%s'), ' - ', DATE_FORMAT(A.BOOKED_EVENT_FINISH, '%H:%i:%s'))", 
								  "A.BOOKED_NAME",
								  "B.REFF_COMMENT"));
			$this->newtable->width(array('Ruang Rapat' => 200,
										 'Nama Rapat' => 350,
										 'Tanggal' => 100,
										 'Waktu' => 150,
										 'Nama Pemesan' => 200,
										 'Status' => 200));
			$this->newtable->search(array(array("CONCAT('Ruang Rapat - ', A.BOOKED_ROOM_NAME)", 'Ruang Rapat'),
										  array("A.BOOKED_EVENT_NAME", 'Nama Rapat')
										  ));
			$table->keys(array("BOOKED_ID"));
			$table->hiddens(array("BOOKED_ID")); 
			$table->menu(array('Preview' => array('GET', site_url().'verified/booking', '1', 'mdi-action-open-in-new', 'blue darken-1')));
			$table->cidb($this->db);
			$table->ciuri($this->uri->segment_array());
			$table->action(site_url('booking/approve'));
			$table->detail(site_url().'get/approve');
			$table->orderby(1);
			$table->sortby("ASC");
			$table->show_search(TRUE);
			$table->show_chk(TRUE);
			$table->single(TRUE);
			$table->hashids(FALSE);
			$table->expandrow(TRUE);
			$table->postmethod(TRUE);
			$table->tbtarget("approve_list");
			$table->judul('Data Pemesanan Ruangan Rapat - Disetujui');
			$arrdata = array('table' => $table->generate($query));
			if($this->input->post("data-post")) return $table->generate($query);
			else return $arrdata;
		}
	}

	public function get_ls_finish()
	{
		if($this->newsession->userdata('isLogin'))
		{
			$table = $this->newtable;
			$query = "SELECT A.BOOKED_ID, CONCAT('Ruang Rapat - ', A.BOOKED_ROOM_NAME) AS 'Ruangan Rapat',
					  A.BOOKED_EVENT_NAME AS 'Nama Rapat', DATE_FORMAT(A.BOOKED_EVENT_START, '%d-%m-%Y') AS 'Tanggal',
					  CONCAT(DATE_FORMAT(A.BOOKED_EVENT_START, '%H:%i:%s'), ' - ', DATE_FORMAT(A.BOOKED_EVENT_FINISH, '%H:%i:%s')) AS 'Waktu', A.BOOKED_NAME AS 'Nama Pemesan', 
					  B.REFF_COMMENT AS 'Status'
					  FROM app_booked A 
					  LEFT JOIN sys_reference B ON A.BOOKED_STATUS = B.REFF_CODE AND B.REFF_DESCRIPTION = 'STATUS_RUANGAN'
					  WHERE A.BOOKED_STATUS = 6";
			if((int)$this->newsession->userdata('SESS_RT') == 0)					  
			{
				$query .= " AND A.BOOKED_CREATE_BY = '".$this->newsession->userdata('SESS_PEG_ID')."'";
			}
			$table->columns(array("A.BOOKED_ID", 
								  "CONCAT('Ruang Rapat - ', A.BOOKED_ROOM_NAME)",
								  "A.BOOKED_EVENT_NAME", 
								  "DATE_FORMAT(A.BOOKED_EVENT_START, '%d-%m-%Y')",
								  "CONCAT(DATE_FORMAT(A.BOOKED_EVENT_START, '%H:%i:%s'), ' - ', DATE_FORMAT(A.BOOKED_EVENT_FINISH, '%H:%i:%s'))", 
								  "A.BOOKED_NAME",
								  "B.REFF_COMMENT"));
			$this->newtable->width(array('Ruang Rapat' => 200,
										 'Nama Rapat' => 350,
										 'Tanggal' => 100,
										 'Waktu' => 150,
										 'Nama Pemesan' => 200,
										 'Status' => 200));
			$this->newtable->search(array(array("CONCAT('Ruang Rapat - ', A.BOOKED_ROOM_NAME)", 'Ruang Rapat'),
										  array("A.BOOKED_EVENT_NAME", 'Nama Rapat')
										  ));
			$table->keys(array("BOOKED_ID"));
			$table->hiddens(array("BOOKED_ID")); 
			$table->menu(array('Preview' => array('GET', site_url().'verified/booking', '1', 'mdi-action-open-in-new', 'blue darken-1')));
			$table->cidb($this->db);
			$table->ciuri($this->uri->segment_array());
			$table->action(site_url('booking/finished'));
			$table->detail(site_url().'get/approve');
			$table->orderby(1);
			$table->sortby("ASC");
			$table->show_search(TRUE);
			$table->show_chk(TRUE);
			$table->single(FALSE);
			$table->hashids(FALSE);
			$table->expandrow(TRUE);
			$table->postmethod(TRUE);
			$table->tbtarget("finished_list");
			$table->judul('Data Pemesanan Ruangan Rapat - Selesai');
			$arrdata = array('table' => $table->generate($query));
			if($this->input->post("data-post")) return $table->generate($query);
			else return $arrdata;
		}
		
	}

	public function get_ls_canceled()
	{
		if($this->newsession->userdata('isLogin'))
		{
			$table = $this->newtable;
			$query = "SELECT A.BOOKED_ID, CONCAT('Ruang Rapat - ', A.BOOKED_ROOM_NAME) AS 'Ruangan Rapat',
					  A.BOOKED_EVENT_NAME AS 'Nama Rapat', DATE_FORMAT(A.BOOKED_EVENT_START, '%d-%m-%Y') AS 'Tanggal',
					  CONCAT(DATE_FORMAT(A.BOOKED_EVENT_START, '%H:%i:%s'), ' - ', DATE_FORMAT(A.BOOKED_EVENT_FINISH, '%H:%i:%s')) AS 'Waktu', A.BOOKED_NAME AS 'Nama Pemesan', 
					  B.REFF_COMMENT AS 'Status'
					  FROM app_booked A 
					  LEFT JOIN sys_reference B ON A.BOOKED_STATUS = B.REFF_CODE AND B.REFF_DESCRIPTION = 'STATUS_RUANGAN'
					  WHERE A.BOOKED_STATUS = 5 AND A.BOOKED_CREATE_BY = '".$this->newsession->userdata('SESS_PEG_ID')."'";
			if((int)$this->newsession->userdata('SESS_RT') == 0)					  
			{
				$query .= " AND A.BOOKED_CREATE_BY = '".$this->newsession->userdata('SESS_PEG_ID')."'";
			}
			$table->columns(array("A.BOOKED_ID", 
								  "CONCAT('Ruang Rapat - ', A.BOOKED_ROOM_NAME)",
								  "A.BOOKED_EVENT_NAME", 
								  "DATE_FORMAT(A.BOOKED_EVENT_START, '%d-%m-%Y')",
								  "CONCAT(DATE_FORMAT(A.BOOKED_EVENT_START, '%H:%i:%s'), ' - ', DATE_FORMAT(A.BOOKED_EVENT_FINISH, '%H:%i:%s'))", 
								  "A.BOOKED_NAME",
								  "B.REFF_COMMENT"));
			$this->newtable->width(array('Ruang Rapat' => 200,
										 'Nama Rapat' => 350,
										 'Tanggal' => 100,
										 'Waktu' => 150,
										 'Nama Pemesan' => 200,
										 'Status' => 200));
			$this->newtable->search(array(array("CONCAT('Ruang Rapat - ', A.BOOKED_ROOM_NAME)", 'Ruang Rapat'),
										  array("A.BOOKED_EVENT_NAME", 'Nama Rapat')
										  ));
			$table->keys(array("BOOKED_ID"));
			$table->hiddens(array("BOOKED_ID")); 
			$table->menu(array('Preview' => array('GET', site_url().'verified/booking', '1', 'mdi-action-open-in-new', 'blue darken-1')));
			$table->cidb($this->db);
			$table->ciuri($this->uri->segment_array());
			$table->action(site_url('booking/canceled'));
			$table->detail(site_url().'get/canceled');
			$table->orderby(1);
			$table->sortby("ASC");
			$table->show_search(TRUE);
			$table->show_chk(TRUE);
			$table->single(FALSE);
			$table->hashids(FALSE);
			$table->expandrow(TRUE);
			$table->postmethod(TRUE);
			$table->tbtarget("finished_list");
			$table->judul('Data Pemesanan Ruangan Rapat - Ditangguhkan');
			$arrdata = array('table' => $table->generate($query));
			if($this->input->post("data-post")) return $table->generate($query);
			else return $arrdata;
		}
	}

	public function get_ls_suspended()
	{
		if($this->newsession->userdata('isLogin'))
		{
			$table = $this->newtable;
			$query = "SELECT A.BOOKED_ID, CONCAT('Ruang Rapat - ', A.BOOKED_ROOM_NAME) AS 'Ruangan Rapat',
					  A.BOOKED_EVENT_NAME AS 'Nama Rapat', DATE_FORMAT(A.BOOKED_EVENT_START, '%d-%m-%Y') AS 'Tanggal',
					  CONCAT(DATE_FORMAT(A.BOOKED_EVENT_START, '%H:%i:%s'), ' - ', DATE_FORMAT(A.BOOKED_EVENT_FINISH, '%H:%i:%s')) AS 'Waktu', A.BOOKED_NAME AS 'Nama Pemesan', 
					  B.REFF_COMMENT AS 'Status'
					  FROM app_booked A 
					  LEFT JOIN sys_reference B ON A.BOOKED_STATUS = B.REFF_CODE AND B.REFF_DESCRIPTION = 'STATUS_RUANGAN'
					  WHERE A.BOOKED_STATUS = 9 AND A.BOOKED_SUSPENDED = 1 AND A.BOOKED_CREATE_BY = '".$this->newsession->userdata('SESS_PEG_ID')."'";
			if((int)$this->newsession->userdata('SESS_RT') == 0)					  
			{
				$query .= " AND A.BOOKED_CREATE_BY = '".$this->newsession->userdata('SESS_PEG_ID')."'";
			}
			$table->columns(array("A.BOOKED_ID", 
								  "CONCAT('Ruang Rapat - ', A.BOOKED_ROOM_NAME)",
								  "A.BOOKED_EVENT_NAME", 
								  "DATE_FORMAT(A.BOOKED_EVENT_START, '%d-%m-%Y')",
								  "CONCAT(DATE_FORMAT(A.BOOKED_EVENT_START, '%H:%i:%s'), ' - ', DATE_FORMAT(A.BOOKED_EVENT_FINISH, '%H:%i:%s'))", 
								  "A.BOOKED_NAME",
								  "B.REFF_COMMENT"));
			$this->newtable->width(array('Ruang Rapat' => 200,
										 'Nama Rapat' => 350,
										 'Tanggal' => 100,
										 'Waktu' => 150,
										 'Nama Pemesan' => 200,
										 'Status' => 200));
			$this->newtable->search(array(array("CONCAT('Ruang Rapat - ', A.BOOKED_ROOM_NAME)", 'Ruang Rapat'),
										  array("A.BOOKED_EVENT_NAME", 'Nama Rapat')
										  ));
			$table->keys(array("BOOKED_ID"));
			$table->hiddens(array("BOOKED_ID")); 
			$table->menu(array('Preview' => array('GET', site_url().'verified/booking', '1', 'mdi-action-open-in-new', 'blue darken-1')));
			$table->cidb($this->db);
			$table->ciuri($this->uri->segment_array());
			$table->action(site_url('booking/suspended'));
			$table->detail(site_url().'get/suspended');
			$table->orderby(1);
			$table->sortby("ASC");
			$table->show_search(TRUE);
			$table->show_chk(TRUE);
			$table->single(FALSE);
			$table->hashids(FALSE);
			$table->expandrow(TRUE);
			$table->postmethod(TRUE);
			$table->tbtarget("finished_list");
			$table->judul('Data Pemesanan Ruangan Rapat - Ditangguhkan');
			$arrdata = array('table' => $table->generate($query));
			if($this->input->post("data-post")) return $table->generate($query);
			else return $arrdata;
		}
	}

	public function get_ls_appeal($sStep)
	{
		if($this->newsession->userdata('isLogin') && $this->newsession->userdata('SESS_TU_PIM'))
		{
			$table = $this->newtable;
			$query = "SELECT A.BOOKED_ID, CONCAT('Ruang Rapat - ', A.BOOKED_ROOM_NAME) AS 'Ruangan Rapat',
					  A.BOOKED_EVENT_NAME AS 'Nama Rapat', DATE_FORMAT(A.BOOKED_EVENT_START, '%d-%m-%Y') AS 'Tanggal',
					  CONCAT(DATE_FORMAT(A.BOOKED_EVENT_START, '%H:%i:%s'), ' - ', DATE_FORMAT(A.BOOKED_EVENT_FINISH, '%H:%i:%s')) AS 'Waktu', A.BOOKED_NAME AS 'Nama Pemesan', 
					  B.REFF_COMMENT AS 'Status'
					  FROM app_booked A 
					  LEFT JOIN sys_reference B ON A.BOOKED_STATUS = B.REFF_CODE AND B.REFF_DESCRIPTION = 'STATUS_RUANGAN'";
			if($sStep == "inbox")
			{
				$query .= $this->main->find_where($query);
				$query .= " A.BOOKED_STATUS = 11";
				$sTitle = "Pengajuan Banding";
			}
			else if($sStep == "approved")
			{
				$query .= $this->main->find_where($query);
				$query .= " A.BOOKED_STATUS = 13 AND A.BOOKED_APPEAL_STATUS = 1";	
				$sTitle = "Banding Disetujui";
			}
			else if($sStep == "rejected")
			{
				$query .= $this->main->find_where($query);
				$query .= " A.BOOKED_STATUS = 14 AND A.BOOKED_APPEAL_STATUS = 2";	
				$sTitle = "Banding Ditolak";
			}

			$table->columns(array("A.BOOKED_ID", 
								  "CONCAT('Ruang Rapat - ', A.BOOKED_ROOM_NAME)",
								  "A.BOOKED_EVENT_NAME", 
								  "DATE_FORMAT(A.BOOKED_EVENT_START, '%d-%m-%Y')",
								  "CONCAT(DATE_FORMAT(A.BOOKED_EVENT_START, '%H:%i:%s'), ' - ', DATE_FORMAT(A.BOOKED_EVENT_FINISH, '%H:%i:%s'))", 
								  "A.BOOKED_NAME",
								  "B.REFF_COMMENT"));
			$this->newtable->width(array('Ruang Rapat' => 200,
										 'Nama Rapat' => 350,
										 'Tanggal' => 100,
										 'Waktu' => 150,
										 'Nama Pemesan' => 200,
										 'Status' => 200));
			$this->newtable->search(array(array("CONCAT('Ruang Rapat - ', A.BOOKED_ROOM_NAME)", 'Ruang Rapat'),
										  array("A.BOOKED_EVENT_NAME", 'Nama Rapat')
										  ));
			$table->keys(array("BOOKED_ID"));
			$table->hiddens(array("BOOKED_ID")); 
			$table->menu(array('Preview' => array('GET', site_url().'verified/booking', '1', 'mdi-action-open-in-new', 'blue darken-1')));
			$table->cidb($this->db);
			$table->ciuri($this->uri->segment_array());
			$table->action(site_url('booking/appeal/' . $sStep));
			$table->detail(site_url().'get/appeal');
			$table->orderby(1);
			$table->sortby("ASC");
			$table->show_search(TRUE);
			$table->show_chk(TRUE);
			$table->single(FALSE);
			$table->hashids(FALSE);
			$table->expandrow(TRUE);
			$table->postmethod(TRUE);
			$table->tbtarget("appeal_list_".$sStep);
			$table->judul('Data Pemesanan Ruangan Rapat - ' . $sTitle);
			$arrdata = array('table' => $table->generate($query));
			if($this->input->post("data-post")) return $table->generate($query);
			else return $arrdata;
		}
	}

	public function get_ls_rejected()
	{
		if($this->newsession->userdata('isLogin'))
		{
			$table = $this->newtable;
			$query = "SELECT A.BOOKED_ID, CONCAT('Ruang Rapat - ', A.BOOKED_ROOM_NAME) AS 'Ruangan Rapat',
					  A.BOOKED_EVENT_NAME AS 'Nama Rapat', DATE_FORMAT(A.BOOKED_EVENT_START, '%d-%m-%Y') AS 'Tanggal',
					  CONCAT(DATE_FORMAT(A.BOOKED_EVENT_START, '%H:%i:%s'), ' - ', DATE_FORMAT(A.BOOKED_EVENT_FINISH, '%H:%i:%s')) AS 'Waktu', A.BOOKED_NAME AS 'Nama Pemesan', 
					  B.REFF_COMMENT AS 'Status'
					  FROM app_booked A 
					  LEFT JOIN sys_reference B ON A.BOOKED_STATUS = B.REFF_CODE AND B.REFF_DESCRIPTION = 'STATUS_RUANGAN'
					  WHERE A.BOOKED_STATUS IN (4, 14) AND A.BOOKED_CREATE_BY = '".$this->newsession->userdata('SESS_PEG_ID')."'";
			if((int)$this->newsession->userdata('SESS_RT') == 0)					  
			{
				$query .= " AND A.BOOKED_CREATE_BY = '".$this->newsession->userdata('SESS_PEG_ID')."'";
			}
			$table->columns(array("A.BOOKED_ID", 
								  "CONCAT('Ruang Rapat - ', A.BOOKED_ROOM_NAME)",
								  "A.BOOKED_EVENT_NAME", 
								  "DATE_FORMAT(A.BOOKED_EVENT_START, '%d-%m-%Y')",
								  "CONCAT(DATE_FORMAT(A.BOOKED_EVENT_START, '%H:%i:%s'), ' - ', DATE_FORMAT(A.BOOKED_EVENT_FINISH, '%H:%i:%s'))", 
								  "A.BOOKED_NAME",
								  "B.REFF_COMMENT"));
			$this->newtable->width(array('Ruang Rapat' => 200,
										 'Nama Rapat' => 350,
										 'Tanggal' => 100,
										 'Waktu' => 150,
										 'Nama Pemesan' => 200,
										 'Status' => 200));
			$this->newtable->search(array(array("CONCAT('Ruang Rapat - ', A.BOOKED_ROOM_NAME)", 'Ruang Rapat'),
										  array("A.BOOKED_EVENT_NAME", 'Nama Rapat')
										  ));
			$table->keys(array("BOOKED_ID"));
			$table->hiddens(array("BOOKED_ID")); 
			$table->menu(array('Preview' => array('GET', site_url().'verified/booking', '1', 'mdi-action-open-in-new', 'blue darken-1')));
			$table->cidb($this->db);
			$table->ciuri($this->uri->segment_array());
			$table->action(site_url('booking/rejected'));
			$table->detail(site_url().'get/rejected');
			$table->orderby(1);
			$table->sortby("ASC");
			$table->show_search(TRUE);
			$table->show_chk(TRUE);
			$table->single(FALSE);
			$table->hashids(FALSE);
			$table->expandrow(TRUE);
			$table->postmethod(TRUE);
			$table->tbtarget("rejected_list");
			$table->judul('Data Pemesanan Ruangan Rapat - Ditolak');
			$arrdata = array('table' => $table->generate($query));
			if($this->input->post("data-post")) return $table->generate($query);
			else return $arrdata;
		}
	}

}
?>