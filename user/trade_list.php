<?php
include '../include/header.php';

if (isset($_SESSION['loginuser']['userid'])) {
    echo '<script>window.location.href = "../user/profile.php";</script>';
    exit();
}
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="../bootstrap/plugins/select2/css/select2.min.css">
        <link rel="stylesheet" href="../bootstrap/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
        <title>My Trade List - Tradee</title>
    </head>
    <body>
        <div class="container-lg mt-3 mb-5">
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <button class="nav-link active" id="nav-offer-tab" data-bs-toggle="tab" data-bs-target="#nav-offer" type="button" role="tab">Offer list</button>
                    <button class="nav-link" id="nav-accept-tab" data-bs-toggle="tab" data-bs-target="#nav-accept" type="button" role="tab">Accept list</button>
                    <button class="nav-link" id="nav-delivery-tab" data-bs-toggle="tab" data-bs-target="#nav-sender" type="button" role="tab">Send list</button>
                    <button class="nav-link" id="nav-delivery-tab" data-bs-toggle="tab" data-bs-target="#nav-recipient" type="button" role="tab">Receive list</button>
                    <button class="nav-link" id="nav-donation-tab" data-bs-toggle="tab" data-bs-target="#nav-donation" type="button" role="tab">Donation list</button>
                </div>
            </nav>

            <div class="tab-content" id="nav-tabContent" style="margin-bottom: 75px;">
                <!--tab 1-->
                <div class="tab-pane fade show active" id="nav-offer" role="tabpanel">
                    <div class="container-lg mt-3">
                        <div class="content" style="padding-bottom:20%">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Trade Offer List</h3>
                                </div>
                                <div class="card-body">
                                    <table id="tradeoffertable" class="table table-striped table-bordered" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th style="width: 12%;">Trade ID</th>
                                                <th style="width: 12%;">Trader</th>
                                                <th style="width: 16%;">Trader's Payment</th>
                                                <th style="width: 15%;">My Payment</th> 
                                                <th style="width: 14%;">Date</th>
                                                <th style="width: 12%;">Status</th>
                                                <th style="width: 8%;"></th>
                                                <th style="width: auto;"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sql = "SELECT * FROM trade t, customer c WHERE t.acceptCustID = c.custid AND t.offerCustID = '" . $_SESSION['loginuser']['custid'] . "'";
                                            $result = $dbc->query($sql);
                                            if ($result) {
                                                while ($row = $result->fetch_assoc()) {
                                                    if ($row["status"] == "Pending") {
                                                        $color1 = "orange";
                                                        $disabled = "none";
                                                    } else if ($row["status"] == "Completed") {
                                                        $color1 = "limegreen";
                                                        $disabled = "none";
                                                    } else if ($row["status"] == "Trading") {
                                                        $color1 = "skyblue";
                                                        $disabled = "none";
                                                    } else if ($row["status"] == "Rejected") {
                                                        $color1 = "red";
                                                        $disabled = "none";
                                                    } else if ($row["status"] == "To Pay") {
                                                        $color1 = "slateblue";
                                                        $disabled = "auto";
                                                    } else if ($row["status"] == "To Ship") {
                                                        $color1 = "lightsalmon";
                                                        $disabled = "none";
                                                    } else {
                                                        $color1 = "red";
                                                        $disabled = "none";
                                                    }

                                                    if ($row["offerPayment"] == "Pending") {
                                                        $color2 = "orange";
                                                    } else if ($row["offerPayment"] == "Completed") {
                                                        $color2 = "limegreen";
                                                        $disabled = "none";
                                                    } else if ($row["offerPayment"] == "Failed") {
                                                        $color2 = "red";
                                                    } else {
                                                        $color2 = "skyblue";
                                                    }

                                                    if ($row["acceptPayment"] == "Pending") {
                                                        $color3 = "orange";
                                                    } else if ($row["acceptPayment"] == "Completed") {
                                                        $color3 = "limegreen";
                                                    } else if ($row["acceptPayment"] == "Failed") {
                                                        $color3 = "red";
                                                    } else {
                                                        $color3 = "skyblue";
                                                    }

                                                    echo "<tr>"
                                                    . "<td>" . $row["tradeid"] . "</td>"
                                                    . "<td>" . $row["username"] . "</td>"
                                                    . "<td style='color: " . $color3 . "; font-weight: bolder;'>" . $row["acceptPayment"] . "</td>"
                                                    . "<td style='color: " . $color2 . "; font-weight: bolder;'>" . $row["offerPayment"] . "</td>"
                                                    . "<td>" . $row["date"] . "</td>"
                                                    . "<td style='font-weight: bolder; color:" . $color1 . "'>" . $row["status"] . "</td>"
                                                    . "<td>"
                                                    . "<a type='button' class='btn btn-block' style='pointer-events: " . $disabled . "' href='offer_delivery_shipping.php?id=" . $row["tradeid"] . "'>"
                                                    . "<i type='button' class='fas fa-truck' style='color:" . $color2 . ";font-size: 1.1em;'></i>"
                                                    . "</a>"
                                                    . "</td>"
                                                    . "<td>"
                                                    . "<a class='btn btn-block btn-info' href='trade_offer.php?id=" . $row["tradeid"] . "'>"
                                                    . "<i class='far fa-eye' style='font-size: 1.1em;'></i>"
                                                    . "</a>"
                                                    . "</td>";
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!--tab 2-->
                <div class="tab-pane fade" id="nav-accept" role="tabpanel">
                    <div class="container-lg mt-3">
                        <div class="content" style="padding-bottom:20%">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Trade Accept List</h3>
                                </div>
                                <div class="card-body">
                                    <table id="tradeaccepttable" class="table table-striped table-bordered" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th style="width: 12%;">Trade ID</th>
                                                <th style="width: 12%;">Trader</th>
                                                <th style="width: 15%;">Trader's Payment</th>
                                                <th style="width: 15%;">My Payment</th>
                                                <th style="width: 14%;">Date</th>
                                                <th style="width: 12%;">Status</th>
                                                <th style="width: 10%;"></th>
                                                <th style="width: auto;"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sql = "SELECT * FROM trade t, customer c WHERE t.offerCustID = c.custid AND t.acceptCustID = '" . $_SESSION['loginuser']['custid'] . "'";
                                            $result = $dbc->query($sql);
                                            if ($result) {
                                                while ($row = $result->fetch_assoc()) {
                                                    if ($row["status"] == "Pending") {
                                                        $color1 = "orange";
                                                        $disabled = "none";
                                                    } else if ($row["status"] == "Completed") {
                                                        $color1 = "limegreen";
                                                        $disabled = "none";
                                                    } else if ($row["status"] == "Trading") {
                                                        $color1 = "skyblue";
                                                        $disabled = "none";
                                                    } else if ($row["status"] == "Rejected") {
                                                        $color1 = "red";
                                                        $disabled = "none";
                                                    } else if ($row["status"] == "To Pay") {
                                                        $color1 = "slateblue";
                                                        $disabled = "auto";
                                                    } else if ($row["status"] == "To Ship") {
                                                        $color1 = "lightsalmon";
                                                        $disabled = "none";
                                                    } else {
                                                        $color1 = "red";
                                                        $disabled = "none";
                                                    }

                                                    if ($row["acceptPayment"] == "Pending") {
                                                        $color2 = "orange";
                                                    } else if ($row["acceptPayment"] == "Completed") {
                                                        $color2 = "limegreen";
                                                        $disabled = "none";
                                                    } else if ($row["acceptPayment"] == "Failed") {
                                                        $color2 = "red";
                                                        $disabled = "none";
                                                    } else {
                                                        $color2 = "skyblue";
                                                    }

                                                    if ($row["offerPayment"] == "Pending") {
                                                        $color3 = "orange";
                                                    } else if ($row["offerPayment"] == "Completed") {
                                                        $color3 = "limegreen";
                                                    } else if ($row["offerPayment"] == "Failed") {
                                                        $color3 = "red";
                                                    } else {
                                                        $color3 = "skyblue";
                                                    }

                                                    echo "<tr>"
                                                    . "<td>" . $row["tradeid"] . "</td>"
                                                    . "<td>" . $row["username"] . "</td>"
                                                    . "<td style='color: " . $color3 . "; font-weight: bolder;'>" . $row["offerPayment"] . "</td>"
                                                    . "<td style='color: " . $color2 . "; font-weight: bolder;'>" . $row["acceptPayment"] . "</td>"
                                                    . "<td>" . $row["date"] . "</td>"
                                                    . "<td style='font-weight: bolder; color:" . $color1 . "'>" . $row["status"] . "</td>"
                                                    . "<td>"
                                                    . "<a class='btn btn-block' style='pointer-events: " . $disabled . "' href='accept_delivery_shipping.php?id=" . $row["tradeid"] . "'>"
                                                    . "<i class='fas fa-truck' style='color:" . $color2 . ";font-size: 1.1em;'></i>"
                                                    . "</a>"
                                                    . "</td>"
                                                    . "<td>"
                                                    . "<a class='btn btn-info btn-block' href='trade_accept.php?id=" . $row["tradeid"] . "'>"
                                                    . "<i class='far fa-eye' style='font-size: 1.1em;'></i>"
                                                    . "</a>"
                                                    . "</td>";
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!--tab 3-->
                <div class="tab-pane fade" id="nav-sender" role="tabpanel">
                    <div class="container-lg mt-3">
                        <div class="content" style="padding-bottom:20%">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Send List</h3>
                                </div>
                                <div class="card-body">
                                    <table id="sendertable" class="table table-striped table-bordered" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th style="width: 13%;">Delivery ID</th>
                                                <th style="width: 11%;">Trade ID</th>
                                                <!--<th style="width: 13%;">Recipient</th>-->
                                                <!--<th style="width: 17%;">Package</th>--> 
                                                <th style="width: 10%;">Total</th>
                                                <th style="width: 15%;">Payment Date</th>
                                                <th style="width: 15%;">Received Date</th>
                                                <th style="width: 12%;">Status</th>
                                                <th style="width: auto;"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
//                                            $sql = "SELECT * FROM delivery d, customer c WHERE d.senderid = c.custid AND d.senderid = '" . $_SESSION['loginuser']['custid'] . "'";
                                            $sql = "SELECT * FROM delivery WHERE senderid = '" . $_SESSION['loginuser']['custid'] . "'";
                                            $result = $dbc->query($sql);
                                            if ($result) {
                                                while ($row = $result->fetch_assoc()) {

                                                    if ($row["deliveryStatus"] == "Pending") {
                                                        $color1 = "orange";
                                                    } else if ($row["deliveryStatus"] == "In Transit") {
                                                        $color1 = "lightsalmon";
                                                    } else if ($row["deliveryStatus"] == "Shipping") {
                                                        $color1 = "skyblue";
                                                    } else if ($row["deliveryStatus"] == "Delivered") {
                                                        $color1 = "limegreen";
                                                    } else {
                                                        $color1 = "red";
                                                    }

                                                    if ($row["receiveDate"] == '') {
                                                        $color2 = "orange";
                                                        $status = "On-Deliver";
                                                    } else if ($row["receiveDate"] !== '') {
                                                        $color2 = "limegreen";
                                                        $status = "";
                                                    } else {
                                                        $color2 = "red";
                                                        $status = "red";
                                                    }

                                                    echo "<tr>"
                                                    . "<td>" . $row["deliveryid"] . "</td>"
                                                    . "<td>" . $row["tradeid"] . "</td>";

//                                                    $sql1 = "SELECT c.username FROM customer c, delivery d WHERE d.recipientid = c.custid AND d.senderid = '" . $_SESSION['loginuser']['custid'] . "'";
//                                                    $result1 = $dbc->query($sql1);
//                                                    if ($result1->num_rows > 0) {
//                                                        while ($row1 = mysqli_fetch_array($result1)) {
//                                                            $recipient = "SELECT c.username FROM customer c WHERE c.custid <> '" . $_SESSION['loginuser']['custid'] . "'";
//                                                            $result2 = $dbc->query($recipient);
//                                                            if ($result2->num_rows > 0) {
//                                                                while ($row2 = mysqli_fetch_array($result2)) {
//                                                                    echo "<td>" . $row2[0] . "</td>";
//                                                                }
//                                                            }
//                                                        }
//                                                    }

//                                                    echo "<td>" . $row["package"] . "</td>"
                                                    echo "<td>" . $row["totalAmount"] . "</td>"
                                                    . "<td>" . $row["paymentDate"] . "</td>"
                                                    . "<td style='color:" . $color2 . "; font-weight: bolder;'>" . $status . "" . $row["receiveDate"] . "</td>"
                                                    . "<td style='color:" . $color1 . "; font-weight: bolder;'>" . $row["deliveryStatus"] . "</td>"
                                                    . "<td>"
                                                    . "<a class='btn btn-info btn-block' href='send_list.php?id=" . $row["deliveryid"] . "'>"
                                                    . "<i class='fas fa-truck' style='font-size: 1.1em;'></i>"
                                                    . "</a>"
                                                    . "</td>";
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!--tab 4-->
                <div class="tab-pane fade" id="nav-recipient" role="tabpanel">
                    <div class="container-lg mt-3">
                        <div class="content" style="padding-bottom:20%">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Receive List</h3>
                                </div>
                                <div class="card-body">
                                    <table id="recipienttable" class="table table-striped table-bordered" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th style="width: 13%;">Delivery ID</th>
                                                <th style="width: 11%;">Trade ID</th>
                                                <!--<th style="width: 13%;">Sender</th>-->
                                                <!--<th style="width: 17%;">Package</th>--> 
                                                <th style="width: 10%;">Total</th>
                                                <th style="width: 15%;">Payment Date</th>
                                                <th style="width: 15%;">Received Date</th>
                                                <th style="width: 12%;">Status</th>
                                                <th style="width: auto;"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sql = "SELECT * FROM delivery WHERE recipientid = '" . $_SESSION['loginuser']['custid'] . "'";
                                            $result = $dbc->query($sql);
                                            if ($result) {
                                                while ($row = $result->fetch_assoc()) {

                                                    if ($row["deliveryStatus"] == "Pending") {
                                                        $color1 = "orange";
                                                    } else if ($row["deliveryStatus"] == "In Transit") {
                                                        $color1 = "lightsalmon";
                                                    } else if ($row["deliveryStatus"] == "Shipping") {
                                                        $color1 = "skyblue";
                                                    } else if ($row["deliveryStatus"] == "Delivered") {
                                                        $color1 = "limegreen";
                                                    } else {
                                                        $color1 = "red";
                                                    }

                                                    if ($row["receiveDate"] == '') {
                                                        $color2 = "orange";
                                                        $status = "On-Deliver";
                                                    } else if ($row["receiveDate"] !== '') {
                                                        $color2 = "limegreen";
                                                        $status = "";
                                                    } else {
                                                        $color2 = "red";
                                                        $status = "red";
                                                    }

                                                    echo "<tr>"
                                                    . "<td>" . $row["deliveryid"] . "</td>"
                                                    . "<td>" . $row["tradeid"] . "</td>";

//                                                    $sender = "SELECT c.username FROM customer c, delivery d WHERE d.senderid = c.custid AND d.recipientid = '" . $_SESSION['loginuser']['custid'] . "'";
//                                                    $result = $dbc->query($sender);
//                                                    if ($result->num_rows > 0) {
//                                                        while ($row1 = mysqli_fetch_array($result)) {
//                                                            echo "<td>" . $row1[0] . "</td>";
//                                                        }
//                                                    }

//                                                    echo "<td>" . $row["package"] . "</td>"
                                                    echo "<td>" . $row["totalAmount"] . "</td>"
                                                    . "<td>" . $row["paymentDate"] . "</td>"
                                                    . "<td style='color:" . $color2 . "; font-weight: bolder;'>" . $status . "" . $row["receiveDate"] . "</td>"
                                                    . "<td style='color:" . $color1 . "; font-weight: bolder;'>" . $row["deliveryStatus"] . "</td>"
                                                    . "<td>"
                                                    . "<a class='btn btn-info btn-block' href='receive_list.php?id=" . $row["deliveryid"] . "'>"
                                                    . "<i class='fas fa-truck' style='font-size: 1.1em;'></i>"
                                                    . "</a>"
                                                    . "</td>";
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!--tab 5-->
                <div class="tab-pane fade" id="nav-donation" role="tabpanel">
                    <div class="container-lg mt-3">
                        <div class="content" style="padding-bottom:20%">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Donation List</h3>
                                </div>
                                <div class="card-body">
                                    <table id="donationtable" class="table table-striped table-bordered" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th style="width: 12%;">Trade ID</th>
                                                <th style="width: 12%;">Trader</th>
                                                <th style="width: 15%;">His Payment</th>
                                                <th style="width: 15%;">My Payment</th>
                                                <th style="width: 14%;">Date</th>
                                                <th style="width: 12%;">Status</th>
                                                <th style="width: 10%;"></th>
                                                <th style="width: auto;"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sql = "SELECT * FROM trade t, customer c WHERE t.offerCustID = c.custid AND t.acceptCustID = '" . $_SESSION['loginuser']['custid'] . "'";
                                            $result = $dbc->query($sql);
                                            if ($result) {
                                                while ($row = $result->fetch_assoc()) {
                                                    if ($row["status"] == "Pending") {
                                                        $color1 = "orange";
                                                        $disabled = "none";
                                                    } else if ($row["status"] == "Completed") {
                                                        $color1 = "limegreen";
                                                        $disabled = "auto";
                                                    } else if ($row["status"] == "Trading") {
                                                        $color1 = "skyblue";
                                                        $disabled = "auto";
                                                    } else {
                                                        $color1 = "red";
                                                        $disabled = "auto";
                                                    }

                                                    if ($row["acceptPayment"] == "Pending") {
                                                        $color2 = "orange";
                                                    } else if ($row["acceptPayment"] == "Completed") {
                                                        $color2 = "limegreen";
                                                        $disabled = "none";
                                                    } else {
                                                        $color2 = "red";
                                                    }

                                                    if ($row["offerPayment"] == "Pending") {
                                                        $color3 = "orange";
                                                    } else if ($row["offerPayment"] == "Completed") {
                                                        $color3 = "limegreen";
                                                    } else {
                                                        $color3 = "skyblue";
                                                    }

                                                    echo "<tr>"
                                                    . "<td>" . $row["tradeid"] . "</td>"
                                                    . "<td>" . $row["username"] . "</td>"
                                                    . "<td style='color: " . $color3 . "; font-weight: bolder;'>" . $row["offerPayment"] . "</td>"
                                                    . "<td style='color: " . $color2 . "; font-weight: bolder;'>" . $row["acceptPayment"] . "</td>"
                                                    . "<td>" . $row["date"] . "</td>"
                                                    . "<td style='font-weight: bolder; color:" . $color1 . "'>" . $row["status"] . "</td>"
                                                    . "<td>"
                                                    . "<a class='btn btn-block' style='pointer-events: " . $disabled . "' href='accept_delivery_shipping.php?id=" . $row["tradeid"] . "'>"
                                                    . "<i class='fas fa-truck' style='color:" . $color2 . ";font-size: 1.1em;'></i>"
                                                    . "</a>"
                                                    . "</td>"
                                                    . "<td>"
                                                    . "<a class='btn btn-info btn-block' href='trade_accept.php?id=" . $row["tradeid"] . "'>"
                                                    . "<i class='far fa-eye' style='font-size: 1.1em;'></i>"
                                                    . "</a>"
                                                    . "</td>";
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include '../include/footer.php'; ?>
    </body>
    <script src="../bootstrap/plugins/select2/js/select2.full.min.js"></script>
    <script>
        $(function () {
            //Initialize Select2 Elements
            $('.select2').select2()

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        })

        $('#tradeoffertable').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true,
            "responsive": true
        });

        $('#tradeaccepttable').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true,
            "responsive": true
        });

        $('#sendertable').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true,
            "responsive": true
        });

        $('#recipienttable').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true,
            "responsive": true
        });

        $('#donationtable').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true,
            "responsive": true
        });
    </script>
    <style>
        /*item*/
        .item-img-box{
            /*width: 192px;*/
            /*height: 192px;*/
            /*background: #e8e8e8;*/
            /*max-width: 255px;*/
            max-height: 370px;
            background: whitesmoke;
            text-align: center;
            background-size: cover;
            object-fit: cover;
        }

        .item-img{
            /*max-height: 300px;*/
            /*height: 100%;*/
            text-align: center;
            background-size: contain;
            background-repeat:   no-repeat;
            background: whitesmoke;
        }

        .fa-heart:hover{
            color: red;
        }
        /*item*/

        .profile-pic-box{
            /*border-radius: 3996px;*/
        }

        .profile-pic{
            width: 192px;
            height: 192px;
            /*            width: 142px;
                        height: 142px;*/
            object-fit: cover;
        }

        .profile-pic-small{
            width: 52px;
            height: 52px;
            /*            width: 142px;
                        height: 142px;*/
            object-fit: cover;
        }

        .model-profile-pic{
            width: 112px;
            height: 112px;
            /*            width: 142px;
                        height: 142px;*/
            object-fit: cover;
        }
    </style>
</html>