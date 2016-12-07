<?php

include 'connectdb.php';

mysqli_select_db($dbcon, $database)
   or die('Could not select database');
print 'Selected database successfully!<br>';

// Getting the input parameter (user):
$difficulty = $_REQUEST['difficulty'];

$query = "SELECT problemid, title, difficulty FROM Problem WHERE difficulty = '$difficulty'";
$result = mysqli_query($dbcon, $query)
  or die('Query failed: ' . mysqli_error($dbcon));

print "The following problems are $difficulty:";

// Printing user attributes in HTML
print '<ul>';
while ($tuple = mysqli_fetch_row($result)) {
    print '<li>Problem ID: '.$tuple[0];
    print '<li>Title :'.$tuple[1];
    print '<li>Difficulty :'.$tuple[2];
    print '<hr>';
}
print '</ul>';

// Free result
mysqli_free_result($result);

// Closing connection
mysqli_close($dbcon);
?> 

