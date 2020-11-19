<?php

//attendance.php

include('header.php');

?>
<!--js for toggle related work-->
	<script>
	    var checkbox = document.querySelector("input[id=togBtn]");
	    checkbox.addEventListener( 'change', function() {
	        document.body.classList.toggle("dark-theme");  
          document.getElementById("card").classList.toggle("dark-card"); 
	    });
  	</script>
<!--link css file for dark theme card-->
<link rel="stylesheet" href="css/card.css">
<div class="container" style="margin-top:30px">
  <div class="card || dark-card" id="card">

      <div class="card-header">
        <div class="row">
          <div class="col-md-9">Leaderboard</div>
        </div>
      </div>
  
      <div class="card-body">
    		<div class="table-responsive">
          <span id="message_operation"></span>
    
          <table class="table table-striped table-bordered" id="user_table">
            <thead>
              <tr>
                <th>Rank</th>
                <th>User Name</th>
                <th>High Score</th>
                <th>Average Score</th>
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
//check whether DOM is ready to run javascript code
$(document).ready(function(){
	
  // call leaderboard_action.php to retrieve data
  //$ means it is a jquery function
  //datatable= jquery object containing data with the id usertable
  var dataTable = $('#user_table').DataTable({
    
    "processing":true,
    "serverSide":true,
    "order":[],

    "ajax":{
      url:"leaderboard_action.php",
      method:"POST",
      data:
      {
        action:"fetch"
      },
    }

  });
});
</script>