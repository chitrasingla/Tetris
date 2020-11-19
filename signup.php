<?php

//signup.php

// connect database
include('../demotetris/database/database_connection.php');

session_start();

if(isset($_POST["action"]))
{
	// for sign up action 
		// variables 
		$newuser_user_name = '';
		$newuser_email = '';
		$newuser_password = '';

		$error_newuser_user_name = '';
		$error_newuser_email = '';
		$error_newuser_password = '';

		$error = 0;

		// newuser user_name empty
		if(empty($_POST["newuser_user_name"]))
		{
			$error_newuser_user_name = 'User name is required';
			$error++;
		}
		else
		{
			$newuser_user_name = $_POST["newuser_user_name"];
		}

		if(empty($_POST["newuser_email"]))
		{
			$error_newuser_email = 'User email id is required';
			$error++;
		}
		else
		{
			// check email format
			if(!filter_var($_POST["newuser_email"], FILTER_VALIDATE_EMAIL))
			{
				$error_newuser_email = 'Invalid email-id format';
				$error++;	
			}
			else
			{
				$newuser_email = $_POST["newuser_email"];
			}
		}
		
		// password empty
		if(empty($_POST["newuser_password"]))
		{
			$error_newuser_password = 'Password is required';
			$error++;
		}
		else
		{
			$newuser_password = $_POST["newuser_password"];
		}

		// if any validation error
		if($error > 0)
		{
			// output array
			$output = array(
				'error'								=>	true,
				'error_newuser_user_name'			=>	$error_newuser_user_name,
				'error_newuser_email'				=>  $error_newuser_email,
				'error_newuser_password'			=>	$error_newuser_password,
			);
		}
		else
		{

			// for adding newuser
				$data = array(
					':newuser_user_name'			=>	$newuser_user_name,
					':newuser_doj'					=>  date("Y-m-d"),
					':newuser_email'				=> 	$newuser_email,
					':newuser_password'				=>	password_hash($newuser_password, PASSWORD_DEFAULT)
				);
			
				// select query
				$query = "
				INSERT INTO tbl_user 
				(user_name, user_doj, user_emailid, user_password) 
				SELECT * FROM (SELECT :newuser_user_name, :newuser_doj, :newuser_email, :newuser_password) as temp
				WHERE NOT EXISTS (
					SELECT user_emailid FROM tbl_user WHERE user_emailid = :newuser_email
				) LIMIT 1
				";

				$statement = $connect->prepare($query);
				if($statement->execute($data)){
					
					if($statement->rowCount() >0)					
					{
						// data added 
						$output = array(
							'success'		=>	'User Added Successfully',
						);
					}
					else
					{
						// error
						$output = array(
							'error'					=> 	true,
							'error_newuser_email' 	=> 'Email ID already exists'
						);
					}

				}
		}
		echo json_encode($output);
}

?>