<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Main extends CI_Model
{
	
	function get_uraian($query, $select)
	{
		$data = $this->db->query($query);
		if ($data->num_rows() > 0) {
			$row = $data->row();
			return $row->$select;
		} else {
			return "";
		}
		return 1;
	}
	
	function get_result(&$query)
	{
		$data = $this->db->query($query);
		if ($data->num_rows() > 0) {
			$query = $data;
		} else {
			return false;
		}
		return true;
	}
	
	function get_row_array(&$query, $db = "")
	{
		$result = array();
		if ($db != "") {
			$dbnya = $this->load->database($db, TRUE);
			$data  = $dbnya->query($query);
		} else {
			$data = $this->db->query($query);
		}
		if ($data->num_rows() > 0) {
			foreach ($data->result_array() as $row) {
				$result[] = $row;
			}
		}
		return $result;
	}
	
	function array_cb($query, $key, $value)
	{
		$data    = $this->db->query($query);
		$arraycb = array();
		if ($data->num_rows() > 0) {
			foreach ($data->result_array() as $row) {
				if (!array_key_exists($row[$key], $arraycb))
					$arraycb[$row[$key]] = $row[$value];
			}
		} else {
			return false;
		}
		return $arraycb;
	}
	
	function set_combobox($query, $key, $value, $empty = FALSE, &$disable = "")
	{
		$combobox = array();
		$data     = $this->db->query($query);
		if ($empty)
			$combobox[""] = "&nbsp;";
		if ($data->num_rows() > 0) {
			$kodedis = "";
			$arrdis  = array();
			foreach ($data->result_array() as $row) {
				if (is_array($disable)) {
					if ($kodedis == $row[$disable[0]]) {
						if (!array_key_exists($row[$key], $combobox))
							$combobox[$row[$key]] = "&nbsp; &nbsp;&nbsp;&nbsp;" . $row[$value];
					} else {
						if (!array_key_exists($row[$disable[0]], $combobox))
							$combobox[$row[$disable[0]]] = $row[$disable[1]];
						if (!array_key_exists($row[$key], $combobox))
							$combobox[$row[$key]] = "&nbsp; &nbsp;&nbsp;&nbsp;" . $row[$value];
					}
					$kodedis = $row[$disable[0]];
					if (!in_array($kodedis, $arrdis))
						$arrdis[] = $kodedis;
				} else {
					$combobox[$row[$key]] = str_replace("'", "\'", $row[$value]);
				}
			}
			$disable = $arrdis;
		}
		return $combobox;
	}
	
	function post_to_query($array, $except = "")
	{
		$data = array();
		foreach ($array as $a => $b) {
			if (is_array($except)) {
				if (!in_array($a, $except))
					$data[$a] = $b;
			} else {
				$data[$a] = $b;
			}
		}
		return $data;
	}
	
	function get_result_array(&$query, $db = "")
	{
		$result = array();
		if ($db != "") {
			$dbnya = $this->load->database($db, TRUE);
			$data  = $dbnya->query($query);
		} else {
			$data = $this->db->query($query);
		}
		if ($data->num_rows() > 0) {
			foreach ($data->result_array() as $row) {
				$result = $row;
			}
		}
		return $result;
	}
	
	
	function find_where($query)
	{
		if (strpos($query, "WHERE") === FALSE) {
			$query = " WHERE ";
		} else {
			$query = " AND ";
		}
		return $query;
	}
	
	function allowed($ext)
	{
		for ($i = -1; $i > -(strlen($ext)); $i--) {
			if (substr($ext, $i, 1) == '.')
				return (substr($ext, $i));
		}
	}
	
	function set_menu($role)
	{
		$query = "SELECT LTRIM(RTRIM(A.MENU_ID)) AS MENU_ID, A.MENU_NAME AS MENU_NAME, A.MENU_CLASS AS MENU_CLASS, A.MENU_URL AS MENU_URL, 
		(SELECT COUNT(*) FROM sys_menu WHERE LEFT(sys_menu.MENU_ID, LENGTH(RTRIM(LTRIM(A.MENU_ID)))) = RTRIM(LTRIM(A.MENU_ID)) AND sys_menu.MENU_FOR = '0') AS SUB_MENU, A.MENU_ORDER
		FROM sys_menu A LEFT JOIN sys_menu_role B ON A.MENU_ID = B.MENU_ID
		WHERE B.ROLE_ID = '" . $role . "' AND A.MENU_STATUS = 1 ";
		if ((int) $this->newsession->userdata('SESS_RT') == 1) {
			/**
			 * Privilage Bagian Rumah Tangga
			 */
			if ((int) $this->newsession->userdata('SESS_PEG_TIPE') == 1) {
				$query .= " AND (A.MENU_FOR = '0' OR B.TIPE_ID = 1 AND B.ACTION = 1) AND A.MENU_ID NOT IN ('09','10') ";
			} else {
				$query .= " AND (A.MENU_FOR = '0' OR B.TIPE_ID = 2 AND B.ACTION = 1) ";
			}
		} else {
			
			if ((int) $this->newsession->userdata('SESS_PEG_TIPE') == 1) {
				/**
				 * Pejabat struktural Esselon 3 & 4 Dilingkungan Badan POM
				 */
				
				if ($this->newsession->userdata('SESS_TU_PIM')) {
					/**
					 * TU Pimpinan
					 */
					$query .= " AND (A.MENU_FOR = '0' OR B.TIPE_ID = 1 AND B.EXT_ID = 1) AND A.MENU_ID NOT IN ('06','07','11') ";
				} else {
					/**
					 * Esselon 3 & 4 semua unit, KTU
					 */
					$query .= " AND (A.MENU_FOR = '0' OR B.TIPE_ID = 1) AND B.ACTION IN (0) AND B.EXT_ID = 0 ";
					
				}
				/**
				 * End pejabat struktural Esselon 3 & 4
				 */
			}
		}
		//$query .= " ORDER BY 1, 6 ";
		$query .= " ORDER BY 6 ";
		if ($this->get_result($query)) {
			foreach ($query->result_array() as $row) {
				$result[$row['MENU_ID']] = array(
					$row['SUB_MENU'],
					$row['MENU_NAME'],
					$row['MENU_CLASS'],
					$row['MENU_BG'],
					str_replace('{urisegment}#', '', site_url($row['MENU_URL']))
				);
			}
		}
		return $result;
	}
	
	function set_content($priv, $content)
	{
		$appname = 'Si RAMUAN - Aplikasi Ruang Pertemuan';
		if ($priv == "signin") {
			$header = $this->load->view('header/signin', '', true);
		} else if ($priv == "dashboard") {
			$header = $this->load->view('header/dashboard', '', true);
		}
		$navmenu = ($priv == "dashboard" ? $this->set_menu($this->newsession->userdata('SESS_PANGKAT_ID')) : '');
		if ($breadcumbs == "")
			$breadcumbs = "";
		$data = array(
			'_appname_' => $appname,
			'_header_' => $header,
			'_navmenu_' => $navmenu,
			'_content_' => $content
		);
		return $data;
	}
	
	function gen_user($params)
	{
		$_result = "";
		$_char   = substr(str_replace(".", "", str_replace(" ", "", strtoupper($params))), 0, 3);
		$_num    = str_shuffle("0123456789876543210");
		$_num    = substr($_num, 3, 4);
		$_result = $_char . $_num;
		return $_result;
	}
	
	function gen_id($params)
	{
		$_result = "";
		$_char   = substr(str_replace(".", "", str_replace(" ", "", strtoupper($params))), 0, 3);
		$_num    = str_shuffle("0123456789876543210");
		$_num    = substr($_num, 3, 4);
		$_result = $_char . $_num;
		return $_result;
	}
	
	function set_verified(&$status, $roleid, $allowed)
	{
		$combobox[""] = "&nbsp;";
		$query        = "SELECT A.PROCCESS_AFTER, B.REFF_COMMENT, A.PROCCESS_ICON_CLASS, A.PROCCESS_BUTTON_COLOUR
			  FROM sys_proccess A LEFT JOIN sys_reference B ON A.PROCCESS_ACTION = B.REFF_CODE AND B.REFF_GROUP = '0007'
			  WHERE A.PROCCESS_ROLE_ID = '" . $roleid . "' AND A.PROCCESS_BEFORE = '$status' AND A.PROCCESS_ALLOWED = $allowed
			  ORDER BY B.REFF_ORDER DESC";
		$data         = $this->db->query($query);
		if ($data->num_rows() > 0) {
			$proses[] = '<a class="waves-effect waves-light btn btn-small light-blue darken-3" id="' . rand() . '" onclick="javascript:window.history.back(); return false;"><i class="mdi-content-undo left"></i>Kembali</a>';
			foreach ($data->result_array() as $row) {
				$proses[] = '<a class="waves-effect waves-light btn btn-small ' . $row['PROCCESS_BUTTON_COLOUR'] . '" id="' . rand() . '" data-status = "' . $row['PROCCESS_AFTER'] . '" onclick="proccess(\'#fpreview\',$(this)); return false;"><i class="' . $row['PROCCESS_ICON_CLASS'] . ' left"></i>' . $row['REFF_COMMENT'] . '</a>';
			}
		}
		return $proses;
	}
	
	function createThumbnail($path_to_image_directory, $path_to_thumbs_directory, $filename, $final_width_of_image)
	{
		if (preg_match('/[.](jpg)$/', $filename)) {
			$im = imagecreatefromjpeg($path_to_image_directory . $filename);
		} else if (preg_match('/[.](gif)$/', $filename)) {
			$im = imagecreatefromgif($path_to_image_directory . $filename);
		} else if (preg_match('/[.](png)$/', $filename)) {
			$im = imagecreatefrompng($path_to_image_directory . $filename);
		}
		
		$ox = imagesx($im);
		$oy = imagesy($im);
		
		$nx = $final_width_of_image;
		$ny = floor($oy * ($final_width_of_image / $ox));
		
		$nm = imagecreatetruecolor($nx, $ny);
		
		imagecopyresized($nm, $im, 0, 0, 0, 0, $nx, $ny, $ox, $oy);
		if (!file_exists($path_to_thumbs_directory)) {
			if (!mkdir($path_to_thumbs_directory)) {
				die("There was a problem. Please try again!");
			}
		}
		imagejpeg($nm, $path_to_thumbs_directory . $filename);
	}
	
	function gen_password()
	{
		$alphabet    = '!@#$%^&*()_+abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
		$pass        = array();
		$alphaLength = strlen($alphabet) - 1;
		for ($i = 0; $i < 8; $i++) {
			$n      = rand(0, $alphaLength);
			$pass[] = $alphabet[$n];
		}
		return implode($pass);
	}
	
	function get_day_indo($tgl)
	{
		$hari = date('l', strtotime($tgl));
		switch ($hari) {
			case "Sunday":
				return "Minggu";
				break;
			case "Monday":
				return "Senin";
				break;
			case "Tuesday":
				return "Selasa";
				break;
			case "Wednesday":
				return "Rabu";
				break;
			case "Thursday":
				return "Kamis";
				break;
			case "Friday":
				return "Jum'at";
				break;
			case "Saturday":
				return "Sabtu";
				break;
		}
		return $hari;
	}
	
}
?>