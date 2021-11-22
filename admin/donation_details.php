<?php
$page = 'donation_list';
include 'navbar.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM donation_delivery d, donation_details t, event e WHERE d.eventid = e.eventid AND t.eventid = e.eventid AND d.donationid = t.donationid AND d.donationid = '$id' LIMIT 1";
    $result = $dbc->query($sql);
    if ($result->num_rows > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $current_data = $row;
            $title = "Delivery Details - {$current_data['donationid']}";
            echo '<script>var current_data = ' . json_encode($current_data) . ';</script>';
            break;
        }
    } else {
        echo '<script>alert("Extract data fail !\nContact IT department for maintainence");window.location.href = "donation_list.php";</script>';
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sql = "UPDATE donation_delivery SET "
            . "receiveDate='" . $_POST['receiveDate'] . "',"
            . "donatorAddress='" . $_POST['donatorAddress'] . "',"
            . "deliveryStatus='" . $_POST['deliveryStatus'] . "' "
            . "WHERE donationid ='" . $current_data['donationid'] . "'";

    if ($dbc->query($sql)) {
        echo '<script>alert("Delivery details has been updated.");var currentURL = window.location.href;window.location.href = currentURL;</script>';
    } else {
        echo '<script>alert("Update fail!\nContact IT department for maintainence")</script>';
    }
}
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Donation <?php echo $current_data['donationid'] ?> - Tradee</title>
    </head>
    <body class="hold-transition sidebar-mini layout-fixed">
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h4 class="m-0 text-dark" style="font-weight: bold;">Donation ID: <?php
                                if (isset($current_data)) {
                                    echo $current_data["donationid"];
                                }
                                ?></h4>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item active"><a href="donation_list.php">Donation list</a></li>
                                <li class="breadcrumb-item">Donation details</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <section class="content">
                <div class="container-fluid">
                    <form id="form" method="post">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card card-primary" >
                                            <div class="card-header">
                                                <h3 class="card-title">Delivery Details</h3>
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
                                                            <label>Event ID:</label>
                                                            <input class="form-control" id="eventid" name="eventid" readonly value="<?php
                                                            if (isset($current_data)) {
                                                                echo $current_data["eventid"];
                                                            }
                                                            ?>">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Username:</label>
                                                            <input class="form-control" id="custid" name="custid" readonly value="<?php
                                                            if (isset($current_data)) {
                                                                echo $current_data["custid"];
                                                            }
                                                            ?>">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Donator:</label>
                                                            <input class="form-control" id="donator" name="donator" readonly value="<?php
                                                            if (isset($current_data)) {
                                                                echo $current_data["donator"];
                                                            }
                                                            ?>">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Receiver:</label>
                                                            <input class="form-control" id="receiver" name="receiver" readonly value="<?php
                                                            if (isset($current_data)) {
                                                                echo $current_data["receiver"];
                                                            }
                                                            ?>">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Sender Address :</label>
                                                            <textarea class="form-control" id="donatorAddress" name="donatorAddress" rows="5" readonly value="" placeholder="Tell us more about yourself"><?php
                                                                if (isset($current_data)) {
                                                                    echo $current_data["donatorAddress"];
                                                                }
                                                                ?></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Remarks :</label>
                                                            <textarea class="form-control" id="remarks" name="remarks" rows="5" readonly value="" placeholder="Tell us more about yourself"><?php
                                                                if (isset($current_data)) {
                                                                    echo $current_data["remarks"];
                                                                }
                                                                ?></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Receive date:</label>
                                                            <div class="input-group date" id="reservationdatetime" data-target-input="nearest">
                                                                <div class="input-group-append" data-target="#reservationdatetime" data-toggle="datetimepicker">
                                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                                </div>
                                                                <input type="text" class="form-control datetimepicker-input" data-target="#reservationdatetime" value="<?php
                                                                if (isset($current_data)) {
                                                                    echo $current_data["receiveDate"];
                                                                }
                                                                ?>" readOnly name="receiveDate" id="receiveDate">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Delivery status:</label>
                                                            <select class="custom-select" id="deliveryStatus" name="deliveryStatus" disabled>
                                                                <option <?php
                                                                if (isset($current_data)) {
                                                                    if ($current_data["deliveryStatus"] === "Pending") {
                                                                        echo "selected";
                                                                    }
                                                                }
                                                                ?> value="Pick up">Pending</option>

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
                                                </div>
                                            </div>
                                        </div>

                                        <div class="card card-info collapsed-card">
                                            <div class="card-header">
                                                <h3 class="card-title" >Donation Summary</h3>
                                                <div class="card-tools" style="padding-top:10px">
                                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="card-body pb-0">
                                                <div class="row">
                                                    <div class="col-12" id="accordion">
                                                        <?php
                                                        $get_inventory = "SELECT * FROM donation_details d, item i WHERE d.itemid = i.itemid AND d.donationid = '{$current_data['donationid']}'";
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
                            </div>

                            <div class="col-lg-6">
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
                                                            <td style="width: 30%;text-align: right">Card Number :</td>
                                                            <td><?php
                                                                if (isset($current_data)) {
                                                                    echo $current_data["cardno"];
                                                                }
                                                                ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width: 30%;text-align: right">Card Name :</td>
                                                            <td><?php
                                                                if (isset($current_data)) {
                                                                    echo $current_data["cardname"];
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
                                                            <td style="width: 30%;text-align: right">Payment Date :</td>
                                                            <td><?php
                                                                if (isset($current_data)) {
                                                                    echo $current_data["paymentDate"];
                                                                }
                                                                ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width: 30%;text-align: right">Shipping Fee :</td>
                                                            <td><?php
                                                                if (isset($current_data)) {
                                                                    $current_data["shippingfee"] = number_format($current_data["shippingfee"], 2, '.', '');
                                                                    echo "RM  {$current_data["shippingfee"]}";
                                                                }
                                                                ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width: 30%;text-align: right">Package Fee :</td>
                                                            <td><?php
                                                                if (isset($current_data)) {
                                                                    $current_data["packagefee"] = number_format($current_data["packagefee"], 2, '.', '');
                                                                    echo "RM  {$current_data["packagefee"]}";
                                                                }
                                                                ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width: 30%;text-align: right">Sub Total :</td>
                                                            <td><?php
                                                                if (isset($current_data)) {
                                                                    $current_data["subTotal"] = number_format($current_data["subTotal"], 2, '.', '');
                                                                    echo "RM  {$current_data["subTotal"]}";
                                                                }
                                                                ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width: 30%;text-align: right">Tax :</td>
                                                            <td><?php
                                                                if (isset($current_data)) {
                                                                    $current_data["tax"] = number_format($current_data["tax"], 2, '.', '');
                                                                    echo "RM  {$current_data["tax"]}";
                                                                }
                                                                ?>
                                                            </td>
                                                        </tr>
                                                        <tr style="font-weight: bolder;">
                                                            <td style="width: 30%;text-align: right">Total Amount :</td>
                                                            <td><?php
                                                                if (isset($current_data)) {
                                                                    $current_data["totalAmount"] = number_format($current_data["totalAmount"], 2, '.', '');
                                                                    echo "RM  {$current_data["totalAmount"]}";
                                                                }
                                                                ?>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="col-auto float-left">
                                            <button type="button" id="btnback" class="btn btn-dark" onclick="back()">Back</button>
                                        </div>

                                        <div class="col-auto float-right">
                                            <button type="button" class="btn btn-danger" onclick="cancel()" id="btncancel" disabled>Cancel</button>
                                        </div>
                                        <div class="col-auto float-right">
                                            <button type="button" class="btn btn-warning" style="color: whitesmoke;" onclick="editorsave()" id="btnsave">Edit</button>
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

        function editorsave() {
            if (document.getElementById("btnsave").textContent === "Save") {
                var fullfill = true;
                var message = "";

                document.getElementById("donatorAddress").style.borderColor = "";
                document.getElementById("receiveDate").style.borderColor = "";
                document.getElementById("deliveryStatus").style.borderColor = "";

                if (!document.getElementById("donatorAddress").value || document.getElementById("donatorAddress").value === "") {
                    document.getElementById("donatorAddress").style.borderColor = "red";
                    fullfill = false;
                }
//                if (!document.getElementById("receiveDate").value || document.getElementById("receiveDate").value === "") {
//                    document.getElementById("receiveDate").style.borderColor = "red";
//                    fullfill = false;
//                }

                if (fullfill) {
                    if (confirm("Are you confirm to update the donation details?")) {
                        document.getElementById("form").submit();
                    }
                } else {
                    alert("Inputs with red border are required field!\n" + message);
                }
            } else {
                editable();
            }
        }

        function cancel() {
            if (confirm("Confirm to unsave current information?")) {
                window.location.href = currentURL;
            }
        }

        function editable() {
            document.getElementById("btnsave").textContent = "Save";
            document.getElementById("btncancel").disabled = false;
            document.getElementById("donatorAddress").readOnly = false;
            document.getElementById("receiveDate").readOnly = false;
            document.getElementById("deliveryStatus").disabled = false;
        }

        function back() {
            window.location.href = "donation_list.php";
        }

        $('#reservationdatetime').datetimepicker({
            format: 'DD/MM/YYYY HH:mm',
            icons: {time: 'far fa-clock'}
        });
    </script>
</html>