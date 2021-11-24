<?php
include '../include/header.php';

$islogin = "";
if (isset($_SESSION['loginuser'])) {
    $islogin = "AND c.custid <> '{$_SESSION['loginuser']['custid']}'";
}

$search = "%";
$category = "%";
$brand = "%";
if (isset($_GET["search"])) {
    $search = '%' . $_GET["search"] . '%';
}
if (isset($_GET["category"])) {
    if ($_GET['category'] != '') {
        $category = $_GET["category"];
    }
}
if (isset($_GET["brand"])) {
    if ($_GET['brand'] != '') {
        $brand = $_GET["brand"];
    }
}

$sql = "SELECT * FROM item i, customer c WHERE i.custid = c.custid AND itemActive = 'Available' AND itemname LIKE '{$search}' AND catname LIKE '{$category}' AND brand LIKE '{$brand}' $islogin ORDER BY i.itemid DESC";
//echo '<script>alert("' . $sql . '");</script>';
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
            <form method="post" id="form">
                <div class="row">
                    <div class="col-md-12 mb-0">
                        <div class="form-group d-flex mt-1 mb-3">
                            <input class="form-control mr-2" type="text" id="search" placeholder="Search" value="<?php
                            if (isset($_GET['search'])) {
                                echo $_GET['search'];
                            }
                            ?>">
                            <button type="button" class="btn btn-info" id="btnsearch" onclick="finditemname()">Search</button>
                        </div>
                    </div>

                    <div class="col-md-auto mb-0">
                        <div class="form-group row mb-0">
                            <div class="col-md-auto">
                                <label class="col-form-label">Category:</label>
                            </div>

                            <div class="col-md-auto">
                                <select class="custom-select" id="category" onchange="filtercategory()">
                                    <option value="">All</option>
                                    <?php
                                    $category_array = array();
                                    $sql1 = "SELECT name FROM category";
                                    $result1 = $dbc->query($sql1);
                                    if ($result1->num_rows > 0) {
                                        while ($row1 = mysqli_fetch_array($result1)) {
                                            $category_array[] = $row1['name'];
                                        }
                                    }
                                    foreach ($category_array as $selection) {
                                        $test1 = "";
                                        if (isset($_GET['category'])) {
                                            if ($_GET['category'] == "$selection") {
                                                $test1 = "selected";
                                            }
                                        }
                                        echo "<option value= " . $selection . " $test1>$selection";
                                        echo "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!--                    <div class="col-md-auto">
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
                                        </div>-->

                    <div class="col-md-auto mb-0">
                        <div class="form-group row mb-0">
                            <div class="col-md-auto">
                                <label class="col-form-label">Brand:</label>
                            </div>

                            <div class="col-md-auto">
                                <select class="custom-select" id="brand" onchange="filterbrand()">
                                    <option value="">All</option>
                                    <?php
                                    $brand_array = array();
                                    $sql2 = "SELECT DISTINCT(brand) FROM item";
                                    $result2 = $dbc->query($sql2);
                                    if ($result2->num_rows > 0) {
                                        while ($row2 = mysqli_fetch_array($result2)) {
                                            $brand_array[] = $row2['brand'];
                                        }
                                    }
                                    foreach ($brand_array as $selection) {
                                        $test2 = "";
                                        if (isset($_GET['brand'])) {
                                            if ($_GET['brand'] == "$selection") {
                                                $test2 = "selected";
                                            }
                                        }
                                        echo "<option value= " . $selection . " $test2>$selection";
                                        echo "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </form>


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
            $result = $dbc->query($sql);
            if ($result->num_rows > 0) {
                echo "<div class='row row-cols-xl-5 row-cols-lg-4 row-cols-md-3 row-cols-sm-2 row-cols-1 mb-2'>";
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
                echo "</div>";
            } else {
                echo "<div class='text-center p-5' style='height:350px;'>"
                . "<i class='fas fa-box-open p-5' style='font-size:5em; color: #969696; text-shadow: -2px 8px 4px #000000;'></i>"
                . "<div class=''>No related item found</div>"
                . "</div>";
            }
            ?>
        </div>
        <?php include '../include/footer.php'; ?>
    </body>
    <script>
        function finditemname() {
            window.location.href = "clothing.php?search=" + document.getElementById("search").value;
        }

        function filtercategory() {
            let params = (new URL(document.location)).searchParams;
            let brand = params.get("brand");

            if (brand !== null) {
                window.location.href = "clothing.php?category=" + document.getElementById('category').value + "&brand=" + brand;
            } else {
                window.location.href = "clothing.php?category=" + document.getElementById('category').value;
            }
        }

        function filterbrand() {
            let params = (new URL(document.location)).searchParams;
            let category = params.get("category");

            if (category !== null) {
                window.location.href = "clothing.php?brand=" + document.getElementById('brand').value + "&category=" + category;
            } else {
                window.location.href = "clothing.php?brand=" + document.getElementById('brand').value;
            }
        }
    </script>
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