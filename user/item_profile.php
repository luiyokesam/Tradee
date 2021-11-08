<?php
include '../include/header.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM item i, customer c WHERE i.custid = c.custid AND itemid = '$id' LIMIT 1";
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
    $sql_trade = "INSERT INTO trade(tradeid, offerCustID, acceptCustID, acceptPayment, offerPayment, date, status) VALUES ("
            . "'" . $newid . "',"
            . "'" . $_SESSION['loginuser']['custid'] . "',"
            . "'" . $current_data['custid'] . "',"
            . "'Pending',"
            . "'Pending',"
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
                    <div class="col-12 img-container">
                        <img src="../bootstrap/dist/img/prod-5.jpg" class="active-image" alt="Product Image">
                    </div>
                    <div class="col-12 product-image-thumbs">
                        <div class="product-image-thumb product-small-img"><img src="../img/test-shirt/test_shirt_5.jpg" alt="Product Image"></div>
                        <div class="product-image-thumb product-small-img"><img src="../img/test-shirt/test_shirt_6.jpg" alt="Product Image"></div>
                        <div class="product-image-thumb product-small-img"><img src="../img/test-shirt/test_shirt_7.jpg" alt="Product Image"></div>
                        <div class="product-image-thumb product-small-img"><img src="../img/test-shirt/test_shirt_8.jpg" alt="Product Image"></div>
                        <div class="product-image-thumb product-small-img active"><img src="../img/test-shirt/test_shirt_9.jpg" alt="Product Image"></div>
                    </div>

                    <!--                                        <div class="product">
                                                                <div class="col-12 img-container">
                                                                    <img class="" src="../img/test-shirt/test_shirt_5.jpg" id="imageBox" onclick="imageGallery(this)">
                                                                </div>
                                        
                                                                <div class="product-small-img mt-3">
                                                                    <img class="mb-2" src="../img/test-shirt/test_shirt_5.jpg" onclick="imageGallery(this)">
                                                                    <img class="mb-2" src="../img/test-shirt/test_shirt_6.jpg" onclick="imageGallery(this)">
                                                                    <img class="mb-2" src="../img/test-shirt/test_shirt_7.jpg" onclick="imageGallery(this)">
                                                                    <img class="mb-2" src="../img/test-shirt/test_shirt_8.jpg" onclick="imageGallery(this)">
                                                                </div>
                                                            </div>-->
                </div>

                <div class="col-xxl-3 col-xl-4 col-lg-4 my-1">
                    <div class="bg-white px-3 py-2 border">
                        <div class="row">
                            <div class="col-lg-12 col-sm-6">
                                <div class="row">
                                    <div class="col-lg-5 col-3 item-title">Brand</div>
                                    <div class="col item-value"><?php
                                        if (isset($current_data)) {
                                            echo $current_data['brand'];
                                        }
                                        ?></div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-5 col-3 item-title">Condition</div>
                                    <div class="col item-value"><?php
                                        if (isset($current_data)) {
                                            echo $current_data['itemCondition'];
                                        }
                                        ?></div>
                                </div>

                                <!--                                <div class="row">
                                                                    <div class="col-lg-5 col-3 item-title">Size</div>
                                                                    <div class="col item-value">L</div>
                                                                </div>-->

                                <div class="row">
                                    <div class="col-lg-5 col-3 item-title">Quantity</div>
                                    <div class="col item-value"><?php
                                        if (isset($current_data)) {
                                            echo $current_data['quantity'];
                                        }
                                        ?></div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-5 col-3 item-title">Value</div>
                                    <div class="col item-value"><?php
                                        if (isset($current_data)) {
                                            echo $current_data['value'];
                                        }
                                        ?></div>
                                </div>

                                <!--                                <div class="row">
                                                                    <div class="col-lg-5 col-3 item-title">Color</div>
                                                                    <div class="col item-value">White</div>
                                                                </div>-->
                            </div>

                            <div class="col-lg-12 col-sm-6">
                                <?php
                                if (isset($current_data['state']) AND ($current_data['country']) !== null) {
                                    echo "<div class='row pt-lg-2'>"
                                    . "<div class='col-lg-5 col-3 item-title'>Location</div>"
                                    . "<div class='col item-value'>" . ($current_data['state']) . ", " . ($current_data['country']) . "</div>"
                                    . "<div class='col item-value'>"
                                    . "</div>"
                                    . "</div>";
                                }
                                ?>

                                <div class="row pt-lg-2">
                                    <div class="col-lg-5 col-3 item-title">Location</div>
                                    <div class="col item-value">Setapak, Selangor</div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-5 col-3 item-title">Trade option</div>
                                    <div class="col item-value"><?php
                                        if (isset($current_data)) {
                                            echo $current_data['tradeOption'];
                                        }
                                        ?></div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-5 col-3 item-title">Uploaded</div>
                                    <div class="col item-value">3 days ago</div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-5 col-3 item-title">Uploaded</div>
                                    <div class="col item-value"><?php
                                        if (isset($current_data)) {
                                            echo $current_data['postDate'];
                                        }
                                        ?></div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-5 col-3 item-title">Trade Item</div>
                                    <div class="col item-value"><?php
                                        if (isset($current_data)) {
                                            echo $current_data['tradeItem'];
                                        }
                                        ?></div>
                                </div>
                            </div>
                        </div>

                        <div class="pt-3 border-bottom"></div>

                        <div class="row pt-3">
                            <div class="col-lg-12 col-md-7">
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
                                <div class='py-1'>
                                    <a class="btn btn-block btn-outline-primary" data-toggle="modal" data-target="#modal-bid-item">Trade now</a>
                                </div>
                                <div class='py-1'>
                                    <a type="button" class="btn btn-outline-info btn-block" href=""><i class="far fa-heart"></i> Add to favourite</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-3 border" style="box-shadow: none; border-radius: 0px;">
                        <a href='../user/profile.php?id=" . $row["custid"] . "' style='text-decoration:none;'>
                            <!--<a class="px-3 py-2 border-bottom align-items-center" href='../user/profile.php?id=" . $current_data["custid"] . "'">-->
                            <?php echo "<a class='px-3 py-2 border-bottom align-items-center' href='../user/profile.php?id=" . $current_data["custid"] . "'>" ?>
                            <div class="float-left">
                                <img src="../img/header/user-icon.png" class="m-2" style="width: 35px;" alt="...">
                            </div>
                            <div class="align-items-center m-2">
                                <div class="row align-items-center">
                                    <div class="col-12" style="font-size:0.8em; text-decoration: none;"><?php
                                        if (isset($current_data)) {
                                            echo $current_data['username'];
                                        }
                                        ?></div>
                                    <div class="col-12" style="font-size:0.9em;">
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
                                    <i class="fas fa-map-marker-alt" style="font-size:px;color:#AFEEEE"></i>
                                    <!--<i class="material-icons" style="font-size:48px;color:#AFEEEE">location_on</i>-->
                                </div>
                                <div class="col" style="font-size:0.8em;">Kuala Lumpur, Malaysia</div>
                            </div>

                            <div class ="row pt-2 align-items-center">
                                <div class="col-1">
                                    <i class="far fa-clock" style="color:#AFEEEE"></i>
                                    <!--<i class="material-icons" style="font-size:40px;padding-left:7px;color:#AFEEEE">rate_review</i>-->
                                </div>
                                <div class="col" style="font-size:0.8em;"><?php
                                    if (isset($current_data)) {
                                        echo $current_data['registration_date'];
                                    }
                                    ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class='row'>
                <div class='col-lg-9'>
                    <div class="border-bottom" style="font-size:1.8em;">You may also like</div>
                    <div class="row row-cols-md-3 row-cols-sm-2">
                        <div class="col px-1 py-2">
                            <a href="../user/profile.php" style="text-decoration:none;">
                                <ul class="list-inline mb-0 p-1">
                                    <img src="../img/header/user-icon.png" class="" style="width: 22px;" alt="...">
                                    <li class="list-inline-item" style="font-size:0.7em; color:#969696;">Username</li>
                                </ul>
                            </a>
                            <div class="item-img-box">
                                <a href="../user/item_portfolio.php">
                                    <img src="../img/test-shirt/test_shirt_5.jpg" class="item-img" alt="...">
                                </a>
                            </div>
                            <div class="d-flex bd-highlight align-items-center p-1 pb-0">
                                <div class="flex-grow-1 bd-highlight" style="font-size:0.8em;">Item Name</div>
                                <div class="d-flex bd-highlight align-items-center">
                                    <i class="far fa-heart me-auto" style="font-size:0.9em;"></i>
                                    <!--<i class="fas fa-heart me-auto" style="font-size:0.9em;"></i>-->
                                    <div class="flex-grow-1 bd-highlight ps-1" style="font-size:0.8em;"> 2</div>
                                </div>
                            </div>
                            <ul class="list-inline p-1 pt-0 mb-0">
                                <div class="flex-grow-1 bd-highlight" style="font-size:0.7em; color:#969696;">Size</div>
                                <div class="flex-grow-1 bd-highlight" style="font-size:0.7em; color:#969696;">Brand</div>
                            </ul>
                        </div>
                        <div class="col px-1 py-2">
                            <a href="../user/profile.php" style="text-decoration:none;">
                                <ul class="list-inline mb-0 p-1">
                                    <img src="../img/header/user-icon.png" class="" style="width: 22px;" alt="...">
                                    <li class="list-inline-item" style="font-size:0.7em; color:#969696;">Username</li>
                                </ul>
                            </a>
                            <div class="item-img-box">
                                <a href="../user/item_portfolio.php">
                                    <img src="../img/test-shirt/test_shirt_3.jpg" class="item-img" alt="...">
                                </a>
                            </div>
                            <div class="d-flex bd-highlight align-items-center p-1 pb-0">
                                <div class="flex-grow-1 bd-highlight" style="font-size:0.8em;">Item Name</div>
                                <div class="d-flex bd-highlight align-items-center">
                                    <i class="far fa-heart me-auto" style="font-size:0.9em;"></i>
                                    <div class="flex-grow-1 bd-highlight ps-1" style="font-size:0.8em;"> 2</div>
                                </div>
                            </div>
                            <ul class="list-inline p-1 pt-0 mb-0">
                                <div class="flex-grow-1 bd-highlight" style="font-size:0.7em; color:#969696;">Size</div>
                                <div class="flex-grow-1 bd-highlight" style="font-size:0.7em; color:#969696;">Brand</div>
                            </ul>
                        </div>
                        <div class="col px-1 py-2">
                            <a href="../user/profile.php" style="text-decoration:none;">
                                <ul class="list-inline mb-0 p-1">
                                    <img src="../img/header/user-icon.png" class="" style="width: 22px;" alt="...">
                                    <li class="list-inline-item" style="font-size:0.7em; color:#969696;">Username</li>
                                </ul>
                            </a>
                            <div class="item-img-box">
                                <a href="../user/item_portfolio.php">
                                    <img src="../img/test-shirt/test_shirt_4.jpg" class="item-img" alt="...">
                                </a>
                            </div>
                            <div class="d-flex bd-highlight align-items-center p-1 pb-0">
                                <div class="flex-grow-1 bd-highlight" style="font-size:0.8em;">Item Name</div>
                                <div class="d-flex bd-highlight align-items-center">
                                    <i class="far fa-heart me-auto" style="font-size:0.9em;"></i>
                                    <div class="flex-grow-1 bd-highlight ps-1" style="font-size:0.8em;"> 2</div>
                                </div>
                            </div>
                            <ul class="list-inline p-1 pt-0 mb-0">
                                <div class="flex-grow-1 bd-highlight" style="font-size:0.7em; color:#969696;">Size</div>
                                <div class="flex-grow-1 bd-highlight" style="font-size:0.7em; color:#969696;">Brand</div>
                            </ul>
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
                            <button type="submit" class="btn btn-offer" id="btnsave">Send offer</button>
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
        .product-image-thumb{
            max-width: none;
        }

        .product-small-img img{
            max-height: 120px;
            max-width: 120px;
            cursor: pointer;
            opacity: 0.6;
            /*display: block;*/
        }

        .product-small-img img:hover{
            opacity: 1;
        }

        .product-small-img{
            /*float: left;*/
        }

        .product{
            /*top: 30%;*/
            /*left: 30%;*/
            /*transform: translate(-50%, -50%);*/
            /*position: absolute;*/
        }

        .img-container img{
            max-height: 500px;
            max-width: 600px;
            width: 100%;
        }

        .img-container{
            height: 500px;
            /*width: 600px;*/
            /*float: right;*/
            /*padding: 10px;*/
            text-align: center;
            /*background-color: whitesmoke;*/
        }

        thead tr th, tfoot tr th{
            text-align: center;
        }

        .checked {
            color: orange;
        }

        .item-img-box{
            /*width: 192px;*/
            /*height: 192px;*/
            /*            width: 142px;
                        height: 142px;*/
            background: #e8e8e8;
            text-align: center;
            object-fit: cover;
        }

        .item-img{
            /*            width: 230px;
                        height: 350px*/
            /*width: 100%;*/
            /*min-height: 370px;*/
            /*max-height: 370px;*/
            /*background-size: 100% 100%;*/
            max-width: 238px;
            /*min-height: 370px;*/
            max-height: 370px;
            background-size: 100% 100%;
        }

        .fa-heart:hover{
            color: red;
        }

        .item-title{
            font-size:0.8em; 
            color:#969696;
        }

        .item-value{
            font-size:0.8em; 
            color: #001226;
        }

        .profile-pic-box{
            /*border-radius: 3996px;*/
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
    </style>
</html>