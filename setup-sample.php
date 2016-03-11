<?php
// Add your projects's details below 
// and rename this file to setup.php

require_once('authenticate.php');
	$quiet_mode = FALSE;
	
	# events localhost
	$d_base = Array( 

		'name'		=> '[My WP website on localhost]',

		'host'		=> "localhost",
	    'user' 		=> "root",
	    'pass'		=> "root",
	    'dbname'	=> "[db-name]",

	);

	$path_to_mysqldump 	= '/Applications/MAMP/Library/bin/mysqldump';
	$path_to_mysql 		= '/Applications/MAMP/Library/bin/mysql';

	
	$source_uri = Array(
		'',  
	);

	$dest_uri   = ''; 
	
	$dest_uri_suffix = ''; // for no mod-rewrite on server such as IIS

	$table_prefix = 'wp_';





?>