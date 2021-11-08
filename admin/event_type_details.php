<?php
include 'navbar.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM event_type WHERE id = '$id' LIMIT 1";
    $result = $dbc->query($sql);
    if ($result->num_rows > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $current_data = $row;
            echo '<script>var current_data = ' . json_encode($current_data) . ';</script>';
            break;
        }
    } else {
        echo '<script>alert("Extract data error !\nContact IT department to maintainence");window.location.href = "event_type_list.php";</script>';
    }
} else {
    echo '<script>var current_data = null;</script>';
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST["action"] == "delete") {
        $sql = "DELETE FROM event_type WHERE id=" . $current_data["id"];
        if ($dbc->query($sql)) {
            $sql = "UPDATE event"
                    . " SET type='" . null . "'"
                    . "WHERE type ='" . $current_data["name"] . "'";
            $dbc->query($sql);
            if ($dbc->query($sql)) {
                echo '<script>alert("Delete successfully!"); window.location.href="event_type_list.php";</script>';
            } else {
                echo '<script>alert("Delete successfully but failed to update event list!\nPlease contact to IT department for maintainence.");window.location.href = "event_type_list.php";</script>';
            }
        } else {
            echo '<script>alert("Delete fail!\nPlease contact to IT department for maintainence.")</script>';
        }
    } else if ($_POST["action"] == "update") {
        $sql = "UPDATE event_type"
                . " SET name='" . $_POST["name"] . "'"
                . "WHERE id ='" . $current_data["id"] . "'";
        if ($dbc->query($sql)) {
            $sql = "UPDATE event"
                    . " SET type='" . $_POST["name"] . "'"
                    . "WHERE type ='" . $current_data["name"] . "'";
            if ($dbc->query($sql)) {
                echo '<script>alert("Update successfully!");var currentURL = window.location.href;window.location.href = currentURL;</script>';
            } else {
                echo '<script>alert("Update successfully but failed to update event list!\nPlease contact to IT department for maintainence.");window.location.href = "event_type_list.php";</script>';
            }
        } else {
            echo '<script>alert("Update fail!\nPlease contact to IT department for maintainence.")</script>';
        }
    } else {
        $sql = "INSERT INTO event_type(name) VALUES ("
                . "'" . $_POST['name'] . "')";

        if ($dbc->query($sql)) {
            echo '<script>alert("Insert successfully!");window.location.href = "event_type_list.php";</script>';
        } else {
            echo '<script>alert("Insert failed!\nPlease contact to IT department for maintainence.")</script>';
        }
    }
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php
            if (isset($current_data)) {
                echo $current_data["name"];
            } else {
                echo "New Category";
            }
            ?> - Tradee</title>
    </head>
    <body class="hold-transition sidebar-mini layout-fixed" onload="loadform()">
        <div class="wrapper">
            <div class="content-wrapper">
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-6"></div>

                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="event_type_list.php">Event type list</a></li>
                                    <li class="breadcrumb-item active">Event type details</li>
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
                                    <h4 class="card-title" id="titleid" style="font-weight: bolder;">Type: <?php
                                        if (isset($current_data)) {
                                            echo $current_data["name"];
                                        } else {
                                            echo "New";
                                        }
                                        ?></h4>
                                </div>
                                <div class="card-body">
                                    <form method="post" id="form" class="m-0">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>Category Name: </label>
                                                <div class="form-group">                                             
                                                    <input class="form-control" value="<?php
                                                    if (isset($current_data)) {
                                                        echo $current_data["name"];
                                                    }
                                                    ?>" name="name" id="name">
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
                                                <button class="btn btn-dark btn-block" id="btnback" onclick="window.location.href = 'event_type_list.php'">Back</button>
                                            </div>
                                        </div>

                                        <div class="col-lg-9 col-md-5"></div>

                                        <div class="col-lg-1 col-md-2">
                                            <div class="form-group mb-0">
                                                <button class="btn btn-danger btn-block" id="btndelete" onclick="submitForm('delete')">Delete</button>
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
                                    <h3 class="card-title" id="titleid">Event List</h3>
                                </div>

                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <table id="eventtable" class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 10%">Event ID</th>
                                                        <th style="width: 12%">Type</th>
                                                        <th style="width: 19%">Title</th>
                                                        <th style="width: 12%">Contact</th>
                                                        <th style="width: 12%">Staff Admin</th>
                                                        <th style="width: 13%">End Date</th>
                                                        <th style="width: 12%">Status</th>
                                                        <th style="width: auto"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    if (isset($current_data)) {
                                                        $sql = "SELECT * FROM event e, event_image i WHERE e.eventid = i.eventid AND e.type = '" . $current_data["name"] . "'";
                                                        $result = $dbc->query($sql);
                                                        if ($result->num_rows > 0) {
                                                            while ($row = $result->fetch_assoc()) {
                                                                if ($row["status"] == 'Pending') {
                                                                    $color = "red";
                                                                } else if ($row["status"] == 'In-Progress') {
                                                                    $color = "blue";
                                                                } else {
                                                                    $color = "green";
                                                                }
                                                                echo "<tr><td><a>" . $row["eventid"] . "</a></td>"
                                                                . "<td><a>" . $row["type"] . "</a></td>"
                                                                . "<td><a>" . $row["title"] . "</a></td>"
                                                                . "<td><a>" . $row["contact"] . "</a></td>"
                                                                . "<td><a>" . $row["adminid"] . "</a></td>"
                                                                . "<td><a>" . $row["endEvent"] . "</a></td>"
                                                                . "<td><a style=" . "'color:" . $color . "; font-weight: bolder;'>" . $row["status"] . "</a></td>"
                                                                . "<td class='project-actions text-right'>"
                                                                . "<a class=" . "'btn btn-info btn-block'" . "href=" . "'event_details.php?id=" . $row["eventid"] . "'>"
                                                                . "<i class=" . "'far fa-eye'" . ">"
                                                                . "</i></a></td></tr>";
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th>Event ID</th>
                                                        <th>Type</th>
                                                        <th>Receiver</th>
                                                        <th>Contact</th>
                                                        <th>Staff Admin</th>
                                                        <th>End Date</th>
                                                        <th>Status</th>
                                                        <th></th>
                                                    </tr>
                                                </tfoot>
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
        $('#eventtable').DataTable({
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

            if (action === "delete") {
                if (confirm("Confirm to delete ?\n All event that related to this type will be updated null.")) {
                    document.getElementById('action').value = "delete";
                    document.getElementById("form").submit();
                }
            } else {
                if (current_data) {
                    if (!document.getElementById('name').value || document.getElementById('name').value === "") {
                        document.getElementById('name').style.borderColor = "red";
                    } else {
                        if (confirm("Confirm to Save ?\n All event that related to this type will be updated to current type.")) {
                            document.getElementById('action').value = "update";
                            document.getElementById("form").submit();
                        }
                    }
                } else {
                    if (!document.getElementById('name').value || document.getElementById('name').value === "") {
                        document.getElementById('name').style.borderColor = "red";
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