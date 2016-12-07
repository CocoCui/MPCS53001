<?php

include 'connectdb.php';
// Getting the input parameter (user):
$order = $_REQUEST['order'];
if($order == 'Increasing') {
    $query = "SELECT userid, SUM(score) as totalscore FROM ProblemScore GROUP BY userid ORDER BY totalscore";
} else  {
    $query = "SELECT userid, SUM(score) as totalscore FROM ProblemScore GROUP BY userid ORDER BY totalscore DESC";
}

$result = mysqli_query($dbcon, $query)
  or die('Query failed: ' . mysqli_error($dbcon));

print "Total score for users:<br>";

// Printing user attributes in HTML
print '<ul>';
print '<table border="1"><tr><th>Userid</th><th>Total Score</th></tr>';
while ($tuple = mysqli_fetch_row($result)) {
    print "<tr><td>$tuple[0]</td><td>$tuple[1]</td></tr>";
}
print '</table>';
print '</ul>';

// Free result
mysqli_free_result($result);

// Closing connection
mysqli_close($dbcon);
?> 


