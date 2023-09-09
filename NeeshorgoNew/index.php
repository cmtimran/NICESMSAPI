<?php

use Vtiful\Kernel\Format;

require 'sqlconnect.php';
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SMS API</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.2.0/mdb.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" type="text/css" />

    <!-- Datatable Plugins css -->
    <link rel="stylesheet" type="text/css" href="./assets/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" type="text/css" href="./assets/css/buttons.dataTables.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/fixedcolumns/4.2.1/css/fixedColumns.dataTables.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.4.0/css/responsive.dataTables.min.css" />

    <!-- MDB -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.2.0/mdb.min.js"></script>

    <!-- Datatable Plugins JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.3/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.colVis.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <!-- App css -->
    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-style" />
    <!-- icons -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
</head>

<body>
    <?php
    //Reservation
    $sql = "SELECT ItemID, [Date], fldTime, PropertyID, PropertyName, fldBookingNo, fldArrDate, fldDeptDate, fldNoOfNight, fldNoOfRoom, fldRoomNo, fldRoomType, fldGuestName, fldCompanyName, fldPhnNumber, fldEmail, fldPAX, fldAdvance, fldBooleans, fldSentTime, fldMessageID, fldDeliveryStatus, fldSMSCount, fldCurrentCredit FROM tblBookingRSMS WHERE (fldBooleans IN (1, 2, 3)) and PropertyID in ('SM001') order by fldBooleans";
    $stmt = sqlsrv_query($conn, $sql);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $ItemID = $row['ItemID'];
        $fldPhnNumber = $row['fldPhnNumber'];
        $fldBookingNo = $row['fldBookingNo'];
        $fldGuestName = $row['fldGuestName'];
        $fldArrDate = $row['fldArrDate']->format('d-M-Y');
        $fldDeptDate = $row['fldDeptDate']->format('d-M-Y');
        $fldAdvance = $row['fldAdvance'];
        $fldBooleans = $row['fldBooleans'];

        if ($fldBooleans == 1) {
            $msg = "Greetings from Neeshorgo.
Booking No.: " . $fldBookingNo . "
Guest Name: " . $fldGuestName . "
Arrival  Date: " . $fldArrDate . " at 1PM
Departure Date: " . $fldDeptDate . " at 11AM

Please pay 50% advance to confirm your booking.
Need NID/Passport to Check-In.

Payment Procedures :
# We only accept CASH or 
Bkash: 01730063216 (Marchant)
Nagad: 01894449085 (Marchant)

# We do not accept any Credit cards.

E-Mail: neeshorgocox@gmail.com
Web: www.neeshorgo.com.bd";
        } elseif ($fldBooleans == 2) {
            $msg = "Greetings from Neeshorgo
Booking No.: " . $fldBookingNo . "
Guest Name: " . $fldGuestName . "
Arrival  Date: " . $fldArrDate . " at 1PM.
Departure Date: " . $fldDeptDate . " at 11AM.
Advance Payment Received: " . $fldAdvance . "/- tk 
Need NID/Passport to Check-In.";
        } else {
            $msg = "Greetings from Neeshorgo
Booking No.: " . $fldBookingNo . "
Your booking has been canceled.
Regards,
Reservation Team
01779 969554";
        }
        $newmsg = urlencode($msg);
        // $url = "https://api.mobireach.com.bd/SendTextMessage?Username=neesh&Password=Dhaka@5599&From=8801894449089&To=" . $fldPhnNumber . "&Message=" . $newmsg;
        $url = "https://labapi.smartlabsms.com/smsapi?user=nsorgo&password=Dhaka@2021&sender=NeeshorgoHR&msisdn=". $fldPhnNumber."&smstext=".$newmsg;
        $contents = file_get_contents($url);
        function get_string_between($string, $start, $end)
        {
            $string = ' ' . $string;
            $ini = strpos($string, $start);
            if ($ini == 0) return '';
            $ini += strlen($start);
            $len = strpos(
                $string,
                $end,
                $ini
            ) - $ini;
            return substr(
                $string,
                $ini,
                $len
            );
        }

        $MessageId = get_string_between($contents, '<MessageId>', '</MessageId>');
        // $Status = get_string_between($contents, '<Status>', '</Status>');
        $StatusText = strtoupper(get_string_between($contents, '<StatusText>', '</StatusText>'));
        // $ErrorCode = get_string_between($contents, '<ErrorCode>', '</ErrorCode>');
        $SMSCount = get_string_between($contents, '<SMSCount>', '</SMSCount>');
        $CurrentCredit = get_string_between($contents, '<CurrentCredit>', '</CurrentCredit>');
        $fldSentTime = date('d-M-Y H:i:s A');

        $serverName2 = "36.255.68.238";
        $connectionInfo2 = array("Database" => "RSMS_API", "UID" => "NICE", "PWD" => "niAll@h#r@sulce");
        $conn2 = sqlsrv_connect($serverName2, $connectionInfo2);

        if ($conn2) {
            $sql2 = "UPDATE tblBookingRSMS SET fldBooleans = 0,fldSMSCount='$SMSCount', fldMessageId='$MessageId', fldDeliveryStatus='$StatusText', fldSentTime='$fldSentTime' WHERE  PropertyID in ('SM001') and ItemID = " . $ItemID;
            $stmt2 = sqlsrv_query($conn2, $sql2);
            $sql3 = "UPDATE tblCurrentBalance1 SET CurrentCredit = '$CurrentCredit' where PropertyCode ='SM001'";
            $stmt3 = sqlsrv_query($conn2, $sql3);
            if ($stmt2 === false && $stmt3 === false) {
                echo "<script>toastr.info('Update!', 'Error in query preparation/execution.');</script>";
                // die(print_r(sqlsrv_errors(), true));
            } else {
                echo "<script>toastr.info('Update!', 'Update Successful.');</script>";
            }
            sqlsrv_free_stmt($stmt2);
            sqlsrv_close($conn2);
        } else {
            echo "<script>toastr.info('Update!', 'Connection could not be established.');</script>";
        }
        if ($contents !== false) {
            // echo "SMS has been send successfully to " . $fldPhnNumber . "<br>";
            echo "<script>toastr.info('Update!', 'SMS has been send successfully to $fldPhnNumber');</script>";
        }
    }

    //     //Registration 
    //     $sql = "SELECT ItemID, [Date], fldTime, PropertyID, PropertyName, fldRegNo, fldArrDate, fldDeptDate, fldNoOfNight, fldNoOfRoom, fldRoomNo, fldRoomType, fldGuestName, fldCompanyName, fldPhnNumber, fldEmail, fldPAX, fldRoomRent, fldBooleans, fldSentTime, fldMessageID, fldDeliveryStatus, fldSMSCount, fldCurrentCredit, fldBirtDate FROM tblCheckinOut WHERE PropertyID in ('SM001', 'NC004') and fldBooleans in (1, 2) order by fldBooleans";
    //     $stmt = sqlsrv_query($conn, $sql);

    //     if ($stmt === false) {
    //         die(print_r(sqlsrv_errors(), true));
    //     }

    //     while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    //         $ItemID = $row['ItemID'];
    //         $fldPhnNumber = $row['fldPhnNumber'];
    //         $fldGuestName = strtoupper($row['fldGuestName']);
    //         $fldBooleans = $row['fldBooleans'];
    //         // Birthday
    //         // $msg = "Dear $fldGuestName,
    //         // Hotel Agrabad wishes you a very Happy Birthday! May your day be filled with unforgettable moments.
    //         // Regards,
    //         // Hotel Agrabad";

    //         if ($fldBooleans === 1) {
    //             // Checkin
    //             $msg = "Dear $fldGuestName,
    // We are excited to welcome you to Hotel Agrabad! We hope you had a comfortable journey and we are looking forward to your stay. Thank you for choosing Hotel Agrabad and we hope you have a wonderful stay!
    // Regards,
    // Hotel Agrabad";
    //         } else {
    //             // CheckOut
    //             $msg = "Dear $fldGuestName,
    // we hope you enjoyed your stay at Hotel Agrabad! We hope you had a comfortable stay and that our services met your expectations. Thank you for choosing Hotel Agrabad and we look forward to welcoming you back soon!
    // Regards,
    // Hotel Agrabad";
    //         }

    //         $newmsg = urlencode($msg);
    //         $url = "https://api.mobireach.com.bd/SendTextMessage?Username=neesh&Password=Dhaka@5599&From=8801894449089&To=" . $fldPhnNumber . "&Message=" . $newmsg;
    //         $contents = file_get_contents($url);
    //         function get_string_between($string, $start, $end)
    //         {
    //             $string = ' ' . $string;
    //             $ini = strpos($string, $start);
    //             if ($ini == 0) return '';
    //             $ini += strlen($start);
    //             $len = strpos(
    //                 $string,
    //                 $end,
    //                 $ini
    //             ) - $ini;
    //             return substr(
    //                 $string,
    //                 $ini,
    //                 $len
    //             );
    //         }

    //         $MessageId = get_string_between($contents, '<MessageId>', '</MessageId>');
    //         // $Status = get_string_between($contents, '<Status>', '</Status>');
    //         $StatusText = strtoupper(get_string_between($contents, '<StatusText>', '</StatusText>'));
    //         // $ErrorCode = get_string_between($contents, '<ErrorCode>', '</ErrorCode>');
    //         $SMSCount = get_string_between($contents, '<SMSCount>', '</SMSCount>');
    //         $CurrentCredit = get_string_between($contents, '<CurrentCredit>', '</CurrentCredit>');
    //         $fldSentTime = date('d-M-Y H:i:s A');

    //         $serverName2 = "36.255.68.238";
    //         $connectionInfo2 = array("Database" => "RSMS_API", "UID" => "NICE", "PWD" => "niAll@h#r@sulce");
    //         $conn2 = sqlsrv_connect($serverName2, $connectionInfo2);

    //         if ($conn2) {
    //             $sql2 = "UPDATE tblCheckinOut SET fldBooleans = 0, fldSMSCount='$SMSCount', fldMessageId='$MessageId', fldDeliveryStatus='$StatusText', fldSentTime='$fldSentTime' WHERE  PropertyID in ('SM001', 'NC004') and ItemID = " . $ItemID;
    //             $stmt2 = sqlsrv_query($conn2, $sql2);
    //             $sql3 = "UPDATE tblCurrentBalance1 SET CurrentCredit = '$CurrentCredit' where PropertyCode ='SM001'";
    //             $stmt3 = sqlsrv_query($conn2, $sql3);
    //             if ($stmt2 === false && $stmt3 === false) {
    //                 echo "<script>toastr.info('Update!', 'Error in query preparation/execution.');</script>";
    //                 // die(print_r(sqlsrv_errors(), true));
    //             } else {
    //                 echo "<script>toastr.info('Update!', 'Update Successful.');</script>";
    //             }
    //             sqlsrv_free_stmt($stmt2);
    //             sqlsrv_close($conn2);
    //         } else {
    //             echo "<script>toastr.info('Update Error!', 'Connection could not be established.');</script>";
    //         }
    //         if ($contents !== false) {
    //             // echo "SMS has been send successfully to " . $fldPhnNumber . "<br>";
    //             echo "<script>toastr.info('SMS!', 'SMS has been send successfully to $fldPhnNumber');</script>";
    //         }
    //     }

    //     //BirthDay 

    //     $datesql = "SELECT * FROM tblDate";
    //     $datestmt = sqlsrv_query($conn, $datesql);
    //     if ($datestmt === false) {
    //         die(print_r(sqlsrv_errors(), true));
    //     }

    //     while ($daterow = sqlsrv_fetch_array($datestmt, SQLSRV_FETCH_ASSOC)) {
    //         $SystemDate = $daterow['SDATE']->format('d-m');
    //         $regsql = "SELECT *  FROM tblCheckinOut WHERE PropertyID in ('SM001', 'NC004') and fldCurrentCredit=0";
    //         $regstmt = sqlsrv_query($conn, $regsql);

    //         $findbtsql = "SELECT *  FROM tblCheckinOut WHERE PropertyID in ('SM001', 'NC004') and fldCurrentCredit=1";
    //         $findbtstmt = sqlsrv_query($conn, $findbtsql);

    //         if ($regstmt === false or $findbtstmt === false) {
    //             die(print_r(sqlsrv_errors(), true));
    //         }

    //         while ($regrow = sqlsrv_fetch_array($regstmt, SQLSRV_FETCH_ASSOC)) { 
    //             //Reg
    //             $RegItemID = $regrow['ItemID'];
    //             $fldPhnNumber = $regrow['fldPhnNumber'];
    //             $fldGuestName = strtoupper($regrow['fldGuestName']);
    //             $fldBooleans = $regrow['fldBooleans'];
    //             $fldBirtDate = $regrow['fldBirtDate']->format('d-m');
    //             if ($SystemDate == $fldBirtDate) {

    //                 $msg = "Dear $fldGuestName,
    // Hotel Agrabad wishes you a very Happy Birthday! May your day be filled with unforgettable moments.
    // Regards,
    // Hotel Agrabad";

    //                 $newmsg = urlencode($msg);
    //                 $url = "https://api.mobireach.com.bd/SendTextMessage?Username=aghl&Password=Dhaka@5599&From=Agrabad%20HTL&To=" . $fldPhnNumber . "&Message=" . $newmsg;
    //                 $contents = file_get_contents($url);
    //                 function get_string_between($string, $start, $end)
    //                 {
    //                     $string = ' ' . $string;
    //                     $ini = strpos($string, $start);
    //                     if ($ini == 0) return '';
    //                     $ini += strlen($start);
    //                     $len = strpos(
    //                         $string,
    //                         $end,
    //                         $ini
    //                     ) - $ini;
    //                     return substr(
    //                         $string,
    //                         $ini,
    //                         $len
    //                     );
    //                 }

    //                 $MessageId = get_string_between($contents, '<MessageId>', '</MessageId>');
    //                 $StatusText = strtoupper(get_string_between($contents, '<StatusText>', '</StatusText>'));
    //                 $SMSCount = get_string_between($contents, '<SMSCount>', '</SMSCount>');
    //                 $CurrentCredit = get_string_between($contents, '<CurrentCredit>', '</CurrentCredit>');
    //                 $fldSentTime = date('d-M-Y H:i:s A');

    //                 $serverName2 = "36.255.68.238";
    //                 $connectionInfo2 = array("Database" => "RSMS_API", "UID" => "NICE", "PWD" => "niAll@h#r@sulce");
    //                 $conn2 = sqlsrv_connect($serverName2, $connectionInfo2);

    //                 if ($conn2) {
    //                     $regsql2 = "UPDATE tblCheckinOut SET fldSMSCount='$SMSCount', fldMessageId='$MessageId', fldDeliveryStatus='$StatusText',fldCurrentCredit=1, fldSentTime='$fldSentTime' WHERE  PropertyID in ('SM001', 'NC004') and ItemID = " . $RegItemID;
    //                     $regstmt2 = sqlsrv_query($conn2, $regsql2);
    //                     $sql3 = "UPDATE tblCurrentBalance1 SET CurrentCredit = '$CurrentCredit' where PropertyCode ='SM001'";
    //                     $stmt3 = sqlsrv_query($conn2, $sql3);
    //                     if ($regstmt2 === false && $stmt3 === false) {
    //                         echo "<script>toastr.info('Update!', 'Error in query preparation/execution.');</script>";
    //                     } else {
    //                         echo "<script>toastr.info('Update!', 'Update Successful.');</script>";
    //                     }
    //                     sqlsrv_free_stmt($regstmt2);
    //                     sqlsrv_close($conn2);
    //                 } else {
    //                     echo "<script>toastr.info('Update Error!', 'Connection could not be established.');</script>";
    //                 }
    //                 if (
    //                     $contents !== false
    //                 ) {
    //                     echo "<script>toastr.info('SMS!', 'SMS has been send successfully to $fldPhnNumber');</script>";
    //                 }
    //             } 
    //         }

    //         while ($findbtrow = sqlsrv_fetch_array($findbtstmt, SQLSRV_FETCH_ASSOC)) {
    //             //findbt and uodate
    //             $findbtItemID = $findbtrow['ItemID'];
    //             $findbtfldBirtDate = $findbtrow['fldBirtDate']->format('d-m');

    //             if ($SystemDate != $findbtfldBirtDate) {
    //                 $sql5 = "UPDATE tblCheckinOut SET  fldCurrentCredit=0 WHERE  PropertyID in ('SM001', 'NC004') and ItemID = " . $findbtItemID;
    //                 $stmt5 = sqlsrv_query($conn, $sql5);
    //                 if ($stmt5 === false) {
    //                     echo "<script>toastr.info('Update!', 'Error in query preparation/execution.');</script>";
    //                 }
    //                 sqlsrv_free_stmt($stmt5);
    //                 sqlsrv_close($conn);
    //             }
    //         }
    //     }


    //Current Balance
    $ccreditsql = "SELECT * FROM tblCurrentBalance1 where PropertyCode ='SM001'";
    $stmt3 = sqlsrv_query($conn, $ccreditsql);
    if ($stmt3 === false) {
        die(print_r(sqlsrv_errors(), true));
    }
    ?>
    <div class="content-page">
        <div class="content">
            <!-- Start Content-->
            <div class="container">
                <!-- Navbar -->
                <nav class="navbar navbar-expand-lg navbar-white fixed-top">
                    <div class="container">
                        <!-- Left side logo with company name -->
                        <a class="navbar-brand" href="index.php">
                            <img src="./assets/images/hotellogo.png" alt="Logo" height="40" class="me-2">
                            <!-- Hotel Agrabad -->
                        </a>

                        <!-- Right side items -->
                        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <a class="nav-link text-black" id="DataDiv" href="#">Server : <i class="fas fa-handshake-slash"></i> <?php echo $connectmsg; ?> </a>
                                </li>
                                <!-- <li class="nav-item" style="margin-top: 7px;"><a class="nav-link text-black" href="#">Logout <i class="fas fa-right-from-bracket"></i> </a></li> -->


                            </ul>
                        </div>
                    </div>
                </nav><!-- End Navbar -->
 
                <script type='text/javascript'>
                    setInterval(function() {
                        $('#DataDiv').load(location.href + ' #DataDiv'); 
                    }, 10000);
                </script> 

                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">

                                <form method="post" action="">
                                    <div class="row">
                                        <div class="mb-3 col-md-3">
                                            <label for="start_date" class="form-label">Form Date</label>
                                            <input name="start_date" type="date" class="form-control" id="start_date" value="<?php echo date('m-d-Y'); ?>" required>
                                        </div>
                                        <div class="mb-3 col-md-3">
                                            <label for="end_date" class="form-label">To Date</label>
                                            <input name="end_date" type="date" class="form-control" id="end_date" value="<?php echo date('m-d-Y'); ?>" required>
                                        </div>
                                        <div class="mt-3 col-md-2">
                                            <label for="submit" class="form-label"></label>
                                            <button type="submit" id="submit" name="submit" class="btn btn-primary waves-effect waves-light" style="margin-top: 5px;">SUBMIT</button>
                                        </div>
                                    </div>
                                </form>

                                <table id="datatable-buttons" style="overflow:hidden; width: 100% !important;" class="table table-striped table-bordered dt-responsive dataTable no-footer dtr-inline">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col" style="width: max-content !important;">EntryDate</th>
                                            <th scope="col">Property ID</th>
                                            <th scope="col">Guest Name</th>
                                            <th scope="col">Contact Number</th>
                                            <th scope="col">Booking No.</th>
                                            <th scope="col">Arrival Date</th>
                                            <th scope="col">Departure Date</th>
                                            <th scope="col">Booking Advance</th>
                                            <th scope="col">Booleans</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (isset($_POST['submit'])) {
                                            if ($conn) {
                                                $start_date = $_POST['start_date'];
                                                $end_date = $_POST['end_date'];
                                            } else {
                                                echo 'Please check your main server.';
                                            }

                                            $sql = "SELECT  * FROM  tblBookingRSMS WHERE   (Date BETWEEN '$start_date' AND '$end_date') and PropertyID in ('SM001') ORDER BY ItemID desc";

                                            $stmt = sqlsrv_query($conn, $sql);

                                            if ($stmt === false) {
                                                die(print_r(sqlsrv_errors(), true));
                                            }
                                            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                                                $ItemID = $row["ItemID"];
                                                $Date = $row["Date"]->format('m-d-Y');
                                                $PropertyID = $row["PropertyID"];
                                                $PropertyName = $row["PropertyName"];
                                                $GuestName = $row["fldGuestName"];
                                                $PhnNumber = $row["fldPhnNumber"];
                                                $BookingNo = $row["fldBookingNo"];
                                                $ArrDate = $row["fldArrDate"]->format('m-d-Y');
                                                $DeptDate = $row["fldDeptDate"]->format('m-d-Y');
                                                $Advance = $row["fldAdvance"];
                                                $Booleans = $row["fldBooleans"];
                                        ?>
                                                <tr>
                                                    <th scope="row"><?php echo $ItemID; ?></th>
                                                    <td style="width: max-content !important;"><?php echo $Date; ?></td>
                                                    <td><?php echo $PropertyID; ?></td>
                                                    <td><?php echo $GuestName; ?></td>
                                                    <td><?php echo $PhnNumber; ?></td>
                                                    <td><?php echo $BookingNo; ?></td>
                                                    <td><?php echo $ArrDate; ?></td>
                                                    <td><?php echo $DeptDate; ?></td>
                                                    <td><?php echo $Advance; ?></td>
                                                    <td><?php
                                                        if ($Booleans == 2) {
                                                            echo "With Advance";
                                                        } elseif ($Booleans == 1) {
                                                            echo "Without Advance";
                                                        } else {
                                                            echo "SENT";
                                                        }
                                                        ?></td>
                                                </tr>
                                        <?php }
                                        } ?>
                                    </tbody>
                                </table>

                                <script type="text/javascript">
                                    $(document).ready(function() {

                                        //Expected Depurture List';
                                        var table = $('#datatable-buttons').DataTable({
                                            dom: 'Bfrtip',
                                            buttons: [{
                                                    extend: 'copyHtml5',
                                                    text: 'Copy',
                                                    // exportOptions: {
                                                    // columns: ':visible'
                                                    // }
                                                },
                                                {
                                                    extend: 'pdfHtml5',
                                                    text: 'PDF',
                                                    // exportOptions: {
                                                    // columns: ':visible'
                                                    // }
                                                    orientation: 'landscape',
                                                    pageSize: 'LEGAL'
                                                },
                                                {
                                                    extend: 'csvHtml5',
                                                    text: 'CSV',
                                                    // exportOptions: {
                                                    // columns: ':visible'
                                                    // }
                                                },
                                                {
                                                    extend: 'print',
                                                    text: 'PRINT',
                                                    // exportOptions: {
                                                    // columns: ':visible'
                                                    // }
                                                    orientation: 'landscape',
                                                    pageSize: 'A4'
                                                }
                                            ]
                                        });
                                    });
                                </script>


                            </div>
                        </div>
                    </div> <!-- end row -->
                </div> <!-- container-fluid -->
            </div> <!-- content -->
        </div>
    </div>
</body>

</html>
