<?php
include '../include/header.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM donation_details d, event e, customer c, item i WHERE d.donator = c.custid AND d.itemid = i.itemid AND d.eventid = e.eventid AND d.donationid = '$id' LIMIT 1";
    $result = $dbc->query($sql);
    if ($result->num_rows > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $current_data = $row;
            $title = "Trade Details - {$current_data['donationid']}";
            echo '<script>var current_data = ' . json_encode($current_data) . ';</script>';
            break;
        }
    } else {
        echo '<script>alert("Extract data fail !\nContact IT department for maintainence");window.location.href = "../php/index.php";</script>';
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
            echo $current_data['title'];
            ?>
            - Trade Offer - Tradee
        </title>
    </head>
    <body>
        <div class="bg-navbar mb-2 bg-light">
            <div class="container-lg">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb py-2 mb-0">
                        <li class="breadcrumb-item"><a href="#">Event List</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Donation</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="container-lg">
            <div class="row">
                <div class="col-lg-3 col-sm-6 col-12 align-content-center">
                    <li class="list-inline-item me-0 trade-desc">Donation To:
                        <?php echo $current_data['title']; ?>
                    </li>
                </div>

                <div class="col-lg-3 col-sm-6 col-12 align-content-center">
                    <li class="list-inline-item me-0 trade-desc">Recipient:
                        <?php echo $current_data['receiver']; ?>
                    </li>
                </div>

                <!--                <div class="col-lg-4 col-sm-6 col-12 align-content-center">
                                    <li class="list-inline-item me-0 trade-desc">Address:
                <?php
                $sql = "SELECT * FROM event WHERE eventid = '{$current_data['eventid']}'";
                $result = $dbc->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = mysqli_fetch_array($result)) {
                        $address = "{$row['address1']}, {$row['address2']}, {$row['postcode']}, {$row['state']}, {$row['country']}";
                        echo $address;
                    }
                }
                ?>
                                    </li>
                                </div>-->
            </div>
        </div>

        <div class="container-lg py-2" style="min-height: 600px;">
            <div class="row">
                <div class="col-md-12">
                    <div class="border px-3 py-2">
                        <div class="row pb-2 border-bottom">
                            <img src="<?php echo $current_data['avatar'] ?>" class="img-fluid profile-pic float-start rounded-pill m-1" alt="Profile picture">

                            <div class="align-content-center ml-2 mt-2">
                                <li class="" style="list-style-type:none; font-size:0.9em;">Username: <?php echo $current_data['username']; ?></li>
                                <li class="" style="list-style-type:none; font-size:0.82em;"">His donated items:</li>
                            </div>
                        </div>

                        <div class="row row-cols-xl-4 row-cols-lg-3 row-cols-md-2 row-cols-sm-2 row-cols-1">
                            <?php
                            $get_inventory = "SELECT * FROM donation_details d, item i WHERE d.itemid = i.itemid AND d.donationid = '{$current_data['donationid']}'";
                            $result = $dbc->query($get_inventory);
                            if ($result->num_rows > 0) {
                                while ($row = mysqli_fetch_array($result)) {
                                    echo "<div class='col px-1 py-2'>"
                                    . "<div class='item-img-box overflow-hidden'>"
//                                    . "<a href='../user/item_profile.php?id=" . $row["itemid"] . "' target='_blank'>"
                                    . "<img src='../data/item_img/" . $row['itemid'] . "_0' class='img-fluid item-img' alt='...'>"
//                                    . "</a>"
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
        </div>
        <?php include '../include/footer.php'; ?>
    </body>
    <script>
        function back() {
            window.location.href = "../user/event_profile.php?id=<?php echo $current_data['eventid'] ?>";
        }
    </script>
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