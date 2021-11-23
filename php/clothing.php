<?php
include '../include/header.php';

$category_array = array();
$sql1 = "SELECT name FROM category";
$result1 = $dbc->query($sql1);
if ($result1->num_rows > 0) {
    while ($row1 = mysqli_fetch_array($result1)) {
        $category_array[] = $row1['name'];
    }
}

$brand_array = array();
$sql2 = "SELECT DISTINCT(brand) FROM item";
$result2 = $dbc->query($sql2);
if ($result2->num_rows > 0) {
    while ($row2 = mysqli_fetch_array($result2)) {
        $brand_array[] = $row2['brand'];
    }
}

if (isset($_GET['search'])) {
    $search = $_GET['search'];
    if (isset($_GET['sort'])) {
        if ($_GET['sort'] == 0) {
            $sql = "SELECT * FROM item WHERE itemname LIKE '%$search%' AND itemActive = 'Available' ORDER BY date_release";
        } else if ($_GET['sort'] == 1) {
            $sql = "SELECT * FROM item WHERE itemname LIKE '%$search%' AND itemActive = 'Available' ORDER BY actual_price";
        } else if ($_GET['sort'] == 2) {
            $sql = "SELECT * FROM item WHERE itemname LIKE '%$search%' AND itemActive = 'Available' ORDER BY actual_price DESC";
        } else {
            $sql = "SELECT * FROM item WHERE itemname LIKE '%$search%' AND itemActive = 'Available'";
        }
    } else {
        $sql = "SELECT * FROM item WHERE itemname LIKE '%$search%' AND itemActive = 'Available' ORDER BY postDate";
    }
} else if (isset($_GET['condition'])) {
    $condition = $_GET['condition'];
    if (isset($_GET['sort'])) {
        if ($_GET['sort'] == 0) {
            $sql = "SELECT * FROM item WHERE itemCondition = '$condition' AND itemActive = 'Available' ORDER BY date_release";
        } else if ($_GET['sort'] == 1) {
            $sql = "SELECT * FROM item WHERE itemCondition = '$condition' AND itemActive = 'Available' ORDER BY actual_price";
        } else if ($_GET['sort'] == 2) {
            $sql = "SELECT * FROM item WHERE itemCondition = '$condition' AND itemActive = 'Available' ORDER BY actual_price DESC";
        } else {
            $sql = "SELECT * FROM item WHERE itemCondition = '$condition' AND itemActive = 'Available'";
        }
    } else {
        $sql = "SELECT * FROM product WHERE itemCondition = '$condition' AND activation=1 ORDER BY date_release";
    }
} else {
    if (isset($_GET['brand'])) {
        if ($_GET['sort'] == 0) {
            $sql = "SELECT * FROM item WHERE activation=1 ORDER BY date_release";
        } else if ($_GET['sort'] == 1) {
            $sql = "SELECT * FROM item WHERE activation=1 ORDER BY actual_price";
        } else if ($_GET['sort'] == 2) {
            $sql = "SELECT * FROM item WHERE activation=1 ORDER BY actual_price DESC";
        } else {
            $sql = "SELECT * FROM item WHERE activation=1 ORDER BY date_release";
        }
    } else {
        $sql = "SELECT * FROM item WHERE activation=1 ORDER BY date_release";
    }
}
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Home - Tradee</title>
    </head>
    <body class="bg-white">
        <div class="container-lg" style="min-height: 680px;">
            <div class="row">
                <div class="col-md-12 mb-0">
                    <form class="d-flex mt-1 mb-3">
                        <input class="form-control mr-2" type="text" id="search" placeholder="Search"  value="<?php
                        if (isset($_GET['search'])) {
                            echo $_GET['search'];
                        }
                        ?>">
                        <button class="btn btn-info" type="button" id="btnsearch" onclick="search()">Search</button>
                    </form>
                </div>

                <div class="col-md-auto mb-0">
                    <div class="form-group row mb-0">
                        <div class="col-md-auto">
                            <label class="col-form-label">Category :</label>
                        </div>

                        <div class="col-md-auto">
                            <select class="custom-select" id="category" onchange="category()">
                                <?php
                                foreach ($category_array as $selection) {
                                    $selected = ($current_data["type"] == $selection) ? "selected" : "";
                                    echo '<option ' . $selected . ' value="' . $selection . '">' . $selection . '</option>';
                                }
                                echo '</select>';
                                ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-md-auto">
                    <div class="form-group row mb-0">
                        <div class="col-md-auto">
                            <label class="col-form-label">Condition :</label>
                        </div>

                        <div class="col-md-auto">
                            <select class="custom-select" id="category" onchange="condition()">
                                <option value="0" <?php
                                if (isset($current_data)) {
                                    if ($current_data["itemCondition"] == "New With Tags") {
                                        echo "selected";
                                    }
                                }
                                ?>>New With Tags</option>
                                <option value="1" <?php
                                if (isset($current_data)) {
                                    if ($current_data["itemCondition"] == "Excellent Used Condition") {
                                        echo "selected";
                                    }
                                }
                                ?>>Excellent Used Condition</option>
                                <option value="2" <?php
                                if (isset($current_data)) {
                                    if ($current_data["itemCondition"] == "Good Used Condition") {
                                        echo "selected";
                                    }
                                }
                                ?>>Good Used Condition</option>
                                <option value="3" <?php
                                if (isset($current_data)) {
                                    if ($current_data["itemCondition"] == "Very Used Condition") {
                                        echo "selected";
                                    }
                                }
                                ?>>Very Used Condition</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-md-auto mb-0">
                    <div class="form-group row mb-0">
                        <div class="col-md-auto">
                            <label class="col-form-label">Brand :</label>
                        </div>

                        <div class="col-md-auto">
                            <select class="custom-select" id="category" onchange="category()">
                                <?php
                                foreach ($brand_array as $selection) {
                                    $selected = ($current_data["type"] == $selection) ? "selected" : "";
                                    echo '<option ' . $selected . ' value="' . $selection . '">' . $selection . '</option>';
                                }
                                echo '</select>';
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row row-cols-xl-5 row-cols-lg-4 row-cols-md-3 row-cols-sm-2 row-cols-1 mb-2">
                <!--                <div class="col px-1 py-2">
                                    <a href="../user/profile.php" style="text-decoration:none;">
                                        <ul class="list-inline mb-0 p-1">
                                            <img src="../img/header/user-icon.png" class="" style="width: 22px;" alt="...">
                                            <li class="list-inline-item" style="font-size:0.7em; color:#969696;">Username</li>
                                        </ul>
                                    </a>
                                    <div class="item-img-box overflow-hidden">
                                        <a href="../user/item_profile.php">
                                            <img src="../img/test-shirt/test_shirt_5.jpg" class="img-fluid item-img" alt="...">
                                        </a>
                                    </div>
                                    <div class="d-flex bd-highlight align-items-center pt-1 px-1">
                                        <div class="flex-grow-1 bd-highlight" style="font-size:0.8em;">Item Name</div>
                                        <div class="d-flex bd-highlight align-items-center">
                                            <i class="far fa-heart me-auto" style="font-size:0.9em;"></i>
                                            <i class="fas fa-heart me-auto" style="font-size:0.9em;"></i>
                                            <div class="flex-grow-1 bd-highlight ps-1" style="font-size:0.8em;"> 2</div>
                                        </div>
                                    </div>
                                                        <div class="d-flex bd-highlight align-items-center p-1 pb-0">
                                                            <div class="flex-grow-1 bd-highlight" style="font-size:0.8em;">Item Name</div>
                                                            <div class="d-flex bd-highlight align-items-center">
                                                                <i class="far fa-heart me-auto" style="font-size:0.9em;"></i>
                                                                <i class="fas fa-heart me-auto" style="font-size:0.9em;"></i>
                                                                <div class="flex-grow-1 bd-highlight ps-1" style="font-size:0.8em;"> 2</div>
                                                            </div>
                                                        </div>
                                    <ul class="list-inline px-1 mb-0">
                                        <div class="float-right bd-highlight" style="font-size:0.7em; color:#969696;">Status</div>
                                        <div class="flex-grow-1 bd-highlight" style="font-size:0.7em; color:#969696;">Size</div>
                                        <div class="flex-grow-1 bd-highlight" style="font-size:0.7em; color:#969696;">Brand</div>
                                    </ul>
                                </div>-->
                <?php
                if (isset($_SESSION['loginuser'])) {
                    $get_inventory = "SELECT * FROM item i, customer c WHERE i.custid = c.custid AND i.itemActive = 'Available' AND c.custid <> '{$_SESSION['loginuser']['custid']}' ORDER BY (i.itemid) DESC";
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
                            . "<div class='d-flex bd-highlight align-items-center pt-1 px-1'>"
                            . "<div class='flex-grow-1 bd-highlight' style='font-size:0.8em;'>" . $row["itemname"] . "</div>"
                            . "<div class='d-flex bd-highlight align-items-center'>"
                            . "<i class='far fa-heart me-auto' style='font-size:0.9em;'></i>"
                            . "</div>"
                            . "</div>"
                            . "<ul class='list-inline px-1 mb-0'>"
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
                            . "<img src=" . $row["avatar"] . " class='rounded-pill mr-1' style='width: 23px; height: 23px;' alt='Avatar'>"
                            . "<li class='list-inline-item' style='font-size:0.7em; color:#969696;'>" . $row["username"] . "</li>"
                            . "</ul>"
                            . "</a>"
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
        <?php include '../include/footer.php'; ?>
    </body>
    <style>
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
    </style>
</html>