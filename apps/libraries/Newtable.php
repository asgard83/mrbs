<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
class Newtable {
	var $rows				= array();
	var $columns			= array();
	var $hiderows			= array();
	var $keys				= array();
	var $proses				= array();
	var $keycari			= array();
	var $heading			= array();
	var $width				= array();
	var $menu_width			= "";
	var $auto_heading		= TRUE;
	var $show_chk			= TRUE;
	var $use_where			= FALSE;
	var $caption			= NULL;	
	var $template 			= NULL;
	var $newline			= "";
	var $lang				= "ID";
	var $empty_cells		= "&nbsp;";
	var $actions			= "";
	var $detils				= "";
	var $baris				= "10";
	var $db 				= "";
	var $hal 				= "AUTO";
	var $uri				= "";
	var $js_file			= "";
	
	var $bsdialog			= array();
	var $bsdatepicker		= array();
	
	var $show_search		= TRUE;
	var $use_ajax			= FALSE;
	var $single			 	= TRUE;
	var $dropdown			= TRUE;
	var $orderby			= 1;
	var $groupby			= array();
	var $sortby				= "ASC";
	var $postmethod			= FALSE;
	var $title				= "";
	var $hashids			= FALSE;
	var $tbtarget			= "";
	var $expandrow			= FALSE;
	var $addfilter			= FALSE;
	var $fieldfilter		= "";			
	var $dbcombobox			= array();
	var $settrid			= FALSE;
	var $attrid				= "";
	var $callback			= "";
	var $fieldcallback		= "";
	var $divappend			= FALSE;
	var $judul				= "";
	
	function Newtable()
	{
		$this->CI =& get_instance();
		$this->CI->load->helper('form');
		$this->hiderows[] = 'HAL';
	}
	
	function width($row)
	{
		$this->width = $row;
		return;
	}
	
	function menu_width($row)
	{
		$this->menu_width = $row;
		return;
	}
	function js_file($file)
	{
		$this->js_file = $file;
		return;
	}
	
	function show_search($show)
	{
		$this->show_search = $show;
		return;
	}
	
	function show_chk($show)
	{
		$this->show_chk = $show;
		return;
	}
	
	function use_ajax($use)
	{
		$this->use_ajax = $use;
		return;
	}
	
	function use_where($use)
	{
		$this->use_where = $use;
		return;
	}
	
	function columns($col)
	{
		$this->columns = $col;
		return;
	}
	
	function groupby($field){
		if ( ! is_array($field)){
			return FALSE;
		}
		$this->groupby = $field;
		return;
	}
	
	function orderby($order)
	{
		$this->orderby = $order;
		return;
	}
	
	function sortby($sort)
	{
		$this->sortby = $sort;
		return;
	}
	
	function topage($to)
	{
		$this->hal = (int)$to;
		return;
	}
	
	function cidb($db)
	{
		$this->db = $db;
		return;
	}
	
	function rowcount($row)
	{
		$this->baris = $row;
		return;
	}
	
	function ciuri($uri)
	{
		$this->uri = $uri;
		return;
	}
	
	
	function bsdialog($bsdialog){
		if(!is_array($bsdialog)){
			return FALSE;
		}
		$this->bsdialog = $bsdialog;
		return;
	}
	
	function bsdatepicker($bsdatepicker){
		if(!is_array($bsdatepicker)){
			return FALSE;
		}
		$this->bsdatepicker = $bsdatepicker;
		return;
	}
	
	function action($act)
	{
		$this->actions = $act;
		return;
	}
	
	function detail($act)
	{
		$this->detils = $act;
		return;
	}
	
	function title($title){
		$this->title = $title;
		return;
	}
	
	function tbtarget($tbtarget){
		$this->tbtarget = $tbtarget;
		return;
	}
	
	function expandrow($expandrow){
		$this->expandrow = $expandrow;
		return;
	}
	
	function hiddens($row)
	{
		if ( ! is_array($row))
		{
			$row = array($row);
		}
		foreach ( $row as $a )
		{
			if ( ! in_array($a, $this->hiderows) ) $this->hiderows[] = $a;
		}
		return;
	}
	
	function keys($row)
	{
		if ( ! is_array($row))
		{
			$row = array($row);
		}
		foreach ( $row as $a )
		{
			if ( ! in_array($a, $this->keys) ) $this->keys[] = $a;
		}
		return;
	}
	
	function menu($row)
	{
		if ( ! is_array($row))
		{
			return FALSE;
		}
		$this->proses = $row;
		return;
	}
	
	function search($row)
	{
		if ( ! is_array($row))
		{
			return FALSE;
		}
		$this->keycari = $row;
		return;
	}
	
	function single($more)
	{
		$this->single = $more;
		return;
	}
	
	function dropdown($btn){
		$this->dropdown = $btn;
		return;
	}
	
	function hashids($hashids){
		$this->hashids = $hashids;
		return;
	}
	
	function postmethod($postmethod){
		$this->postmethod = $postmethod;
		return;
	}
	
	function addfilter($addfilter){
		$this->addfilter = $addfilter;
		return;
	}

	function fieldfilter($fieldfilter){
		$this->fieldfilter = $fieldfilter;
		return;
	}
	
	function settrid($settrid){
		$this->settrid = $settrid;
		return;
	}
	
	function attrid($attrid){
		$this->attrid = $attrid;
		return;
	}
	
	function callback($callback){
		$this->callback = $callback;
		return;
	}
	
	function fieldcallback($fieldcallback){
		$this->fieldcallback = $fieldcallback;
		return;
	}
	
	function divappend($divappend){
		$this->divappend = $divappend;
		return;
	}
	
	function judul($judul){
		$this->judul = $judul;
		return;
	}
	
	function set_template($template)
	{
		if ( ! is_array($template)) return FALSE;
		$this->template = $template;
	}
	
	function set_heading()
	{
		$args = func_get_args();
		$this->heading = (is_array($args[0])) ? $args[0] : $args;
	}
	
	function make_columns($array = array(), $col_limit = 0)
	{
		if ( ! is_array($array) OR count($array) == 0) return FALSE;
		$this->auto_heading = FALSE;
		if ($col_limit == 0) return $array;
		$new = array();
		while(count($array) > 0)
		{	
			$temp = array_splice($array, 0, $col_limit);
			if (count($temp) < $col_limit)
			{
				for ($i = count($temp); $i < $col_limit; $i++)
				{
					$temp[] = '&nbsp;';
				}
			}
			$new[] = $temp;
		}
		return $new;
	}

	function set_empty($value)
	{
		$this->empty_cells = $value;
	}
	
	function add_row()
	{
		$args = func_get_args();
		$this->rows[] = (is_array($args[0])) ? $args[0] : $args;
	}

	function set_caption($caption)
	{
		$this->caption = $caption;
	}	

	function generate($table_data = NULL)
	{
		if ( ! is_null($table_data))
		{
			if (is_object($table_data))
			{
				$this->_set_from_object($table_data);
			}
			elseif (is_array($table_data))
			{
				$set_heading = (count($this->heading) == 0 AND $this->auto_heading == FALSE) ? FALSE : TRUE;
				$this->_set_from_array($table_data, $set_heading);
			}
			elseif ($table_data!="")
			{
				if ( $this->db == "" || !is_array($this->uri) ) return 'Missing required params (db & uri)';
				if ( ($this->db->dbdriver=='mssql' || $this->db->dbdriver=='sqlsrv') && !is_array($this->columns) )  return 'Missing required params (columns)';
				if($this->CI->input->post('data-post')) $this->clear(); 
				
				$kunci = "";
				$terkunci = "";
				$cari = "";
				$tercari = "";

				if(!$this->CI->input->post("data-post")){
					if($this->addfilter){
						$default = strpos(strtolower($table_data), "where");
						if ( $default === false )
							$table_data .= " WHERE ".$this->fieldfilter;
						else
							$table_data .= " AND ".$this->fieldfilter;
					}
				}else{
					$this->addfilter = FALSE;
					$this->fieldfilter = "";
				}	
				
				if(!$this->CI->input->post('inline')){#Single Searching	
					$arrkunci = explode("|",$this->CI->input->post('opt_search'));
					if($this->CI->input->post('range') && $this->CI->input->post('block')){ #Range Datepicker dengan single searching
						if(is_array($this->CI->input->post('range'))){
							$arrbetween = $this->CI->input->post('range');
							$range = "BETWEEN '". $arrbetween[0] . "' AND '" . $arrbetween[1]. "'";
							$arrcari = explode("|",$range);
						}
					}else{
						$arrcari = explode("|",$this->CI->input->post('key_search'));
					} 
				}else{
					$arrkunci = array_keys($this->CI->input->post('opt_search'));
					$arrcari = $this->CI->input->post('opt_search');
				}
				$and = ""; 
				foreach($arrkunci as $z => $kunci){
					if ( array_key_exists($kunci, $this->keycari))
					{
						$terkunci = $this->keycari[$kunci]; 
						$terkunci = $terkunci[0];
						$cari = $arrcari[$z];
						if(is_array($cari)){
							if($cari[0] != "" && $cari != ""){
								if(count(array_unique($cari)) > 1){
									$tercari .= "$and $terkunci BETWEEN '". $cari[0] . "' AND '" . $cari[1]. "'";
									$and = " AND ";
								}
							}
						}else{
							if($cari != ""){
								$cari = str_replace("'", "''", $cari);
								if(substr($terkunci, 0, 4)=="{IN}"){
									$terkunci = substr($terkunci, 4);
									$tercari .= " $and ".str_replace("{LIKE}", "LIKE '%$cari%'", $terkunci);
								}else{
									$between = strpos(strtolower($cari), "between");
									if ($between === false){
										$tercari .= " $and $terkunci LIKE '%$cari%'";
									}else{
										$tercari .= "$terkunci ".str_replace("''", "'", $cari); 
									}
								}
								$and = " AND ";
							}
						}
					}
				}
				if ( $this->baris != "ALL"){
					if($this->CI->input->post('tb_view') < 1) $this->baris = 10;
					else $this->baris = $this->CI->input->post('tb_view');
				}

				if ($tercari!="")
				{
					if ( $this->use_where )
					{
						$table_data .= " WHERE $tercari";
					}
					else
					{
						$ada = strpos(strtolower($table_data), "where");
						if ( $ada === false )
							$table_data .= " WHERE $tercari";
						else
							$table_data .= " AND $tercari";
					}
				}
				if(count($this->groupby) > 0){
					$komagrup = "";
					$columns = "";
					foreach($this->groupby as $z){
						$columns .= $komagrup.$z;
						$komagrup = ",";
					}
					$table_data = $table_data . " GROUP BY " . $columns;
				}
				
				$total_record = 0;
				$table_count = $this->db->query("SELECT COUNT(*) AS JML FROM ($table_data) AS TBL");
				if ( $table_count )
				{
					$table_count = $table_count->row();
					$total_record = $table_count = $table_count->JML;
				}
				else
				{
					$total_record = 0;
				}
				
				if ($this->CI->input->post('orderby')){ 
					$this->orderby = (int)$this->CI->input->post('orderby');
					$this->sortby = $this->CI->input->post('sortby');
					if ( $this->db->dbdriver=='mssql' || $this->db->dbdriver=='sqlsrv' )
					{
						$orderby = $this->columns[$this->orderby-1];
						if ( is_array($orderby) ) $orderby = $orderby[0];
					}
					else
					{
						$orderby = $this->orderby;
					}
				}
				else
				{
					if (is_numeric($this->orderby) )
					{
						if ( $this->db->dbdriver=='mssql' || $this->db->dbdriver=='sqlsrv' )
						{
							$orderby = $this->columns[$this->orderby-1];
							if ( is_array($orderby) ) $orderby = $orderby[0];
						}
						else
						{
							$orderby = $this->orderby;
						}
					}
					else
					{
						$orderby = $this->orderby;
					}
				}
				
				if ( $this->baris != "ALL"){
					$table_count = ceil($table_count / $this->baris);
					if($this->hal == "AUTO") $this->hal = $this->CI->input->post('tb_hal');
					if ( $this->hal < 1 ) $this->hal = 1;
					if ( $this->hal > $table_count ) $this->hal = $table_count;
					if ( $this->hal==1 ){
						if ( $this->db->dbdriver=='mssql' || $this->db->dbdriver=='sqlsrv' )
						{
							$dari = $this->hal;
							$sampai = $this->baris;
						}
						else
						{
							$dari = 0;
							$sampai = $this->baris;
						}
					}
					else
					{
						if ( $this->db->dbdriver=='mssql' || $this->db->dbdriver=='sqlsrv' )
						{
							$dari = ($this->hal * $this->baris) - $this->baris + 1;
							$sampai = $this->hal * $this->baris;
						}else{
							$dari = $this->hal>0?($this->hal-1) * $this->baris:0;
							$sampai = $this->baris;
						}
					}
					if ( $this->db->dbdriver=='mssql' || $this->db->dbdriver=='sqlsrv' )
						$table_data = "SELECT * FROM (SELECT ROW_NUMBER() OVER (ORDER BY $orderby $this->sortby) AS HAL, ".substr($table_data, 6)." ) AS TBLTMP WHERE HAL >= $dari AND HAL <= $sampai";
					else
						$table_data = "$table_data ORDER BY $orderby $this->sortby LIMIT $dari, $sampai";
				}
				else
				{
					$table_data = $table_data." ORDER BY $orderby $this->sortby";
				}

				$table_data = $this->db->query($table_data); 
				$this->_set_from_object($table_data);
				
			}
		}
	
		if (count($this->heading) == 0 AND count($this->rows) == 0)
		{
			return '<i>Undefined Table Data</i>';
		}
		$this->_compile_template();
		

		$out = '<div class="section">';
		
		$out .= 	'<form id="'.$this->tbtarget.'" action="'.$this->actions.'" autocomplete="off">';

		
		if($this->single)
		$out .= 	'<input type="hidden" id="searchtipe" value="1" '.($this->postmethod ? 'name="block"' : '').'>';
		else
		$out .= 	'<input type="hidden" id="searchtipe" value="N" '.($this->postmethod ? 'name="inline"' : '').'>';
		
		$arrsubhome = array();
		$prost = false;
		if(count($this->proses) > 0){
			foreach($this->proses as $prosa => $prosb){
				if (count($prosb)>3){
					if($prosb[3]=='home' && $prosb[0]=='GET' && $prosb[2]=='0')$arrsubhome[$prosa] = $prosb;
				}
			}
		}

		$out .= '<div class="row">';
		/**
		 * Judul Header
		 */
		if(!$this->CI->input->post('data-post')){
		$out .=		'<div class="col s12">
						<nav class="blue lighten-1">
							<div class="nav-wrapper">
								<div class="left col s12 m5 l5">
									<ul>
										<li><i class="mdi-action-view-list"></i></li>
										<li>&nbsp;'.$this->judul.'</li>
									</ul>
								</div>
								<div class="col s12 m7 l7 hide-on-med-and-down">
									<ul class="right">';
									if($this->show_search){
		$out .=							'<li><a href="javascript:void(0);" onClick="$(\'#sSearch_'.$this->tbtarget.'\').toggle(\'slow\')"><i class="mdi-action-find-in-page small icon-demo"></i></a></li>';
									}
		$out .=							'<li><a href="javascript:void(0);"><i class="mdi-action-info small icon-demo"></i></a></li>
									</ul>
								</div>
							</div>	
						</nav>
					</div>';
		}
		/**
		 * Akhir Judul Header
		 */
		
		
		/**
		 * If Show Searach = True
		 */
		if(!$this->CI->input->post('data-post')){
			if ($this->show_search){
				$lblcategory = "Filter Berdasarkan";
				$seltitle = "Pilih Kategori";
				$contains = "Dengan kata kunci";
				$titlecontains = "Ketik Kata Kunci &amp; Tekan Enter Untuk Mencari";
				$lbldropdownbtn = "Pilih Proses";
				$arrkey = $this->keycari;
				$out .= '<div class="col s12" id="sSearch_'.$this->tbtarget.'" style="display:none;">';
				/**
				 * Single Searching
				 */
				if($this->single){
					$out .=					'<div class="row" style="margin-left:10px; margin-top:20px; margin-right:10px; margin-bottom:10px;">';
					$out .= 					'<div class="col s12">';
					$out .=						'<div class="row">';
					$out .= 					'<label class="col s3">'.$lblcategory.'</label>';
					$out .= 					'<div class="col s4" id="'.rand().'">';
						$out .= 						'<select class="select-dropdown" id="tb_keycari" title="'.$seltitle.'"'.($this->postmethod ? 'name="opt_search" data-postmethod = "'.$this->postmethod.'" data-form = "#'.$this->tbtarget.'" data-action = "'.$this->actions.'" data-target =".'.$this->tbtarget.'" data-post = "TRUE"' : '').' >';
														foreach ($this->keycari as $a => $b){
															$out .= '<option value="';
															$out .= $a;
															$out .= '"';
															if (count($b)>2){
																if ($b[2][0]=="STRING"){
																	$out .= ' cb="'.implode(";", $b[2][1]).'"';
																}else if ($b[2][0]=="ARRAY"){
																	$out .= ' cb="'.implode(";", array_keys($b[2][1])).'" urcb="'.implode(";", array_values($b[2][1])).'"';
																}else if ($b[2][0] == "DATEPICKER"){
																	$out .= ' picker = "'. $b[2][1][0] . '" data-picker ="'.$b[2][1][1].'" data-format ="'.$b[2][1][2].'"';
																}else if($b[2][0] == "DATERANGE"){
																	$out .= ' range = "'. $b[2][1][0] . '" data-picker = "'.$b[2][1][1].'" data-format = "'.$b[2][1][2].'"';
																}
															}
															$out .= '>';
															$out .= $b[1];
															$out .= '</option>';
														}
					$out .= 							'</select>';
					$out .=						'</div>';
					
					$out .=						'<div class="col s5" id="'.rand().'">';
					$out .=							'<div class="input-field col s12" style="margin-top:0px;"><input class="form-control input-sm key_search" type="text" id="key_search" placeholder="'.$contains.'" name="key_search"><label for="key_search" class=""></label><i class="mdi-action-pageview prefix"vdata-form = "#'.$this->tbtarget.'" data-action = "'.$this->actions.'" data-target =".'.$this->tbtarget.'" data-post = "TRUE" style="cursor:pointer;" id="btn-search-'.rand().'" onclick="postobj($(this));"></i></div>';
					$out .=						'</div>';

					$out .= 					'</div>';
					$out .=						'</div>';
					$out .=					'</div>';
				}
				/** 
				 * End Single Searching 
				*/
				
				/**
				 * Multiple Searching
				 */
				else
				{
					$out .= 			    '<div class="row" style="margin-left:10px; margin-top:20px; margin-right:10px; margin-bottom:10px;">';
						foreach($this->keycari as $a => $b){
					$out .=						'<div class="col s6">
														<label id="lbl_'.str_replace(".", "_", $b[0]).'" style="margin-bottom:0px;">'.$b[1].'</label>';
														if (count($b)>2){
															if ($b[2][0]=="STRING"){
																$out .= ' combobox string';
															}else if ($b[2][0]=="ARRAY"){
																$out .= '<div class="select fg-line">';
																$out .= '<select class="form-control keywords" name="opt_search['.$a.']" id="'.rand(pow(10, $counter-1), pow(10, $counter)-1).'" '.((is_array($b[3]) && $this->postmethod) ? 'data-url = "'.$b[3][0].'"' : "").'>';
																$out .= '<option value=""></option>';
																foreach ($b[2][1] as $valopt => $selopt) {
																	$out .= '<option value= "'.$valopt.'">'.$selopt.'</option>';
																}
																$out .= '</select>';
																$out .= '</div>';
															}else if ($b[2][0] == "DATEPICKER"){
																$out .= '<input type="text" class="form-control date-pickers keywords" data-date-format="'.$b[2][1][2].'" placeholder="'.$b[2][1][2].'" name="opt_search['.$a.']"" id="'.rand(pow(10, $counter-1), pow(10, $counter)-1).'">';
															}else if($b[2][0] == "DATERANGE"){
																$out .= '<div class="input-daterange input-group"><input class="form-control datepickers-range keywords col-sm-3 date-start" type="text" placeholder="Dari" name="opt_search['.$a.'][]" data-date-format="'.$b[2][1][2].'" id="'.rand(pow(10, $counter-1), pow(10, $counter)-1).'"><span class="input-group-addon"><i class="fa fa-chevron-right"></i></span><input class="form-control mb-10 datepickers-range keywords col-sm-3 date-end" type="text" placeholder="Sampai" name="opt_search['.$a.'][]" data-date-format="'.$b[2][1][2].'" id="'.rand(pow(10, $counter-1), pow(10, $counter)-1).'">
						  </div>';
															}
														}else{
															$out .= '<input type="text" class="form-control keywords" id="'.$b[0].'" name="opt_search['.$a.']" id="'.rand(pow(10, $counter-1), pow(10, $counter)-1).'">';
														}
					$out .=								'</div>';			
						}
					$out .= 				'</div>';
					
					$out .= '<div class="row" style="margin-left:10px; margin-top:20px; margin-right:10px; margin-bottom:10px;">
								<div class="btn-demo">
									<button class="btn waves-effect waves-light blue lighten-1" data-form = "#'.$this->tbtarget.'" data-action = "'.$this->actions.'" data-target =".'.$this->tbtarget.'" data-post = "TRUE" style="cursor:pointer;" id="btn-search-'.rand().'" onclick="postobj($(this)); return false;">Cari <i class="mdi-content-send right"></i></button>
								</div>
							 </div>';
				}
				/**
				 * End Multiple Searching
				 */
				$out .= '</div>';
			}				 
		}
		/**
		 * End Show Search = True
		 */
		
		/**
		 * Generate Tabel
		 */
		$out .= '<div class="col s12 '.$this->tbtarget.'">';
		$out .= '<div style="height:10px;">&nbsp;</div>';
		$out .= $this->template['table_open'];
		$out .= '<thead>';
		
		if ($this->caption){
			$out .= '<caption>' . $this->caption . '</caption>';
		}
		if (count($this->heading) > 0){
			if ($this->baris=='ALL') $out .= '<tr class="head">';
			else $out .= '<tr>';
			foreach($this->heading as $z => $heading)
			{
				if ( $this->db->dbdriver=='mssql' || $this->db->dbdriver=='sqlsrv' )
				{
					if( !$this->show_chk) $z--;
				}
				else
				{
					if( !$this->show_chk) $z++;
					
				}
				if ( ! in_array($heading, $this->hiderows))
				{ 
					if ( (($this->db->dbdriver=='mssql' || $this->db->dbdriver=='sqlsrv') && $z < 0 && $this->show_chk) || ($z==0 && $this->show_chk) ){
						$out .= '<th width="13">';
						$out .= $heading;
						$out .= '</th>';
					}else{
						
						if($this->expandrow){
							$z--;
						}
						if($this->expandrow && $z == 1){
							$out .= '<th width="8">x</th>';
						}

						if ( array_key_exists($heading, $this->width) ) $out .= '<th width="'.$this->width[$heading].'">';
						else $out .= "<th>";
						if ( $this->baris != "ALL")
						{
							if ( $z==$this->orderby ){
								if ( $this->sortby=="ASC" )
								{
									$out .= "<span title=\"Sort By ".$heading." (Z-A)\" orderby=\"$z\" sortby=\"DESC\"".($this->postmethod || $this->CI->input->post('data-post') ? " data-post = \"TRUE\" data-form = \"#".$this->tbtarget."\" data-action = \"".$this->actions."\" data-target = \".".$this->tbtarget."\" id =\"orderby\" onclick=\"order($(this));\"" : "").">$heading</span>";
								}
								else
								{
									$out .= "<span title=\"Sort By ".$heading." (Z-A)\" orderby=\"$z\" sortby=\"ASC\"".($this->postmethod || $this->CI->input->post('data-post') ? " data-post = \"TRUE\" data-form = \"#".$this->tbtarget."\" data-action = \"".$this->actions."\" data-target = \".".$this->tbtarget."\" id =\"orderby\" onclick=\"order($(this));\"" : "")."\>$heading</span>";
								}
							}else{
								$out .= "<span title=\"Sort By ".$heading." (Z-A)\" orderby=\"$z\" sortby=\"ASC\"".($this->postmethod || $this->CI->input->post('data-post') ? " data-post = \"TRUE\" data-form = \"#".$this->tbtarget."\" data-action = \"".$this->actions."\" data-target = \".".$this->tbtarget."\" id =\"orderby\" onclick=\"order($(this));\"" : "").">$heading</span>";
							}
						}
						else
						{
							$out .= "<span>$heading</span>";
						}
						$out .= '</th>';
						
					}
				}
			}
			$out .= $this->template['heading_row_end'];
		}
		$out .= '</thead>';
		
		if (count($this->rows) > 0)
		{
			$out .= '<tbody '.($this->postmethod ? 'id="body-'.$this->tbtarget.'"': '').'>';
			$i = 1;
			foreach($this->rows as $row)
			{
				if ( ! is_array($row))
				{
					break;
				}
				
				$keyz = "";
				$koma = "";
				foreach ($this->keys as $a)
				{
					$keyz .= $koma.$row[$a];
					$koma = ".";
				}
				
				if($this->hashids){
					$keyz = hashids_encrypt($keyz,_HASHIDS_,9);
				}
				
				$name = (fmod($i++, 2)) ? '' : 'alt_';
				if($i%2==0) $cls = 'alt-row';
				else $cls = "main-row";
				if ($this->detils=="")
				{
					$out .= '<tr class="'.$cls.'" urldetil="" id="'.$this->tbtarget.'-'.rand().'">';
				}
				else
				{
					if ($this->show_chk)
						$out .= '<tr class="'.$cls.'" urldetil="/'.$keyz.'" id="'.$this->tbtarget.'-'.rand().'">';
					else
						$out .= '<tr class="'.$cls.'" urldetil="/'.$keyz.'" id="'.$this->tbtarget.'-'.rand().'">';
				}
				$out .= $this->newline;
				
				if ( $this->show_chk ){
					$sId_Td = 'td_'.$this->tbtarget.'_'.rand();
					$out .= '<td><div class="center-align"><input type="checkbox" name="tb_chk[]" class="tb_chk filled-in" id ="'.$sId_Td.'" value="'.$keyz.'"><label for="'.$sId_Td.'"></label></div></td>';
				}
				if ($this->expandrow) $out .= '<td width="8"><a href="javascript:void(0);" id="expand'.$keyz.'" onclick="expand($(this)); return false;" title="Expand baris"><i class="zmdi zmdi-format-valign-center zmdi-hc-fw"></i></a></td>';
				$seq = -1;
				foreach($row as $rowz => $cell)
				{
					if ( !in_array($rowz, $this->hiderows))
					{
						
						if ($this->baris=='ALL' || !$this->show_chk) $out .= '<td class="pad12">';
						else $out .= "<td>";
						if ($cell === "")
						{
							$out .= $this->empty_cells;
						}
						else
						{
							$cell = str_replace(chr(10), '<br>', $cell);
							$url_col = $this->columns[$seq];
							if ( is_array($url_col) )
							{
								$new_url_col = $url_col[1];
								$url_col = explode("{", $new_url_col); 
								foreach($url_col as $x){
									$temp_url_col = explode("}", $x); 
									$temp_url_col = $temp_url_col[0]; 
									$new_url_col = str_replace("{".$temp_url_col."}", ($this->hashids ? hashids_encrypt($row[$temp_url_col],_HASHIDS_,9) : $row[$temp_url_col]), $new_url_col); 

								}

								if(in_array('modal', $this->columns[$seq])){
									$out .= '<a href="javascript:void(0);" data-url = "'.$new_url_col.'" class="modal-link" onclick="modalrow($(this));">'.$cell.'</a>'; #Extend
								}else if(in_array('replace', $this->columns[$seq])){
									$out .= '<a href="javascript:void(0);" data-url="'.$new_url_col.'" class="replaced" id = "'.rand().'" onclick="fullscdiv($(this));" data-target="#'.$this->columns[$seq][3].'"><small><i class="fa fa-unsorted"></i></small> '.$cell.'</a>';
								}else if(in_array('append', $this->columns[$seq])){
									$out .= '<a href="javascript:void(0);" data-url = "'.$new_url_col.'" class="append-link" onclick="appendrow($(this));">'.$cell.'</a>'; #End Extend
								}
								else{
									$out .= '<a href="'.$new_url_col.'">'.$cell.'</a>'; #Default
								}
							}
							else
							{
								$out .= $cell;
							}
						}
						$out .= $this->template['cell_'.$name.'end'];
						
					}
					$seq++;
				}
				if($this->settrid){
					$attr_row = $this->attrid; 
					$attr_rowx = explode("{", $attr_row); 
					foreach($attr_rowx as $attrx){
						$temp_attr = explode("}", $attrx);
						$temp_attr = $temp_attr[0];
						$attr_row = str_replace("{".$temp_attr."}", $row[$temp_attr], $attr_row);
						
					}
					if($this->callback != ""){
						$urlcallback = $this->callback;
						$tmpcallback = explode("{", $urlcallback);
						foreach($tmpcallback as $urlcall){
							$tmpcallbackx = explode("}", $urlcall);
							$tmpcallbackx = $tmpcallbackx[0];
							$urlcallback = str_replace("{".$tmpcallbackx."}", $row[$tmpcallbackx], $urlcallback);
						}
					}
					$out .= '<td><a href="javascript:void(0);" id="'.$this->tbtarget.'_'.$i.'" class="tdselect" data-target="'.str_replace('{','',str_replace('}','',$this->attrid)).'" data-retrive = "'.$attr_row.'" '.($this->callback!= "" ? "data-url-callback=\"".$urlcallback."\"" : "").' '.($this->callback!= "" ? "data-field-callback=\"".$this->fieldcallback."\"" : "").' onclick="selectedrow($(this));"><i class="fa fa-check-square"></i></a></td>';
				}

				$out .= $this->template['row_'.$name.'end'];
			}
			$out .= '</tbody>';
		
		}
		else #Jika Data Kosong
		{
			if($this->lang=="EN")
			{
				$out .= '<tr><td colspan="'.count($this->heading).'"><center><span class="label label-danger">Record Not Found</span></center></td></tr>';
			}
			else
			{
				$out .= '<tr><td colspan="'.count($this->heading).'"><center><span class="label label-danger">Data Tidak Ditemukan</span></center></td></tr>';
			}
		}
		
		$out .= $this->template['table_close'];
		$out .= '<input type="hidden" name="tb_hal" value="'.$this->hal.'" /><input type="hidden" name="tb_view" value="'.$this->baris.'" /><input type="hidden" name="orderby" value="'.$this->orderby.'"><input type="hidden" name="sortby" value="'.$this->sortby.'">';
		$out .= '<input type="hidden" name="tblang" value="'.$this->lang.'">';
		if ($this->detils!="") $out .= '<input type="hidden" id="urldtl" value="'.$this->detils.'">';

		if (count($this->rows) > 0){
		/**
		 * Blok Pagination
		 */
		$out .= '<div class="row">';
		/**
		 * Pagination Start
		 */
		$out .= '<div class="col s12">';
		$out .= '<div class="row">';
		if($this->baris != "ALL"){
		$datast = ($this->hal - 1);
		if ( $datast<1 ) $datast = 1;
		else $datast = $datast * $this->baris + 1;
		$dataen = $datast + $this->baris - 1;
		if($total_record < $dataen) $dataen = $total_record;
		if($total_record==0) $datast = 0;
		/**
		 * Navigasi Pagination left
		 */
		$out .= '<div class="col s6 m6">';
		$out .= '<ul class="nav-kiri pagination" style="margin-left:10px;">';
					if($total_record>=10){
						if($this->baris==10)
							$out .= '<li class="active"><a href="javascript:void(0);" class="per" title="Tampilkan 10 Data Per Halaman" '.($this->postmethod || $this->CI->input->post('data-post') ? " data-post = \"TRUE\" data-form = \"#".$this->tbtarget."\" data-action = \"".$this->actions."\" data-target = \".".$this->tbtarget."\" id =\"per10\" onclick=\"view($(this));\"" : "").'>10</a></li>';
						else
							$out .= '<li class="waves-effect"><a href="javascript:void(0);" class="per" title="Tampilkan 10 Data Per Halaman" '.($this->postmethod || $this->CI->input->post('data-post') ? " data-post = \"TRUE\" data-form = \"#".$this->tbtarget."\" data-action = \"".$this->actions."\" data-target = \".".$this->tbtarget."\" id =\"per10\" onclick=\"view($(this));\"" : "").'>10</a></li>';
					 }
					 if($total_record>=20){
						  if($this->baris==20)
							$out .= '<li class="active"><a href="javascript:void(0);" class="per" title="Tampilkan 20 Data Per Halaman" '.($this->postmethod || $this->CI->input->post('data-post') ? " data-post = \"TRUE\" data-form = \"#".$this->tbtarget."\" data-action = \"".$this->actions."\" data-target = \".".$this->tbtarget."\" id =\"per20\" onclick=\"view($(this));\"" : "").'>20</a></li>';
						  else
							$out .= '<li class="waves-effect"><a href="javascript:void(0);" class="per" title="Tampilkan 20 Data Per Halaman" '.($this->postmethod || $this->CI->input->post('data-post') ? " data-post = \"TRUE\" data-form = \"#".$this->tbtarget."\" data-action = \"".$this->actions."\" data-target = \".".$this->tbtarget."\" id =\"per20\" onclick=\"view($(this));\"" : "").'>20</a></li>';
					 }
					 if($total_record>=50){
						if($this->baris==50)
							$out .= '<li class="active"><a href="javascript:void(0);" class="per" title="Tampilkan 50 Data Per Halaman" '.($this->postmethod || $this->CI->input->post('data-post') ? " data-post = \"TRUE\" data-form = \"#".$this->tbtarget."\" data-action = \"".$this->actions."\" data-target = \".".$this->tbtarget."\" id =\"per50\" onclick=\"view($(this));\"" : "").'>50</a></li>';
						else
							$out .= '<li class="waves-effect"><a href="javascript:void(0);" class="per" title="Tampilkan 50 Data Per Halaman" '.($this->postmethod || $this->CI->input->post('data-post') ? " data-post = \"TRUE\" data-form = \"#".$this->tbtarget."\" data-action = \"".$this->actions."\" data-target = \".".$this->tbtarget."\" id =\"per50\" onclick=\"view($(this));\"" : "").'>50</a></li>';
					}
					if($total_record>=100){
						  if($this->baris==100)
							$out .= '<li class="active"><a href="javascript:void(0);" class="per" title="Tampilkan 100 Data Per Halaman" '.($this->postmethod || $this->CI->input->post('data-post') ? " data-post = \"TRUE\" data-form = \"#".$this->tbtarget."\" data-action = \"".$this->actions."\" data-target = \".".$this->tbtarget."\" id =\"per100\" onclick=\"view($(this));\"" : "").'>100</a></li>';
						  else
							$out .= '<li class="waves-effect"><a href="javascript:void(0);" class="per" title="Tampilkan 100 Data Per Halaman" '.($this->postmethod || $this->CI->input->post('data-post') ? " data-post = \"TRUE\" data-form = \"#".$this->tbtarget."\" data-action = \"".$this->actions."\" data-target = \".".$this->tbtarget."\" id =\"per100\" onclick=\"view($(this));\"" : "").'>100</a></li>';
					}
				  if($total_record!=10 || $total_record!=20 || $total_record!=50 || $total_record!=100){
					  if($total_record<=100){
						  if($this->baris==$total_record){
							  $out .= '<li class="active"><a href="javascript:void(0);" class="current per" title="Tampilkan '.$total_record.' Data Per Halaman" '.($this->postmethod || $this->CI->input->post('data-post') ? " data-post = \"TRUE\" data-form = \"#".$this->tbtarget."\" data-action = \"".$this->actions."\" data-target = \".".$this->tbtarget."\" id =\"per".$total_record."\" onclick=\"view($(this));\"" : "").'>'.$total_record.'</a></li>';
						  }else{
							  $out .= '<li class="waves-effect"><a href="javascript:void(0);" class="per" title="Tampilkan '.$total_record.' Data Per Halaman" '.($this->postmethod || $this->CI->input->post('data-post') ? " data-post = \"TRUE\" data-form = \"#".$this->tbtarget."\" data-action = \"".$this->actions."\" data-target = \".".$this->tbtarget."\" id =\"per".$total_record."\" onclick=\"view($(this));\"" : "").'>'.$total_record.'</a></li>';
						  }
					  }else{
						  $out .= '<li class="disabled"><a href="javascript:void(0);" class="disabled" title="Total Data">'.$total_record.'</a></li>';
					  }
				  }
			$out .= '</ul>';	
		$out .= '</div>';
		/**
		 * End Navigasi Pagination Left
		 */
		
		/**
		 * Navigasi Pagination Right
		 */
		$out .= '<div class="col s6 m6">';
		$out .= '<ul class="nav-kanan pagination" style="margin-right:10px;">';	
					if($this->hal==1)
					$out .= '<li class="active"><a href="javascript:void(0);" class="active page" title="Ke Halaman 1" '.($this->postmethod || $this->CI->input->post('data-post') ? " data-post = \"TRUE\" data-form = \"#".$this->tbtarget."\" data-action = \"".$this->actions."\" data-target = \".".$this->tbtarget."\" id =\"page-".$this->hal."\" onclick=\"nextprevpage($(this));\"" : "").'>1</a></li>';
					else
					$out .= '<li class="waves-effect"><a href="javascript:void(0);" class="page" title="Ke Halaman 1" '.($this->postmethod || $this->CI->input->post('data-post') ? " data-post = \"TRUE\" data-form = \"#".$this->tbtarget."\" data-action = \"".$this->actions."\" data-target = \".".$this->tbtarget."\" id =\"page-".$this->hal."\" onclick=\"nextprevpage($(this));\"" : "").'>1</a></li>';
						
					if($this->hal>=6){
						$out .= '<li class="waves-effect"><a href="#">&hellip; </a></li>';
						$minnav = $this->hal-2;
						$maxnav = $this->hal+2;
					}else{
						$minnav = 0;
						$maxnav = 0;
					}
					$countnav = 1;
					for($halnav=2;$halnav<$table_count;$halnav++){
						if(($minnav==0 && $maxnav==0) || ($halnav>=$minnav && $halnav<=$maxnav)){
							if($this->hal==$halnav)
								$out .= '<li class="active"><a href="javascript:void(0);" class="active page" title="Ke Halaman '.$halnav.'" '.($this->postmethod || $this->CI->input->post('data-post') ? " data-post = \"TRUE\" data-form = \"#".$this->tbtarget."\" data-action = \"".$this->actions."\" data-target = \".".$this->tbtarget."\" id =\"page-".$halnav."\" onclick=\"nextprevpage($(this));\"" : "").'>'.$halnav.'</a></li>';
							else
								$out .= '<li class="waves-effect"><a href="javascript:void(0);" class="page" title="Ke Halaman '.$halnav.'" '.($this->postmethod || $this->CI->input->post('data-post') ? " data-post = \"TRUE\" data-form = \"#".$this->tbtarget."\" data-action = \"".$this->actions."\" data-target = \".".$this->tbtarget."\" id =\"page-".$halnav."\" onclick=\"nextprevpage($(this));\"" : "").'>'.$halnav.'</a></li>';
							$countnav++;
						}
						if($countnav==6) break;
					}
					if($table_count>7) $out .= '<li class="waves-effect"><a href="#">&hellip; </a></li>';
					if($table_count>1){
						if($this->hal==$table_count)
								$out .= '<li class="active"><a href="javascript:void(0);" class="active page" title="Ke Halaman'.$table_count.'" '.($this->postmethod || $this->CI->input->post('data-post') ? " data-post = \"TRUE\" data-form = \"#".$this->tbtarget."\" data-action = \"".$this->actions."\" data-target = \".".$this->tbtarget."\" id =\"page-".$table_count."\" onclick=\"nextprevpage($(this));\"" : "").'>'.$table_count.'</a></li>';
							else
								$out .= '<li class="waves-effect"><a href="javascript:void(0);" class="page" title="Ke Halaman '.$table_count.'" '.($this->postmethod || $this->CI->input->post('data-post') ? " data-post = \"TRUE\" data-form = \"#".$this->tbtarget."\" data-action = \"".$this->actions."\" data-target = \".".$this->tbtarget."\" id =\"page-".$table_count."\" onclick=\"nextprevpage($(this));\"" : "").'>'.$table_count.'</a></li>';
					}
			$out .= '</ul>';
		$out .= '</div>';
		/**
		 * End Navigasi Pagination Right
		 */
		}
		$out .= '</div>';
		$out .= '</div>';
		/**
		 * End Pagination
		 */	
		$out .= '</div>';
		}
		/**
		 * End Blok Pagination
		 */


		$out .= '</div>';
		/**
		 * Akhir Generate Tabel
		 */
		
		/**
		 * End class row before mail-app
		 */
		$out .=	'</div>';

		$out .=	'</form>';

		$out .= '</div>';
		/**
		 * End Mail App Section
		 */


		/**
		 * FAB Menu
		 */


		if (count($this->proses) > 0 && $this->show_chk){
			$out .= '<div class="fixed-action-btn">
						<a class="btn-floating btn-large red accent-4"><i class="mdi-action-assignment"></i></a>';
				$out .= '<ul>';
				if(count($arrsubhome)>0){
					foreach ($arrsubhome as $a => $b){
						$out .= '<li><a href="javascript:void(0);" id = "'.rand().'new" act="'.$b[1].'" value="'.$a.'" '.($b[4]=="append" ? "data-append=\"true\" data-div=\"#newdiv\" data-class = \".formsearch"   : "").' '.($b[4]=="modal" ? "data-modal=\"true" : "").' class="btn-floating green btnsubmenu" style="transform: scaleY(0.4) scaleX(0.4) translateY(40px) translateX(0px); opacity: 0;"><i class="mdi-editor-border-color"></i></a></li>';
					}
				}			

				foreach ($this->proses as $a => $b){
					if(!array_key_exists($a, $arrsubhome)){
						  $out .= '<li class="tbs_menu" '.(($this->CI->config->item('url_suffix') && ($b[2] == 1 || $b[2] > 1) ) ? 'url-suffix=".html"' : '') .' met="'.$b[0].'" jml="'.$b[2].'" url="'.$b[1].'"'.(strlen($b[5]) > 0 ? 'isngajax = "true" data-form = "#'.$this->tbtarget.'"' : ""). (strlen(trim($b[6])) > 0 ? 'data-body = "'.$b[5].'"' : ''). ' ><a href="javascript:void(0);" class="btn-floating '.$b[4].'" style="transform: scaleY(0.4) scaleX(0.4) translateY(40px) translateX(0px); opacity: 0;"><i class="'.$b[3].'"></i>&nbsp;'.$a.'&nbsp;</a></li>';
						  
					  }
				}
				$out .= '</ul>';	
			$out .= '</div>';
		}
		/**
		 * End of FAB Menu
		 */
		
		if($this->divappend){
			$out .= '<div class="row" id="newdiv"></div>';
		}
		return $out;
		
	}
	
	function clear()
	{
		$this->rows				= array();
		$this->heading			= array();
		$this->auto_heading		= TRUE;	
	}
	
	function _set_from_object($query)
	{
		if ( !is_object($query))
		{
			return FALSE;
		}
		
		if (count($this->heading) == 0)
		{
			if ( ! method_exists($query, 'list_fields'))
			{
				return FALSE;
			}
			empty($this->heading);
			if( $this->show_chk ) $this->heading[] = '<input type="checkbox" class="filled-in"'.($this->postmethod ? 'class="chkall'.$this->tbtarget.'" onchange="_chkall($(this));" id ="chkall'.$this->tbtarget.'" data-body = "#body-'.$this->tbtarget.'" ': 'id="tb_chkall').'><label for="'.($this->postmethod ? 'chkall'.$this->tbtarget : 'tb_chkall').'"></label>';
			if( $this->expandrow ) $this->heading[] = '&nbsp;';
			foreach ($query->list_fields() as $a)
			{
				$this->heading[] = $a;
			}
			if($this->settrid)$this->heading[] = '&nbsp;';
		}
		
		if ($query->num_rows() > 0)
		{
			foreach ($query->result_array() as $row)
			{
				$this->rows[] = $row;
			}
		}
	}

	function _set_from_array($data, $set_heading = TRUE)
	{
		if ( ! is_array($data) OR count($data) == 0)
		{
			return FALSE;
		}
		
		$i = 0;
		foreach ($data as $row)
		{
			if ( ! is_array($row))
			{
				$this->rows[] = $data;
				break;
			}
						
			if ($i == 0 AND count($data) > 1 AND count($this->heading) == 0 AND $set_heading == TRUE)
			{
				$this->heading = $row;
			}
			else
			{
				$this->rows[] = $row;
			}
			
			$i++;
		}
	}

	function _compile_template()
	{ 	
		if ($this->template == NULL)
		{
			$this->template = $this->_default_template();
			return;
		}
		
		$this->temp = $this->_default_template();
		foreach (array('table_open','heading_row_start', 'heading_row_end', 'heading_cell_start', 'heading_cell_end', 'row_start', 'row_end', 'cell_start', 'cell_end', 'row_alt_start', 'row_alt_end', 'cell_alt_start', 'cell_alt_end', 'table_close') as $val)
		{
			if ( ! isset($this->template[$val]))
			{
				$this->template[$val] = $this->temp[$val];
			}
		} 	
	}
	
	function _default_template()
	{
		return  array ('table_open' 			=> '<table class="tabelajax table striped responsive-table">',

						'heading_row_start' 	=> '<tr>',
						'heading_row_end' 		=> '</tr>',
						'heading_cell_start'	=> '<th>',
						'heading_cell_end'		=> '</th>',

						'row_start' 			=> '<tr>',
						'row_end' 				=> '</tr>',
						'cell_start'			=> '<td>',
						'cell_end'				=> '</td>',

						'row_alt_start' 		=> '<tr>',
						'row_alt_end' 			=> '</tr>',
						'cell_alt_start'		=> '<td>',
						'cell_alt_end'			=> '</td>',

						'table_close' 			=> '</table>'
					);	
	}
}