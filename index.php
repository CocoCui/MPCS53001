<?php

session_start();

if(!isset($_SESSION['username'])) {
    exit('Please Login First');
}
$username = $_SESSION['username'];
print "<body><h1>Online Judege Web Interface</h1></body>";
print "<h3>Welcome $username</h3>";
print "This button is linked to a page that lists the acrate, total score and all the submissions for the current user<br>";
print '<form method=get action="stastic_user.php">';
print "<input type='hidden' name='user' value=$username>";
print '<input type="submit" value="My Infomation">';
print '</form>';
print "This button is linked to a page that allow the user to change their password.(1 update)<br>";
print '<form method=get action="setting.php">';
print "<input type='hidden' name='user' value=$username>";
print '<input type="submit" value="Change Password">';
print '</form>';
?>

<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML//EN">
<html> <head>
<title>Online Judege Web Interface</title>
</head>

<hr>
List all the problems at the given difficulty level.
<p>
<form method=get action="list_problem.php">
<b>CHOOSE DIFFICULTY:</b><br>
<select name="difficulty">
<option>Easy</option>
<option>Medium</option>
<option>Hard</option>
</select>
<input type="submit" value="Submit">
</form>


<hr>
A page List the information of a problem given a problemid.
<br>
<li>In this page, you can also submit the C++ solution through the text area, the system will compile and test the code on seveal testcase of a problem, if your solution passes all the test, then it will got an "Accept". If you solved a problem for the first time, you can get the score from the problem automaticly.
<br>
<li>If you have some difficulty solving the problem, you can also create a discussion on the problem.
<li>1 insert into Submission, 1 insert into Discussion, 1 insert into ProblemScore when solve the problem for the first time
<p>
<form method=get action="show_problem.php">
<b>Enter problemid(1~20):</b><br>
<input type="text" name="problemid"><BR>
<input type="submit" value="Submit">
</form>

<hr>
List the scores for all the users and sort the score. 
<p>
<form method=get action="list_scores.php">
<b>Sort Perference:</b><br>
<select name="order">
<option>Increasing</option>
<option>Decreasing</option>
</select>
<input type="submit" value="Submit">
</form>

<hr>
List the accept rate for each problem
<p>
<form method=get action="acrate_problem.php">
<input type="submit" value="Go">
</form>
</body>
</html>

<hr>
List all the submissions for a given problem and set the best submission.
<li>If you solved a problem, then you can set a submission which got an "Accept" as the best submission on this problem, then you can use this submission to challenge others' best submission, if your code is faster, then you can win half of the score on that problem from whom you challenged to and you'll lose the score if your code is slower.
<li>1 insert into Challenge and 1 update the score in ProblemScore
<p>
<form method=get action="set_best_submission.php">
<b>Enter Problem ID(1~20):</b><br>
<input type="text" name="problemid"><BR>
<input type="submit" value="Submit">
</form>

<hr>
List all the best submission which can be challenged for a given problem.
<li>Try to challenge the submissions and win scores from others.
<li>1 modify the bestsubmission in the ProblemScore
<p>
<form method=get action="challenge_candiate.php">
<b>Enter Problem ID(1~20):</b><br>
<input type="text" name="problem"><BR>
<input type="submit" value="Submit">
</form>



<hr>
List all the discusses and the related replies on a given problem.
<li>In this page, you can create or delete your own rely and discussions.
<li>1 insert into reply, 1 delete on reply
<p>
<form method=get action="discuss.php">
<b>Enter Problem ID(1~20):</b><br>
<input type="text" name="problemid"><BR>
<input type="submit" value="Submit">
</form>

