<?php

$host = 'cspp53001.cs.uchicago.edu';
$username_db = 'yancui';
$password_db = 'aitheege';
$database = $username_db.'DB';

// Attempting to connect
$dbcon = mysqli_connect($host, $username_db, $password_db, $database)
   or die('Could not connect: ' . mysqli_connect_error());
?>
