<?php

//leaderboard_action.php

// include database
include('database/database_connection.php');
session_start();

if(isset($_POST["action"]))
{

  // for user list
  if($_POST["action"] == "fetch")
  {

    //retrieve data to display leaderboard with users with their username, highscore and average score ordered by score_value 
    $query = "
    SELECT DISTINCT tbl_user.user_id FROM tbl_user
    INNER JOIN tbl_score
    ON tbl_score.user_id = tbl_user.user_id 
    
    ";

    // for searching
    if(isset($_POST["search"]["value"]))
    {
      $query .= '
      WHERE tbl_score.score_value LIKE "%'.$_POST["search"]["value"].'%" 
      OR tbl_user.user_name LIKE "%'.$_POST["search"]["value"].'%" 
      ';
    }

    // for ordering data 
    //not working because properly because the query data is different from the data array(elements of data array dont exist in the query generated using sql)
    if(isset($_POST["order"]))
    {
      $query .= '
      ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].'
      ';
    }
    else
    {
      $query .= '
      ORDER BY tbl_score.score_value DESC
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
      $sub_array = array();
      $sub_array[] = get_rank($connect,$row["user_id"]);
      $sub_array[] = get_user_name($connect,$row["user_id"]);
      $sub_array[] = get_highscore($connect,$row["user_id"]);
      $sub_array[] = average_score($connect,$row["user_id"]);
      $data[] = $sub_array;
    }
    sort($data);
    
    // store in output
    $output = array(
      "draw"            =>  intval($_POST["draw"]),
      "recordsTotal"    =>  get_total_records($connect, 'tbl_score'),
      "recordsFiltered" =>  $filtered_rows,
      "data"            =>  $data
    );

    // return output data in json format
    echo json_encode($output);
  }   
}
?>