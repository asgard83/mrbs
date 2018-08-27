<?php
class DashboardModel extends CI_Model{

	public function get_building()
	{

	}
	
	public function get_arr_schedule()
	{
		$arr_rooms = array();
		$SQL_rooms = "SELECT ROOM_ID, ROOM_NAME FROM app_rooms WHERE ROOM_STATUS = 1 ORDER BY 1 ASC";
		$bl_data_rooms = $this->main->get_result($SQL_rooms);
		if($bl_data_rooms){
			foreach($SQL_rooms->result_array() as $arr_row_rooms){
				$arr_rooms[] = array('id' => $arr_row_rooms['ROOM_ID'], 'title' => $arr_row_rooms['ROOM_NAME']);
			}
			$arrdata['arr_resources'] = json_encode($arr_rooms);
		}
		return $arrdata;
	}	

	public function get_arr_dashboard()
	{
		if($this->newsession->userdata('isLogin'))
		{
			$arr_schedule = array();
			$sql_schedule = "SELECT A.BOOKED_ID, A.BOOKED_EVENT_NAME, DATE_FORMAT(A.BOOKED_EVENT_START, '%H:%i') AS BOOKED_EVENT_START, DATE_FORMAT(A.BOOKED_EVENT_FINISH, '%H:%i') AS BOOKED_EVENT_FINISH, 
							CASE WHEN A.BOOKED_EVENT_TYPE = 0 THEN 'Internal' WHEN A.BOOKED_EVENT_TYPE = 1 THEN 'External' END AS BOOKED_EVENT_TYPE_NAME, A.BOOKED_EVENT_TYPE, A.BOOKED_EVENT_PIC_PHONE,
							CONCAT('Ruang Rapat - ', B.ROOM_NAME) AS ROOM_NAME, B.ROOM_PHOTO, CONCAT(C.USER_FIRST_NAME, ' ', C.USER_LAST_NAME) AS BOOKED_EVENT_PIC, A.BOOKED_EVENT_COLOR
							FROM app_booked A 
							LEFT JOIN app_rooms B ON A.BOOKED_ROOM_ID = B.ROOM_ID
							LEFT JOIN sys_users C ON A.BOOKED_CREATE_BY = C.USER_ID
							ORDER BY DATE_FORMAT(A.BOOKED_EVENT_START, '%Y-%m-%d'), DATE_FORMAT(A.BOOKED_EVENT_START, '%H:%i') ASC";
			$bl_schedule = $this->main->get_result($sql_schedule);
			if($bl_schedule){
				foreach($sql_schedule->result_array() as $row_schedule){
					$arr_schedule['arr_schedule'][] = $row_schedule;
				}
			}
			$arr_schedule['arr_building'] = $this->main->set_combobox("SELECT A.BUILDING_ID, A.BUILDING_NAME FROM sys_building A WHERE BUILDING_STATUS = 1", "BUILDING_ID", "BUILDING_NAME", TRUE);
			$iAwal = 0;
			$arr_capacity[$iAwal] = '';
			do {
				$iAwal += 5;
				$arr_capacity[$iAwal] = $iAwal . ' Orang';
			} while ($iAwal <= 45);
			$arr_schedule['arr_capacity'] = $arr_capacity;
			return $arr_schedule;
		}
	}

	public function set_cb_rooms()
	{
		if($this->newsession->userdata('isLogin'))
		{
			$sql_rooms = "SELECT A.ROOM_ID, A.ROOM_NAME FROM app_rooms A WHERE A.ROOM_BUILDING_ID = '".$this->input->post('params')."' ORDER BY 1";
			$obj_sql = $this->main->get_result($sql_rooms);
			if($obj_sql)
			{
				$arr_obj_sql['error'] = "";
				$arr_obj_sql['message'][] = array('value' => '',
											  'option' => '');
				foreach($sql_rooms->result_array() as $row_rooms)
				{
					$arr_obj_sql['message'][] = array('value' => $row_rooms['ROOM_ID'],
													  'option' => $row_rooms['ROOM_NAME']);
				}
				return $arr_obj_sql;							 
			}
			else
			{
				return array('error' => 'Data tidak ditemukan');
			}
		}
	}

	public function set_cb_layout_capacity()
	{
		if($this->newsession->userdata('isLogin'))
		{
			$sql_rooms_capacity = "SELECT A.TYPE_ROOM_ID, A.TYPE_ROOM_CAPACITY FROM app_rooms_type A WHERE A.TYPE_ROOM = '".$this->input->post('params')."' AND A.ROOM_ID = '".hashids_decrypt($this->input->post('keys'), _HASHIDS_,9)."'";
			$obj_sql = $this->main->get_result($sql_rooms_capacity);
			if($obj_sql)
			{
				$arr_obj_sql['error'] = "";
				$arr_obj_sql['message'][] = array('value' => '',
											  'option' => '');
				foreach($sql_rooms_capacity->result_array() as $row_rooms_capacity)
				{
					$arr_obj_sql['message'][] = array('value' => $row_rooms_capacity['TYPE_ROOM_ID'],
													  'option' => $row_rooms_capacity['TYPE_ROOM_CAPACITY']);
				}
				return $arr_obj_sql;							 
			}
			else
			{
				return array('error' => 'Data tidak ditemukan');
			}
		}
	}

	public function set_quick_finder_events()
	{
		if($this->newsession->userdata('isLogin'))
		{
			$dStart = date("Y-m-d", $_POST['start']);
			$dEnd = date("Y-m-d", $_POST['end']);
			$sql_finder_events = "SELECT EVENT_DATE, EVENT_REAL AS EVENT_HOURS, EVENT_COUNT FROM (
										 SELECT DATE_FORMAT(BOOKED_EVENT_START, '%Y-%m-%d') AS EVENT_DATE,
										 SUM(TIME_TO_SEC(TIMEDIFF(BOOKED_EVENT_FINISH, BOOKED_EVENT_START)) / 3600) AS EVENT_REAL, COUNT(BOOKED_ID) AS EVENT_COUNT
										 FROM app_booked WHERE BOOKED_STATUS IN (3, 13) AND DATE_FORMAT(BOOKED_EVENT_START, '%Y-%m-%d') BETWEEN '".$dStart."' AND '".$dEnd."'
										 GROUP BY DATE_FORMAT(BOOKED_EVENT_START, '%Y-%m-%d') ORDER BY DATE_FORMAT(BOOKED_EVENT_START, '%Y-%m-%d') ASC
									) AS DATA GROUP BY DATE_FORMAT(DATA.EVENT_DATE, '%Y-%m-%d') ORDER BY DATE_FORMAT(DATA.EVENT_DATE, '%Y-%m-%d') ASC";
			$bl_finder_events = $this->main->get_result($sql_finder_events);
			if($bl_finder_events)
			{
				$iCheck_Quota =  0;
				$iQouta = 232;
				$iQouta_Color = 0;
				$sColor = "";
				foreach($sql_finder_events->result_array() as $row_finder_events)
				{
					$iCheck_Quota = $iQouta / 100;
					$iQouta_Color = $iCheck_Quota * $row_finder_events['EVENT_HOURS']; 
					if($iQouta_Color <= 50)
					{
						$sColor = "#1b5e20";
					}
					else if($iQouta_Color > 50 && $iQouta_Color <= 80)
					{
						$sColor = "#f57f17";
					}
					else if($iQouta_Color > 80)
					{
						$sColor = "#b71c1c";
					}
					$arr_finder[] = array('Id' 			=> $row_finder_events['EVENT_DATE'],
										  'Title' 		=> $row_finder_events['EVENT_COUNT'] . ' Agenda',
										  'StartDate' 	=> $row_finder_events['EVENT_DATE'],
										  'Color' 		=> $sColor);
				}
			}
			else
			{
				$arr_finder[] = array('Title' => 'Jumlah Rapat - 0',
									  'StartDate' => $dStart,
									  'Color' => '#FFF');
			}
			return $arr_finder;
		}
	}

}
?>