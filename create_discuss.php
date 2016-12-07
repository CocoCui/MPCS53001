<?php
session_start();
if(!isset($_SESSION['username'])) {
    exit('Please Login First');
}
$userid = $_REQUEST['userid'];
$problemid = $_REQUEST['problemid'];
$title = $_REQUEST['title'];
$text = $_REQUEST['text'];

if($problemid == "" || $userid == "" || $text == "" || $title ==""){
    print "<script>alert('The content/title can't be empty!');</script>";
    print("<script>history.back();</script>");  
} else {
    include 'connectdb.php';
    $insert = "INSERT Discussion (problemid, userid, title, text) VALUES($problemid, '$userid', '$title', '$text');";
    $res_insert = mysqli_query($dbcon, $insert) 
        or die('Insert failed: ' . mysqli_error($dbcon));
    if($res_insert) {
        print "<script>alert('Success!');</script>";
        print("<script>history.back(-1);</script>");    
    } else {
        print "<script>alert('Failed!');</script>";
        print("<script>history.back(-1);</script>");  
    }
}
?>
