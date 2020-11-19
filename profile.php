<?php

  //profile.php

  include('header.php')

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


    <div class="card-header"><b>Profile</b>
    </div>
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
          <tr>
            <th>Rank</th>
            <td><?php echo get_rank($connect, $_SESSION["user_id"]); ?></td>
          </tr>
          <tr>
            <th>Average Score</th>
            <td><?php echo average_score($connect, $_SESSION["user_id"]); ?></td>
          </tr>
        </table>
     </div>
    </div>


    <div class="card-header"><b>Recent Scores</b>
    </div>
    <div class="card-body">
  		<div class="table-responsive">
        <span id="message_operation"></span>
        <table class="table table-striped table-bordered" id="score_table">
          <thead>
            <tr>
              <th>Date</th>
              <th>Score</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
  		</div>
  	</div>


  </div>
</div>

</body>
</html> 

<script>
$(document).ready(function(){
	
  // call profile_action.php to retrieve data
  var dataTable = $('#score_table').DataTable({
    
    "processing":true,
    "serverSide":true,
    "order":[],

    "ajax":{
      url:"profile_action.php",
      method:"POST",
      data:
      {
        action:"fetch"
      },
    }
  });

});
</script>