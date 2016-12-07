<?php
session_start();
if(!isset($_SESSION['username'])) {
    exit('Please Login First');
}
$username = $_SESSION['username'];

include 'connectdb.php';

// Getting the input parameter (user):
$problemid = $_REQUEST['problemid'];
if(!preg_match('/^[0-9]+$/', $problemid)){
    exit('Please enter a valid problemid!<a href="javascript:history.back(-1);">Return</a>');
}

// Get the attributes of the user with the given username
$query = "SELECT * FROM Problem WHERE problemid = $problemid";
$result = mysqli_query($dbcon, $query)
  or die('Query failed: ' . mysqli_error($dbcon));

// Can also check that there is only one tuple in the result
$tuple = mysqli_fetch_array($result)
  or die("Problem $problemid not found!");


// Printing user attributes in HTML
print "<h2> {$tuple['title']} </h2>";
print '<li>ID: '.$tuple['problemid'];
print '<li>Score: '.$tuple['score'];
print "<li>Description: <br>{$tuple['description']}<br><br></body>";
print '<li><em>Sample Input: </em><br>';
print "<code>{$tuple['sampleinput']}</code><br><br>";
print '<li><em>Sample Output: </em><br>';
print "<code>{$tuple['sampleoutput']}</code><br><br>";
print '</ul>';

print '<form method=post action="discuss.php">';
print "<input type='hidden' name='problemid' value = '{$tuple['problemid']}'>";
print '<input type="submit" value="Show Discussions on this problem"></form>';

print '<hr><h3>Create a Discussion</h3><form method=get action="create_discuss.php">';
print "<input type='hidden' name='problemid' value={$tuple['problemid']}>";
print "<input type='hidden' name='userid' value={$username}>";
print '<b>Title:</b><input type="text" name="title"><br>';
print '<textarea rows="5" cols="50" name="text">Please type the content here.</textarea><br>';
print '<input type="submit" value="Submit"></form>';


print '<hr><h3>Submit Solution</h3><form method=get action="submit.php">';
print '<b>Language:</b><select name="language"><option>C++</option></select><br>';
print "<input type='hidden' name='problemid' value={$tuple['problemid']}>";
print "<input type='hidden' name='userid' value={$tuple['problemid']}>";
print '<textarea rows="25" cols="150" name="source">Code Area.</textarea><br>';
print '<input type="submit" value="Submit"></form>';
// Free result
mysqli_free_result($result);

// Closing connection
mysqli_close($dbcon);
?> 

