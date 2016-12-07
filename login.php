<?php
if (!isset($_REQUEST['submit'])) {
    exit('Please Login First');
}
$username = $_REQUEST['username'];
$password = $_REQUEST['password'];
if($username == "" || $password == ""){
    print "<script>alert('Username/Password is empty!');</script>";
    print "<script>history.back();</script>";  
} else {
    include 'connectdb.php';
    $query = "SELECT password FROM User WHERE userid = '$username'";
    $result = mysqli_query($dbcon, $query)
        or die('Query failed: ' . mysqli_error($dbcon));
    $tuple = mysqli_fetch_array($result)
        or die("User $username not found!");

    if($password == $tuple['password']) {
        session_start();
        $_SESSION['username'] = $username;
        print "<script>alert('Welcome!');</script>";
        header('Location: index.php');
    } else {
        print "<script>alert('Invalid Username or Password!');</script>";
        print "<script>history.back();</script>";
    }
}
?>
