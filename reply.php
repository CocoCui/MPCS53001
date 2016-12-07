<?php
session_start();
if(!isset($_SESSION['username'])) {
    exit('Please Login First');
}
$userid = $_REQUEST['userid'];
$replyto = $_REQUEST['replyto'];
$text = $_REQUEST['text'];

if($text == "" || $userid == "" || $text == ""){
    print "<script>alert('The reply can't be empty!');</script>";
    print("<script>history.back();</script>");  
} else {
    include 'connectdb.php';
    $insert = "INSERT Reply(replyto, userid, text) values($replyto, '$userid', '$text');";
    $res_insert = mysqli_query($dbcon, $insert) 
        or die('Insert failed: ' . mysqli_error($dbcon));
    if($res_insert) {
        print "<script>alert('Succeed!');</script>";
        print("<script>history.back();</script>");    
    } else {
        print "<script>alert('Failed!');</script>";
        print("<script>history.back();</script>");  
    }
}
?>
