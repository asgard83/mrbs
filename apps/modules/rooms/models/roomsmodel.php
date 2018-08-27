<?php
class RoomsModel extends CI_Model{

	public function get_obj_rooms($iRoom_Id)
	{
		if($this->newsession->userdata('isLogin'))
		{	
			$arr_rooms = array();
			if($iRoom_Id == "")
			{
				$arr_rooms['sRules'] = hashids_encrypt($this->main->get_uraian("SELECT REFF_CODE FROM sys_reference WHERE REFF_GROUP = '9999' AND REFF_CODE = 1","REFF_CODE"), _HASHIDS_, 3);
			}
			else 
			{
				$arr_rooms['sRules'] = hashids_encrypt($this->main->get_uraian("SELECT REFF_CODE FROM sys_reference WHERE REFF_GROUP = '9999' AND REFF_CODE = 2","REFF_CODE"), _HASHIDS_, 3);
			}
			$arr_rooms['action'] = site_url('post/set_reference_rooms');
			return $arr_rooms;
		}
	}

	public function set_store_rooms()
	{
		if($this->newsession->userdata('isLogin'))
		{

		}
	}

}
?>