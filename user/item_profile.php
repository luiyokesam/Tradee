<?php
include '../include/header.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM item i, customer c WHERE i.custid = c.custid AND itemid = '$id' LIMIT 1";
    $result = $dbc->query($sql);
    if ($result->num_rows > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $current_data = $row;
            $Array_Image = array();
            $sql2 = "SELECT `img` FROM `item_image` WHERE `itemid` = '$id'";
            $result2 = $dbc->query($sql2);
            if ($result2->num_rows > 0) {
                while ($row = mysqli_fetch_array($result2)) {
                    array_push($Array_Image, $row[0]);
                }
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
        <title><?php
            if (isset($current_data)) {
                echo $current_data['itemname'];
            }
            ?> - Tradee</title>
        <link rel="stylesheet" href="../bootstrap/plugins/select2/css/select2.min.css">
        <link rel="stylesheet" href="../bootstrap/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    </head>
    <body class="">
        <div class="bg-navbar mb-3 bg-light">
            <div class="container-xl">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb py-2 mb-0">
                        <li class="breadcrumb-item"><a href="../php/index.php">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?php
                            if (isset($current_data)) {
                                echo $current_data['catname'];
                            }
                            ?>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="container-lg">
            <div class="row pb-3">
                <div class="col-xxl-9 col-xl-8 col-lg-8 my-1">
                    <div class="col-12 img-container" style="width: 500px; height: 500px">
                        <img src="<?php
                        if (isset($Array_Image)) {
                            echo $Array_Image[0];
                        }
                        ?>" class="active-image" style="max-width: 500px; max-height: 500px" alt="Product Image">
                    </div>

                    <div class="col-12 product-image-thumbs mt-3">
                        <div class="product-image-thumb product-small-img mr-2 p-1 active" style="width: 80px; max-width: 80px; height: 80px; max-height: 80px;">
                            <img class="img-fluid" src="<?php
                            if (isset($Array_Image)) {
                                echo $Array_Image[0];
                            }
                            ?>" alt="Photo" style="height: auto; max-height: 70px; width: 70px; max-width: 70px" id="img_display0" name="img_display">
                        </div>

                        <div class="product-image-thumb product-small-img mr-2 p-1" style="width: 80px; max-width: 80px; height: 80px; max-height: 80px;">
                            <img class="img-fluid" src="<?php
                            if (isset($Array_Image)) {
                                echo $Array_Image[1];
                            }
                            ?>" alt="Photo" style="height: auto; max-height: 70px; width: 70px; max-width: 70px" id="img_display1" name="img_display">
                        </div>

                        <div class="product-image-thumb product-small-img mr-2 p-1" style="width: 80px; max-width: 80px; height: 80px; max-height: 80px;">
                            <img class="img-fluid" src="<?php
                            if (isset($Array_Image)) {
                                echo $Array_Image[2];
                            }
                            ?>" alt="Photo" style="height: auto; max-height: 70px; width: 70px; max-width: 70px" id="img_display2" name="img_display">
                        </div>

                        <div class="product-image-thumb product-small-img mr-2 p-1" style="width: 80px; max-width: 80px; height: 80px; max-height: 80px;">
                            <img class="img-fluid" src="<?php
                            if (isset($Array_Image)) {
                                echo $Array_Image[3];
                            }
                            ?>" alt="Photo" style="height: auto; max-height: 70px; width: 70px; max-width: 70px" id="img_display3" name="img_display">
                        </div>

                        <div class="product-image-thumb product-small-img mr-2 p-1" style="width: 80px; max-width: 80px; height: 80px; max-height: 80px;">
                            <img class="img-fluid" src="<?php
                            if (isset($Array_Image)) {
                                echo $Array_Image[4];
                            }
                            ?>" alt="Photo" style="height: auto; max-height: 70px; width: 70px; max-width: 70px" id="img_display4" name="img_display">
                        </div>
                    </div>
                </div>

                <div class="col-xxl-3 col-xl-4 col-lg-4 my-1">
                    <div class="bg-white px-3 py-2 border">
                        <div class="row">
                            <div class="col-lg-12 col-sm-6">
                                <div class="row">
                                    <div class="col-lg-5 col-3 item-title">Brand</div>
                                    <div class="col item-value">
                                        <?php
                                        if (isset($current_data)) {
                                            echo $current_data['brand'];
                                        }
                                        ?>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-5 col-3 item-title">Condition</div>
                                    <div class="col item-value">
                                        <?php
                                        if (isset($current_data)) {
                                            echo $current_data['itemCondition'];
                                        }
                                        ?>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-5 col-3 item-title">Size</div>
                                    <div class="col item-value">
                                        <?php
                                        if (isset($current_data)) {
                                            echo $current_data['size'];
                                        }
                                        ?>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-5 col-3 item-title">Value</div>
                                    <div class="col item-value">
                                        <?php
                                        if (isset($current_data)) {
                                            echo $current_data['value'];
                                        }
                                        ?>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-5 col-3 item-title">Color</div>
                                    <div class="col item-value">
                                        <?php
                                        if (isset($current_data)) {
                                            echo $current_data['colour'];
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12 col-sm-6">
                                <?php
                                if (isset($current_data['state']) AND ($current_data['country']) !== null) {
                                    echo "<div class='row pt-lg-2'>"
                                    . "<div class='col-lg-5 col-3 item-title'>Location</div>"
                                    . "<div class='col item-value'>" . ($current_data['state']) . ", " . ($current_data['country']) . "</div>"
                                    . "</div>";
                                }
                                ?>

                                <div class="row">
                                    <div class="col-lg-5 col-3 item-title">Trade option</div>
                                    <div class="col item-value"><?php
                                        if (isset($current_data)) {
                                            echo $current_data['tradeOption'];
                                        }
                                        ?>
                                    </div>
                                </div>

                                <!--                                <div class="row">
                                                                    <div class="col-lg-5 col-3 item-title">Uploaded</div>
                                                                    <div class="col item-value" style="color: red;">
                                <?php
//                                        if (isset($current_data)) {
//                                            date_default_timezone_set('Etc/GMT+8');
////                                            $today0 = new DateTime();
////                                            $today = strtotime("d/m/Y", $today0);
//
//                                            $date1 = new DateTime($current_data['postDate']);
//                                            $date2 = new DateTime();
//                                            $interval = $date1->diff($date2);
//                                            echo '<script>alert("' . $interval->d . '");</script>';
//
////                                            $postdate = new DateTime($current_data['postDate']);
////                                            $time = strtotime("d/m/Y", $current_data['postDate']);
////                                            echo '<script>alert("' . $today . '");</script>';
////                                            $now = $today - $postdate;
////                                            $day = $now / (1000 * 60 * 60 * 24);
//                                            echo $day;
//                                        }
                                ?>
                                                                    </div>
                                                                </div>-->

                                <div class="row">
                                    <div class="col-lg-5 col-3 item-title">Uploaded</div>
                                    <div class="col item-value">
                                        <?php
                                        if (isset($current_data)) {
                                            echo $current_data['postDate'];
                                        }
                                        ?>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-5 col-3 item-title">Trade Item</div>
                                    <div class="col item-value">
                                        <?php
                                        if (isset($current_data)) {
                                            echo $current_data['tradeItem'];
                                        }
                                        ?>
                                    </div>
                                </div>

                                <?php
                                if (isset($current_data)) {
                                    if (($current_data['itemActive'] !== 'Available')) {
                                        echo "<div class='row mt-2' style='font-weight: bolder;'>"
                                        . "<div class='col-lg-5 col-3 item-title'>Item Status</div>"
                                        . "<div class='col item-value' style='color: red;'>"
                                        . "{$current_data['itemActive']}"
                                        . "</div>"
                                        . "</div>";
                                    }
                                }
                                ?>
                            </div>
                        </div>

                        <div class="mt-2 border-bottom"></div>

                        <div class="row mt-2">
                            <div class="col-lg-12 col-md-7 mb-2">
                                <div class="" style="font-size:1em;"><?php
                                    if (isset($current_data)) {
                                        echo $current_data['itemname'];
                                    }
                                    ?></div> 
                                <div class="text-justify item-value">
                                    <?php
                                    if (isset($current_data)) {
                                        echo $current_data['itemDescription'];
                                    }
                                    ?>
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-5">
                                <?php
                                if (isset($current_data)) {
                                    if (($current_data['itemActive'] == 'Available')) {
                                        if (isset($_SESSION['loginuser'])) {
                                            if ($_SESSION['loginuser']['custid'] !== $current_data['custid']) {
                                                echo "<div class='py-1'>"
                                                . "<button class='btn btn-block btn-trade-now' data-toggle='modal' data-target='#modal-bid-item'>Trade now</button>"
                                                . "</div>";
                                            }
                                        }
                                    }
                                }
                                ?>
                                <div class='py-1'>
                                    <?php
                                    if (isset($current_data)) {
                                        if (isset($_SESSION['loginuser'])) {
                                            if ($_SESSION['loginuser']['custid'] !== $current_data['custid']) {
                                                echo "<button class='btn btn-block btn-add-fav btn-light' style='color: red;'><i class='far fa-heart'></i> Favorite</button>";
                                            }
                                        }
                                    }
                                    ?>
                                    <!--<a type="button" class="btn btn-outline-info btn-block" href=""><i class="far fa-heart"></i> Add to favourite</a>-->
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-3 border" style="box-shadow: none; border-radius: 0px;">
                        <?php echo "<a class='py-2 border-bottom align-items-center' href='../user/profile.php?id=" . $current_data["custid"] . "'>" ?>
                        <div class="float-left">
                            <img src="<?php
                            if (isset($current_data)) {
                                echo $current_data['avatar'];
                            }
                            ?>" class="mx-2 rounded-circle" style="width: 45px; height: 45px;" alt="Profile avatar">
                        </div>
                        <div class="align-items-center mx-2" style="color: black;">
                            <div class="row align-items-center">
                                <div class="col-12" style="font-size:0.85em; text-decoration: none;"><?php
                                    if (isset($current_data)) {
                                        echo $current_data['username'];
                                    }
                                    ?></div>
                                <div class="col-12" style="font-size:0.8em;">
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star"></span>
                                </div>
                            </div>
                        </div>
                        </a>

                        <div class="card-body px-3 py-2">
                            <div class="row align-items-center">
                                <div class="col-1">
                                    <i class="fas fa-map-marker-alt" style="color: #09B1BA;"></i>
                                    <!--<i class="material-icons" style="font-size:48px;color:#AFEEEE">location_on</i>-->
                                </div>
                                <div class="col" style="font-size: 0.85em;"><?php
                                    if (isset($current_data)) {
                                        echo "{$current_data['state']}, {$current_data['country']}";
                                    }
                                    ?>
                                </div>
                            </div>

                            <div class ="row pt-2 align-items-center">
                                <div class="col-1">
                                    <i class="far fa-clock" style="color: #09B1BA"></i>
                                    <!--<i class="material-icons" style="font-size:40px;padding-left:7px;color:#AFEEEE">rate_review</i>-->
                                </div>
                                <div class="col" style="font-size: 0.85em;"><?php
                                    if (isset($current_data)) {
                                        echo $current_data['registration_date'];
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class='row mt-2'>
                <div class='col-lg-9'>
                    <div class="border-bottom mb-2 pb-2" style="font-size:1.8em;">You may also like</div>
                    <div class="row row-cols-md-3 row-cols-sm-2">
                        <?php
                        if (isset($_SESSION['loginuser'])) {
                            $get_inventory = "SELECT * FROM item i, customer c WHERE i.custid = c.custid AND i.itemActive = 'Available' AND c.custid <> '{$_SESSION['loginuser']['custid']}' AND i.itemid <> '{$current_data['itemid']}' ORDER BY i.itemid DESC";
                            $result = $dbc->query($get_inventory);
                            if ($result->num_rows > 0) {
                                while ($row = mysqli_fetch_array($result)) {
                                    echo "<div class='col px-1 py-2'>"
                                    . "<a href='../user/profile.php?id=" . $row["custid"] . "' style='text-decoration:none;'>"
                                    . "<ul class='list-inline mb-0 p-1'>"
                                    . "<img src=" . $row["avatar"] . " class='rounded-pill mr-1' style='width: 23px; height: 23px;' alt='Avatar'>"
                                    . "<li class='list-inline-item' style='font-size:0.7em; color:#969696;'>" . $row["username"] . "</li>"
                                    . "</ul>"
                                    . "</a>"
                                    . "<div class='item-img-box overflow-hidden'>"
                                    . "<a href='../user/item_profile.php?id=" . $row["itemid"] . "'>"
                                    . "<img src='../data/item_img/" . $row['itemid'] . "_0' class='img-fluid item-img' alt='...'>"
                                    . "</a>"
                                    . "</div>"
                                    . "<div class='d-flex bd-highlight align-items-center p-1 py-0'>"
                                    . "<div class='flex-grow-1 bd-highlight' style='font-size:0.8em;'>" . $row["itemname"] . "</div>"
                                    . "<div class='d-flex bd-highlight align-items-center'>"
                                    . "<i class='far fa-heart me-auto' style='font-size:0.9em;'></i>"
                                    . "</div>"
                                    . "</div>"
                                    . "<ul class='list-inline p-1 py-0 mb-0'>"
//                        . "<div class='float-right bd-highlight' style='font-size:0.7em; color:#969696;'>" . $row["itemActive"] . "</div>"
                                    . "<div class='flex-grow-1 bd-highlight' style='font-size:0.7em; color:#969696;'>" . $row["itemCondition"] . "</div>"
                                    . "<div class='flex-grow-1 bd-highlight' style='font-size:0.7em; color:#969696;'>" . $row["brand"] . "</div>"
                                    . "</ul>"
                                    . "</div>";
                                }
                            }
                        } else {
                            $get_inventory = "SELECT * FROM item i, customer c WHERE i.custid = c.custid AND itemActive = 'Available' ORDER BY i.itemid DESC";
                            $result = $dbc->query($get_inventory);
                            if ($result->num_rows > 0) {
                                while ($row = mysqli_fetch_array($result)) {
                                    echo "<div class='col px-1 py-2'>"
                                    . "<a href='../user/profile.php?id=" . $row["custid"] . "' style='text-decoration:none;'>"
                                    . "<ul class='list-inline mb-0 p-1'>"
                                    . "<img src=" . $row["avatar"] . " class='rounded-pill mr-1' style='width: 22px;' alt='Avatar'>"
                                    . "<li class='list-inline-item' style='font-size:0.7em; color:#969696;'>" . $row["username"] . "</li>"
                                    . "</ul>"
                                    . "</a>"
                                    . "<div class='item-img-box overflow-hidden'>"
                                    . "<a href='../user/item_profile.php?id=" . $row["itemid"] . "'>"
                                    . "<img src='../data/item_img/" . $row['itemid'] . "_0' class='img-fluid item-img' alt='...'>"
                                    . "</a>"
                                    . "</div>"
                                    . "<div class='d-flex bd-highlight align-items-center p-1 pb-0'>"
                                    . "<div class='flex-grow-1 bd-highlight' style='font-size:0.8em;'>" . $row["itemname"] . "</div>"
                                    . "<div class='d-flex bd-highlight align-items-center'>"
                                    . "<i class='far fa-heart me-auto' style='font-size:0.9em;'></i>"
                                    . "</div>"
                                    . "</div>"
                                    . "<ul class='list-inline p-1 pt-0 mb-0'>"
//                        . "<div class='float-right bd-highlight' style='font-size:0.7em; color:#969696;'>" . $row["itemActive"] . "</div>"
                                    . "<div class='flex-grow-1 bd-highlight' style='font-size:0.7em; color:#969696;'>" . $row["itemCondition"] . "</div>"
                                    . "<div class='flex-grow-1 bd-highlight' style='font-size:0.7em; color:#969696;'>" . $row["brand"] . "</div>"
                                    . "</ul>"
                                    . "</div>";
                                }
                            }
                        }
                        ?>
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
                                    ?>" class="rounded-pill img-fluid profile-pic" alt="Profile picture">
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
                                                echo "<div style='font-weight:lighter;'>- No reviews yet.</div>";
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
                                                echo "<div style='font-weight: lighter;'>- Location no shown.</div>";
                                            }
                                            ?>
                                        </div>

                                        <div class="col-lg-4 col-sm-6 mb-1">
                                            <div style="font-weight: bolder;">Trade Count</div>
                                            <?php
                                            $sql = "SELECT COUNT(t.tradeid) NUMBER FROM trade t, customer c WHERE (t.offerCustID = c.custid OR t.acceptCustID = c.custid) AND c.custid = '{$current_data['custid']}'";
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
                                            $sql = "SELECT MAX(t.tradeDate) DATE FROM trade t, customer c WHERE (t.offerCustID = c.custid OR t.acceptCustID = c.custid) AND c.custid = '{$current_data['custid']}'";
                                            $result = $dbc->query($sql);
                                            if ($result->num_rows > 0) {
                                                while ($row = mysqli_fetch_array($result)) {
                                                    $current_offer = $row;
                                                    echo "<div>- {$current_offer['DATE']}</div>";
                                                    break;
                                                }
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
                                                    echo "<div style='font-weight: lighter;'>- No description yet.</div>";
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
                                            $get_item = "SELECT * FROM item WHERE custid = '{$current_data['custid']}' AND itemActive = 'Available' AND itemid = '{$current_data['itemid']}'";
                                            $result_item = $dbc->query($get_item);
                                            if ($result_item->num_rows > 0) {
                                                while ($row = mysqli_fetch_array($result_item)) {
                                                    echo '<option ' . $selected . ' selected="selected" value="' . $row['itemid'] . '">' . $row['itemname'] . '</option>';
                                                }
                                            }

                                            $get_item_available = "SELECT * FROM item WHERE itemActive = 'Available' AND custid = '{$current_data['custid']}' AND itemid != '{$current_data['itemid']}'";
                                            $result_item_available = $dbc->query($get_item_available);
                                            if ($result_item_available->num_rows > 0) {
                                                while ($row = mysqli_fetch_array($result_item_available)) {
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
        $(function () {
            //Initialize Select2 Elements
            $('.select2').select2()

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        })

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

        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0');
        var yyyy = today.getFullYear();
        document.getElementById("todaydate").value = dd + '/' + mm + '/' + yyyy;

        function imageGallery(smallImg) {
            var fullImg = document.getElementById("imageBox");
            fullImg.src = smallImg.src;
        }

        $(document).ready(function () {
            $('.product-image-thumb').on('click', function () {
                var $image_element = $(this).find('img')
                $('.active-image').prop('src', $image_element.attr('src'))
                $('.product-image-thumb.active').removeClass('active')
                $(this).addClass('active')
            })
        })
    </script>
    <script src="../bootstrap/plugins/select2/js/select2.full.min.js"></script>
    <style>
        .product-small-img img:hover{
            opacity: 1;
        }

        /*        .img-container img{
                    max-height: 500px;
                    max-width: 500px;
                    width: 100%;
                }
        
                .img-container{
                    width: 600px;
                    height: 600px;
                    background-color: whitesmoke;
                }*/

        .checked {
            color: orange;
        }

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
            max-height: 250px;
            min-height: 250px;
            /*width: 100%;*/
            /*height: 100%;*/
            text-align: center;
            background-size: contain;
            background-repeat:   no-repeat;
            background: whitesmoke;
        }

        .fa-heart:hover{
            color: red;
        }

        .item-title{
            font-size:0.85em; 
            color:#969696;
        }

        .item-value{
            font-size:0.85em; 
            color: #001226;
        }

        .profile-pic{
            width: 132px;
            height: 132px;
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