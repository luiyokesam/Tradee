<?php
include '../include/header.php';

if (!isset($_SESSION['loginuser'])) {
    echo '<script>alert("Please login to Tradee.");window.location.href="../user/logout.php";</script>';
}

$category_array = array();
$sql = "SELECT name FROM category";
$result = $dbc->query($sql);
if ($result->num_rows > 0) {
    while ($row = mysqli_fetch_array($result)) {
        $category_array[] = $row['name'];
    }
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM item i WHERE i.itemid = '$id' LIMIT 1";
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
            $title = "Item Details - {$current_data['itemid']}";
            echo '<script>var current_data = ' . json_encode($current_data) . ';</script>';
            break;
        }
    } else {
        echo '<script>alert("Extract data fail !\nContact IT department for maintainence");</script>';
    }
} else {
    $sql = "SELECT * FROM item ORDER BY itemid DESC LIMIT 1";
    $result = $dbc->query($sql);
    if ($result->num_rows > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $latestnum = ((int) substr($row['itemid'], 1)) + 1;
            $newid = "I{$latestnum}";
            echo '<script>var current_data = null;</script>';
            break;
        }
    } else {
        $newid = "I10001";
        echo '<script>var current_data = null;</script>';
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_GET['id'])) {

        if (is_uploaded_file($_FILES["img"]["tmp_name"][0])) {
            $length = count($Array_Image);
            for ($x = 0; $x < $length; $x++) {
                if (file_exists($Array_Image[$x])) {
//                    echo '<script>alert("' . 1 . '");</script>';
                    unlink($Array_Image[$x]);
                }
            }

            $sql_Delete_Image = "DELETE FROM `item_image` WHERE `itemid` = '{$current_data["itemid"]}'";
            if ($dbc->query($sql_Delete_Image)) {
                $Count_Image = count($_FILES['img']['name']);
                for ($i = 0; $i < $Count_Image; $i++) {
                    $image_path = "../data/item_img/{$current_data["itemid"]}_{$i}";
                    if (file_exists($image_path)) {
                        unlink($image_path);
                    }
                    move_uploaded_file($_FILES["img"]["tmp_name"][$i], $image_path);
                    $sql = "INSERT INTO `item_image`(`itemid`, `img`) VALUES ('{$current_data["itemid"]}','{$image_path}')";
                    if (!$dbc->query($sql)) {
                        echo '<script>console.log("Error Insert Image !");</script>';
                    }
                }
            }
        }

        $sql_item = "UPDATE item SET"
                . " itemname='" . $_POST['itemname'] . "', "
                . "brand='" . $_POST['brand'] . "', "
                . "catname='" . $_POST['catname'] . "', "
                . "itemCondition='" . $_POST['itemCondition'] . "', "
                . "colour='" . $_POST['colour'] . "', "
                . "size='" . $_POST['size'] . "', "
                . "value=" . $_POST['value'] . ", "
                . "tradeItem='" . $_POST['tradeItem'] . "', "
                . "tradeOption='" . $_POST['tradeOption'] . "', "
                . "itemDescription='" . $_POST['itemDescription'] . "' "
//                . "postDate=" . $_POST['postDate'] . " "
//                . "itemActive=" . $_POST['active'] . ", "
                . " WHERE itemid ='" . $current_data["itemid"] . "' ";

//        echo '<script>alert("' . $sql_item . '");</script>';

        if ($dbc->query($sql_item)) {
            echo '<script>alert("Item details has been updated successfully!");window.location.href="my_profile.php";</script>';
        } else {
            echo '<script>alert("Failed to update item details!\nPlease contact to our IT department for maintainence.")</script>';
        }
    } else {
        $Count_Image = count($_FILES['img']['name']);
        for ($i = 0; $i < $Count_Image; $i++) {
            $image_path = "../data/item_img/{$newid}_$i";
            move_uploaded_file($_FILES["img"]["tmp_name"][$i], $image_path);
            $sql = "INSERT INTO `item_image`(`itemid`, `img`) VALUES ('$newid','{$image_path}')";
            if (!$dbc->query($sql)) {
                echo '<script>console.log("Error Insert Image !");</script>';
            }
        }

        $sql_item = "INSERT INTO item(itemid, custid, itemname, brand, catname, colour, size, itemCondition, favour, value, tradeItem, tradeOption, itemDescription, postDate, itemActive) VALUES ("
                . "'" . $newid . "',"
                . "'" . $_SESSION['loginuser']['custid'] . "',"
                . "'" . $_POST['itemname'] . "',"
                . "'" . $_POST['brand'] . "',"
                . "'" . $_POST['catname'] . "',"
                . "'" . $_POST['colour'] . "',"
                . "'" . $_POST['size'] . "',"
                . "'" . $_POST['itemCondition'] . "',"
                . "0,"
                . $_POST['value'] . ","
                . "'" . $_POST['tradeItem'] . "',"
                . "'" . $_POST['tradeOption'] . "',"
                . "'" . $_POST['itemDescription'] . "',"
                . "'" . $_POST['postDate'] . "',"
                . "'Available')";

        if ($dbc->query($sql_item)) {
            echo '<script>alert("New item has been added to your inventory!");window.location.href="my_profile.php";</script>';
        } else {
            echo '<script>alert("Failed to add the item into your inventory!\nPlease contact to our IT department for maintainence.")</script>';
        }
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
                echo $current_data["itemid"];
            } else {
                echo "Upload New";
            }
            ?> Item - Tradee</title>
    </head>
    <body onload="loadform()">
        <div class="setting bg-light">
            <div class="container-lg py-3">
                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <div class="row m-2">
                            <div class="h1 py-3">Trade an item</div>
                        </div>

                        <form method="post" id="form" enctype="multipart/form-data">
                            <div class="mb-3 bg-white">
                                <div class="row align-items-center border-bottom m-0 p-3">
                                    <div class="p-3">Add up to 5 photos.
                                        <a href="">See photos tips.</a>
                                    </div>
                                    <div class="p-3">
                                        <button type="button" class="btn btn-primary">+ Upload photos</button>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-3 product-image-thumbs d-flex flex-column mt-0">
                                    <div class="product-image-thumb product-small-img mb-3 mr-0 p-1 active" style="width: 80px; max-width: 80px; height: 80px; max-height: 80px;">
                                        <img class="img-fluid" src="<?php
                                        if (isset($Array_Image)) {
                                            echo $Array_Image[0];
                                        }
                                        ?>" alt="Photo" style="height: auto; max-height: 70px; width: 70px; max-width: 70px" id="img_display0" name="img_display">
                                    </div>

                                    <div class="product-image-thumb product-small-img mb-3 mr-0 p-1" style="width: 80px; max-width: 80px; height: 80px; max-height: 80px;">
                                        <img class="img-fluid" src="<?php
                                        if (isset($Array_Image)) {
                                            echo $Array_Image[1];
                                        }
                                        ?>" alt="Photo" style="height: auto; max-height: 70px; width: 70px; max-width: 70px" id="img_display1" name="img_display">
                                    </div>

                                    <div class="product-image-thumb product-small-img mb-3 mr-0 p-1" style="width: 80px; max-width: 80px; height: 80px; max-height: 80px;">
                                        <img class="img-fluid" src="<?php
                                        if (isset($Array_Image)) {
                                            echo $Array_Image[2];
                                        }
                                        ?>" alt="Photo" style="height: auto; max-height: 70px; width: 70px; max-width: 70px" id="img_display2" name="img_display">
                                    </div>

                                    <div class="product-image-thumb product-small-img mb-3 mr-0 p-1" style="width: 80px; max-width: 80px; height: 80px; max-height: 80px;">
                                        <img class="img-fluid" src="<?php
                                        if (isset($Array_Image)) {
                                            echo $Array_Image[3];
                                        }
                                        ?>" alt="Photo" style="height: auto; max-height: 70px; width: 70px; max-width: 70px" id="img_display3" name="img_display">
                                    </div>

                                    <div class="product-image-thumb product-small-img mb-3 mr-0 p-1" style="width: 80px; max-width: 80px; height: 80px; max-height: 80px;">
                                        <img class="img-fluid" src="<?php
                                        if (isset($Array_Image)) {
                                            echo $Array_Image[4];
                                        }
                                        ?>" alt="Photo" style="height: auto; max-height: 70px; width: 70px; max-width: 70px" id="img_display4" name="img_display">
                                    </div>
                                </div>

                                <div class="col-9 img-container" style="width: 500px; height: 500px">
                                    <img src="../img/test-shirt/drop_img.png" class="active-image" style="max-width: 500px; max-height: 500px" alt="Product Image">
                                </div>
                            </div>

                            <div class="mb-3 bg-white mt-2">
                                <div class="col-md-12" >
                                    <div class="form-group py-3">
                                        <div class="custom-file">
                                            <input type="file" accept="image/*" onchange="loadFile(event)" class="custom-file-input" id="img" name="img[]" multiple disabled>
                                            <label class="custom-file-label" id="validate_img">Choose file</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3 bg-white">
                                <div class="row align-items-center border-bottom m-0 p-3">
                                    <div class="col-md-6 p-2">Name</div>
                                    <div class="col-md-6 p-2">
                                        <input class="form-control" type="text" id="itemname" name="itemname" placeholder="e.g White COS Sweater" readonly value="<?php
                                        if (isset($current_data)) {
                                            echo $current_data["itemname"];
                                        }
                                        ?>">
                                    </div>
                                </div>

                                <div class="row align-items-center border-bottom m-0 p-3">
                                    <div class="col-md-6 p-2">Brand</div>
                                    <div class="col-md-6 p-2">
                                        <input class="form-control" type="text" id="brand" name="brand" placeholder="e.g White COS Sweater" readonly value="<?php
                                        if (isset($current_data)) {
                                            echo $current_data["brand"];
                                        }
                                        ?>">
                                    </div>
                                </div>

                                <div class="row align-items-center border-bottom m-0 p-3">
                                    <div class="col-md-6 p-2">Category</div>
                                    <div class="col-md-6 p-2">
                                        <select class="custom-select" id="catname" name="catname" disabled>
                                            <option value="">-- Select --</option>
                                            <?php
                                            foreach ($category_array as $selection) {
                                                $selected = ($current_data["catname"] == $selection) ? "selected" : "";
                                                echo '<option ' . $selected . ' value="' . $selection . '">' . $selection . '</option>';
                                            }
                                            echo '</select>';
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="row align-items-center border-bottom m-0 p-3">
                                    <div class="col-md-6 p-2">Condition</div>
                                    <div class="col-md-6 p-2">
                                        <select class="custom-select" id="itemCondition" name="itemCondition" disabled>
                                            <option value="">-- Select --</option>
                                            <option value="New With Tags" <?php
                                            if (isset($current_data)) {
                                                if ($current_data["itemCondition"] == "New With Tags") {
                                                    echo "selected";
                                                }
                                            }
                                            ?>>New With Tags</option>
                                            <option value="Excellent Used Condition" <?php
                                            if (isset($current_data)) {
                                                if ($current_data["itemCondition"] == "Excellent Used Condition") {
                                                    echo "selected";
                                                }
                                            }
                                            ?>>Excellent Used Condition</option>
                                            <option value="Good Used Condition" <?php
                                            if (isset($current_data)) {
                                                if ($current_data["itemCondition"] == "Good Used Condition") {
                                                    echo "selected";
                                                }
                                            }
                                            ?>>Good Used Condition</option>
                                            <option value="Very Used Condition" <?php
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

                            <div class="mb-3 bg-white">
                                <div class="row align-items-center border-bottom m-0 p-3">
                                    <div class="col-md-6 p-2">Colour</div>
                                    <div class="col-md-6 p-2">
                                        <input class="form-control" type="text" id="colour" name="colour" placeholder="e.g Blue" readonly value="<?php
                                        if (isset($current_data)) {
                                            echo $current_data["colour"];
                                        }
                                        ?>">
                                    </div>
                                </div>

                                <div class="row align-items-center border-bottom m-0 p-3">
                                    <div class="col-md-6 p-2">Size</div>
                                    <div class="col-md-6 p-2">
                                        <input class="form-control" type="text" id="size" name="size" placeholder="e.g XL" readonly value="<?php
                                        if (isset($current_data)) {
                                            echo $current_data["size"];
                                        }
                                        ?>">
                                    </div>
                                </div>

                                <div class="row align-items-center border-bottom m-0 p-3">
                                    <div class="col-md-6 p-2">Value (RM)</div>
                                    <div class="col-md-6 p-2">
                                        <input class="form-control" type="text" id="value" name="value" onkeypress="return isNumberKey(event)" placeholder="e.g 50.50" readonly value="<?php
                                        if (isset($current_data)) {
                                            echo $current_data["value"];
                                        }
                                        ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3 bg-white">
                                <div class="row align-items-center border-bottom m-0 p-3">
                                    <div class="col-md-6 p-2">Preferred to swap</div>
                                    <div class="col-md-6 p-2">
                                        <select class="custom-select" id="tradeItem" name="tradeItem" disabled>
                                            <option value="">-- Select --</option>
                                            <?php
                                            foreach ($category_array as $selection) {
                                                $selected = ($current_data["tradeItem"] == $selection) ? "selected" : "";
                                                echo '<option ' . $selected . ' value="' . $selection . '">' . $selection . '</option>';
                                            }
                                            echo '</select>';
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="row align-items-center border-bottom m-0 p-3">
                                    <div class="col-md-6 p-2">Trade option</div>
                                    <div class="col-md-6 p-2">
                                        <select class="custom-select" id="tradeOption" name="tradeOption" disabled>
                                            <option value="">-- Select --</option>
                                            <option value="On-Delivery" <?php
                                            if (isset($current_data)) {
                                                if ($current_data["tradeOption"] == "On-Delivery") {
                                                    echo "selected";
                                                }
                                            }
                                            ?>>On-Delivery</option>
                                            <option value="On-Trade" <?php
                                            if (isset($current_data)) {
                                                if ($current_data["tradeOption"] == "On-Trade") {
                                                    echo "selected";
                                                }
                                            }
                                            ?>>On-Trade</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row border-bottom m-0 p-3">
                                    <div class="col-md-6 p-2">Describe your item</div>
                                    <div class="col-md-6 py-2">
                                        <textarea class="form-control" id="itemDescription" name="itemDescription" rows="5" placeholder="e.g only worn a few times, true to size" readonly><?php
                                            if (isset($current_data)) {
                                                echo $current_data["itemDescription"];
                                            }
                                            ?></textarea>
                                    </div>
                                </div>

                                <div class="row border-bottom m-0 p-3" style="display: none;">
                                    <div class="col-md-6 p-2">Date</div>
                                    <div class="col-md-6 py-2">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                            <input type="text" class="form-control" placeholder="dd/mm/yyyy" id="postDate" maxlength="10" readOnly name="postDate">
                                        </div>
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
        var loadFile = function (event) {
            for (i = 0; i < 5; i++) {
                document.getElementById("img_display" + i + "").src = "";
            }

            if (event.target.files.length < 6) {
                for (i = 0; i < event.target.files.length; i++) {
                    document.getElementById("img_display" + i + "").src = URL.createObjectURL(event.target.files[i]);
                }
            }
        };

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
            if (document.getElementById("btnsave").textContent === "Upload") {
                var fullfill = true;
                var message = "";
                document.getElementById("validate_img").style.borderColor = "";
                document.getElementById("itemname").style.borderColor = "";
                document.getElementById("brand").style.borderColor = "";
                document.getElementById("catname").style.borderColor = "";
                document.getElementById("itemCondition").style.borderColor = "";
                document.getElementById("colour").style.borderColor = "";
                document.getElementById("size").style.borderColor = "";
                document.getElementById("value").style.borderColor = "";
                document.getElementById("tradeItem").style.borderColor = "";
                document.getElementById("tradeOption").style.borderColor = "";
                document.getElementById("itemDescription").style.borderColor = "";

                var img = document.getElementById('img_display');

                if (!document.getElementById("img").value || document.getElementById("img").value === "") {
                    if (img.getAttribute('src') === "") {
                        document.getElementById("validate_img").style.borderColor = "red";
                        fullfill = false;
                    }
                }
                if (!document.getElementById("itemname").value || document.getElementById("itemname").value === "") {
                    document.getElementById("itemname").style.borderColor = "red";
                    fullfill = false;
                }
                if (!document.getElementById("brand").value || document.getElementById("brand").value === "") {
                    document.getElementById("brand").style.borderColor = "red";
                    fullfill = false;
                }
                if (!document.getElementById("catname").value || document.getElementById("catname").value === "") {
                    document.getElementById("catname").style.borderColor = "red";
                    fullfill = false;
                }
                if (!document.getElementById("itemCondition").value || document.getElementById("itemCondition").value === "") {
                    document.getElementById("itemCondition").style.borderColor = "red";
                    fullfill = false;
                }
                if (!document.getElementById("colour").value || document.getElementById("colour").value === "") {
                    document.getElementById("colour").style.borderColor = "red";
                    fullfill = false;
                }
                if (!document.getElementById("size").value || document.getElementById("size").value === "") {
                    document.getElementById("size").style.borderColor = "red";
                    fullfill = false;
                }
                if (!document.getElementById("value").value || document.getElementById("value").value === "") {
                    document.getElementById("value").style.borderColor = "red";
                    fullfill = false;
                }
                if (!document.getElementById("tradeItem").value || document.getElementById("tradeItem").value === "") {
                    document.getElementById("tradeItem").style.borderColor = "red";
                    fullfill = false;
                }
                if (!document.getElementById("tradeOption").value || document.getElementById("tradeOption").value === "") {
                    document.getElementById("tradeOption").style.borderColor = "red";
                    fullfill = false;
                }
                if (!document.getElementById("itemDescription").value || document.getElementById("itemDescription").value === "") {
                    document.getElementById("itemDescription").style.borderColor = "red";
                    fullfill = false;
                }

                if (fullfill) {
                    if (confirm("Are you sure to upload the item?")) {
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
            document.getElementById("btnsave").textContent = "Upload";
            document.getElementById("btncancel").disabled = false;
            document.getElementById("img").disabled = false;
            document.getElementById("itemname").readOnly = false;
            document.getElementById("brand").readOnly = false;
            document.getElementById("catname").disabled = false;
            document.getElementById("itemCondition").disabled = false;
            document.getElementById("colour").readOnly = false;
            document.getElementById("size").readOnly = false;
            document.getElementById("value").readOnly = false;
            document.getElementById("tradeItem").disabled = false;
            document.getElementById("tradeOption").disabled = false;
            document.getElementById("itemDescription").readOnly = false;
        }

        function addnew() {
            var params = new window.URLSearchParams(window.location.search);
            if (!params.get('id')) {
                isnew = true;
                editable();
            }
        }

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

        function isNumberKey(evt) {
            var charCode = (evt.which) ? evt.which : event.keyCode;
            if (charCode > 31 && (charCode !== 46 && (charCode < 48 || charCode > 57)))
                return false;
            if (charCode === 46 && charCode === ".")
                return false;
            if (charCode === ".")
            {
                var number = [];
                number = charCode.split(".");
                if (number[1].length === decimalPts)
                    return false;
            }
            return true;
        }

        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0');
        var yyyy = today.getFullYear();
        document.getElementById("postDate").value = dd + '/' + mm + '/' + yyyy;
    </script>
    <style>
        .product-small-img img:hover{
            opacity: 1;
            transition-duration: 0.2s;
        }
        
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