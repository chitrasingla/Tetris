<?php

//profile.php

include('header.php');


$output = "";


// retrieve  data of that user
$query = "
SELECT * FROM tbl_score 
WHERE user_id = '".$_SESSION["user_id"]."'
";
$statement = $connect->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
$total_row = $statement->rowCount();

foreach($result as $row)
{
	$output .= '
		<tr>
			<td>'.$row["score_date"].'</td>
			<td>'.$row["score_value"].'</td>
		</tr>
	';
}

?>
<!--link css file for dark theme card-->
<link rel="stylesheet" href="css/card.css">
<!--js for toggle related work-->
	<script>
	    var checkbox = document.querySelector("input[id=togBtn]");
	    checkbox.addEventListener( 'change', function() {
	        document.body.classList.toggle("dark-theme"); 
	        document.getElementById("card").classList.toggle("dark-card");  
	    });
  	</script>
<div class="container" style="margin-top:30px">
  <div class="card || dark-card" id="card">
  	<div class="card-header"><b>Profile</b></div>
  	<div class="card-body">
      <div class="table-responsive">
        
        <table class="table table-bordered table-striped">
          <tr>
            <th>User Name</th>
            <td><?php echo get_user_name($connect, $_SESSION["user_id"]); ?></td>
          </tr>
          <tr>
            <th>Email Address</th>
            <td><?php echo get_user_email($connect, $_SESSION["user_id"]); ?></td>
          </tr>
          <tr>
            <th>Date of Joining</th>
            <td><?php echo get_user_doj($connect, $_SESSION["user_id"]); ?></td>
          </tr>
        </table>


        <div class="table-responsive">
        	<table class="table table-striped table-bordered">
	          <tr>
	            <th>Date</th>
	            <th>Score</th>
	          </tr>
	          <?php echo $output; ?>
	      </table>
        </div>
  		
      </div>
  	</div>
  </div>
</div>

</body>
</html>

