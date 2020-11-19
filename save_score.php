<?php 

//save_score.php

// connect database
include('../demotetris/database/database_connection.php');

session_start();

$user_id = $_SESSION["user_id"];

$player_score = isset($_POST['score']) ? $_POST['score'] : 0;

// for adding game score
$data = array(
	':p_id'			=>	$user_id,
	':p_score'		=>  $player_score,
	':p_date'		=>  date("Y-m-d"),
	
);

// select query
$query = "
INSERT INTO tbl_score
(user_id, score_value, score_date) 
VALUES (:p_id, :p_score, :p_date)
";

$statement = $connect->prepare($query);
$statement->execute($data);
			
?>
