<?php
require ('../include/config.inc.php');
include '../include/header.php';

$category_array = array();
$sql = "SELECT name FROM category";
$result = $dbc->query($sql);
if ($result->num_rows > 0) {
    while ($row = mysqli_fetch_array($result)) {
        $category_array[] = $row['name'];
    }
}

?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Home</title>
    </head>
    <body class="bg-white">
        <!--        <div id="carouselExampleDark" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1" aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    </div>
                    <div class="carousel-inner">
                        <div class="carousel-item active" data-bs-interval="10000">
                            <img src="https://mdbootstrap.com/img/Photos/Slides/img%20(35).jpg" class="d-block w-100" alt="...">
                            <div class="carousel-caption d-none d-md-block">
                                <h5>First slide label</h5>
                                <p>Some representative placeholder content for the first slide.</p>
                            </div>
                        </div>
                        <div class="carousel-item" data-bs-interval="2000">
                            <img src="https://mdbootstrap.com/img/Photos/Slides/img%20(33).jpg" class="d-block w-100" alt="..."">
                            <div class="carousel-caption d-none d-md-block">
                                <h5>Second slide label</h5>
                                <p>Some representative placeholder content for the second slide.</p>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <img src="https://mdbootstrap.com/img/Photos/Slides/img%20(31).jpg" class="d-block w-100" alt="..."">
                            <div class="carousel-caption d-none d-md-block">
                                <h5>Third slide label</h5>
                                <p>Some representative placeholder content for the third slide.</p>
                            </div>
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>-->

        <div class="container-lg">
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
                            <select class="custom-select" id="activation" onchange="filter()">
                                <option value="">All</option>
                                <option value="Pending">Pending</option>
                                <option value="Completed">Completed</option>
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

            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                <!--                <div class="col">
                                    <div class="card" style="border: none; border-radius: 0px; box-shadow: none;">
                                        <svg class="bd-placeholder-img card-img-top" width="100%" height="225" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#55595c"></rect><text x="50%" y="50%" fill="#eceeef" dy=".3em">Thumbnail</text></svg>
                                        <img class="" src="../img/event/event_1.jpg">
                                        <div class="card-body px-0 py-2">
                                            <div class="" style="font-size: 1em; font-weight: bold;">1 Jan 2021</div>
                                            <div class="" style="font-size: 1em;">Rumah Charis - Home For The Children</div>
                                            <div class="card-text py-1" style="font-size: 0.9em;">Lot 10064, Jalan Awan Pintal, Taman Yarl, 58200 Kuala Lumpur.</div>
                                            <div class="card-text">Tel: 03-7971 9167</div>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="btn-group">
                                                    <a href="#" type="button" class="btn btn-sm btn-outline-secondary">View</a>
                                                    <button type="button" class="btn btn-sm btn-outline-secondary">Edit</button>
                                                </div>
                                                <small class="text-muted">Tel: 03-7971 9167</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>-->

                <?php
                $get_event = "SELECT * FROM event e WHERE (e.status = 'Pending' OR e.status = 'In-Progress')";
                $result = $dbc->query($get_event);
                if ($result->num_rows > 0) {
                    while ($row = mysqli_fetch_array($result)) {
                        $address = "{$row['address1']}, {$row['address2']}, {$row['postcode']}, {$row['state']}, {$row['country']}";
                        echo "<div class='col'>"
                        . "<div class='card' style='border: none; border-radius: 0px; box-shadow: none;'>"
                        . "<img class='event-img' src='../data/event_img/" . $row['eventid'] . "_0'>"
                        . "<div class='card-body px-0 py-2'>"
                        . "<div class='' style='font-size: 1em; font-weight: bold;'>" . $row["endEvent"] . "</div>"
                        . "<div class='' style='font-size: 1em;'>" . $row["title"] . "</div>"
                        . "<div class='card-text py-1' style='font-size: 0.9em;'>" . $address . "</div>"
                        . "<div class='d-flex justify-content-between align-items-center'>"
                        . "<div class='btn-group'>"
                        . "<a href='../user/event_profile.php?id=" . $row["eventid"] . "' type='button' class='btn btn-sm btn-outline-secondary'>View</a>"
                        . "</div>"
                        . "<small class='text-muted'>Tel: " . $row["contact"] . "</small>"
                        . "</div>"
                        . "</div>"
                        . "</div>"
                        . "</div>";
                    }
                }
                ?>
            </div>

            <!--        <div class="container-lg">
                        <div class="row row-cols-xl-5 row-cols-lg-4 row-cols-md-3 row-cols-sm-2 row-cols-1">
            <?php
//                $get_inventory = "SELECT DISTINCT(a.auctionid), c.custid, c.username, c.avatar, i.itemid, m.img, a.endAuction, i.itemCondition, i.brand FROM item i, customer c, item_image m, auction a WHERE c.custid = a.auctioneerid AND i.custid = c.custid AND i.itemid = m.itemid AND a.auctionStatus = 'Active' AND i.itemActive = 'Auction'";
            $get_auction = "SELECT * FROM auction a, auction_details d, item i, customer c, item_image m WHERE a.auctionid = d.auctionid AND i.itemid = d.itemid AND a.auctioneerid = c.custid AND i.itemid = m.itemid";
            $result = $dbc->query($get_auction);
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
                    . "<a href='../user/auction_profile.php?id=" . $row["auctionid"] . "'>"
                    . "<img src=" . $row["img"] . " class='img-fluid item-img' alt='...'>"
                    . "</a>"
                    . "</div>"
                    . "<div class='d-flex bd-highlight align-items-center p-1 pb-0'>"
                    . "<div class='flex-grow-1 bd-highlight' style='font-size:0.8em;'>" . $row["endAuction"] . "</div>"
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
            ?>
                        </div>
                    </div>-->        
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

        .event-img{
            max-height: 245px;
            min-height: 245px;
            width: 100%;
            height: 100%;
            text-align: center;
            background-size: contain;
            background-repeat:   no-repeat;
            background: whitesmoke;
        }

        .fa-heart:hover{
            color: red;
        }

        .img-event{
            max-width: 100%;
            height: auto;
            align-self: flex-end;
            text-align: center;
            background: whitesmoke;
        }

        .img-event-box{
            max-width: 500px;
            max-height: 300px;
            display: flex;
        }

        .auction-img-box{
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

        .auction-img{
            /*max-height: 300px;*/
            /*height: 100%;*/
            text-align: center;
            background-size: contain;
            background-repeat:   no-repeat;
            background: whitesmoke;
        }
    </style>
</html>