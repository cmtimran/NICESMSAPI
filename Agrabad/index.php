<?php
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
    <div class="content-page">
        <div class="content">
            <!-- Start Content-->
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">

                                <a class="ripple" href="index.php">
                                    <img alt="Hotel Logo" class="img-fluid img-responsive" width=60 src="./assets/images/hotellogo.png" />Hotel Agrabad
                                </a>
                                <p id="DataDiv" style="float:right;" class="text-right"><span class="mt-3"><?php echo $connectmsg; ?></span>
                                    <!-- <script type='text/javascript'>
                                        setInterval(function() {
                                            $('#DataDiv').load(location.href + ' #DataDiv');
                                        }, 13000);
                                    </script> -->
                                </p>

                                <?php 
                                $sql = "SELECT ItemID, [Date], fldTime, PropertyID, PropertyName, fldBookingNo, fldArrDate, fldDeptDate, fldNoOfNight, fldNoOfRoom, fldRoomNo, fldRoomType, fldGuestName, fldCompanyName, fldPhnNumber, fldEmail, fldPAX, fldAdvance, fldBooleans, fldSentTime, fldMessageID, fldDeliveryStatus, fldSMSCount, fldCurrentCredit FROM tblBookingRSMS WHERE (fldBooleans IN (1, 2)) order by fldBooleans";
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
                                    $msg = "Greetings";

                                    $newmsg = urlencode($msg);
                                    $url = "https://api.mobireach.com.bd/SendTextMessage?Username=neesh&Password=Dhaka@5599&From=8801894449089&To=" . $fldPhnNumber . "&Message=" . $newmsg;
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
                                    $StatusText = get_string_between($contents, '<StatusText>', '</StatusText>');
                                    // $ErrorCode = get_string_between($contents, '<ErrorCode>', '</ErrorCode>');
                                    $SMSCount = get_string_between($contents, '<SMSCount>', '</SMSCount>');
                                    $CurrentCredit = get_string_between($contents, '<CurrentCredit>', '</CurrentCredit>');
                                    // echo $MessageId;
                                    // echo $StatusText;
                                    // echo $SMSCount;
                                    // echo $CurrentCredit;

                                    $d = mktime(11, 14, 54, 8, 12, 2014);
                                    $fldSentTime = date("Y-m-d h:i:sa", $d);

                                    $update_sql = "UPDATE tblBookingRSMS SET fldBooleans = 0,fldSMSCount='$SMSCount', fldCurrentCredit='$CurrentCredit', fldMessageId='$MessageId', fldDeliveryStatus='$StatusText', fldSentTime='$fldSentTime' WHERE ItemID = " . $ItemID;
                                    sqlsrv_query($conn, $update_sql);
                                    sqlsrv_close($conn);
                                    if ($contents !== false) {
                                        echo "SMS has been send successfully to " . $fldPhnNumber . "<br>";
                                    }

                                } 
                                ?>



                                <!-- <script script type="text/javascript">
                                    setInterval(function() {
                                        $('#reloadDiv').load(location.href + ' #reloadDiv');
                                    }, 5000);
                                </script> -->
                            </div>
                        </div>
                    </div>
                </div> <!-- end row -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">

                                <!-- Tabs navs -->
                                <ul class="nav nav-tabs mb-3" id="ex1" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link active" id="ex1-tab-1" data-mdb-toggle="tab" href="#ex1-tabs-1" role="tab" aria-controls="ex1-tabs-1" aria-selected="true">Reservation</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" id="ex1-tab-2" data-mdb-toggle="tab" href="#ex1-tabs-2" role="tab" aria-controls="ex1-tabs-2" aria-selected="false">Registration</a>
                                    </li>
                                    <!-- <li class="nav-item" role="presentation">
                                        <a class="nav-link" id="ex1-tab-3" data-mdb-toggle="tab" href="#ex1-tabs-3" role="tab" aria-controls="ex1-tabs-3" aria-selected="false">Tab 3</a>
                                    </li> -->
                                </ul>
                                <!-- Tabs navs -->

                                <!-- Tabs content -->
                                <div class="tab-content" id="ex1-content">
                                    <div class="tab-pane fade show active" id="ex1-tabs-1" role="tabpanel" aria-labelledby="ex1-tab-1">
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

                                                    $sql = "SELECT  ItemID, [Date], PropertyID, PropertyName, fldGuestName, fldPhnNumber, fldBookingNo, fldArrDate, fldDeptDate, fldAdvance, fldBooleans FROM  tblBookingRSMS WHERE   (Date BETWEEN '$start_date' AND '$end_date') ORDER BY ItemID desc";

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
                                    <div class="tab-pane fade" id="ex1-tabs-2" role="tabpanel" aria-labelledby="ex1-tab-2">
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

                                        <table id="Registration-buttons" style="overflow:hidden; width: 100% !important;" class="table table-striped table-bordered dt-responsive dataTable no-footer dtr-inline">
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

                                                    $sql = "SELECT  ItemID, [Date], PropertyID, PropertyName, fldGuestName, fldPhnNumber, fldBookingNo, fldArrDate, fldDeptDate, fldAdvance, fldBooleans FROM  tblBookingRSMS WHERE   (Date BETWEEN '$start_date' AND '$end_date') ORDER BY ItemID desc";

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
                                                var table = $('#Registration-buttons').DataTable({
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
                                <!-- Tabs content -->

                            </div>
                        </div>
                    </div> <!-- end row -->
                </div> <!-- container-fluid -->
            </div> <!-- content -->
        </div>

        <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script> -->
</body>

</html>