<?php
include 'navbar.php';
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Delivery List - Tradee</title>
    </head>
    <body class="hold-transition sidebar-mini layout-fixed">
        <div class="wrapper">
            <div class="content-wrapper">
                <section class="content">
                    <nav class="navbar-light pt-3 px-2">
                        <div class="row">
                            <div class="col-md-auto">
                                <div class="form-group row">
                                    <div class="col-md-auto">
                                        <label class="col-form-label">Delivery Status :</label>
                                    </div>
                                    <div class="col-md-auto">
                                        <select class="custom-select" id="deliverystatus" name="deliverystatus" onchange="filter()">
                                            <option value="">All</option>
                                            <option value="Pick up">Pick up</option>
                                            <option value="In Transit">In Transit</option>
                                            <option value="Shipping">Shipping </option>
                                            <option value="Completed">Completed</option>

                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </nav>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Delivery List</h3>
                        </div>
                        <div class="card-body">
                            <table id="table" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 11%">Delivery ID</th>
                                        <th style="width: 10%">Trade ID</th>
                                        <th style="width: 12%">Customer ID</th>
                                        <th style="width: 15%">Name</th>
                                        <th style="width: 15%">Delivery Date</th>
                                        <th style="width: 15%">Receive Date</th>
                                        <th style="width: 10%">Status</th>
                                        <th style="width: auto"></th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    $sql = "SELECT * FROM delivery";
                                    $result = $dbc->query($sql);
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            if ($row["deliveryStatus"] === "Pick Up") {
                                                $color = "orange";
                                            } else if ($row["deliveryStatus"] === "In Transit") {
                                                $color = "purple";
                                            } else if ($row["deliveryStatus"] === "Shipping") {
                                                $color = "blue";
                                            } else {
                                                $color = "green";
                                            }

                                            echo "<tr>"
                                            . "<td><a>" . $row["deliveryid"] . "</a></td>"
                                            . "<td><a>" . $row["tradeid"] . "</a></td>"
                                            . "<td><a>" . $row["custid"] . "</a></td>"
                                            . "<td><a>" . $row["username"] . "</a></td>"
                                            . "<td><a>" . $row["paymentDate"] . "</a></td>"
                                            . "<td><a>" . $row["receiveDate"] . "</a></td>"
                                            . "<td style='color:" . $color . "; font-weight: bolder;'><a>" . $row["deliveryStatus"] . "</a></td>"
                                            . "<td class='project-actions text-right'>"
                                            . "<a class='btn btn-info btn-block' href='delivery_details.php?id=" . $row["deliveryid"] . "'>"
                                            . "<i class=" . "'far fa-eye'" . ">"
                                            . "</i></a></td>"
                                            . "</tr>";
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <?php include 'footer.php'; ?>
    </body>
    <script>
        $('#table').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true
        });

        function filter() {
            var deliverystatus = document.getElementById("deliverystatus").value.toUpperCase();
            table = document.getElementById("table");
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[6];
                if (td) {
                    var txtValue = td.textContent.toUpperCase() || td.innerText.toUpperCase();
                    if (deliverystatus === "") {
                        tr[i].style.display = "";
                    } else if (txtValue !== deliverystatus) {
                        tr[i].style.display = "none";
                    } else {
                        tr[i].style.display = "";
                    }
                }
            }
        }
    </script>
</html>