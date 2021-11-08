<?php
include 'navbar.php';
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Event List - Tradee</title>
    </head>
    <body class="hold-transition sidebar-mini layout-fixed">
        <div class="wrapper">
            <div class="content-wrapper">
                <section class="content">
                    <nav class="navbar-light">
                        <div class="row p-2 pb-0 pt-3">
                            <div class="col-md-auto">
                                <div class="form-group row">
                                    <div class="col-md-auto">
                                        <label class="col-form-label">Category :</label>
                                    </div>

                                    <div class="col-md-auto">
                                        <select class="custom-select" id="category" onchange="filter()">
                                            <option value="">All</option>
                                            <?php
                                            $sql_get_type = "SELECT name FROM event_type";
                                            $result_get_type = $dbc->query($sql_get_type);
                                            while ($row = mysqli_fetch_array($result_get_type)) {
                                                echo '<option value="' . $row["name"] . '">' . $row["name"] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-auto">
                                <div class="form-group row">
                                    <div class="col-md-auto">
                                        <label class="col-form-label">Status :</label>
                                    </div>
                                    <div class="col-md-auto">
                                        <select class="custom-select" id="activation" onchange="filter()">
                                            <option value="">All</option>
                                            <option value="Pending">Pending</option>
                                            <option value="In-Progress">In-Progress</option>
                                            <option value="Completed">Completed</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md">
                                <button class="btn btn-dark" onclick="reset_filter()">Reset filter</button>
                            </div>

                            <div class="col-auto px-0">
                                <button class="btn btn-warning float-right" onclick="location.href = 'event_details.php?action=add'"><i class="fas fa-plus"></i> New Event</button>
                            </div>

                            <div class="col-auto px-0">
                                <button class="btn btn-light float-right" onclick="location.href = 'event_type_list.php'"><i class="fas fa-cog"></i></button>
                            </div>
                        </div>
                    </nav>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Event List</h3>
                        </div>
                        <div class="card-body">
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
                                    $sql = "SELECT * FROM event";
                                    $result = $dbc->query($sql);
                                    if ($result) {
                                        while ($row = $result->fetch_assoc()) {
                                            if ($row["status"] == 'Pending') {
                                                $color = "red";
                                            } else if ($row["status"] == 'In-Progress'){
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
                </section>
            </div>
        </div>
        <?php include 'footer.php'; ?>
    </body>
    <script>
        function filter() {
            var activation = document.getElementById("activation").value.toUpperCase();
            var category = document.getElementById("category").value.toUpperCase();
            table = document.getElementById("eventtable");
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                td1 = tr[i].getElementsByTagName("td")[6];
                td2 = tr[i].getElementsByTagName("td")[1];
                if (td1 || td2) {
                    txtValue1 = td1.textContent.toUpperCase() || td1.innerText.toUpperCase();
                    txtValue2 = td2.textContent.toUpperCase() || td2.innerText.toUpperCase();
                    if (activation === "" && category === "") {
                        tr[i].style.display = "";
                    } else if (category !== "" && activation !== "") {
                        if (txtValue1 !== activation || txtValue2 !== category) {
                            tr[i].style.display = "none";
                        } else {
                            tr[i].style.display = "";
                        }
                    } else if (category !== "" && activation === "") {
                        if (txtValue2 !== category) {
                            tr[i].style.display = "none";
                        } else {
                            tr[i].style.display = "";
                        }
                    } else if (category === "" && activation !== "") {
                        if (txtValue1 !== activation) {
                            tr[i].style.display = "none";
                        } else {
                            tr[i].style.display = "";
                        }
                    } else {
                        tr[i].style.display = "";
                    }
                }
            }
        }

        function reset_filter() {
            document.getElementById("activation").selectedIndex = 0;
            document.getElementById("category").selectedIndex = 0;
            filter();
        }

        $('#eventtable').DataTable({
            "paging": true,
            "lengthChange": true,   
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true
        });
    </script>
</html>