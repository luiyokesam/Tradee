<?php
include 'navbar.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM category WHERE catid = '$id' LIMIT 1";
    $result = $dbc->query($sql);
    if ($result->num_rows > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $current_data = $row;
            echo '<script>var current_data = ' . json_encode($current_data) . ';</script>';
            break;
        }
    } else {
        echo '<script>alert("Extract data error !\nContact IT department to maintainence");window.location.href = "item_type_list.php";</script>';
    }
} else {
    echo '<script>var current_data = null;</script>';
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST["action"] == "delete") {
//        $sql = "DELETE FROM category WHERE catid=" . $current_data["catid"];
        $sql = "UPDATE category"
                . " SET active='" . 0 . "'"
                . "WHERE catid ='" . $current_data["catid"] . "'";

        if ($dbc->query($sql)) {
            $sql = "UPDATE item"
                    . " SET catname='" . null . "'"
                    . "WHERE catname ='" . $current_data["name"] . "'";
            $dbc->query($sql);
            if ($dbc->query($sql)) {
                echo '<script>alert("Deactivate successfully!"); window.location.href="item_type_list.php";</script>';
            } else {
                echo '<script>alert("Deactivate successfully but failed to update item list!\nPlease contact to IT department for maintainence.");window.location.href = "item_type_list.php";</script>';
            }
        } else {
            echo '<script>alert("Delete fail!\nPlease contact to IT department for maintainence.")</script>';
        }
    } else if ($_POST["action"] === "update") {
        $sql = "UPDATE category"
                . " SET name='" . $_POST["name"] . "',"
                . " description='" . $_POST["description"] . "'"
                . "WHERE catid ='" . $current_data["catid"] . "'";
        if ($dbc->query($sql)) {
            $sql = "UPDATE item"
                    . " SET catname='" . $_POST["name"] . "'"
                    . "WHERE catname ='" . $current_data["name"] . "'";
            if ($dbc->query($sql)) {
                echo '<script>alert("Update successfully!");var currentURL = window.location.href;window.location.href = currentURL;</script>';
            } else {
                echo '<script>alert("Update successfully but failed to update item list!\nPlease contact to IT department for maintainence.");window.location.href = "item_type_list.php";</script>';
            }
        } else {
            echo '<script>alert("Update fail!\nPlease contact to IT department for maintainence.")</script>';
        }
    } else {
        $sql = "INSERT INTO category (name, description, active) VALUES ("
                . "'" . $_POST['name'] . "',"
                . "'" . $_POST['description'] . "',"
                . 1 . ")";

        if ($dbc->query($sql)) {
            echo '<script>alert("Insert successfully!");window.location.href = "item_type_list.php";</script>';
        } else {
            echo '<script>alert("Insert failed!\nPlease contact to IT department for maintainence.")</script>';
        }
    }
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Item Type Details - Tradee</title>
    </head>
    <body class="hold-transition sidebar-mini layout-fixed" onload="loadform()">
        <div class="wrapper">
            <div class="content-wrapper">
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-6"></div>

                            <div class="col-sm-6 float-sm-right">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="item_type_list.php">Item type list</a></li>
                                    <li class="breadcrumb-item active">Item type details</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

                <section class="content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title" id="titleid">Type: <?php
                                        if (isset($current_data)) {
                                            echo $current_data["name"];
                                        } else {
                                            echo "New";
                                        }
                                        ?></h3>
                                </div>
                                <div class="card-body">
                                    <form method="post" id="form" class="m-0">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>Item Category Name :</label>
                                                <div class="form-group">                                             
                                                    <input class="form-control" value="<?php
                                                    if (isset($current_data)) {
                                                        echo $current_data["name"];
                                                    }
                                                    ?>" name="name" id="name">
                                                    <!--<input value="" name="action" id="action" style="display: none">-->
                                                </div>

                                                <label>Description :</label>
                                                <div class="form-group">                                             
                                                    <input class="form-control" value="<?php
                                                    if (isset($current_data)) {
                                                        echo $current_data["description"];
                                                    }
                                                    ?>" name="description" id="description">
                                                    <input value="" name="action" id="action" style="display: none">
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="card-footer p-2 py-3">
                                    <div class="row">
                                        <div class="col-lg-1 col-md-2">
                                            <div class="form-group mb-0">
                                                <button class="btn btn-dark btn-block" id="btnback" onclick="window.location.href = 'item_type_list.php'">Back</button>
                                            </div>
                                        </div>

                                        <div class="col-lg-9 col-md-5"></div>

                                        <div class="col-lg-1 col-md-2">
                                            <div class="form-group mb-0">
                                                <button class="btn btn-danger btn-block" id="btndelete" onclick="submitForm('delete')">Deactive</button>
                                            </div>
                                        </div>

                                        <div class="col-lg-1 col-md-2">
                                            <div class="form-group mb-0">
                                                <button class="btn btn-primary btn-block" id="btnsave" onclick="submitForm('save')">Save</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="card card-info">
                                <div class="card-header">
                                    <h3 class="card-title" id="titleid">Item List</h3>
                                </div>

                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <table id="itemtable" class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                    <tr>
                                                        <th style="width: 10%">Item ID</th>
                                                        <th style="width: 13%">Customer ID</th>
                                                        <th style="width: 13%">Category</th>
                                                        <th style="width: 13%">Brand</th>
                                                        <th style="width: 13%">Value</th>
                                                        <th style="width: 15%">Post Date</th>
                                                        <th style="width: 13%">Active</th>
                                                        <th style="width: auto"></th>
                                                    </tr>
                                                </thead>
                                                <tbody><?php
                                                    if (isset($current_data)) {
                                                        $sql = "SELECT * FROM item WHERE catname = '" . $current_data["name"] . "'";
                                                        $result = $dbc->query($sql);
                                                        if ($result->num_rows > 0) {
                                                            while ($row = $result->fetch_assoc()) {
                                                                if ($row["itemActive"] === "Available") {
                                                                    $color = "blue";
                                                                } else if ($row["itemActive"] === "Pending") {
                                                                    $color = "orange";
                                                                } else if ($row["itemActive"] === "Trading") {
                                                                    $color = "green";
                                                                } else {
                                                                    $color = "red";
                                                                }
                                                                echo "<tr><td><a>" . $row["itemid"] . "</a></td>"
                                                                . "<td><a>" . $row["custid"] . "</a></td>"
                                                                . "<td><a>" . $row["catname"] . "</a></td>"
                                                                . "<td><a>" . $row["brand"] . "</a></td>"
                                                                . "<td><a>" . $row["value"] . "</a></td>"
                                                                . "<td><a>" . $row["postDate"] . "</a></td>"
                                                                . "<td style='color:" . $color . "; font-weight: bolder;'><a>" . $row["itemActive"] . "</a></td>"
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
                        </div>
                </section>
            </div>
        </div>
        <?php include 'footer.php'; ?>
    </body>
    <script>
        $('#itemtable').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true
        });

        function loadform() {
            var params = new window.URLSearchParams(window.location.search);
            if (!params.get('id')) {
                document.getElementById('btndelete').disabled = true;
            }
        }

        function submitForm(action) {
            document.getElementById('name').style.borderColor = "";
            document.getElementById('description').style.borderColor = "";

            if (action === "delete") {
                if (confirm("Confirm to deactivate ?\n All event that related to this type will be updated null.")) {
                    document.getElementById('action').value = "delete";
                    document.getElementById("form").submit();
                }
            } else {
                if (current_data) {
                    if (!document.getElementById('name').value || document.getElementById('name').value === "") {
                        document.getElementById('name').style.borderColor = "red";
                    }
                    if (!document.getElementById('description').value || document.getElementById('description').value === "") {
                        document.getElementById('description').style.borderColor = "red";
                    } else {
                        if (confirm("Confirm to Save ?\n All event that related to this type will be updated to current type.")) {
                            document.getElementById('action').value = "update";
                            document.getElementById("form").submit();
                        }
                    }
                } else {
                    if (!document.getElementById('name').value || document.getElementById('name').value === "") {
                        document.getElementById('name').style.borderColor = "red";
                    }
                    if (!document.getElementById('description').value || document.getElementById('description').value === "") {
                        document.getElementById('description').style.borderColor = "red";
                    } else {
                        if (confirm("Confirm to insert?")) {
                            document.getElementById('action').value = "add";
                            document.getElementById("form").submit();
                        }
                    }
                }
            }
        }
    </script>
</html>