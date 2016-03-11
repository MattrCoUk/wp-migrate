<?php
	require_once('authenticate.php');

	set_time_limit(0);

	require_once('setup.php');

	$file = dirname(__FILE__) . '/'.$d_base['dbname'].'.sql.gz';
	exec($path_to_mysqldump . " -u" . $d_base['user'] . " -p" . $d_base['pass'] . " -h" . $d_base['host'] . " '" . $d_base['dbname'] . "' | gzip > ".$file);

	if (file_exists($file)) {
	    header('Content-Description: File Transfer');
	    header('Content-Type: application/octet-stream');
	    header('Content-Disposition: attachment; filename="'.basename($file).'"');
	    header('Expires: 0');
	    header('Cache-Control: must-revalidate');
	    header('Pragma: public');
	    header('Content-Length: ' . filesize($file));
	    readfile($file);
	    exit;
	}


?>