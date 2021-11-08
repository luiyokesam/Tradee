<?php
require ('../include/config.inc.php');
include '../include/header.php';

// If no user_id session variable exists, redirect the user:
//if (!isset($_SESSION['custid'])) {
//    $url = BASE_URL . '/php/index.php'; // Define the URL.
//    ob_end_clean(); // Delete the buffer.
//    header("Location: $url");
//    exit(); // Quit the script.
//}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST["type"] === "ResetPassword") {
        // Check for a new password and match against the confirmed password:
        $p = FALSE;
        if (preg_match('/^(\w){4,20}$/', $_POST['pass1'])) {
            if ($_POST['pass1'] == $_POST['pass2']) {
                $p = mysqli_real_escape_string($dbc, $_POST['pass1']);
            } else {
                echo '<script>alert("Your password did not match the confirmed password!");</script>';
            }
        } else {
            echo '<script>alert("Please enter a valid password!");</script>';
        }

        if ($p) {
            $q = "UPDATE customer SET pass=SHA1('$p') WHERE custid='{$_SESSION['loginuser']['custid']}' LIMIT 1";
            $r = mysqli_query($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));
            if (mysqli_affected_rows($dbc) == 1) {
                // Send an email, if desired.
                echo '<script>alert("Your password has been changed.\nPlease login again.");window.location.href="../user/logout.php";</script>';
                mysqli_close($dbc);
//                include ('../include/footer.php');
                exit();
            } else {
                echo '<script>alert("Your password was not changed. Make sure your new password is different than the current password.\nContact the system administrator if you think an error occurred.");</script>';
            }
        } else {
//            echo '<p class="error">Please try again.</p>';
        }
    } else {
        $sql = "UPDATE customer"
                . " SET contact='" . $_POST['contact'] . "',"
                . "gender='" . $_POST['gender'] . "',"
                . "birth='" . $_POST['birth'] . "' "
                . "WHERE custid ='" . $_SESSION['loginuser']['custid'] . "'";

        if ($dbc->query($sql)) {
            $_SESSION['loginuser']['contact'] = $_POST['contact'];
            $_SESSION['loginuser']['gender'] = $_POST['gender'];
            $_SESSION['loginuser']['birth'] = $_POST['birth'];
            echo '<script>alert("Update successfully!");var currentURL = window.location.href; window.location.href = currentURL;</script>';
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
        <title>Account Settings - Tradee</title>
    </head>
    <body>
        <div class="setting">
            <div class="container-lg py-3">
                <div class="row justify-content-center">
                    <?php include '../include/sidenav.php'; ?>
                    <div class="col-lg-8 col-md-10">
                        <form method="post" id="form">
                            <div class="mb-1 bg-white">
                                <div class="row align-items-center border-bottom m-0 px-3 py-2 pt-3">
                                    <div class="col-md-12" style="font-weight: bolder;">Reset Password</div>
                                    <div class="col-md-6 p-2">New password</div>
                                    <div class="col-md-6 p-2">
                                        <input class="form-control" type="password" id="pass1" name="pass1" disabled>
                                    </div>
                                </div>

                                <div class="row align-items-center m-0 px-3 py-2">
                                    <div class="col-md-6 p-2">Confirm new password</div>
                                    <div class="col-md-6 p-2">
                                        <input class="form-control" type="password" id="pass2" name="pass2" disabled>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex flex-row-reverse py-2 mb-2">
                                <button class="btn btn-warning" type="button" id="btnchange" name="btnchange" value="" onclick="changepassword()">Change</button>
                                <input class="form-control" type="text" id="type" name="type" style="display: none;" readonly>
                            </div>

                            <div class="mb-3 bg-white">
                                <div class="row align-items-center border-bottom m-0 p-3">
                                    <div class="col-md-6 p-2">Phone number</div>
                                    <div class="col-md-6 p-2">
                                        <input class="form-control" id="contact" name="contact" readonly value="<?php
                                        if ($_SESSION['loginuser']['contact'] !== null) {
                                            echo $_SESSION['loginuser']['contact'];
                                        }
                                        ?>">
                                    </div>
                                </div>

                                <div class="row align-items-center border-bottom m-0 p-3">
                                    <div class="col-md-6 p-2">Gender</div>
                                    <div class="col-md-6 p-2">
                                        <select class="custom-select" id="gender" name="gender" disabled>
                                            <option value="" <?php
                                            if (($_SESSION['loginuser']['gender']) == null) {
                                                echo "selected";
                                            }
                                            ?>>Not to display</option>
                                            <option value="F" <?php
                                            if ($_SESSION['loginuser']) {
                                                if ($_SESSION['loginuser']['gender'] == "F") {
                                                    echo "selected";
                                                }
                                            }
                                            ?>>Female</option>
                                            <option value="M" <?php
                                            if ($_SESSION['loginuser']) {
                                                if ($_SESSION['loginuser']['gender'] == "M") {
                                                    echo "selected";
                                                }
                                            }
                                            ?>>Male</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row align-items-center border-bottom m-0 p-3">
                                    <div class="col-md-6 p-3">Birthday</div>
                                    <div class="col-6">
                                        <div class="input-group">
                                            <div class="input-group date" id="registrationdate" data-target-input="nearest">
                                                <div class="input-group-append" data-target="#registrationdate" data-toggle="datetimepicker">
                                                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                                </div>
                                                <input type="text" class="form-control datetimepicker-input" data-target="#registrationdate" value="<?php
                                                if (isset($_SESSION['loginuser'])) {
                                                    echo ($_SESSION['loginuser']['birth']);
                                                }
                                                ?>" readOnly name="birth" id="birth">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <div class="bd-highlight float-right">
                            <button class="btn btn-primary" type="button" id="btnsave" style="width: 70px" onclick="editorsave()">Edit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include '../include/footer.php'; ?>
    </body>
    <script>
        function changepassword() {
            var btnoption = document.getElementById("btnchange").textContent;
            console.log(document.getElementById("btnchange").textContent);

            if (btnoption === "Save") {
                var fullfill = true;
                document.getElementById("pass1").style.borderColor = "";
                document.getElementById("pass2").style.borderColor = "";

                if (!document.getElementById("pass1").value || document.getElementById("pass1").value === "") {
                    document.getElementById("pass1").style.borderColor = "red";
                    fullfill = false;
                }

                if (!document.getElementById("pass2").value || document.getElementById("pass2").value === "") {
                    document.getElementById("pass2").style.borderColor = "red";
                    fullfill = false;
                }

                if (fullfill) {
                    if (confirm("Confirm to save?")) {
                        if (!document.getElementById("pass1").value) {
                            document.getElementById("pass1").value = null;
                        }
                        if (!document.getElementById("pass2").value) {
                            document.getElementById("pass2").value = null;
                        }
                        document.getElementById("type").value = "ResetPassword";
                        document.getElementById("form").submit();
                    }
                }
            } else {
                change();
            }
        }

        function editorsave() {
            var btnoption = document.getElementById("btnsave").textContent;
            console.log(document.getElementById("btnsave").textContent);

            if (btnoption === "Save") {
                var fullfill = true;
                document.getElementById("contact").style.borderColor = "";

                if (!document.getElementById("contact").value || document.getElementById("contact").value === "") {
                    document.getElementById("contact").style.borderColor = "red";
                    fullfill = false;
                }

                if (fullfill) {
                    if (confirm("Confirm to save?")) {
                        if (!document.getElementById("contact").value) {
                            document.getElementById("contact").value = null;
                        }
                        document.getElementById("type").value = "UpdateInformation";
                        document.getElementById("form").submit();
                    }
                }
            } else {
                editable();
            }
        }

        function editable() {
            document.getElementById("contact").readOnly = false;
            document.getElementById("gender").disabled = false;
            document.getElementById("birth").readOnly = false;
            document.getElementById("btnsave").textContent = "Save";
        }

        function change() {
            document.getElementById("pass1").disabled = false;
            document.getElementById("pass2").disabled = false;
            document.getElementById("btnchange").textContent = "Save";
        }

        //Date picker
        $('#registrationdate').datetimepicker({
            format: 'L'
        });
    </script>
    <style>
        .setting{
            background: whitesmoke;
        }
    </style>
</html>