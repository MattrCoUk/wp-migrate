<?php
require_once('authenticate.php');


/**
 *
 *   Wordpress migrate tool by Mattr
 *   ===============================
 *
 *   Version 1.1
 *
 */

require_once('setup.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
		<title>WP Migrate - <?php echo $d_base['name']; ?></title>

		<style type="text/css">
			body,html{height: 100%;}
			body{ font-size:140%; line-height: 200%; background-color: #D3DCE3; font-family: 'Helvetica Neue', sans-serif; position: relative; }
			a{display: block; padding: 30px;margin: 20px; width: 200px; color: white; text-decoration: none; text-align: center;}
			li{display: block;}
			
		</style>

	</head>
	<body>
	<ul>
		<li><a style="background-color:green" href="get.php">&darr; Get</a></li>
		<li><a style="background-color:red" href="put.php">Put &uarr;</a></li>
	</ul>
<?php 
// phpinfo();
?>
	</body>
</html>