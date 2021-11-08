<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css">
        <link href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap5.min.css">
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap5.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        
        <title>Trade request</title>
    </head>
    <body>
        <?php
        include '../include/header.php';
        ?>
        <div class="container">
            <h1 class="pb-2 pt-5"> Trading requests:</h1>
            <div class="row">
                <div class="col-9 ">
                    <div class="col-auto">
                        <label for="text" class="col-form-label">Shwoing Entitries</label>
                    </div>
                    <div class="col-auto">
                        <select class="form-select" aria-label="Default select example" style="width:200px;"> 
                            <option selected></option>
                            <option value="1">25</option>
                            <option value="2">50</option>
                            <option value="3">10</option>
                        </select> 
                    </div>
                </div>
                <div class="col-3 pt-4 pb-5 " style="float:left">
                    <div class="col-auto">
                        <input type="Search" id="inputsearch" class="form-control"  placeholder="Search..">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    </script>
                </div>
            </div>
            <table id="example" class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th>Date </th>
                        <th>Trading Partner</th>
                        <th>Status </th>
                        <th>Action</th>
                        <th>Refund?</th>
                        <th>Refund status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="width:10%">23/06/2021</td>
                        <td style="width:20%">Chee Kin</td>
                        <td style="width:20%">Pending</td>
                        <td style="width:15%"><button type="button" class="btn btn-primary btn-sm" style="background-color:#00cccc;"><i class="fa fa-folder"  style="color:white; font-size:23px"></i> View details</button></td>
                        <td style="width:20%"><button type="button" class="btn btn-primary btn-sm disabled " style="background-color:#00cccc;"><<i class='fas fa-hand-holding'  style="color:white; font-size:23px"></i>Send request</button></td>
                        <td style="width:15%">-</td>
                    </tr>
                    <tr>
                        <td style="width:10%">23/06/2021</td>
                        <td style="width:20%">Sam</td>
                        <td style="width:20%">Pending</td>
                        <td style="width:15%"><button type="button" class="btn btn-primary btn-sm" style="background-color:#00cccc;"><i class="fa fa-folder"  style="color:white; font-size:23px"></i> View details</button></td>
                          <td style="width:20%"><button type="button" class="btn btn-primary btn-sm disabled" style="background-color:#00cccc;"><<i class='fas fa-hand-holding'  style="color:white; font-size:23px"></i>Send request</button></td>
                        <td style="width:15%">- </td>
                    </tr>
                    <tr>
                        <td style="width:10%">23/06/2021</td>
                        <td style="width:20%">Sam</td>
                        <td style="width:20%;color:red">Rejected</td>
                        <td style="width:15%"><button type="button" class="btn btn-primary btn-sm" style="background-color:#00cccc;"><i class="fa fa-folder"  style="color:white; font-size:23px"></i> View details</button></td>
                        <td style="width:20%"><button type="button"  class="btn btn-primary btn-sm" disabled style="background-color:#00cccc;"><<i class='fas fa-hand-holding'  style="color:white; font-size:23px"></i>Send request</button></td>
                        <td style="width:15%">- </td>
                    </tr>
                    <tr>
                        <td style="width:10%">23/06/2021</td>
                        <td style="width:20%">Chee Kin</td>
                        <td style="width:20%;color:greenyellow">Accepted</td>
                        <td style="width:15%"><button type="button" class="btn btn-primary btn-sm" style="background-color:#00cccc;"><i class="fa fa-folder"  style="color:white; font-size:23px"></i> View details</button></td>
                          <td style="width:20%"><button type="button" class="btn btn-primary btn-sm" style="background-color:#00cccc;"><<i class='fas fa-hand-holding'  style="color:white; font-size:23px"></i>Send request</button></td>
                        <td style="width:15%; color:greenyellow">Accepted </td>
                    </tr>
            </table>
            <div class="row">
                <div class="col-4 "> Showing 1 out of 1 entires </div>
                <div class="col-8 pt-5 ps-3">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">Next</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </body>
    <?php
    include '../include/footer.php';
    ?>
</body>
</html>
