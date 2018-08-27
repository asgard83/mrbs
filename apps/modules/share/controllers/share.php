<?php
class Share extends MY_Controller{

	public function index()
	{
		
	}

    public function put() 
    {
        if (isset($_SERVER['HTTP_ORIGIN'])) {
        	header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        	//header('Access-Control-Allow-Credentials: true');
        	header('Access-Control-Max-Age: 86400');
    	}
		if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS'){
			if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
				header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         
			if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
				header("Access-Control-Allow-Headers:        {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
			exit(0);
		}
		$postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
        echo $request->latitude;
    }
		
}
?>