<?php
include 'navbar.php';
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Event Type List - Tradee</title>
    </head>
    <body class="hold-transition sidebar-mini layout-fixed">
        <div class="wrapper">
            <div class="content-wrapper">
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-auto">
                                <button class="btn btn-dark" onclick="location.href='event_list.php'"><i class="nav-icon fas fa-calendar-alt"></i> Event list</button>
                            </div>

                            <div class="col-sm-auto">
                                <button class="btn btn-primary" onclick="location.href='event_type_details.php'"><i class="fas fa-plus"></i> New category</button>
                            </div>

                            <div class="col-sm">
                                <ol class="breadcrumb float-right">
                                    <li class="breadcrumb-item"><a href="event_list.php">Event list</a></li>
                                    <li class="breadcrumb-item active">Categories</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <section class="content">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Categories List</h3>
                        </div>
                        <div class="card-body">
                            <table id="configure_categories_table" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 90%;">Category</th>
                                        <th style="width: 10%;"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = "SELECT * FROM event_type";
                                    $result = $dbc->query($sql);
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<tr>"
                                            . "<td contenteditable='true'>" . $row["name"] . "</td>"
                                            . "<td class='project-actions'><a class='btn btn-info btn-block' style='color:white;' href='event_type_details.php?id=" . $row["id"] . "'><i class='fas fa-edit' style='color:white'></i></a></td>"
                                            . "</tr>";
                                        }
                                    }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Category</th>
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
        $("#configure_categories_table").DataTable({
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