<?php
	/*
	list($microseconds,$seconds) = explode(' ',microtime());
	$id = $seconds.$microseconds.rand(0,9);
	$session_id = str_replace(".", "", $id);
	$_SESSION['session_id'] = $session_id;
	*/
	$_SESSION['session_id'] = time();
	
	//print_r($_SESSION);

	//get browser data without relying on extra php file
	function getBrowser() 
	{ 
		$u_agent = $_SERVER['HTTP_USER_AGENT']; 
		$bname = 'Unknown';
		$platform = 'Unknown';
		$version= "";

		//First get the platform?
		if (preg_match('/linux/i', $u_agent)) {
			$platform = 'linux';
		}
		elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
			$platform = 'mac';
		}
		elseif (preg_match('/windows|win32/i', $u_agent)) {
			$platform = 'windows';
		}
		
		// Next get the name of the useragent yes seperately and for good reason
		if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent)) 
		{ 
			$bname = 'Internet Explorer'; 
			$ub = "MSIE"; 
		} 
		elseif(preg_match('/Firefox/i',$u_agent)) 
		{ 
			$bname = 'Mozilla Firefox'; 
			$ub = "Firefox"; 
		} 
		elseif(preg_match('/Chrome/i',$u_agent)) 
		{ 
			$bname = 'Google Chrome'; 
			$ub = "Chrome"; 
		} 
		elseif(preg_match('/Safari/i',$u_agent)) 
		{ 
			$bname = 'Apple Safari'; 
			$ub = "Safari"; 
		} 
		elseif(preg_match('/Opera/i',$u_agent)) 
		{ 
			$bname = 'Opera'; 
			$ub = "Opera"; 
		} 
		elseif(preg_match('/Netscape/i',$u_agent)) 
		{ 
			$bname = 'Netscape'; 
			$ub = "Netscape"; 
		} 
		
		// finally get the correct version number
		$known = array('Version', $ub, 'other');
		$pattern = '#(?<browser>' . join('|', $known) .
		')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
		if (!preg_match_all($pattern, $u_agent, $matches)) {
			// we have no matching number just continue
		}
		
		// see how many we have
		$i = count($matches['browser']);
		if ($i != 1) {
			//we will have two since we are not using 'other' argument yet
			//see if version is before or after the name
			if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
				$version= $matches['version'][0];
			}
			else {
				$version= $matches['version'][1];
			}
		}
		else {
			$version= $matches['version'][0];
		}
		
		// check if we have a number
		if ($version==null || $version=="") {$version="?";}
		
		return array(
			'userAgent' => $u_agent,
			'name'      => $bname,
			'version'   => $version,
			'platform'  => $platform,
			'pattern'    => $pattern
		);
	} 

	
	$ua=getBrowser();
	/* //debug for getBrowser function
	$yourbrowser= "Your browser: " . $ua['name'] . " " . $ua['version'] . " on " .$ua['platform'] . " reports: <br >" . $ua['userAgent'];
	print_r($yourbrowser);
	*/

	//Get study condition (sequential) and increment it
	$file = fopen(path_to_theme()."/count.txt", "r");
	$studycondition = trim(fgets($file));
	fclose($file);

	$filewrite = fopen(path_to_theme()."/count.txt", "w");
	
	if($studycondition == "0") {
		fwrite($filewrite, "1");
	} else if ($studycondition == "1") {
		fwrite($filewrite, "2");
	} else if($studycondition == "2") {
		fwrite($filewrite, "3");
	} else {
		fwrite($filewrite, "0");
	}
	fclose($filewrite);
	
	//Write session data to db
	db_insert('weblabux_sessions')
		->fields(array(
		  'instance_id' => 0000,//TODO: what is this supposed to be?
		  'browser_data_guid' => 0000, //TODO: what is this supposed to be?
		  'browser_data_browser_type' => $ua['name'],
		  'browser_data_browser_version' => $ua['version'],
		  'browser_data_os' => $ua['platform'],
		  'browser_data_resolution' => "1x1",
		  'browser_data_language' => $_SERVER['HTTP_ACCEPT_LANGUAGE'],
		  'browser_data_country' => "TODO: Map IP to country",
		  'browser_data_ip' => $_SERVER['REMOTE_ADDR'],
		  'study_condition' => (int)$studycondition,
		))
		->execute();

	//Print the content of the page
	print render($content);
?>