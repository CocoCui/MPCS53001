<?php
session_start();
if(!isset($_SESSION['username'])) {
    exit('Please Login First');
}
$username = $_SESSION['username'];

include 'connectdb.php';

// Getting the input parameter (user):
$problemid = $_REQUEST['problemid'];

// Get the attributes of the user with the given username
$query = "SELECT title, userid, time, text, discussionid FROM Discussion WHERE problemid = '$problemid'";
$result = mysqli_query($dbcon, $query)
  or die('Query failed: ' . mysqli_error($dbcon));
if(mysqli_num_rows($result) == 0) {
    print "There are no discussions on problem $problemid!<br>";
    exit('<a href="javascript:history.back(-1);">Return</a>');
}
// Printing user attributes in HTML
print "<h2>Discussions on Problem $problemid</h2>";
print '<ul>';
while ($tuple = mysqli_fetch_row($result)) {
    print "<hr>";
    print "<li><strong>$tuple[0]</strong><br><hr>";
    print "<em>creator: $tuple[1] time: $tuple[2]</em><br>";
    print "$tuple[3]";
    print "<hr>";
    $query2 = "SELECT userid, time, text, replyid FROM Reply WHERE replyto = '$tuple[4]'";
    $result2 = mysqli_query($dbcon, $query2) or die('Query failed: ' . mysqli_error($dbcon));
    while ($tuple2 = mysqli_fetch_row($result2)) {
        print "<strong>Reply: </strong><em>creator: $tuple2[0] time: $tuple2[1]";
        print "</em><br>$tuple2[2]<br>";
        if($tuple2[0] == $username) {
            print '<form method=post action="delete_reply.php">';
            print "<input type='hidden' name='replyid' value=$tuple2[3]>";
            print '<input type="submit" value="Delete"></form>';
        }
        
    }
    print '<form method=post action="reply.php">';
    print "<input type='hidden' name='userid' value=$username>";
    print "<input type='hidden' name='replyto' value=$tuple[4]>";
    print '<textarea rows="4" cols="50" name="text">Reply...</textarea><br>';
    print '<input type="submit" value="Reply">';
    print '</form>';
}
print '</table>';
print '</ul>';

// Free result
mysqli_free_result($result);

// Closing connection
mysqli_close($dbcon);
?> 


