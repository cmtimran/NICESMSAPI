<?php
    $serverName = "192.168.163.129";
    $connectionInfo = array( "Database"=> "RSMS_API", "UID"=> "NICE", "PWD"=> 'niAll@h#r@sulce');
    $conn = sqlsrv_connect( $serverName, $connectionInfo);

    if( $conn ) {
        $connectmsg= "Connected.";
        echo "<script>toastr.info('Network Check!', 'Connection established.');</script>";
    }else{
        $connectmsg = "Connection could not be established.";
        echo "<script>toastr.info('Network Check!', 'Connection could not be established.');</script><br>";
        echo "<script>toastr.info('Network Check!', ". die(print_r(sqlsrv_errors(), true)).");</script><br>"; 
    } 
?>
