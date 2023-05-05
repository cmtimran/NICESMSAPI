<?php
    $serverName = "192.168.163.129";
    $connectionInfo = array( "Database"=> "RSMS_API", "UID"=> "NICE", "PWD"=> 'niAll@h#r@sulce');
    $conn = sqlsrv_connect( $serverName, $connectionInfo);

    if( $conn ) {
        $connectmsg= "Connected";
        echo "<script>toastr.info('Network Check!', 'Connection established.');</script>";
    }else{
        $connectmsg = "Offline";
        // echo "<script>toastr.info('Network Check!', 'Connection could not be established.');</script><br>";
        echo "<script>toastr.info('Network Check!', 'Offline');</script><br>"; 
    } 
?>
