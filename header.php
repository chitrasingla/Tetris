<?php

//header.php

include('../demotetris/database/database_connection.php');
session_start();

// call login.php if not logined

if(!isset($_SESSION["user_id"]))
{
  header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang='en'>
 
<head>
  <meta charset='UTF-8'>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/themes.css">
  <link rel="stylesheet" href="css/header.css">
  <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>-->
  <link rel="stylesheet" href="css/bootstrap.css">
  <link rel="stylesheet" href="css/dataTables.bootstrap4.min.css">
  <script src="js/jquery.min.js"> </script>
  <!--<script src="js/popper.min.js"></script>-->
  <script src="js/jquery.dataTables.min.js"></script>
  <script src="js/bootstrap.js"></script>
  <script src="js/dataTables.bootstrap4.js"></script>

</head>
 
<body class="dark-theme || light-theme">
  <!--nav bar-->
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="index.php"><strong>Tetris</strong></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav">

        <li class="nav-item active">
          <a class="nav-link" href="profile.php">Profile <span class="sr-only">(current)</span></a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="leaderboard.php">LeaderBoard</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="help.php">Help</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="logout.php">Logout</a>
        </li>

         <!-- Rounded switch -->
         <li class="nav-item">
          <label class="switch">
            <input type="checkbox" id="togBtn" checked="true">
            <div class="slider round">
              <span class="on">DARK MODE</span>
              <span class="off">LIGHT MODE</span>
            </div>
          </label>
        </li>

      </ul>
    </div>
  </nav>
  