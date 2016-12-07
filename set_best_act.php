<?php
session_start();
if(!isset($_SESSION['username'])) {
    exit('Please Login First');
}
$username = $_SESSION['username'];
$problemid = $_REQUEST['problemid'];
$submissionid = $_REQUEST['submissionid'];
// Connection parameters 
include 'connectdb.php';

// Getting the input parameter (user):
// Get the attributes of the user with the given username
$query = "UPDATE ProblemScore SET bestsubmission = $submissionid WHERE userid = '$username' and problemid = $problemid";

$res_insert = mysqli_query($dbcon, $query) 
        or die('Update failed: ' . mysqli_error($dbcon));
if($res_insert) {  
    print 'Success';  
} else {
    print 'Failed';
}
print '<br><a href="javascript:history.back(-1);">Return</a>';
// Free result

// Closing connection
mysqli_close($dbcon);
?> 

