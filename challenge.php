<?php
session_start();
if(!isset($_SESSION['username'])) {
    exit('Please Login First');
}
$username = $_SESSION['username'];

// Connection parameters 
include 'connectdb.php';

$submission1 = $_REQUEST['submission1'];
$submission2 = $_REQUEST['submission2'];
$problemid = $_REQUEST['problemid'];
$query1 = "SELECT runtime from Submission WHERE submissionid = $submission1";
$query2 = "SELECT runtime from Submission WHERE submissionid = $submission2";
$score_query = "SELECT score from ProblemScore WHERE userid = '$username' and problemid = $problemid";

$result1 = mysqli_query($dbcon, $query1)
    or die('Query failed: '.mysqli_error($dbcon));
$result2 = mysqli_query($dbcon, $query2)
    or die('Query failed: '.mysqli_error($dbcon));
$tuple1 = mysqli_fetch_array($result1);
$tuple2 = mysqli_fetch_array($result2);

$score_res = mysqli_query($dbcon, $score_query)
    or die('Query failed: '.mysqli_error($dbcon));
$old_score = mysqli_fetch_array($score_res)['score'];

$insert = "insert Challenge (submission1, submission2, runtime1, runtime2) values($submission1, $submission2, $tuple1[0], $tuple2[0]);";
$insert_res = mysqli_query($dbcon, $insert);
if(!$insert_res) {
    exit('Error!You have already challenged this submission!<br><a href="javascript:history.back(-1);">Return</a>');
}

$score_res = mysqli_query($dbcon, $score_query)
    or die('Query failed: '.mysqli_error($dbcon));
$new_score = mysqli_fetch_array($score_res)['score'];



print "<h3>Challenge Result</h3>";
print "<li>Your runtime: $tuple1[0]";
print "<li>Your opponent's runtime: $tuple2[0]<br>";
print "<li>Your orginal score on problem $problemid: $old_score";
print "<li>Your new score on problem $problemid: $new_score<br>";
print '<a href="javascript:history.back(-1);">Return</a>';



// Closing connection
mysqli_close($dbcon);
?>
