<?php
$page = 'donation_list';
include 'navbar.php';
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Donation List - Tradee</title>
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
                        </div>
                    </nav>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Donation List</h3>
                        </div>
                        <div class="card-body">
                            <table id="donationtable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 10%">Donate ID</th>
                                        <th style="width: 10%">Event ID</th>
                                        <th style="width: 13%">Donator</th>
                                        <th style="width: 10%">Quantity</th>
                                        <th style="width: 15%">Donation Date</th>
                                        <th style="width: 15%">Delivery Status</th>
                                        <th style="width: 15%">Received Date</th>
                                        <th style="width: auto"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = "SELECT * FROM donation_delivery";
                                    $result = $dbc->query($sql);
                                    if ($result) {
                                        while ($row = $result->fetch_assoc()) {
                                            if ($row["deliveryStatus"] == "Pending") {
                                                $color1 = "orange";
                                            } else if ($row["deliveryStatus"] == "In Transit") {
                                                $color1 = "lightsalmon";
                                            } else if ($row["deliveryStatus"] == "Shipping") {
                                                $color1 = "skyblue";
                                            } else if ($row["deliveryStatus"] == "Delivered") {
                                                $color1 = "limegreen";
                                            } else {
                                                $color1 = "red";
                                            }

                                            echo "<td><a>" . $row["donationid"] . "</a></td>"
                                            . "<td><a>" . $row["eventid"] . "</a></td>"
                                            . "<td><a>" . $row["donator"] . "</a></td>"
                                            . "<td><a>" . $row["itemQuantity"] . "</a></td>"
                                            . "<td><a>" . $row["paymentDate"] . "</a></td>"
                                            . "<td style='color: " . $color1 . "; font-weight: bolder;'><a>" . $row["deliveryStatus"] . "</a></td>"
                                            . "<td><a>" . $row["receiveDate"] . "</a></td>"
                                            . "<td class='project-actions text-right'>"
                                            . "<a class=" . "'btn btn-info btn-block'" . "href=" . "'donation_details.php?id=" . $row["donationid"] . "'>"
                                            . "<i class=" . "'far fa-eye'" . ">"
                                            . "</i></a></td></tr>";
                                        }
                                    }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Donate ID</th>
                                        <th>Event ID</th>
                                        <th>Donator</th>
                                        <th>Quantity</th>
                                        <th>Donation Date</th>
                                        <th>Delivery Status</th>
                                        <th>Received Date</th>
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

        $('#donationtable').DataTable({
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