<?php
$page = 'event_list';
include 'navbar.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM donation_delivery d, donation_details t WHERE d.donationid = t.donationid AND d.donationid = '$id' LIMIT 1";
    $result = $dbc->query($sql);
    if ($result->num_rows > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $current_data = $row;
            $title = "Donation Details - {$current_data['tradeid']}";
            echo '<script>var current_data = ' . json_encode($current_data) . ';</script>';
            break;
        }
    } else {
        echo '<script>alert("Extract data fail !\nContact IT department for maintainence");window.location.href = "trade_list.php";</script>';
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_GET['id'])) {
        $sql = "UPDATE trade SET "
                . "status='" . $_POST['status'] . "' "
                . "WHERE tradeid ='" . $current_data['tradeid'] . "'";

        echo '<script>alert("' . $sql . '");</script>';
        if ($dbc->query($sql)) {
            echo '<script>alert("Trade details updated successfully.");var currentURL = window.location.href;window.location.href = currentURL;</script>';
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
        <title>Trade <?php echo $current_data['tradeid'] ?> - Tradee</title>
    </head>
    <body class="hold-transition sidebar-mini layout-fixed">
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
                    <form method="post" id="form">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h3 style="font-weight: bolder;" class="card-title" id="titleid">Trade ID: <?php echo $current_data['tradeid'] ?></h3>
                                    </div>
                                    <div class="card-body pt-2">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="row pt-2">
                                                    <div class="col-auto">
                                                        <div class="form-group row">
                                                            <label for="date" class="col-sm-auto col-form-label">Trade Date:</label>
                                                            <div class="col-sm-auto">
                                                                <input type="text" class="form-control" id="date" name="date" readonly value="<?php
                                                                if (isset($current_data)) {
                                                                    echo $current_data["tradeDate"];
                                                                }
                                                                ?>">
                                                                <div class="invalid-feedback">
                                                                    Please provide a valid address.
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-auto">
                                                        <div class="form-group row">
                                                            <label for="status" class="col-sm-auto col-form-label">Trade Status:</label>
                                                            <div class="col-sm-auto">
                                                                <select class="custom-select" id="status" name="status" disabled>
                                                                    <option value="Rejected" <?php
                                                                    if (isset($current_data)) {
                                                                        if ($current_data["status"] == "Rejected") {
                                                                            echo "selected";
                                                                        }
                                                                    }
                                                                    ?>>Rejected</option>
                                                                    <option value="Completed" <?php
                                                                    if (isset($current_data)) {
                                                                        if ($current_data["status"] == "Completed") {
                                                                            echo "selected";
                                                                        }
                                                                    }
                                                                    ?>>Completed</option>
                                                                    <option value="Pending" <?php
                                                                    if (isset($current_data)) {
                                                                        if ($current_data["status"] == "Pending") {
                                                                            echo "selected";
                                                                        }
                                                                    }
                                                                    ?>>Pending</option>
                                                                    <option value="To-Pay" <?php
                                                                    if (isset($current_data)) {
                                                                        if ($current_data["status"] == "To-Pay") {
                                                                            echo "selected";
                                                                        }
                                                                    }
                                                                    ?>>To-Pay</option>
                                                                    <option value="To-Ship" <?php
                                                                    if (isset($current_data)) {
                                                                        if ($current_data["status"] == "To-Ship") {
                                                                            echo "selected";
                                                                        }
                                                                    }
                                                                    ?>>To-Ship</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="border px-3 py-2">
                                                    <div class="row pb-1 border-bottom">
                                                        <img src="<?php
                                                        $sql = "SELECT avatar FROM customer WHERE custid = '{$current_data['offerCustID']}'";
                                                        $result = $dbc->query($sql);
                                                        if ($result->num_rows > 0) {
                                                            while ($row = mysqli_fetch_array($result)) {
                                                                echo $row[0];
                                                            }
                                                        }
                                                        ?>" class="img-fluid profile-pic float-start rounded-pill m-1" style="width: 55px; height: 55px; object-fit: cover;" alt="Profile picture">
                                                        <div class="align-content-center ml-2 mt-2">
                                                            <li class="" style="list-style-type:none; font-size:0.9em;">Offer Customer: <?php echo $current_data['offerCustID'] ?></li>
                                                            <li class="" style="list-style-type:none; font-size:0.9em;">Payment: <?php echo $current_data['offerPayment'] ?></li>
                                                        </div>
                                                    </div>

                                                    <div class="row row-cols-lg-2 row-cols-md-1 row-cols-sm-2 row-cols-1">
                                                        <?php
                                                        $get_inventory = "SELECT * FROM trade_details d, item i WHERE d.itemid = i.itemid AND d.custid = '{$current_data['offerCustID']}' AND d.tradeid = '{$current_data['tradeid']}'";
                                                        $result = $dbc->query($get_inventory);
                                                        if ($result->num_rows > 0) {
                                                            while ($row = mysqli_fetch_array($result)) {
                                                                echo "<div class='col px-1 py-2'>"
                                                                . "<div class='item-img-box overflow-hidden'>"
                                                                . "<a href='item_details.php?id=" . $row["itemid"] . "' target='_blank'>"
                                                                . "<img src='../data/item_img/" . $row['itemid'] . "_0' class='img-fluid item-img' alt='...'>"
                                                                . "</a>"
                                                                . "</div>"
                                                                . "<div class='d-flex bd-highlight align-items-center pt-1 px-1'>"
                                                                . "<div class='flex-grow-1 bd-highlight' style='font-size:0.8em;'>" . $row["itemname"] . "</div>"
                                                                . "<div class='d-flex bd-highlight align-items-center'>"
                                                                . "<i class='far fa-heart me-auto' style='font-size:0.9em; display: none;'></i>"
                                                                . "</div>"
                                                                . "</div>"
                                                                . "<ul class='list-inline px-1 mb-0'>"
                                                                . "<div class='float-right bd-highlight' style='font-size:0.7em; color:#969696;'>" . $row["tradeOption"] . "</div>"
                                                                . "<div class='flex-grow-1 bd-highlight' style='font-size:0.7em; color:#969696;'>" . $row["itemCondition"] . "</div>"
                                                                . "<div class='flex-grow-1 bd-highlight' style='font-size:0.7em; color:#969696;'>" . $row["brand"] . "</div>"
                                                                . "</ul>"
                                                                . "</div>";
                                                            }
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="border px-3 py-2">
                                                    <div class="row pb-1 border-bottom">
                                                        <img src="<?php
                                                        $sql = "SELECT avatar FROM customer WHERE custid = '{$current_data['acceptCustID']}'";
                                                        $result = $dbc->query($sql);
                                                        if ($result->num_rows > 0) {
                                                            while ($row = mysqli_fetch_array($result)) {
                                                                echo $row[0];
                                                            }
                                                        }
                                                        ?>" class="img-fluid profile-pic float-start rounded-pill m-1" style="width: 55px; height: 55px; object-fit: cover;" alt="Profile picture">
                                                        <div class="align-content-center ml-2 mt-2">
                                                            <li class="" style="list-style-type:none; font-size:0.9em;">Accept Customer: <?php echo $current_data['acceptCustID'] ?></li>
                                                            <li class="" style="list-style-type:none; font-size:0.9em;">Payment: <?php echo $current_data['acceptPayment'] ?></li>
                                                        </div>
                                                    </div>

                                                    <div class="row row-cols-lg-2 row-cols-md-1 row-cols-sm-2 row-cols-1">
                                                        <?php
                                                        $get_inventory = "SELECT * FROM trade_details d, item i  WHERE d.itemid = i.itemid AND d.custid = '{$current_data['acceptCustID']}' AND d.tradeid = '{$current_data['tradeid']}'";
                                                        $result = $dbc->query($get_inventory);
                                                        if ($result->num_rows > 0) {
                                                            while ($row = mysqli_fetch_array($result)) {
                                                                echo "<div class='col px-1 py-2'>"
                                                                . "<div class='item-img-box overflow-hidden'>"
                                                                . "<a href='item_details.php?id=" . $row["itemid"] . "' target='_blank'>"
                                                                . "<img src='../data/item_img/" . $row['itemid'] . "_0' class='img-fluid item-img' alt='...'>"
                                                                . "</a>"
                                                                . "</div>"
                                                                . "<div class='d-flex bd-highlight align-items-center pt-1 px-1'>"
                                                                . "<div class='flex-grow-1 bd-highlight' style='font-size:0.8em;'>" . $row["itemname"] . "</div>"
                                                                . "<div class='d-flex bd-highlight align-items-center'>"
                                                                . "<i class='far fa-heart me-auto' style='font-size:0.9em; display: none;'></i>"
                                                                . "</div>"
                                                                . "</div>"
                                                                . "<ul class='list-inline px-1 mb-0'>"
                                                                . "<div class='float-right bd-highlight' style='font-size:0.7em; color:#969696;'>" . $row["tradeOption"] . "</div>"
                                                                . "<div class='flex-grow-1 bd-highlight' style='font-size:0.7em; color:#969696;'>" . $row["itemCondition"] . "</div>"
                                                                . "<div class='flex-grow-1 bd-highlight' style='font-size:0.7em; color:#969696;'>" . $row["brand"] . "</div>"
                                                                . "</ul>"
                                                                . "</div>";
                                                            }
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
                                                <button class="btn btn-warning" style="width:100%" id="btncancel" onclick="cancel()" disabled>Cancel</button>
                                            </div>
                                        </div>

                                        <div class="col-md-1">
                                            <div class="form-group">
                                                <button class="btn btn-primary" style="width:100%" id="btnsave" onclick="editorsave()">Edit</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </section>
            </div>
        </div>
        <?php include 'footer.php'; ?>
    </body>
    <script>
        var currentURL = window.location.href;

        function back() {
            window.location.href = "trade_list.php";
        }

        function editable() {
            document.getElementById("btncancel").disabled = false;
            document.getElementById("btnsave").textContent = "Save";
            document.getElementById("status").disabled = false;
        }

        function editorsave() {
            var btnoption = document.getElementById("btnsave").textContent;
            if (btnoption === "Save") {
                var fullfill = true;
                document.getElementById("status").style.borderColor = "";

                if (!document.getElementById("status").value || document.getElementById("status").value === "") {
                    document.getElementById("status").style.borderColor = "red";
                    fullfill = false;
                }

                if (fullfill) {
                    if (confirm("Confirm to save?")) {
                        document.getElementById("form").submit();
                    }
                }
            } else {
                editable();
            }
        }

        function cancel() {
            if (confirm("Confirm to unsave current information?")) {
                window.location.href = currentURL;
            }
        }
    </script>
    <style>
        /*item*/
        .item-img-box{
            /*width: 192px;*/
            /*height: 192px;*/
            /*background: #e8e8e8;*/
            /*max-width: 255px;*/
            max-height: 250px;
            background: whitesmoke;
            text-align: center;
            background-size: cover;
            object-fit: cover;
        }

        .item-img{
            min-height: 250px;
            max-height: 250px;
            text-align: center;
            background-size: contain;
            background-repeat: no-repeat;
            background: whitesmoke;
        }
    </style>
</html>