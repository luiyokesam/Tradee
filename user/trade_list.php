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
        <div class="container-lg mt-3">
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <button class="nav-link " id="nav-offer-tab" data-bs-toggle="tab" data-bs-target="#nav-offer" type="button" role="tab">Offer list</button>
                    <button class="nav-link" id="nav-accept-tab" data-bs-toggle="tab" data-bs-target="#nav-accept" type="button" role="tab">Accept list</button>
                    <button class="nav-link active" id="nav-delivery-tab" data-bs-toggle="tab" data-bs-target="#nav-delivery" type="button" role="tab">Delivery list</button>
                </div>
            </nav>

            <div class="tab-content" id="nav-tabContent">
                <!--tab 3-->
                <div class="tab-pane fade " id="nav-offer" role="tabpanel">
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
                                            $sql = "SELECT * FROM trade t, customer c WHERE t.acceptCustID = c.custid AND t.offerCustID = '" . $_SESSION['loginuser']['custid'] . "'";
                                            $result = $dbc->query($sql);
                                            if ($result) {
                                                while ($row = $result->fetch_assoc()) {
                                                    if ($row["status"] === "Pending") {
                                                        $color1 = "orange";
                                                        $disabled = "none";
                                                    } else if ($row["status"] === "Completed") {
                                                        $color1 = "green";
                                                        $disabled = "auto";
                                                    } else if ($row["status"] === "Trading") {
                                                        $color1 = "blue";
                                                        $disabled = "auto";
                                                    } else {
                                                        $color1 = "red";
                                                        $disabled = "auto";
                                                    }

                                                    if ($row["offerPayment"] === "Pending") {
                                                        $color2 = "orange";
                                                    } else if ($row["offerPayment"] === "Completed") {
                                                        $color2 = "green";
                                                        $disabled = "none";
                                                    } else {
                                                        $color2 = "blue";
                                                    }

                                                    if ($row["acceptPayment"] === "Pending") {
                                                        $color3 = "orange";
                                                    } else if ($row["offerPayment"] === "Completed") {
                                                        $color3 = "green";
                                                    } else {
                                                        $color3 = "blue";
                                                    }

                                                    echo "<tr>"
                                                    . "<td style='text-align: center'>" . $row["tradeid"] . "</td>"
                                                    . "<td style='text-align: center'>" . $row["username"] . "</td>"
                                                    . "<td style='text-align: center; color: ". $color3 ."; font-weight: bolder;''>" . $row["acceptPayment"] . "</td>"
                                                    . "<td style='text-align: center; color: ". $color2 ."; font-weight: bolder;'>" . $row["offerPayment"] . "</td>"
                                                    . "<td style='text-align: center'>" . $row["date"] . "</td>"
                                                    . "<td style='text-align: center; font-weight: bolder; color:" . $color1 . "'>" . $row["status"] . "</td>"
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

                <!--tab 4-->
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
                                                    if ($row["status"] === "Pending") {
                                                        $color1 = "orange";
                                                        $disabled = "none";
                                                    } else if ($row["status"] === "Completed") {
                                                        $color1 = "green";
                                                        $disabled = "auto";
                                                    } else if ($row["status"] === "Trading") {
                                                        $color1 = "blue";
                                                        $disabled = "auto";
                                                    } else {
                                                        $color1 = "red";
                                                        $disabled = "auto";
                                                    }

                                                    if ($row["acceptPayment"] === "Pending") {
                                                        $color2 = "orange";
                                                    } else if ($row["acceptPayment"] === "Completed") {
                                                        $color2 = "green";
                                                        $disabled = "none";
                                                    } else {
                                                        $color2 = "red";
                                                    }

                                                    if ($row["offerPayment"] === "Pending") {
                                                        $color3 = "orange";
                                                    } else if ($row["offerPayment"] === "Completed") {
                                                        $color3 = "green";
                                                    } else {
                                                        $color3 = "blue";
                                                    }

                                                    echo "<tr>"
                                                    . "<td style='text-align: center'>" . $row["tradeid"] . "</td>"
                                                    . "<td style='text-align: center'>" . $row["username"] . "</td>"
                                                    . "<td style='text-align: center; color: ". $color3 ."; font-weight: bolder;'>" . $row["offerPayment"] . "</td>"
                                                    . "<td style='text-align: center; color: ". $color2 ."; font-weight: bolder;'>" . $row["acceptPayment"] . "</td>"
                                                    . "<td style='text-align: center'>" . $row["date"] . "</td>"
                                                    . "<td style='text-align: center; font-weight: bolder; color:" . $color1 . "'>" . $row["status"] . "</td>"
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
                
                <!--tab 5-->
                <div class="tab-pane fade show active" id="nav-delivery" role="tabpanel">
                    <div class="container-lg mt-3">
                        <div class="content" style="padding-bottom:20%">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Delivery List</h3>
                                </div>
                                <div class="card-body">
                                    <table id="deliverytable" class="table table-striped table-bordered" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th style="width: 12%;">Delivery ID</th>
                                                <th style="width: 10%;">Trade ID</th>
                                                <th style="width: 15%;">Package</th> 
                                                <th style="width: 12%;">Total</th>
                                                <th style="width: 14%;">Payment Date</th>
                                                <th style="width: 15%;">Received Date</th>
                                                <th style="width: 10%;">Status</th>
                                                <th style="width: auto;"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sql = "SELECT * FROM delivery WHERE custid = '" . $_SESSION['loginuser']['custid'] . "'";
                                            $result = $dbc->query($sql);
                                            if ($result) {
                                                while ($row = $result->fetch_assoc()) {

                                                    if ($row["deliveryStatus"] == "Pending") {
                                                        $color1 = "orange";
                                                    } else if ($row["deliveryStatus"] == "Completed") {
                                                        $color1 = "green";
                                                    } else {
                                                        $color1 = "blue";
                                                    }

                                                    if ($row["receiveDate"] == '') {
                                                        $color2 = "orange";
                                                        $status = "Delivering";
                                                    } else {
                                                        $color2 = "blue";
                                                        $status = "OK";
                                                    }

                                                    echo "<tr>"
                                                    . "<td style='text-align: center'>" . $row["deliveryid"] . "</td>"
                                                    . "<td style='text-align: center'>" . $row["tradeid"] . "</td>"
                                                    . "<td style='text-align: center'>" . $row["package"] . "</td>"
                                                    . "<td style='text-align: center'>" . $row["totalAmount"] . "</td>"
                                                    . "<td style='text-align: center'>" . $row["paymentDate"] . "</td>"
                                                    . "<td style='text-align: center;  color:" . $color2 . "; font-weight: bolder;'>" . $status . "</td>"
                                                    . "<td style='text-align: center; color:" . $color1 . "; font-weight: bolder;'>" . $row["deliveryStatus"] . "</td>"
                                                    . "<td>"
                                                    . "<a class='btn btn-info btn-block' href='delivery_details.php?id=" . $row["deliveryid"] . "'>"
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

        $('#deliverytable').DataTable({
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