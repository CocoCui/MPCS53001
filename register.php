<?php
if (!isset($_REQUEST['submit'])) {
    exit('Please Login First');
}
$username = $_REQUEST['username'];
$password1 = $_REQUEST['password1'];
$password2 = $_REQUEST['password2'];
$email = $_REQUEST['email'];
if($username == "" || $password1 == "" ||  $password2 == "" || $email == ""){
    print "<script>alert('No Empty Field');</script>";
    print "<script>history.back();</script>";  
} else {
    include 'connectdb.php';
    if(!preg_match('/^[a-zA-Z0-9]{3,15}$/', $username)){
        exit('Invaild Username, only letters and numbers are allowed  and the length should be within [5,15] <a href="javascript:history.back(-1);">Return</a>');
    }
    if($password1 != $password2){
        exit('Password not match. <a href="javascript:history.back(-1);">Return</a>');
    }
    if(strlen($password1) < 6){
        exit('Password is too short. <a href="javascript:history.back(-1);">Return</a>');
    }
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        exit('Invalid Email address. <a href="javascript:history.back(-1);">Retrun</a>');
    }
    $query = "SELECT userid FROM User WHERE userid = '$username'";
    
    $result = mysqli_query($dbcon, $query)
        or die('Query failed: ' . mysqli_error($dbcon));
    if(mysqli_num_rows($result)) {  
        exit("<script>alert('Username already exists.'); history.go(-1);</script>");
    }  
    $insert = "INSERT User VALUES('$username', '$password1', '$email', '2000-01-01 00:00:00');";
    $res_insert = mysqli_query($dbcon, $insert) 
        or die('Insert failed: ' . mysqli_error($dbcon));
    if($res_insert) {  
        print 'Registion Successful. <a href=login.html>Login Page</a>';  
    } else {
        print 'Registion Failed. <a href=login.html>Login Page</a>'; 
    }
    /*if($password == $tuple['password']) {
        session_start();
        $_SESSION['username'] = $username;
        print "<script>alert('Welcome!');</script>";
        header('Location: enter.html');
    } else {
        print "<script>alert('Invalid Username or Password!');</script>";
        print "<script>history.back();</script>";
    }*/
}
?>
