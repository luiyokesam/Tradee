<?php
include '../include/header.php';

if (isset($_SESSION['loginuser']['userid'])) {
    echo '<script>window.location.href = "../user/profile.php";</script>';
    exit();
}

//$q = "SELECT * FROM customer_address ca, customer c WHERE (ca.custid = $_SESSION['profile']['custid']) AND active IS NULL";
//$q = "SELECT * FROM customer_address ca, customer c WHERE (ca.custid = c.custid) AND c.active IS NULL";
//$r = mysqli_query($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));
//
//if (@mysqli_num_rows($r) == 1) {
//    // Register the values:
//    $_SESSION['profile'] = mysqli_fetch_array($r, MYSQLI_ASSOC);
//    mysqli_free_result($r);
//    mysqli_close($dbc);
//
//    // Redirect the user:
//    $url = '../php/index.php';
//    ob_end_clean();
//    header("Location: $url");
//    exit();
//}
//else {
//    echo '<p class="error">Either the email address and password entered do not match those on file or you have not yet activated your account.</p>';
//}
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="../bootstrap/plugins/select2/css/select2.min.css">
        <link rel="stylesheet" href="../bootstrap/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
        <title>My profile - Tradee</title>
    </head>
    <body>
        <div class="container-lg">
            <div class="row my-3 py-3">
                <div class="col-lg-3 profile-pic-box float-start align-items-center justify-content-center text-center">
                    <?php
                    if ($_SESSION['loginuser']) {
                        if ($_SESSION['loginuser']['avatar'] != null) {
                            echo "<img src='{$_SESSION['loginuser']['avatar']}' class='rounded-pill img-fluid profile-pic' alt='Avatar'>";
                        } else {
                            echo "<img src='../img/login/anonymous.png' class='rounded-pill img-fluid profile-pic' alt='Avatar'>";
                        }
                    }
                    ?>
                </div>

                <div class="col-lg-9">
                    <div class="row">
                        <div class="col-9 py-3">
                            <?php
                            if ($_SESSION['loginuser']) {
                                echo "<div>{$_SESSION['loginuser']['username']}</div>";
                            } else {
                                echo "<div style='font-weight:bold;'>Username</div>";
                            }
                            ?>
                            <?php
                            if ($_SESSION['loginuser']['review'] !== null) {
                                echo "<div>{$_SESSION['loginuser']['review']}</div>";
                            } else {
                                echo "<div style='font-weight:bold;'>No reviews yet</div>";
                            }
                            ?>
                        </div>

                        <div class="col-3 py-3">
                            <a class="btn btn-outline-primary" href="../user/setting_profile.php" role="button">Edit profile</a>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-9">
                            <div class="my-2">
                                <div>Joined date</div>
                                <?php
                                if ($_SESSION['loginuser']) {
                                    echo "<div>{$_SESSION['loginuser']['registration_date']}</div>";
                                }
                                ?>
                            </div>

                            <div class="my-2">
                                <div>Location</div>
                                <?php
                                if (isset($_SESSION['loginuser'])) {
                                    echo "<div>{$_SESSION['loginuser']['state']}, {$_SESSION['loginuser']['country']}</div>";
                                    echo "<div>";
                                    if ($_SESSION['loginuser']['state'] != null){
                                        echo "{$_SESSION['loginuser']['state']}";
                                        if ($_SESSION['loginuser']['country'] != null){
                                            echo $_SESSION['loginuser']['country'];
                                        }
                                    }
                                    echo "</div>";
                                } else {
                                    echo "<div style='font-weight:bold;'>No state shown</div>";
                                }
                                ?>
                            </div>
                        </div>

                        <div class="col-3 py-3">
                            <a class="btn btn-outline-primary" href="../user/upload_auction.php" role="button">Create Auction</a>
                        </div>
                    </div>

                    <div class="col py-3 px-0">
                        <div>Description</div>
                        <?php
                        if ($_SESSION['loginuser']['description'] !== null) {
                            echo "<div>{$_SESSION['loginuser']['description']}</div>";
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
                </div>
            </nav>

            <div class="tab-content" id="nav-tabContent">
                <!--tab 1-->
                <div class="tab-pane fade show active" id="nav-inventory" role="tabpanel">
                    <?php
                    $get_inventory = "SELECT * FROM item i, customer c, item_image m  WHERE c.custid = '{$_SESSION['loginuser']['custid']}' AND i.custid = c.custid AND i.itemid = m.itemid";
                    $result = $dbc->query($get_inventory);
                    if ($result->num_rows > 0) {
                        echo "<div class = 'container-lg'>"
                        . "<div class='row row-cols-xl-5 row-cols-lg-4 row-cols-md-3 row-cols-sm-2 row-cols-1'>";
                        while ($row = mysqli_fetch_array($result)) {
                            echo "<div class='col px-1 py-2'>"
//                            . "<a href='../user/profile.php?id=" . $row["custid"] . "' style='text-decoration:none;'>"
                            . "<ul class='list-inline mb-0 p-1'>"
//                            . "<img src=" . $row["avatar"] . " class='' style='width: 22px;' alt='Avatar'>"
//                            . "<li class='list-inline-item' style='font-size:0.7em; color:#969696;'>" . $row["username"] . "</li>"
                            . "</ul>"
//                            . "</a>"
                            . "<div class='item-img-box overflow-hidden'>"
                            . "<a href='../user/upload_item.php?id=" . $row["itemid"] . "'>"
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

                <!--tab 2-->
                <div class="tab-pane fade" id="nav-reviews" role="tabpanel">
                    <div class="text-center p-5" style="height:350px;">
                        <i class="far fa-star p-5" style="font-size:5em; color: #969696; text-shadow: -2px 8px 4px #000000;"></i>
                        <div class="">Collecting reviews takes time, so check back soon</div>
                    </div>
                </div>
            </div>
        </div>
        <?php include '../include/footer.php'; ?>
    </body>
    <script src="../bootstrap/plugins/select2/js/select2.full.min.js"></script>
    <script>
        $(function () {
            //Initialize Select2 Elements
            $('.select2').select2()

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        })
    </script>
    <style>
        /*item*/
        .item-img-box{
            /*width: 192px;*/
            /*height: 192px;*/
            /*background: #e8e8e8;*/
            /*max-width: 255px;*/
            max-height: 370px;
            background: whitesmoke;
            text-align: center;
            background-size: cover;
            object-fit: cover;
        }

        .item-img{
            max-height: 300px;
            text-align: center;
            background-size: contain;
            background-repeat:   no-repeat;
            background: whitesmoke;
        }

        .fa-heart:hover{
            color: red;
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