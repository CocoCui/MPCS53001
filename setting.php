 
<head>Change Password</head>  
<form name="password" method="post" action="setting.php"> 
<p>  
    <label for="password" class="label">Old Password:</label>  
    <input name="password" type="password">  
<p/>
<p>  
<label for="password1" class="label">New Password(more than 5 letters):</label>  
    <input name="password1" type="password">  
<p/>
<p>  
    <label for="password2" class="label">Confirm Password:</label>  
    <input name="password2" type="password">  
<p/>
<p>  
    <input type="submit" name="submit" value="Change Password" class="left" />  
</p>  
</form> 


<?php
session_start();
if(!isset($_REQUEST['submit'])) {
    exit();
}
if(!isset($_SESSION['username'])) {
    exit('Please Login First');
}
$username = $_SESSION['username'];
$password = $_REQUEST['password'];
$password1 = $_REQUEST['password1'];
$password2 = $_REQUEST['password2'];
include 'connectdb.php';
$query = "SELECT password FROM User WHERE userid = '$username'";
$result = mysqli_query($dbcon, $query)
    or die('Query failed: ' . mysqli_error($dbcon));
$tuple = mysqli_fetch_array($result)
    or die("User $username not found!");
if($password != $tuple['password']) {
    print "<script>alert('Old password is wrong!');</script>";
} else {
    if($password1 == "" ||  $password2 == ""){
        print "<script>alert('No Empty Field');</script>";  
    } else {
        include 'connectdb.php';
        if($password1 != $password2){
            print "<script>alert('Password not match.');</script>";
        }
        else if(strlen($password1) < 6){
            print "<script>alert('Password too short.');</script>";
        }
        else {
            $query = "UPDATE User SET password = '$password1' WHERE userid = '$username'";
            
            $result = mysqli_query($dbcon, $query)
                or die('Query failed: ' . mysqli_error($dbcon));
            if($result) {  
                print 'Succeed. <a href=login.html>Login Page</a>';  
            } else {
                print 'Failed. <a href=login.html>Login Page</a>'; 
            }
        }
    }
}
?>
