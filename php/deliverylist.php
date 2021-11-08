<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!--        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
                <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css">
                <link href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap5.min.css">
                <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
                <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
                <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap5.min.js"></script>
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">-->

        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.22/datatables.min.css"/>
        <!--<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.22/datatables.min.js"></script>-->

        <title>Delivery List</title>
    </head>
    <body>
        <?php
        include '../include/header.php';
        ?>

        <div class="bg-navbar mb-3">
            <div class="container-lg">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb py-2 mb-0">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Profile</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Delivery List</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="container-lg">
            <div class="content" style="padding-bottom:20%">
                <div class="row">
                    <div class="col-md-12">
                        <table id="table" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Trading Id</th>
                                    <th>Status</th>
                                    <th>Delivery ID</th>
                                    <th>Estimated pick up date </th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>T001</td>
                                    <td>Pending</td>
                                    <td>D001</td>
                                    <td>25/3/2021</td>
                                    <td>
                                        <a class="btn btn-block btn-outline-dark justify-content-center" data-toggle="modal" data-target="#modal-lg">
                                            <i class="fas fa-angle-double-right"> View Details</i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>T002</td>
                                    <td style="color:green">Accepted</td>
                                    <td>D002</td>
                                    <td>25/3/2021</td>
                                    <td>
                                        <a class="btn btn-block btn-outline-dark justify-content-center" data-toggle="modal" data-target="#modal-lg">
                                            <i class="fas fa-angle-double-right"> View Details</i>
                                        </a>
                                    </td>
                                </tr>
                                <?php
//                            $sql = "SELECT * FROM `order` WHERE custid = '" . $customer_data["custid"] . "' ORDER BY orderid DESC";
//                            $result = $conn->query($sql);
//                            if ($result) {
//                                while ($row = $result->fetch_assoc()) {
//
//                                    if ($row["delivery_status"] === "Pending") {
//                                        $color1 = "yellow";
//                                    } else if ($row["delivery_status"] === "Delivered") {
//                                        $color1 = "blue";
//                                    } else {
//                                        $color1 = "green";
//                                    }
//
//                                    if ($row["order_status"] === "Success") {
//                                        $color2 = "green";
//                                    } else {
//                                        $color2 = "red";
//                                    }
//
//                                    echo "<tr>"
//                                    . "<td style='text-align: center'>" . $row["orderid"] . "</td>"
//                                    . "<td style='text-align: center'>" . $row["order_date"] . "</td>"
//                                    . "<td style='text-align: center'>" . $row["net_amount"] . "</td>"
//                                    . "<td style='text-align: center;color:" . $color1 . "'>" . $row["delivery_status"] . "</td>"
//                                    . "<td style='text-align: center;color:" . $color2 . "'>" . $row["order_status"] . "</td>"
//                                    . "<td>"
//                                    . "<a class='btn btn-primary btn-sm' style='width:100%' href='order_detail.php?order_id=" . $row["orderid"] . "'>View</a></td></tr>";
//                                }
//                            }
                                ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Trading Id</th>
                                    <th>Status</th>
                                    <th>Delivery ID</th>
                                    <th>Estimated pick up date </th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>

                        <div class="modal fade" id="modal-lg">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Admin detail's ( 990317-14-6039 )</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Identity card : </label>
                                                    <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter Identity number">
                                                </div>

                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Name : </label>
                                                    <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter name">
                                                </div>

                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Contact : </label>
                                                    <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter contact">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Position : </label>
                                                    <select class="form-control">
                                                        <option>--Select--</option>
                                                        <option>Admin</option>
                                                        <option>Manager</option>
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">New password : </label>
                                                    <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
                                                </div>

                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Re password : </label>
                                                    <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-6"></div>
                                                    <div class="col-md-6">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <button type="button" style="width: 100%" class="btn btn-danger">Cancel</button>
                                                                </div>

                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <button type="button" style="width: 100%" class="btn btn-primary">Edit</button>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h3 class="card-title">Activities</h3>
                                                    </div>
                                                    <!-- /.card-header -->
                                                    <div class="card-body table-responsive p-0" style="height: 300px;">
                                                        <table class="table table-head-fixed text-nowrap">
                                                            <thead>
                                                                <tr>
                                                                    <th style="width: 20%">Date</th>
                                                                    <th style="width: 10%">Time</th>
                                                                    <th style="width: 80%">Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>2021-06-25</td>
                                                                    <td>07:20</td>
                                                                    <td>Remove</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>2021-06-25</td>
                                                                    <td>07:20</td>
                                                                    <td>Remove</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>2021-06-25</td>
                                                                    <td>07:20</td>
                                                                    <td>Remove</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>2021-06-25</td>
                                                                    <td>07:20</td>
                                                                    <td>Remove</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>2021-06-25</td>
                                                                    <td>07:20</td>
                                                                    <td>Remove</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>2021-06-25</td>
                                                                    <td>07:20</td>
                                                                    <td>Remove</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <!-- /.card-body -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php
        include '../include/footer.php';
        ?>
    </body>
    <script>
        $(document).ready(function () {
            $("#table").DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true
            });
        });
    </script>
    <style>
        .bg-navbar{
            background: whitesmoke;
        }

        thead tr th, tfoot tr th{
            text-align: center;
        }
    </style>
</html>

