<?php
include 'navbar.php';
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Item List - Tradee</title>
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
                                        <label class="col-form-label">Category:</label>
                                    </div>

                                    <div class="col-md-auto">
                                        <select class="custom-select" id="category" onchange="filter()">
                                            <option value="">All</option>
                                            <?php
                                            $sql_get_type = "SELECT name FROM category";
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
                                        <label class="col-form-label">Activation:</label>
                                    </div>
                                    <div class="col-md-auto">
                                        <select class="custom-select" id="itemActive" name="itemActive" onchange="filter()">
                                            <option value="">All</option>
                                            <option value="Available">Available</option>
                                            <option value="Pending">Pending</option>
                                            <option value="Trading">Trading</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-auto">
                                <button class="btn btn-dark" onclick="reset_filter()">Reset filter</button>
                            </div>

                            <div class="col-md">
                                <button class="btn btn-light float-right" onclick="location.href = 'item_type_list.php'"><i class="fas fa-cog"></i></button>
                            </div>
<!--                            <div class="col-md-auto">
                                <button class="btn btn-warning" onclick="location.href = 'item_details.php'">Add new item</button>
                            </div>-->
                        </div>
                    </nav>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">List of items</h3>
                        </div>
                        <div class="card-body">
                            <table id="itemtable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 10%">Item ID</th>
                                        <th style="width: 12%">Customer ID</th>
                                        <th style="width: 12%">Item Name</th>
                                        <th style="width: 12%">Category</th>
                                        <th style="width: 10%">Brand</th>
                                        <th style="width: 10%">Value (RM)</th>
                                        <th style="width: 13%">Post Date</th>
                                        <th style="width: 11%">Status</th>
                                        <th style="width: auto"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = "SELECT * FROM item";
                                    $result = $dbc->query($sql);
                                    if ($result) {
                                        while ($row = $result->fetch_assoc()) {
                                            if ($row["itemActive"] === "Available") {
                                                $color = "green";
                                            } else if ($row["itemActive"] === "Pending") {
                                                $color = "orange";
                                            } else if ($row["itemActive"] === "Trading") {
                                                $color = "blue";
                                            } else {
                                                $color = "red";
                                            }
                                            echo "<tr><td><a>" . $row["itemid"] . "</a></td>"
                                            . "<td><a>" . $row["custid"] . "</a></td>"
                                            . "<td><a>" . $row["itemname"] . "</a></td>"
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
                                    ?>
                                </tbody>

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
            var itemActive = document.getElementById("itemActive").value.toUpperCase();
            var category = document.getElementById("category").value.toUpperCase();
            table = document.getElementById("itemtable");
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                td1 = tr[i].getElementsByTagName("td")[7];
                td2 = tr[i].getElementsByTagName("td")[3];
                if (td1 || td2) {
                    txtValue1 = td1.textContent.toUpperCase() || td1.innerText.toUpperCase();
                    txtValue2 = td2.textContent.toUpperCase() || td2.innerText.toUpperCase();
                    if (itemActive === "" && category === "") {
                        tr[i].style.display = "";
                    } else if (category !== "" && itemActive !== "") {
                        if (txtValue1 !== itemActive || txtValue2 !== category) {
                            tr[i].style.display = "none";
                        } else {
                            tr[i].style.display = "";
                        }
                    } else if (category !== "" && itemActive === "") {
                        if (txtValue2 !== category) {
                            tr[i].style.display = "none";
                        } else {
                            tr[i].style.display = "";
                        }
                    } else if (category === "" && itemActive !== "") {
                        if (txtValue1 !== itemActive) {
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
            document.getElementById("itemActive").selectedIndex = 0;
            document.getElementById("category").selectedIndex = 0;
            filter();
        }

        $('#itemtable').DataTable({
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