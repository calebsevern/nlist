<?php

	//Requires MySQL Native Driver
	//Requires PEAR::Mail
	//Requires PEAR::Net_SMTP
	
	//Replace with development/production credentials as appropriate
	
	
	/*
	*	We need this ugly thing to get the current url,
	*	so that the installer won't need to prompt for 
	*	an "install directory". Mainly used for recruiting email confirmations.
	*/
	
	function get_current_url($strip = true) {
	
		$filter = function($input, $strip) {
			$input = urldecode($input);
			$input = str_ireplace(array("\0", '%00', "\x0a", '%0a', "\x1a", '%1a'), '', $input);
			if ($strip)
				$input = strip_tags($input);
			$input = htmlentities($input, ENT_QUOTES, 'UTF-8');
			return trim($input);
		};

		$url = array();
		$url['protocol'] = 'http://';
		if (isset($_SERVER['HTTPS']) && (strtolower($_SERVER['HTTPS']) === 'on' || $_SERVER['HTTPS'] == 1))
			$url['protocol'] = 'https://';
		elseif (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443)
			$url['protocol'] = 'https://';
		$url['host'] = $_SERVER['HTTP_HOST'];
		$url['request_uri'] = $filter($_SERVER['REQUEST_URI'], $strip);
		$u = join('', $url);
		return str_replace(basename(__FILE__), "", join('', $url));
	}
	
	return array(
		'host' => 'localhost',
		'db' => 'econ',
		'username' => 'root',
		'password' => 'jvyrPM#w*vK3Mty',
		'email' => 'yourname@example.com',
		'full_name' => 'John Doe',
		'smtp_host' => 'ssl://smtp.gmail.com',
		'smtp_port' => '465',
		'smtp_login' => 'test1231235123535@gmail.com',
		'smtp_password' => 'Jonessoda00@',
		'public_directory' => get_current_url()
	);
	
	