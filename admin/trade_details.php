<?php
include 'navbar.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM trade t, trade_details d WHERE  t.tradeid = d.tradeid AND t.tradeid = '$id' LIMIT 1";
    $result = $dbc->query($sql);
    if ($result->num_rows > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $current_data = $row;
            $title = "Trading Details - {$current_data['tradeid']}";
            echo '<script>var current_data = ' . json_encode($current_data) . ';</script>';
            break;
        }
    } else {
        echo '<script>alert("Extract data fail !\nContact IT department for maintainence");window.location.href = "trade_list.php";</script>';
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_GET['id'])) {

        $sql = "UPDATE trade_details SET "
                . "id='" . $_POST['id'] . "',"
                . "tradeid='" . $_POST['tradeid'] . "',"
                . "custid='" . $_POST['custid'] . "',"
                . "itemid='" . $_POST['itemid'] . "',"
                . "WHERE id ='" . $current_data['id'] . "'";

        if ($dbc->query($sql)) {
            echo '<script>alert("Successfuly update !");var currentURL = window.location.href;window.location.href = currentURL;</script>';
        } else {
            echo '<script>alert("Update fail !\nContact IT department for maintainence")</script>';
        }
    }
}
?>


<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Trading details - Tradee</title>
    </head>
    <body class="hold-transition sidebar-mini layout-fixed" onload="addnew()">
        <div class="wrapper">
            <div class="content-wrapper">
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="trade_list.php">Trading list</a></li>
                                    <li class="breadcrumb-item active">Trading details</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

                <section class="content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title" id="titleid">ID</h3>
                                </div>

                                <div class="card-body">
                                    <form method="post" id="form" enctype="multipart/form-data">
                                        <div class="row">
<!--                                            <div class="col-md-3">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="col-md-12">
                                                            <img class="img-fluid mb-12" src="<?php
                                                            if (isset($current_data)) {
                                                                echo $current_data["file"];
                                                            }
                                                            ?>" alt="Photo" style="width: 100%;height:500px;padding-top: 10px" id="img_display" name="img_display">
                                                        </div>
                                                        <div class="col-md-12" >
                                                            <div class="form-group" style="padding-top: 15px">
                                                                <div class="custom-file">
                                                                    <input type="file" accept="image/*" onchange="loadFile(event)" class="custom-file-input" id="img" disabled name="img">
                                                                    <label class="custom-file-label" id="validate_img">Choose file</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>-->

                                            <div class="col-md-12">
                                                <div class="row">
                                                    
                                                    <div class="col-md-6">
                                                        <label>Trade ID :</label>
                                                        <div class="form-group">                                             
                                                            <input class="form-control" id="tradeid" name="tradetid" readOnly value="<?php
                                                            if (isset($current_data)) {
                                                                echo $current_data["tradetid"];
                                                            }
                                                            ?>">
                                                        </div>
                                                    </div>
                                                    
                                                     <div class="col-md-6">
                                                        <label>Customer ID :</label>
                                                        <div class="form-group">                                             
                                                            <input class="form-control" id="custid" name="custid" readOnly value="<?php
                                                            if (isset($current_data)) {
                                                                echo $current_data["custid"];
                                                            }
                                                            ?>">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label>Offered Customer ID:</label>
                                                        <div class="form-group">                                             
                                                            <input class="form-control" id="offerCustID" name="offerCustID" readOnly value="<?php
                                                            if (isset($current_data)) {
                                                                echo $current_data["offerCustID"];
                                                            }
                                                            ?>">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label>Accepted Customer ID:</label>
                                                        <div class="form-group">                                             
                                                            <input class="form-control" id="acceptCustID" name="acceptCustID" readOnly value="<?php
                                                            if (isset($current_data)) {
                                                                echo $current_data["acceptCustID"];
                                                            }
                                                            ?>">
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-4">
                                                        <label>Date :</label>
                                                        <div class="form-group">                                             
                                                            <input class="form-control" id="date" name="date" readOnly value="<?php
                                                            if (isset($current_data)) {
                                                                echo $current_data["date"];
                                                            }
                                                            ?>">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label>Item ID :</label>
                                                        <div class="form-group">                                             
                                                            <input class="form-control" id="itemid" name="itemid" readOnly value="<?php
                                                            if (isset($current_data)) {
                                                                echo $current_data["itemid"];
                                                            }
                                                            ?>">
                                                        </div>
                                                    </div>

                                                    
                                                        <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Delivery status:</label>
                                                            <select class="custom-select" id="status" name="status" disabled>
                                                                <option <?php
                                                                if (isset($current_data)) {
                                                                    if ($current_data["status"] === "Accepted") {
                                                                        echo "selected";
                                                                    }
                                                                }
                                                                ?> value="Accepted">Accepted</option>
                                                                <option <?php
                                                                if (isset($current_data)) {
                                                                    if ($current_data["status"] === "Rejected") {
                                                                        echo "selected";
                                                                    }
                                                                }
                                                                ?> value="Rejected">Rejected</option>
                                                           
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                      
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <button type="button" class="btn btn-dark" style="width:100%" id="btnback" onclick="back()">Back</button>
                                        </div>
                                    </div>

                                    <div class="col-md-9"></div>

                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <button type="button" class="btn btn-warning" style="width:100%" id="btncancel" onclick="cancel()" disabled>Cancel</button>
                                        </div>
                                    </div>

                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <button type="button" class="btn btn-primary" style="width:100%" id="btnsave" onclick="editorsave()">Edit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <?php include 'footer.php'; ?>
    </body>
       <script>
        var currentURL = window.location.href;
        var isnew = false;

        function back() {
            var btnoption = document.getElementById("btnsave").textContent;
            if (btnoption === "Save") {
                if (confirm("Confirm to unsave ?")) {
                    window.location.href = "trade_list.php";
                }
            } else {
                window.location.href = "trade_list.php";
            }
        }

        function editable() {
            document.getElementById("btncancel").disabled = false;
            document.getElementById("btnsave").textContent = "Save";
            document.getElementById("itemid").readOnly = false;
            document.getElementById("custid").readOnly = false;
            document.getElementById("status").disabled = false;
            document.getElementById("offerCustID").readOnly = false;
            document.getElementById("acceptCustID").readOnly = false;
            document.getElementById("tradeid").readOnly = false;
            document.getElementById("date").disabled = false;
  
        }

        function editorsave() {
            var btnoption = document.getElementById("btnsave").textContent;
            if (btnoption === "Save") {
                var fullfill = true;
                document.getElementById("custid").style.borderColor = "";
                document.getElementById("tradeid").style.borderColor = "";
                document.getElementById("status").style.borderColor = "";
                document.getElementById("offerCustID").style.borderColor = "";
                document.getElementById("acceptCustID").style.borderColor = "";
                document.getElementById("acceptCustID").style.borderColor = "";
                document.getElementById("tradeid").style.borderColor = "";
                document.getElementById("date").style.borderColor = "";

                if (!document.getElementById("itemid").value || document.getElementById("itemid").value === "") {
                    document.getElementById("itemid").style.borderColor = "red";
                    fullfill = false;
                }
                  if (!document.getElementById("custid").value || document.getElementById("custid").value === "") {
                    document.getElementById("custid").style.borderColor = "red";
                    fullfill = false;
                }
                  if (!document.getElementById("tradeid").value || document.getElementById("tradeid").value === "") {
                    document.getElementById("tradeid").style.borderColor = "red";
                    fullfill = false;
                }
                  if (!document.getElementById("status").value || document.getElementById("status").value === "") {
                    document.getElementById("status").style.borderColor = "red";
                    fullfill = false;
                }
                  if (!document.getElementById("offerCustID").value || document.getElementById("offerCustID").value === "") {
                    document.getElementById("offerCustID").style.borderColor = "red";
                    fullfill = false;
                }
                  if (!document.getElementById("acceptCustID").value || document.getElementById("acceptCustID").value === "") {
                    document.getElementById("acceptCustID").style.borderColor = "red";
                    fullfill = false;
                }
                

                if (fullfill) {
                    if (confirm("Confirm to save ?")) {
                        document.getElementById("form").submit();
                    }
                }
            } else {
                editable();
            }
        }

        function cancel() {
            if (confirm("Confirm to unsave current information!")) {
                if (isnew) {
                    window.location.href = "trade_list.php";
                } else {
                    window.location.href = currentURL;
                }
            }
        }

        function isNumberKey(evt) {
            var charCode = (evt.which) ? evt.which : event.keyCode;
            if (charCode > 31 && (charCode !== 46 && (charCode < 48 || charCode > 57)))
                return false;
            if (charCode === 46 && charCode === ".")
                return false;
            if (charCode === ".")
            {
                var number = [];
                number = charCode.split(".");
                if (number[1].length === decimalPts)
                    return false;
            }
            return true;
        }

        var loadFile = function (event) {
            var image = document.getElementById('img_display');
            image.src = URL.createObjectURL(event.target.files[0]);
        };
    </script>
</html>