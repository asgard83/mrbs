<?php
class EventsModel extends CI_Model{

	public function get_rooms_events($dEvent)
	{
		if($this->newsession->userdata('isLogin'))
		{
			date_default_timezone_set("Asia/Jakarta");
			$dEvent = date('d-m-Y', $dEvent);
			$arr_events = array();
			$sql_rooms_events = "SELECT A.ROOM_NAME, A.ROOM_ID, A.ROOM_BUILDING_ID, A.ROOM_PHOTO, A.ROOM_FACILITIES,
								 A.ROOM_MIN_CAPACITY, A.ROOM_MAX_CAPACITY,
								 B.BOOKED_EVENT_NAME, B.BOOKED_EVENT_LEADER,
								 B.BOOKED_EVENT_PIC, B.BOOKED_EVENT_PIC_PHONE,
								 DATE_FORMAT(B.BOOKED_EVENT_START, '%H:%i') AS BOOKED_EVENT_START,
								 DATE_FORMAT(B.BOOKED_EVENT_FINISH, '%H:%i') AS BOOKED_EVENT_FINISH 
								 FROM app_rooms A LEFT JOIN app_booked B ON A.ROOM_ID = B.BOOKED_ROOM_ID
								 WHERE B.BOOKED_STATUS IN (3,13) AND DATE_FORMAT(B.BOOKED_EVENT_START, '%d-%m-%Y') = '".$dEvent."'
								 ORDER BY DATE_FORMAT(B.BOOKED_EVENT_START, '%Y-%m-%d'), DATE_FORMAT(B.BOOKED_EVENT_START, '%H:%i') ASC"; 
			$bl_data_rooms_events = $this->main->get_result($sql_rooms_events);
			if($bl_data_rooms_events)
			{
				foreach($sql_rooms_events->result_array() as $row_events_rooms)
				{
					$arr_events['obj_sql'][] = $row_events_rooms;
				}
			}
			$sMonth = $this->config->config['bulan'];
			$arr_date_events = explode('-', $dEvent);
			$sMonth_i = (int)$arr_date_events[1];
			$sMonth_i = $sMonth[$sMonth_i];
			$sDay = "$arr_date_events[2]/$arr_date_events[1]/$arr_date_events[0]";
			$arr_events['sDate'] = $arr_date_events[0] .' ' . $sMonth_i .' '. $arr_date_events[2];
			$arr_events['sDay'] = $this->main->get_day_indo($sDay);
			return $arr_events;
		}	
	}

}
?>