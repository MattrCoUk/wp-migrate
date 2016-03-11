<?php	
require_once('authenticate.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: text/html; charset=utf-8');

	ini_set('memory_limit', '1000M');
	set_time_limit(0);

	$fileSizeLimit = 50000000;

	require_once('setup.php');


if ( isset($_POST["submit"]) ) :

	try {
	    
	    // Undefined | Multiple Files | $_FILES Corruption Attack
	    // If this request falls under any of them, treat it invalid.
	    if (
	        !isset($_FILES['upfile']['error']) ||
	        is_array($_FILES['upfile']['error'])
	    ) {
	        throw new RuntimeException('Invalid parameters.');
	    }

	    // Check $_FILES['upfile']['error'] value.
	    switch ($_FILES['upfile']['error']) {
	        case UPLOAD_ERR_OK:
	            break;
	        case UPLOAD_ERR_NO_FILE:
	            throw new RuntimeException('No file sent.');
	        case UPLOAD_ERR_INI_SIZE:
	        case UPLOAD_ERR_FORM_SIZE:
	            throw new RuntimeException('Exceeded filesize limit.');
	        default:
	            throw new RuntimeException('Unknown errors.');
	    }

	    // You should also check filesize here. 
	    if ($_FILES['upfile']['size']> $fileSizeLimit) {
	        throw new RuntimeException('Exceeded filesize limit.');
	    }
		
		// the below is not working with php 5.2
		
	    // // DO NOT TRUST $_FILES['upfile']['mime'] VALUE !!
	    // // Check MIME Type by yourself.
	    // $finfo = new finfo(FILEINFO_MIME_TYPE);
	    // if (false === $ext = array_search(
	    //     $finfo->file($_FILES['upfile']['tmp_name']),
	    //     array(
	    //         'gz' => 'application/x-gzip',
	    //     ),
	    //     true
	    // )) {
	    //     throw new RuntimeException('Invalid file format.');
	    // }

	    // You should name it uniquely.
	    // DO NOT USE $_FILES['upfile']['name'] WITHOUT ANY VALIDATION !!
	    // On this example, obtain safe unique name from its binary data.
	    // not used here as we want ot overwrite the file ib each upload
	    $ext = 'gz';
	    if (!move_uploaded_file(
	        $_FILES['upfile']['tmp_name'],
	        sprintf('%s.%s',
	        //     sha1_file($_FILES['upfile']['tmp_name']),
	        //     $ext

		        'upload/incoming-db-sql',
		        $ext
	        )

	    )) {
	        throw new RuntimeException('Failed to move uploaded file.');
	    }

	    echo 'File is uploaded successfully.';

	} catch (RuntimeException $e) {

	    echo $e->getMessage();

	}




	if (!is_dir(dirname(__FILE__) . '/upload')) mkdir(dirname(__FILE__) . '/upload',0755);
	

	$file = dirname(__FILE__) . '/upload/incoming-db-sql.'.$ext;
	$run = "gunzip < ". $file ." | " . $path_to_mysql . " -u" . $d_base['user'] . " -p" . $d_base['pass'] . " -h" . $d_base['host'] . " '" . $d_base['dbname']. "'";

	exec($run);
	// echo "<br><br>" .$run . "<br>";


	require_once('db-connect.php');


	$DB = new dbConnect($d_base, $quiet_mode);




	foreach( $source_uri as $uri ){
		$DB->query( "UPDATE ${table_prefix}options SET option_value = replace(option_value, '$uri', '$dest_uri') WHERE option_name = 'home' OR option_name = 'siteurl'" );
	    $DB->query( "UPDATE ${table_prefix}posts SET guid = replace(guid, '$uri', '${dest_uri}${dest_uri_suffix}' )" );
		$DB->query( "UPDATE ${table_prefix}posts SET post_content = replace(post_content, '$uri', '${dest_uri}${dest_uri_suffix}' )" );
	}


	if( "" != $dest_uri_suffix) {
		foreach ($dir_list as $dest_uri_suffix ) {
			$DB->query( "UPDATE ${table_prefix}posts SET post_content = replace(post_content, '${dest_uri}${dest_uri_suffix}/${dirs}', '${dest_uri}/${dirs}')");
		}
	}

endif;
?>



<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<title>WP Migrate, PUT - <?php echo $d_base['name']; ?></title>

<style type="text/css">
	body,html{height: 100%;}
	body{font-size:110%; background-color: #D3DCE3; font-family: 'Helvetica Neue', sans-serif; position: relative;}
	form{margin: 5em auto; max-width: 500px;}
	footer{position: absolute; bottom: 1em; right: 1em; color: #999;}
	input[type="submit"]{margin-left: 3em; transform: scale(1.6);-webkit-transform: scale(1.6);}
	input[type="file"]{margin: 2em 6em; transform: scale(1.5);-webkit-transform: scale(1.5);}
</style>

</head>
<body>

<p><?php echo $d_base['name']; ?></p>
	<form enctype="multipart/form-data"  method="POST">

		
		    <!-- MAX_FILE_SIZE must precede the file input field -->
	    <input type="hidden" name="MAX_FILE_SIZE" value="<?php $fileSizeLimit ?>">

		Select file to upload (<?php echo $fileSizeLimit/1000000; ?>MB limit):<br>
	    <input type="file" name="upfile">


	    <br><br>


		<input type="submit" value="Go for it!" name="submit">
	    
	</form>


<footer><small>WP MySQL migrate tool. 2016 by MATTR.co.uk</small></footer>
<body>

