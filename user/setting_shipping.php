<?php
include '../include/header.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sql = "UPDATE customer"
            . " SET address1='" . $_POST['address1'] . "',"
            . "address2='" . $_POST['address2'] . "',"
            . "postcode='" . $_POST['postcode'] . "',"
            . "city='" . $_POST['city'] . "',"
            . "state='" . $_POST['state'] . "',"
            . "country='" . $_POST['country'] . "' "
            . "WHERE custid ='" . $_SESSION['loginuser']['custid'] . "'";

    if ($dbc->query($sql)) {
        $_SESSION['loginuser']['address1'] = $_POST['address1'];
        $_SESSION['loginuser']['address2'] = $_POST['address2'];
        $_SESSION['loginuser']['postcode'] = $_POST['postcode'];
        $_SESSION['loginuser']['city'] = $_POST['city'];
        $_SESSION['loginuser']['state'] = $_POST['state'];
        $_SESSION['loginuser']['country'] = $_POST['country'];
        echo '<script>alert("Your shipping address has been updated.");var currentURL = window.location.href;window.location.href = currentURL;</script>';
    } else {
        echo '<script>alert("Update fail !\nContact IT department for maintainence")</script>';
    }
}
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Shipping Settings - Tradee</title>
    </head>
    <body>
        <div class="setting">
            <div class="container-lg py-3">
                <form method="post" id="form">
                    <div class="row justify-content-center">
                        <?php
                        $page = 'setting_shipping';
                        include '../include/sidenav.php';
                        ?>
                        <div class="col-lg-8 col-md-10">
                            <div class="mb-3 bg-white">
                                <!--<div class="row p-4 m-0 border-bottom">Address</div>-->
                                <div class="row align-items-center border-bottom m-0 p-3">
                                    <div class="col-12" style="font-weight: bolder;">Address</div>
                                    <div class="col-md-6 p-2">Line 1</div>
                                    <div class="col-md-6 p-2">
                                        <input class="form-control" id="address1" name="address1" readonly value="<?php
                                        if ($_SESSION['loginuser']['address1'] !== null) {
                                            echo $_SESSION['loginuser']['address1'];
                                        }
                                        ?>">
                                    </div>
                                </div>

                                <div class="row align-items-center border-bottom m-0 p-3">
                                    <div class="col-md-6 p-2">Line 2</div>
                                    <div class="col-md-6 p-2">
                                        <input class="form-control" id="address2" name="address2" readonly value="<?php
                                        if ($_SESSION['loginuser']['address2'] !== null) {
                                            echo $_SESSION['loginuser']['address2'];
                                        }
                                        ?>">
                                    </div>
                                </div>

                                <div class="row align-items-center border-bottom m-0 p-3">
                                    <div class="col-md-6 p-2">Postal Code</div>
                                    <div class="col-md-6 p-2">
                                        <input class="form-control" id="postcode" name="postcode" readonly value="<?php
                                        if ($_SESSION['loginuser']['postcode'] !== null) {
                                            echo $_SESSION['loginuser']['postcode'];
                                        }
                                        ?>">
                                    </div>
                                </div>

                                <div class="row align-items-center border-bottom m-0 p-3">
                                    <div class="col-md-6 p-2">City</div>
                                    <div class="col-md-6 p-2">
                                        <input class="form-control" id="city" name="city" readonly value="<?php
                                        if ($_SESSION['loginuser']['city'] !== null) {
                                            echo $_SESSION['loginuser']['city'];
                                        }
                                        ?>">
                                    </div>
                                </div>

                                <div class="row align-items-center border-bottom m-0 p-3">
                                    <div class="col-md-6 p-2">State</div>
                                    <div class="col-md-6 p-2">
                                        <input class="form-control" id="state" name="state" readonly value="<?php
                                        if ($_SESSION['loginuser']['state'] !== null) {
                                            echo $_SESSION['loginuser']['state'];
                                        }
                                        ?>">
                                    </div>
                                </div>

                                <div class="row align-items-center border-bottom m-0 p-3">
                                    <div class="col-md-6 p-2">Country</div>
                                    <div class="col-md-6 p-2">
                                        <input class="form-control" id="country" name="country" readonly value="<?php
                                        if ($_SESSION['loginuser']['country'] !== null) {
                                            echo $_SESSION['loginuser']['country'];
                                        }
                                        ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="bd-highlight float-right" style="margin-bottom: 2.3rem;">
                                <button class="btn btn-primary" type="button" id="btnsave" style="width: 70px" onclick="editorsave()">Edit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <?php
        include '../include/footer.php';
        ?>
    </body>
    <script>
        function editable() {
            document.getElementById("address1").readOnly = false;
            document.getElementById("address2").readOnly = false;
            document.getElementById("postcode").readOnly = false;
            document.getElementById("city").readOnly = false;
            document.getElementById("state").readOnly = false;
            document.getElementById("country").readOnly = false;
            document.getElementById("btnsave").textContent = "Save";
        }

        function editorsave() {
            var btnoption = document.getElementById("btnsave").textContent;
            console.log(document.getElementById("btnsave").textContent);

            if (btnoption === "Save") {
                var fullfill = true;
//                document.getElementById("validate_img").style.borderColor = "";
//                document.getElementById("username").style.borderColor = "";
//                document.getElementById("description").style.borderColor = "";
//
//                if (!document.getElementById("username").value || document.getElementById("username").value === "") {
//                    document.getElementById("username").style.borderColor = "red";
//                    fullfill = false;
//                }
//                if (!document.getElementById("description").value || document.getElementById("description").value === "") {
//                    document.getElementById("description").style.borderColor = "red";
//                    fullfill = false;
//                }
//                var img = document.getElementById('img_display');
//                if (!document.getElementById("img").value || document.getElementById("img").value === "") {
//                    if (img.getAttribute('src') === "") {
//                        document.getElementById("validate_img").style.borderColor = "red";
//                        fullfill = false;
//                    }
//                }

                if (fullfill) {
                    if (confirm("Confirm to save?")) {
//                        if (!document.getElementById("username").value) {
//                            document.getElementById("username").value = null;
//                        }
//                        if (!document.getElementById("description").value) {
//                            document.getElementById("description").value = null;
//                        }
                        document.getElementById("form").submit();
                    }
                }
            } else {
                editable();
            }
        }
    </script>
    <style>
        .setting{
            background: whitesmoke;
        }
    </style>
</html>