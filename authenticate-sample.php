<?php 
	if (!isset($_SERVER['PHP_AUTH_USER']) || $_SERVER['PHP_AUTH_USER'] !== "you-username" || $_SERVER['PHP_AUTH_PW'] !== "your-password" ) {
	    header('WWW-Authenticate: Basic realm="My Realm"');
	    header('HTTP/1.0 401 Unauthorized');
	    echo 'Unauthorized';
	    exit;
	}
?>