<?php
class SearchModel extends CI_Model{

	public function get_rooms_availablity($dTime, $iCapacity, $iBuilding_Id)
	{
		if($this->newsession->userdata('isLogin'))
		{
			$dTime = gmdate('d-m-Y', $dTime);
			$iCapacity = (int)hashids_decrypt($iCapacity,_HASHIDS_,10);
			$iBuilding_Id = (int)hashids_decrypt($iBuilding_Id,_HASHIDS_,6);
			$arr_availabilty = array();

			$sql_building_rooms = "SELECT *, (( EVENT_REAL / 8) * 100) AS PERCENT FROM (SELECT A.ROOM_NAME, A.ROOM_ID, A.ROOM_BUILDING_ID, A.ROOM_PHOTO, A.ROOM_FACILITIES, 
								   A.ROOM_MIN_CAPACITY, A.ROOM_MAX_CAPACITY,
								   IFNULL(SUM(TIME_TO_SEC(TIMEDIFF(B.BOOKED_EVENT_FINISH, B.BOOKED_EVENT_START)) / 3600), 0) AS EVENT_REAL
								   FROM app_rooms A LEFT JOIN app_booked B ON A.ROOM_ID = B.BOOKED_ROOM_ID
								   AND DATE_FORMAT(B.BOOKED_EVENT_START, '%d-%m-%Y') = '".$dTime."'
								   AND B.BOOKED_STATUS IN (3, 13)
								   GROUP BY A.ROOM_NAME ORDER BY A.ROOM_MIN_CAPACITY ASC) AS DATA";
			if($iBuilding_Id != 0)
			{
				$sql_building_rooms .= $this->main->find_where($sql_building_rooms);
				$sql_building_rooms .= "ROOM_BUILDING_ID = ".$iBuilding_Id."";
			}
			if($iCapacity != 0)
			{
				$sql_building_rooms .= $this->main->find_where($sql_building_rooms);
				$sql_building_rooms .= "ROOM_MIN_CAPACITY > ".$iCapacity."";
			}

			$sql_building_rooms .= " ORDER BY PERCENT DESC";

			$bl_data_building_rooms = $this->main->get_result($sql_building_rooms);
			if($bl_data_building_rooms)
			{
				foreach($sql_building_rooms->result_array() as $row_building_rooms)
				{
					$arr_availabilty['obj_sql'][] = $row_building_rooms;
				}
			}
			$arr_availabilty['arr_params'] = array('dTime' => $dTime,
												   'iCapacity' => $iCapacity,
												   'iBuilding_Id' => $iBuilding_Id);
			$arr_availabilty['arr_building'] = $this->main->set_combobox("SELECT A.BUILDING_ID, A.BUILDING_NAME FROM sys_building A WHERE BUILDING_STATUS = 1", "BUILDING_ID", "BUILDING_NAME", TRUE);
			$iAwal = 0;
			$arr_capacity[$iAwal] = '';
			do {
				$iAwal += 5;
				$arr_capacity[$iAwal] = $iAwal . ' Orang';
			} while ($iAwal <= 45);
			$arr_availabilty['arr_capacity'] = $arr_capacity;

			return $arr_availabilty;
		}	
	}

	public function get_availablity_rooms($iBuilding_Id, $iRoom_Id, $dTime)
	{
		if($this->newsession->userdata('isLogin'))
		{
			$arr_availabilty = array();
			
			$sql_building_rooms = "SELECT A.BUILDING_NAME, B.ROOM_ID, CONCAT('Ruang Rapat - ', B.ROOM_NAME) AS ROOM_NAME, B.ROOM_PABX, B.ROOM_PIC, B.ROOM_FLOOR, B.ROOM_PHOTO, B.ROOM_FACILITIES, B.ROOM_PHOTO FROM sys_building A LEFT JOIN app_rooms B
ON A.BUILDING_ID = B.ROOM_BUILDING_ID WHERE A.BUILDING_ID = ".hashids_decrypt($iBuilding_Id,_HASHIDS_,6)." AND B.ROOM_ID = '".hashids_decrypt($iRoom_Id,_HASHIDS_,6)."' AND A.BUILDING_STATUS = 1 AND B.ROOM_STATUS = 1";
			$bl_data_building_rooms = $this->main->get_result($sql_building_rooms);
			if($bl_data_building_rooms)
			{
				foreach($sql_building_rooms->result_array() as $row_building_rooms)
				{
					$arr_availabilty['obj_sql'] = $row_building_rooms;
				}
				
				$sMonth = $this->config->config['bulan'];
				$arr_date_search = explode('-', $dTime);
				$sMonth_i = (int)$arr_date_search[1];
				$sMonth_i = $sMonth[$sMonth_i];
				$sDay = "$arr_date_search[2]/$arr_date_search[1]/$arr_date_search[0]";
				$arr_availabilty['sDate'] = $arr_date_search[0] .' ' . $sMonth_i .' '. $arr_date_search[2];
				$arr_availabilty['sDay'] = $this->main->get_day_indo($sDay);

				$arr_availabilty['arr_building'] = $this->main->set_combobox("SELECT A.BUILDING_ID, A.BUILDING_NAME FROM sys_building A WHERE BUILDING_STATUS = 1", "BUILDING_ID", "BUILDING_NAME", TRUE);
				$arr_availabilty['sHeader_Date']  = date("Y-m-d", strtotime($dTime));
				$arr_json_resources = array('id' => hashids_encrypt($row_building_rooms['ROOM_ID'],_HASHIDS_,9),
											'title' => $row_building_rooms['ROOM_NAME']);
				$arr_availabilty['arr_resources'] = json_encode($arr_json_resources);

				$sql_booked_rooms = "SELECT A.BOOKED_ID, A.BOOKED_ROOM_ID, DATE_FORMAT(A.BOOKED_EVENT_START, '%Y-%m-%d %H:%i%:%s') AS BOOKED_EVENT_START,
									 DATE_FORMAT(A.BOOKED_EVENT_FINISH, '%Y-%m-%d %H:%i%:%s') AS BOOKED_EVENT_FINISH, A.BOOKED_EVENT_NAME, A.BOOKED_EVENT_COLOR
									 FROM app_booked A WHERE A.BOOKED_ROOM_ID = '".hashids_decrypt($iRoom_Id,_HASHIDS_,6)."'
									 AND A.BOOKED_STATUS NOT IN ('1', '2', '3', '4', '5', '6', '9' '11','13', '14')
									 ORDER BY DATE_FORMAT(A.BOOKED_EVENT_START, '%Y-%m-%d %H:%i%:%s') ASC";
				$bl_booked_rooms = $this->main->get_result($sql_booked_rooms);
				if($bl_booked_rooms)
				{
					foreach($sql_booked_rooms->result_array() as $row_booked_rooms)
					{
						$arr_booked[] = array('id' => hashids_encrypt($row_booked_rooms['BOOKED_ID'],_HASHIDS_,6),
											  'resourceId' => hashids_encrypt($row_booked_rooms['BOOKED_ROOM_ID'],_HASHIDS_,9), 
											  'start' => $row_booked_rooms['BOOKED_EVENT_START'], 
											  'end' => $row_booked_rooms['BOOKED_EVENT_FINISH'], 
											  'title' => $row_booked_rooms['BOOKED_EVENT_NAME'],
											  'color' => $row_booked_rooms['BOOKED_EVENT_COLOR']);
					}
				}
				else
				{
					$arr_booked[] = array('id' => rand(),
										  'resourceId' => hashids_encrypt(hashids_decrypt($iRoom_Id,_HASHIDS_,6), _HASHIDS_, 9), 
										  'start' => date("Y-m-d H:i:s"), 
										  'end' => date("Y-m-d H:i:s"), 
										  'title' => '',
										  'color' => '');
				}
				$arr_availabilty['arr_events'] = json_encode($arr_booked);
				$arr_availabilty['arr_info'] = $this->db->query("SELECT
								SUM(CASE WHEN A.BOOKED_STATUS = 1 THEN 1 ELSE 0 END) AS 'Dipesan',
								SUM(CASE WHEN A.BOOKED_STATUS = 2 THEN 1 ELSE 0 END) AS 'Diverifikasi',
								SUM(CASE WHEN A.BOOKED_STATUS IN (3,13) THEN 1 ELSE 0 END) AS 'Disetujui',
								SUM(CASE WHEN A.BOOKED_STATUS = 5 THEN 1 ELSE 0 END) AS 'Dibatalkan',
								DATE_FORMAT(A.BOOKED_EVENT_START, '%d-%m-%Y') AS BOOKED_EVENT_DAY
								FROM app_booked A
								WHERE DATE_FORMAT(A.BOOKED_EVENT_START, '%d-%m-%Y') = '".$dTime."'
								GROUP BY DATE_FORMAT(A.BOOKED_EVENT_START, '%d-%m-%Y')")->result_array();
				return $arr_availabilty;
			}
			else
			{
				return redirect(base_url());
				exit();
			}
		}
	}

}
?>