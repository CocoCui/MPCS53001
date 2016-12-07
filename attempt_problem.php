<?php

// Connection parameters 
include 'connect.php';
// Getting the input parameter (user):
$user = $_REQUEST['user'];

// Get the attributes of the user with the given username
$query = "SELECT problemid, title, COUNT(*) from Submission NATURAL JOIN Problem WHERE problemid NOT IN (SELECT problemid from ProblemScore where userid = '$user') and userid = '$user' GROUP BY problemid;";
$result = mysqli_query($dbcon, $query)
  or die('Query failed: '.mysqli_error($dbcon));

print "<h2>Attempted Problems for $user</h2>";
print '<ul>';
print '<table border="1"><tr><th>ProblemID</th><th>Title</th><th>Attempts</th></tr>';
while ($tuple = mysqli_fetch_row($result)) {
    print "<tr><td>$tuple[0]</td><td>$tuple[1]</td><td>$tuple[2]</td></tr>";
}
print '</table>';
print '</ul>';
// Free result
mysqli_free_result($result);
// Closing connection
mysqli_close($dbcon);
?> 
