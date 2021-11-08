<?php
include 'navbar.php';
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Tracking list</title>
    </head>
    <body class="hold-transition sidebar-mini layout-fixed">
        <div class="wrapper">
            <div class="content-wrapper">
                <section class="content">
                    <nav class="navbar-light pt-3 px-2">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <div class="col-md-auto">
                                        <label class="col-form-label">Delivery Status :</label>
                                    </div>
                                    <div class="col-md-auto">
                                        <select class="custom-select" style="width:100%" id="activation" onchange="filter()">
                                            <option value="">All</option>
                                            <option value="Inactive">Completed</option>
                                            <option value="Inactive">Pending</option>
                                            <option value="Active">Blacklisted</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </nav>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Tracking list</h3>
                        </div>
                        <div class="card-body">
                            <table id="table" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 10%">Delivery ID</th>
                                        <th style="width: 10%">Trading ID</th>
                                        <th style="width: 20%">Delivery request status</th>
                                        <th style="width: 20%">Estimated pick up date</th>
                                        <th style="width: 15%">Delivery status</th>
                                        <th style="width: 11%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>D001</td>
                                        <td>T001</td>
                                        <td>Accepted</td>
                                        <td>30/7/2021</td>
                                        <td>In transit</td>
                                        <td>
                                            <a class="btn btn-warning justify-content-center"  id="btnback" onclick="window.location.href='tracking_details.php'">
                                                <i class="fas fa-angle-double-right"> View Details</i>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>D002</td>
                                        <td>T002</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>
                                            <a class="btn btn-warning justify-content-center"  id="btnback" onclick="window.location.href='tracking_details.php'">
                                                <i class="fas fa-angle-double-right"> View Details</i>
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
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
</html>
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
