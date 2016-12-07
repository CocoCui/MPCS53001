<?php
session_start();
if(!isset($_SESSION['username'])) {
    exit('Please Login First');
}
$username = $_SESSION['username'];

// Connection parameters 
include 'connectdb.php';

// Getting the input parameter (user):
$problemid = $_REQUEST['problemid'];
if(!preg_match('/^[0-9]+$/', $problemid)){
    exit('Please enter a valid problemid!<a href="javascript:history.back(-1);">Return</a>');
}
// Get the attributes of the user with the given username
$query = "SELECT submissionid, runtime FROM Submission where userid = '$username' and result = 'Accept' and problemid = $problemid";

$result = mysqli_query($dbcon, $query)
  or die('Query failed: '.mysqli_error($dbcon));

print "<h2>Submissions for Problem $problemid</h2>";

if(mysqli_num_rows($result) == 0) {
    exit("You have no accepted submissions on problem $problemid!<br><a href='javascript:history.back(-1);'>Return</a>");
}

$query2 = "SELECT bestsubmission FROM ProblemScore where userid = '$username' and problemid = $problemid;";
$result2 = mysqli_query($dbcon, $query2)
    or die('Query failed: '.mysqli_error($dbcon));
$curbest = mysqli_fetch_row($result2);
print "Current Best Submission: $curbest[0]<br>";
print '<ul>';
print '<table border="1"><tr><th>Submission ID</th><th>Runtime</th><th>Choice</th></tr>';
while ($tuple = mysqli_fetch_row($result)) {
    print "<tr><td>$tuple[0]</td><td>$tuple[1]</td>";
    print '<td><form method=post action="set_best_act.php">';
    print "<input type='hidden' name='userid' value=$username>";
    print "<input type='hidden' name='problemid' value=$problemid>";
    print "<input type='hidden' name='submissionid' value=$tuple[0]>";
    print '<input type="submit" value="Set as best submission"></form></td></tr>';
}
print '</table>';
print '</ul>';
// Free result
mysqli_free_result($result);
mysqli_free_result($result2);
// Closing connection
mysqli_close($dbcon);
?> 
