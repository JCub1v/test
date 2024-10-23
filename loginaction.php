<?php
 require 'connection.html';


 function loginf() {
    $data= array();
    $data[1]= $_REQUEST['username'];
    $data[2]= $_REQUEST['pw'];
    $data[3]= $_REQUEST['fullname'];

    return $data;
 }
    if (isset($_POST['logbtn'])) {
        $log= loginf();
        $user = "SELECT * FROM users where username ='$log[1]' and pw ='$log[2]'";
        // $result = sqlsrv_query($conn,$user);
        header("Location:index.html");
    }else {
            echo "<script>alert('Username or Password not FOUND. ')</script>";
            $url = $_SERVER['HTTP_REFERER']; // right back to the referrer page from where you came.
                echo '<meta http-equiv="refresh" content="0.5 ;URL=' . $url . '">'; //go back login page in 0.5s after click OK
    }
