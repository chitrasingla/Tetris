<?php

//login.php

// connect database
include('../demotetris/database/database_connection.php');

session_start();

// login successful, then call index.php
if(isset($_SESSION["user_id"]))
{
    header('location:index.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
 
  <title>Tetris</title>
  <meta charset='UTF-8'>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/canvas.css">
  <link rel="stylesheet" href="css/header.css">
  <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>-->
  <link rel="stylesheet" href="css/bootstrap.css">
  <script src="js/jquery.min.js"> </script>
  <script src="js/bootstrap.min.js"></script>
</head>
<body>

<div class="jumbotron text-center" style="margin-bottom:0">
  <h1>Tetris</h1>
</div>

<div class="container">
  <div class="row">
    <div class="col-md-4">
    </div>

    <!-- Login page -->
    <div class="col-md-4" style="margin-top:20px;">
      <div class="card">

        <!-- heading -->
        <div class="card-header">User Login</div>
        
        <div class="card-body">
          <form method="post" id="user_login_form">
            
            <div class="form-group">
              
            <!-- username -->
              <label>Enter Username</label>
              <input type="text" name="user_emailid" id="user_emailid" class="form-control" />
              <span id="error_user_emailid" class="text-danger"></span>
            </div>
            
            <div class="form-group">
            
              <!-- password -->
              <label>Enter Password</label>
              <input type="password" name="user_password" id="user_password" class="form-control" />
              <span id="error_user_password" class="text-danger"></span>
            </div>
            
            <!-- submit -->
            <div class="form-group">
              <div class ="col" align ="right">
                <span  class="text-primary">New User?</span>
                <button type=button id="add_button" class="btn btn-info " >Sign Up</button>
                <input type="submit" name="user_login" id="user_login" class="btn btn-info" value="Login" />
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="col-md-4">

    </div>
  </div>
</div>

</body>
</html>


<div class="modal" id="formModal">
  <div class="modal-dialog">
    <form method="post" id="admin_form">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title" id="modal_title"></h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">

          <div class="form-group">
            <div class="row">
              <label class="col-md-4 text-right">Username <span class="text-danger">*</span></label>
              <div class="col-md-8">
                <input type="text" user_name="admin_user_name" id="admin_user_name" class="form-control" />
                <span id="error_admin_user_name" class="text-danger"></span>
              </div>
            </div>
          </div>
                
          <div class="form-group">
            <div class="row">
              <label class="col-md-4 text-right">Email id<span class="text-danger">*</span></label>
              <div class="col-md-8">
                <input type="text" user_name="admin_password" id="admin_password" class="form-control" />
                <span id="error_admin_password" class="text-danger"></span>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="row">
              <label class="col-md-4 text-right">Password<span class="text-danger">*</span></label>
              <div class="col-md-8">
                <input type="text" user_name="admin_password" id="admin_password" class="form-control" />
                <span id="error_admin_password" class="text-danger"></span>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="row">
              <label class="col-md-4 text-right">Password<span class="text-danger">*</span></label>
              <div class="col-md-8">
                <input type="text" user_name="admin_password" id="admin_password" class="form-control" />
                <span id="error_admin_password" class="text-danger"></span>
              </div>
            </div>
          </div>
                  
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
          <input type="hidden" user_name="admin_id" id="admin_id" />
          <input type="hidden" user_name="action" id="action" value="Add" />
          <input type="submit" user_name="button_action" id="button_action" class="btn btn-success btn-sm" value="Add" />
            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
        </div>

      </div>
  </form>
  </div>
</div>



<!-- js starts -->
<script>

$(document).ready(function(){
  
  // login page submit clicked
  $('#user_login_form').on('submit', function(event){
    
    event.preventDefault();
    $.ajax({
    
      // call check login file
      url:"check_user_login.php",
      method:"POST",
      data:$(this).serialize(),
      dataType:"json",

      // change submit to validate and then disable button
      beforeSend:function(){
        $('#user_login').val('Validate...');
        $('#user_login').attr('disabled','disabled');
      },

      // login check
      success:function(data)
      {

        // if success, call index.php
        if(data.success)
        {
          location.href="index.php";
        }

        // if error, enable button and display error
        if(data.error)
        {
          $('#user_login').val('Login');
          $('#user_login').attr('disabled', false);      // enable submit button

          // if email error not empty
          if(data.error_user_emailid != '')
          {
            $('#error_user_emailid').text(data.error_user_emailid);
          }
          else    
          {
            $('#error_user_emailid').text('');
          }

          // if password error not empty
          if(data.error_user_password != '')
          {
            $('#error_user_password').text(data.error_user_password);
          }
          else
          {
            $('#error_user_password').text('');
          }
        }
      }
    })
  });
});

// --------------------------------------------------------------------------------------------------------


// clicked on add button
  $('#add_button').click(function(){
    $('#modal_title').text('Add admin');
    $('#button_action').val('Add');
    $('#action').val('Add');
    $('#formModal').modal('show');
    clear_field();
  });

// submitted details for adding admin
  $('#admin_form').on('submit', function(event){
    event.preventDefault();

    $.ajax({
      url:"admin_action.php",
      method:"POST",
      data:$(this).serialize(),
      dataType:"json",

      // before sending request
      beforeSend:function(){
        $('#button_action').val('Validate...');
        $('#button_action').attr('disabled', 'disabled');
      },

      success:function(data)
      {
        $('#button_action').attr('disabled', false);
        $('#button_action').val($('#action').val());

        // data success
        if(data.success)
        {
          $('#message_operation').html('<div class="alert alert-success">'+data.success+'</div>');
          clear_field();
          $('#formModal').modal('hide');
          dataTable.ajax.reload();
        }

        // if error
        if(data.error)
        {

          // empty user_name
          if(data.error_admin_user_name != '')
          {
            $('#error_admin_user_name').text(data.error_admin_user_name);
          }
          else
          {
            $('#error_admin_user_name').text('');
          }
          
          // empty password
          if(data.error_admin_password != '')
          {
            $('#error_admin_password').text(data.error_admin_password);
          }
          else
          {
            $('#error_admin_password').text('');
          }
          
        }
      }
    })
  });

</script>
