<?php
    $serverName = "36.255.68.238";
    // $serverName = "192.168.244.128";
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
