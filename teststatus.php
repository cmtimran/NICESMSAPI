<?php

    $fldPhnNumber = '01618867673';  
    $msg = "Test";
    $newmsg = urlencode($msg);
    $url = "https://api.mobireach.com.bd/SendTextMessage?Username=aghl&Password=Dhaka@5599&From=8801766665163&To=".$fldPhnNumber."&Message=".$newmsg;
    
    $contents = file_get_contents($url);
 
    $fullstring = $contents;

    function get_string_between($string, $start, $end){
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }
    
    $MessageId = get_string_between($fullstring, '<MessageId>', '</MessageId>');
    $Status = get_string_between($fullstring, '<Status>', '</Status>');
    $StatusText = get_string_between($fullstring, '<StatusText>', '</StatusText>');
    $ErrorCode = get_string_between($fullstring, '<ErrorCode>', '</ErrorCode>');
    $SMSCount = get_string_between($fullstring, '<SMSCount>', '</SMSCount>');
    $CurrentCredit = get_string_between($fullstring, '<CurrentCredit>', '</CurrentCredit>');

    echo '<br>MessageId :  '. $MessageId . '<br>';
    echo 'Status : ' . $Status. '<br>'; 
    echo 'Status Text : ' . strtoupper($StatusText). '<br>'; 
    echo 'Error Code : ' . $ErrorCode. '<br>'; 
    echo 'SMS Count : ' . $SMSCount. '<br>'; 
    echo 'CurrentCredit: ' . $CurrentCredit. '<br>'; 
    
    // if ($contents !== false) {
    //     // echo $url;
    //     echo "SMS has been send successfully to " . $fldPhnNumber . "<br>";
    //     echo 'Status Code: ' . $Status;
    //     // echo "MessageId   :  " . $_GET['MessageId'] . "<br>";
    //     // echo "Status Text : " . $_GET['StatusText'] . "<br>";
    // } 

    
?>