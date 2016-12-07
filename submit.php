<?php
session_start();
if(!isset($_SESSION['username'])) {
    exit('Please Login First');
}
$username = $_SESSION['username'];
$problemid = $_REQUEST['problemid'];
$source = $_REQUEST['source'];
$language = $_REQUEST['language'];

if($problemid == "" || $username == "" || $language == "" || $source ==""){
    print "<script>alert('The source code can't be empty!');</script>";
    print $username;
    print $problemid;
    print $source;
    print $language;
} else {
    include 'connectdb.php';
    $insert = "INSERT Submission (userid, problemid, language, result, memory, runtime, sourcefile) VALUES('$username', $problemid, '$language', 'Pending', 0, 0, '$source');";
    $query_id = 'SELECT LAST_INSERT_ID()';  
    $res_insert = mysqli_query($dbcon, $insert) 
        or die('Insert failed: ' . mysqli_error($dbcon));
    $res_id = mysqli_query($dbcon, $query_id) 
        or die('Get SubmissionID failed:' . mysqli_error($dbcon));
    $submissionid = mysqli_fetch_row($res_id)[0];
    if (!is_dir("./judge/$submissionid")) mkdir("./judge/$submissionid");
    $sourcefile = fopen("./judge/$submissionid/$submissionid.cpp", "w");
    fwrite($sourcefile, $source);
    fclose($sourcefile);
    $testcase_query = "SELECT testcaseid, inputdata, outputdata FROM TestCase WHERE problemid = $problemid";
    $testcase_result = mysqli_query($dbcon, $testcase_query);
    $number_of_testcase = 0;
    while ($tuple = mysqli_fetch_row($testcase_result)){
        $number_of_testcase = $tuple[0] + 1;
        $testinput = fopen("./judge/$submissionid/$tuple[0].in", "w");
        $testoutput = fopen("./judge/$submissionid/$tuple[0].out", "w");
        fwrite($testinput, $tuple[1]);
        fwrite($testoutput, $tuple[2]);
        fclose($testinput);
        fclose($testoutput);
    }
    print "Submission on problem $problemid<br>";
    print "Number of testcases:$number_of_testcase<br>";
    print "Submission ID: $submissionid<br>";
    $command = "cd judge; ./judge $submissionid $number_of_testcase >  $submissionid/result.txt";
    $return = passthru($command);
    print "TestResult:<br>";
    $res = file("./judge/$submissionid/result.txt");
    $result = rtrim($res[0]);
    $runtime= rtrim($res[1]);
    $update_query = "UPDATE Submission set result = '$result', runtime = $runtime WHERE Submissionid = $submissionid";
    mysqli_query($dbcon, $update_query) or die('Update submission failed:' . mysqli_error($dbcon));
    print "<li>Result:$result<br>";
    print "<li>Runtime:$runtime<br>";
    print '<a href="index.php">Return Home</a>';

}
?>
