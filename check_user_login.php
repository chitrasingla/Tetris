<?php

//check_user_login.php

include('../demotetris/database/database_connection.php');

session_start();

// called by login.php 

$user_emailid = '';
$user_password = '';
$error_user_emailid = '';
$error_user_password = '';
$error = 0;

// empty email
if(empty($_POST["user_emailid"]))
{
	$error_user_emailid = 'Email Address is required';
	$error++;
}
else
{
	$user_emailid = $_POST["user_emailid"];
}

// empty pasword
if(empty($_POST["user_password"]))
{	
	$error_user_password = 'Password is required';
	$error++;
}
else
{
	$user_password = $_POST["user_password"];
}

// if both are present
if($error == 0)
{
	$query = "
	SELECT * FROM tbl_user
	WHERE user_emailid = '".$user_emailid."'
	";

	// match emailid by the databse

	$statement = $connect->prepare($query);
	if($statement->execute())
	{
		$total_row = $statement->rowCount();
		if($total_row > 0)
		{
			// fetch all results matched by emailid
			$result = $statement->fetchAll();
			foreach($result as $row)
			{
				// verify password
				if(password_verify($user_password, $row["user_password"]))
				{
					$_SESSION["user_id"] = $row["user_id"];
				}
				else			// else wrong password
				{
					$error_user_password = "Wrong Password";
					$error++;
				}
			}
		}
		else			// if not row matched then wrong email
		{
			$error_user_emailid = "Wrong Email Address";
			$error++;
		}
	}
}

// if there is error
if($error > 0)
{
	$output = array(
		'error'			=>	true,
		'error_user_emailid'	=>	$error_user_emailid,
		'error_user_password'	=>	$error_user_password
	);
}
else			// success
{
	$output = array(
		'success'		=>	true
	);
}

echo json_encode($output);

?>