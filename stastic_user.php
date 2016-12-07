<?php
session_start();
if(!isset($_SESSION['username'])) {
    exit('Please Login First');
}

include 'connectdb.php';

// Getting the input parameter (user):
$user = $_REQUEST['user'];
print "<h2>$user:</h2>";
print "<br><strong>Accept Rate of $user: </strong>";
$query = "Select SUM(result = 'Accept')/COUNT(*), SUM(result = 'Accept'), COUNT(*) FROM Submission where userid = '$user' GROUP BY userid";
$result = mysqli_query($dbcon, $query)
    or die('Query failed: ' . mysqli_error($dbcon));
$tuple = mysqli_fetch_array($result);
if($tuple != NULL) {
    print "$tuple[0] ($tuple[1]/$tuple[2])";
} else {
    print "0";
}
// Free result
mysqli_free_result($result);


print "<br><strong>Total score of $user: </strong>";
$query = "Select SUM(score) FROM ProblemScore where userid = '$user' GROUP BY userid";
$result = mysqli_query($dbcon, $query)
    or die('Query failed: ' . mysqli_error($dbcon));
$tuple = mysqli_fetch_array($result);
if($tuple != NULL) {
    print "$tuple[0]";
} else {
    print "0";
}

// Get the attributes of the user with the given username
$query = "Select submissionid, problemid, title,  result, runtime, memory FROM Submission NATURAL JOIN Problem WHERE userid = '$user'";
$result = mysqli_query($dbcon, $query)
  or die('Query failed: ' . mysqli_error($dbcon));

// Can also check that there is only one tuple in the result

print "<br><strong>Submissions of $user:</strong><br>";

// Printing user attributes in HTML
print '<table border="1"><tr><th>Submission</th><th>Problem</th><th>Title</th><th>Result</th><th>Runtime</th><th>Memory</th>';
while ($tuple = mysqli_fetch_row($result)) {
    print "<tr><td>$tuple[0]</td><td>$tuple[1]</td><td>$tuple[2]</td><td>$tuple[3]</td><td>$tuple[4]</td><td>$tuple[5]</td></tr>";
}
print '</table>';


// Free result
mysqli_free_result($result);
// Closing connection
mysqli_close($dbcon);
?> 
