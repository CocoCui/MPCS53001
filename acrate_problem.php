<?php

// Connection parameters 
include 'connectdb.php';

// Getting the input parameter (user):

// Get the attributes of the user with the given username
$query = "SELECT problemid, title, SUM(result = 'Accept'), COUNT(*), SUM(result = 'Accept')/COUNT(*) FROM Submission NATURAL JOIN Problem GROUP BY problemid";
$result = mysqli_query($dbcon, $query)
  or die('Query failed: ' . mysqli_error($dbcon));

// Printing user attributes in HTML
print "<h2>Accept Rate for All Problems:</h2><br>";
print '<ul>';
print '<table border="1"><tr><th>ProblemID</th><th>Problem Title</th><th>Accepted Submission</th><th>Total Submission</th><th>ACRate</th></tr>';
while ($tuple = mysqli_fetch_row($result)) {
    print "<tr><td>$tuple[0]</td><td>$tuple[1]</td><td>$tuple[2]</td><td>$tuple[3]</td><td>$tuple[4]</td></tr>";
}
print '</table>';
print '</ul>';

// Free result
mysqli_free_result($result);

// Closing connection
mysqli_close($dbcon);
?> 

