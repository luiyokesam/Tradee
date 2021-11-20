
<?php
include 'navbar.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $type = $_POST["type"];
    if (isset($_POST["datefrom"])) {
        $datefrom = $_POST["datefrom"];
        $dateto = $_POST["dateto"];
    }

    if ($type == "trade") {
        $sql = "SELECT DISTINCT c.custid, c.username, count(t.tradeid) as tradeqty , t.acceptCustID , t.tradeDate, td.itemid FROM `trade` as t, `trade_details` as td , `customer` as c WHERE t.tradeid = td.tradeid AND str_to_date(tradeDate, '%d/%m/%Y' ) >= str_to_date('$datefrom', '%d/%m/%Y' )AND str_to_date(tradeDate, '%d/%m/%Y' ) <= str_to_date('$dateto', '%d/%m/%Y' ) AND status = 'Completed' AND c.custid = t.offerCustID group by c.custid";
        $title = "Trade report";
    } else if ($type == "top_valueitem") {
        $sql = "SELECT c.custid as custid, c.username,  SUM(i.value) AS totalvalue FROM `customer` as c, `item` as i where c.custid = i.custid group by custid";
        $title = "Top value item report";
    } else if ($type == "top_customer") {
        $sql = "SELECT  d.senderid as id , count(d.senderid) as deliveryqty,SUM(d.totalAmount) AS revenue FROM `customer` as c , `delivery` as d where c.custid = d.senderid group by senderid order by deliveryqty DESC";
        $title = "Top Customer Sales report";
    } else if ($type == "admin_list") {
        $sql = "SELECT * from admin";
        $title = "Admin List report";
    } else if ($type == "newuploads") {
        $sql = "SELECT   c.catid , c.name , count(i.tradeItem) as catqty, i.postDate FROM `item` as i, `category` as c where c.name = i.tradeItem AND str_to_date(postDate, '%d/%m/%Y' ) >= str_to_date('$datefrom', '%d/%m/%Y' )AND str_to_date(postDate, '%d/%m/%Y' ) <= str_to_date('$dateto', '%d/%m/%Y' )  group by i.tradeItem order by catqty DESC";
        $title = "New uploads report";
    }
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Report</title>
    </head>
    <body class="hold-transition sidebar-mini layout-fixed">
        <div class="wrapper">
            <div class="content-wrapper">
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-12">
                            <div class="col-sm-6">
                                <h1 class="m-0 text-dark">Report</h1>
                            </div>
                        </div>
                    </div>
                </div>

                <section class="content">
                    <nav class="navbar navbar-expand navbar-light">
                        <form class="form-inline ml-3"  id="form" method="post">
                            <div class="input-group input-group-sm">
                                <label style="padding-left: 10px">Report type : </label>
                                <div class="form-group" style="padding-left: 10px">
                                    <select class="custom-select" style="width:200px" name="type" id="type" onchange="changetype(this.value)">
                                        <option value="trade" <?php
if (isset($type)) {
    if ($type == "trade") {
        echo "selected";
    }
}
?>>Trades Made </option>
                                        <option value="top_valueitem" <?php
                                                if (isset($type)) {
                                                    if ($type == "top_valueitem") {
                                                        echo "selected";
                                                    }
                                                }
                                                ?>>Top Value Items</option>
                                        <option value="top_customer" <?php
                                                if (isset($type)) {
                                                    if ($type == "top_customer") {
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
                                <label style="padding-left: 10px">Date fom : r</label>
                                <div class="form-group" style="padding-left: 10px">
                                    <input class="form-control" id="datefrom" name="datefrom" placeholder="dd/mm/yyyy" maxlength="10" value="<?php
                                        if (isset($datefrom)) {
                                            echo $datefrom;
                                        }
                                                ?>">
                                </div>
                                <label style="padding-left: 10px">Date to : </label>
                                <div class="form-group" style="padding-left: 10px;padding-right: 10px">
                                    <input class="form-control" id="dateto" name="dateto"  placeholder="dd/mm/yyyy" maxlength="10" value="">
                                </div>
                                <div class="form-group" style="padding-left: 10px;padding-right: 10px">
                                    <button class="btn btn-primary" type="button" onclick="generate_report()">Generate</button>
                                </div>
<?php
if (isset($title)) {
    echo '<button class="btn btn-success" type="button" style="width:150px" onclick="print()">Print report</button>';
}
?>


                            </div>
                        </form>
                    </nav>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><?php
                                if (isset($title)) {
                                    echo $title;
                                }
?></h3>

                        </div>
                        <div class="card-body p-0">
                            <table class="table table-striped projects" id="data">
                                <?php
                                if (isset($type)) {
                                    if ($type == "trade") {
                                        echo '<tr>
                                        <th style="width: 20%;text-align: center">
                                            Customer ID
                                        </th>
                                       <th style="width: 20%;text-align: center">
                                            Username
                                        </th>
                                        <th style="width: 20%;text-align: center">
                                            Number of trade(s) Made
                                        </th>
                                        <th style="width: 20%;text-align: center">
                                           Trading Parnter ID
                                        </th>
                                        <th style="width: 20%;text-align: center">
                                            Date
                                        </th>
                                    
                                        

                                    </tr>';
                                    } else if ($type == "top_valueitem") {
                                        echo '<tr>
                                        <th style="width: 33%;text-align: center">
                                            Customer ID
                                        </th>
                                        <th style="width: 33%;text-align: center">
                                            Username
                                        </th>
                                        <th style="width: 33%;text-align: center">
                                            Total value(RM)
                                        </th>
                                   
                                     </tr>';
                                    } else if ($type == "top_customer") {
                                        echo '<tr>
                                        <th style="width: 33%;text-align: center">
                                            Customer ID
                                        </th>
                                        <th style="width: 33%;text-align: center">
                                            Delivery (s) Made
                                        </th>
                                        <th style="width: 33%;text-align: center">
                                            Revenue Earned (RM)
                                        </th>
                                    </tr>';
                                    } else if ($type == "newuploads") {
                                        echo '<tr>
                                       <th style="width: 25%;text-align: center">
                                           Category ID
                                        </th>
                                        <th style="width: 25;text-align: center">
                                           Item Category
                                        </th>
                                        <th style="width: 25%;text-align: center">
                                            Number of Uploads
                                        </th>
                                      
                                    </tr>';
                                    } else if ($type == "admin_list") {
                                        echo '<tr>
                                        <th style="width: 15%;text-align: center">
                                            Admin ID
                                        </th>
                                        <th style="width: 15%;text-align: center">
                                            Name
                                        </th>
                                        <th style="width: 25%;text-align: center">
                                            Email 
                                        </th>
                                        <th style="width: 15%;text-align: center">
                                            Phone 
                                        </th>
                                        <th style="width: 15%;text-align: center">
                                            Position
                                        </th>
                                        <th style="width: 15%;text-align: center">
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
                                                . "<td style='text-align: center'><a>" . $row["custid"] . "</a></td>"
                                                . "<td style='text-align: center'><a>" . $row["username"] . "</a></td>"
                                                . "<td style='text-align: center'><a>" . $row["tradeqty"] . "</a></td>"
                                                . "<td style='text-align: center'><a>" . $row["acceptCustID"] . "</a></td>"
                                                . "<td style='text-align: center'><a>" . $row["tradeDate"] . "</a></td>"
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
                                                . "<td style='text-align: center'><a>" . $row["custid"] . "</a></td>"
                                                . "<td style='text-align: center'><a>" . $row["username"] . "</a></td>"
                                                . "<td style='text-align: center'><a>" . $row["totalvalue"] . "</a></td>"
                                                . "</tr>";
                                            }
                                        }
                                    } else if ($type == "top_customer") {
                                        $result = $dbc->query($sql);
                                        if ($result->num_rows > 0) {
                                            $totalqty = 0;
                                            $totalamount = 0;
                                            while ($row = $result->fetch_assoc()) {
                                                $totalqty += $row["deliveryqty"];
                                                $totalamount += $row["revenue"];
                                                echo "<tr>"
                                                . "<td style='text-align: center'><a>" . $row["id"] . "</a></td>"
                                                . "<td style='text-align: center'><a>" . $row["deliveryqty"] . "</a></td>"
                                                . "<td style='text-align: center'><a>" . $row["revenue"] . "</a></td>"
                                                . "</tr>";
                                            }
                                        }
                                    } else if ($type == "admin_list") {
                                        $result = $dbc->query($sql);
                                        if ($result->num_rows > 0) {

                                            while ($row = $result->fetch_assoc()) {


                                                echo " <tr>"
                                                . "<td style='text-align: center'><a>" . $row["adminid"] . "</a></td>"
                                                . "<td style='text-align: center'><a>" . $row["name"] . "</a></td>"
                                                . "<td style='text-align: center'><a>" . $row["email"] . "</a></td>"
                                                . "<td style='text-align: center'><a>" . $row["phone"] . "</a></td>"
                                                . "<td style='text-align: center'><a>" . $row["position"] . "</a></td>"
                                                . "<td style='text-align: center'><a>" . $row["manager"] . "</a></td>"
                                                . "</tr>";
                                            }
                                        }
                                    } else if ($type == "newuploads") {
                                        $result = $dbc->query($sql);
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                echo " <tr>"
                                                . "<td style='text-align: center'><a>" . $row["catid"] . "</a></td>"
                                                . "<td style='text-align: center'><a>" . $row["name"] . "</a></td>"
                                                . "<td style='text-align: center'><a>" . $row["catqty"] . "</a></td>"
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
                                            echo '<tr><th style="width: 20%;text-align: center">' . $result->num_rows . '</th>
                                        <th style="width: 20%;text-align: center">
                                            
                                        </th>
                                          <th style="width: 20%;text-align: center">
                                            
                                        </th>
                                          <th style="width: 20%;text-align: center">
                                            
                                        </th>
                                          <th style="width: 20%;text-align: center">
                                            
                                        </th>
                                          <th style="width: 20%;text-align: center">
                                            
                                        </th>
                                        
                                    
                                            
                                        
                                  
                                        </tr>';
                                        } else if ($type == "top_product") {
                                            echo '<tr><th style="width: 33%;text-align: center">' . $result->num_rows . '</th>

                                        <th style="width: 33%;text-align: center">
                                            ' . $totalqty . '
                                        </th>
                                        <th style="width: 33%;text-align: center">
                                            ' . $totalamount . '
                                        </th>

                                        </tr>';
                                        } else if ($type == "top_customer") {
                                            echo '<tr><th style="width: 33%;text-align: center"> Total Customers : ' . $result->num_rows . '</th>

                                        <th style="width: 33%;text-align: center">
                                            ' . $totalqty . '
                                        </th>
                                        <th style="width: 33%;text-align: center">
                                           Total Revenue Earned : ' . $totalamount . '
                                        </th>

                                        </tr>';
                                        }
                                    }
                                    ?>
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
