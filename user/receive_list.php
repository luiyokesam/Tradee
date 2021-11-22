<?php
include '../include/header.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM delivery d, trade_details t, trade r, customer c WHERE r.tradeid = t.tradeid AND d.tradeid = r.tradeid AND d.tradeid = t.tradeid AND t.custid = c.custid AND d.senderid = c.custid AND deliveryid = '$id' LIMIT 1";
    $result = $dbc->query($sql);
    if ($result->num_rows > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $current_data = $row;
            $title = "Delivery Details - {$current_data['deliveryid']}";
            echo '<script>var current_data = ' . json_encode($current_data) . ';</script>';
            break;
        }
    } else {
        echo '<script>alert("Extract data fail !\nContact IT department for maintainence");</script>';
    }
}

$sql = "SELECT * FROM feedback ORDER BY feedbackid DESC LIMIT 1";
$result = $dbc->query($sql);
if ($result->num_rows > 0) {
    while ($row = mysqli_fetch_array($result)) {
        $latestnum = ((int) substr($row['feedbackid'], 1)) + 1;
        $newid = "F{$latestnum}";
        break;
    }
} else {
    $newid = "F10001";
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sql = "INSERT INTO feedback(feedbackid, custid, tradeid, enquirytype, email, comment, feedbackdate, status) VALUES ("
            . "'" . $newid . "',"
            . "'" . $_SESSION['loginuser']['custid'] . "',"
            . "'" . $current_data['tradeid'] . "',"
            . "'Shipping & Delivery',"
            . "'" . $_SESSION['loginuser']['email'] . "',"
            . "'" . $_POST["comment"] . "',"
            . "'" . $_POST["feedbackdate"] . "',"
            . "'Pending')";

    echo '<script>alert("' . $sql . '");</script>';

    if ($dbc->query($sql)) {
        echo '<script>alert("Thanks for your feedback. We will make a better arrangement for our service now.");window.location.href="trade_list.php";</script>';
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
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

        <title><?php echo $current_data['deliveryid'] ?> Delivery - Tradee</title>
    </head>
    <body>
        <div class="bg-navbar mb-3 bg-light">
            <div class="container-lg">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb py-2 mb-0">
                        <li class="breadcrumb-item"><a href="../user/trade_list.php">Trade list</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Delivery Details</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="container-lg">
            <!--            <div class="row">
                            <div class="col-auto">
                                <div style="font-weight: bold;">Delivery ID: <?php echo $current_data["deliveryid"] ?></div>
                            </div>
            
                                            <div class="col-4">
                                                <div>Estimated Receive Date : <?php echo $current_data["receiveDate"] ?> |</div>
                                            </div>
            
                            <div class="col-auto">
                                <div style="font-weight: bold;">Trade ID: <?php echo $current_data["tradeid"] ?></div>
                            </div>
                        </div>-->

            <div class="row mt-5">
                <div class="col">
                    <div class="stepper-wrapper">
                        <div class="stepper-item <?php
                        if ($current_data["deliveryStatus"] == "Pending") {
                            echo "active";
                        } else {
                            echo "completed";
                        }
                        ?>">
                            <div class="step-counter"><i class="fa fa-truck" style="font-size:25px;color:white"></i></div>
                            <div class="" style="font-weight: bold;">Pending</div>
                        </div>

                        <div class="stepper-item <?php
                        if ($current_data["deliveryStatus"] == "In Transit") {
                            echo "active";
                        } else {
                            if ($current_data["deliveryStatus"] == "Shipping" || $current_data["deliveryStatus"] == "Delivered") {
                                echo "completed";
                            }
                        }
                        ?>">
                            <div class="step-counter"><i class="material-icons" style="font-size:30px;color:white">compare_arrows</i></div>
                            <div class="" style="font-weight: bold;">In Transit</div>
                        </div>

                        <div class="stepper-item <?php
                        if ($current_data["deliveryStatus"] == "Shipping") {
                            echo "active";
                        } else {
                            if ($current_data["deliveryStatus"] == "Delivered") {
                                echo "completed";
                            }
                        }
                        ?>">
                            <div class="step-counter"><i class='fas fa-shipping-fast' style='font-size:25px;color:white'></i></div>
                            <div class="" style="font-weight: bold;">Shipping</div>
                        </div>

                        <div class="stepper-item <?php
                        if ($current_data["deliveryStatus"] == "Delivered") {
                            echo "completed";
                        }
                        ?>">
                            <div class="step-counter"><i class="fa fa-check" style="font-size:30px;color:white"></i></div>
                            <div class="" style="font-weight: bold;">Delivered</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-5">
                <div class="col pt-3">
                    <div class="text-center px-4">Your driver is on-the-way to pick up your items</div>
                </div>

                <div class="col pt-3">
                    <div class="text-center px-4">Your items has been pickup and ready for delivery</div>
                </div>

                <div class="col pt-3">
                    <div class="text-center px-4"> Your package is being shipped to its final destination</div>
                </div>

                <div class="col pt-3">
                    <div class="text-center px-4"> The delivery has arrived at its final destination</div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="container">
                        <div class="card card-warning">
                            <div class="card-header">
                                <div class="card-title">Payment Details</div>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body pb-1">
                                <div class="row pb-2" style="font-weight: bolder;">
                                    <div class="col-xl">
                                        <div class="">Delivery ID: <?php echo $current_data['deliveryid'] ?></div>
                                    </div>

                                    <div class="col-xl">
                                        <div class="">Trade ID: <?php echo $current_data['tradeid'] ?></div>
                                    </div>
                                </div>

                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="table-info" style="width: auto">Fees</th>
                                            <th class="table-info" style="width: auto">Total (RM)</th>
                                        </tr>
                                    </thead>
                                    <tbody style="text-align: left">
                                        <tr>
                                            <td>Shipping fee</td>
                                            <td><?php
                                                $current_data['shippingfee'] = number_format($current_data['shippingfee'], 2, '.', '');
                                                echo $current_data['shippingfee'];
                                                ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Packaging fee</td>
                                            <td><?php
                                                $current_data['packagefee'] = number_format($current_data['packagefee'], 2, '.', '');
                                                echo $current_data['packagefee'];
                                                ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Sub Total</td>
                                            <td><?php
                                                $current_data['subTotal'] = number_format($current_data['subTotal'], 2, '.', '');
                                                echo $current_data['subTotal'];
                                                ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Tax (6%)</td>
                                            <td><?php
                                                $current_data['tax'] = number_format($current_data['tax'], 2, '.', '');
                                                echo $current_data['tax'];
                                                ?>
                                            </td>
                                        </tr>
                                        <tr style="font-weight: bolder;">
                                            <td>Total Amount</td>
                                            <td><?php
                                                $current_data['totalAmount'] = number_format($current_data['totalAmount'], 2, '.', '');
                                                echo $current_data['totalAmount'];
                                                ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="card card-olive collapsed-card">
                            <div class="card-header">
                                <div class="card-title" style="font-size:1.2em;">Delivery Summary</div>
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
                                        $get_inventory = "SELECT * FROM trade_details d, item i WHERE d.itemid = i.itemid AND d.custid <> '{$_SESSION['loginuser']['custid']}' AND d.tradeid = '{$current_data['tradeid']}'";
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
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <div class="card-title" style="font-size:1.2em;">Recipient details</div>
                            <!--                            <div class="card-tools">
                                                            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                                                <i class="fas fa-minus"></i>
                                                            </button>
                                                        </div>-->
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="cardno" class="form-label">Sender</label>
                                    <input type="text" class="form-control" value="<?php
                                    if (isset($current_data)) {
                                        echo $current_data["username"];
                                    }
                                    ?>" readonly="">
                                </div>

                                <div class="col-md-6">
                                    <label for="month" class="form-label">Delivery Package</label>
                                    <input type="text" class="form-control" value="<?php
                                    if (isset($current_data)) {
                                        echo $current_data["package"];
                                    }
                                    ?>" readonly="">
                                </div>

                                <div class="col-md-6 mt-3">
                                    <label for="year" class="form-label">Payment Date</label>
                                    <input type="text" class="form-control" value="<?php
                                    if (isset($current_data)) {
                                        echo $current_data["paymentDate"];
                                    }
                                    ?>" readonly="">
                                </div>

                                <div class="col-md-6 mt-3">
                                    <label for="year" class="form-label">Received Date</label>
                                    <input type="text" class="form-control" value="<?php
                                    if (isset($current_data)) {
                                        if (($current_data["receiveDate"]) !== '') {
                                            echo $current_data["receiveDate"];
                                        } else {
                                            echo "Delivering";
                                        }
                                    }
                                    ?>" readonly="">
                                </div>

                                <div class="col-md-12 pt-3">
                                    <label for="cardname" class="form-label">Sender Address</label>
                                    <textarea class="form-control" id="itemDescription" name="itemDescription" rows="3" readonly><?php
                                        if (isset($current_data)) {
                                            echo $current_data["senderAddress"];
                                        }
                                        ?></textarea>
                                </div>
                            </div>

                            <?php
                            if (isset($current_data)) {
                                if (($current_data['deliveryStatus'] !== 'Delivered')) {
                                    echo '<div class="col-12 mt-1">
                                <form method="post" id="form">
                                    <div class="row mb-2" style="display: none;">
                                        <label for="paymentDate" class="form-label">Feedback Date</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                            <input type="text" class="form-control" placeholder="dd/mm/yyyy" id="feedbackdate" maxlength="10" readOnly name="feedbackdate">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col mb-3">
                                            <div class="form-label py-2" style="font-weight: bold;" for="comment">Please write a short description if there are any problems:</div>
                                            <textarea class="form-control" id="comment" name="comment" required rows="4" minlength="50"></textarea>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-auto float-right">
                                            <button type="button" id="btnback" class="btn btn-dark float-right" onclick="back()">Back</button>
                                        </div>

                                        <div class="col-auto float-right">
                                            <button type="button" class="btn btn-primary float-right" onclick="feedback()">Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>';
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php include '../include/footer.php'; ?>
    </body>
    <script>
        function feedback() {
            var fullfill = true;
            var message = "";
            document.getElementById("comment").style.borderColor = "";

            if (!document.getElementById("comment").value || document.getElementById("comment").value === "") {
                document.getElementById("comment").style.borderColor = "red";
                message += "Please enter your comment for feedback!\n";
                fullfill = false;
            } else {
                if (document.getElementById("comment").value.length < 50) {
                    fulfill = false;
                    message += "Your comment must be atleast more than 50 words!\n";
                    document.getElementById("comment").style.borderColor = "red";
                }
            }

            if (fullfill) {
                if (confirm("Confirm to submit your feedback?")) {
                    document.getElementById("form").submit();
                }
            }
//            else {
//                alert("Please enter all required information for the delivery.\n" + message);
//            }
        }

        function back() {
            window.location.href = "../user/trade_list.php";
        }

        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0');
        var yyyy = today.getFullYear();
        document.getElementById("feedbackdate").value = dd + '/' + mm + '/' + yyyy;
    </script>
    <style>
        .item-img{
            width: 100px;
            height: 200px;
            object-fit: cover;
        }

        .stepper-wrapper {
            display: flex;
            justify-content: space-between;
        }

        .stepper-item {
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            flex: 1;
        }

        .stepper-item::before {
            position: absolute;
            content: "";
            border-bottom: 3px solid #ccc;
            width: 100%;
            top: 20px;
            left: -50%;
            z-index: 2;
        }

        .stepper-item::after {
            position: absolute;
            content: "";
            border-bottom: 3px solid #ccc;
            width: 100%;
            top: 20px;
            left: 50%;
            z-index: 2;
        }

        .stepper-item .step-counter {
            position: relative;
            z-index: 5;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 50px;
            height: 50px;
            border-radius: 30%;
            background: #ccc;
            margin-bottom: 6px;
        }

        .stepper-item.active {
            font-weight: bold;
        }

        .stepper-item.active .step-counter {
            background-color: #7cf279;
        }

        .stepper-item.completed .step-counter {
            background-color: #7cf279;
        }

        .stepper-item.completed::after {
            position: absolute;
            content: "";
            border-bottom: 2px solid #7cf279;
            width: 100%;
            top: 20px;
            left: 50%;
            z-index: 3;
        }

        .stepper-item:first-child::before {
            content: none;
        }

        .stepper-item:last-child::after {
            content: none;
        }
    </style>
</html>