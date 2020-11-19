<?php

//database_connection.php

// connect database
$connect = new PDO("mysql:host=localhost;dbname=tetris","root","");

$base_url = "http://localhost:8085/project1/";
// $base_url = "http://localhost/tutorial/user-attendance-system-in-php-using-ajax/";


// count number of total rows
function get_total_records($connect, $table_name)
{
	$query = "SELECT * FROM $table_name";
	$statement = $connect->prepare($query);
	$statement->execute();
	return $statement->rowCount();
}

// ------------------------------------------------------------------------------------------------------

// retrieve the user scores
function get_user_scores($connect, $user_id)
{
	// select query
	$query = "SELECT * FROM tbl_score WHERE user_id = '".$user_id."' ";

	// execute and fetch
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '';
	
	foreach($result as $row)
	{
		$output .= '<option value="'.$row["score_value"].'">'.$row["score_date"].'</option>';
	}
	return $output;
}

// ------------------------------------------------------------------------------------------------------

// get name of that user
function get_user_name($connect, $user_id)
{
	// select query
	$query = "
	SELECT user_name FROM tbl_user 
	WHERE user_id = '".$user_id."'
	";

	// execute and fetch
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();

	foreach($result as $row)
	{
		return $row["user_name"];
	}
}

//get email of that user
function get_user_email($connect, $user_id)
{
	// select query
	$query = "
	SELECT user_emailid FROM tbl_user 
	WHERE user_id = '".$user_id."'
	";

	// execute and fetch
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();

	foreach($result as $row)
	{
		return $row["user_emailid"];
	}
}

//get doj of that user
function get_user_doj($connect, $user_id)
{
	// select query
	$query = "
	SELECT user_doj FROM tbl_user 
	WHERE user_id = '".$user_id."'
	";

	// execute and fetch
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();

	foreach($result as $row)
	{
		return $row["user_doj"];
	}
}






/* load course list
function load_course_list($connect)
{
	// select query
	$query = "
	SELECT * FROM tbl_course ORDER BY course_code ASC
	";

	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '';
	
	foreach($result as $row)
	{
		$output .= '<option value="'.$row["course_id"].'">'.$row["course_code"].'</option>';
	}

	return $output;
}


// --------------------------------------------------------------------------------------------------------

// calculate percentage for defaulters
function get_defatt_percentage($connect, $user_id)
{
	// select query
	$query = "
	SELECT 
		ROUND((SELECT COUNT(*) FROM tbl_attendance 
		WHERE attendance_status = 'Present' 
		AND user_id = '".$user_id."') 
	* 100 / COUNT(*)) AS percentage FROM tbl_attendance 
	WHERE user_id = '".$user_id."'
	";

	// execute and fetch
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	
	// for each row calculate percentage
	foreach($result as $row)
	{
		if($row["percentage"] >75)
		{
			return 'NULL';			
		}
		else
		{
			return $row["percentage"] . '%';
		}
	}
}


// -----------------------------------------------------------------------------------------------------

// get course name from user id
function Get_user_course_name($connect, $user_id)
{
	// select query
	$query = "
	SELECT tbl_course.course_name FROM tbl_user 
	INNER JOIN tbl_course 
	ON tbl_course.course_id = tbl_user.user_course_id 
	WHERE tbl_user.user_id = '".$user_id."'
	";

	// execute and fecth
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	
	foreach($result as $row)
	{
		return $row['course_name'];
	}
}


// ------------------------------------------------------------------------------------------------------

// get course name from course id
function Get_course_name($connect, $course_id)
{
	// select query
	$query = "
	SELECT course_name FROM tbl_course 
	WHERE course_id = '".$course_id."'
	";

	// execute and fetch
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	
	foreach($result as $row)
	{
		return $row["course_name"];
	}
}*/

// ------------------------------------------------------------------------------------------------------

?>
