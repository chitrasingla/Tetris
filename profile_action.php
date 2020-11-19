<?php

//profile_action.php

// include database
include('database/database_connection.php');
session_start();

if(isset($_POST["action"]))
{

	// for score list
	if($_POST["action"] == "fetch")
	{
		// retrieve data of that user
		$query = "
		SELECT tbl_score.score_date,tbl_score.score_value FROM tbl_score WHERE tbl_score.user_id='".$_SESSION["user_id"]."';
		";
		/*SELECT tbl_score.score_date,tbl_score.score_value FROM tbl_score
	    INNER JOIN tbl_user
	    ON tbl_score.user_id = tbl_user.user_id */
		//when i add this i dont understand what happens
		//WHERE tbl_score.user_id= '".$_SESSION["user_id"]."'	

		// for searching
		if(isset($_POST["search"]["value"]))
		{
			$query .= '
			WHERE tbl_score.score_value LIKE "%'.$_POST["search"]["value"].'%" 
			OR tbl_score.score_date LIKE "%'.$_POST["search"]["value"].'%" 
			';
		}

		// for ordering data 
		if(isset($_POST["order"]))
		{
			$query .= '
			ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].'
			';
		}
		else
		{
			$query .= '
			ORDER BY tbl_score.score_date DESC
			';
		}

		if($_POST["length"] != -1)
		{
			$query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
		}

		// execute and fetch matched rows
		$statement = $connect->prepare($query);
		$statement->execute();
		$result = $statement->fetchAll();
		$data = array();
		$filtered_rows = $statement->rowCount();

		// for each row put data in array
		foreach($result as $row)
		{
			//if($row["user_id"] == $_SESSION["user_id"]){
			$sub_array = array();
			$sub_array[] = $row["score_date"];
			$sub_array[] = $row["score_value"];
			$data[] = $sub_array;
			//}
		}
		
		// store in output
		$output = array(
			"draw"				=>	intval($_POST["draw"]),
			"recordsTotal"		=> 	get_total_records($connect, 'tbl_score'),
			"recordsFiltered"	=>	$filtered_rows,
			"data"				=>	$data
		);

		// return output data in json format
		echo json_encode($output);
	}	  
}
?>