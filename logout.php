<?php

//logout.php

session_start();

session_destroy();

// after logout call login.php

header('location:login.php');

?>