<?php
$page = 'admin_list';
include 'navbar.php';
echo '<script>var position = ' . json_encode($current_admin["position"]) . ';</script>';
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Admin List - Tradee</title>
    </head>
    <body class="hold-transition sidebar-mini layout-fixed" onload="loadform()">
        <div class="wrapper">
            <div class="content-wrapper">
                <section class="content">
                    <nav class="navbar-light pt-3 px-2">
                        <div class="row">
                            <div class="col-md-auto">
                                <div class="form-group row">
                                    <div class="col-md-5">
                                        <label class="col-form-label">Activation:</label>
                                    </div>
                                    <div class="col-md-7">
                                        <select class="custom-select" style="width:100%" id="activation" onchange="filter()">
                                            <option value="">All</option>
                                            <option value="Active">Active</option>
                                            <option value="Inactive">Inactive</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-auto">
                                <button class="btn btn-primary btn-block" onclick="location.href = 'admin_details.php'" id="btnadd"><i class="fas fa-user-plus"></i> New admin</button>
                            </div>
                        </div>
                    </nav>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Admin List</h3>
                        </div>
                        <div class="card-body">
                            <table id="table" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 11%">Admin ID</th>
                                        <th style="width: 13%">Name</th>
                                        <th style="width: 23%">Email</th>
                                        <th style="width: 10%">Phone</th>
                                        <th style="width: 9%">Position</th>
                                        <th style="width: 13%">Manager</th>
                                        <th style="width: 11%">Activation</th>
                                        <th style="width: auto"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = "SELECT * FROM admin";
                                    $result = $dbc->query($sql);
                                    if ($result) {
                                        while ($row = $result->fetch_assoc()) {
                                            if ($row["activation"] == true) {
                                                $active = "Active";
                                                $color = "limegreen";
                                            } else {
                                                $active = "Inactive";
                                                $color = "limegreen";
                                            }
                                            echo "<tr><td><a>" . $row["adminid"] . "</a></td>"
                                            . "<td><a>" . $row["name"] . "</a></td>"
                                            . "<td><a>" . $row["email"] . "</a></td>"
                                            . "<td><a>" . $row["phone"] . "</a></td>"
                                            . "<td><a>" . $row["position"] . "</a></td>"
                                            . "<td><a>" . $row["manager"] . "</a></td>"
                                            . "<td><a value =" . $row["activation"] . "  style='color:" . $color . ";font-weight: bolder;'>" . $active . "</a></td>"
                                            . "<td class='project-actions text-right'>"
                                            . "<a class=" . "'btn btn-info btn-block'" . "href=" . "'admin_details.php?id=" . $row["adminid"] . "'>"
                                            . "<i class=" . "'far fa-eye'" . ">"
                                            . "</i></a></td></tr>";
                                        }
                                    }
                                    ?>
                                </tbody>

                                <tfoot>
                                    <tr>
                                        <th>Admin ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Position</th>
                                        <th>Manager</th>
                                        <th>Activation</th>
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
        function loadform() {
            if (position === "Admin") {
                document.getElementById("btnadd").hidden = true;
            }
        }

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
                td = tr[i].getElementsByTagName("td")[6];
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