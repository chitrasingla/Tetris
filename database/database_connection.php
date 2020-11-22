<?php

//database_connection.php

// connect database
$connect = new PDO("mysql:host=localhost;dbname=tetris","root","");

$base_url = "http://localhost:8085/Tetris/";


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


// ------------------------------------------------------------------------------------------------------

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


// ------------------------------------------------------------------------------------------------------

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
		return $row[0];
	}
}


// ------------------------------------------------------------------------------------------------------

//
function get_highscore($connect,$user_id){
	$query= "
	SELECT MAX(score_value) from tbl_score 
	WHERE tbl_score.user_id = '".$user_id."'
	";
	// execute and fetch
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach ($result as $row) {
		return $row[0];
	}
}


// -----------------------------------------------------------------------------------------------------

//
function get_rank($connect,$user_id){
	$query= "
	SELECT DISTINCT user_id from tbl_score 
	WHERE tbl_score.score_value > (SELECT MAX(score_value) from tbl_score 
	WHERE tbl_score.user_id = '".$user_id."')
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	return $statement->rowCount()+1;
}


// --------------------------------------------------------------------------------------------------------

//
function average_score($connect,$user_id){
	$query ="
	SELECT AVG (score_value) from tbl_score
	WHERE tbl_score.user_id = '".$user_id."'
	";

	// execute and fetch
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach ($result as $row) {
		return $row[0];
	}
}


?>
