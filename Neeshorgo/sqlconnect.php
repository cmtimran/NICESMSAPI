<?php
    $serverName = "36.255.68.238";
    $connectionInfo = array( "Database"=> "RSMS_API", "UID"=> "APINICRSMS", "PWD"=> '1@p!@$m$#!C23');
    $conn = sqlsrv_connect( $serverName, $connectionInfo);

    if( $conn ) {
        echo "Connection established.<br />";

    }else{
        echo "Connection could not be established.<br />";
        die( print_r( sqlsrv_errors(), true));
    } 
?>
