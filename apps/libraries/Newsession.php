 <?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Newsession {

	function Newsession($params = array())
	{
		@session_start();
	}
	
	function set_userdata($newdata = array(), $newval = '')
	{
		if (is_string($newdata))
		{
			$_SESSION[$newdata] = $newval;
			return;
		}
		
		if (count($newdata) > 0)
		{
			foreach ($newdata as $key => $val)
			{
				$_SESSION[$key] = $val;
			}
			return;
		}
	}
	
	function userdata($item)
	{
		return (!isset($_SESSION[$item])) ? FALSE : $_SESSION[$item];
	}
	
	function sess_destroy()
	{
		@session_unset();
		@session_destroy();
	}
}
?>