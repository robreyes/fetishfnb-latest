<?php

class Core {

	// Function to validate the post data
	function validate_post($data)
	{
		/* Validating the hostname, the database name and the username. The password is optional. */
		return !empty($data['hostname']) && !empty($data['username']) && !empty($data['database']);
	}

	// Function to show an error
	function show_message($type,$message) {
		return $message;
	}

	// Function to write the config file
	function write_config($data) {

		// Config path
		$template_path 	= 'config/database.php';
		$output_path 	= '../application/config/development/database.php';
		
		// Open the file
		$database_file = file_get_contents($template_path);

		$new  = str_replace("%HOSTNAME%",$data['hostname'],$database_file);
		$new  = str_replace("%USERNAME%",$data['username'],$new);
		$new  = str_replace("%PASSWORD%",$data['password'],$new);
		$new  = str_replace("%DATABASE%",$data['database'],$new);

		// Write the new database.php file
		$handle = fopen($output_path,'w+');

		// Chmod the file, in case the user forgot
		@chmod($output_path,0777);
		
		// Verify file permissions
		if(is_writable($output_path)) {

			// Write the file
			if(fwrite($handle,$new)) {
				return true;
			} else {
				return false;
			}

		} else {
			return false;
		}
	}

	// Function to write the config file
	function write_config_2($data) {

		// Config path
		$template_path 	= 'config/database.php';
		$output_path 	= '../application/config/production/database.php';

		// Open the file
		$database_file = file_get_contents($template_path);

		$new  = str_replace("%HOSTNAME%",$data['hostname'],$database_file);
		$new  = str_replace("%USERNAME%",$data['username'],$new);
		$new  = str_replace("%PASSWORD%",$data['password'],$new);
		$new  = str_replace("%DATABASE%",$data['database'],$new);

		// Write the new database.php file
		$handle = fopen($output_path,'w+');

		// Chmod the file, in case the user forgot
		@chmod($output_path,0777);
		
		// Verify file permissions
		if(is_writable($output_path)) {

			// Write the file
			if(fwrite($handle,$new)) {
				return true;
			} else {
				return false;
			}

		} else {
			return false;
		}
	}


	// Function to write the config file
	function write_config_3($base_url) {

		// Config path
		$template_path 	= 'config/config.php';
		$output_path 	= '../application/config/development/config.php';

		// Open the file
		$config_file 	= file_get_contents($template_path);

		$new  			= str_replace("%BASE_URL%", $base_url, $config_file);
		
		// Write the new database.php file
		$handle 		= fopen($output_path, 'w+');

		// Chmod the file, in case the user forgot
		@chmod($output_path, 0777);
		
		// Verify file permissions
		if(is_writable($output_path)) {
			// Write the file
			if(fwrite($handle, $new)) {
				return TRUE;
			} else {
				return FALSE;
			}
		} else {
			return FALSE;
		}
	}

	// Function to write the config file
	function write_config_4($base_url) {

		// Config path
		$template_path 	= 'config/config.php';
		$output_path 	= '../application/config/production/config.php';

		// Open the file
		$config_file 	= file_get_contents($template_path);

		$new  			= str_replace("%BASE_URL%", $base_url, $config_file);
		
		// Write the new database.php file
		$handle 		= fopen($output_path, 'w+');

		// Chmod the file, in case the user forgot
		@chmod($output_path, 0777);
		
		// Verify file permissions
		if(is_writable($output_path)) {
			// Write the file
			if(fwrite($handle, $new)) {
				return TRUE;
			} else {
				return FALSE;
			}
		} else {
			return FALSE;
		}
	}

}