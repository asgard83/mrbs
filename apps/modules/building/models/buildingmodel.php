<?php
class BuildingModel extends CI_Model{

	public function get_room_building($id)
	{
		$query = "SELECT A.ROOM_ID, A.ROOM_BUILDING_ID, A.ROOM_FLOOR,
				  A.ROOM_NAME, A.ROOM_LARGE, A.ROOM_PIC, A.ROOM_PABX, A.ROOM_FACILITIES, A.ROOM_PHOTO
				  FROM app_rooms A 
				  WHERE A.ROOM_BUILDING_ID = '".$id."' AND A.ROOM_STATUS = 1";
		$data = $this->main->get_result($query);
		if($data)
		{
			foreach($query->result_array() as $row)
			{
				$response['building_room'][] = $row;
			}
		}
		$response['building_name'] = $this->main->get_uraian("SELECT BUILDING_NAME FROM sys_building WHERE BUILDING_ID = '".$id."'", "BUILDING_NAME");
		return $response;
	}	

}
?>