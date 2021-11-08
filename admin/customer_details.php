<?php
include 'navbar.php';

//$Array_email = array();
//$sql1 = "SELECT email FROM customer";
//$result1 = $dbc->query($sql1);
//if ($result1->num_rows > 0) {
//    while ($row = mysqli_fetch_array($result1)) {
//        array_push($Array_email, $row["email"]);
//    }
//}
//echo '<script>var Array_email = ' . json_encode($Array_email) . ';</script>';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM customer WHERE custid = '$id' LIMIT 1";
    $result = $dbc->query($sql);
    if ($result->num_rows > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $current_data = $row;
            $title = "Customer Details - {$current_data['custid']}";
            echo '<script>var current_data = ' . json_encode($current_data) . ';</script>';
            break;
        }
    } else {
        echo '<script>alert("Extract data fail !\nContact IT department for maintainence");window.location.href = "customer_list.php";</script>';
    }
}
//else {
//    $sql = "SELECT custid FROM customer ORDER BY custid DESC LIMIT 1";
//    $result = $dbc->query($sql);
//    if ($result->num_rows > 0) {
//        while ($row = mysqli_fetch_array($result)) {
//            $latestnum = ((int) substr($row['custid'], 1)) + 1;
//            $newid = "C{$latestnum}";
//            $title = "New Customer ({$newid})";
//            echo '<script>var current_data = null;</script>';
//            $current_data = null;
//            break;
//        }
//    } else {
//        $newid = "C00001";
//        $title = "New Customer ({$newid})";
//    }
//}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_GET['id'])) {

        $img = $_FILES['img']['name'];
        if ($img) {
            $newimg = "../photo/$img";
        } else {
            $newimg = $current_data["img"];
        }

        if ($_POST['ps'] === "" || !isset($_POST['ps'])) {
            $ps = $current_data['pass'];
        } else {
            $ps = $_POST['ps'];
        }

        $sql = "UPDATE customer SET "
                . "username='" . $_POST['username'] . "',"
                . "avatar='" . $newimg . "',"
                . "contact='" . $_POST['contact'] . "',"
                . "gender='" . $_POST['gender'] . "',"
                . "birth='" . $_POST['birth'] . "',"
                . "email='" . $_POST['email'] . "',"
                . "address1='" . $_POST['address1'] . "',"
                . "address2='" . $_POST['address2'] . "',"
                . "city='" . $_POST['city'] . "',"
                . "postcode='" . $_POST['postcode'] . "',"
                . "state='" . $_POST['state'] . "',"
                . "country='" . $_POST['country'] . "',"
                . "pass='" . $ps . "',"
                . "active='" . $_POST['activation'] . "'"
                . "WHERE custid ='" . $current_data['custid'] . "'";

        if ($dbc->query($sql)) {
            if ($img) {
                move_uploaded_file($_FILES['img']['tmp_name'], "../photo/$img");
            }
            echo '<script>alert("Successfuly update !");var currentURL = window.location.href;window.location.href = currentURL;</script>';
        } else {
            echo '<script>alert("Update fail !\nContact IT department for maintainence")</script>';
        }
    } 
//    else {
//        $img = $_FILES['img']['name'];
//        if ($img) {
//            $newimg = "../photo/$img";
//        }
//
//        $sql = "INSERT INTO customer(custid, email, pass, username, avatar, birth, contact, gender, address1, address2, postcode, city, state, country, user_level, registration_date, active) VALUES("
//                . "'" . $newid . "',"
//                . "'" . $_POST['email'] . "',"
//                . "'" . $_POST['ps'] . "',"
//                . "'" . $_POST['username'] . "',"
//                . "'" . $newimg . "',"
//                . "'" . $_POST['birth'] . "',"
//                . "'" . $_POST['contact'] . "',"
//                . "'" . $_POST['gender'] . "',"
//                . "'" . $_POST['address1'] . "',"
//                . "'" . $_POST['address2'] . "',"
//                . "'" . $_POST['postcode'] . "',"
//                . "'" . $_POST['city'] . "',"
//                . "'" . $_POST['state'] . "',"
//                . "'" . $_POST['country'] . "',"
//                . "'" . $_POST['ps'] . "')";
//
//        if ($dbc->query($sql)) {
//            if ($img) {
//                move_uploaded_file($_FILES['img']['tmp_name'], "../photo/$img");
//            }
//            echo '<script>alert("Successfuly insert !");window.location.href = "customer_details.php?id=' . $newid . '";</script>';
//        } else {
//            echo '<script>alert("Insert fail !\nContact IT department for maintainence\nRedirect to Customer list");window.location.href = "customer_list.php";</script>';
//        }
//    }
}
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo $current_data['custid'] ?> (Customer Details) - Tradee</title>
    </head>
    <body class="hold-transition sidebar-mini layout-fixed"  onload="addnew()">
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h4 class="m-0 text-dark" style="font-weight: bolder;"><?php echo $title; ?></h4>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="customer_list.php">Customers list</a></li>
                                <li class="breadcrumb-item active">Customer details</li>
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
                                        <div class="card card-primary">
                                            <div class="card-header">
                                                <h3 class="card-title">Personal Details</h3>
                                                <div class="card-tools" style="padding-top:10px">
                                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                                        <i class="fas fa-minus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="col-md-12">
                                                            <img class="img-fluid mb-12" src="<?php
                                                            if (isset($current_data)) {
                                                                echo $current_data["avatar"];
                                                            }
                                                            ?>" alt="Photo" style="width: 100%; height: 500px; padding-top: 10px" id="img_display" name="img_display">
                                                        </div>
                                                        <div class="col-md-12" >
                                                            <div class="form-group" style="padding-top: 15px">
                                                                <div class="custom-file">
                                                                    <input type="file" accept="image/*" onchange="loadFile(event)" class="custom-file-input" id="img" disabled name="img">
                                                                    <label class="custom-file-label" id="validate_img">Choose file</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Name :</label>
                                                            <input class="form-control" id="username" name="username" readonly value="<?php
                                                            if (isset($current_data)) {
                                                                echo $current_data["username"];
                                                            }
                                                            ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Contact :</label>
                                                            <input class="form-control" id="contact" name="contact" readonly value="<?php
                                                            if (isset($current_data)) {
                                                                echo $current_data["contact"];
                                                            }
                                                            ?>">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="inputGender">Gender</label>
                                                            <select class="custom-select" id="gender" name="gender" disabled>
                                                                <option value="F" <?php
                                                                if (isset($current_data)) {
                                                                    if ($current_data["gender"] == "F") {
                                                                        echo "selected";
                                                                    }
                                                                }
                                                                ?>>Female</option>
                                                                <option value="M" <?php
                                                                if (isset($current_data)) {
                                                                    if ($current_data["gender"] == "M") {
                                                                        echo "selected";
                                                                    }
                                                                }
                                                                ?>>Male</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="inputGender">Gender</label>
                                                            <div class="input-group">
                                                                <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                                                    <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                                                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                                                    </div>
                                                                    <input type="text" class="form-control datetimepicker-input" data-target="#reservationdate" value="<?php
                                                                    if (($_SESSION['loginuser']['birth']) !== null) {
                                                                        echo ($_SESSION['loginuser']['birth']);
                                                                    }
                                                                    ?>" id="birth" readOnly name="birth">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>Email :</label>
                                                            <input class="form-control" id="email" name="email" readonly value="<?php
                                                            if (isset($current_data)) {
                                                                echo $current_data["email"];
                                                            }
                                                            ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="card card-red">
                                            <div class="card-header">
                                                <h3 class="card-title">Reset/Set Password</h3>
                                                <div class="card-tools" style="padding-top:10px">
                                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                                        <i class="fas fa-minus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>Password :</label>
                                                            <input type="password" class="form-control" id="ps" name="ps" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>Re-Password :</label>
                                                            <input type="password" class="form-control" id="reps" readonly>
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
                                        <div class="card card-success">
                                            <div class="card-header">
                                                <h3 class="card-title">Address Details</h3>
                                                <div class="card-tools" style="padding-top:10px">
                                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                                        <i class="fas fa-minus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>Address 1 :</label>
                                                            <input class="form-control" id="address1" name="address1" readonly value="<?php
                                                            if (isset($current_data)) {
                                                                echo $current_data["address1"];
                                                            }
                                                            ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>Address 2 :</label>
                                                            <input class="form-control" id="address2" name="address2" readonly value="<?php
                                                            if (isset($current_data)) {
                                                                echo $current_data["address2"];
                                                            }
                                                            ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>City :</label>
                                                            <input class="form-control" id="city" name="city" readonly value="<?php
                                                            if (isset($current_data)) {
                                                                echo $current_data["city"];
                                                            }
                                                            ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>Post code :</label>
                                                            <input class="form-control" id="postcode" name="postcode" size="5" maxlength="5" onkeypress="return isNumberKey(event)" readonly value="<?php
                                                            if (isset($current_data)) {
                                                                echo $current_data["postcode"];
                                                            }
                                                            ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>State :</label>
                                                            <input class="form-control" id="state" name="state" readonly value="<?php
                                                            if (isset($current_data)) {
                                                                echo $current_data["state"];
                                                            }
                                                            ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>Country :</label>
                                                            <select class="custom-select" id="country" name="country" disabled>
                                                                <option value="Malaysia">Malaysia</option>
                                                                <option value="Singapore">Singapore</option>
                                                                <option value="Thailand">Thailand</option>
                                                                <option value="Hong Kong">Hong Kong</option>
                                                                <option value="China">China</option>
                                                                <option value="America">United States of America</option>

                                                                <option value="Malaysia" <?php
                                                                if (isset($current_data)) {
                                                                    if ($current_data["country"] == "Malaysia") {
                                                                        echo "selected";
                                                                    }
                                                                }
                                                                ?>>Malaysia</option>
                                                                <option value="Singapore" <?php
                                                                if (isset($current_data)) {
                                                                    if ($current_data["country"] == "Singapore") {
                                                                        echo "selected";
                                                                    }
                                                                }
                                                                ?>>Singapore</option>
                                                                <option value="Thailand" <?php
                                                                if (isset($current_data)) {
                                                                    if ($current_data["country"] == "Thailand") {
                                                                        echo "selected";
                                                                    }
                                                                }
                                                                ?>>Thailand</option>
                                                                <option value="China" <?php
                                                                if (isset($current_data)) {
                                                                    if ($current_data["country"] == "China") {
                                                                        echo "selected";
                                                                    }
                                                                }
                                                                ?>>China</option>
                                                                <option value="Taiwan" <?php
                                                                if (isset($current_data)) {
                                                                    if ($current_data["country"] == "Taiwan") {
                                                                        echo "selected";
                                                                    }
                                                                }
                                                                ?>>Taiwan</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="card card-warning">
                                            <div class="card-header">
                                                <h3 class="card-title">Activation</h3>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <select class="custom-select" id="activation" name="activation" disabled>
                                                                <option value="1" <?php
                                                                if (isset($current_data)) {
                                                                    if ($current_data["active"] == 1) {
                                                                        echo "selected";
                                                                    }
                                                                }
                                                                ?>>Blacklisted</option>
                                                                <option value="0" <?php
                                                                if (isset($current_data)) {
                                                                    if ($current_data["active"] == null) {
                                                                        echo "selected";
                                                                    }
                                                                }
                                                                ?>>Active</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <label>Registration Date :</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                                            </div>
                                                            <input type="text" class="form-control" placeholder="dd/mm/yyyy" id="registration_date" maxlength="10" value="<?php
                                                            if (isset($current_data)) {
                                                                echo $current_data["registration_date"];
                                                            }
                                                            ?>" readOnly name="registration_date">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group d-inline-block">
                                            <button type="button" class="btn btn-dark" id="btnback" onclick="back()">Back</button>
                                        </div>
                                        <div class="col-auto float-right">
                                            <button type="button" class="btn btn-primary btn-block" onclick="editorsave()" id="btnsave">Edit</button>
                                        </div>
                                        <div class="col-auto float-right">
                                            <button type="button" class="btn btn-warning btn-block" onclick="cancel()" id="btncancel" disabled>Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="col-md-12">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">Inventory Record</h3>
                                <div class="card-tools" style="padding-top:10px">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                        <i class="fas fa-minus"></i></button>
                                </div>
                            </div>
                            
                            <div class="card-body">
                                <table id="orderlisttable" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th style="width: 10%">Order Id</th>
                                            <th style="width: 10%">Date</th>
                                            <th style="width: 10%">Amount(RM)</th>
                                            <th style="width: 10%">Tax(RM)</th>
                                            <th style="width: 12%">Delivery fees(RM)</th>
                                            <th style="width: 10%">Net(RM)</th>
                                            <th style="width: 10%">Delivery status</th>
                                            <th style="width: 10%">Order status</th>
                                            <th style="width: auto"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
//                                        if ($current_data) {
//                                            $sql = "SELECT * FROM `order` WHERE custid = '" . $current_data["custid"] . "'";
//                                            $result = $dbc->query($sql);
//                                            if ($result->num_rows > 0) {
//                                                while ($row = $result->fetch_assoc()) {
//                                                    echo "<tr>"
//                                                    . "<td><a>" . $row["orderid"] . "</a></td>"
//                                                    . "<td><a>" . $row["order_date"] . "</a></td>"
//                                                    . "<td><a>" . $row["total_amount"] . "</a></td>"
//                                                    . "<td><a>" . $row["tax"] . "</a></td>"
//                                                    . "<td><a>" . $row["delivery_fees"] . "</a></td>"
//                                                    . "<td><a>" . $row["net_amount"] . "</a></td>"
//                                                    . "<td><a>" . $row["delivery_status"] . "</a></td>"
//                                                    . "<td><a>" . $row["order_status"] . "</a></td>"
//                                                    . "<td class='project-actions text-right'>"
//                                                    . "<a class='btn btn-primary btn-sm' style='width:100%' href='order_detail.php?action=view&orderid=" . $row["orderid"] . "'>"
//                                                    . "<i class=" . "'fas fa-folder'" . ">"
//                                                    . "</i> View</a></td></tr>";
//                                                }
//                                            }
//                                        }
                                        ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Order Id</th>
                                            <th>Date</th>
                                            <th>Amount(RM)</th>
                                            <th>Tax(RM)</th>
                                            <th>Delivery fees(RM)</th>
                                            <th>Net(RM)</th>
                                            <th>Delivery status</th>
                                            <th>Order status</th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
            </section>
        </div>
        <?php include 'footer.php'; ?>
    </body>
    <script>
        var currentURL = window.location.href;
        var isnew = false;

        function addnew() {
            var params = new window.URLSearchParams(window.location.search);
            if (!params.get('id')) {
                isnew = true;
                editing();
            }
        }

        function editorsave() {
            var btnoption = document.getElementById("btnsave").textContent;
            if (btnoption === "Save") {
                var fullfill = true;
                var message = "";

                document.getElementById("username").style.borderColor = "";
                document.getElementById("gender").style.borderColor = "";
                document.getElementById("contact").style.borderColor = "";
                document.getElementById("email").style.borderColor = "";
                document.getElementById("ps").style.borderColor = "";
                document.getElementById("reps").style.borderColor = "";
                document.getElementById("postcode").style.borderColor = "";

                if (document.getElementById("postcode").value) {
                    if (document.getElementById("postcode").value < 5) {
                        document.getElementById("postcode").style.borderColor = "red";
                        fullfill = false;
                    }
                }
                if (document.getElementById("contact").value) {
                    if (document.getElementById("contact").value < 5) {
                        document.getElementById("contact").style.borderColor = "red";
                        fullfill = false;
                    }
                }
                if (!document.getElementById("username").value || document.getElementById("username").value === "") {
                    document.getElementById("username").style.borderColor = "red";
                    fullfill = false;
                }
                if (!document.getElementById("contact").value || document.getElementById("contact").value === "") {
                    document.getElementById("contact").style.borderColor = "red";
                    fullfill = false;
                }
                if (!document.getElementById("gender").value || document.getElementById("gender").value === "") {
                    document.getElementById("gender").style.borderColor = "red";
                    fullfill = false;
                }
                if (!document.getElementById("email").value || document.getElementById("email").value === "") {
                    document.getElementById("email").style.borderColor = "red";
                    fullfill = false;
                } else {
                    var mailformat = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
                    if (!document.getElementById("email").value.match(mailformat)) {
                        document.getElementById("email").style.borderColor = "red";
                        fullfill = false;
                        message = message + "Invalid email !\n";
                    } else {
                        if (isnew) {
                            for (i = 0; i < Array_email.length; i++) {
                                if (Array_email[i] === document.getElementById("email").value) {
                                    document.getElementById("email").style.borderColor = "red";
                                    fullfill = false;
                                    message = message + "This email already been registered !\n";
                                    break;
                                }
                            }
                        } else {
                            if (document.getElementById("email").value !== current_data.email) {
                                for (i = 0; i < Array_email.length; i++) {
                                    if (Array_email[i] === document.getElementById("email").value) {
                                        document.getElementById("email").style.borderColor = "red";
                                        fullfill = false;
                                        message = message + "This email already been registered !\n";
                                        break;
                                    }
                                }
                            }
                        }
                    }
                }

                if (isnew) {
                    if (document.getElementById("ps").value.length < 8) {
                        document.getElementById("ps").style.borderColor = "red";
                        message = "Password must be more than 8 digit or alphapet !\n"
                        fullfill = false;
                    }
                    if (!document.getElementById("ps").value || document.getElementById("ps").value === "") {
                        document.getElementById("ps").style.borderColor = "red";
                        fullfill = false;
                    }
                    if (!document.getElementById("reps").value || document.getElementById("reps").value === "") {
                        document.getElementById("reps").style.borderColor = "red";
                        fullfill = false;
                    }
                    if (document.getElementById("ps").value !== document.getElementById("reps").value) {
                        document.getElementById("ps").style.borderColor = "red";
                        document.getElementById("reps").style.borderColor = "red";
                        message = message + "Password and Re password is not match !\n"
                        fullfill = false;
                    }
                } else {
                    if (document.getElementById("ps").value || document.getElementById("reps").value) {
                        if (document.getElementById("ps").value.length < 8) {
                            document.getElementById("ps").style.borderColor = "red";
                            message = message + "Password must be more than 8 digit or alphabet !\n"
                            fullfill = false;
                        }
                        if (document.getElementById("ps").value !== document.getElementById("reps").value) {
                            document.getElementById("ps").style.borderColor = "red";
                            document.getElementById("reps").style.borderColor = "red";
                            message = message + "Password and Re password is not match !\n"
                            fullfill = false;
                        }
                    }
                }

                if (fullfill) {
                    if (confirm("Confirm to save ?")) {
                        if (!document.getElementById("img").value) {
                            document.getElementById("img").value = null;
                        }
                        if (!document.getElementById("address1").value) {
                            document.getElementById("address1").value = null;
                        }
                        if (!document.getElementById("address2").value) {
                            document.getElementById("address2").value = null;
                        }
                        if (!document.getElementById("city").value) {
                            document.getElementById("city").value = null;
                        }
                        if (!document.getElementById("postcode").value) {
                            document.getElementById("postcode").value = null;
                        }
                        if (!document.getElementById("state").value) {
                            document.getElementById("state").value = null;
                        }
                        if (!document.getElementById("country").value) {
                            document.getElementById("country").value = null;
                        }
                        if (!document.getElementById("activation").value) {
                            document.getElementById("activation").value = "'null'";
                        }
                        document.getElementById("form").submit();
                    }
                } else {
                    alert("Inputs with red border are required field!\n" + message);
                }

            } else {
                editing();
            }
        }

        function editing() {
            document.getElementById("btnsave").textContent = "Save";
            document.getElementById("btncancel").disabled = false;
            document.getElementById("img").disabled = false;
            document.getElementById("username").readOnly = false;
            document.getElementById("contact").readOnly = false;
            document.getElementById("gender").disabled = false;
            document.getElementById("birth").readOnly = false;
            document.getElementById("email").readOnly = false;
            document.getElementById("address1").readOnly = false;
            document.getElementById("address2").readOnly = false;
            document.getElementById("city").readOnly = false;
            document.getElementById("postcode").readOnly = false;
            document.getElementById("state").readOnly = false;
            document.getElementById("country").disabled = false;
            document.getElementById("ps").readOnly = false;
            document.getElementById("reps").readOnly = false;
            document.getElementById("activation").disabled = false;
        }

        function back() {
            var btnoption = document.getElementById("btnsave").textContent;
            if (btnoption === "Save") {
                if (confirm("Confirm to unsave?")) {
                    window.location.href = "customer_list.php";
                }
            } else {
                window.location.href = "customer_list.php";
            }
        }

        $('#orderlisttable').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true
        });

        function cancel() {
            if (isnew) {
                if (confirm("Confirm to cancel insert new customer and redirect to Customer list ?")) {
                    window.location.href = "customer_list.php";
                }
            } else {
                if (confirm("Confirm to unsave current information ?")) {
                    window.location.href = currentURL;
                }
            }
        }

        function isNumberKey(evt) {
            var charCode = (evt.which) ? evt.which : event.keyCode;

            if (charCode > 31 && (charCode !== 46 && (charCode < 48 || charCode > 57)))
                return false;

            if (charCode === 46 && charCode === ".")
                return false;

            if (charCode === ".") {
                var number = [];
                number = charCode.split(".");
                if (number[1].length === decimalPts)
                    return false;
            }
            return true;
        }

        function validate(evt) {
            var theEvent = evt || window.event;
            if (theEvent.type === 'paste') {
                key = event.clipboardData.getData('text/plain');
            } else {
                var key = theEvent.keyCode || theEvent.which;
                key = String.fromCharCode(key);
            }
            var regex = /[0-9]|\./;
            if (!regex.test(key)) {
                theEvent.returnValue = false;
                if (theEvent.preventDefault)
                    theEvent.preventDefault();
            }
        }

        var loadFile = function (event) {
            var image = document.getElementById('img_display');
            image.src = URL.createObjectURL(event.target.files[0]);
        };
        
        //Date picker
        $('#reservationdate').datetimepicker({
            format: 'L'
        });
    </script>
</html>