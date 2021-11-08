<?php
include '../include/header.php';

if (isset($_SESSION['loginuser']['userid'])) {
    echo '<script>window.location.href = "../user/profile.php";</script>';
    exit();
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

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM customer WHERE custid = '$id' LIMIT 1";
    $result = $dbc->query($sql);
    if ($result->num_rows > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $current_data = $row;
            break;
        }
    } else {
        echo '<script>alert("Extract data error!\nContact IT department for maintainence");window.location.href = "product_detail.php";</script>';
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sql_trade = "INSERT INTO trade(tradeid, offerCustID, acceptCustID, date, status) VALUES ("
            . "'" . $newid . "',"
            . "'" . $_SESSION['loginuser']['custid'] . "',"
            . "'" . $current_data['custid'] . "',"
            . "NOW(),"
            . "'Pending')";

    echo '<script>alert("' . $sql_trade . '");</script>';

    $my_items = $_POST['my_item'];
    foreach ($my_items as $my_item_list) {
        $sql_my_trade_details = "INSERT INTO trade_details(tradeid, custid, itemid) VALUES ("
                . "'" . $newid . "',"
                . "'" . $_SESSION['loginuser']['custid'] . "',"
                . "'" . $my_item_list . "')";

        $dbc->query($sql_my_trade_details);
    }
    echo '<script>alert("' . $sql_my_trade_details . '");</script>';

    foreach ($my_items as $update_my_item_list) {
        $sql = "UPDATE item SET "
                . "itemActive = 'Pending'"
                . " WHERE custid ='" . $_SESSION['loginuser']['custid'] . "' AND"
                . " itemid = '" . $update_my_item_list . "'";

        $dbc->query($sql);
        echo '<script>alert("' . $sql . '");</script>';
    }

    echo '<script>alert("' . $update_my_item_list . '");</script>';

    $his_items = $_POST['his_item'];
    foreach ($his_items as $his_item_list) {
        $sql_his_trade_details = "INSERT INTO trade_details(tradeid, custid, itemid) VALUES ("
                . "'" . $newid . "',"
                . "'" . $current_data['custid'] . "',"
                . "'" . $his_item_list . "')";

        $dbc->query($sql_his_trade_details);
    }
    echo '<script>alert("' . $sql_his_trade_details . '");</script>';

    if (($dbc->query($sql_trade))) {
        echo '<script>alert("Successfuly insert!");window.location.href="../php/index.php";</script>';
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
            ?> profile - Tradee</title>
    </head>
    <body>
        <div class="container-lg">
            <div class="row my-3 py-3">
                <div class="col-lg-3 profile-pic-box float-start align-items-center justify-content-center text-center">
                    <img src="../img/about/people-2.jpg" class="rounded-pill img-fluid profile-pic" alt="Profile picture">
                </div>

                <div class="col-lg-9">
                    <div class="row py-3">
                        <div class="col-9 py-3">
                            <?php
                            if (isset($current_data)) {
                                echo $current_data['username'];
                            }
                            ?>
                            <?php
                            if (isset($current_data) == null) {
                                echo "<div>{$current_data['review']}</div>";
                            } else {
                                echo "<div style='font-weight:bold;'>No reviews yet</div>";
                            }
                            ?>
                        </div>

                        <div class="col-3 py-3">
                            <a class="btn btn-block btn-outline-primary" data-toggle="modal" data-target="#modal-bid-item">Trade now</a>
                        </div>
                    </div>

                    <div class="col py-3 px-0">
                        <div>About</div>
                        <?php
                        if (isset($current_data)) {
                            echo "<div>{$current_data['registration_date']}</div>";
                        }
                        ?>
                        <div>Display location</div>
                        <?php
                        if (isset($current_data) == null) {
                            echo "<div>{$current_data['state']}</div>";
                        } else {
                            echo "<div style='font-weight:bold;'>No state shown</div>";
                        }
                        ?>
                    </div>

                    <div class="col py-3 px-0">
                        <div>Description here</div>
                        <?php
                        if (isset($current_data) == null) {
                            echo "<div>{$current_data['description']}</div>";
                        } else {
                            echo "<div>No description yet</div>";
                        }
                        ?>
                    </div>
                </div>
            </div>

            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <button class="nav-link active" id="nav-inventory-tab" data-bs-toggle="tab" data-bs-target="#nav-inventory" type="button" role="tab">Inventory</button>
                    <button class="nav-link" id="nav-reviews-tab" data-bs-toggle="tab" data-bs-target="#nav-reviews" type="button" role="tab">Reviews</button>
                    <button class="nav-link" id="nav-history-tab" data-bs-toggle="tab" data-bs-target="#nav-history" type="button" role="tab">Trade history</button>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <!--tab 1-->
                <div class="tab-pane fade show active" id="nav-inventory" role="tabpanel">
                    <?php
                    $get_inventory = "SELECT * FROM item i, customer c, item_image m  WHERE i.custid = '{$current_data['custid']}' AND i.custid = c.custid AND i.itemid = m.itemid";
                    $result = $dbc->query($get_inventory);
                    if ($result->num_rows > 0) {
                        echo "<div class = 'container-lg'>"
                        . "<div class='row row-cols-xl-5 row-cols-lg-4 row-cols-md-3 row-cols-sm-2 row-cols-1'>";

                        while ($row = mysqli_fetch_array($result)) {
                            echo "<div class='col px-1 py-2'>"
                            . "<a href='../user/profile.php' style='text-decoration:none;'>"
                            . "<ul class='list-inline mb-0 p-1'>"
                            . "<img src=" . $row["avatar"] . " class='' style='width: 22px;' alt='Avatar'>"
                            . "<li class='list-inline-item' style='font-size:0.7em; color:#969696;'>" . $row["username"] . "</li>"
                            . "</ul>"
                            . "</a>"
                            . "<div class='item-img-box overflow-hidden'>"
                            . "<a href='../user/item_profile.php?id=" . $row["itemid"] . "'>"
                            . "<img src=" . $row["img"] . " class='img-fluid item-img' alt='...'>"
                            . "</a>"
                            . "</div>"
                            . "<div class='d-flex bd-highlight align-items-center p-1 pb-0'>"
                            . "<div class='flex-grow-1 bd-highlight' style='font-size:0.8em;'>" . $row["itemname"] . "</div>"
                            . "<div class='d-flex bd-highlight align-items-center'>"
                            . "<i class='far fa-heart me-auto' style='font-size:0.9em;'></i>"
                            . "</div>"
                            . "</div>"
                            . "<ul class='list-inline p-1 pt-0 mb-0'>"
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
                        <div class="content" style="padding-bottom:20%">
                            <div class="row">
                                <div class="col-md-12">
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
                                                        $color1 = "blue";
                                                        $weight1 = 'bolder';
                                                    } else {
                                                        $color1 = "black";
                                                        $weight1 = 'normal';
                                                    }
                                                    
                                                    if ($row["acceptCustID"] == $current_data['custid']) {
                                                        $color2 = "blue";
                                                        $weight2 = 'bolder';
                                                    } else {
                                                        $color2 = "black";
                                                        $weight2 = 'normal';
                                                    }
                                                    
                                                    if ($row["status"] === "Pending") {
                                                        $color3 = "yellow";
                                                    } else if ($row["status"] === "Completed") {
                                                        $color3 = "green";
                                                    } else {
                                                        $color3 = "red";
                                                    }

                                                    echo "<tr>"
                                                    . "<td style='text-align: center;'>" . $row["tradeid"] . "</td>"
                                                    . "<td style='text-align: center; color:" . $color1 . "; font-weight: ". $weight1 ."'>" . $row["offerCustID"] . "</td>"
                                                    . "<td style='text-align: center; color:" . $color2 . "; font-weight: ". $weight2 ."'>" . $row["acceptCustID"] . "</td>"
                                                    . "<td style='text-align: center;'>" . $row["date"] . "</td>"
                                                    . "<td style='text-align: center; font-weight: bolder; color:" . $color3 . "'>" . $row["status"] . "</td>"
                                                    . "<td>"
                                                    . "<a class='btn btn-info btn-block' href='trade_offer.php?tradeid=" . $row["tradeid"] . "'><i class='far fa-eye'></i></a></td></tr>";
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

        <div class="modal fade" id="modal-lg">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="modal-title">Trade Request</div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body px-3 p-0">
                        <div class="row border-bottom py-3">
                            <div class="col-lg-3 profile-pic-box float-start align-items-center justify-content-center text-center">
                                <img src="../img/about/people-1.jpg" class="rounded-pill img-fluid model-profile-pic" alt="Profile picture">
                            </div>

                            <div class="col-lg-9">
                                <div class="row py-3">
                                    <div class="col-9 py-3">
                                        <div>Username</div>
                                        <div>No reviews yet</div>
                                    </div>

                                    <div class="col-3 py-3">
                                        <a class="btn btn-outline-primary" href="../user/profile.php.php" role="button">View profile</a>
                                    </div>  
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 border my-3" style="border-style: none;">
                            <div class="">
                                <div class="row">
                                    <div class="profile-pic-box">
                                        <img src="../img/about/people-1.jpg" class="img-fluid profile-pic-small float-start" alt="Profile picture">
                                        <div class="align-content-center py-2">
                                            <li class="" style="list-style-type:none;">Username offered:</li>
                                        </div>
                                    </div>
                                </div>

                                <div class="row" style="height:200px; background: whitesmoke"></div>
                            </div>

                            <div class="pt-2">
                                <div class="row py-2">
                                    <div class="profile-pic-box">
                                        <img src="../img/about/people-2.jpg" class="img-fluid profile-pic-small float-start" alt="Profile picture">
                                        <div class="align-content-center py-2">
                                            <li class="" style="list-style-type:none;">For yours:</li>
                                        </div>
                                    </div>
                                </div>

                                <div class="row" style="height:200px; background: whitesmoke"></div>
                            </div>
                        </div>

                        <div class="py-3 justify-content-center">
                            <button type="button" class="btn btn-danger">Decline</button>
                            <button type="button" class="btn btn-warning">Refund</button>
                            <a href="../user/trade_offer.php" type="button" class="btn btn-primary">View details</a>
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
                                    <img src="../img/about/people-2.jpg" class="rounded-pill img-fluid profile-pic" alt="Profile picture">
                                </div>

                                <div class="col-lg-9">
                                    <div class="col-12">
                                        <?php
                                        if (isset($current_data)) {
                                            echo $current_data['username'];
                                        }
                                        ?>
                                        <?php
                                        if (isset($current_data) == null) {
                                            echo "<div>{$current_data['review']}</div>";
                                        } else {
                                            echo "<div style='font-weight:bold;'>No reviews yet</div>";
                                        }
                                        ?>
                                    </div>

                                    <div class="col">
                                        <div>About</div>
                                        <?php
                                        if (isset($current_data)) {
                                            echo "<div>{$current_data['registration_date']}</div>";
                                        }
                                        ?>
                                        <div>Display location</div>
                                        <?php
                                        if (isset($current_data) == null) {
                                            echo "<div>{$current_data['state']}</div>";
                                        } else {
                                            echo "<div style='font-weight:bold;'>No state shown</div>";
                                        }
                                        ?>
                                    </div>

                                    <div class="col">
                                        <div>Description here</div>
                                        <?php
                                        if (isset($current_data) == null) {
                                            echo "<div>{$current_data['description']}</div>";
                                        } else {
                                            echo "<div>No description yet</div>";
                                        }
                                        ?>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Your inventory</label>
                                        <select class="select2bs4" name="my_item[]" multiple="multiple" data-placeholder="Select your item" style="width: 100%;">
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
                                        <select class="select2bs4" name="his_item[]" multiple="multiple" data-placeholder="Select his/her item" style="width: 100%;">
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
                            <button type="submit" class="btn btn-primary" id="btnsave">Save</button>
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
        .profile-pic-box{
            /*border-radius: 3996px;*/
        }

        .profile-pic{
            width: 192px;
            height: 192px;
            /*            width: 142px;
                        height: 142px;*/
            object-fit: cover;
        }

        .profile-pic-small{
            width: 52px;
            height: 52px;
            /*            width: 142px;
                        height: 142px;*/
            object-fit: cover;
        }

        .model-profile-pic{
            width: 112px;
            height: 112px;
            /*            width: 142px;
                        height: 142px;*/
            object-fit: cover;
        }
    </style>
</html>