<?php
session_start();
if(!isset($_SESSION['username'])) {
    exit('Please Login First');
}
$username = $_SESSION['username'];

include 'connectdb.php';

// Getting the input parameter (user):
$replyid = $_REQUEST['replyid'];

$query = "DELETE from Reply where replyid = $replyid;";

$result = mysqli_query($dbcon, $query);

if($result){
    print "<script>alert('Succeed!');</script>";
    print("<script>history.back();</script>"); 
} else {
    print "<script>alert('Faileds!');</script>";
    print("<script>history.back();</script>");
}
mysqli_close($dbcon);
?>
