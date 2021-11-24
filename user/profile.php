<?php
include '../include/header.php';

if (!isset($_SESSION['loginuser'])) {
    echo '<script>alert("Please login to Tradee.");window.location.href="../user/logout.php";</script>';
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM customer WHERE custid = '$id' LIMIT 1";
    $result = $dbc->query($sql);
    if ($result->num_rows > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $current_data = $row;
            $sqluser = "SELECT * FROM customer WHERE custid = '{$_SESSION['loginuser']['custid']}' AND custid = '{$row['custid']}'";
            $resultuser = $dbc->query($sqluser);
            if ($resultuser->num_rows > 0) {
                echo '<script>window.location.href="../user/my_profile.php";</script>';
            }
            break;
        }
    } else {
        echo '<script>alert("Extract data error!\nContact IT department for maintainence");window.location.href = "../php/index.php";</script>';
    }
}

$sql = "SELECT * FROM trade ORDER BY tradeid DESC LIMIT 1";
$result = $dbc->query($sql);
if ($result->num_rows > 0) {
    while ($row = mysqli_fetch_array($result)) {
        $latestnum = ((int) substr($row['tradeid'], 1)) + 1;
        $newid = "T{$latestnum}";
        $title = "Trade ID - {$newid}";
        echo '<script>var current_data = null;</script>';
        $view = false;
        break;
    }
} else {
    $newid = "T10001";
    $title = "Trade ID - T10001";
    echo '<script>var current_data = null;</script>';
    $view = false;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sql_trade = "INSERT INTO trade(tradeid, offerCustID, acceptCustID, acceptPayment, offerPayment, tradeDate, status) VALUES ("
            . "'" . $newid . "',"
            . "'" . $_SESSION['loginuser']['custid'] . "',"
            . "'" . $current_data['custid'] . "',"
            . "'Pending',"
            . "'Pending',"
            . "'" . $_POST['todaydate'] . "',"
            . "'Pending')";
//    echo '<script>alert("' . $sql_trade . '");</script>';

    if (($dbc->query($sql_trade))) {
        $my_items = $_POST['my_item'];
        foreach ($my_items as $myitems) {
            $sql_mytrade = "INSERT INTO trade_details(tradeid, custid, itemid) VALUES ("
                    . "'" . $newid . "',"
                    . "'" . $_SESSION['loginuser']['custid'] . "',"
                    . "'" . $myitems . "')";
            $dbc->query($sql_mytrade);
//        echo '<script>alert("' . $sql_mytrade . '");</script>';

            $sql_my_itemActive = "UPDATE item SET "
                    . "itemActive = 'Pending'"
                    . " WHERE custid ='" . $_SESSION['loginuser']['custid'] . "' AND"
                    . " itemid = '" . $myitems . "'";
            $dbc->query($sql_my_itemActive);
//        echo '<script>alert("' . $sql_my_itemActive . '");</script>';
        }
//    echo '<script>alert("' . $myitems . '");</script>';

        $his_items = $_POST['his_item'];
        foreach ($his_items as $his_item_list) {
            $sql_his_trade_details = "INSERT INTO trade_details(tradeid, custid, itemid) VALUES ("
                    . "'" . $newid . "',"
                    . "'" . $current_data['custid'] . "',"
                    . "'" . $his_item_list . "')";

            $dbc->query($sql_his_trade_details);
        }
//    echo '<script>alert("' . $sql_his_trade_details . '");</script>';
        echo '<script>alert("Trade offer sent successfully!");window.location.href="../php/index.php";</script>';
    } else {
        echo '<script>alert("Insert fail!\nContact IT department for maintainence")</script>';
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
        <title><?php
            echo $current_data['username'];
            ?> - Tradee</title>
    </head>
    <body>
        <div class="container-lg">
            <div class="row my-3 py-3">
                <div class="col-lg-3 profile-pic-box float-start align-items-center justify-content-center text-center">
                    <img src="<?php
                    if (isset($current_data)) {
                        if ($current_data['avatar'] != null) {
                            echo $current_data['avatar'];
                        } else {
                            echo "../img/login/default_profile.jpg";
                        }
                    }
                    ?>" class="rounded-pill img-fluid profile-pic" alt="Profile picture">
                </div>

                <div class="col-lg-9 px-3">
                    <div class="row">
                        <div class="col py-3">
                            <?php
                            if (isset($current_data)) {
                                echo "<div>{$current_data['username']}</div>";
                            } else {
                                echo "<div style='font-weight:bold;'>Username</div>";
                            }
                            ?>
                            <?php
                            if (isset($current_data)) {
                                if (isset($current_data['review'])) {
                                    echo "<div>{$current_data['review']}</div>";
                                } else {
                                    echo "<div style='font-weight:lighter;'>- No reviews yet</div>";
                                }
                            }
                            ?>
                        </div>

                        <div class="col-auto float-right py-3">
                            <button class="btn btn-trade-now" data-toggle="modal" data-target="#modal-bid-item">Trade now</button>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="row">
                                <div class="col-md-3 col-sm-4 col-6">
                                    <div class="my-2">
                                        <div style="font-weight: bolder;">Contact</div>
                                        <?php
                                        if (isset($current_data)) {
                                            echo "<div>- {$current_data['contact']}</div>";
                                        }
                                        ?>
                                    </div>
                                </div>
                                
                                <div class="col-md-3 col-sm-4 col-6">
                                    <div class="my-2">
                                        <div style="font-weight: bolder;">Joined</div>
                                        <?php
                                        if (isset($current_data)) {
                                            echo "<div>- {$current_data['registration_date']}</div>";
                                        }
                                        ?>
                                    </div>
                                </div>

                                <div class="col-md-3 col-sm-4 col-6">
                                    <div class="my-2">
                                        <div style="font-weight: bolder;">Location</div>
                                        <?php
                                        if (isset($current_data)) {
                                            echo "<div>- {$current_data['state']}, {$current_data['country']}</div>";
                                        } else {
                                            echo "<div style='font-weight: lighter;'>- No state shown</div>";
                                        }
                                        ?>
                                    </div>
                                </div>

                                <?php
                                if (isset($current_data)) {
                                    if (($current_data['gender'] != "")) {
                                        echo "<div class='col-md-3 col-sm-4 col-6'>"
                                        . "<div class='my-2'>"
                                        . "<div style='font-weight: bolder;'>Gender</div>";
                                        echo "<div>- {$current_data['gender']}</div>"
                                        . "</div>"
                                        . "</div>";
                                    }
                                }
                                ?>

                                <?php
                                if (isset($current_data)) {
                                    if (($current_data['birth'] != "")) {
                                        echo "<div class='col-md-3 col-sm-4 col-6'>"
                                        . "<div class='my-2'>"
                                        . "<div style='font-weight: bolder;'>Birth</div>";
                                        echo "<div>- {$current_data['birth']}</div>"
                                        . "</div>"
                                        . "</div>";
                                    }
                                }
                                ?>

                                <div class="col-md-3 col-sm-4 col-6">
                                    <div class="my-2">
                                        <div style="font-weight: bolder;">Trade Count</div>
                                        <?php
                                        $sql = "SELECT COUNT(t.tradeid) NUMBER FROM trade t, customer c WHERE (t.offerCustID = c.custid OR t.acceptCustid = c.custid) AND c.custid = '{$current_data['custid']}' AND (status = 'Rejected' OR status = 'Completed')";
                                        $result = $dbc->query($sql);
                                        if ($result->num_rows > 0) {
                                            while ($row = mysqli_fetch_array($result)) {
                                                $count = $row['NUMBER'];
                                                echo "<div>- {$row['NUMBER']}</div>";
                                                break;
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>

                                <div class="col-md-3 col-sm-4 col-6">
                                    <div class="my-2">
                                        <div style="font-weight: bolder;">Last Trade</div>
                                        <?php
                                        $sql = "SELECT MAX(t.tradeDate) DATE FROM trade t, customer c WHERE (t.offerCustID = c.custid OR t.acceptCustID = c.custid) AND c.custid = '{$current_data['custid']}'";
                                        $result = $dbc->query($sql);
                                        if ($result->num_rows > 0) {
                                            while ($row = mysqli_fetch_array($result)) {
                                                if ($row['DATE'] == "") {
                                                    echo "<div style='font-weight: lighter;'>- No trade completed</div>";
                                                } else {
                                                    echo "<div>- {$row['DATE']}</div>";
                                                }
                                                break;
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col py-3 px-0">
                        <div style="font-weight: bolder;">Description</div>
                        <?php
                        if (isset($current_data)) {
                            if (($current_data['description'] != '')) {
                                echo "<div>- {$current_data['description']}</div>";
                            } else {
                                echo "<div style='font-weight: lighter;'>- No description yet</div>";
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>

            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <button class="nav-link active" id="nav-inventory-tab" data-bs-toggle="tab" data-bs-target="#nav-inventory" type="button" role="tab">Inventory</button>
                    <button class="nav-link" id="nav-reviews-tab" data-bs-toggle="tab" data-bs-target="#nav-reviews" type="button" role="tab">Reviews</button>
                    <button class="nav-link " id="nav-history-tab" data-bs-toggle="tab" data-bs-target="#nav-history" type="button" role="tab">Trade history</button>
                </div>
            </nav>
            <div class="tab-content mb-3" id="nav-tabContent">
                <!--tab 1-->
                <div class="tab-pane fade show active" id="nav-inventory" role="tabpanel">
                    <?php
                    $get_inventory = "SELECT * FROM item i, customer c WHERE i.custid = c.custid AND i.custid = '{$current_data['custid']}' ORDER BY i.itemid DESC";
                    $result = $dbc->query($get_inventory);
                    if ($result->num_rows > 0) {
                        echo "<div class = 'container-lg'>"
                        . "<div class='row row-cols-xl-5 row-cols-lg-4 row-cols-md-3 row-cols-sm-2 row-cols-1'>";

                        while ($row = mysqli_fetch_array($result)) {
                            echo "<div class='col px-1 py-2'>"
//                            . "<a href='../user/profile.php' style='text-decoration:none;'>"
//                            . "<ul class='list-inline mb-0 p-1'>"
//                            . "<img src=" . $row["avatar"] . " class='' style='width: 22px;' alt='Avatar'>"
//                            . "<li class='list-inline-item' style='font-size:0.7em; color:#969696;'>" . $row["username"] . "</li>"
//                            . "</ul>"
//                            . "</a>"
                            . "<div class='item-img-box overflow-hidden'>"
                            . "<a href='../user/item_profile.php?id=" . $row["itemid"] . "'>"
                            . "<img src='../data/item_img/" . $row['itemid'] . "_0' class='img-fluid item-img' alt='...'>"
                            . "</a>"
                            . "</div>"
                            . "<div class='d-flex bd-highlight align-items-center pt-1 px-1'>"
                            . "<div class='flex-grow-1 bd-highlight' style='font-size:0.8em;'>" . $row["itemname"] . "</div>"
                            . "<div class='d-flex bd-highlight align-items-center'>"
                            . "<i class='far fa-heart me-auto' style='font-size:0.9em;'></i>"
                            . "</div>"
                            . "</div>"
                            . "<ul class='list-inline px-1 mb-0'>"
                            . "<div class='float-right bd-highlight' style='font-size:0.7em; color:#969696;'>" . $row["itemActive"] . "</div>"
                            . "<div class='flex-grow-1 bd-highlight' style='font-size:0.7em; color:#969696;'>" . $row["itemCondition"] . "</div>"
                            . "<div class='flex-grow-1 bd-highlight' style='font-size:0.7em; color:#969696;'>" . $row["brand"] . "</div>"
                            . "</ul>"
                            . "</div>";
                        }

                        echo "</div>"
                        . "</div>";
                    } else {
                        echo "<div class='text-center p-5' style='height:350px;'>"
                        . "<i class='fas fa-box-open p-5' style='font-size:5em; color: #969696; text-shadow: -2px 8px 4px #000000;'></i>"
                        . "<div class=''>This member has not upload anything yet</div>"
                        . "</div>";
                    }
                    ?>
                </div>

                <div class="tab-pane fade" id="nav-reviews" role="tabpanel">
                    <div class="text-center p-5" style="height:350px;">
                        <i class="far fa-star p-5" style="font-size:5em; color: #969696; text-shadow: -2px 8px 4px #000000;"></i>
                        <div class="">Collecting reviews takes time, so check back soon</div>
                    </div>
                </div>

                <div class="tab-pane fade" id="nav-history" role="tabpanel">
                    <div class="container-lg mt-3">
                        <div class="content" style="min-height: 320px;">
                            <div class="card">
                                <div class="card-body">
                                    <table id="table" class="table table-striped table-bordered" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th style="width: 15%;">Trade ID</th>
                                                <th style="width: 18%;">Offer ID</th>
                                                <th style="width: 18%;">Accept ID</th>
                                                <th style="width: 20%;">Date</th>
                                                <th style="width: 15%;">Status</th>
                                                <th style="width: auto;"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sql = "SELECT * FROM trade WHERE (status = 'Completed' OR status = 'Rejected') AND (offerCustID = '" . $current_data['custid'] . "' OR acceptCustID = '" . $current_data['custid'] . "') ORDER BY tradeid DESC";
                                            $result = $dbc->query($sql);
                                            if ($result) {
                                                while ($row = $result->fetch_assoc()) {
                                                    if ($row["offerCustID"] == $current_data['custid']) {
                                                        $color1 = "skyblue";
                                                        $weight1 = 'bolder';
                                                    } else {
                                                        $color1 = "black";
                                                        $weight1 = 'normal';
                                                    }

                                                    if ($row["acceptCustID"] == $current_data['custid']) {
                                                        $color2 = "skyblue";
                                                        $weight2 = 'bolder';
                                                    } else {
                                                        $color2 = "black";
                                                        $weight2 = 'normal';
                                                    }

                                                    if ($row["status"] === "Pending") {
                                                        $color3 = "yellow";
                                                    } else if ($row["status"] === "Completed") {
                                                        $color3 = "limegreen";
                                                    } else {
                                                        $color3 = "red";
                                                    }

                                                    echo "<tr>"
                                                    . "<td style=''>" . $row["tradeid"] . "</td>"
                                                    . "<td style='color:" . $color1 . "; font-weight: " . $weight1 . "'>" . $row["offerCustID"] . "</td>"
                                                    . "<td style='color:" . $color2 . "; font-weight: " . $weight2 . "'>" . $row["acceptCustID"] . "</td>"
                                                    . "<td style=''>" . $row["tradeDate"] . "</td>"
                                                    . "<td style='font-weight: bolder; color:" . $color3 . "'>" . $row["status"] . "</td>"
                                                    . "<td>"
                                                    . "<a class='btn btn-info btn-block' href='trade_offer.php?id=" . $row["tradeid"] . "'><i class='far fa-eye'></i></a></td></tr>";
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal-bid-item">
            <form method="post" id="form">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div class="modal-title" style="font-weight: bold;"><?php echo $title; ?></div>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-3 profile-pic-box float-start align-items-center justify-content-center text-center">
                                    <img src="<?php
                                    if (isset($current_data)) {
                                        echo $current_data['avatar'];
                                    }
                                    ?>" class="rounded-pill img-fluid profile-pic-small" alt="Profile picture">
                                </div>

                                <div class="col-lg-9">
                                    <div class="row">
                                        <div class="col-lg-4 mb-1">
                                            <?php
                                            if (isset($current_data)) {
                                                echo $current_data['username'];
                                            }
                                            ?>
                                            <?php
                                            if (isset($current_data) == null) {
                                                echo "<div>- {$current_data['review']}</div>";
                                            } else {
                                                echo "<div style='font-weight:lighter;'>- No reviews yet</div>";
                                            }
                                            ?>
                                        </div>

                                        <div class="col-lg-4 col-sm-6 mb-1">
                                            <div style="font-weight: bolder;">Joined</div>
                                            <?php
                                            if (isset($current_data)) {
                                                echo "<div>- {$current_data['registration_date']}</div>";
                                            }
                                            ?>
                                        </div>

                                        <div class="col-lg-4 col-sm-6 mb-1">
                                            <div style="font-weight: bolder;">Location</div>
                                            <?php
                                            if (isset($current_data)) {
                                                echo "<div>- {$current_data['state']}, {$current_data['country']}</div>";
                                            } else {
                                                echo "<div style='font-weight:lighter;'>- No location shown</div>";
                                            }
                                            ?>
                                        </div>

                                        <div class="col-lg-4 col-sm-6 mb-1">
                                            <div style="font-weight: bolder;">Trade Count</div>
                                            <?php
                                            $sql = "SELECT COUNT(t.tradeid) NUMBER FROM trade t, customer c WHERE (t.acceptCustID = c.custid OR t.offerCustID = c.custid) AND c.custid = '{$current_data['custid']}'";
                                            $result = $dbc->query($sql);
                                            if ($result->num_rows > 0) {
                                                while ($row = mysqli_fetch_array($result)) {
                                                    $current_offer = $row;
                                                    echo "<div>- {$current_offer['NUMBER']}</div>";
                                                    break;
                                                }
                                            }
                                            ?>
                                        </div>

                                        <div class="col-lg-4 col-sm-6 mb-1">
                                            <div style="font-weight: bolder;">Last Trade</div>
                                            <?php
                                            $sql = "SELECT MAX(t.tradeDate) DATE FROM trade t, customer c WHERE (t.acceptCustID = c.custid OR t.offerCustID = c.custid) AND c.custid = '{$current_data['custid']}'";
                                            $result = $dbc->query($sql);
                                            if ($result->num_rows > 0) {
                                                while ($row = mysqli_fetch_array($result)) {
                                                    $current_offer = $row;
                                                    echo "<div>- {$current_offer['DATE']}</div>";
                                                    break;
                                                }
                                            } else {
                                                echo "<div style='font-weight:lighter;'>- This user haven't conduct any trade yet.</div>";
                                            }
                                            ?>
                                        </div>

                                        <div class="col-12 mb-1">
                                            <div style="font-weight: bolder;">Description</div>
                                            <?php
                                            if (isset($current_data)) {
                                                if (($current_data['description'] != '')) {
                                                    echo "<div>- {$current_data['description']}</div>";
                                                } else {
                                                    echo "<div style='font-weight:lighter;'>- No description yet.</div>";
                                                }
                                            }
                                            ?>
                                        </div>

                                        <div class="col-12 mb-1" style="display: none;">
                                            <div style="font-weight: bolder;">Today Date</div>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                                </div>
                                                <input type="text" class="form-control" placeholder="dd/mm/yyyy" id="todaydate" maxlength="10" readOnly name="todaydate">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Your inventory</label>
                                        <select class="select2bs4" name="my_item[]" id="myitem" multiple="multiple" data-placeholder="Select your item" style="width: 100%;">
                                            <?php
                                            $get_item = "SELECT * FROM item WHERE custid = '{$_SESSION['loginuser']['custid']}' AND itemActive = 'Available'";
                                            $result_item = $dbc->query($get_item);
                                            if ($result_item->num_rows > 0) {
                                                while ($row = mysqli_fetch_array($result_item)) {
                                                    echo '<option ' . $selected . ' value="' . $row['itemid'] . '">' . $row['itemname'] . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>His/Her inventory</label>
                                        <select class="select2bs4" name="his_item[]" id="hisitem" multiple="multiple" data-placeholder="Select his/her item" style="width: 100%;">
                                            <?php
                                            $get_item = "SELECT * FROM item WHERE custid = '{$current_data['custid']}' AND itemActive = 'Available'";
                                            $result_item = $dbc->query($get_item);
                                            if ($result_item->num_rows > 0) {
                                                while ($row = mysqli_fetch_array($result_item)) {
                                                    echo '<option ' . $selected . ' value="' . $row['itemid'] . '">' . $row['itemname'] . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-offer" id="btntrade" onclick="sendoffer()">Send offer</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <?php include '../include/footer.php'; ?>
    </body>
    <script>
        $('#table').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true
        });

        function sendoffer() {
            var fullfill = true;
            var message = "Both trader must select at least an item to trade.";

            document.getElementById("myitem").style.borderColor = "";
            document.getElementById("hisitem").style.borderColor = "";

            if (!document.getElementById("myitem").value || document.getElementById("myitem").value === "") {
                document.getElementById("myitem").style.borderColor = "red";
                fullfill = false;
            }
            if (!document.getElementById("hisitem").value || document.getElementById("hisitem").value === "") {
                document.getElementById("hisitem").style.borderColor = "red";
                fullfill = false;
            }

            if (fullfill) {
                if (confirm("Are sure to trade the current item with <?php echo $current_data['username'] ?>?")) {
                    document.getElementById("form").submit();
                }
            } else {
                alert(message);
            }
        }

        $(function () {
            //Initialize Select2 Elements
            $('.select2').select2()

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        })
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

        .profile-pic-box{
            /*border-radius: 3996px;*/
        }

        .profile-pic{
            width: 182px;
            height: 182px;
            object-fit: cover;
        }

        .profile-pic-small{
            width: 142px;
            height: 142px;
            object-fit: cover;
        }

        .model-profile-pic{
            width: 112px;
            height: 112px;
            /*            width: 142px;
                        height: 142px;*/
            object-fit: cover;
        }

        /*button*/
        .btn-offer{
            color: white;
            border-color: #7cf279;
            background-color: #7cf279;
        }

        .btn-trade-now{
            color: #fff;
            border-color: #7cf279;
            background-color: #7cf279;
            transition-duration: 0.2s;
        }

        .btn-trade-now:hover{
            color: #fff;
            border-color: #6ed66b;
            background-color: #6ed66b;
            transition-duration: 0.2s;
        }
    </style>
</html>