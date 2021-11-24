<?php
$page = 'report';
include 'navbar.php';

$sql = "SELECT * FROM admin WHERE position = 'Manager' AND adminid = '{$_SESSION['adminid']}'";
$result = $dbc->query($sql);
if ($result->num_rows < 1) {
    echo '<script>alert("Sorry, you do not have this access.");window.location.href="home.php";</script>';
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $type = $_POST["type"];
    if (isset($_POST["datefrom"])) {
        $datefrom = $_POST["datefrom"];
    }

    if (isset($_POST["dateto"])) {
        $dateto = $_POST["dateto"];
    }
//        echo '<script>alert("' . $sql . '");</script>';

    if ($type == "trade_report") {
        $title = "Trades Report";
        $sql = "SELECT * FROM trade "
                . "WHERE str_to_date(tradeDate, '%d/%m/%Y') >= str_to_date('$datefrom', '%d/%m/%Y') AND "
                . "str_to_date(tradeDate, '%d/%m/%Y') <= str_to_date('$dateto', '%d/%m/%Y')";

//        echo '<script>alert("' . $sql . '");</script>';
    } else if ($type == "donation_event") {
        $title = "Donation Event";
        $sql = "SELECT * FROM event WHERE status = 'Ended' AND str_to_date(endEvent, '%d/%m/%Y') <= str_to_date('$dateto', '%d/%m/%Y') ";

//        echo '<script>alert("' . $sql . '");</script>';
    } else if ($type == "customer_inventory") {
        $title = "Customers Inventory";
        $sql = "SELECT DISTINCT custid, username "
                . "FROM customer";

//        echo '<script>alert("' . $sql . '");</script>';
    } else if ($type == "top_valueitem") {
        $title = "Customer Item Value Report";
        $sql = "SELECT c.custid as custid, c.username, COUNT(i.itemid) AS totalitem, SUM(i.value) AS totalvalue "
                . "FROM customer c, item i "
                . "WHERE c.custid = i.custid "
                . "GROUP BY c.custid";
    } else if ($type == "delivery_report") {
        $title = "Delivery Report";
        $sql = "SELECT d.senderid as id , count(d.senderid) as deliveryqty,SUM(d.totalAmount) AS revenue FROM `customer` as c , `delivery` as d where c.custid = d.senderid group by senderid order by deliveryqty DESC";
    } else if ($type == "admin_list") {
        $title = "Admin List report";
        $sql = "SELECT * from admin";
    } else if ($type == "newuploads") {
        $title = "New uploads report";
        $sql = "SELECT c.catid, c.name, count(i.tradeItem) as catqty, i.postDate FROM `item` as i, `category` as c where c.name = i.tradeItem AND str_to_date(postDate, '%d/%m/%Y' ) >= str_to_date('$datefrom', '%d/%m/%Y' ) AND str_to_date(postDate, '%d/%m/%Y' ) <= str_to_date('$dateto', '%d/%m/%Y' )  group by i.tradeItem order by catqty DESC";
    }
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Report - Tradee</title>
    </head>
    <body class="hold-transition sidebar-mini layout-fixed">
        <div class="wrapper">
            <div class="content-wrapper">
                <section class="content pt-3">
                    <nav class="navbar navbar-expand navbar-light">
                        <form class="form-inline" id="form" method="post">
                            <div class="row">
                                <div class="col-md-auto">
                                    <div class="form-group row">
                                        <div class="col-md-auto">
                                            <label class="col-form-label">Report Type :</label>
                                        </div>

                                        <div class="col-md-auto">
                                            <select class="custom-select" name="type" id="type" onchange="changetype(this.value)">
                                                <option value="trade_report" <?php
                                                if (isset($type)) {
                                                    if ($type == "trade_report") {
                                                        echo "selected";
                                                    }
                                                }
                                                ?>>Trade Report</option>

                                                <option value="top_valueitem" <?php
                                                if (isset($type)) {
                                                    if ($type == "top_valueitem") {
                                                        echo "selected";
                                                    }
                                                }
                                                ?>>Top Value Items</option>

                                                <option value="customer_inventory" <?php
                                                if (isset($type)) {
                                                    if ($type == "customer_inventory") {
                                                        echo "selected";
                                                    }
                                                }
                                                ?>>Customers Inventory</option>

                                                <option value="delivery_report" <?php
                                                if (isset($type)) {
                                                    if ($type == "delivery_report") {
                                                        echo "selected";
                                                    }
                                                }
                                                ?>>Top Customer Deliveries</option>

                                                <option value="admin_list" <?php
                                                if (isset($type)) {
                                                    if ($type == "admin_list") {
                                                        echo "selected";
                                                    }
                                                }
                                                ?>>Admin List</option>

                                                <option value="newuploads" <?php
                                                if (isset($type)) {
                                                    if ($type == "newuploads") {
                                                        echo "selected";
                                                    }
                                                }
                                                ?>>New Uploads</option>

                                                <option value="donation_event" <?php
                                                if (isset($type)) {
                                                    if ($type == "donation_event") {
                                                        echo "selected";
                                                    }
                                                }
                                                ?>>Donation Event</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-auto">
                                    <div class="form-group row">
                                        <div class="col-md-auto">
                                            <label class="col-form-label">Date From :</label>
                                        </div>

                                        <div class="col-md-auto">
                                            <input class="form-control" id="datefrom" name="datefrom" placeholder="dd/mm/yyyy" maxlength="10" value="<?php
                                            if (isset($datefrom)) {
                                                echo $datefrom;
                                            }
                                            ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-auto">
                                    <div class="form-group row">
                                        <div class="col-md-auto">
                                            <label class="col-form-label">Date To :</label>
                                        </div>

                                        <div class="col-md-auto">
                                            <input class="form-control" id="dateto" name="dateto"  placeholder="dd/mm/yyyy" maxlength="10" value="<?php
                                            if (isset($dateto)) {
                                                echo $dateto;
                                            }
                                            ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-auto">
                                    <button class="btn btn-primary" type="button" onclick="generate_report()">Generate</button>
                                </div>

                                <?php
//                                if (isset($title)) {
//                                    echo '<button class="btn btn-success" type="button" style="width:150px" onclick="print()">Print report</button>';
//                                }
                                ?>
                            </div>
                        </form>
                    </nav>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Tradee Report</h3>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <?php
                                    if (isset($type)) {
                                        if ($type == "trade_report") {
                                            echo "<tr>"
                                            . "<th style='width: 20%;'>Trade ID</th>"
                                            . "<th style='width: 20%;'>Customer</th>"
                                            . "<th style='width: 20%;'>Item</th>"
                                            . "<th style='width: 20%;'>Date</th>"
                                            . "<th style='width: 20%;'>Status</th>"
                                            . "</tr>";
                                        } else if ($type == "top_valueitem") {
                                            echo "<tr>"
                                            . "<th style='width: 25%;'>Customer ID</th>"
                                            . "<th style='width: 25%;'>Username</th>"
                                            . "<th style='width: 25%;'>Quantity</th>"
                                            . "<th style='width: 25%;'>Total value(RM)</th>"
                                            . "</tr>";
                                        } else if ($type == "top_valueitem") {
                                            echo "<tr>"
                                            . "<th style='width: 25%;'>Customer ID</th>"
                                            . "<th style='width: 25%;'>Username</th>"
                                            . "<th style='width: 25%;'>Quantity</th>"
                                            . "<th style='width: 25%;'>Total value(RM)</th>"
                                            . "</tr>";
                                        } else if ($type == "customer_inventory") {
                                            echo "<tr>"
                                            . "<th style='width: 20%;'>Customer ID</th>"
                                            . "<th style='width: 20%;'>Username</th>"
                                            . "<th style='width: 20%;'>Item</th>"
                                            . "<th style='width: 20%;'>Category</th>"
                                            . "<th style='width: 20%;'>Brand</th>"
                                            . "</tr>";
                                        } else if ($type == "newuploads") {
                                            echo "<tr>"
                                            . "<th style='width: 25%;'>Category ID</th>"
                                            . "<th style='width: 25%;'>Item Category</th>"
                                            . "<th style='width: 25%;'>Number of Uploads</th>"
                                            . "</tr>";
                                        } else if ($type == "admin_list") {
                                            echo "<tr>"
                                            . "<th style='width: 15%;'>Admin ID</th>"
                                            . "<th style='width: 15%;'>Name</th>"
                                            . "<th style='width: 25%;'>Email</th>"
                                            . "<th style='width: 15%;'>Phone</th>"
                                            . "<th style='width: 15%;'>Position</th>"
                                            . "<th style='width: 15%;'>Manager</th>"
                                            . "</tr>";
                                        } else if ($type == "delivery_report") {
                                            echo "<tr>"
                                            . "<th style='width: auto;'>Delivery ID</th>"
                                            . "<th style='width: auto;'>Delivery Quantity</th>"
                                            . "<th style='width: auto;'>Profits (RM)</th>"
//                                            . "<th style='width: 15%;'>Donator</th>"
//                                            . "<th style='width: 15%;'>Item ID</th>"
//                                            . "<th style='width: auto;'>endEvent</th>"
//                                            . "<th style='width: 15%;'>status</th>"
                                            . "</tr>";
                                        } else if ($type == "donation_event") {
                                            echo "<tr>"
                                            . "<th style='width: 15%;'>Event ID</th>"
                                            . "<th style='width: 15%;'>Title</th>"
                                            . "<th style='width: 15%;'>Receiver</th>"
                                            . "<th style='width: 15%;'>Donator</th>"
                                            . "<th style='width: 15%;'>Item ID</th>"
                                            . "<th style='width: auto;'>endEvent</th>"
                                            . "<th style='width: 15%;'>status</th>"
                                            . "</tr>";
                                        }
                                    }
                                    ?>
                                </thead>
                                <tbody>
                                    <?php
                                    if (isset($type)) {
                                        if ($type == "trade_report") {
                                            $result = $dbc->query($sql);
                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    $sql1 = "SELECT * FROM trade_details WHERE tradeid = '{$row['tradeid']}' AND custid = '{$row['acceptCustID']}'";
                                                    $result1 = $dbc->query($sql1);
                                                    $test = true;
                                                    if ($result1->num_rows > 0) {
                                                        while ($row1 = $result1->fetch_assoc()) {
                                                            if ($test == true) {
                                                                echo "<tr>"
                                                                . "<td><a>" . $row1["tradeid"] . "</a></td>"
                                                                . "<td><a>" . $row["acceptCustID"] . "</a></td>"
                                                                . "<td><a>" . $row1["itemid"] . "</a></td>"
                                                                . "<td><a>" . $row["tradeDate"] . "</a></td>"
                                                                . "<td><a>" . $row["status"] . "</a></td>"
                                                                . "</tr>";
                                                                $test = false;
                                                            } else {
                                                                echo "<tr>"
                                                                . "<td></td>"
                                                                . "<td></td>"
                                                                . "<td><a>" . $row1["itemid"] . "</a></td>"
                                                                . "<td></td>"
                                                                . "<td></td>"
                                                                . "</tr>";
                                                            }
                                                        }
                                                    }
                                                    $sql1 = "SELECT * FROM trade_details WHERE tradeid = '{$row['tradeid']}' AND custid = '{$row['offerCustID']}'";
                                                    $result1 = $dbc->query($sql1);
                                                    $test = true;
                                                    if ($result1->num_rows > 0) {
                                                        while ($row1 = $result1->fetch_assoc()) {
                                                            if ($test == true) {
                                                                echo "<tr>"
                                                                . "<td></td>"
                                                                . "<td><a>" . $row["offerCustID"] . "</a></td>"
                                                                . "<td><a>" . $row1["itemid"] . "</a></td>"
                                                                . "<td></td>"
                                                                . "<td></td>"
                                                                . "</tr>";
                                                                $test = false;
                                                            } else {
                                                                echo "<tr>"
                                                                . "<td></td>"
                                                                . "<td></td>"
                                                                . "<td><a>" . $row1["itemid"] . "</a></td>"
                                                                . "<td></td>"
                                                                . "<td></td>"
                                                                . "</tr>";
                                                            }
                                                        }
                                                    }
                                                    echo "<tr>"
                                                    . "<td></td>"
                                                    . "<td></td>"
                                                    . "<td></td>"
                                                    . "<td></td>"
                                                    . "<td></td>"
                                                    . "</tr>";
                                                }
                                            }
                                        } else if ($type == "top_valueitem") {
                                            $result = $dbc->query($sql);
                                            if ($result->num_rows > 0) {
                                                $totalqty = 0;
                                                $totalamount = 0;
                                                while ($row = $result->fetch_assoc()) {
                                                    $totalamount += $row["totalvalue"];
                                                    echo "<tr>"
                                                    . "<td><a>" . $row["custid"] . "</a></td>"
                                                    . "<td><a>" . $row["username"] . "</a></td>"
                                                    . "<td><a>" . $row["totalitem"] . "</a></td>"
                                                    . "<td><a>" . $row["totalvalue"] . "</a></td>"
                                                    . "</tr>";
                                                }
                                            }
                                        } else if ($type == "customer_inventory") {
                                            $result = $dbc->query($sql);
                                            if ($result->num_rows > 0) {
                                                $totalqty = 0;
                                                $totalamount = 0;
                                                while ($row = $result->fetch_assoc()) {
                                                    $sql1 = "SELECT DISTINCT itemid, itemname, brand, catname FROM item WHERE custid = '" . $row['custid'] . "'";
                                                    $result1 = $dbc->query($sql1);
                                                    $test = true;
                                                    if ($result1->num_rows > 0) {
                                                        while ($row1 = $result1->fetch_assoc()) {
                                                            if ($test == true) {
                                                                echo "<tr>"
                                                                . "<td><a>" . $row["custid"] . "</a></td>"
                                                                . "<td><a>" . $row["username"] . "</a></td>"
                                                                . "<td><a>" . $row1["itemname"] . "</a></td>"
                                                                . "<td><a>" . $row1["catname"] . "</a></td>"
                                                                . "<td><a>" . $row1["brand"] . "</a></td>"
                                                                . "</tr>";
                                                                $test = false;
                                                            } else {
                                                                echo "<tr>"
                                                                . "<td></td>"
                                                                . "<td></td>"
                                                                . "<td><a>" . $row1["itemname"] . "</a></td>"
                                                                . "<td><a>" . $row1["catname"] . "</a></td>"
                                                                . "<td><a>" . $row1["brand"] . "</a></td>"
                                                                . "</tr>";
                                                            }
                                                        }
                                                    }
                                                    echo "<tr>"
                                                    . "<td></td>"
                                                    . "<td></td>"
                                                    . "<td></td>"
                                                    . "<td></td>"
                                                    . "<td></td>"
                                                    . "</tr>";
                                                }
                                            }
                                        } else if ($type == "delivery_report") {
                                            $result = $dbc->query($sql);
                                            if ($result->num_rows > 0) {
                                                $totalqty = 0;
                                                $totalamount = 0;
                                                while ($row = $result->fetch_assoc()) {
                                                    $totalqty += $row["deliveryqty"];
                                                    $totalamount += $row["revenue"];
                                                    echo "<tr>"
                                                    . "<td><a>" . $row["id"] . "</a></td>"
                                                    . "<td><a>" . $row["deliveryqty"] . "</a></td>"
                                                    . "<td><a>" . $row["revenue"] . "</a></td>"
                                                    . "</tr>";
                                                }
                                            }
                                        } else if ($type == "admin_list") {
                                            $result = $dbc->query($sql);
                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    echo " <tr>"
                                                    . "<td><a>" . $row["adminid"] . "</a></td>"
                                                    . "<td><a>" . $row["name"] . "</a></td>"
                                                    . "<td><a>" . $row["email"] . "</a></td>"
                                                    . "<td><a>" . $row["phone"] . "</a></td>"
                                                    . "<td><a>" . $row["position"] . "</a></td>"
                                                    . "<td><a>" . $row["manager"] . "</a></td>"
                                                    . "</tr>";
                                                }
                                            }
                                        } else if ($type == "newuploads") {
                                            $result = $dbc->query($sql);
                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    echo " <tr>"
                                                    . "<td><a>" . $row["catid"] . "</a></td>"
                                                    . "<td><a>" . $row["name"] . "</a></td>"
                                                    . "<td><a>" . $row["catqty"] . "</a></td>"
                                                    . "</tr>";
                                                }
                                            }
                                        } else if ($type == "donation_event") {
                                            $result = $dbc->query($sql);
                                            if ($result->num_rows >= 0) {
                                                $countitem = 0;
                                                while ($row = $result->fetch_assoc()) {
                                                    $sql1 = "SELECT * FROM donation_details t, item i WHERE t.eventid = '{$row['eventid']}' AND t.itemid = i.itemid";
                                                    $result1 = $dbc->query($sql1);
                                                    $test = true;
                                                    if ($result1->num_rows >= 0) {
                                                        while ($row1 = $result1->fetch_assoc()) {
                                                            if ($test == true) {
                                                                echo "<tr>"
                                                                . "<td><a>" . $row["eventid"] . "</a></td>"
                                                                . "<td><a>" . $row["title"] . "</a></td>"
                                                                . "<td><a>" . $row["receiver"] . "</a></td>"
                                                                . "<td><a>" . $row1["custid"] . "</a></td>"
                                                                . "<td><a>" . $row1["itemid"] . "</a></td>"
                                                                . "<td><a>" . $row["endEvent"] . "</a></td>"
                                                                . "<td><a>" . $row["status"] . "</a></td>"
                                                                . "</tr>";
                                                                $test = false;
                                                            } else {
                                                                echo "<tr>"
                                                                . "<td></td>"
                                                                . "<td></td>"
                                                                . "<td></td>"
                                                                . "<td><a>" . $row1["custid"] . "</a></td>"
                                                                . "<td><a>" . $row1["itemid"] . "</a></td>"
                                                                . "<td></td>"
                                                                . "<td></td>"
                                                                . "<td</td>"
                                                                . "</tr>";
                                                            }
                                                        }
                                                    } else {
                                                        echo "<tr>"
                                                        . "<td><a>" . $row["eventid"] . "</a></td>"
                                                        . "<td><a>" . $row["title"] . "</a></td>"
                                                        . "<td><a>" . $row["receiver"] . "</a></td>"
                                                        . "<td></td>"
                                                        . "<td></td>"
                                                        . "<td><a>" . $row["endEvent"] . "</a></td>"
                                                        . "<td><a>" . $row["status"] . "</a></td>"
                                                        . "</tr>";
                                                    }
                                                    echo "<tr>"
                                                    . "<td></td>"
                                                    . "<td></td>"
                                                    . "<td></td>"
                                                    . "<td></td>"
                                                    . "<td></td>"
                                                    . "<td></td>"
                                                    . "<td></td>"
                                                    . "</tr>";
                                                }
                                            } else {
                                                echo "<tr>"
                                                . "<td><a>" . $row["eventid"] . "</a></td>"
                                                . "<td><a>" . $row["title"] . "</a></td>"
                                                . "<td><a>" . $row["receiver"] . "</a></td>"
                                                . "<td></td>"
                                                . "<td></td>"
                                                . "<td><a>" . $row["endEvent"] . "</a></td>"
                                                . "<td><a>" . $row["status"] . "</a></td>"
                                                . "</tr>";
                                            }
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
        $(function () {
            $("#example1").DataTable({
                "responsive": true, "lengthChange": true, "autoWidth": false, "ordering": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });
        function changetype(value) {
            if (value === "trade_report" || value === "newuploads") {
                document.getElementById("datefrom").disabled = false;
                document.getElementById("dateto").disabled = false;
            } else if (value === "donation_event") {
                document.getElementById("datefrom").disabled = true;
                document.getElementById("dateto").disabled = false;
            } else {
                document.getElementById("datefrom").disabled = true;
                document.getElementById("dateto").disabled = true;
                document.getElementById("datefrom").value = "";
                document.getElementById("dateto").value = "";
            }
        }

        function generate_report() {
            var fulfill = true;
            var message = "";
            if ((document.getElementById("type").value === "trade_report") || (document.getElementById("type").value === "newuploads")) {
                var dateformat = /^\d{2}\/\d{2}\/\d{4}$/;
                if (!document.getElementById("datefrom") || document.getElementById("datefrom") === "") {
                    fulfill = false;
                    message += "Please enter starting date.\n";
                } else {
                    if (!document.getElementById("datefrom").value.match(dateformat)) {
                        fulfill = false;
                        message += "Invalid start date format!\n";
                    }
                }

                if (!document.getElementById("dateto") || document.getElementById("dateto") === "") {
                    fulfill = false;
                    message += "Please enter end date.\n";
                } else {
                    if (!document.getElementById("dateto").value.match(dateformat)) {
                        fulfill = false;
                        message += "Invalid end date format!\n";
                    }
                }

                var datefrom = new Date(document.getElementById("datefrom").value);
                var dateto = new Date(document.getElementById("dateto").value);
                if (datefrom > dateto) {
                    fulfill = false;
                    message += "End date must not be larger than start date!\n";
                }
            } else if ((document.getElementById("type").value === "donation_event")) {
                var dateformat = /^\d{2}\/\d{2}\/\d{4}$/;
                if (!document.getElementById("dateto") || document.getElementById("dateto") === "") {
                    fulfill = false;
                    message += "Please enter end date.\n";
                } else {
                    if (!document.getElementById("dateto").value.match(dateformat)) {
                        fulfill = false;
                        message += "Invalid end date format!\n";
                    }
                }

                var dateto = new Date(document.getElementById("dateto").value);
            }
            if (fulfill) {
                document.getElementById("form").submit();
            } else {
                alert(message);
            }
        }

        var dateInputMask = function dateInputMask(elm) {
            elm.addEventListener('keypress', function (e) {
                if (e.keyCode < 47 || e.keyCode > 57) {
                    e.preventDefault();
                }

                var len = elm.value.length;
                if (len !== 1 || len !== 3) {
                    if (e.keyCode === 47) {
                        e.preventDefault();
                    }
                }

                if (len === 2) {
                    elm.value += '/';
                }

                if (len === 5) {
                    elm.value += '/';
                }
            });
        };
        dateInputMask(document.getElementById("datefrom"));
        dateInputMask(document.getElementById("dateto"));
    </script>
    <script src="../bootstrap/plugins/jquery/jquery.min.js"></script>
    <script src="../bootstrap/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../bootstrap/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../bootstrap/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="../bootstrap/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../bootstrap/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="../bootstrap/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="../bootstrap/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="../bootstrap/plugins/jszip/jszip.min.js"></script>
    <script src="../bootstrap/plugins/pdfmake/pdfmake.min.js"></script>
    <script src="../bootstrap/plugins/pdfmake/vfs_fonts.js"></script>
    <script src="../bootstrap/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="../bootstrap/plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="../bootstrap/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <script src="../bootstrap/dist/js/adminlte.min.js"></script>
    <script src="../bootstrap/dist/js/demo.js"></script>
    <script src="../bootstrap/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="../bootstrap/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="../bootstrap/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
</html>