<?php
include '../include/header.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM event WHERE eventid = '$id' LIMIT 1";
    $result = $dbc->query($sql);
    if ($result->num_rows > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $current_data = $row;
            echo '<script>var current_data = ' . json_encode($current_data) . ';</script>';
            break;
        }
    } else {
//        echo '<script>alert("Extract data fail !\nContact IT department for maintainence")</script>';
        echo '<script>alert("Extract data fail !\nContact IT department for maintainence");window.location.href = "../user/my_profile.php";</script>';
    }
}

$sql = "SELECT * FROM donation ORDER BY donateid DESC LIMIT 1";
$result = $dbc->query($sql);
if ($result->num_rows > 0) {
    while ($row = mysqli_fetch_array($result)) {
        $latestnum = ((int) substr($row['donateid'], 1)) + 1;
        $newid = "DO{$latestnum}";
        echo '<script>var current_data = null;</script>';
        break;
    }
} else {
    $newid = "DO10001";
    echo '<script>var current_data = null;</script>';
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION['delivery_details'] = json_decode($_POST['detail'], true);
    echo '<script>window.location.href = "event_payment.php?id=' . $current_data['eventid'] . '";</script>';
    exit();
}

//if ($_SERVER["REQUEST_METHOD"] == "POST") {
//    $my_items = $_POST['my_item'];
//    foreach ($my_items as $my_item_list) {
//        $sql = "INSERT INTO donation(donateid, eventid, donator, itemid, donationDate) VALUES ("
//                . "'" . $newid . "',"
//                . "'" . $current_data['eventid'] . "',"
//                . "'" . $_SESSION['loginuser']['custid'] . "',"
//                . "'" . $my_item_list . "',"
//                . "'" . $_POST['donationDate'] . "')";
//
//        $dbc->query($sql);
////        echo '<script>alert("' . $sql . '");</script>';
//    }
////    echo '<script>alert("' . $my_item_list . '");</script>';
//
//    foreach ($my_items as $update_my_item_list) {
//        $sql_update = "UPDATE item SET "
//                . "itemActive = 'Donation',"
//                . "custid = '$newid'"
//                . " WHERE custid ='" . $_SESSION['loginuser']['custid'] . "' AND"
//                . " itemid = '" . $update_my_item_list . "'";
//
//        $dbc->query($sql_update);
////        echo '<script>alert("' . $sql_update . '");</script>';
//    }
////    echo '<script>alert("' . $update_my_item_list . '");</script>';
//
//    echo '<script>alert("Thanks for your donation! Wishing you have a nice day.");window.location.href="../user/event_shipping.php?id=' . $newid . '";</script>';
//}
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="../bootstrap/plugins/select2/css/select2.min.css">
        <link rel="stylesheet" href="../bootstrap/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
        <title><?php
            echo $current_data['eventid'];
//            if (isset($current_data)) {
//                echo $current_data["deliveryid"];
//            } else {
//                echo $newid;
//            }
            ?> Donation Shipping - Tradee</title>
    </head>
    <body>
        <div class="bg-navbar mb-3 bg-light">
            <div class="container-lg">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb py-2 mb-0">
                        <li class="breadcrumb-item"><a href="#">Trade Offer</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Delivery</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="container-lg">
            <form id="form"  method="post">
                <input id="detail" name="detail">
                <div class="row justify-content-center pt-3 mb-5">
                    <div class="col-md-12">
                        <div class="border-bottom border-3" style="font-size:1.5em;">Shipping</div>
                        <div class="row justify-content-center pt-3">
                            <div class="col-md-6">
                                <div class="">
                                    <div class="form-group row" style="display: none;">
                                        <label for="tradeid" class="col-sm-2 col-form-label">Event</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="eventid" name="eventid" required value="<?php
                                            echo $current_data['eventid'];
                                            ?>">
                                            <div class="invalid-feedback">
                                                Please provide your name.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row" style="display: none;">
                                        <label for="tradeid" class="col-sm-2 col-form-label">Donation</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="donateid" name="donateid" required value="<?php
                                            echo $newid;
                                            ?>">
                                            <div class="invalid-feedback">
                                                Please provide your name.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="myitem" class="col-sm-2 col-form-label">Inventory</label>
                                        <div class="col-sm-10">
                                            <select class="select2bs4" name="my_item[]" id="myitem" multiple="multiple" data-placeholder="Select your item" style="width: 100%;">
                                                <?php
                                                $get_item = "SELECT * FROM item WHERE custid = '{$_SESSION['loginuser']['custid']}' AND itemActive = 'Available'";
                                                $result_item = $dbc->query($get_item);
                                                if ($result_item->num_rows > 0) {
                                                    while ($row = mysqli_fetch_array($result_item)) {
                                                        echo '<option ' . $selected . ' value="' . $row['itemid'] . '">' . $row['itemname'] . '</option>';
                                                    }
                                                }
                                                ?>
                                            </select>
                                            <div class="invalid-feedback">
                                                Please select an item.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="username" class="col-sm-2 col-form-label">Name</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="username" name="username" required value="<?php
                                            if (isset($_SESSION['delivery_details'])) {
                                                echo $_SESSION["delivery_details"]['username'];
                                            } else {
                                                if (isset($_SESSION['loginuser'])) {
                                                    echo $_SESSION['loginuser']['username'];
                                                }
                                            }
                                            ?>">
                                            <div class="invalid-feedback">
                                                Please provide your name.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="contact" class="col-sm-2 col-form-label">Phone</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="contact" name="contact" maxlength="15" required value="<?php
                                            if (isset($_SESSION['delivery_details'])) {
                                                echo $_SESSION['delivery_details']['contact'];
                                            } else {
                                                if (isset($_SESSION['loginuser'])) {
                                                    echo $_SESSION['loginuser']['contact'];
                                                }
                                            }
                                            ?>">
                                            <div class="invalid-feedback">
                                                Please provide a valid phone no.
                                            </div>
                                        </div>
                                    </div>

                                    <div>Address</div>
                                    <div class="form-group row">
                                        <label for="address1" class="col-sm-2 col-form-label">Line 1</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="address1" name="address1" required value="<?php
                                            if (isset($_SESSION['delivery_details'])) {
                                                echo $_SESSION['delivery_details']['address1'];
                                            } else {
                                                if (isset($_SESSION['loginuser'])) {
                                                    echo $_SESSION['loginuser']['address1'];
                                                }
                                            }
                                            ?>">
                                            <div class="invalid-feedback">
                                                Please provide a valid address.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row align-items-center mb-1">
                                        <label for="address2" class="col-sm-2 col-form-label align-items-center">Line 2 <small>Optional</small></label>
                                        <div class="col-sm-10 align-items-center">
                                            <input type="text" class="form-control align-items-center" id="address2" name="address2" value="<?php
                                            if (isset($_SESSION['delivery_details'])) {
                                                echo $_SESSION['delivery_details']['address2'];
                                            } else {
                                                if (isset($_SESSION['loginuser'])) {
                                                    echo $_SESSION['loginuser']['address2'];
                                                }
                                            }
                                            ?>">
                                            <div class="invalid-feedback">
                                                Please provide a valid address.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="">
                                        <label for="remarks" class="form-label">Remarks</label>
                                        <textarea class="form-control" id="remarks" name="remarks" rows="5"><?php
                                            if (isset($_SESSION['delivery_details'])) {
                                                echo $_SESSION['delivery_details']['remarks'];
                                            }
                                            ?></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-5">
                                <div class="form-group row align-items-center">
                                    <label for="city" class="col-sm-2 col-form-label align-items-center">City</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="city" name="city" required value="<?php
                                        if (isset($_SESSION['delivery_details'])) {
                                            echo $_SESSION['delivery_details']['city'];
                                        } else {
                                            if (isset($_SESSION['loginuser'])) {
                                                echo $_SESSION['loginuser']['city'];
                                            }
                                        }
                                        ?>">
                                        <div class="invalid-feedback">
                                            Please provide a valid city.
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row align-items-center">
                                    <label for="state" class="col-sm-2 col-form-label align-items-center">State</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="state" name="state" required value="<?php
                                        if (isset($_SESSION['delivery_details'])) {
                                            echo $_SESSION['delivery_details']['state'];
                                        } else {
                                            if (isset($_SESSION['loginuser'])) {
                                                echo $_SESSION['loginuser']['state'];
                                            }
                                        }
                                        ?>">
                                        <div class="invalid-feedback">
                                            Please provide a valid state.
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row align-items-center">
                                    <label for="postcode" class="col-sm-2 col-form-label align-items-center">Postal</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="postcode" name="postcode" onkeypress="return isNumberKey(event)" maxlength="10" required value="<?php
                                        if (isset($_SESSION['delivery_details'])) {
                                            echo $_SESSION['delivery_details']['postcode'];
                                        } else {
                                            if (isset($_SESSION['loginuser'])) {
                                                echo $_SESSION['loginuser']['postcode'];
                                            }
                                        }
                                        ?>">
                                        <div class="invalid-feedback">
                                            Please provide a valid postal code.
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row align-items-center">
                                    <label for="country" class="col-sm-2 col-form-label align-items-center">Country</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="country" name="country" required value="<?php
                                        if (isset($_SESSION['delivery_details'])) {
                                            echo $_SESSION['delivery_details']['country'];
                                        } else {
                                            if (isset($_SESSION['loginuser'])) {
                                                echo $_SESSION['loginuser']['country'];
                                            }
                                        }
                                        ?>">
                                        <div class="invalid-feedback">
                                            Please select a valid country.
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row" style="display: none;">
                                    <label for="country" class="col-sm-2 col-form-label align-items-center">Date</label>
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                            <input type="text" class="form-control" placeholder="dd/mm/yyyy" id="donationDate" maxlength="10" readOnly name="donationDate" value="<?php
                                            if (isset($_SESSION['delivery_details'])) {
                                                echo $_SESSION['delivery_details']['donationDate'];
                                            }
                                            ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row pl-2 my-2 mb-3">
                                    <label class="col-sm-12 p-0">Select packaging method</label>
                                    <div class="col-md-11 px-0 pr-2" style="width: 100%;">
                                        <select class="custom-select" id="packaging" name="packaging">
                                            <option value="Plastic boxes">Plastic boxes</option>
                                            <option value="Bubble wrap">Bubble wrap</option>
                                            <option value="Seal boxes with tape">Seal boxes with tape</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row pl-2">
                                    <label class="form-label">Deliver to</label>
                                    <div class="col-11 px-0">
                                        <input type="text" class="form-control" readonly="" value="<?php
                                        echo "{$current_data['state']}, {$current_data['country']}";
                                        ?>">
                                    </div>
                                    <div class="col-11 px-0" style="display: none;">
                                        <input type="text" class="form-control" id="deliveryState" name="deliveryState" readonly="" value="<?php
                                        echo $current_data['state'];
                                        ?>">
                                    </div>
                                    <div class="col-11 px-0" style="display: none;">
                                        <input type="text" class="form-control" id="deliveryCountry" name="deliveryCountry" readonly="" value="<?php
                                        echo $current_data['country'];
                                        ?>">
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-sm-auto">
                                        <button type="button" class="btn btn-warning btn-block" onclick="cancel()" id="btncancel" >Cancel</button>
                                    </div>

                                    <div class="col-sm-auto">
                                        <button class="btn btn-success" onclick="checkout()" type="button">Proceed to payment</button>
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
        var currentURL = window.location.href;

        function checkout() {
            var fullfill = true;
            var message = "";
            document.getElementById("myitem").style.borderColor = "";
            document.getElementById("username").style.borderColor = "";
            document.getElementById("contact").style.borderColor = "";
            document.getElementById("address1").style.borderColor = "";
            document.getElementById("address2").style.borderColor = "";
            document.getElementById("city").style.borderColor = "";
            document.getElementById("state").style.borderColor = "";
            document.getElementById("postcode").style.borderColor = "";
            document.getElementById("country").style.borderColor = "";
            document.getElementById("remarks").style.borderColor = "";
            document.getElementById("packaging").style.borderColor = "";

            if (!document.getElementById("myitem").value || document.getElementById("myitem").value === "") {
                document.getElementById("myitem").style.borderColor = "red";
                message = "Please select an item that you wanted to donate !\n";
                fullfill = false;
            }
            if (!document.getElementById("username").value || document.getElementById("username").value === "") {
                document.getElementById("username").style.borderColor = "red";
                message = "Receiver is required field !\n";
                fullfill = false;
            }
            if (!document.getElementById("contact").value || document.getElementById("contact").value === "") {
                document.getElementById("contact").style.borderColor = "red";
                message += "Contact is required field !\n";
                fullfill = false;
            }
            if (!document.getElementById("address1").value || document.getElementById("address1").value === "") {
                document.getElementById("address1").style.borderColor = "red";
                message += "Address is required field !\n";
                fullfill = false;
            }
            if (!document.getElementById("city").value || document.getElementById("city").value === "") {
                document.getElementById("city").style.borderColor = "red";
                message += "City is required field !\n";
                fullfill = false;
            }
            if (!document.getElementById("state").value || document.getElementById("state").value === "") {
                document.getElementById("state").style.borderColor = "red";
                message += "State is required field !\n";
                fullfill = false;
            }
            if (!document.getElementById("postcode").value || document.getElementById("postcode").value === "") {
                document.getElementById("postcode").style.borderColor = "red";
                message += "Postcode is required field !\n";
                fullfill = false;
            } else {
                if (document.getElementById("postcode").value.length < 5 || document.getElementById("postcode").value.length > 5) {
                    fulfill = false;
                    message += "Postcode is invalid , must be 5 character !\n";
                    document.getElementById("postcode").style.borderColor = "red";
                }
            }
            if (!document.getElementById("country").value || document.getElementById("country").value === "") {
                document.getElementById("country").style.borderColor = "red";
                message += "Country is required field !\n";
                fullfill = false;
            }
            if (!document.getElementById("packaging").value || document.getElementById("packaging").value === "") {
                document.getElementById("packaging").style.borderColor = "red";
                message += "Packaging is required field !\n";
                fullfill = false;
            }

            if (fullfill) {
                var select = document.getElementById('myitem');
                var selected = [...select.selectedOptions].map(option => option.value);
                console.log(selected);

                var delivery_details = {
                    myitem: selected,
                    eventid: document.getElementById("eventid").value,
                    donateid: document.getElementById("donateid").value,
                    username: document.getElementById("username").value,
                    contact: document.getElementById("contact").value,
                    address1: document.getElementById("address1").value,
                    address2: document.getElementById("address2").value,
                    city: document.getElementById("city").value,
                    state: document.getElementById("state").value,
                    postcode: document.getElementById("postcode").value,
                    country: document.getElementById("country").value,
                    remarks: document.getElementById("remarks").value,
                    donationDate: document.getElementById("donationDate").value,
                    deliveryState: document.getElementById("deliveryState").value,
                    deliveryCountry: document.getElementById("deliveryCountry").value,
                    packaging: document.getElementById("packaging").value
                };
                if (confirm("Confirm your donation items and delivery details?")) {
                    document.getElementById("detail").value = JSON.stringify(delivery_details);
                    document.getElementById("form").submit();
                }
            } else {
                alert("Please enter all required information for the delivery.\n" + message);
            }
        }

        function cancel() {
            if (confirm("Confirm to cancel the delivery process?")) {
                window.location.href = "trade_list.php";
            }
        }

        function isNumberKey(evt) {
            var charCode = (evt.which) ? evt.which : event.keyCode;
            if (charCode > 31 && (charCode !== 46 && (charCode < 48 || charCode > 57)))
                return false;
            if (charCode === 46 && charCode === ".")
                return false;
            if (charCode === ".")
            {
                var number = [];
                number = charCode.split(".");
                if (number[1].length === decimalPts)
                    return false;
            }
            return true;
        }

        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0');
        var yyyy = today.getFullYear();
        document.getElementById("donationDate").value = dd + '/' + mm + '/' + yyyy;

        $(function () {
            //Initialize Select2 Elements
            $('.select2').select2()

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        })
    </script>
    <script src="../bootstrap/plugins/select2/js/select2.full.min.js"></script>
    <style>
        .item-img{
            width: 100px;
            height: 200px;
            object-fit: cover;
        }
    </style>
</html>