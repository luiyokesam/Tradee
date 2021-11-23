<?php
$page = 'report';
include 'navbar.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $type = $_POST["type"];
    if (isset($_POST["datefrom"])) {
        $datefrom = $_POST["datefrom"];
        $dateto = $_POST["dateto"];
    }

//    if ($type == "trade") {
//        $sql = "SELECT DISTINCT c.custid, c.username, count(t.tradeid) as tradeqty, t.acceptCustID , t.tradeDate, td.itemid "
//                . "FROM trade t, trade_details td , customer c "
//                . "WHERE t.tradeid = td.tradeid AND str_to_date(tradeDate, '%d/%m/%Y') >= str_to_date('$datefrom', '%d/%m/%Y') AND "
//                . "str_to_date(tradeDate, '%d/%m/%Y') <= str_to_date('$dateto', '%d/%m/%Y') AND "
//                . "status = 'Completed' AND "
//                . "c.custid = t.offerCustID "
//                . "GROUP BY c.custid";
//
//        $title = "Trades Report";
//    }
    if ($type == "trade_report") {
        $sql = "SELECT * FROM trade t, customer c "
                . "WHERE (c.custid = t.offerCustID OR c.custid = t.acceptCustID) AND "
                . "str_to_date(t.tradeDate, '%d/%m/%Y') >= str_to_date('$datefrom', '%d/%m/%Y') AND "
                . "str_to_date(t.tradeDate, '%d/%m/%Y') <= str_to_date('$dateto', '%d/%m/%Y')";

        $title = "Trades Report";
    } else if ($type == "top_valueitem") {
        $sql = "SELECT c.custid as custid, c.username, COUNT(i.itemid) AS totalitem, SUM(i.value) AS totalvalue "
                . "FROM customer c, item i "
                . "WHERE c.custid = i.custid "
                . "GROUP BY c.custid";

        $title = "Customer Item Value Report";
    } else if ($type == "customer_inventory") {
        $sql = "SELECT DISTINCT custid, username "
                . "FROM customer";

        $title = "Customers Inventory";
    } else if ($type == "delivery_report") {
        $sql = "SELECT d.senderid as id , count(d.senderid) as deliveryqty,SUM(d.totalAmount) AS revenue FROM `customer` as c , `delivery` as d where c.custid = d.senderid group by senderid order by deliveryqty DESC";

        $title = "Delivery Report";
    } else if ($type == "admin_list") {
        $sql = "SELECT * from admin";

        $title = "Admin List report";
    } else if ($type == "newuploads") {
        $sql = "SELECT c.catid, c.name, count(i.tradeItem) as catqty, i.postDate FROM `item` as i, `category` as c where c.name = i.tradeItem AND str_to_date(postDate, '%d/%m/%Y' ) >= str_to_date('$datefrom', '%d/%m/%Y' ) AND str_to_date(postDate, '%d/%m/%Y' ) <= str_to_date('$dateto', '%d/%m/%Y' )  group by i.tradeItem order by catqty DESC";

        $title = "New uploads report";
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
                                                    if ($type == "trade") {
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
                                            <label class="col-form-label">Date From :</label>
                                        </div>

                                        <div class="col-md-auto">
                                            <input class="form-control" id="dateto" name="dateto"  placeholder="dd/mm/yyyy" maxlength="10" value="">
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
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <?php
                                    if (isset($type)) {
                                        if ($type == "trade_report") {
                                            echo "<tr>"
                                            . "<th style='width: 12%;'>Trade ID</th>"
                                            . "<th style='width: 12%;'>Offer Customer</th>"
                                            . "<th style='width: 12%;'>Offer Item</th>"
                                            . "<th style='width: 12%;'>Accept Customer</th>"
                                            . "<th style='width: 12%;'>Accept Item</th>"
                                            . "<th style='width: auto;'>Date</th>"
                                            . "<th style='width: 12%;'>Status</th>"
                                            . "</tr>";
                                        } else if ($type == "top_valueitem") {
                                            echo '<tr>
                                        <th style="width: 25%;">
                                            Customer ID
                                        </th>
                                        <th style="width: 25%;">
                                            Username
                                        </th>
                                        <th style="width: 25%;">
                                            Quantity
                                        </th>
                                        <th style="width: 25%;">
                                            Total value(RM)
                                        </th>
                                   
                                     </tr>';
                                        } else if ($type == "top_valueitem") {
                                            echo '<tr>
                                        <th style="width: 25%;">
                                            Customer ID
                                        </th>
                                        <th style="width: 25%;">
                                            Username
                                        </th>
                                        <th style="width: 25%;">
                                            Quantity
                                        </th>
                                        <th style="width: 25%;">
                                            Total value(RM)
                                        </th>
                                   
                                     </tr>';
                                        } else if ($type == "customer_inventory") {
                                            echo "<tr>"
                                            . "<th style='width: 25%;'>Customer ID</th>"
                                            . "<th style='width: 25%;'>Item Name</th>"
                                            . "<th style='width: 25%;'>Value</th>"
                                            . "<th style='width: 25%;'>Status</th>"
                                            . "</tr>";
                                        } else if ($type == "newuploads") {
                                            echo '<tr>
                                       <th style="width: 25%;">
                                           Category ID
                                        </th>
                                        <th style="width: 25;">
                                           Item Category
                                        </th>
                                        <th style="width: 25%;">
                                            Number of Uploads
                                        </th>
                                      
                                    </tr>';
                                        } else if ($type == "admin_list") {
                                            echo '<tr>
                                        <th style="width: 15%;">
                                            Admin ID
                                        </th>
                                        <th style="width: 15%;">
                                            Name
                                        </th>
                                        <th style="width: 25%;">
                                            Email 
                                        </th>
                                        <th style="width: 15%;">
                                            Phone 
                                        </th>
                                        <th style="width: 15%;">
                                            Position
                                        </th>
                                        <th style="width: 15%;">
                                            Manager
                                        </th>
                                    </tr>';
                                        }
                                    }
                                    ?>
                                </thead>
                                <tbody>
                                    <?php
                                    if (isset($type)) {
                                        if ($type == "trade") {
                                            $result = $dbc->query($sql);
                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    $sql1 = "SELECT * FROM trade_details d WHERE d.tradeid = '{$row['tradeid']} AND d.custid = '{$row['custid']}'";
                                                    $result1 = $dbc->query($sql1);
                                                    $test = true;
                                                    if ($result1->num_rows > 0) {
                                                        while ($row1 = $result1->fetch_assoc()) {
                                                            
                                                        }
                                                    }
//                                                    echo "<tr>"
//                                                    . "<td><a>" . $row["custid"] . "</a></td>"
//                                                    . "<td><a>" . $row["username"] . "</a></td>"
//                                                    . "<td><a>" . $row["tradeqty"] . "</a></td>"
//                                                    . "<td><a>" . $row["acceptCustID"] . "</a></td>"
//                                                    . "<td><a>" . $row["tradeDate"] . "</a></td>"
//                                                    . "</tr>";
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
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!--                    <div class="card">
                                            <div class="card-header">
                                                <h3 class="card-title"><?php
                    if (isset($title)) {
                        echo $title;
                    }
                    ?></h3>
                                            </div>
                                            <div class="card-body p-0">
                                                <table class="table table-striped projects" id="reportable">
                    <?php
                    if (isset($type)) {
                        if ($type == "trade") {
                            echo '<tr>
                                        <th style="width: 20%;">
                                            Customer ID
                                        </th>
                                       <th style="width: 20%;">
                                            Username
                                        </th>
                                        <th style="width: 20%;">
                                            Number of trade(s) Made
                                        </th>
                                        <th style="width: 20%;">
                                           Trading Parnter ID
                                        </th>
                                        <th style="width: 20%;">
                                            Date
                                        </th>

                                    </tr>';
                        } else if ($type == "top_valueitem") {
                            echo '<tr>
                                        <th style="width: 25%;">
                                            Customer ID
                                        </th>
                                        <th style="width: 25%;">
                                            Username
                                        </th>
                                        <th style="width: 25%;">
                                            Quantity
                                        </th>
                                        <th style="width: 25%;">
                                            Total value(RM)
                                        </th>
                                   
                                     </tr>';
                        } else if ($type == "top_valueitem") {
                            echo '<tr>
                                        <th style="width: 25%;">
                                            Customer ID
                                        </th>
                                        <th style="width: 25%;">
                                            Username
                                        </th>
                                        <th style="width: 25%;">
                                            Quantity
                                        </th>
                                        <th style="width: 25%;">
                                            Total value(RM)
                                        </th>
                                   
                                     </tr>';
                        } else if ($type == "customer_inventory") {
                            echo "<tr>"
                            . "<th style='width: 25%;'>Customer ID</th>"
                            . "<th style='width: 25%;'>Item Name</th>"
                            . "<th style='width: 25%;'>Value</th>"
                            . "<th style='width: 25%;'>Status</th>"
                            . "</tr>";
                        } else if ($type == "newuploads") {
                            echo '<tr>
                                       <th style="width: 25%;">
                                           Category ID
                                        </th>
                                        <th style="width: 25;">
                                           Item Category
                                        </th>
                                        <th style="width: 25%;">
                                            Number of Uploads
                                        </th>
                                      
                                    </tr>';
                        } else if ($type == "admin_list") {
                            echo '<tr>
                                        <th style="width: 15%;">
                                            Admin ID
                                        </th>
                                        <th style="width: 15%;">
                                            Name
                                        </th>
                                        <th style="width: 25%;">
                                            Email 
                                        </th>
                                        <th style="width: 15%;">
                                            Phone 
                                        </th>
                                        <th style="width: 15%;">
                                            Position
                                        </th>
                                        <th style="width: 15%;">
                                            Manager
                                        </th>
                                    </tr>';
                        }
                    }
                    ?>
                    
                                                    </thead>
                                                    <tbody>
                    <?php
                    if (isset($type)) {
                        if ($type == "trade") {
                            $result = $dbc->query($sql);
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>"
                                    . "<td><a>" . $row["custid"] . "</a></td>"
                                    . "<td><a>" . $row["username"] . "</a></td>"
                                    . "<td><a>" . $row["tradeqty"] . "</a></td>"
                                    . "<td><a>" . $row["acceptCustID"] . "</a></td>"
                                    . "<td><a>" . $row["tradeDate"] . "</a></td>"
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
                                    if ($result1->num_rows > 0) {
                                        while ($row1 = $result1->fetch_assoc()) {
                                            echo "<tr>"
                                            . "<td><a>" . $row["custid"] . "</a></td>"
                                            . "<td><a>" . $row["username"] . "</a></td>"
                                            . "<td></td>"
                                            . "<td></td>"
                                            . "</tr>";
                                            echo "<tr>"
                                            . "<td></td>"
                                            . "<td></td>"
                                            . "<td><a>" . $row1["brand"] . "</a></td>"
                                            . "<td><a>" . $row1["catname"] . "</a></td>"
                                            . "</tr>";
                                        }
                                    }

//                                                    $totalamount += $row["totalvalue"];
//                                                    echo "<tr>"
//                                                    . "<td><a>" . $row["custid"] . "</a></td>"
//                                                    . "<td><a>" . $row["username"] . "</a></td>"
//                                                    . "<td><a>" . $row["totalitem"] . "</a></td>"
//                                                    . "<td><a>" . $row["totalvalue"] . "</a></td>"
//                                                    . "</tr>";
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
                        }
                    }
                    ?>
                    
                                                    </tbody>
                                                    <tfoot>
                    <?php
                    if (isset($type)) {
                        if ($type == "trade") {
                            echo '<tr><th style="width: 20%;">' . $result->num_rows . '</th>
                                        <th style="width: 20%;">
                                        </th>
                                          <th style="width: 20%;">
                                            
                                        </th>
                                          <th style="width: 20%;">
                                            
                                        </th>
                                          <th style="width: 20%;">
                                            
                                        </th>
                                          <th style="width: 20%;">
                                        </th>
                                        </tr>';
                        } else if ($type == "top_product") {
                            echo '<tr><th style="width: 33%;">' . $result->num_rows . '</th>

                                        <th style="width: 33%;">
                                            ' . $totalqty . '
                                        </th>
                                        <th style="width: 33%;">
                                            ' . $totalamount . '
                                        </th>

                                        </tr>';
                        } else if ($type == "delivery_report") {
                            echo '<tr><th style="width: 33%;"> Total Customers : ' . $result->num_rows . '</th>

                                        <th style="width: 33%;">
                                            ' . $totalqty . '
                                        </th>
                                        <th style="width: 33%;">
                                           Total Revenue Earned : ' . $totalamount . '
                                        </th>

                                        </tr>';
                        }
                    }
                    ?>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>-->
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

        function generate_report() {
            var fulfill = true;
            var message = "";
            if (document.getElementById("type").value === "" && document.getElementByID("type").value === "newuploads") {
                var dateformat = /^\d{2}\/\d{2}\/\d{4}$/;

                if (!document.getElementById("datefrom") || document.getElementById("datefrom") === "") {
                    fulfill = false;
                    message += "Invalid date from!\n"
                } else {
                    if (!document.getElementById("datefrom").value.match(dateformat)) {
                        fulfill = false;
                        message += "Invalid date from!\n"
                    }
                }

                if (!document.getElementById("dateto") || document.getElementById("dateto") === "") {
                    fulfill = false;
                    message += "Invalid date to!\n"
                } else {
                    if (!document.getElementById("dateto").value.match(dateformat)) {
                        fulfill = false;
                        message += "Invalid date to!\n"
                    }
                }

                var datefrom = new Date(document.getElementById("datefrom").value);
                var dateto = new Date(document.getElementById("dateto").value);


                if (datefrom > dateto) {
                    fulfill = false;
                    message += "Date from cannot over than date to!\n"
                }
            }


            if (fulfill) {
                document.getElementById("form").submit();
            } else {
                alert(message);
            }
        }

        function changetype(value) {
            if (value === "trade" && value === "newuploads") {
                document.getElementById("datefrom").disabled = false;
                document.getElementById("dateto").disabled = false;
            } else {
                document.getElementById("datefrom").disabled = true;
                document.getElementById("dateto").disabled = true;
                document.getElementById("datefrom").value = "";
                document.getElementById("dateto").value = "";
            }
        }

        function print() {
            var divToPrint = document.getElementById("data");
            newWin = window.open("");
            newWin.document.write(divToPrint.outerHTML);
            newWin.print();
            newWin.close();
        }
    </script>
    <!-- jQuery -->
    <script src="../bootstrap/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../bootstrap/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables  & Plugins -->
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
    <!-- AdminLTE App -->
    <script src="../bootstrap/dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../bootstrap/dist/js/demo.js"></script>
    <!-- Page specific script -->
    <script src="../bootstrap/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="../bootstrap/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="../bootstrap/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
</html>