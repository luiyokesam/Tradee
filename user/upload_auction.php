<?php
include '../include/header.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM auction WHERE auctionid = '$id' LIMIT 1";
    $result = $dbc->query($sql);
    if ($result->num_rows > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $current_data = $row;
            $title = "Auction Details - {$current_data['auctionid']}";
            echo '<script>var current_data = ' . json_encode($current_data) . ';</script>';
            break;
        }
    } else {
        echo '<script>alert("Extract data fail !\nContact IT department for maintainence");</script>';
    }
} else {
    $sql = "SELECT * FROM auction ORDER BY auctionid DESC LIMIT 1";
    $result = $dbc->query($sql);
    if ($result->num_rows > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $latestnum = ((int) substr($row['auctionid'], 1)) + 1;
            $newid = "A{$latestnum}";
            echo '<script>var current_data = null;</script>';
            break;
        }
    } else {
        $newid = "A10001";
        echo '<script>var current_data = null;</script>';
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_GET['id'])) {

//        $sql_item = "UPDATE auction SET"
//                . " itemname='" . $_POST['itemname'] . "',"
//                . "brand='" . $_POST['brand'] . "',"
//                . "catname='" . $_POST['catname'] . "',"
//                . "itemCondition='" . $_POST['itemCondition'] . "',"
//                . "colour='" . $_POST['colour'] . "',"
//                . "size='" . $_POST['size'] . "',"
//                . "quantity=" . $_POST['quantity'] . ","
////                . "favour=" . $_POST['favour'] . ","
//                . "value=" . $_POST['value'] . ","
//                . "tradeItem='" . $_POST['tradeItem'] . "',"
//                . "tradeOption='" . $_POST['tradeOption'] . "',"
//                . "itemDescription='" . $_POST['itemDescription'] . "'"
////                . "postDate=" . $_POST['postDate'] . ""
////                . "itemActive=" . $_POST['active'] . ","
//                . " WHERE itemid ='" . $current_data["itemid"] . "'";
//
//        echo '<script>alert("' . $sql_item . '");</script>';
//
//        $sql_image = "UPDATE item_image SET"
//                . " img='" . $newimg . "'"
//                . " WHERE itemid ='" . $current_data["itemid"] . "'";
//
//        echo '<script>alert("' . $sql_image . '");</script>';
//
//        if (($dbc->query($sql_item)) AND ($dbc->query($sql_image))) {
//            if ($img) {
//                move_uploaded_file($_FILES['img']['tmp_name'], "../photo/$img");
//            }
//            echo '<script>alert("Successfuly update !");window.location.href="my_profile.php";</script>';
//        } else {
//            echo '<script>alert("Update fail !\nContact IT department for maintainence")</script>';
//        }
    } else {
        $sql1 = "INSERT INTO auction(auctionid, auctioneerid, auctionDesc, endAuction, auctionStatus) VALUES ("
                . "'" . $newid . "',"
                . "'" . $_SESSION['loginuser']['custid'] . "',"
                . "'" . $_POST['auctionDesc'] . "',"
                . "'" . $_POST['endAuction'] . "',"
//                .  $_POST['endAuction'] . ","
                . "'" . $_POST['auctionStatus'] . "')";

        echo '<script>alert("' . $sql1 . '");</script>';

        $my_items = $_POST['my_item'];
        foreach ($my_items as $my_item_list) {
            $sql_my_trade_details = "INSERT INTO auction_details(auctionid, itemid) VALUES ("
                    . "'" . $newid . "',"
                    . "'" . $my_item_list . "')";

            $dbc->query($sql_my_trade_details);
        }
        echo '<script>alert("' . $sql_my_trade_details . '");</script>';

        foreach ($my_items as $update_my_item_list) {
            $sql = "UPDATE item SET "
                    . "itemActive = 'Auction'"
                    . " WHERE custid ='" . $_SESSION['loginuser']['custid'] . "' AND"
                    . " itemid = '" . $update_my_item_list . "'";

            $dbc->query($sql);
            echo '<script>alert("' . $sql . '");</script>';
        }

        echo '<script>alert("' . $update_my_item_list . '");</script>';

        if ($dbc->query($sql1)) {
            echo '<script>alert("Successfuly insert!");window.location.href="my_profile.php";</script>';
        } else {
            echo '<script>alert("Insert fail!\nContact IT department for maintainence")</script>';
        }
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
            if (isset($current_data)) {
                echo $current_data["itemid"];
            } else {
                echo $newid;
            }
            ?> Auction - Tradee</title>
    </head>
    <body onload="loadform()">
        <div class="setting bg-light">
            <div class="container-lg py-3">
                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <div class="row m-2">
                            <div class="h1 py-3">Auction in Tradee</div>
                        </div>

                        <form method="post" id="form" enctype="multipart/form-data">
                            <div class="mb-3 bg-white">
                                <div class="row align-items-center border-bottom m-0 p-3">
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

                            <div class="mb-3 bg-white">
                                <div class="row align-items-center border-bottom m-0 p-3">
                                    <div class="col-md-6 p-2">End Date and time</div>
                                    <div class="col-md-6 input-group date" id="reservationdatetime" data-target-input="nearest">
                                        <input type="text" id="endAuction" name="endAuction" readonly class="form-control datetimepicker-input" data-target="#reservationdatetime">

                                        <div class="input-group-append" data-target="#reservationdatetime" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row border-bottom m-0 p-3">
                                    <div class="col-md-6 p-2">Describe your item</div>
                                    <div class="col-md-6 py-2">
                                        <textarea class="form-control" id="auctionDesc" name="auctionDesc" rows="5" placeholder="e.g Thanks for visiting our auction." readonly><?php
                                            if (isset($current_data)) {
                                                echo $current_data["auctionDesc"];
                                            }
                                            ?></textarea>
                                    </div>
                                </div>

                                <div class="row align-items-center border-bottom m-0 p-3">
                                    <div class="col-md-6 p-2">Auction Status</div>
                                    <div class="col-md-6 p-2">
                                        <select class="custom-select" id="auctionStatus" name="auctionStatus" disabled>
                                            <option value="Active" <?php
                                            if (isset($current_data)) {
                                                if ($current_data["tradeOption"] == "Active") {
                                                    echo "selected";
                                                }
                                            }
                                            ?>>Active</option>
                                            <option value="Pending" <?php
                                            if (isset($current_data)) {
                                                if ($current_data["tradeOption"] == "Pending") {
                                                    echo "selected";
                                                }
                                            }
                                            ?>>Pending</option>
                                            <option value="Completed" <?php
                                            if (isset($current_data)) {
                                                if ($current_data["tradeOption"] == "Completed") {
                                                    echo "selected";
                                                }
                                            }
                                            ?>>Completed</option>
                                            <option value="Ended" <?php
                                            if (isset($current_data)) {
                                                if ($current_data["tradeOption"] == "Ended") {
                                                    echo "selected";
                                                }
                                            }
                                            ?>>Ended</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="float-right p-2">
                                <button type="button" class="btn btn-save btn-block" id="btnsave" onclick="editorsave()">Edit</button>
                            </div>

                            <div class="float-sm-right p-2">
                                <button type="button" class="btn btn-warning btn-block" onclick="cancel()" id="btncancel" disabled>Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
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

        //Date and time picker
        $('#reservationdatetime').datetimepicker({icons: {time: 'far fa-clock'}});

        var currentURL = window.location.href;
        var isnew = false;

        function loadform() {
            var params = new window.URLSearchParams(window.location.search);
            if (!params.get('id')) {
                isnew = true;
                editable();
            }
        }

        function editorsave() {
            if (document.getElementById("btnsave").textContent === "Save") {
                var fullfill = true;
                var message = "";
                document.getElementById("endAuction").style.borderColor = "";
                document.getElementById("auctionDesc").style.borderColor = "";
                document.getElementById("auctionStatus").style.borderColor = "";

                if (!document.getElementById("endAuction").value || document.getElementById("endAuction").value === "") {
                    document.getElementById("endAuction").style.borderColor = "red";
                    fullfill = false;
                }
                if (!document.getElementById("auctionDesc").value || document.getElementById("auctionDesc").value === "") {
                    document.getElementById("auctionDesc").style.borderColor = "red";
                    fullfill = false;
                }
                if (!document.getElementById("auctionStatus").value || document.getElementById("auctionStatus").value === "") {
                    document.getElementById("auctionStatus").style.borderColor = "red";
                    fullfill = false;
                }

                if (fullfill) {
                    if (confirm("Are you sure to upload the items?")) {
                        document.getElementById("form").submit();
                    }
                } else {
                    alert("Please enter all required information for this items.\n" + message);
                }
            } else {
                editable();
            }
        }

        function cancel() {
            if (isnew) {
                if (confirm("Are you sure to cancel to insert item?\n")) {
                    window.location.href = "my_profile.php";
                }
            } else {
                if (confirm("Confirm to unsave current information?")) {
                    window.location.href = currentURL;
                }
            }
        }

        function editable() {
            document.getElementById("btnsave").textContent = "Save";
            document.getElementById("btncancel").disabled = false;
            document.getElementById("endAuction").readOnly = false;
            document.getElementById("auctionDesc").readOnly = false;
            document.getElementById("auctionStatus").disabled = false;
        }

        function addnew() {
            var params = new window.URLSearchParams(window.location.search);
            if (!params.get('id')) {
                isnew = true;
                editable();
            }
        }
    </script>
    <script src="../bootstrap/plugins/select2/js/select2.full.min.js"></script>
    <style>
        .btn-save{
            color: #fff;
            border-color: #7cf279;
            background-color: #7cf279;
        }

        .btn-save:hover{
            color: #fff;
            border-color: #5cc259;
            background-color: #5cc259;
            transition-duration: 0.2s;
        }
    </style>
</html>