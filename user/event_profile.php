<?php
include '../include/header.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM event e, event_image i WHERE e.eventid = i.eventid AND e.eventid = '$id' LIMIT 1";
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

$sql = "SELECT * FROM donation ORDER BY donateid DESC LIMIT 1";
$result = $dbc->query($sql);
if ($result->num_rows > 0) {
    while ($row = mysqli_fetch_array($result)) {
        $latestnum = ((int) substr($row['donateid'], 1)) + 1;
        $newid = "D{$latestnum}";
        $title = "Trade ID - {$newid}";
        echo '<script>var current_data = null;</script>';
        $view = false;
        break;
    }
} else {
    $newid = "D10001";
    $title = "Donate ID - D10001";
    echo '<script>var current_data = null;</script>';
    $view = false;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $my_items = $_POST['my_item'];
    foreach ($my_items as $my_item_list) {
        $sql = "INSERT INTO donation(donateid, eventid, donator, itemid, date) VALUES ("
                . "'" . $newid . "',"
                . "'" . $current_data['eventid'] . "',"
                . "'" . $_SESSION['loginuser']['custid'] . "',"
                . "'" . $my_item_list . "',"
                . "NOW())";

        $dbc->query($sql);
//        echo '<script>alert("' . $sql . '");</script>';
    }
//    echo '<script>alert("' . $my_item_list . '");</script>';

    foreach ($my_items as $update_my_item_list) {
        $sql_update = "UPDATE item SET "
                . "itemActive = 'Donation',"
                . "custid = '$newid'"
                . " WHERE custid ='" . $_SESSION['loginuser']['custid'] . "' AND"
                . " itemid = '" . $update_my_item_list . "'";

        $dbc->query($sql_update);
//        echo '<script>alert("' . $sql_update . '");</script>';
    }
//    echo '<script>alert("' . $update_my_item_list . '");</script>';

    echo '<script>alert("Thanks for your donation!");</script>';
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
            if (isset($current_data)) {
                echo $current_data['title'];
            }
            ?> - Tradee</title>
    </head>
    <body>
        <div class="bg-navbar mb-3 bg-light">
            <div class="container-xl">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb py-2 mb-0">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Clothing</li>
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
                        <div class="product-image-thumb product-small-img"><img src="../img/event/event_1.jpg" alt="Product Image"></div>
                        <div class="product-image-thumb product-small-img"><img src="../img/event/event_2.jpg" alt="Product Image"></div>
                        <div class="product-image-thumb product-small-img"><img src="../img/event/event_3.jpg" alt="Product Image"></div>
                        <div class="product-image-thumb product-small-img active"><img src="../img/event/event_4.jpg" alt="Product Image"></div>
                    </div>
                </div>

                <div class="col-xxl-3 col-xl-4 col-lg-4 my-1">
                    <div class="bg-white px-3 py-2 border">
                        <div class="row">
                            <div class="col-lg-12 col-sm-6">
                                <!--                                <div class="row">
                                                                    <div class="col item-value">Rumah Charis</div>
                                                                </div>-->
                                <div class="row">
                                    <div class="col-lg-5 col-3 item-title">Event type</div>
                                    <div class="col item-value"><?php
                                        if (isset($current_data)) {
                                            echo $current_data['type'];
                                        }
                                        ?></div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-5 col-3 item-title">Receiver</div>
                                    <div class="col item-value"><?php
                                        if (isset($current_data)) {
                                            echo $current_data['receiver'];
                                        }
                                        ?></div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-5 col-3 item-title">End</div>
                                    <div class="col item-value"><?php
                                        if (isset($current_data)) {
                                            echo $current_data['endEvent'];
                                        } else {
                                            echo 'none';
                                        }
                                        ?></div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-5 col-3 item-title">Contact</div>
                                    <div class="col item-value"><?php
                                        if (isset($current_data)) {
                                            echo $current_data['contact'];
                                        }
                                        ?></div>
                                </div>
                                <div class="row mt-1">
                                    <div class="col item-value"><?php
                                        if (isset($current_data)) {
                                            echo $current_data['address'];
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
                                        echo $current_data['title'];
                                    }
                                    ?></div> 
                                <div class="text-justify item-value"><?php
                                    if (isset($current_data)) {
                                        echo $current_data['description'];
                                    }
                                    ?></div>
                            </div>

                            <div class="col-lg-12 col-md-5 mt-2">
                                <div class='py-1'>
                                    <a class="btn btn-block btn-donate-now" style="color: #09B1BA;" data-toggle="modal" data-target="#modal-bid-item">
                                        <i class="far fa-heart" style="color: red;"></i> Donate now
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class='row pb-5'>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Donation List</h3>
                        </div>
                        <div class="card-body">
                            <table id="donationtable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 20%">Donate ID</th>
                                        <th style="width: 20%">Event ID</th>
                                        <th style="width: 20%">Donator</th>
                                        <th style="width: 20%">Item Name</th>
                                        <th style="width: auto"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = "SELECT * FROM donation d, item i, customer c WHERE d.donator = c.custid AND d.itemid = i.itemid AND eventid = '" . $current_data['eventid'] . "'";
                                    $result = $dbc->query($sql);
                                    if ($result) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<tr><td><a>" . $row["donateid"] . "</a></td>"
                                            . "<td><a>" . $row["eventid"] . "</a></td>"
                                            . "<td><a>" . $row["username"] . "</a></td>"
                                            . "<td><a>" . $row["itemname"] . "</a></td>"
                                            . "<td class='project-actions text-right'>"
//                                            . "<a class = "btn btn-block btn-donate-now" data-toggle = "modal" data-target = "#modal-bid-item">"
//                                                    . "<a class='btn btn-info btn-block' href='event_details.php?id=" . $row["eventid"] . "'>"
                                                    . "<a class='btn btn-info btn-block' data-toggle='modal' data-target='#".$row["donateid"] ."'>"
                                                    . "<i class='far fa-eye'>"
                                                    . "</i></a></td></tr>";
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
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-donate" id="btnsave">Donate</button>
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

        $(document).ready(function () {
            $("#donationtable").DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true
            });
        });
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

        .item-title{
            font-size:0.8em; 
            color:#969696;
        }

        .item-value{
            font-size:0.8em; 
            color: #001226;
        }

        /*button*/
        .btn-donate-now{
            border-color: #09B1BA;
            background-color: #fff;
        }

        .btn-donate-now:hover{
            border-color: #7cf279;
            background-color: #7cf279;
            transition-duration: 0.2s;
        }

        .btn-donate{
            color: #09B1BA;
            border-color: #09B1BA;
            background-color: #fff;
        }

        .btn-donate:hover{
            color: #fff;
            border-color: #7cf279;
            background-color: #7cf279;
            transition-duration: 0.2s;
        }

        .btn-donate:active{
            color: #fff;
            border-color: #7cf279;
            background-color: #7cf279;
            transition-duration: 0.2s;
        }
    </style>
</html>