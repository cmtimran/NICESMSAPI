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

    <!-- Plugins css -->
    <link href="assets/libs/spectrum-colorpicker2/spectrum.min.css" rel="stylesheet" type="text/css">
    <link href="assets/libs/flatpickr/flatpickr.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/libs/clockpicker/bootstrap-clockpicker.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/libs/mohithg-switchery/switchery.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/libs/multiselect/css/multi-select.css" rel="stylesheet" type="text/css" />
    <link href="assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/libs/selectize/css/selectize.bootstrap3.css" rel="stylesheet" type="text/css" />
    <link href="assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet" type="text/css" />

    <!-- Datatable Plugins css -->
    <link rel="stylesheet" type="text/css" href="./assets/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" type="text/css" href="./assets/css/buttons.dataTables.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/fixedcolumns/4.2.1/css/fixedColumns.dataTables.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.4.0/css/responsive.dataTables.min.css" />

    <!-- Datatable Plugins JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.3/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.colVis.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script>

    <!-- App css -->
    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-style" />
    <!-- icons -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
</head>

<body>
    <div class="content-page">
        <div class="content">
            <!-- Start Content-->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <?php
                                require './sqlconnect.php';
                                
                                $sql = "SELECT ItemID, Date, PropertyID, PropertyName, fldGuestName, fldPhnNumber, fldBookingNo, fldArrDate, fldDeptDate, fldBookingAdvance, fldBooleans
                                FROM tblBookingRSMS WHERE fldBooleans IN (1, 2) order by fldBooleans";
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
                                    $fldBookingAdvance = $row['fldBookingAdvance'];
                                    $fldBooleans = $row['fldBooleans'];

                                    if ($fldBooleans === 1) {
$msg = "Greetings from Neeshorgo.
Booking No.: " . $fldBookingNo . "
Guest Name: " . $fldGuestName . "
Arrival  Date: " . $fldArrDate . "
Departure Date: " . $fldDeptDate . "

Please pay 50% advance to confirm your booking.
Need NID/Passport to Check-In.

Payment Procedures :
We only accept CASH Or Bkash: 01730063216 (Marchant).
We do not accept any Credit Cards.

E-Mail: neeshorgocox@gmail.com
Web: www.neeshorgo.com.bd";
}else {
$msg = "Greetings from Neeshorgo
Booking No.: " . $fldBookingNo . "
Guest Name: " . $fldGuestName . "
Arrival  Date: " . $fldArrDate . "
Departure Date: " . $fldDeptDate . "
Advance Payment Received: " . $fldBookingAdvance . "/- tk 
Need NID/Passport to Check-In.";
                                    } 

                                    $newmsg = urlencode($msg);
                                    $url = "https://api.mobireach.com.bd/SendTextMessage?Username=neesh&Password=Dhaka@5599&From=8801894449089&To=" . $fldPhnNumber . "&Message=" . $newmsg;
                                    $contents = file_get_contents($url);
                                    if ($contents !== false) {
                                        // echo $url;
                                        echo "SMS has been send successfully to " . $fldPhnNumber . "<br>";
                                    }
                                    $update_sql = "UPDATE tblBookingRSMS SET fldBooleans = 0 WHERE ItemID = " . $ItemID;
                                    sqlsrv_query($conn, $update_sql);
                                    sqlsrv_close($conn);
                                }?>
                             
                                <script type="text/javascript">
                                    setTimeout(function () {
                                        window . location . reload();
                                    }, 5000);
                                </script>
                            </div>
                        </div>
                    </div>
                </div> <!-- end row -->
            </div> <!-- container-fluid -->
        </div> <!-- content -->
    </div>
 
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>
