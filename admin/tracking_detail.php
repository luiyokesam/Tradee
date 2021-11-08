<?php
include 'navbar.php';
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Requests</title>
    </head>
    <body class="hold-transition sidebar-mini layout-fixed">
        <div class="wrapper">
            <div class="content-wrapper">
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-10">
                                <h1 class="m-0 text-dark">Requests list</h1>
                            </div>
                        </div>
                    </div>
                </div>
                <section class="content">
                    <nav class="navbar-light">
                        <div class="row" style="padding-top: 15px">
                            <div class="col-md-4"></div>
                            <div class="col-md-4">
                                <div class="form-group row">
                                    <div class="col-md-3">
                                        <label class="col-form-label">Delivery Status:</label>
                                    </div>
                                    <div class="col-md-9">
                                        <select class="custom-select" style="width:100%" id="select_request" onchange="filter()">
                                            <option value="">All</option>
                                            <option value="Pending">Pending</option>
                                            <option value="Complete">Complete</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4"></div>
                        </div>
                    </nav>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Tracking Mainteance</h3>
                        </div>
                        <div class="card-body">
                            <table id="table" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 10%">
                                           Delivery ID 
                                        </th>
                                         <th style="width: 10%">
                                            Request status
                                        </th>
                                         <th style="width: 10%">
                                             Reqeust Date
                                         </th>
                                        <th style="width: 10%">
                                            Delivery Date 
                                        </th>
                                        <th style="width: 10%">
                                            Customer Id
                                        </th>
                                          <th style="width: 10%">
                                           Product Id
                                        </th>
                                        <th style="width: 10%">
                                           Address
                                        </th>
                                        <th style="width: 10%">
                                            Action
                                        </th>
                                       
                                       
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Delivery ID</th>
                                        <th>Request Status</th>
                                        <th>Request Date</th>
                                        <th>Delivery date</th>
                                        <th>Customer ID</th>
                                        <th>Address</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                </section>
            </div>
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
        var activation = document.getElementById("select_request").value.toUpperCase();
        table = document.getElementById("table");
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[5];
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


    function reset_filter() {
        document.getElementById("orderstatus").selectedIndex = 0;
        document.getElementById("deliverystatus").selectedIndex = 0;
        filter();
    }
</script>
