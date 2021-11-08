
<?php
include 'navbar.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $type = $_POST["type"];
    if (isset($_POST["datefrom"])) {
        $datefrom = $_POST["datefrom"];
        $dateto = $_POST["dateto"];
    }

    if ($type == "sales") {
        $sql = "SELECT * FROM `order` WHERE str_to_date(order_date, '%d/%m/%Y' ) >= str_to_date('$datefrom', '%d/%m/%Y' )AND str_to_date(order_date, '%d/%m/%Y' ) <= str_to_date('$dateto', '%d/%m/%Y' ) AND order_status = 'Success'";
        $title = "Sales report";
    } else if ($type == "top_product") {
        $sql = "select od.productid as productid, sum(od.quantity) as TotalQty,sum(od.price) as totalprice from order_detail as od , `order` as o where (o.orderid = od.orderid) AND o.order_status = 'Success' group by od.productid";
        $title = "Top product sales report";
    } else if ($type == "top_customer") {
        $sql = "SELECT c.custid as id , COUNT(O.orderid) as orderqty,SUM(o.net_amount) AS revenue FROM `customer` as c , `order` as o WHERE c.custid = o.custid AND o.order_status = 'Success' order by revenue";
        $title = "Top customer sales report";
    }
    else if ($type == "admin_list") {
        $sql = "SELECT * from admin";
        $title = "List of admin report";
    }
    else if ($type == "new_customers") {
        $sql = "SELECT * from customer";
        $title = "Customers report";
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
                                        <option value="sales" <?php
                                        if (isset($type)) {
                                            if ($type == "sales") {
                                                echo "selected";
                                            }
                                        }
                                        ?>>Sales</option>
                                        <option value="top_product" <?php
                                        if (isset($type)) {
                                            if ($type == "top_product") {
                                                echo "selected";
                                            }
                                        }
                                        ?>>Top product sale</option>
                                        <option value="top_customer" <?php
                                        if (isset($type)) {
                                            if ($type == "top_customer") {
                                                echo "selected";
                                            }
                                        }
                                        ?>>Top customer sales</option>
                                            <option value="admin_list" <?php
                                        if (isset($type)) {
                                            if ($type == "admin_list") {
                                                echo "selected";
                                            }
                                        }
                                        ?>>List of admin</option>
                                          <option value="new_customers" <?php
                                        if (isset($type)) {
                                            if ($type == "new_customers") {
                                                echo "selected";
                                            }
                                        }
                                        ?>>New Customers</option>
                                        
                                    </select>
                                </div>
                                <label style="padding-left: 10px">Date from : </label>
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
                                }   ?></h3>
                      
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-striped projects" id="data">
                              <?php
                                    if (isset($type)) {
                                        if ($type == "sales") {
                                            echo '<tr>
                                        <th style="width: 20%;text-align: center">
                                            Order Id
                                        </th>
                                        <th style="width: 10%;text-align: center">
                                            Date ordered
                                        </th>
                                        <th style="width: 10%;text-align: center">
                                            Total(RM)
                                        </th>
                                        <th style="width: 10%;text-align: center">
                                            Tax(6%)(RM)
                                        </th>
                                        <th style="width: 10%;text-align: center">
                                            Sub total (RM)
                                        </th>
                                        <th style="width: 10%;text-align: center">
                                            Delivery fees (RM)
                                        </th>
                                        <th style="width: 10%;text-align: center">
                                            Net total (RM)
                                        </th>
                                        <th style="width: 10%;text-align: center">
                                            Delivery status
                                        </th>
                                        <th style="width: 10%;text-align: center">
                                            Order status
                                        </th>
                                    </tr>';
                                        } else if ($type == "top_product") {
                                            echo '<tr>
                                        <th style="width: 33%;text-align: center">
                                            Product id
                                        </th>
                                        <th style="width: 33%;text-align: center">
                                            Total quantity
                                        </th>
                                        <th style="width: 33%;text-align: center">
                                            Total amount(RM)
                                        </th>
                                    </tr>';
                                        } else if ($type == "top_customer") {
                                            echo '<tr>
                                        <th style="width: 33%;text-align: center">
                                            Customer id
                                        </th>
                                        <th style="width: 33%;text-align: center">
                                            Order quantity
                                        </th>
                                        <th style="width: 33%;text-align: center">
                                            Total Revenue(RM)
                                        </th>
                                    </tr>';
                                        } 
                                        
                                        
                                        else if ($type == "admin_list") {
                                            echo '<tr>
                                        <th style="width: 33%;text-align: center">
                                            admin id
                                        </th>
                                        <th style="width: 33%;text-align: center">
                                            password 
                                        </th>
                                        <th style="width: 33%;text-align: center">
                                            phone 
                                        </th>
                                    </tr>';
                                    }
                                    
                                    }
                                    
                                    ?>

                                </thead>
                                <tbody>
                                    <?php
                                    if (isset($type)) {
                                        if ($type == "sales") {
                                            $total = 0;
                                            $tax = 0;
                                            $subtotal_total = 0;
                                            $deliver_fees = 0;
                                            $net_amount = 0;
                                            $result = $conn->query($sql);
                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    $subtotal = $row["total_amount"] + $row["tax"];

                                                    $total += $row["total_amount"];
                                                    $tax += $row["tax"];
                                                    $subtotal_total += $subtotal;
                                                    $deliver_fees += $row["delivery_fees"];
                                                    $net_amount += $row["net_amount"];



                                                    echo "<tr>"
                                                    . "<td style='text-align: center'><a>" . $row["orderid"] . "</a></td>"
                                                    . "<td style='text-align: center'><a>" . $row["order_date"] . "</a></td>"
                                                    . "<td style='text-align: center'><a>" . $row["total_amount"] . "</a></td>"
                                                    . "<td style='text-align: center'><a>" . $row["tax"] . "</a></td>"
                                                    . "<td style='text-align: center'><a>" . $subtotal . "</a></td>"
                                                    . "<td style='text-align: center'><a>" . $row["delivery_fees"] . "</a></td>"
                                                    . "<td style='text-align: center'><a>" . $row["net_amount"] . "</a></td>"
                                                    . "<td style='text-align: center'><a>" . $row["delivery_status"] . "</a></td>"
                                                    . "<td style='text-align: center'><a>" . $row["order_status"] . "</a></td>"
                                                    . "</tr>";
                                                }
                                            }
                                        } else if ($type == "top_product") {
                                            $result = $conn->query($sql);
                                            if ($result->num_rows > 0) {
                                                $totalqty = 0;
                                                $totalamount = 0;
                                                while ($row = $result->fetch_assoc()) {
                                                    $totalqty += $row["TotalQty"];
                                                    $totalamount += $row["totalprice"];
                                                    echo "<tr>"
                                                    . "<td style='text-align: center'><a>" . $row["productid"] . "</a></td>"
                                                    . "<td style='text-align: center'><a>" . $row["TotalQty"] . "</a></td>"
                                                    . "<td style='text-align: center'><a>" . $row["totalprice"] . "</a></td>"
                                                    . "</tr>";
                                                }
                                            }
                                        } else if ($type == "top_customer") {
                                            $result = $conn->query($sql);
                                            if ($result->num_rows > 0) {
                                                $totalqty = 0;
                                                $totalamount = 0;
                                                while ($row = $result->fetch_assoc()) {
                                                    $totalqty += $row["orderqty"];
                                                    $totalamount += $row["revenue"];
                                                    echo "<tr>"
                                                    . "<td style='text-align: center'><a>" . $row["id"] . "</a></td>"
                                                    . "<td style='text-align: center'><a>" . $row["orderqty"] . "</a></td>"
                                                    . "<td style='text-align: center'><a>" . $row["revenue"] . "</a></td>"
                                                    . "</tr>";
                                                }
                                            }
                                        }else if ($type == "admin_list") {
                                            $result = $dbc->query($sql);
                                            if ($result->num_rows > 0) {
                                              
                                                while ($row = $result->fetch_assoc()) {
                                                  
                                                   
                                                    echo " <tr>"
                                            
                                                    . "<td style='text-align: center'><a>" . $row["adminid"] . "</a></td>"
                                                    . "<td style='text-align: center'><a>" . $row["password"] . "</a></td>"
                                                    . "<td style='text-align: center'><a>" . $row["phone"] . "</a></td>"
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
                                        if ($type == "sales") {
                                            echo '<tr><th style="width: 20%;text-align: center">' . $result->num_rows . '</th>
                                        <th style="width: 10%;text-align: center">
                                            
                                        </th>
                                        <th style="width: 10%;text-align: center">
                                            ' . $total . '
                                        </th>
                                        <th style="width: 10%;text-align: center">
                                            ' . $tax . '
                                        </th>
                                        <th style="width: 10%;text-align: center">
                                            ' . $subtotal_total . '
                                        </th>
                                        <th style="width: 10%;text-align: center">
                                            ' . $deliver_fees . '
                                        </th>
                                        <th style="width: 10%;text-align: center">
                                            ' . $net_amount . '
                                        </th>
                                        <th style="width: 10%;text-align: center">
                                            
                                        </th>
                                        <th style="width: 10%;text-align: center">
                                            
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
                                            echo '<tr><th style="width: 33%;text-align: center">' . $result->num_rows . '</th>

                                        <th style="width: 33%;text-align: center">
                                            ' . $totalqty . '
                                        </th>
                                        <th style="width: 33%;text-align: center">
                                            ' . $totalamount . '
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
        if (document.getElementById("type").value === "sales") {
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
        if (value === "sales") {
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
