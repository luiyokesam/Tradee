<?php
include '../include/header.php';

if (!isset($_SESSION["donation_details"])) {
    echo '<script>alert("You have not input your details at shipping.\nRedirect to home page.");window.location.href = "../php/index.php";</script>';
    exit();
}

if ((isset($_GET['eventid'])) && (isset($_GET['donateid']))) {
    $eventid = $_GET['eventid'];
    $donateid = $_GET['donateid'];
    $sql = "SELECT * FROM event e WHERE e.eventid = '$eventid' LIMIT 1";
    $result = $dbc->query($sql);
    if ($result->num_rows > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $current_data = $row;
            echo '<script>var current_data = ' . json_encode($current_data) . ';</script>';

            if ($_SESSION['donation_details']['deliveryCountry'] !== $_SESSION['loginuser']['country']) {
                if ($_SESSION['donation_details']['deliveryState'] !== $_SESSION['loginuser']['state']) {
                    $shipping_fee = $shipping_fee + 10;
                }
                $shipping_fee = $shipping_fee + 20;

                $shipping_fee = number_format($shipping_fee, 2, '.', '');
            } else {
                $shipping_fee = 10;
                $shipping_fee = number_format($shipping_fee, 2, '.', '');
            }

            if ($_SESSION['donation_details']['packaging'] == 'Plastic boxes') {
                $packaging_fee = 5;
            } else if ($_SESSION['donation_details']['packaging'] == 'Bubble wrap') {
                $packaging_fee = 8;
            } else if ($_SESSION['donation_details']['packaging'] == 'Seal boxes with tape') {
                $packaging_fee = 10;
            }
            $packaging_fee = number_format($packaging_fee, 2, '.', '');

            $subtotal = number_format($packaging_fee + $shipping_fee, 2, '.', '');
            $tax = number_format($subtotal * 0.06, 2, '.', '');
            $totalamount = number_format($subtotal + $tax, 2, '.', '');

            break;
        }
    } else {
//        echo '<script>alert("Extract data fail !\nContact IT department for maintainence")</script>';
        echo '<script>alert("Extract data fail !\nContact IT department for maintainence");window.location.href = "../user/my_profile.php";</script>';
    }
}

//$sql_donation = "SELECT * FROM donation ORDER BY donateid  DESC LIMIT 1";
//$result_donation = $dbc->query($sql_donation);
//if ($result_donation->num_rows > 0) {
//    while ($row = mysqli_fetch_array($result_donation)) {
//        $latestdonation = ((int) substr($row['donateid '], 1)) + 1;
//        $newdonation = "DO{$latestdonation}";
//        echo '<script>var current_data = null;</script>';
//        break;
//    }
//} else {
//    $newdonation = "DO10001";
//    echo '<script>var current_data = null;</script>';
//}

$sql_delivery = "SELECT * FROM donation_delivery ORDER BY donatedeliveryid  DESC LIMIT 1";
$result_delivery = $dbc->query($sql_delivery);
if ($result_delivery->num_rows > 0) {
    while ($row = mysqli_fetch_array($result_delivery)) {
        $latestdelivery = ((int) substr($row['donatedeliveryid '], 1)) + 1;
        $newdelivery = "DD{$latestdelivery}";
        echo '<script>var current_data = null;</script>';
        break;
    }
} else {
    $newdelivery = "DD10001";
    echo '<script>var current_data = null;</script>';
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sql_donation = "INSERT INTO donation(donateid, eventid, donator, donateDate) VALUES ("
            . "'" . $newdonation . "',"
            . "'" . $_SESSION['donation_details']['eventid'] . "',"
            . "'" . $_SESSION['loginuser']['custid'] . "',"
            . "'" . $_SESSION['donation_details']['donationDate'] . "')";

    foreach ($_SESSION['donation_details']['myitem'] as $myitem) {
        $sql_donationdetails = "INSERT INTO donation_details(donateid, eventid, itemid, donateDate) VALUES ("
                . "'" . $newdonation . "',"
                . "'" . $_SESSION['donation_details']['eventid'] . "',"
                . "'" . $myitem . "',"
                . "'" . $_SESSION['donation_details']['donationDate'] . "')"
                . "'Pending')";

        $dbc->query($sql_mytrade);

        echo '<script>alert("' . $myitem . '");</script>';
    }

//     <a href="https://wa.me/601111932585" target="_blank">


    $sql2 = "INSERT INTO donation_delivery(deliveryid, tradeid, senderid, recipientid, username, senderAddress, recipientAddress, itemQuantity, package, remarks, cardno, cardname, shippingfee, packagefee, subTotal, tax, totalAmount, paymentDate, deliveryStatus) VALUES ("
            . "'" . $newid . "',"
            . "'" . $_SESSION['donation_details']['tradeid'] . "',"
            . "'" . $_SESSION['loginuser']['custid'] . "',"
            . "'" . $_SESSION['donation_details']['recipientid'] . "',"
            . "'" . $_SESSION['donation_details']['username'] . "',"
            . "'" . $_SESSION['donation_details']['address1'] . "',"
            . "'" . $_SESSION['donation_details']['deliveryCountry'] . "',"
            . $_SESSION['donation_details']['itemQuantity'] . ","
            . "'" . $_SESSION['donation_details']['packaging'] . "',"
            . "'" . $_SESSION['donation_details']['remarks'] . "',"
            . "'" . $_POST["cardno"] . "',"
            . "'" . $_POST["cardname"] . "',"
            . $_POST["shippingfee"] . ","
            . $_POST["packagingfee"] . ","
            . $_POST["subTotal"] . ","
            . $_POST["tax"] . ","
            . $_POST["totalAmount"] . ","
            . "'" . $_POST["paymentDate"] . "',"
            . "'Pending')";

    echo '<script>alert("' . $sql . '");</script>';

    if ($dbc->query($sql)) {
        $sql = "UPDATE trade SET"
                . " offerPayment = 'Completed'"
                . " WHERE tradeid ='" . $_SESSION['donation_details']['tradeid'] . "'";
        if ($dbc->query($sql)) {
            echo '<script>alert("Successfuly insert!");window.location.href="trade_list.php";</script>';
        } else {
            echo '<script>alert("Insert fail!\nContact IT department for maintainence")</script>';
        }
    } else {
        echo '<script>alert("Insert fail!\nContact IT department for maintainence")</script>';
    }
}
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php
            echo "{$_SESSION['donation_details']['donateid']}";
//            if (isset($current_data)) {
//                echo $current_data["paymentid"];
//            } else {
//                echo $newid;
//            }
            ?> Donation Delivery - Tradee</title>
    </head>
    <body>
        <div class="bg-navbar mb-3 bg-light">
            <div class="container-lg">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb py-2 mb-0">
                        <li class="breadcrumb-item"><a href="#">Donation</a></li>
                        <li class="breadcrumb-item"><a href="#">Shipping</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Payment</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="container-lg">
            <form method="post" id="form">
                <div class="row justify-content-center">
                    <div class="col-md-5">
                        <div class="row">
                            <div class="container">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="" style="font-size:1.2em;">Payment details</div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <label for="cardno" class="form-label">Card number</label>
                                            <input type="text" class="form-control" id="cardno" name="cardno" onkeypress="return isNumberKey(event)" maxlength="16" required>
                                            <div class="invalid-feedback">
                                                Please provide a valid card number.
                                            </div>

                                            <div class="col-md-8 pt-3">
                                                <label for="cardname" class="form-label">Cardholder's name</label>
                                                <input type="text" class="form-control" id="cardname" name="cardname" required>
                                                <div class="invalid-feedback">
                                                    Please provide your card name.
                                                </div>
                                            </div>

                                            <div class="col-md-4 pt-3">
                                                <label for="cvv" class="form-label">CVV Code</label>
                                                <input type="text" class="form-control" id="cvv" name="cvv" onkeypress="return isNumberKey(event)" maxlength="3" required>
                                                <div class="invalid-feedback">
                                                    Please provide a valid CVV code.
                                                </div>
                                            </div>

                                            <div class="col-md-6 pt-3">
                                                <label for="month" class="form-label">Expired Month</label>
                                                <input type="text" class="form-control" placeholder="MM" maxlength="2" id="month" name="month" onkeypress="return isNumberKey(event)" required>
                                                <div class="invalid-feedback">
                                                    Please provide a valid city.
                                                </div>
                                            </div>

                                            <div class="col-md-6 pt-3">
                                                <label for="year" class="form-label">Expired Year</label>
                                                <input type="text" class="form-control" placeholder="YYYY" maxlength="4" id="year" name="year" onkeypress="return isNumberKey(event)" required>
                                                <div class="invalid-feedback">
                                                    Please provide a valid year.
                                                </div>
                                            </div>

                                            <div class="row m-0 p-3">
                                                <label for="paymentDate" class="form-label">Payment Date</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control" placeholder="dd/mm/yyyy" id="paymentDate" maxlength="10" readOnly name="paymentDate">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row py-3">
                                    <div class="col-auto mb-2">
                                        <a class="btn btn-warning btn-block" href="../user/event_shipping.php?eventid=<?php echo $eventid ?>&donateid=<?php echo $donateid ?>" id="btnback">Back</a>
                                    </div>

                                    <div class="col-auto">
                                        <button class="btn btn-primary btn-block" type="submit" onclick="payment()">Confirm payment</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-5">
                        <div class="row">
                            <div class="container-lg">
                                <div class="card collapsed-card">
                                    <div class="card-header">
                                        <div class="card-title">Delivery Summary</div>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body pb-0">
                                        <div class="row">
                                            <div class="col-12" id="accordion">
                                                <?php
                                                foreach ($_SESSION['donation_details']['myitem'] as $myitem) {
                                                    $get_inventory = "SELECT * FROM item i WHERE i.itemid = '$myitem'";
                                                    $result = $dbc->query($get_inventory);
                                                    if ($result->num_rows > 0) {
                                                        while ($row = mysqli_fetch_array($result)) {
                                                            echo "<div class='card card-primary card-outline'>"
                                                            . "<a class='d-block w-100' data-toggle='collapse' href='#" . $row["itemid"] . "' aria-expanded='true'>"
                                                            . "<div class='card-header'>"
                                                            . "<div class='card-title w-100'>" . $row["itemname"] . "</div>"
                                                            . "</div>"
                                                            . "</a>"
                                                            . "<div id='" . $row["itemid"] . "' class='collapse' data-parent='#accordion'>"
                                                            . "<div class='card-body'>"
                                                            . "<img src='../data/item_img/" . $row['itemid'] . "_0' class='img-fluid item-img' alt='...'>"
                                                            . "</div>"
//                                                    . "<div class='float-left' style='color:#969696;'>" . $row["itemCondition"] . "</div>"
//                                                    . "<div class='' style='color:#969696;'>" . $row["brand"] . "</div>"
                                                            . "</div>"
                                                            . "</div>";
                                                        }
                                                    }
                                                }
                                                ?>

                                                <!--card sameple-->
                                                <!--                                                <div class="card card-primary card-outline">
                                                                                                    <a class="d-block w-100" data-toggle="collapse" href="#collapseOne" aria-expanded="true">
                                                                                                        <div class="card-header">
                                                                                                            <h6 class="card-title w-75">Item #1</h6>
                                                                                                        </div>
                                                                                                    </a>
                                                                                                    <div id="collapseOne" class="collapse" data-parent="#accordion" style="">
                                                                                                        <div class="card-body">
                                                                                                            <img src="../img/test-shirt/test-shirt-1.jpg" class="img-fluid item-pic" alt="Profile picture">
                                                                                                        </div>
                                                                                                        <div>Hi</div>
                                                                                                    </div>
                                                                                                </div>-->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="container">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="" style="font-size:1.2em;">Checkout</div>
                                    </div>
                                    <div class="card-body pb-1">
                                        <div class="row pb-2" style="font-weight: bolder;">
                                            <div class="col-xl">
                                                <div class="">Donate to: <?php
                                                    $count = "SELECT receiver FROM event WHERE eventid = '{$_SESSION['donation_details']['eventid']}'";
                                                    $result = $dbc->query($count);
                                                    if ($result->num_rows > 0) {
                                                        while ($row = mysqli_fetch_array($result)) {
                                                            echo $row['receiver'];
                                                        }
                                                    }
                                                    ?>
                                                </div>
                                            </div>

                                            <!--                                            <div class="col-xl">
                                                                                            <div class="">Items: <?php
                                            $count = "SELECT COUNT(t.itemid) itemQuantity FROM trade_details t, customer c WHERE t.custid = c.custid AND c.custid = '{$_SESSION['loginuser']['custid']}' AND t.tradeid = '{$current_data['tradeid']}'";
                                            $result = $dbc->query($count);
                                            if ($result->num_rows > 0) {
                                                while ($row = mysqli_fetch_array($result)) {
                                                    echo $row['itemQuantity'];
                                                }
                                            }
                                            ?>
                                                                                            </div>
                                                                                        </div>-->

                                            <!--                                            <div class="col-xl">
                                                                                            <div class="">Items: <?php
                                            foreach ($_SESSION['donation_details']['myitem'] as $myitems) {
                                                $count = "SELECT COUNT($myitems) itemQuantity FROM trade_details t, customer c WHERE t.custid = c.custid AND c.custid = '{$_SESSION['loginuser']['custid']}' AND t.tradeid = '{$current_data['tradeid']}'";
                                                $dbc->query($count);
                                                echo $count;
                                                echo '<script>alert("' . $sql . '");</script>';
                                            }
                                            ?>
                                                                                            </div>
                                                                                        </div>-->
                                        </div>

                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col" class="table-info">Fees</th>
                                                    <th scope="col" class="table-info">Total (RM)</th>
                                                </tr>
                                            </thead>
                                            <tbody style="text-align: left">
                                                <tr>
                                                    <td>Shipping fee</td>
                                                    <td><?php echo $shipping_fee; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Packaging fee</td>
                                                    <td><?php echo $packaging_fee; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Sub Total</td>
                                                    <td><?php echo $subtotal; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Tax (6%)</td>
                                                    <td><?php echo $tax; ?></td>
                                                </tr>
                                                <tr style="font-weight: bolder;">
                                                    <td>Total Amount</td>
                                                    <td><?php echo $totalamount; ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--                    <div class="col-md-3">
                                            <div class="row">
                                                <div class="container-lg">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <div class="" style="font-size:1.2em;">Delivery Summary</div>
                                                        </div>
                                                        <div class="card-body pb-0">
                                                            <div class="row">
                                                                <div class="col-12" id="accordion">
                    <?php
                    foreach ($_SESSION['donation_details']['myitem'] as $myitem) {
                        $get_inventory = "SELECT * FROM item i WHERE i.itemid = '$myitem'";
                        $result = $dbc->query($get_inventory);
                        if ($result->num_rows > 0) {
                            while ($row = mysqli_fetch_array($result)) {
                                echo "<div class='card card-primary card-outline'>"
                                . "<a class='d-block w-100' data-toggle='collapse' href='#" . $row["itemid"] . "' aria-expanded='true'>"
                                . "<div class='card-header'>"
                                . "<div class='card-title w-100'>" . $row["itemname"] . "</div>"
                                . "</div>"
                                . "</a>"
                                . "<div id='" . $row["itemid"] . "' class='collapse' data-parent='#accordion'>"
                                . "<div class='card-body'>"
                                . "<img src='../data/item_img/" . $row['itemid'] . "_0' class='img-fluid item-img' alt='...'>"
                                . "</div>"
//                                                    . "<div class='float-left' style='color:#969696;'>" . $row["itemCondition"] . "</div>"
//                                                    . "<div class='' style='color:#969696;'>" . $row["brand"] . "</div>"
                                . "</div>"
                                . "</div>";
                            }
                        }
                    }
                    ?>
                    
                                                                    card sameple
                                                                                                                    <div class="card card-primary card-outline">
                                                                                                                        <a class="d-block w-100" data-toggle="collapse" href="#collapseOne" aria-expanded="true">
                                                                                                                            <div class="card-header">
                                                                                                                                <h6 class="card-title w-75">Item #1</h6>
                                                                                                                            </div>
                                                                                                                        </a>
                                                                                                                        <div id="collapseOne" class="collapse" data-parent="#accordion" style="">
                                                                                                                            <div class="card-body">
                                                                                                                                <img src="../img/test-shirt/test-shirt-1.jpg" class="img-fluid item-pic" alt="Profile picture">
                                                                                                                            </div>
                                                                                                                            <div>Hi</div>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>-->
                </div>
            </form>
        </div>
        <?php include '../include/footer.php'; ?>
    </body>
    <script>
        function payment() {
            var fulfill = true;
            var message = "";
            var pattern = /^\d+$/;

            document.getElementById("cardno").style.borderColor = "";
            document.getElementById("cardname").style.borderColor = "";
            document.getElementById("cvv").style.borderColor = "";
            document.getElementById("month").style.borderColor = "";
            document.getElementById("year").style.borderColor = "";

            if (!document.getElementById("cardno").value || document.getElementById("cardno").value === "") {
                fulfill = false;
                message = "Card number is required field !\n";
                document.getElementById("cardno").style.borderColor = "red";
            } else {
                if (document.getElementById("cardno").value.length < 16 || !pattern.test(document.getElementById("cardno").value)) {
                    fulfill = false;
                    message = "Card number is invalid, 16 digit is required !\n";
                    document.getElementById("cardno").style.borderColor = "red";
                }
            }

            if (!document.getElementById("year").value || document.getElementById("year").value === "") {
                fulfill = false;
                message += "Expired year is required field !\n";
                document.getElementById("year").style.borderColor = "red";
            } else {
                if (document.getElementById("year").value.length < 4 || !pattern.test(document.getElementById("year").value)) {
                    fulfill = false;
                    message += "Expired year is invalid , Example : 2020 !\n";
                    document.getElementById("year").style.borderColor = "red";
                }
            }

            if (!document.getElementById("month").value || document.getElementById("month").value === "") {
                fulfill = false;
                message += "Expired month is required field !\n";
                document.getElementById("month").style.borderColor = "red";
            } else {
                if (document.getElementById("month").value < 2 || !pattern.test(document.getElementById("month").value)) {
                    fulfill = false;
                    message += "Expired month is invalid, Example: 03!\n";
                    document.getElementById("month").style.borderColor = "red";
                }
            }

            if (!document.getElementById("cvv").value || document.getElementById("cvv").value === "") {
                fulfill = false;
                message += "CVV code is required field !\n";
                document.getElementById("cvv").style.borderColor = "red";
            } else {
                if (document.getElementById("cvv").value < 3 || !pattern.test(document.getElementById("cvv").value)) {
                    fulfill = false;
                    message += "CVV code is invalid!\n";
                    document.getElementById("cvv").style.borderColor = "red";
                }
            }

            if (!document.getElementById("cardname").value || document.getElementById("cardname").value === "") {
                fulfill = false;
                message += "Card holder name is required field !\n";
                document.getElementById("cardname").style.borderColor = "red";
            }

            if (fulfill) {
                if (confirm("Confirm to process payment ?")) {
                    document.getElementById("form").submit();
                }
            } else {
                alert(message);
            }
        }

        function isNumberKey(evt) {
            var charCode = (evt.which) ? evt.which : event.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57))
                return false;
            return true;
        }

        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0');
        var yyyy = today.getFullYear();
        document.getElementById("paymentDate").value = dd + '/' + mm + '/' + yyyy;
    </script>
</html>