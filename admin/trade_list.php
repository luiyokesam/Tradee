<?php
$page = 'trade_list';
include 'navbar.php';
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Trading List - Tradee</title>
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
                                        <label class="col-form-label">Trading Status :</label>
                                    </div>
                                    <div class="col-md-auto">
                                        <select class="custom-select" id="status" name="status" onchange="filter()">
                                            <option value="">All</option>
                                            <option value="Accepted">Accepted</option>
                                            <option value="Rejected">Rejected</option>
                                       

                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </nav>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Trading List</h3>
                        </div>
                        <div class="card-body">
                            <table id="table" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 11%">Trading ID</th>
                                        <th style="width: 12%">Offered ID</th>
                                        <th style="width: 12%">Accepted ID</th>
                                        <th style="width: 14%">Offer Payment</th>
                                        <th style="width: 14%">Accept Payment</th>
                                        <th style="width: 15%">Traded Date</th>
                                        <th style="width: 12%">Status</th>
                                        <th style="width: auto"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = "SELECT * FROM trade";
                                    $result = $dbc->query($sql);
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            if ($row["status"] == "Pending") {
                                                        $color1 = "orange";
                                                    } else if ($row["status"] == "Trading") {
                                                        $color1 = "skyblue";
                                                    } else if ($row["status"] == "Rejected") {
                                                        $color1 = "red";
                                                    } else if ($row["status"] == "To Pay") {
                                                        $color1 = "slateblue";
                                                    } else if ($row["status"] == "To Ship") {
                                                        $color1 = "lightsalmon";
                                                    } else if ($row["status"] == "Completed") {
                                                        $color1 = "limegreen";
                                                    } else if ($row["status"] == "Delivered") {
                                                        $color1 = "limegreen";
                                                    } else {
                                                        $color1 = "red";
                                                    }

                                            echo "<tr>"
                                            . "<td><a>" . $row["tradeid"] . "</a></td>"
                                            . "<td><a>" . $row["offerCustID"] . "</a></td>"
                                            . "<td><a>" . $row["acceptCustID"] . "</a></td>"
                                            . "<td><a>" . $row["offerPayment"] . "</a></td>"
                                            . "<td><a>" . $row["acceptPayment"] . "</a></td>"
                                            . "<td><a>" . $row["tradeDate"] . "</a></td>"
                                            . "<td style='color:" . $color1 . "; font-weight: bolder;'><a>" . $row["status"] . "</a></td>"
                                            . "<td class='project-actions text-right'>"
                                            . "<a class='btn btn-info btn-block' href='trade_details.php?id=" . $row["tradeid"] . "'>"
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
            var status = document.getElementById("status").value.toUpperCase();
            table = document.getElementById("table");
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[4];
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