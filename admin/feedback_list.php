<?php
$page = 'feedback_list';
include 'navbar.php';
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Feedback - Tradee</title>
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
                                        <select class="custom-select" id="status" onchange="category()">
                                            <option value="">All</option>
                                            <option value="Payments & Escrow">Payments & Escrow</option>
                                            <option value="Shipping & Delivery">Shipping & Delivery</option>
                                            <option value="Campaigns & Seller Related">Campaigns & Seller Related</option>
                                            <option value="Web performance">Web performance</option>
                                            <option value="General Enquiries">General Enquiries</option>
                                            <option value="Account & Security">Account & Security</option>
                                            <option value="Returns & Refunds">Returns & Refunds</option>
                                            <option value="Product Content & Legal">Product Content & Legal</option>
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
                                            <option value="Completed">Completed</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-auto">
                                <button class="btn btn-dark" onclick="reset_filter()">Reset filter</button>
                            </div>
                        </div>
                    </nav>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Feedback list</h3>
                        </div>
                        <div class="card-body">
                            <table id="table" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 11%">Feedback ID</th>
                                        <th style="width: 12%">Customer ID</th>
                                        <th style="width: 10%">Trade ID</th>
                                        <th style="width: 20%">Enquiry Type</th>
                                        <th style="width: 10%">Position</th>
                                        <th style="width: 15%">Date</th>
                                        <th style="width: 10%">Status</th>
                                        <th style="width: auto"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = "SELECT * FROM feedback";
                                    $result = $dbc->query($sql);
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            if ($row["status"] == "Completed") {
                                                $color = "limegreen";
                                            } else if ($row["status"] == "Pending") {
                                                $color = "orange";
                                            } else {
                                                $color = "red";
                                            }
                                            echo "<tr>"
                                            . "<td><a>" . $row["feedbackid"] . "</a></td>"
                                            . "<td><a>" . $row["custid"] . "</a></td>"
                                            . "<td><a>" . $row["tradeid"] . "</a></td>"
                                            . "<td><a>" . $row["enquirytype"] . "</a></td>"
                                            . "<td><a>" . $row["position"] . "</a></td>"
                                            . "<td><a>" . $row["feedbackdate"] . "</a></td>"
                                            . "<td><a style='color:" . $color . "; font-weight: bolder;'>" . $row["status"] . "</a></td>"
                                            . "<td class='project-actions text-right'>"
                                            . "<a class='btn btn-info btn-block' href='feedback_details.php?id=" . $row["feedbackid"] . "'>"
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

        function category() {
            var status = document.getElementById("status").value.toUpperCase();
            table = document.getElementById("table");
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[3];
                if (td) {
                    var txtValue = td.textContent.toUpperCase() || td.innerText.toUpperCase();
                    if (status === "") {
                        tr[i].style.display = "";
                    } else if (txtValue !== status) {
                        tr[i].style.display = "none";
                    } else {
                        tr[i].style.display = "";
                    }
                }
            }
        }

        function filter() {
            var status = document.getElementById("activation").value.toUpperCase();
            table = document.getElementById("table");
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[6];
                if (td) {
                    var txtValue = td.textContent.toUpperCase() || td.innerText.toUpperCase();
                    if (status === "") {
                        tr[i].style.display = "";
                    } else if (txtValue !== status) {
                        tr[i].style.display = "none";
                    } else {
                        tr[i].style.display = "";
                    }
                }
            }
        }
    </script>
</html>