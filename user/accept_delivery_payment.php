<?php
include '../include/header.php';

if (!isset($_SESSION["delivery_details"])) {
    echo '<script>alert("You have not input your detail at check out/\nRedirect to Check out");window.location.href = "checkout.php";</script>';
    exit();
}
//else {
//    $sql = "SELECT * FROM trade t, trade_details d, item i WHERE t.tradeid = d.tradeid AND d.itemid = i.itemid AND d.custid = '" . $_SESSION['loginuser']['custid'] . "' AND d.tradeid = '{$_SESSION['delivery_details']['tradeid']}' LIMIT 1";
//    $result = $dbc->query($sql);
//}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM trade t, trade_details d, item i WHERE t.tradeid = d.tradeid AND d.itemid = i.itemid AND d.custid = '" . $_SESSION['loginuser']['custid'] . "' AND d.tradeid = '$id' LIMIT 1";
    $result = $dbc->query($sql);
    if ($result->num_rows > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $current_data = $row;
            echo '<script>var current_data = ' . json_encode($current_data) . ';</script>';
            break;
        }
    } else {
        echo '<script>alert("Extract data fail!\nContact IT department for maintainence");window.location.href = "../user/trade_list.php";</script>';
    }
}

$sql = "SELECT * FROM delivery ORDER BY deliveryid DESC LIMIT 1";
$result = $dbc->query($sql);
if ($result->num_rows > 0) {
    while ($row = mysqli_fetch_array($result)) {
        $latestnum = ((int) substr($row['deliveryid'], 1)) + 1;
        $newid = "D{$latestnum}";
        echo '<script>var current_data = null;</script>';
        break;
    }
} else {
    $newid = "D10001";
    echo '<script>var current_data = null;</script>';
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $address = "{$_SESSION['delivery_details']['address1']}, {$_SESSION['delivery_details']['address2']}, {$_SESSION['delivery_details']['city']}, {$_SESSION['delivery_details']['postcode']}, {$_SESSION['delivery_details']['state']}, {$_SESSION['delivery_details']['country']}";
    $destination = "{$_SESSION['delivery_details']['deliveryaddress1']}, {$_SESSION['delivery_details']['deliveryaddress2']}, {$_SESSION['delivery_details']['deliverycity']}, {$_SESSION['delivery_details']['deliverypostcode']}, {$_SESSION['delivery_details']['deliverystate']}, {$_SESSION['delivery_details']['deliverycountry']}";
    $sql = "INSERT INTO delivery(deliveryid, tradeid, senderid, recipientid, username, senderAddress, recipientAddress, itemQuantity, package, remarks, cardno, cardname, shippingfee, packagefee, subTotal, tax, totalAmount, paymentDate, deliveryStatus) VALUES ("
            . "'" . $newid . "',"
            . "'" . $_SESSION['delivery_details']['tradeid'] . "',"
            . "'" . $_SESSION['loginuser']['custid'] . "',"
            . "'" . $_SESSION['delivery_details']['recipientid'] . "',"
            . "'" . $_SESSION['delivery_details']['username'] . "',"
            . "'" . $address . "',"
            . "'" . $destination . "',"
            . $_SESSION['delivery_details']['itemQuantity'] . ","
            . "'" . $_SESSION['delivery_details']['packaging'] . "',"
            . "'" . $_SESSION['delivery_details']['remarks'] . "',"
            . "'" . $_POST["cardno"] . "',"
            . "'" . $_POST["cardname"] . "',"
            . $_POST["shippingfee"] . ","
            . $_POST["packagingfee"] . ","
            . $_POST["subTotal"] . ","
            . $_POST["tax"] . ","
            . $_POST["totalAmount"] . ","
            . "'" . $_POST["paymentDate"] . "',"
            . "'Pending')";

//    echo '<script>alert("' . $sql . '");</script>';

    if ($dbc->query($sql)) {
        $sql = "UPDATE trade SET"
                . " acceptPayment = 'Completed'"
                . " WHERE tradeid ='" . $_SESSION['delivery_details']['tradeid'] . "'";

        if ($dbc->query($sql)) {
            $sql_status = "SELECT * FROM trade WHERE offerPayment = 'Completed' AND tradeid = '" . $_SESSION['delivery_details']['tradeid'] . "'";
            $result = $dbc->query($sql_status);
            if ($result->num_rows > 0) {
//                while ($row = mysqli_fetch_array($result)) {
                    $sql_update = "UPDATE trade SET"
                            . " status = 'To Ship'"
                            . " WHERE tradeid ='" . $_SESSION['delivery_details']['tradeid'] . "'";
                    $result = $dbc->query($sql_update);
//                }
            }
            echo '<script>alert("Your trade payment has completed. Our delivery courier will be coming soon. Thank you.");window.location.href="trade_list.php";</script>';
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
            echo $newid;
//            if (isset($current_data)) {
//                echo $current_data["paymentid"];
//            } else {
//                echo $newid;
//            }
            ?> Barter Delivery - Tradee</title>
    </head>
    <body>
        <div class="bg-navbar mb-3 bg-light">
            <div class="container-lg">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb py-2 mb-0">
                        <li class="breadcrumb-item"><a href="#">Trade List</a></li>
                        <li class="breadcrumb-item"><a href="#">Trade Offer</a></li>
                        <li class="breadcrumb-item"><a href="#">Shipping</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Payment</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="container-lg mb-5">
            <form method="post" id="form">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="container">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="" style="font-size:1.2em;">Payment details</div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label for="cardno" class="form-label">Card number</label>
                                                <input type="text" class="form-control" id="cardno" name="cardno" onkeypress="return isNumberKey(event)" maxlength="16" required>
                                                <div class="invalid-feedback">
                                                    Please provide a valid card number.
                                                </div>
                                            </div>

                                            <div class="col-md-8 mt-3">
                                                <label for="cardname" class="form-label">Cardholder's name</label>
                                                <input type="text" class="form-control" id="cardname" name="cardname" required>
                                                <div class="invalid-feedback">
                                                    Please provide your card name.
                                                </div>
                                            </div>

                                            <div class="col-md-4 mt-3">
                                                <label for="cvv" class="form-label">CVV Code</label>
                                                <input type="text" class="form-control" id="cvv" name="cvv" onkeypress="return isNumberKey(event)" maxlength="3" required>
                                                <div class="invalid-feedback">
                                                    Please provide a valid CVV code.
                                                </div>
                                            </div>

                                            <div class="col-md-6 mt-3">
                                                <label for="month" class="form-label">Expired Month</label>
                                                <input type="text" class="form-control" placeholder="MM" maxlength="2" id="month" name="month" onkeypress="return isNumberKey(event)" required>
                                                <div class="invalid-feedback">
                                                    Please provide a valid city.
                                                </div>
                                            </div>

                                            <div class="col-md-6 mt-3">
                                                <label for="year" class="form-label">Expired Year</label>
                                                <input type="text" class="form-control" placeholder="YYYY" maxlength="4" id="year" name="year" onkeypress="return isNumberKey(event)" required>
                                                <div class="invalid-feedback">
                                                    Please provide a valid year.
                                                </div>
                                            </div>

                                            <div class="col-md-6 mt-3">
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

                                <div class="row py-3 mb-5">
                                    <div class="col-auto mb-2">
                                        <a class="btn btn-warning btn-block" href="../user/accept_delivery_shipping.php?id=<?php echo $current_data['tradeid'] ?>" id="btnback">Back</a>
                                    </div>

                                    <div class="col-auto mb-2">
                                        <button class="btn btn-primary btn-block" type="button" onclick="payment()">Confirm payment</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-5">
                        <div class="row">
                            <div class="container">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="" style="font-size:1.2em;">Checkout</div>
                                    </div>
                                    <div class="card-body pb-1">
                                        <div class="row pb-2" style="font-weight: bolder;">
                                            <div class="col-xl">
                                                <div class="">Trade ID: <?php echo $_SESSION['delivery_details']['tradeid'] ?></div>
                                            </div>

                                            <div class="col-xl">
                                                <div class="">Items: <?php
                                                    $count = "SELECT COUNT(t.itemid) itemQuantity FROM trade_details t, customer c WHERE t.custid = c.custid AND c.custid = '{$_SESSION['loginuser']['custid']}' AND t.tradeid = '{$current_data['tradeid']}'";
                                                    $result = $dbc->query($count);
                                                    if ($result->num_rows > 0) {
                                                        while ($row = mysqli_fetch_array($result)) {
                                                            echo $row['itemQuantity'];
                                                        }
                                                    }
                                                    ?></div>
                                            </div>
                                        </div>

                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col" class="table-info">Fees</th>
                                                    <th scope="col" class="table-info">Total (RM)</th>
                                                </tr>
                                            </thead>
                                        </table>
                                        <div class="form-group row py-1 px-3 mb-1">
                                            <label class="col-sm-5 col-form-label border-bottom">Shipping Fee</label>
                                            <div class="col-md-7 border-bottom">
                                                <input type="text" class="form-control" id="shippingfee" name="shippingfee" required style="border-style: none;" value="<?php
                                                $shipping_fee = 0;
                                                if ($_SESSION['delivery_details']['deliverycountry'] !== $_SESSION['loginuser']['country']) {
                                                    if ($_SESSION['delivery_details']['deliverystate'] !== $_SESSION['loginuser']['state']) {
                                                        $shipping_fee = $shipping_fee + 10;
                                                    }
                                                    $shipping_fee = $shipping_fee + 15;

                                                    $shipping_fee = number_format($shipping_fee, 2, '.', '');
                                                    echo $shipping_fee;
                                                } else {
                                                    $shipping_fee = 5;
                                                    $shipping_fee = number_format($shipping_fee, 2, '.', '');
                                                    echo $shipping_fee;
                                                }
                                                ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row px-3 mb-1">
                                            <label class="col-sm-5 col-form-label border-bottom">Packaging Fee</label>
                                            <div class="col-md-7 border-bottom">
                                                <input type="text" class="form-control" id="packagingfee" name="packagingfee" required style="border-style: none;" value="<?php
                                                $packaging_fee = 0;
                                                if ($_SESSION['delivery_details']['packaging'] == 'Plastic boxes') {
                                                    $packaging_fee = 5;
                                                } else if ($_SESSION['delivery_details']['packaging'] == 'Bubble wrap') {
                                                    $packaging_fee = 8;
                                                } else if ($_SESSION['delivery_details']['packaging'] == 'Seal boxes with tape') {
                                                    $packaging_fee = 10;
                                                }
                                                $packaging_fee = number_format($packaging_fee, 2, '.', '');
                                                echo $packaging_fee;
                                                ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row px-3 mb-1">
                                            <label class="col-sm-5 col-form-label border-bottom">Sub Total</label>
                                            <div class="col-md-7 border-bottom">
                                                <input type="text" class="form-control" id="subTotal" name="subTotal" required style="border-style: none;" value="<?php
                                                $subtotal = 0;
                                                $subtotal = number_format($packaging_fee + $shipping_fee, 2, '.', '');
                                                echo $subtotal;
                                                ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row px-3 mb-1">
                                            <label class="col-sm-5 col-form-label border-bottom">Tax (6%)</label>
                                            <div class="col-md-7 border-bottom">
                                                <input type="text" class="form-control" id="tax" name="tax" required style="border-style: none;" value="<?php
                                                $tax = 0;
                                                $tax = number_format($subtotal * 0.06, 2, '.', '');
                                                echo $tax;
                                                ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row px-3 mb-0">
                                            <label class="col-sm-5 col-form-label">Total Amount</label>
                                            <div class="col-md-7">
                                                <input type="text" class="form-control" id="totalAmount" name="totalAmount" required style="border-style: none;" value="<?php
                                                       $totalamount = 0;
                                                       $totalamount = number_format($subtotal + $tax, 2, '.', '');
                                                       echo $totalamount;
                                                       ?>">
                                            </div>
                                        </div>

        <!--                                        <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col" class="table-info">Fees</th>
                                                            <th scope="col" class="table-info">Total (RM)</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody style="text-align: left">
                                                        <tr>
                                                            <td>Shipping fee</td>
                                                            <td>
                                        <?php $totalamount ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Packaging fee</td>
                                                            <td>
                                        <?php
                                        $packaging_fee = 0;
                                        if ($_SESSION['delivery_details']['packaging'] == 'Plastic boxes') {
                                            $packaging_fee = 5;
                                        } else if ($_SESSION['delivery_details']['packaging'] == 'Bubble wrap') {
                                            $packaging_fee = 8;
                                        } else if ($_SESSION['delivery_details']['packaging'] == 'Seal boxes with tape') {
                                            $packaging_fee = 10;
                                        }
                                        $packaging_fee = number_format($packaging_fee, 2, '.', '');
                                        echo $packaging_fee;
                                        ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Sub Total</td>
                                                            <td>
                                        <?php
                                        $subtotal = 0;
                                        $subtotal = number_format($packaging_fee + $shipping_fee, 2, '.', '');
                                        echo $subtotal;
                                        ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Tax (6%)</td>
                                                            <td>
                                        <?php
                                        $tax = 0;
                                        $tax = number_format($subtotal * 0.06, 2, '.', '');
                                        echo $tax;
                                        ?>
                                                            </td>
                                                        </tr>
                                                        <tr style="font-weight: bolder;">
                                                            <td>Total Amount</td>
                                                            <td>
                                        <?php
                                        $totalamount = 0;
                                        $totalamount = number_format($subtotal + $tax, 2, '.', '');
                                        echo $totalamount;
                                        ?>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
                message = "Card number is a required field.\n";
                document.getElementById("cardno").style.borderColor = "red";
            } else {
                if (document.getElementById("cardno").value.length < 16 || !pattern.test(document.getElementById("cardno").value)) {
                    fulfill = false;
                    message = "Card number is invalid, 16 digit is required.\n";
                    document.getElementById("cardno").style.borderColor = "red";
                }
            }

            if (!document.getElementById("year").value || document.getElementById("year").value === "") {
                fulfill = false;
                message += "Expired year is a required field.\n";
                document.getElementById("year").style.borderColor = "red";
            } else {
                if (document.getElementById("year").value.length < 4 || !pattern.test(document.getElementById("year").value)) {
                    fulfill = false;
                    message += "Expired year is invalid, example: 2020.\n";
                    document.getElementById("year").style.borderColor = "red";
                }
            }

            if (!document.getElementById("month").value || document.getElementById("month").value === "") {
                fulfill = false;
                message += "Expired month is required field.\n";
                document.getElementById("month").style.borderColor = "red";
            } else {
                if (document.getElementById("month").value < 2 || !pattern.test(document.getElementById("month").value)) {
                    fulfill = false;
                    message += "Expired month is invalid, example: 03.\n";
                    document.getElementById("month").style.borderColor = "red";
                }
            }

            if (!document.getElementById("cvv").value || document.getElementById("cvv").value === "") {
                fulfill = false;
                message += "CVV code is required field.\n";
                document.getElementById("cvv").style.borderColor = "red";
            } else {
                if (document.getElementById("cvv").value < 3 || !pattern.test(document.getElementById("cvv").value)) {
                    fulfill = false;
                    message += "CVV code is invalid.\n";
                    document.getElementById("cvv").style.borderColor = "red";
                }
            }

            if (!document.getElementById("cardname").value || document.getElementById("cardname").value === "") {
                fulfill = false;
                message += "Card holder name is required field.\n";
                document.getElementById("cardname").style.borderColor = "red";
            }

            if (fulfill) {
                if (confirm("Confirm to complete payment?")) {
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