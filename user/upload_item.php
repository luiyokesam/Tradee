<?php
include '../include/header.php';

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
    $sql = "SELECT * FROM item i, item_image m WHERE i.itemid = '$id' AND i.itemid = m.itemid LIMIT 1";
    $result = $dbc->query($sql);
    if ($result->num_rows > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $current_data = $row;
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
        $img = $_FILES['img']['name'];
        if ($img) {
            $newimg = "../item_img/$img";
        } else {
            $newimg = $current_data["img"];
        }

        $sql_item = "UPDATE item SET"
                . " itemname='" . $_POST['itemname'] . "',"
                . "brand='" . $_POST['brand'] . "',"
                . "catname='" . $_POST['catname'] . "',"
                . "itemCondition='" . $_POST['itemCondition'] . "',"
                . "colour='" . $_POST['colour'] . "',"
                . "size='" . $_POST['size'] . "',"
                . "quantity=" . $_POST['quantity'] . ","
//                . "favour=" . $_POST['favour'] . ","
                . "value=" . $_POST['value'] . ","
                . "tradeItem='" . $_POST['tradeItem'] . "',"
                . "tradeOption='" . $_POST['tradeOption'] . "',"
                . "itemDescription='" . $_POST['itemDescription'] . "'"
//                . "postDate=" . $_POST['postDate'] . ""
//                . "itemActive=" . $_POST['active'] . ","
                . " WHERE itemid ='" . $current_data["itemid"] . "'";

        echo '<script>alert("' . $sql_item . '");</script>';

        $sql_image = "UPDATE item_image SET"
                . " img='" . $newimg . "'"
                . " WHERE itemid ='" . $current_data["itemid"] . "'";

        echo '<script>alert("' . $sql_image . '");</script>';

        if (($dbc->query($sql_item)) AND ($dbc->query($sql_image))) {
            if ($img) {
                move_uploaded_file($_FILES['img']['tmp_name'], "../photo/$img");
            }
            echo '<script>alert("Successfuly update !");window.location.href="my_profile.php";</script>';
        } else {
            echo '<script>alert("Update fail !\nContact IT department for maintainence")</script>';
        }
    } else {
        $img = $_FILES['img']['name'];
        if ($img) {
            $newimg = "../item_img/$img";
        }

        $sql_item = "INSERT INTO item(itemid, custid, itemname, brand, catname, colour, size, itemCondition, quantity, favour, value, tradeItem, tradeOption, itemDescription, postDate, itemActive) VALUES ("
                . "'" . $newid . "',"
                . "'" . $_SESSION['loginuser']['custid'] . "',"
                . "'" . $_POST['itemname'] . "',"
                . "'" . $_POST['brand'] . "',"
                . "'" . $_POST['catname'] . "',"
                . "'" . $_POST['colour'] . "',"
                . "'" . $_POST['size'] . "',"
                . "'" . $_POST['itemCondition'] . "',"
                . $_POST['quantity'] . ","
//            . $_POST['favour'] . ","
                . "0,"
                . $_POST['value'] . ","
                . "'" . $_POST['tradeItem'] . "',"
                . "'" . $_POST['tradeOption'] . "',"
                . "'" . $_POST['itemDescription'] . "',"
                . "'" . $_POST['postDate'] . "',"
                . "'Available')";

        echo '<script>alert("' . $sql_item . '");</script>';

        $sql_image = "INSERT INTO item_image(itemid, img) VALUES ("
                . "'" . $newid . "',"
                . "'" . $newimg . "')";

        echo '<script>alert("' . $sql_image . '");</script>';

        if (($dbc->query($sql_item)) AND ($dbc->query($sql_image))) {
            if ($img) {
                move_uploaded_file($_FILES['img']['tmp_name'], "../item_img/$img");
            }
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
        <title><?php
            if (isset($current_data)) {
                echo $current_data["itemid"];
            } else {
                echo $newid;
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
                            <div class="mb-3 bg-white">
                                <div class="row align-items-center border-bottom m-0 p-3">
                                    <img class="img-fluid mb-12" src="<?php
                                    if (isset($current_data)) {
                                        echo $current_data["img"];
                                    }
                                    ?>" alt="Photo" style="width: 20%; height: auto; padding-top: 10px" id="img_display" name="img_display">
                                </div>
                                <div class="col-md-12" >
                                    <div class="form-group py-3">
                                        <div class="custom-file">
                                            <input type="file" accept="image/*" onchange="loadFile(event)" class="custom-file-input" id="img" name="img" disabled>
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
                                        <input class="form-control" type="text" id="itemCondition" name="itemCondition" placeholder="e.g Gently used, with little signs of wear" readonly value="<?php
                                        if (isset($current_data)) {
                                            echo $current_data["itemCondition"];
                                        }
                                        ?>">
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
                                    <div class="col-md-6 p-2">Quantity</div>
                                    <div class="col-md-6 p-2">
                                        <input class="form-control" type="text" id="quantity" name="quantity" onkeypress="return isNumberKey(event)" placeholder="e.g 1" readonly value="<?php
                                        if (isset($current_data)) {
                                            echo $current_data["quantity"];
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
            var image = document.getElementById('img_display');
            image.src = URL.createObjectURL(event.target.files[0]);
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
            if (document.getElementById("btnsave").textContent === "Save") {
                var fullfill = true;
                var message = "";
                document.getElementById("validate_img").style.borderColor = "";
                document.getElementById("itemname").style.borderColor = "";
                document.getElementById("brand").style.borderColor = "";
                document.getElementById("catname").style.borderColor = "";
                document.getElementById("itemCondition").style.borderColor = "";
                document.getElementById("colour").style.borderColor = "";
                document.getElementById("size").style.borderColor = "";
                document.getElementById("quantity").style.borderColor = "";
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
                if (!document.getElementById("quantity").value || document.getElementById("quantity").value === "") {
                    document.getElementById("quantity").style.borderColor = "red";
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
            document.getElementById("img").disabled = false;
            document.getElementById("itemname").readOnly = false;
            document.getElementById("brand").readOnly = false;
            document.getElementById("catname").disabled = false;
            document.getElementById("itemCondition").readOnly = false;
            document.getElementById("colour").readOnly = false;
            document.getElementById("size").readOnly = false;
            document.getElementById("quantity").readOnly = false;
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