<?php
include 'navbar.php';
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Customers List - Tradee</title>
    </head>
    <body class="hold-transition sidebar-mini layout-fixed">
        <div class="wrapper">
            <div class="content-wrapper">
                <section class="content">
                    <nav class="navbar-light pt-3 px-2">
                        <div class="row mb-3">
                            <div class="col-auto">
                                <label class="col-form-label">Activation:</label>
                            </div>
                            <div class="col-auto">
                                <select class="custom-select" id="activation" onchange="filter()">
                                    <option value="">All</option>
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Blacklisted</option>
                                </select>
                            </div>

<!--                            <div class="float-right">
                                <button class="btn btn-primary btn-block float-right" onclick="location.href='customer_details.php'"><i class="fas fa-user-plus"></i> New customer</button>
                            </div>-->
                        </div>
                    </nav>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Customer List</h3>
                        </div>
                        <div class="card-body">
                            <table id="table" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 11%">Customer ID</th>
                                        <th style="width: 10%">Name</th>
                                        <th style="width: 10%">Email</th>
                                        <th style="width: 10%">Contact</th>
                                        <th style="width: 13%">Register Date</th>
                                        <th style="width: 8%">State</th>
                                        <th style="width: 10%">Country</th>
                                        <th style="width: 8%">Activation</th>
                                        <th style="width: auto"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = "SELECT * FROM customer";
                                    $result = $dbc->query($sql);
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            if ($row["active"] == null) {
                                                $active = "Active";
                                                $color = "blue";
                                            } else {
                                                $active = "Blacklisted";
                                                $color = "red";
                                            }
                                            echo "<tr>"
                                            . "<td><a>" . $row["custid"] . "</a></td>"
                                            . "<td><a>" . $row["username"] . "</a></td>"
                                            . "<td><a>" . $row["email"] . "</a></td>"
                                            . "<td><a>" . $row["contact"] . "</a></td>"
                                            . "<td><a>" . $row["registration_date"] . "</a></td>"
                                            . "<td><a>" . $row["state"] . "</a></td>"
                                            . "<td><a>" . $row["country"] . "</a></td>"
                                            . "<td><a value ='" . $row["active"] . "'  style='color:" . $color . "; font-weight: bolder;'>" . $active . "</a></td>"
                                            . "<td class='project-actions text-right'>"
                                            . "<a class='btn btn-info btn-block' href='customer_details.php?id=" . $row["custid"] . "'>"
                                            . "<i class=" . "'far fa-eye'" . ">"
                                            . "</i></a></td>"
                                            . "</tr>";
                                        }
                                    }
                                    ?>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Customer ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Contact</th>
                                        <th>Register Date</th>
                                        <th>State</th>
                                        <th>Country</th>
                                        <th>Activation</th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </section>

                <div class="card-footer">
                    <div class="row">
                        <div class="col-auto">
                            <button class="btn btn-primary btn-block" id="btnsave" onclick="editorsave()" onclick="location.href = 'contactDetails.php'" id="btnadd">Contact</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php
        include 'footer.php';
        ?>
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
            var activation = document.getElementById("activation").value.toUpperCase();
            table = document.getElementById("table");
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[7];
                if (td) {
                    var txtValue = td.textContent.toUpperCase() || td.innerText.toUpperCase();
                    if (activation === "") {
                        tr[i].style.display = "";
                    } else if (txtValue !== activation) {
                        tr[i].style.display = "none";
                    } else {
                        tr[i].style.display = "";
                    }
                }
            }
        }
    </script>
</html>