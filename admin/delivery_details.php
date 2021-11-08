<?php
include 'navbar.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM delivery d, payment p WHERE deliveryid = '$id' AND d.tradeid = p.tradeid LIMIT 1";
    $result = $dbc->query($sql);
    if ($result->num_rows > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $current_data = $row;
            $title = "Delivery Details - {$current_data['deliveryid']}";
            echo '<script>var current_data = ' . json_encode($current_data) . ';</script>';
            break;
        }
    } else {
        echo '<script>alert("Extract data fail !\nContact IT department for maintainence");window.location.href = "delivery_list.php";</script>';
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_GET['id'])) {

        $sql = "UPDATE delivery SET "
                . "custType='" . $_POST['custType'] . "',"
                . "name='" . $_POST['name'] . "',"
                . "deliveryDate='" . $_POST['deliveryDate'] . "',"
                . "receiveDate='" . $_POST['receiveDate'] . "',"
                . "itemQuantity='" . $_POST['itemQuantity'] . "',"
                . "pickAddress='" . $_POST['pickAddress'] . "',"
                . "destinationAddress='" . $_POST['destinationAddress'] . "',"
                . "deliveryStatus='" . $_POST['deliveryStatus'] . "' "
                . "WHERE deliveryid ='" . $current_data['deliveryid'] . "'";

        if ($dbc->query($sql)) {
            echo '<script>alert("Successfuly update !");var currentURL = window.location.href;window.location.href = currentURL;</script>';
        } else {
            echo '<script>alert("Update fail !\nContact IT department for maintainence")</script>';
        }
    }
}
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Delivery Details - Tradee</title>
    </head>
    <body class="hold-transition sidebar-mini layout-fixed" onload="addnew()">
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h4 class="m-0 text-dark" style="font-weight: bold;"><?php echo $title; ?></h4>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item active"><a href="delivery_list.php">Delivery list</a></li>
                                <li class="breadcrumb-item">Delivery detail</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <section class="content">
                <div class="container-fluid">
                    <form id="form" method="post">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card card-primary" >
                                            <div class="card-header">
                                                <h3 class="card-title">Deliver Details</h3>
                                                <div class="card-tools" style="padding-top:10px">
                                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                                        <i class="fas fa-minus"></i>
                                                    </button>
                                                </div>
                                            </div>

                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Trade ID:</label>
                                                            <input class="form-control" id="tradeid" name="tradeid" readonly value="<?php
                                                            if (isset($current_data)) {
                                                                echo $current_data["tradeid"];
                                                            }
                                                            ?>">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Customer ID:</label>
                                                            <input class="form-control" id="custid" name="custid" readonly value="<?php
                                                            if (isset($current_data)) {
                                                                echo $current_data["custid"];
                                                            }
                                                            ?>">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <label>Name:</label>
                                                            <input class="form-control" id="name" name="name" readonly value="<?php
                                                            if (isset($current_data)) {
                                                                echo $current_data["name"];
                                                            }
                                                            ?>">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Item quantity:</label>
                                                            <input class="form-control" id="itemQuantity" name="itemQuantity" readonly value="<?php
                                                            if (isset($current_data)) {
                                                                echo $current_data["itemQuantity"];
                                                            }
                                                            ?>">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Delivery date:</label>
                                                            <input class="form-control" id="deliveryDate" name="deliveryDate" readonly value="<?php
                                                            if (isset($current_data)) {
                                                                echo $current_data["deliveryDate"];
                                                            }
                                                            ?>">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Receive Date:</label>
                                                            <input class="form-control" id="receiveDate" name="receiveDate" readonly value="<?php
                                                            if (isset($current_data)) {
                                                                echo $current_data["receiveDate"];
                                                            }
                                                            ?>">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>Pick address: </label>
                                                            <input class="form-control" id="pickAddress" name="pickAddress" readonly value="<?php
                                                            if (isset($current_data)) {
                                                                echo $current_data["pickAddress"];
                                                            }
                                                            ?>">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>Destination address:</label>
                                                            <input class="form-control" id="destinationAddress" name="destinationAddress" readonly value="<?php
                                                            if (isset($current_data)) {
                                                                echo $current_data["destinationAddress"];
                                                            }
                                                            ?>">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Delivery status:</label>
                                                            <select class="custom-select" id="deliveryStatus" name="deliveryStatus" disabled>
                                                                <option <?php
                                                                if (isset($current_data)) {
                                                                    if ($current_data["deliveryStatus"] === "Pick up") {
                                                                        echo "selected";
                                                                    }
                                                                }
                                                                ?> value="Picked">Picked</option>
                                                                <option <?php
                                                                if (isset($current_data)) {
                                                                    if ($current_data["deliveryStatus"] === "In Transit") {
                                                                        echo "selected";
                                                                    }
                                                                }
                                                                ?> value="In Transit">In Transit</option>
                                                                <option <?php
                                                                if (isset($current_data)) {
                                                                    if ($current_data["deliveryStatus"] === "Shipping") {
                                                                        echo "selected";
                                                                    }
                                                                }
                                                                ?> value="Shipping">Shipping</option>
                                                                <option <?php
                                                                if (isset($current_data)) {
                                                                    if ($current_data["deliveryStatus"] === "Delivered") {
                                                                        echo "selected";
                                                                    }
                                                                }
                                                                ?> value="Delivered">Delivered</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Customer type:</label>
                                                            <select class="custom-select" id="custType" name="custType" disabled>
                                                                <option <?php
                                                                if (isset($current_data)) {
                                                                    if ($current_data["custType"] === "Buyer") {
                                                                        echo "selected";
                                                                    }
                                                                }
                                                                ?> value="Buyer">Buyer</option>
                                                                <option <?php
                                                                if (isset($current_data)) {
                                                                    if ($current_data["custType"] === "Seller") {
                                                                        echo "selected";
                                                                    }
                                                                }
                                                                ?> value="Seller">Seller</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card card-warning">
                                            <div class="card-header">
                                                <h3 class="card-title" >Transaction Details</h3>
                                                <div class="card-tools" style="padding-top:10px">
                                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                                        <i class="fas fa-minus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <table id="orderlisttable" class="table table-bordered table-striped">
                                                    <tbody>
                                                        <tr>
                                                            <td style="width: 30%;text-align: right">Payment Type :</td>
                                                            <td><?php
                                                                if (isset($current_data)) {
                                                                    echo $current_data["paytype"];
                                                                }
                                                                ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width: 30%;text-align: right">Card Number :</td>
                                                            <td><?php
                                                                if (isset($current_data)) {
                                                                    echo $current_data["cardname"];
                                                                }
                                                                ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width: 30%;text-align: right">Card Number :</td>
                                                            <td><?php
                                                                if (isset($current_data)) {
                                                                    echo $current_data["cardno"];
                                                                }
                                                                ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width: 30%;text-align: right">Package :</td>
                                                            <td><?php
                                                                if (isset($current_data)) {
                                                                    echo $current_data["package"];
                                                                }
                                                                ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width: 30%;text-align: right">Tax(RM) :</td>
                                                            <td><?php
                                                                if (isset($current_data)) {
                                                                    echo $current_data["tax"];
                                                                }
                                                                ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width: 30%;text-align: right">Total Amount (RM) :</td>
                                                            <td><?php
                                                                if (isset($current_data)) {
                                                                    echo $current_data["total"];
                                                                }
                                                                ?>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td style="width: 30%;text-align: right">Card Name :</td>
                                                            <td><?php
                                                                if (isset($current_data)) {
                                                                    echo $current_data["paymentdate"];
                                                                }
                                                                ?>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="row float-md-right">
                                            <div class="col-md-auto">
                                                <button type="button" class="btn btn-danger" onclick="cancel()" id="btncancel" disabled>Cancel</button>
                                            </div>
                                            <div class="col-md-auto">
                                                <button type="button" class="btn btn-warning" style="color: whitesmoke;" onclick="editorsave()" id="btnsave">Edit</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
        </div>
        <?php include 'footer.php'; ?>
    </body>
    <script>
        var currentURL = window.location.href;
        var isnew = false;

        function editorsave() {
            if (document.getElementById("btnsave").textContent === "Save") {
                var fullfill = true;
                var message = "";
                document.getElementById("name").style.borderColor = "";
                document.getElementById("itemQuantity").style.borderColor = "";
                document.getElementById("deliveryDate").style.borderColor = "";
                document.getElementById("receiveDate").style.borderColor = "";
                document.getElementById("pickAddress").style.borderColor = "";
                document.getElementById("destinationAddress").style.borderColor = "";
                document.getElementById("deliveryStatus").style.borderColor = "";
                document.getElementById("custType").style.borderColor = "";

                if (!document.getElementById("name").value || document.getElementById("name").value === "") {
                    document.getElementById("name").style.borderColor = "red";
                    fullfill = false;
                }
                if (!document.getElementById("deliveryDate").value || document.getElementById("deliveryDate").value === "") {
                    document.getElementById("deliveryDate").style.borderColor = "red";
                    fullfill = false;
                }
                if (!document.getElementById("receiveDate").value || document.getElementById("receiveDate").value === "") {
                    document.getElementById("receiveDate").style.borderColor = "red";
                    fullfill = false;
                }
                if (!document.getElementById("itemQuantity").value || document.getElementById("itemQuantity").value === "") {
                    document.getElementById("itemQuantity").style.borderColor = "red";
                    fullfill = false;
                }
                if (!document.getElementById("pickAddress").value || document.getElementById("pickAddress").value === "") {
                    document.getElementById("pickAddress").style.borderColor = "red";
                    fullfill = false;
                }
                if (!document.getElementById("destinationAddress").value || document.getElementById("destinationAddress").value === "") {
                    document.getElementById("destinationAddress").style.borderColor = "red";
                    fullfill = false;
                }
                if (!document.getElementById("deliveryStatus").value || document.getElementById("deliveryStatus").value === "") {
                    document.getElementById("deliveryStatus").style.borderColor = "red";
                    fullfill = false;
                }
                if (!document.getElementById("custType").value || document.getElementById("custType").value === "") {
                    document.getElementById("custType").style.borderColor = "red";
                    fullfill = false;
                }

                if (fullfill) {
                    if (confirm("Confirm to save ?")) {
                        document.getElementById("tradeid").disabled = false;
                        document.getElementById("custid").disabled = false;
                        document.getElementById("name").disabled = false;
                        document.getElementById("deliveryDate").disabled = false;
                        document.getElementById("receiveDate").disabled = false;
                        document.getElementById("itemQuantity").disabled = false;
                        document.getElementById("pickAddress").disabled = false;
                        document.getElementById("destinationAddress").disabled = false;
                        document.getElementById("deliveryStatus").disabled = false;
                        document.getElementById("custType").disabled = false;
                        document.getElementById("form").submit();
                    }
                } else {
                    alert("Inputs with red border are required field !\n" + message);
                }
            } else {
                editable();
            }
        }

        function cancel() {
            if (isnew) {
                if (confirm("Confirm to cancel insert new delivery and redirect to delivery list ?\n")) {
                    window.location.href = "delivery_list.php";
                }
            } else {
                if (confirm("Confirm to unsave current information ?")) {
                    window.location.href = currentURL;
                }
            }
        }

        function editable() {
            document.getElementById("btnsave").textContent = "Save";
            document.getElementById("btncancel").disabled = false;
            document.getElementById("name").readOnly = false;
            document.getElementById("deliveryDate").readOnly = false;
            document.getElementById("receiveDate").readOnly = false;
            document.getElementById("itemQuantity").readOnly = false;
            document.getElementById("pickAddress").readOnly = false;
            document.getElementById("destinationAddress").readOnly = false;
            document.getElementById("deliveryStatus").disabled = false;
            document.getElementById("custType").disabled = false;
        }
    </script>
</html>