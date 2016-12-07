<?php
session_start();
if(!isset($_SESSION['username'])) {
    exit('Please Login First');
}
$username = $_SESSION['username'];

// Connection parameters 
include 'connectdb.php';

$submissionid = $_REQUEST['submissionid'];
$query = "SELECT sourcefile from Submission WHERE submissionid = $submissionid";
$result = mysqli_query($dbcon, $query)
    or die('Query failed: '.mysqli_error($dbcon));
print "Source File<br>";
$tuple = mysqli_fetch_array($result);
print '<textarea rows="40" cols="150" name="text">'.$tuple['sourcefile'].'</textarea><br>';
print '<a href="javascript:history.back(-1);">Return</a>';
mysqli_free_result($result);

// Closing connection
mysqli_close($dbcon);
?>

