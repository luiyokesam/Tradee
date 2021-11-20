<?php
include '../include/header.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM event e WHERE e.eventid = '$id' LIMIT 1";
    $result = $dbc->query($sql);
    if ($result->num_rows > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $current_data = $row;
            echo '<script>var End_Date_Time = ' . json_encode($current_data['endEvent']) . ';</script>';
            $Array_Image = array();
            $sql2 = "SELECT `img` FROM `event_image` WHERE `eventid` = '$id'";
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

$sql = "SELECT * FROM donation_delivery ORDER BY donationid DESC LIMIT 1";
$result = $dbc->query($sql);
if ($result->num_rows > 0) {
    while ($row = mysqli_fetch_array($result)) {
        $latestnum = ((int) substr($row['donationid'], 1)) + 1;
        $newid = "X{$latestnum}";
        $title = "Donation ID - {$newid}";
        echo '<script>var current_data = null;</script>';
        break;
    }
} else {
    $newid = "X10001";
    $title = "Donate ID - X10001";
    echo '<script>var current_data = null;</script>';
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
                        <img src="<?php
                        if (isset($Array_Image)) {
                            echo $Array_Image[0];
                        }
                        ?>" class="active-image" alt="Product Image">
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
                                    <div class="col-lg-5 col-3 item-title">Event type</div>
                                    <div class="col item-value"><?php
                                        if (isset($current_data)) {
                                            echo $current_data['type'];
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-5 col-3 item-title">Receiver</div>
                                    <div class="col item-value"><?php
                                        if (isset($current_data)) {
                                            echo $current_data['receiver'];
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-lg-5 col-3 item-title">End Date</div>
                                    <div class="col item-value"><?php
                                        if (isset($current_data)) {
                                            echo "{$current_data['endEvent']}";
                                        } else {
                                            echo 'none';
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-5 col-3 item-title">End In</div>
                                    <div class="col item-value" style="font-weight:bolder;" id="Time"></div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-lg-5 col-3 item-title">Person In-Charge</div>
                                    <div class="col item-value"><?php
                                        if (isset($current_data)) {
                                            echo $current_data['principal'];
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-5 col-3 item-title">Contact</div>
                                    <div class="col item-value"><?php
                                        if (isset($current_data)) {
                                            echo $current_data['contact'];
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="row mt-1">
                                    <div class="col item-value"><?php
                                        if (isset($current_data)) {
                                            echo "{$current_data['address1']}, {$current_data['address2']}, {$current_data['postcode']}, {$current_data['state']}, {$current_data['country']}";
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-2 border-bottom"></div>

                        <div class="row mt-2">
                            <div class="col-lg-12 col-md-7">
                                <div class="" style="font-size:1em;"><?php
                                    if (isset($current_data)) {
                                        echo $current_data['title'];
                                    }
                                    ?>
                                </div> 
                                <div class="text-justify item-value"><?php
                                    if (isset($current_data)) {
                                        echo $current_data['description'];
                                    }
                                    ?>
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-5 mt-2">
                                <div class='py-1'>
                                    <?php
                                    echo "<a class='btn btn-block btn-donate-now' style='color: #09B1BA;' href='event_shipping.php?eventid=" . $current_data["eventid"] . "&donationid=" . $newid . "'>"
                                    . "<i class='far fa-heart' style='color: red;'></i> Donate now"
                                    . "</a>"
                                    ?>
<!--                                    <a class="btn btn-block btn-donate-now" style="color: #09B1BA;" data-toggle="modal" data-target="#modal-bid-item">
                                        <i class="far fa-heart" style="color: red;"></i> Donate now
                                    </a>-->
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
                                        <th style="width: 20%">Donator</th>
                                        <th style="width: 20%">Item Quantity</th>
                                        <th style="width: 20%">Date</th>
                                        <th style="width: auto"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = "SELECT * FROM donation_delivery d WHERE d.eventid = '" . $current_data['eventid'] . "'";
                                    $result = $dbc->query($sql);
                                    if ($result) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<tr><td><a>" . $row["donationid"] . "</a></td>"
                                            . "<td><a>" . $row["donator"] . "</a></td>"
                                            . "<td><a>" . $row["itemQuantity"] . "</a></td>"
                                            . "<td><a>" . $row["paymentDate"] . "</a></td>"
                                            . "<td class='project-actions text-right'>"
                                            . "<a class='btn btn-light btn-block' href='donation_details.php?id=" . $row["donationid"] . "'>"
                                            . "<i class='far fa-heart' style='color: red;'>"
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

                                    <div class="form-group" style="display: none;">
                                        <label>Date</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                            <input type="text" class="form-control" placeholder="dd/mm/yyyy" id="donationDate" maxlength="10" readOnly name="donationDate">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-donate" id="btnsave" onclick="donation()">Donate</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <?php include '../include/footer.php'; ?>
    </body>
    <script>
        var x = setInterval(function () {
            var day = End_Date_Time.substring(0, 2);
            var month = End_Date_Time.substring(3, 5);
            var year = End_Date_Time.substring(6, 10);
            var date = year + "-" + month + "-" + day + " 00:00:00";
//            console.log(date);

            var now = new Date().getTime();
            var enddate = new Date(date).getTime();
//            console.log(now);
//            console.log(enddate);

            var distance = enddate - now;
            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);
            document.getElementById("Time").innerHTML = days + "d " + hours + "h "
                    + minutes + "m " + seconds + "s ";
            if (distance < 0) {
                clearInterval(x);
                document.getElementById("Time").innerHTML = "END";
            }
        }, 1000);

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

        function donation() {
            if (confirm("Are you sure to donate your item?\nRefund are not allowable.")) {
                window.location.href = "event_shipping.php";
            }
        }

//        function donation() {
//            var fullfill = true;
//            var message = "";
//
//            document.getElementById("myitem").style.borderColor = "";
//
//            if (!document.getElementById("myitem").value || document.getElementById("myitem").value === "") {
//                document.getElementById("myitem").style.borderColor = "red";
//                fullfill = false;
//            }
//
//            if (fullfill) {
//                if (confirm("Are you sure to donate your item?\nRefund are not allowable.")) {
//                    document.getElementById("form").submit();
//                }
//            } else {
//                alert("Please select an item from your inventory.\n" + message);
//            }
//        }

        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0');
        var yyyy = today.getFullYear();
        document.getElementById("donationDate").value = dd + '/' + mm + '/' + yyyy;
    </script>
    <script src="../bootstrap/plugins/select2/js/select2.full.min.js"></script>
    <style>
        .product-image-thumb{
            max-width: none;
        }

        .product-small-img img{
            cursor: pointer;
        }

        .product-small-img img:hover{
            opacity: 1;
        }

        .img-container img{
            max-height: 500px;
            max-width: 600px;
        }

        .img-container{
            min-height: 500px;
            max-height: 500px;
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
            font-size:0.85em; 
            color:#969696;
        }

        .item-value{
            font-size:0.85em; 
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