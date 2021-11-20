<?php
include '../include/header.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM trade t, trade_details s WHERE t.tradeid = s.tradeid AND t.tradeid = '$id' LIMIT 1";
    $result = $dbc->query($sql);
    if ($result->num_rows > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $current_data = $row;
            $title = "Trade Details - {$current_data['tradeid']}";
            echo '<script>var current_data = ' . json_encode($current_data) . ';</script>';
            break;
        }
    } else {
        echo '<script>alert("Extract data fail !\nContact IT department for maintainence");window.location.href = "../user/trade_list.php";</script>';
    }
}
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="../bootstrap/plugins/select2/css/select2.min.css">
        <link rel="stylesheet" href="../bootstrap/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
        <title>
            <?php
            $sql = "SELECT * FROM trade t, customer c WHERE t.acceptCustID = c.custid AND tradeid = '" . $current_data['tradeid'] . "'";
            $result = $dbc->query($sql);
            if ($result->num_rows > 0) {
                while ($row = mysqli_fetch_array($result)) {
                    $current_offer = $row;
                    break;
                }
            }
            echo $current_offer['username'];
            ?>
            - Trade Offer - Tradee
        </title>
    </head>
    <body>
        <div class="bg-navbar mb-2 bg-light">
            <div class="container-lg">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb py-2 mb-0">
                        <li class="breadcrumb-item"><a href="#">Trade List</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Trade offer</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="container-lg">
            <div class="row">
                <div class="col-lg-3 col-sm-6 col-12 align-content-center">
                    <li class="list-inline-item me-0 trade-desc">You are trading with:
                        <?php
                        $sql = "SELECT * FROM trade t, customer c WHERE t.acceptCustID = c.custid AND tradeid = '" . $current_data['tradeid'] . "'";
                        $result = $dbc->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = mysqli_fetch_array($result)) {
                                $current_offer = $row;
                                $traderid = $current_offer['custid'];
                                echo $current_offer['username'];
                                break;
                            }
                        }
                        ?>
                    </li>
                </div>

                <div class="col-lg-3 col-sm-6 col-12 align-content-center">
                    <li class="list-inline-item me-0 trade-desc">Location:
                        <?php
                        $sql = "SELECT * FROM trade t, customer c WHERE t.acceptCustID = c.custid AND tradeid = '" . $current_data['tradeid'] . "'";
                        $result = $dbc->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = mysqli_fetch_array($result)) {
                                $current_offer = $row;
                                echo "{$current_offer['state']}, {$current_offer['country']}";
                                break;
                            }
                        }
                        ?>
                    </li>
                </div>

                <div class="col-lg-2 col-sm-6 col-12 align-content-center">
                    <li class="list-inline-item me-0 trade-desc">Joined: 
                        <?php
                        $sql = "SELECT * FROM trade t, customer c WHERE t.acceptCustID = c.custid AND tradeid = '" . $current_data['tradeid'] . "'";
                        $result = $dbc->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = mysqli_fetch_array($result)) {
                                $current_offer = $row;
                                echo $current_offer['registration_date'];
                                break;
                            }
                        }
                        ?>
                    </li>
                </div>

                <div class="col-lg-2 col-sm-6 col-12 align-content-center">
                    <li class="list-inline-item me-0 trade-desc">Trade count:
                        <?php
                        $sql = "SELECT COUNT(t.tradeid) NUMBER FROM trade t, customer c WHERE c.custid = '$traderid' AND (t.acceptCustID = '$traderid' OR t.offerCustID = '$traderid') AND t.tradeid <> '" . $current_data['tradeid'] . "' AND (t.status = 'Rejected' OR t.status = 'Completed')";
                        $result = $dbc->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = mysqli_fetch_array($result)) {
                                $current_offer = $row;
                                echo $current_offer['NUMBER'];
                                break;
                            }
                        }
                        ?>
                    </li>
                </div>

                <div class="col-lg-2 col-sm-6 col-12 align-content-center">
                    <li class="list-inline-item me-0 trade-desc">Last trade:
                        <?php
                        $sql = "SELECT MAX(t.tradeDate) DATE FROM trade t, customer c WHERE t.acceptCustID = c.custid AND tradeid = '" . $current_data['tradeid'] . "'";
                        $result = $dbc->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = mysqli_fetch_array($result)) {
                                $current_offer = $row;
                                echo $current_offer['DATE'];
                                break;
                            }
                        }
                        ?>
                    </li>
                </div>
            </div>
        </div>

        <div class="container-lg py-3">
            <form id="form" method="post">
                <div class="row">
                    <div class="col-md-6">
                        <div class="border px-3 py-2">
                            <div class="row pb-2">
                                <img src="<?php
                                $sql = "SELECT avatar FROM customer WHERE custid = '{$current_data['offerCustID']}'";
                                $result = $dbc->query($sql);
                                if ($result->num_rows > 0) {
                                    while ($row = mysqli_fetch_array($result)) {
                                        echo $row[0];
                                    }
                                }
                                ?>" class="img-fluid profile-pic float-start rounded-pill m-1" alt="Profile picture">

                                <div class="align-content-center ml-2 mt-2">
                                    <li class="" style="list-style-type:none;">Yours items:</li>
                                    <li class="" style="list-style-type:none; font-size:0.82em;">These are the items you will lose in the trade.</li>
                                </div>
                            </div>

                            <div class="form-group">
                                <select class="select2bs4" name="my_item[]" id="my_item" multiple="multiple" data-placeholder="Select your item" style="width: 100%;" disabled>
                                    <?php
                                    $get_item = "SELECT * FROM item i, trade_details d WHERE i.itemid = d.itemid AND d.tradeid = '{$current_data['tradeid']}' AND d.custid = '{$_SESSION['loginuser']['custid']}'";
                                    $result_item = $dbc->query($get_item);
                                    if ($result_item->num_rows > 0) {
                                        while ($row = mysqli_fetch_array($result_item)) {
                                            echo '<option ' . $selected . ' selected="selected" value="' . $row['itemid'] . '">' . $row['itemname'] . '</option>';
                                        }
                                    }

                                    $get_item_available = "SELECT * FROM item i WHERE i.custid = '{$_SESSION['loginuser']['custid']}' AND i.itemActive = 'Available' AND NOT EXISTS (SELECT * FROM trade_details d WHERE i.itemid = d.itemid AND d.tradeid = '{$current_data['tradeid']}')";
                                    $result_item_available = $dbc->query($get_item_available);
                                    if ($result_item_available->num_rows > 0) {
                                        while ($row = mysqli_fetch_array($result_item_available)) {
                                            echo '<option value="' . $row['itemid'] . '">' . $row['itemname'] . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="row row-cols-xl-2 row-cols-lg-2 row-cols-md-1 row-cols-sm-2 row-cols-1">
                                <?php
                                $get_inventory = "SELECT * FROM trade_details d, item i WHERE d.itemid = i.itemid AND d.custid = '{$current_data['offerCustID']}' AND d.tradeid = '{$current_data['tradeid']}'";
                                $result = $dbc->query($get_inventory);
                                if ($result->num_rows > 0) {
                                    while ($row = mysqli_fetch_array($result)) {
                                        echo "<div class='col px-1 py-2'>"
                                        . "<div class='item-img-box overflow-hidden'>"
                                        . "<a href='../user/item_profile.php?id=" . $row["itemid"] . "' target='_blank'>"
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
                            <div class="row pb-2">
                                <img src="<?php
                                $sql = "SELECT avatar FROM customer WHERE custid = '{$current_data['acceptCustID']}'";
                                $result = $dbc->query($sql);
                                if ($result->num_rows > 0) {
                                    while ($row = mysqli_fetch_array($result)) {
                                        echo $row[0];
                                    }
                                }
                                ?>" class="img-fluid profile-pic float-start rounded-pill m-1" alt="Profile picture">
                                <div class="align-content-center ml-2 mt-2">
                                    <li class="" style="list-style-type:none;">His items:</li>
                                    <li class="" style="list-style-type:none; font-size:0.82em;">These are the items you will receive in the trade.</li>
                                </div>
                            </div>

                            <div class="form-group">
                                <select class="select2bs4" name="his_item[]" id="his_item" multiple="multiple" data-placeholder="Select his/her item" style="width: 100%;" disabled>
                                    <?php
                                    $get_item = "SELECT * FROM trade t, item i, trade_details d WHERE i.itemid = d.itemid AND t.acceptCustID = d.custid AND t.tradeid = d.tradeid AND d.tradeid = '{$current_data['tradeid']}'";
                                    $result_item = $dbc->query($get_item);
                                    if ($result_item->num_rows > 0) {
                                        while ($row = mysqli_fetch_array($result_item)) {
                                            echo '<option ' . $selected . ' selected="selected" value="' . $row['itemid'] . '">' . $row['itemname'] . '</option>';
                                        }
                                    }

                                    $get_item_available = "SELECT * FROM item i, trade t WHERE i.custid = t.offerCustID AND i.itemActive = 'Available' AND t.tradeid = '{$current_data['tradeid']}' AND NOT EXISTS (SELECT * FROM trade_details d WHERE t.offerCustID = d.custid AND i.itemid = d.itemid AND d.tradeid = '{$current_data['tradeid']}')";
                                    $result_item_available = $dbc->query($get_item_available);
                                    if ($result_item_available->num_rows > 0) {
                                        while ($row = mysqli_fetch_array($result_item_available)) {
                                            echo '<option value="' . $row['itemid'] . '">' . $row['itemname'] . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="row row-cols-xl-2 row-cols-lg-2 row-cols-md-1 row-cols-sm-2 row-cols-1">
                                <?php
                                $get_inventory = "SELECT * FROM trade_details d, item i  WHERE d.itemid = i.itemid AND d.custid = '{$current_data['acceptCustID']}' AND d.tradeid = '{$current_data['tradeid']}'";
                                $result = $dbc->query($get_inventory);
                                if ($result->num_rows > 0) {
                                    while ($row = mysqli_fetch_array($result)) {
                                        echo "<div class='col px-1 py-2'>"
                                        . "<div class='item-img-box overflow-hidden'>"
                                        . "<a href='../user/item_profile.php?id=" . $row["itemid"] . "' target='_blank'>"
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

                    <div class="col-auto py-2 float-right mt-1 mb-5">
                        <button type='button' class='btn btn-dark' id='btnback' onclick='back()'>Back</button>
                    </div>
                </div>
            </form>
        </div>
        <?php include '../include/footer.php'; ?>
    </body>
    <script>
        function changeRequest() {
            if (document.getElementById("btnchange").textContent === "Save") {
                var fullfill = true;

                if (fullfill) {
                    if (confirm("Confirm to save ?")) {
                        isset($_POST['change']);
                    }
                }
            } else {
                editable();
            }
        }

        function editable() {
            document.getElementById("btnchange").textContent = "Save";
            document.getElementById("my_item").disabled = false;
            document.getElementById("his_item").disabled = false;
        }

        $(function () {
            //Initialize Select2 Elements
            $('.select2').select2()

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        })

        function back() {
            window.location.href = "trade_list.php";
        }
    </script>
    <script src="../bootstrap/plugins/select2/js/select2.full.min.js"></script>
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

        /*        .item-pic{
                    width: 100px;
                    height: 100px;
                    object-fit: cover;
                }
        
                .item-img-box{
                    width: 192px;
                    height: 192px;
                    background: #e8e8e8;
                    max-width: 255px;
                    max-height: 370px;
                    background: whitesmoke;
                    text-align: center;
                    background-size: cover;
                    object-fit: cover;
                }
        
                .item-img{
                    max-height: 300px;
                    height: 100%;
                    text-align: center;
                    background-size: contain;
                    background-repeat:   no-repeat;
                    background: whitesmoke;
                }*/

        .profile-pic{
            width: 55px;
            height: 55px;
            object-fit: cover;
        }

        .trade-desc{
            font-size: 0.9em;
        }
    </style>
</html>