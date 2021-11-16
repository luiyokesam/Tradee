<?php
include 'navbar.php';

$category_array = array();
$sql = "SELECT name FROM event_type";
$result = $dbc->query($sql);
if ($result->num_rows > 0) {
    while ($row = mysqli_fetch_array($result)) {
        $category_array[] = $row['name'];
    }
}

$staff_array = array();
$sqladmin = "SELECT name FROM admin";
$resultadmin = $dbc->query($sqladmin);
if ($resultadmin->num_rows > 0) {
    while ($row = mysqli_fetch_array($resultadmin)) {
        $staff_array[] = $row['name'];
    }
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM event e, event_image i WHERE e.eventid = i.eventid AND e.eventid = '$id' LIMIT 1";
    $result = $dbc->query($sql);
    if ($result->num_rows > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $current_data = $row;
            $Array_Image = array();
            $sql2 = "SELECT `img` FROM `event_image` WHERE `eventid` = '$id'";
            $result2 = $dbc->query($sql2);
            if ($result2->num_rows > 0) {
                while ($row = mysqli_fetch_array($result2)) {
                    array_push($Array_Image, $row[0]);
                }
            }
            break;
        }
    } else {
        echo '<script>alert("Extract data error !\nContact IT department for maintainence");window.location.href = "event_list.php";</script>';
    }
} else {
    $sql = "SELECT eventid FROM event ORDER BY eventid DESC LIMIT 1";
    $result = $dbc->query($sql);
    if ($result->num_rows > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $latestnum = ((int) substr($row['eventid'], 1)) + 1;
            $newid = "E{$latestnum}";
            break;
        }
    } else {
        $newid = "E10001";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_GET['id'])) {

        if (is_uploaded_file($_FILES["img"]["tmp_name"][0])) {
            $length = count($Array_Image);
            for ($x = 0; $x < $length; $x++) {
                if (file_exists($Array_Image[$x])) {
//                    echo '<script>alert("' . 1 . '");</script>';
                    unlink($Array_Image[$x]);
                }
            }

            $sql_Delete_Image = "DELETE FROM `event_image` WHERE `eventid` = '{$current_data["eventid"]}'";
            if ($dbc->query($sql_Delete_Image)) {
                $Count_Image = count($_FILES['img']['name']);
                for ($i = 0; $i < $Count_Image; $i++) {
                    $image_path = "../data/event_img/{$current_data["eventid"]}_{$i}";
                    if (file_exists($image_path)) {
                        unlink($image_path);
                    }
                    move_uploaded_file($_FILES["img"]["tmp_name"][$i], $image_path);
                    $sql = "INSERT INTO `event_image`(`eventid`, `img`) VALUES ('{$current_data["eventid"]}','{$image_path}')";
                    if (!$dbc->query($sql)) {
                        echo '<script>console.log("Error Insert Image !");</script>';
                    }
                }
            }
        }

        $sql2 = "UPDATE event"
                . " SET title='" . $_POST['title'] . "', "
                . "type='" . $_POST['type'] . "', "
                . "receiver='" . $_POST['receiver'] . "', "
                . "principal='" . $_POST['principal'] . "', "
                . "contact='" . $_POST['contact'] . "', "
                . "adminid='" . $_POST['adminid'] . "', "
                . "address1='" . $_POST['address1'] . "', "
                . "address2='" . $_POST['address2'] . "', "
                . "postcode='" . $_POST['postcode'] . "', "
                . "state='" . $_POST['state'] . "', "
                . "country='" . $_POST['country'] . "', "
                . "endEvent='" . $_POST['endEvent'] . "', "
                . "status='" . $_POST['status'] . "', "
                . "description='" . $_POST['description'] . "' "
                . "WHERE eventid ='" . $current_data["eventid"] . "'";

        if ($dbc->query($sql2)) {
            echo '<script>alert("Event update successfuly!");var currentURL = window.location.href;window.location.href = currentURL;</script>';
        } else {
            echo '<script>alert("Failed to update event!\nPlease contact to our IT department for maintainence.")</script>';
        }
    } else {
        $Count_Image = count($_FILES['img']['name']);
        for ($i = 0; $i < $Count_Image; $i++) {
            $image_path = "../data/event_img/{$newid}_$i";
            move_uploaded_file($_FILES["img"]["tmp_name"][$i], $image_path);
            $sql = "INSERT INTO `event_image`(`eventid`, `img`) VALUES ('$newid','{$image_path}')";
            if (!$dbc->query($sql)) {
                echo '<script>console.log("Error Insert Image !");</script>';
            }
        }

        $sql2 = "INSERT INTO event(eventid,adminid,title,contact,description,type,receiver,principal,address1,address2,postcode,state,country,endEvent,status)VALUES("
                . "'" . $newid . "',"
                . "'" . $_POST['adminid'] . "',"
                . "'" . $_POST['title'] . "',"
                . "'" . $_POST['contact'] . "',"
                . "'" . $_POST['description'] . "',"
                . "'" . $_POST['type'] . "',"
                . "'" . $_POST['receiver'] . "',"
                . "'" . $_POST['principal'] . "',"
                . "'" . $_POST['address1'] . "',"
                . "'" . $_POST['address2'] . "',"
                . "'" . $_POST['postcode'] . "',"
                . "'" . $_POST['state'] . "',"
                . "'" . $_POST['country'] . "',"
                . "'" . $_POST['endEvent'] . "',"
                . "'" . $_POST['status'] . "')";

        if ($dbc->query($sql2)) {
            echo '<script>alert("New event added successfuly!");window.location.href="event_details.php?id=' . $newid . '";</script>';
        } else {
            echo '<script>alert("Failed to add new event!\nPlease contact to our IT department for maintainence.")</script>';
        }
    }
}
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php
            if (isset($current_data)) {
                echo "{$current_data["eventid"]} Event";
            } else {
                echo "New Event";
            }
            ?> - Tradee</title>
    </head>
    <body class="hold-transition sidebar-mini layout-fixed" onload="addnew()">
        <div class="wrapper">
            <div class="content-wrapper">
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="event_list.php">Event list</a></li>
                                    <li class="breadcrumb-item active">Event details</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

                <section class="content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-warning">
                                <div class="card-header">
                                    <h3 class="card-title" id="eventid" style="font-weight: bold;">Event ID: <?php
                                        if (isset($current_data)) {
                                            echo $current_data["eventid"];
                                        } else {
                                            echo $newid . " (New)";
                                        }
                                        ?></h3>
                                </div>

                                <div class="card-body">
                                    <form method="post" id="form" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-6">  
                                                        <label>Title :</label>
                                                        <div class="form-group">                                             
                                                            <input class="form-control" id="title" name="title" readOnly value="<?php
                                                            if (isset($current_data)) {
                                                                echo $current_data["title"];
                                                            }
                                                            ?>">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label>Receiver :</label>
                                                        <div class="form-group">                                             
                                                            <input class="form-control" id="receiver" name="receiver" readOnly value="<?php
                                                            if (isset($current_data)) {
                                                                echo $current_data["receiver"];
                                                            }
                                                            ?>">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-5">
                                                        <label>Person In-Charge :</label>
                                                        <div class="form-group">                                             
                                                            <input class="form-control" id="principal" name="principal" readOnly value="<?php
                                                            if (isset($current_data)) {
                                                                echo $current_data["principal"];
                                                            }
                                                            ?>">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <label>Contact :</label>
                                                        <div class="form-group">                                             
                                                            <input class="form-control" id="contact" name="contact" readOnly value="<?php
                                                            if (isset($current_data)) {
                                                                echo $current_data["contact"];
                                                            }
                                                            ?>">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label>Type :</label>
                                                        <div class="form-group">
                                                            <select class="custom-select" id="type" name="type" disabled>
                                                                <option value="">--Select--</option>
                                                                <?php
                                                                foreach ($category_array as $selection) {
                                                                    $selected = ($current_data["type"] == $selection) ? "selected" : "";
                                                                    echo '<option ' . $selected . ' value="' . $selection . '">' . $selection . '</option>';
                                                                }
                                                                echo '</select>';
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-12" style="font-weight: bolder; font-size: 1.1em;">Address</div>

                                                    <div class="col-md-6">
                                                        <label>Line 1 :</label>
                                                        <div class="form-group">                                             
                                                            <input class="form-control" id="address1" name="address1" readOnly value="<?php
                                                            if (isset($current_data)) {
                                                                echo $current_data["address1"];
                                                            }
                                                            ?>">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label>Line 2 :</label>
                                                        <div class="form-group">                                             
                                                            <input class="form-control" id="address2" name="address2" readOnly value="<?php
                                                            if (isset($current_data)) {
                                                                echo $current_data["address2"];
                                                            }
                                                            ?>">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label>Postal Code :</label>
                                                        <div class="form-group">                                             
                                                            <input class="form-control" id="postcode" name="postcode" readOnly value="<?php
                                                            if (isset($current_data)) {
                                                                echo $current_data["postcode"];
                                                            }
                                                            ?>">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label>State :</label>
                                                        <div class="form-group">                                             
                                                            <input class="form-control" id="state" name="state" readOnly value="<?php
                                                            if (isset($current_data)) {
                                                                echo $current_data["state"];
                                                            }
                                                            ?>">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label>Country :</label>
                                                        <div class="form-group">                                             
                                                            <input class="form-control" id="country" name="country" readOnly value="<?php
                                                            if (isset($current_data)) {
                                                                echo $current_data["country"];
                                                            }
                                                            ?>">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label>Staff Incharge :</label>
                                                        <div class="form-group">                                             
                                                            <select class="custom-select" id="adminid" name="adminid" disabled>
                                                                <?php
                                                                foreach ($staff_array as $selection) {
                                                                    $selected = ($current_data["name"] == $selection) ? "selected" : "";
                                                                    echo '<option ' . $selected . ' value="' . $selection . '">' . $selection . '</option>';
                                                                }
                                                                echo '</select>';
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label>End Date :</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                                            </div>
                                                            <input type="text" class="form-control" placeholder="dd/mm/yyyy" id="endEvent" maxlength="10" value="<?php
                                                            if (isset($current_data)) {
                                                                echo $current_data["endEvent"];
                                                            }
                                                            ?>" readOnly name="endEvent">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label>Status :</label>
                                                        <select class="custom-select" id="status" name="status" disabled>
                                                            <option value="Pending" <?php
                                                            if (isset($current_data['status']) && $current_data['status'] == 'Pending') {
                                                                echo 'selected';
                                                            }
                                                            ?>>Pending</option>
                                                            <option value="In-Progress" <?php
                                                            if (isset($current_data['status']) && $current_data['status'] == 'In-Progress') {
                                                                echo 'selected';
                                                            }
                                                            ?>>In-Progress</option>
                                                            <option value="Ended" <?php
                                                            if (isset($current_data['status']) && $current_data['status'] == 'Ended') {
                                                                echo 'selected';
                                                            }
                                                            ?>>Ended</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <label>Description :</label>
                                                        <div class="form-group">
                                                            <textarea class="form-control" rows="5" id="description" readOnly name="description"><?php
                                                                if (isset($current_data)) {
                                                                    echo $current_data["description"];
                                                                }
                                                                ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="col-12 img-container" style="width: 1000px; height: 400px">
                                                            <img src="../img/event/drop_img.jpg" class="active-image" style="width: 100%; height: 400px;" alt="Product Image">
                                                        </div>

                                                        <div class="col-12 product-image-thumbs mt-3">
                                                            <div class="product-image-thumb product-small-img mr-2 p-1 active" style="width: 80px; max-width: 80px; height: 80px; max-height: 80px;">
                                                                <img class="img-fluid" src="<?php
                                                                if (isset($Array_Image)) {
                                                                    echo $Array_Image[0];
                                                                }
                                                                ?>" alt="Photo" style="height: auto; max-height: 70px; width: 70px; max-width: 70px" id="img_display0" name="img_display">
                                                            </div>

                                                            <div class="product-image-thumb product-small-img mr-2 p-1" style="width: 80px; max-width: 80px; height: 80px; max-height: 80px;">
                                                                <img class="img-fluid" src="<?php
                                                                if (isset($Array_Image)) {
                                                                    echo $Array_Image[1];
                                                                }
                                                                ?>" alt="Photo" style="height: auto; max-height: 70px; width: 70px; max-width: 70px" id="img_display1" name="img_display">
                                                            </div>

                                                            <div class="product-image-thumb product-small-img mr-2 p-1" style="width: 80px; max-width: 80px; height: 80px; max-height: 80px;">
                                                                <img class="img-fluid" src="<?php
                                                                if (isset($Array_Image)) {
                                                                    echo $Array_Image[2];
                                                                }
                                                                ?>" alt="Photo" style="height: auto; max-height: 70px; width: 70px; max-width: 70px" id="img_display2" name="img_display">
                                                            </div>

                                                            <div class="product-image-thumb product-small-img mr-2 p-1" style="width: 80px; max-width: 80px; height: 80px; max-height: 80px;">
                                                                <img class="img-fluid" src="<?php
                                                                if (isset($Array_Image)) {
                                                                    echo $Array_Image[3];
                                                                }
                                                                ?>" alt="Photo" style="height: auto; max-height: 70px; width: 70px; max-width: 70px" id="img_display3" name="img_display">
                                                            </div>

                                                            <div class="product-image-thumb product-small-img mr-2 p-1" style="width: 80px; max-width: 80px; height: 80px; max-height: 80px;">
                                                                <img class="img-fluid" src="<?php
                                                                if (isset($Array_Image)) {
                                                                    echo $Array_Image[4];
                                                                }
                                                                ?>" alt="Photo" style="height: auto; max-height: 70px; width: 70px; max-width: 70px" id="img_display4" name="img_display">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12" >
                                                            <div class="form-group" style="padding-top: 15px">
                                                                <div class="custom-file">
                                                                    <input type="file" multiple="multiple" accept="image/*" onchange="loadFile(event)" class="custom-file-input" id="img" disabled name="img[]">
                                                                    <label class="custom-file-label" id="validate_img">Choose file</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <button type="button" class="btn btn-dark" style="width:100%" id="btnback" onclick="back()">Back</button>
                                        </div>
                                    </div>

                                    <div class="col-md-9"></div>

                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <button type="button" class="btn btn-warning" style="width:100%" id="btncancel" onclick="cancel()" disabled>Cancel</button>
                                        </div>
                                    </div>

                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <button type="button" class="btn btn-primary" style="width:100%" id="btnsave" onclick="editorsave()">Edit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Donation List</h3>
                                </div>
                                <div class="card-body">
                                    <table id="donationtable" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th style="width: 22%">Donate ID</th>
                                                <th style="width: 22%">Event ID</th>
                                                <th style="width: 22%">Donator</th>
                                                <th style="width: 22%">Item ID</th>
                                                <th style="width: auto"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (isset($current_data)) {
                                                $sql = "SELECT * FROM donation WHERE eventid = '" . $current_data['eventid'] . "'";
                                                $result = $dbc->query($sql);
                                                if ($result) {
                                                    while ($row = $result->fetch_assoc()) {
                                                        echo "<td><a>" . $row["donateid"] . "</a></td>"
                                                        . "<td><a>" . $row["eventid"] . "</a></td>"
                                                        . "<td><a>" . $row["donator"] . "</a></td>"
                                                        . "<td><a>" . $row["itemid"] . "</a></td>"
                                                        . "<td class='project-actions text-right'>"
                                                        . "<a class=" . "'btn btn-info btn-block'" . "href=" . "'item_details.php?id=" . $row["itemid"] . "'>"
                                                        . "<i class=" . "'far fa-eye'" . ">"
                                                        . "</i></a></td></tr>";
                                                    }
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <?php include 'footer.php'; ?>
    </body>
    <script>
        var currentURL = window.location.href;
        var output = document.getElementById("endEvent");
        var isnew = false;

        function back() {
            var btnoption = document.getElementById("btnsave").textContent;
            if (btnoption === "Save") {
                if (confirm("Confirm to unsave ?")) {
                    window.location.href = "event_list.php";
                }
            } else {
                window.location.href = "event_list.php";
            }
        }

        var dateInputMask = function dateInputMask(elm) {
            elm.addEventListener('keypress', function (e) {
                if (e.keyCode < 47 || e.keyCode > 57) {
                    e.preventDefault();
                }

                var len = elm.value.length;

                if (len !== 1 || len !== 3) {
                    if (e.keyCode === 47) {
                        e.preventDefault();
                    }
                }

                if (len === 2) {
                    elm.value += '/';
                }

                if (len === 5) {
                    elm.value += '/';
                }
            });
        };

        dateInputMask(output);

        function addnew() {
            var params = new window.URLSearchParams(window.location.search);
            if (!params.get('id')) {
                isnew = true;
                editable();
//                var today = new Date();
//                var dd = String(today.getDate()).padStart(2, '0');
//                var mm = String(today.getMonth() + 1).padStart(2, '0');
//                var yyyy = today.getFullYear();
//                document.getElementById("startEvent").value = dd + '/' + mm + '/' + yyyy;
            }
        }

        function editorsave() {
            var btnoption = document.getElementById("btnsave").textContent;
            if (btnoption === "Save") {
                var fullfill = true;
                document.getElementById("title").style.borderColor = "";
                document.getElementById("type").style.borderColor = "";
                document.getElementById("receiver").style.borderColor = "";
                document.getElementById("principal").style.borderColor = "";
                document.getElementById("contact").style.borderColor = "";
                document.getElementById("adminid").style.borderColor = "";
                document.getElementById("address1").style.borderColor = "";
                document.getElementById("address2").style.borderColor = "";
                document.getElementById("postcode").style.borderColor = "";
                document.getElementById("state").style.borderColor = "";
                document.getElementById("country").style.borderColor = "";
                document.getElementById("endEvent").style.borderColor = "";
                document.getElementById("status").style.borderColor = "";
                document.getElementById("description").style.borderColor = "";
                document.getElementById("validate_img").style.borderColor = "";

                if (!document.getElementById("title").value || document.getElementById("title").value === "") {
                    document.getElementById("title").style.borderColor = "red";
                    fullfill = false;
                }
                if (!document.getElementById("type").value || document.getElementById("type").value === "") {
                    document.getElementById("type").style.borderColor = "red";
                    fullfill = false;
                }
                if (!document.getElementById("receiver").value || document.getElementById("receiver").value === "") {
                    document.getElementById("receiver").style.borderColor = "red";
                    fullfill = false;
                }
                if (!document.getElementById("contact").value || document.getElementById("contact").value === "") {
                    document.getElementById("contact").style.borderColor = "red";
                    fullfill = false;
                }
                if (!document.getElementById("adminid").value || document.getElementById("adminid").value === "") {
                    document.getElementById("adminid").style.borderColor = "red";
                    fullfill = false;
                }
                if (!document.getElementById("address1").value || document.getElementById("address1").value === "") {
                    document.getElementById("address1").style.borderColor = "red";
                    fullfill = false;
                }
                if (!document.getElementById("address2").value || document.getElementById("address2").value === "") {
                    document.getElementById("address2").style.borderColor = "red";
                    fullfill = false;
                }
                if (!document.getElementById("postcode").value || document.getElementById("postcode").value === "") {
                    document.getElementById("postcode").style.borderColor = "red";
                    fullfill = false;
                }
                if (!document.getElementById("state").value || document.getElementById("state").value === "") {
                    document.getElementById("state").style.borderColor = "red";
                    fullfill = false;
                }
                if (!document.getElementById("country").value || document.getElementById("country").value === "") {
                    document.getElementById("country").style.borderColor = "red";
                    fullfill = false;
                }
                if (!document.getElementById("endEvent").value || document.getElementById("endEvent").value === "") {
                    document.getElementById("endEvent").style.borderColor = "red";
                    fullfill = false;
                }
                if (!document.getElementById("status").value || document.getElementById("status").value === "") {
                    document.getElementById("status").style.borderColor = "red";
                    fullfill = false;
                }
                if (!document.getElementById("description").value || document.getElementById("description").value === "") {
                    document.getElementById("description").style.borderColor = "red";
                    fullfill = false;
                }
                var img = document.getElementById('img_display');
                if (!document.getElementById("img").value || document.getElementById("img").value === "") {
                    if (img.getAttribute('src') === "") {
                        document.getElementById("validate_img").style.borderColor = "red";
                        fullfill = false;
                    }
                }

                if (fullfill) {
                    if (confirm("Confirm to save ?")) {
                        document.getElementById("form").submit();
                    }
                } else {
                    alert("Inputs with red border are required field !");
                }

            } else {
                editable();
            }
        }

        function editable() {
            document.getElementById("btnsave").textContent = "Save";
            document.getElementById("btncancel").disabled = false;
            document.getElementById("img").disabled = false;
            document.getElementById("title").readOnly = false;
            document.getElementById("type").disabled = false;
            document.getElementById("receiver").readOnly = false;
            document.getElementById("principal").readOnly = false;
            document.getElementById("contact").readOnly = false;
            document.getElementById("adminid").disabled = false;
            document.getElementById("address1").readOnly = false;
            document.getElementById("address2").readOnly = false;
            document.getElementById("postcode").readOnly = false;
            document.getElementById("state").readOnly = false;
            document.getElementById("country").readOnly = false;
            document.getElementById("endEvent").readOnly = false;
            document.getElementById("description").readOnly = false;
            document.getElementById("status").disabled = false;
        }

        function cancel() {
            if (confirm("Confirm to unsave current information!")) {
                if (isnew) {
                    window.location.href = "event_list.php";
                } else {
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
                if (number[1].length === decimalPts) {
                    return false;
                }
            }
            return true;
        }

        $('#donationtable').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true
        });

        var loadFile = function (event) {
            for (i = 0; i < 5; i++) {
                document.getElementById("img_display" + i + "").src = "";
            }

            if (event.target.files.length < 6) {
                for (i = 0; i < event.target.files.length; i++) {
                    document.getElementById("img_display" + i + "").src = URL.createObjectURL(event.target.files[i]);
                }
            }
        };

        function imageGallery(smallImg) {
            var fullImg = document.getElementById("imageBox");
            fullImg.src = smallImg.src;
        }

        $(document).ready(function () {
            $('.product-image-thumb').on('click', function () {
                var $image_element = $(this).find('img')
                $('.active-image').prop('src', $image_element.attr('src'))
                $('.product-image-thumb.active').removeClass('active')
                $(this).addClass('active')
            })
        })
    </script>
    <style>
        .product-small-img img:hover{
            opacity: 1;
            transition-duration: 0.2s;
        }
    </style>
</html>