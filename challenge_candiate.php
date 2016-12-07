<?php
session_start();
if(!isset($_SESSION['username'])) {
    exit('Please Login First');
}
$username = $_SESSION['username'];

// Connection parameters 
include 'connectdb.php';

// Getting the input parameter (user):
$problemid = $_REQUEST['problem'];

// Get the attributes of the user with the given username
$query = "SELECT submissionid, Submission.userid FROM Submission JOIN ProblemScore ON submissionid = bestsubmission WHERE Submission.problemid = $problemid and Submission.userid != '$username'";
$result = mysqli_query($dbcon, $query)
    or die('Query failed: '.mysqli_error($dbcon));

$query2 = "SELECT bestsubmission FROM ProblemScore where userid = '$username' and problemid = $problemid;";
$result2 = mysqli_query($dbcon, $query2)
    or die('Query failed: '.mysqli_error($dbcon));
$curbest = mysqli_fetch_row($result2);

print "<h2>Best Submissions for Problem $problemid</h2>";
print "<li>The following submissions are best submissions, you can view the source code of them to decide whether to challenge or not. If your code win, you will get score, otherwise you will lose the score.";
print "<li>You can challenge a best submission only once.";
print '<ul>';
if(mysqli_num_rows($result) == 0) {
    print "Sorry! There are no best Submissions you can challenge!<br>";
    exit('<a href="javascript:history.back(-1);">Return</a>');
}
if(mysqli_num_rows($result2) == 0) {
    print "Sorry! You haven't solved that problem so that you can not challenge others!<br>";
    exit('<a href="javascript:history.back(-1);">Return</a>');
}
print "Current Best Submission: $curbest[0]<br><br>";
print '<table border="1"><tr><th>Best Submission ID</th><th>User ID</th><th>Code</th><th>Choice</th></tr>';
while ($tuple = mysqli_fetch_row($result)) {
    print "<tr><td>$tuple[0]</td><td>$tuple[1]</td>";
    print '<td><form method=post action="viewcode.php">';
    print "<input type='hidden' name='submissionid' value=$tuple[0]>";
    print "<input type='submit' value='View Code'></form></td>";
    print '<td><form method=post action="challenge.php">';
    print "<input type='hidden' name='submission1' value=$curbest[0]>";
    print "<input type='hidden' name='submission2' value=$tuple[0]>";
    print "<input type='hidden' name='problemid' value=$problemid>";
    print "<input type='submit' value='Challenge'></form></td>";
}
print '</table>';
print '</ul>';
// Free result
mysqli_free_result($result);
// Closing connection
mysqli_close($dbcon);
?> 
