<?php
class Home_act extends CI_Model{
	function table(){
		$table = $this->newtable;
		$reffstatus = $this->main->array_cb("SELECT kode, uraian FROM m_reff WHERE jenis = 'STATUS_DOK' ORDER BY 1", "kode", "uraian");
		$reffnsw = $this->main->array_cb("SELECT kode, uraian FROM m_reff WHERE jenis = 'STATUS_NSW' ORDER BY 1", "kode", "uraian");

		$query = "SELECT a.id, a.no_rekom AS 'No. Rekomendasi',
				  a.no_ukl AS 'No. UKL', DATE_FORMAT(a.tgl_terbit, '%d/%m/%Y') AS 'Tanggal Terbit',
				  b.uraian AS 'Status', c.uraian AS 'Status NSW'
				  FROM t_rekom a LEFT JOIN m_reff b on a.status_dok = b.kode AND b.jenis = 'STATUS_DOK'
				  LEFT JOIN m_reff c on a.status_nsw = c.kode AND c.jenis = 'STATUS_NSW'";
		$table->title("");
		$table->columns(array("a.id", "a.no_rekom", "a.no_ukl", "DATE_FORMAT(a.tgl_terbit, '%d/%m/%Y')","b.uraian"));
		$this->newtable->width(array('No. Rekomendasi' => 200 , 'No. UKL' => 200, 'Tanggal Terbit' => 100, 'Status' => 150, 'Status NSW' => 150));
		$this->newtable->search(array(array("a.no_rekom", 'No. Rekomendasi'),
									  array("a.no_ukl","No. UKL"),
									  array("DATE_FORMAT(a.tgl_terbit,'%d/%m/%Y')", "Tanggal Terbit", array('DATEPICKER', array('TRUE', 'data-date-format', 'dd/mm/yyyy'))),
									  array("a.status_dok", 'Status Dokumen', array('ARRAY', $reffstatus)),
									  array("a.status_nsw", 'Status NSW', array('ARRAY', $reffnsw))
									  ));
		$table->cidb($this->db);
		$table->ciuri($this->uri->segment_array());
		$table->action(site_url()."home/table");
		$table->orderby(1);
		$table->sortby("ASC");
		$table->keys(array("id"));
		$table->hiddens(array("id"));
		$table->show_search(TRUE);
		$table->show_chk(TRUE);
		$table->single(FALSE);
		$table->dropdown(TRUE);
		$table->hashids(FALSE);
		$table->postmethod(TRUE);
		$table->tbtarget("tb_rekom");
		$table->js_file('<script src="'. base_url(). 'assets/js/newtable/newtable.js?v='. date("YmdHis"). '" type="text/javascript"></script>');
		$table->judul('Newtable MD Subject I');
		$table->menu(array('Tambah' => array('GET', site_url().'setting/view/document/new', '0', 'home', 'modal'),
						   'Edit' => array('GET', site_url().'setting/view/document/new', '1', 'zmdi-edit zmdi-hc-fw'),
						   'Hapus' => array('POST', site_url().'setting/document/new', 'N', 'zmdi-delete', 'isngajax')));
		$arrdata = array('table' => $table->generate($query));
		if($this->input->post("data-post")) return $table->generate($query);
		else return $arrdata;
	}
}
?>