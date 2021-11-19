<?php
include '../include/header.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM trade WHERE tradeid = '$id' LIMIT 1";
    $result = $dbc->query($sql);
    if ($result->num_rows > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $current_data = $row;
            $title = "Trade Details - {$current_data['tradeid']}";
            echo '<script>var current_data = ' . json_encode($current_data) . ';</script>';
            break;
        }
    } else {
        echo '<script>alert("Extract data fail !\nContact IT department for maintainence");window.location.href = "../php/index.php";</script>';
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_GET['id'])) {
        if ($_POST["type"] === "Accept") {
            $sql_pending = "UPDATE trade_details t, item i SET i.itemActive='Trading' WHERE t.itemid = i.itemid AND tradeid ='" . $current_data['tradeid'] . "'";
            if ($dbc->query($sql_pending)) {
                $sql_delivery = "SELECT * FROM trade_details t, item i WHERE t.itemid = i.itemid AND t.tradeid ='" . $current_data['tradeid'] . "' AND i.tradeOption = 'On-Delivery'";
                $result = $dbc->query($sql_delivery);
                if ($result->num_rows > 0) {
                    $sql_delivery = "UPDATE trade SET status = 'To Pay' WHERE tradeid ='" . $current_data['tradeid'] . "'";
                    if ($dbc->query($sql_delivery)) {
                        echo "<script>alert('Proceed to delivery to complete the trading.');window.location.href='accept_delivery_shipping.php?id=" . $current_data['tradeid'] . "' ;</script>";
                    }
                } else {
                    $sql1 = "SELECT * FROM customer WHERE custid = '{$current_data['offerCustID']}'";
                    $result1 = $dbc->query($sql1);
//                    echo '<script>alert("' . $sql1 . '");</script>';
                    if ($result1->num_rows > 0) {
                        while ($row1 = mysqli_fetch_array($result1)) {
                            $sql2 = "SELECT * FROM customer WHERE custid = '{$_SESSION['loginuser']['custid']}' AND (country <> '{$row1['country']}' OR state <> '{$row1['state']}')";
                            $result2 = $dbc->query($sql2);
//                            echo '<script>alert("' . $sql2 . '");</script>';
                            if ($result2->num_rows > 0) {
                                $sql_delivery = "UPDATE trade SET status = 'To Pay' WHERE tradeid ='" . $current_data['tradeid'] . "'";
                                if ($dbc->query($sql_delivery)) {
                                    echo "<script>alert('Proceed to delivery to complete the trading.');window.location.href='accept_delivery_shipping.php?id=" . $current_data['tradeid'] . "' ;</script>";
                                }
                            } else {
                                $sql_ontrade = "UPDATE trade SET acceptPayment = 'On-Trade', offerPayment = 'On-Trade' WHERE tradeid ='" . $current_data['tradeid'] . "'";
                                $sql_trading = "UPDATE trade SET status = 'Trading' WHERE tradeid ='" . $current_data['tradeid'] . "'";
                                if (($dbc->query($sql_ontrade)) AND ($dbc->query($sql_trading))) {
                                    echo '<script>alert("Trade confirmed and has been sent to the other trader.");window.location.href="../user/trade_list.php";</script>';
                                }
                            }
                        }
                    }
                }
            } else {
                echo '<script>alert("Update fail!\nContact IT department for maintainence");window.location.href = "../php/index.php";</script>';
            }
        } else if ($_POST["type"] === "Reject") {
            $sql = "SELECT * FROM trade_details WHERE tradeid = '" . $current_data['tradeid'] . "'";
            $result = $dbc->query($sql);
            if ($result->num_rows > 0) {
                while ($row = mysqli_fetch_array($result)) {
                    $sql1 = "UPDATE item SET itemActive = 'Available' WHERE itemid = '" . $row['itemid'] . "'";
                    ($dbc->query($sql1));
                }
            }

            $sql_rejected = "UPDATE trade SET acceptPayment = 'Failed', offerPayment = 'Failed', status = 'Rejected' WHERE tradeid ='" . $current_data['tradeid'] . "'";
//            echo '<script>alert("' . $sql_rejected . '");</script>';
            if ($dbc->query($sql_rejected)) {
                echo '<script>alert("Trade rejected successfully.\nRejection notification also will be sent to the other trader.");window.location.href = "../user/trade_list.php";</script>';
            } else {
                echo '<script>alert("Update fail!\nContact IT department for maintainence");window.location.href = "../php/index.php";</script>';
            }
        } else if ($_POST["type"] === "Complete") {
            $sql = "UPDATE trade SET status = 'Completed' WHERE tradeid ='" . $current_data['tradeid'] . "'";
//            echo '<script>alert("' . $sql . '");</script>';
            if ($dbc->query($sql)) {
                $sql = "SELECT * FROM trade_details WHERE tradeid = '" . $current_data['tradeid'] . "' AND custid = '" . $current_data['offerCustID'] . "'";
                $result = $dbc->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = mysqli_fetch_array($result)) {
                        $sql1 = "UPDATE item SET custid = '" . $current_data['acceptCustID'] . "', itemActive = 'Available' WHERE itemid = '" . $row['itemid'] . "'";
                        ($dbc->query($sql1));
//                        echo '<script>alert("' . $sql1 . '");</script>';
                    }
                }

                $sql = "SELECT * FROM trade_details WHERE tradeid = '" . $current_data['tradeid'] . "' AND custid = '" . $current_data['acceptCustID'] . "'";
                $result = $dbc->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = mysqli_fetch_array($result)) {
                        $sql2 = "UPDATE item SET custid = '" . $current_data['offerCustID'] . "', itemActive = 'Available' WHERE itemid = '" . $row['itemid'] . "'";
                        ($dbc->query($sql2));
//                    echo '<script>alert("' . $sql2 . '");</script>';
                    }
                }
            }
            echo '<script>alert("Congratulations!\nYou have successfully completed your trading.");window.location.href = "../user/trade_list.php";</script>';
        } else {
            $my_items = $_POST['my_item'];
            $his_items = $_POST['his_item'];

            $sql = "SELECT * FROM trade_details WHERE tradeid = '" . $current_data['tradeid'] . "'";
            $result = $dbc->query($sql);
            if ($result->num_rows > 0) {
                while ($row = mysqli_fetch_array($result)) {
                    $my_item_available = "UPDATE item SET itemActive = 'Available' WHERE custid = '" . $_SESSION['loginuser']['custid'] . "' AND itemid = '" . $row['itemid'] . "'";
                    $dbc->query($my_item_available);

                    $his_item_available = "UPDATE item SET itemActive = 'Available' WHERE custid = '" . $current_data['offerCustID'] . "' AND itemid = '" . $row['itemid'] . "'";
                    $dbc->query($his_item_available);

                    $sql_delete = "DELETE FROM trade_details WHERE tradeid = '" . $row["tradeid"] . "'";
                    ($dbc->query($sql_delete));
                }
//                echo '<script>alert("' . $my_item_available . '");</script>';
//                echo '<script>alert("' . $his_item_available . '");</script>';
//                echo '<script>alert("' . $sql_delete . '");</script>';
            }

            foreach ($my_items as $my_item_list) {
                $sql_mytrade = "INSERT INTO trade_details(tradeid, custid, itemid) VALUES ("
                        . "'" . $current_data["tradeid"] . "',"
                        . "'" . $_SESSION['loginuser']['custid'] . "',"
                        . "'" . $my_item_list . "')";
                $dbc->query($sql_mytrade);
//        echo '<script>alert("' . $sql_mytrade . '");</script>';

                $sql_my_itemActive = "UPDATE item SET "
                        . "itemActive = 'Pending'"
                        . " WHERE custid ='" . $_SESSION['loginuser']['custid'] . "' AND"
                        . " itemid = '" . $my_item_list . "'";
                $dbc->query($sql_my_itemActive);
//        echo '<script>alert("' . $sql_my_itemActive . '");</script>';
            }

            foreach ($his_items as $his_item_list) {
                $sql_histrade = "INSERT INTO trade_details(tradeid, custid, itemid) VALUES ("
                        . "'" . $current_data["tradeid"] . "',"
                        . "'" . $current_data['offerCustID'] . "',"
                        . "'" . $his_item_list . "')";
                $dbc->query($sql_histrade);
//        echo '<script>alert("' . $sql_histrade . '");</script>';
            }

            $change_position = "UPDATE trade SET "
                    . "acceptCustID = '" . $current_data['offerCustID'] . "', "
                    . "offerCustID = '" . $_SESSION['loginuser']['custid'] . "' "
                    . "WHERE tradeid ='" . $current_data['tradeid'] . "'";
//    echo '<script>alert("' . $change_position . '");</script>';

            if ($dbc->query($change_position)) {
                echo '<script>alert("Trade offer has been updated and sent to the other trader to confirm.");window.location.href = "../user/trade_list.php";</script>';
            } else {
                echo '<script>alert("Update fail!\nContact IT department for maintainence");window.location.href = "../php/index.php";</script>';
            }
        }
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
            $sql = "SELECT * FROM trade t, customer c WHERE t.offerCustID = c.custid AND tradeid = '" . $current_data['tradeid'] . "'";
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
                        $sql = "SELECT * FROM trade t, customer c WHERE t.offerCustID = c.custid AND tradeid = '" . $current_data['tradeid'] . "'";
                        $result = $dbc->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = mysqli_fetch_array($result)) {
                                $current_offer = $row;
                                $trader = $current_offer['username'];
                                $traderid = $current_offer['custid'];
                                echo $trader;
                                break;
                            }
                        }
                        ?>
                    </li>
                </div>

                <div class="col-lg-3 col-sm-6 col-12 align-content-center">
                    <li class="list-inline-item me-0 trade-desc">Location:
                        <?php
                        $sql = "SELECT * FROM trade t, customer c WHERE t.offerCustID = c.custid AND tradeid = '" . $current_data['tradeid'] . "'";
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
                        $sql = "SELECT * FROM trade t, customer c WHERE t.offerCustID = c.custid AND tradeid = '" . $current_data['tradeid'] . "'";
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
                        $sql = "SELECT COUNT(t.tradeid) NUMBER FROM trade t, customer c WHERE c.custid = '{$current_data['offerCustID']}' AND (t.offerCustID = '{$current_data['offerCustID']}' OR t.acceptCustID = '{$current_data['offerCustID']}') AND t.tradeid <> '{$current_data['tradeid']}'";
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
                        $sql = "SELECT MAX(t.tradeDate) DATE FROM trade t, customer c WHERE t.offerCustID = c.custid AND t.tradeid <> '{$current_data['tradeid']}'";
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
                    <input class="form-control" type="text" id="type" name="type" readonly style="display: none;">
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
                                    <li class="" style="list-style-type:none;">Yours items:</li>
                                    <li class="" style="list-style-type:none; font-size:0.82em;">These are the items you will lose in the trade.</li>
                                </div>
                            </div>

                            <div class="form-group">
                                <select class="select2bs4" name="my_item[]" id="myitem" disabled multiple="multiple" data-placeholder="Select your item" style="width: 100%;">
                                    <?php
                                    $get_item = "SELECT * FROM trade t, item i, trade_details d WHERE i.itemid = d.itemid AND t.acceptCustID = d.custid AND t.tradeid = d.tradeid AND d.tradeid = '{$current_data['tradeid']}'";
                                    $result_item = $dbc->query($get_item);
                                    if ($result_item->num_rows > 0) {
                                        while ($row = mysqli_fetch_array($result_item)) {
                                            echo '<option ' . $selected . ' selected="selected" value="' . $row['itemid'] . '">' . $row['itemname'] . '</option>';
                                        }
                                    }

                                    $get_item_available = "SELECT * FROM item i, trade t WHERE i.custid = t.acceptCustID AND i.itemActive = 'Available' AND t.tradeid = '{$current_data['tradeid']}' AND NOT EXISTS (SELECT * FROM trade_details d WHERE t.acceptCustID = d.custid AND i.itemid = d.itemid AND d.tradeid = '{$current_data['tradeid']}')";
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
                                $get_inventory = "SELECT * FROM trade_details d, item i WHERE d.itemid = i.itemid AND d.custid = '{$current_data['acceptCustID']}' AND d.tradeid = '{$current_data['tradeid']}'";
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
                            <?php
                            if (($current_data['status'] == 'Pending') || $current_data['status'] == 'Trading')  {
                                echo '<div class="row px-2">
                                <div class="form-check p-0">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" name="terms1" class="custom-control-input" id="checkTerms1">
                                        <label class="custom-control-label" for="checkTerms1" style="font-weight: lighter;">Click here to confirm the trade content</label>
                                    </div>
                                </div>
                            </div>';
                            }
                            ?>

                        </div>
                    </div>

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
                                    <li class="" style="list-style-type:none;">His items:</li>
                                    <li class="" style="list-style-type:none; font-size:0.82em;">These are the items you will receive in the trade.</li>
                                </div>
                            </div>

                            <div class="form-group">
                                <select class="select2bs4" name="his_item[]" id="hisitem" disabled multiple="multiple" data-placeholder="Select his/her item" style="width: 100%;">
                                    <?php
                                    $get_item = "SELECT * FROM trade t, item i, trade_details d WHERE i.itemid = d.itemid AND t.offerCustID = d.custid AND t.tradeid = d.tradeid AND d.tradeid = '{$current_data['tradeid']}'";
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
                                        . "<div class='d-flex bd-highlight align-items-center px-1 pt-1'>"
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

                            <?php
                            if (($current_data['status'] == 'Pending') || $current_data['status'] == 'Trading')  {
                                echo '<div class="row px-2">
                                <div class="form-check p-0">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" name="terms2" class="custom-control-input" id="checkTerms2">
                                        <label class="custom-control-label" for="checkTerms2" style="font-weight: lighter;">Click here to confirm the trade content</label>
                                    </div>
                                </div>
                            </div>';
                            }
                            ?>
                        </div>
                    </div>

                    <div class="col-auto float-right mt-3 mb-5">
                        <button type='button' class='btn btn-dark mr-2' id='btnback' onclick='back()'>Back</button>
                        <?php
                        if ($current_data['status'] == 'Pending') {
                            echo "<button type='button' class='btn btn-danger mr-2' id='btnreject' name='btnreject' onclick='reject()'>Reject</button>";
                            echo "<button type='button' class='btn btn-success mr-2' id='btnaccept' name='btnaccept' onclick='accept()'>Accept</button>";
                            echo "<button type='button' class='btn btn-primary mr-2' id='btnchange' name='btnchange' onclick='change()'>Change request</button>";
                            echo "<button type='button' class='btn btn-warning mr-2' id='btncancel' name='btncancel' onclick='cancel()' disabled>Cancel</button>";
                        }
                        ?>
                        <?php
                        if ($current_data['status'] == 'Trading') {
                            echo "<button type='button' class='btn btn-info' id='complete' name='complete' onclick='completed()'>Complete</button>";
                        }
                        ?>
                        <?php
//                        if (($current_data['status'] == 'Completed') OR ($current_data['status'] == 'To Pay') OR ($current_data['status'] == 'Rejected')) {
//                            echo "<button type='button' class='btn btn-dark' id='btnback' onclick='back()'>Back</button>";
//                        }
                        ?>
                    </div>
                </div>
            </form>
        </div>
        <?php include '../include/footer.php'; ?>
    </body>
    <script>
        var currentURL = window.location.href;

        function accept() {
            var message = "";
            var fullfill = true;
            var checked = true;
            document.getElementById("myitem").style.borderColor = "";
            document.getElementById("hisitem").style.borderColor = "";
            document.getElementById("checkTerms1").style.borderColor = "";
            document.getElementById("checkTerms2").style.borderColor = "";

            if (!document.getElementById("myitem").value || document.getElementById("myitem").value === "") {
                document.getElementById("myitem").style.borderColor = "red";
                message += "You must select at least an item from your inventory.\n";
                fullfill = false;
            }

            if (!document.getElementById("hisitem").value || document.getElementById("hisitem").value === "") {
                document.getElementById("hisitem").style.borderColor = "red";
                message += "You must select at least an item from his inventory.\n";
                fullfill = false;
            }

            if (!document.getElementById("checkTerms1").checked || document.getElementById("checkTerms1").checked === false) {
                document.getElementById("checkTerms1").style.borderColor = "red";
                message += "Please check the checkbox from your site to confirm your trade.\n";
                checked = false;
            }

            if (!document.getElementById("checkTerms2").checked || document.getElementById("checkTerms2").value === false) {
                document.getElementById("checkTerms2").style.borderColor = "red";
                message += "Please check the checkbox from his site to confirm his trade.\n";
                checked = false;
            }

            if ((fullfill) && (checked)) {
                if (confirm("Are you sure that you want to accept this trade with <?php echo $trader ?>?")) {
                    document.getElementById("type").value = "Accept";
                    document.getElementById("form").submit();
                }
            } else {
                alert(message);
            }
        }

        function reject() {
            var message = "";
            var fullfill = true;
            var checked = true;
            document.getElementById("myitem").style.borderColor = "";
            document.getElementById("hisitem").style.borderColor = "";
            document.getElementById("checkTerms1").style.borderColor = "";
            document.getElementById("checkTerms2").style.borderColor = "";

            if (!document.getElementById("myitem").value || document.getElementById("myitem").value === "") {
                document.getElementById("myitem").style.borderColor = "red";
                message += "You must select at least an item from your inventory.\n";
                fullfill = false;
            }

            if (!document.getElementById("hisitem").value || document.getElementById("hisitem").value === "") {
                document.getElementById("hisitem").style.borderColor = "red";
                message += "You must select at least an item from his inventory.\n";
                fullfill = false;
            }

            if (!document.getElementById("checkTerms1").checked || document.getElementById("checkTerms1").checked === false) {
                document.getElementById("checkTerms1").style.borderColor = "red";
                message += "Please check the checkbox from your site to confirm your trade.\n";
                checked = false;
            }

            if (!document.getElementById("checkTerms2").checked || document.getElementById("checkTerms2").value === false) {
                document.getElementById("checkTerms2").style.borderColor = "red";
                message += "Please check the checkbox from his site to confirm his trade.\n";
                checked = false;
            }

            if ((fullfill) && (checked)) {
                if (confirm("Are you sure that you want to reject this trade with <?php echo $trader ?>?")) {
                    document.getElementById("type").value = "Reject";
                    document.getElementById("form").submit();
                }
            } else {
                alert(message);
            }
        }

        function change() {
            var message = "";
            var fullfill = true;
            var checked = true;
            document.getElementById("myitem").style.borderColor = "";
            document.getElementById("hisitem").style.borderColor = "";
            document.getElementById("checkTerms1").style.borderColor = "";
            document.getElementById("checkTerms2").style.borderColor = "";

            if (document.getElementById("btnchange").textContent === "Confirm change") {
                if (!document.getElementById("myitem").value || document.getElementById("myitem").value === "") {
                    document.getElementById("myitem").style.borderColor = "red";
                    message += "You must select at least an item from your inventory.\n";
                    fullfill = false;
                }

                if (!document.getElementById("hisitem").value || document.getElementById("hisitem").value === "") {
                    document.getElementById("hisitem").style.borderColor = "red";
                    message += "You must select at least an item from his inventory.\n";
                    fullfill = false;
                }

                if (!document.getElementById("checkTerms1").checked || document.getElementById("checkTerms1").checked === false) {
                    document.getElementById("checkTerms1").style.borderColor = "red";
                    message += "Please check the checkbox from your site to confirm your trade.\n";
                    checked = false;
                }

                if (!document.getElementById("checkTerms2").checked || document.getElementById("checkTerms2").value === false) {
                    document.getElementById("checkTerms2").style.borderColor = "red";
                    message += "Please check the checkbox from his site to confirm his trade.\n";
                    checked = false;
                }

                if ((fullfill) && (checked)) {
                    if (confirm("Are you sure that you want to update offer of this trade with <?php echo $trader ?>?")) {
                        document.getElementById("type").value = "Change";
                        document.getElementById("form").submit();
                    }
                } else {
                    alert(message);
                }
            } else {
                editable();
            }
        }

        function completed() {
            var message = "";
            var fullfill = true;
            var checked = true;
            document.getElementById("myitem").style.borderColor = "";
            document.getElementById("hisitem").style.borderColor = "";
            document.getElementById("checkTerms1").style.borderColor = "";
            document.getElementById("checkTerms2").style.borderColor = "";

            if (!document.getElementById("myitem").value || document.getElementById("myitem").value === "") {
                document.getElementById("myitem").style.borderColor = "red";
                message += "You must select at least an item from your inventory.\n";
                fullfill = false;
            }

            if (!document.getElementById("hisitem").value || document.getElementById("hisitem").value === "") {
                document.getElementById("hisitem").style.borderColor = "red";
                message += "You must select at least an item from his inventory.\n";
                fullfill = false;
            }

            if (!document.getElementById("checkTerms1").checked || document.getElementById("checkTerms1").checked === false) {
                document.getElementById("checkTerms1").style.borderColor = "red";
                message += "Please check the checkbox from your site to confirm your trade.\n";
                checked = false;
            }

            if (!document.getElementById("checkTerms2").checked || document.getElementById("checkTerms2").value === false) {
                document.getElementById("checkTerms2").style.borderColor = "red";
                message += "Please check the checkbox from his site to confirm his trade.\n";
                checked = false;
            }

            if ((fullfill) && (checked)) {
                if (confirm("Are you sure that you have complete this trade with <?php echo $trader ?>?")) {
                    document.getElementById("type").value = "Complete";
                    document.getElementById("form").submit();
                }
            } else {
                alert(message);
            }
        }

        function editable() {
            document.getElementById("btnchange").textContent = "Confirm change";
            document.getElementById("myitem").disabled = false;
            document.getElementById("hisitem").disabled = false;
            document.getElementById("btncancel").disabled = false;

            document.getElementById("btnaccept").disabled = true;
            document.getElementById("btnreject").disabled = true;
        }

        function cancel() {
            if (confirm("Are you sure to unsave current information?")) {
                document.getElementById("btnchange").textContent = "Change request";
//                document.getElementById("myitem").disabled = true;
//                document.getElementById("hisitem").disabled = true;
//                document.getElementById("btncancel").disabled = true;
//
//                document.getElementById("btnaccept").disabled = false;
//                document.getElementById("btnreject").disabled = false;

                window.location.href = currentURL;
            }
        }

//        function changeRequest() {
//            if (document.getElementById("btnchange").textContent === "Save") {
//                var fullfill = true;
//
//                if (fullfill) {
//                    if (confirm("Confirm to save ?")) {
//                        isset($_POST['change']);
//                    }
//                }
//            } else {
//                editable();
//            }
//        }

        $(function () {
            //Initialize Select2 Elements
            $('.select2').select2()

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        })

        function back() {
            window.location.href = "../user/trade_list.php";
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