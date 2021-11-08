<?php
include '../include/header.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM trade t, trade_details d, customer c WHERE t.tradeid = d.tradeid AND d.custid = c.custid AND c.custid = '" . $_SESSION['loginuser']['custid'] . "' AND t.status = 'Trading' AND d.tradeid = '$id' LIMIT 1";
    $result = $dbc->query($sql);
    if ($result->num_rows > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $current_data = $row;
            echo '<script>var current_data = ' . json_encode($current_data) . ';</script>';
            break;
        }
    } else {
        echo '<script>alert("Extract data fail !\nContact IT department for maintainence");window.location.href = "../user/my_profile.php";</script>';
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION['delivery_details'] = json_decode($_POST['detail'], true);
    echo '<script>window.location.href = "offer_delivery_payment.php?id=' . $current_data['tradeid'] . '";</script>';
    exit();
}
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php
            echo $current_data['tradeid'];
//            if (isset($current_data)) {
//                echo $current_data["deliveryid"];
//            } else {
//                echo $newid;
//            }
            ?> Shipping Details - Tradee</title>
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
                    <div class="col-md-8">
                        <div class="border-bottom border-3" style="font-size:1.5em;">Shipping</div>
                        <div class="row justify-content-center pt-3">
                            <div class="col-md-7">
                                <div class="">
                                    <div class="form-group row" style="display: none;">
                                        <label for="tradeid" class="col-sm-2 col-form-label">Trade ID</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="tradeid" name="tradeid" required value="<?php
                                            echo $current_data["tradeid"];
                                            ?>">
                                            <div class="invalid-feedback">
                                                Please provide your name.
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

                                    <div class="form-group row pl-2 my-2 mb-3">
                                        <label class="col-sm-12 p-0">Select packaging method</label>
                                        <div class="col-auto px-0 pr-2" style="width: 100%;">
                                            <select class="custom-select" id="packaging" name="packaging">
                                                <option value="Plastic boxes">Plastic boxes</option>
                                                <option value="Bubble wrap">Bubble wrap</option>
                                                <option value="Seal boxes with tape">Seal boxes with tape</option>
                                            </select>
                                        </div>

<!--                                        <label class="col-sm-12 p-0">Select packaging method</label>
                                        <div class="form-group mb-1">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" id="packaging" name="packaging" value="Plastic boxes"<?php
                                                if (isset($_SESSION['delivery_details'])) {
                                                    if ($_SESSION['delivery_details']['packaging'] == 'Plastic boxes') {
                                                        echo 'checked';
                                                    }
                                                }
                                                ?>">
                                                <label class="form-check-label">Plastic boxes</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" id="packaging" name="packaging" value="Bubble wrap"<?php
                                                if (isset($_SESSION['delivery_details'])) {
                                                    if ($_SESSION['delivery_details']['packaging'] == 'Bubble wrap') {
                                                        echo 'checked';
                                                    }
                                                }
                                                ?>">
                                                <label class="form-check-label">Bubble wrap</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" id="packaging" name="packaging" value="Seal boxes with tape"<?php
                                                if (isset($_SESSION['delivery_details'])) {
                                                    if ($_SESSION['delivery_details']['packaging'] == 'Seal boxes with tape') {
                                                        echo 'checked';
                                                    }
                                                }
                                                ?>>
                                                <label class="form-check-label">Seal boxes with tape</label>
                                            </div>
                                        </div>-->
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
                                    <label for="city" class="col-sm-3 col-form-label align-items-center">City</label>
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
                                    <label for="state" class="col-sm-3 col-form-label align-items-center">State</label>
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
                                    <label for="postcode" class="col-sm-3 col-form-label align-items-center">Postal</label>
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
                                    <label for="country" class="col-sm-3 col-form-label align-items-center">Country</label>
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

                                <div class="form-group row">
                                    <label for="country" class="col-sm-3 col-form-label align-items-center">Date</label>
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                            <input type="text" class="form-control" placeholder="dd/mm/yyyy" id="deliveryDate" maxlength="10" readOnly name="deliveryDate" value="<?php
                                            if (isset($_SESSION['delivery_details'])) {
                                                echo $_SESSION['delivery_details']['deliveryDate'];
                                            }
                                            ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row pl-2">
                                    <label class="form-label">Deliver to</label>
                                    <div class="row">
                                        <div class="col-6">
                                            <input type="text" class="form-control" id="deliveryState" name="deliveryState" readonly="" value="<?php
                                            $sql_deliver = "SELECT DISTINCT(c.state) FROM trade_details d, customer c WHERE d.custid = c.custid AND d.custid <> '{$_SESSION['loginuser']['custid']}' AND d.tradeid = '{$current_data['tradeid']}'";
                                            $result = $dbc->query($sql_deliver);
                                            if ($result->num_rows > 0) {
                                                while ($row = mysqli_fetch_array($result)) {
                                                    echo $row['state'];
                                                }
                                            }
                                            ?>">
                                        </div>
                                        <div class="col-6">
                                            <input type="text" class="form-control" id="deliveryCountry" name="deliveryCountry" readonly="" value="<?php
                                            $sql_deliver = "SELECT DISTINCT(c.country) FROM trade_details d, customer c WHERE d.custid = c.custid AND d.custid <> '{$_SESSION['loginuser']['custid']}' AND d.tradeid = '{$current_data['tradeid']}'";
                                            $result = $dbc->query($sql_deliver);
                                            if ($result->num_rows > 0) {
                                                while ($row = mysqli_fetch_array($result)) {
                                                    echo $row['country'];
                                                }
                                            }
                                            ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl">
                                    <label class="form-label">Item Quantity</label>
                                    <input type="text" class="form-control" id="itemQuantity" name="itemQuantity" readonly="" value="<?php
                                    $count = "SELECT COUNT(t.itemid) itemQuantity FROM trade_details t, customer c WHERE t.custid = c.custid AND c.custid = '{$_SESSION['loginuser']['custid']}' AND t.tradeid = '{$current_data['tradeid']}'";
                                    $result = $dbc->query($count);
                                    if ($result->num_rows > 0) {
                                        while ($row = mysqli_fetch_array($result)) {
                                            echo $row['itemQuantity'];
                                        }
                                    }
                                    ?>">
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

                    <div class="col-md-4">
                        <div class="row">
                            <div class="container">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="" style="font-size:1.2em;">Order Summary</div>
                                    </div>
                                    <div class="card-body pb-0">
                                        <div class="row">
                                            <div class="col-12" id="accordion">
                                                <?php
                                                $get_inventory = "SELECT * FROM trade_details d, item i, item_image m  WHERE d.itemid = i.itemid AND i.itemid = m.itemid AND d.custid = '{$current_data['offerCustID']}'";
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
                                                        . "<img src=" . $row["img"] . " class='img-fluid item-img' alt='...'>"
                                                        . "</div>"
//                                                    . "<div class='float-left' style='color:#969696;'>" . $row["itemCondition"] . "</div>"
//                                                    . "<div class='' style='color:#969696;'>" . $row["brand"] . "</div>"
                                                        . "</div>"
                                                        . "</div>";
                                                    }
                                                }
                                                ?>
                                                <!--card sameple-->
                                                <!--                                            <div class="card card-primary card-outline">
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
                var delivery_details = {
                    tradeid: document.getElementById("tradeid").value,
                    username: document.getElementById("username").value,
                    contact: document.getElementById("contact").value,
                    address1: document.getElementById("address1").value,
                    address2: document.getElementById("address2").value,
                    city: document.getElementById("city").value,
                    state: document.getElementById("state").value,
                    postcode: document.getElementById("postcode").value,
                    country: document.getElementById("country").value,
                    remarks: document.getElementById("remarks").value,
                    deliveryDate: document.getElementById("deliveryDate").value,
                    deliveryState: document.getElementById("deliveryState").value,
                    deliveryCountry: document.getElementById("deliveryCountry").value,
                    itemQuantity: document.getElementById("itemQuantity").value,
                    packaging: document.getElementById("packaging").value
                };
                if (confirm("Confirmed the delivery details?")) {
                    document.getElementById("detail").value = JSON.stringify(delivery_details);
                    document.getElementById("form").submit();
                }
            } else {
                alert("Please enter all required information for the delivery.\n" + message);
            }
        }

        function cancel() {
            if (confirm("Confirm to cancel the delivery process?")) {
                window.location.href = "my_profile.php";
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
        document.getElementById("deliveryDate").value = dd + '/' + mm + '/' + yyyy;
    </script>
    <style>
        .item-img{
            width: 100px;
            height: 200px;
            object-fit: cover;
        }
    </style>
</html>