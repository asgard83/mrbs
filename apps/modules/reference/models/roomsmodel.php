<?php
class RoomsModel extends CI_Model{

	public function get_ls_rooms()
	{
		if($this->newsession->userdata('isLogin'))
		{
			$table = $this->newtable;
			$query = "SELECT A.ROOM_ID, A.ROOM_NAME AS 'Ruang Rapat', CONCAT(A.ROOM_FACILITIES, '<div>Luas : ', A.ROOM_LARGE, ' </div>') AS 'Fasilitas', A.ROOM_PIC AS 'Penanggung Jawab', A.ROOM_PABX AS 'PABX'
					  FROM app_rooms A WHERE A.ROOM_STATUS = 1";
			$table->columns(array("A.ROOM_ID", 
								  "A.ROOM_NAME", 
								  "CONCAT(A.ROOM_FACILITIES, '<div>Luas : ', A.ROOM_LARGE, ' </div>')",
								  "A.ROOM_PIC", 
								  "A.ROOM_PABX"));
			$this->newtable->width(array('Ruang Rapat' => 250,
										 'Fasilitas' => 150,
										 'Penanggung Jawab' => 100,
										 'PABX' => 50));
			$this->newtable->search(array(array("A.ROOM_NAME", 'Ruang Rapat'),
										  array("A.ROOM_FACILITIES", 'Fasilitas'),
										  array("A.ROOM_PIC", 'Penanggung Jawab'),
										  array("A.ROOM_PABX", 'PABX')
										  ));
			$table->keys(array("ROOM_ID"));
			$table->hiddens(array("ROOM_ID")); #mdi-action-delete
			$table->menu(array('Tambah' => array('GET', site_url('rooms/create'), '0', 'home'),
							   'Edit' => array('GET', site_url().'rooms/create', '1', 'mdi-editor-insert-drive-file', 'blue darken-1')));
			$table->cidb($this->db);
			$table->ciuri($this->uri->segment_array());
			$table->action(site_url('reference/rooms'));
			$table->detail(site_url().'get/rooms');
			$table->orderby(1);
			$table->sortby("ASC");
			$table->show_search(TRUE);
			$table->show_chk(TRUE);
			$table->single(FALSE);
			$table->hashids(TRUE);
			$table->expandrow(TRUE);
			$table->postmethod(TRUE);
			$table->tbtarget("room_list");
			$table->judul('Daftar Ruang Rapat');
			$arrdata = array('table' => $table->generate($query));
			if($this->input->post("data-post")) return $table->generate($query);
			else return $arrdata;
		}
		
	}

}
?>