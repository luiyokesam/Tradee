<?php
$page = 'admin_list';
include 'navbar.php';

echo '<script>var current_admin = ' . json_encode($current_admin) . ';</script>';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM admin WHERE adminid = '$id' LIMIT 1";
    $result = $dbc->query($sql);
    if ($result->num_rows > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $current_data = $row;
            $title = "Admin Details - {$current_data['adminid']}";
            echo '<script>var current_data = ' . json_encode($current_data) . ';</script>';
            $view = true;
            break;
        }
    } else {
        echo '<script>alert("Extract data error !\nContact IT department for maintainence");window.location.href = "admin_list.php";</script>';
    }
} else {
    $sql = "SELECT adminid FROM admin ORDER BY adminid DESC LIMIT 1";
    $result = $dbc->query($sql);
    if ($result->num_rows > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $latestnum = ((int) substr($row['adminid'], 1)) + 1;
            $newid = "A{$latestnum}";
            $title = "New admin ({$newid})";
            echo '<script>var current_data = null;</script>';
            $view = false;
            break;
        }
    } else {
        $newid = "A10001";
        $title = "A10001 (NEW)";
        echo '<script>var current_data = null;</script>';
        $view = false;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($view) {
        if ($_POST['ps'] === "" || !isset($_POST['ps'])) {
            $ps = $current_data['password'];
        } else {
            $ps = $_POST['ps'];
        }

        $sql = "UPDATE admin SET "
                . "name='" . $_POST['name'] . "',"
                . "phone='" . $_POST['phone'] . "',"
                . "email='" . $_POST['email'] . "',"
                . "manager='" . $_POST['manager'] . "',"
                . "position='" . $_POST['position'] . "',"
                . "password='" . $ps . "',"
                . "activation='" . $_POST['activation'] . "'"
                . "WHERE adminid ='" . $current_data['adminid'] . "'";

        if ($dbc->query($sql)) {
            echo '<script>alert("Successfuly update !");var currentURL = window.location.href;window.location.href = currentURL;</script>';
        } else {
            echo '<script>alert("Update fail !\nContact IT department for maintainence");var currentURL = window.location.href;window.location.href = currentURL;</script>';
        }
    } else {
        $sql = "INSERT INTO admin(adminid, password, phone, name, email, position, manager, activation) VALUES ("
                . "'" . $newid . "',"
                . "'" . $_POST['ps'] . "',"
                . "'" . $_POST['phone'] . "',"
                . "'" . $_POST['name'] . "',"
                . "'" . $_POST['email'] . "',"
                . "'" . $_POST['position'] . "',"
                . "'" . $_POST['manager'] . "',"
                . "'" . $_POST['activation'] . "')";

        if ($dbc->query($sql)) {
            ob_end_clean();
            echo '<script>alert("Successfuly insert !");window.location.href = "admin_list.php?id=' . $newid . '";</script>';
            exit();
        } else {
            echo '<script>alert("Insert fail !\nContact IT department for maintainence");var currentURL = window.location.href;window.location.href = currentURL;</script>';
        }
    }
}
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Admin <?php echo $current_data['adminid'] ?> - Tradee</title>
    </head>
    <body class="hold-transition sidebar-mini layout-fixed" onload="loadform()">
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h4 class="m-0 text-dark" style="font-weight: bold;"><?php echo $title; ?></h4>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="admin_list.php">Admin list</a></li>
                                <li class="breadcrumb-item active">Admin details</li>
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
                                                <h3 class="card-title">Personal details</h3>
                                                <div class="card-tools" style="padding-top:10px">
                                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                                        <i class="fas fa-minus"></i>
                                                    </button>
                                                </div>
                                            </div>

                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-7">
                                                        <div class="form-group">
                                                            <label>Name :</label>
                                                            <input class="form-control" id="name" name="name" readonly value="<?php
                                                            if (isset($current_data)) {
                                                                echo $current_data['name'];
                                                            }
                                                            ?>">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-5">
                                                        <div class="form-group">
                                                            <label>Contact :</label>
                                                            <input class="form-control" id="phone" name="phone" readonly value="<?php
                                                            if (isset($current_data)) {
                                                                echo $current_data['phone'];
                                                            }
                                                            ?>">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>Email :</label>
                                                            <input class="form-control" id="email" name="email" readonly value="<?php
                                                            if (isset($current_data)) {
                                                                echo $current_data['email'];
                                                            }
                                                            ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="card card-success">
                                            <div class="card-header">
                                                <h3 class="card-title ">Career details</h3>
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
                                                            <label>Manager :</label>
                                                            <select class="custom-select" id="manager" name="manager" disabled>
                                                                <option value="" <?php
                                                                if (isset($current_data)) {
                                                                    if ($current_data["manager"] == "") {
                                                                        echo "selected";
                                                                    }
                                                                } else {
                                                                    echo "selected";
                                                                }
                                                                ?>>None</option>
                                                                        <?php
                                                                        $sql1 = "SELECT name FROM admin WHERE position = 'Manager'";
                                                                        $result1 = $dbc->query($sql1);
                                                                        if ($result1->num_rows > 0) {
                                                                            while ($row = mysqli_fetch_array($result1)) {
                                                                                $selected = ($current_data["manager"] == $row['name']) ? "selected" : "";
                                                                                echo '<option ' . $selected . ' value="' . $row['name'] . '">' . $row['name'] . '</option>';
                                                                            }
                                                                        }
                                                                        ?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>Position :</label>
                                                            <select class="custom-select" id="position" name="position" disabled>
                                                                <option value="Admin" <?php
                                                                if (isset($current_data)) {
                                                                    if ($current_data["position"] == "Admin") {
                                                                        echo "selected";
                                                                    }
                                                                }
                                                                ?>>Admin</option>
                                                                <option value="Manager" <?php
                                                                if (isset($current_data)) {
                                                                    if ($current_data["position"] == "Manager") {
                                                                        echo "selected";
                                                                    }
                                                                }
                                                                ?>>Manager</option>
                                                                <option value="Staff" <?php
                                                                if (isset($current_data)) {
                                                                    if ($current_data["position"] == "Staff") {
                                                                        echo "selected";
                                                                    }
                                                                }
                                                                ?>>Staff</option>
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
                                        <div class="card card-info">
                                            <div class="card-header">
                                                <h3 class="card-title" >Account details</h3>
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
                                                            <label>Re-type Password :</label>
                                                            <input type="password" class="form-control" id="reps" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="card card-warning" >
                                            <div class="card-header">
                                                <h3 class="card-title" style="color: whitesmoke;">Activation</h3>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <select class="custom-select" id="activation" name="activation" disabled>
                                                                <option value="1" <?php
                                                                if (isset($current_data)) {
                                                                    if ($current_data["activation"] == 1) {
                                                                        echo "selected";
                                                                    }
                                                                }
                                                                ?>>Active</option>
                                                                <option value="0" <?php
                                                                if (isset($current_data)) {
                                                                    if ($current_data["activation"] == 0) {
                                                                        echo "selected";
                                                                    }
                                                                }
                                                                ?>>Inactive</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="row" style="padding-bottom: 10px">
                        <div class="col-md-10"></div>

                        <div class="col-md-1 float-sm-right" style="padding-bottom: 10px">
                            <button class="btn btn-danger btn-block" onclick="cancel()" id="btncancel" disabled>Cancel</button>
                        </div>

                        <div class="col-md-1">
                            <button class="btn btn-warning btn-block" style="color: whitesmoke;" onclick="editorsave()" id="btnsave">Edit</button>
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

        function loadform() {
            if (current_admin.position === "Admin") {
                if (current_admin.adminid !== current_data.adminid) {
                    document.getElementById("btnsave").disabled = true;
                }
            } else {
                var params = new window.URLSearchParams(window.location.search);
                if (!params.get('id')) {
                    isnew = true;
                    editable();
                }
            }
        }

        function editorsave() {
            if (document.getElementById("btnsave").textContent === "Save") {
                var fullfill = true;
                var message = "";
                document.getElementById("name").style.borderColor = "";
                document.getElementById("phone").style.borderColor = "";
                document.getElementById("email").style.borderColor = "";
                document.getElementById("ps").style.borderColor = "";
                document.getElementById("reps").style.borderColor = "";

                if (!document.getElementById("name").value || document.getElementById("name").value === "") {
                    document.getElementById("name").style.borderColor = "red";
                    fullfill = false;
                }
                if (!document.getElementById("phone").value || document.getElementById("phone").value === "") {
                    document.getElementById("phone").style.borderColor = "red";
                    fullfill = false;
                }
                if (!document.getElementById("email").value || document.getElementById("email").value === "") {
                    document.getElementById("email").style.borderColor = "red";
                    fullfill = false;
                }
                if (document.getElementById("email").value) {
                    var mailformat = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
                    if (!document.getElementById("email").value.match(mailformat)) {
                        document.getElementById("email").style.borderColor = "red";
                        fullfill = false;
                        message = "Invalid email!\n";
                    }
                }

                if (isnew) {
                    if (document.getElementById("ps").value.length < 8) {
                        document.getElementById("ps").style.borderColor = "red";
                        message = "Password must be more than 8 digit or alphapet.\n"
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
                        message = message + "Password and Re-password are not match!\n"
                        fullfill = false;
                    }
                } else {
                    if (document.getElementById("ps").value || document.getElementById("reps").value) {
                        if (document.getElementById("ps").value.length < 8) {
                            document.getElementById("ps").style.borderColor = "red";
                            message = message + "Password must be more than 8 digit or alphapet.\n"
                            fullfill = false;
                        }
                        if (document.getElementById("ps").value !== document.getElementById("reps").value) {
                            document.getElementById("ps").style.borderColor = "red";
                            document.getElementById("reps").style.borderColor = "red";
                            message = message + "Password and Re password is not match.\n"
                            fullfill = false;
                        }
                    }
                }

                if (fullfill) {
                    if (confirm("Confirm to save?")) {
                        document.getElementById("manager").disabled = false;
                        document.getElementById("position").disabled = false;
                        document.getElementById("activation").disabled = false;
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
                if (confirm("Confirm to cancel insert new admin and redirect to Admin list?\n")) {
                    window.location.href = "admin_list.php";
                }
            } else {
                if (confirm("Confirm to unsave current information?")) {
                    window.location.href = currentURL;
                }
            }
        }

        function editable() {
            document.getElementById("btnsave").textContent = "Save";
            document.getElementById("btncancel").disabled = false;
            document.getElementById("name").readOnly = false;
            document.getElementById("phone").readOnly = false;
            document.getElementById("email").readOnly = false;
            if (current_admin.position === "Admin") {
                document.getElementById("ps").readOnly = false;
                document.getElementById("reps").readOnly = false;
            }
            if (current_admin.position === "Manager") {
                document.getElementById("manager").disabled = false;
                document.getElementById("position").disabled = false;
                document.getElementById("activation").disabled = false;

                document.getElementById("ps").readOnly = false;
                document.getElementById("reps").readOnly = false;
            }
        }
    </script>
</html>