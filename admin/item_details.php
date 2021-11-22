<?php
$page = 'item_list';
include 'navbar.php';

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
    $sql = "SELECT * FROM item i, item_image m WHERE i.itemid = m.itemid AND i.itemid = '$id' LIMIT 1";
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
            $title = "Item detail ({$current_data['itemid']})";
            echo '<script>var current_data = ' . json_encode($current_data) . ';</script>';
            $view = true;
            break;
        }
    } else {
        echo '<script>alert("Extract data error !\nContact IT department for maintainence");window.location.href = "item_list.php";</script>';
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

        $sql = "UPDATE item"
                . " SET itemname= '" . $_POST['itemname'] . "', "
                . "brand = '" . $_POST['brand'] . "', "
                . "catname = '" . $_POST['catname'] . "', "
                . "itemCondition = '" . $_POST['itemCondition'] . "', "
                . "colour = '" . $_POST['colour'] . "', "
                . "size = '" . $_POST['size'] . "', "
                . "value = " . $_POST['value'] . ", "
                . "tradeItem = '" . $_POST['tradeItem'] . "', "
                . "tradeOption = '" . $_POST['tradeOption'] . "', "
                . "itemDescription = '" . $_POST['itemDescription'] . "' "
                . "WHERE itemid = '" . $current_data["itemid"] . "'";

//        echo '<script>alert("' . $sql . '");</script>';

        if ($dbc->query($sql)) {
            echo '<script>alert("Item details update successfully.");window.location.href="item_details.php?id=' . $current_data['itemid'] . '";</script>';
        }
    } else {
        echo '<script>alert("Update failed !\nContact IT department for maintainence")</script>';
    }
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo $current_data['itemid']; ?> (Item Details) - Tradee</title>
    </head>
    <body class="hold-transition sidebar-mini layout-fixed">
        <div class="wrapper">
            <div class="content-wrapper">
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6"></div>

                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="item_list.php">Item list</a></li>
                                    <li class="breadcrumb-item active">Item details</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

                <section class="content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h4 class="card-title" id="titleid" style="font-weight: bolder;">Item ID: <?php
                                        if (isset($current_data)) {
                                            echo $current_data["itemid"];
                                        }
                                        ?>
                                    </h4>
                                </div>

                                <div class="card-body">
                                    <form method="post" id="form" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="col-xl-6">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="col-12 img-container" style="width: 400px; height: 300px">
                                                            <img src="../img/test-shirt/drop_img.png" class="active-image" style="max-width: 400px; max-height: 300px;" alt="Product Image">
                                                        </div>

                                                        <div class="col-6 product-image-thumbs mt-3">
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
                                                        <div class="col-md-12" >
                                                            <div class="form-group" style="padding-top: 15px">
                                                                <div class="custom-file">
                                                                    <input type="file" multiple="multiple" accept="image/*" onchange="loadFile(event)" class="custom-file-input" id="img" disabled name="img[]">
                                                                    <label class="custom-file-label" id="validate_img">Choose file</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-6">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label>Customer ID:</label>
                                                        <div class="form-group">
                                                            <input class="form-control" id="custid" name="custid" readOnly value="<?php
                                                            if (isset($current_data)) {
                                                                echo $current_data["custid"];
                                                            }
                                                            ?>" name="custid">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-5">
                                                        <label>Item Name:</label>
                                                        <div class="form-group">                                             
                                                            <input class="form-control" id="itemname" name="itemname" readOnly value="<?php
                                                            if (isset($current_data)) {
                                                                echo $current_data["itemname"];
                                                            }
                                                            ?>">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label>Brand:</label>
                                                        <div class="form-group">
                                                            <input class="form-control" id="brand" name="brand" readOnly value="<?php
                                                            if (isset($current_data)) {
                                                                echo $current_data["brand"];
                                                            }
                                                            ?>" name="brand">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <label>Category:</label>
                                                        <div class="form-group">
                                                            <select class="custom-select" id="catname" name="catname" disabled>
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

                                                    <div class="col-md-4">
                                                        <label>Condition:</label>
                                                        <select class="custom-select" id="itemCondition" name="itemCondition" disabled>
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

                                                    <div class="col-md-2">
                                                        <label>Colour:</label>
                                                        <div class="form-group">
                                                            <input class="form-control" id="colour" readOnly value="<?php
                                                            if (isset($current_data)) {
                                                                echo $current_data["colour"];
                                                            }
                                                            ?>" name="colour">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-1">
                                                        <label>Size:</label>
                                                        <div class="form-group">
                                                            <input class="form-control" id="size" readOnly value="<?php
                                                            if (isset($current_data)) {
                                                                echo $current_data["size"];
                                                            }
                                                            ?>" name="size">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-2">
                                                        <label>Value:</label>
                                                        <div class="form-group">
                                                            <input class="form-control" id="value" readOnly onkeypress="return isNumberKey(event)" value="<?php
                                                            if (isset($current_data)) {
                                                                echo $current_data["value"];
                                                            }
                                                            ?>" name="value">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-1" style="display: none;">
                                                        <label>Favour:</label>
                                                        <div class="form-group">
                                                            <input class="form-control" id="favour" readOnly onkeypress="return isNumberKey(event)" value="<?php
                                                            if (isset($current_data)) {
                                                                echo $current_data["favour"];
                                                            }
                                                            ?>" name="favour">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label>Trade item:</label>
                                                        <div class="form-group">
                                                            <select class="custom-select" id="tradeItem" name="tradeItem" disabled>
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

                                                    <div class="col-md-3">
                                                        <label>Trade Option:</label>
                                                        <select class="custom-select" id="tradeOption" name="tradeOption" disabled>
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

                                                    <div class="col-md-3">
                                                        <label>Post Date:</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                                            </div>
                                                            <input type="text" class="form-control" placeholder="dd/mm/yyyy" id="postDate" maxlength="10" value="<?php
                                                            if (isset($current_data)) {
                                                                echo $current_data["postDate"];
                                                            }
                                                            ?>" readOnly name="postDate">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-2">
                                                        <label>Active:</label>
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" id="itemActive" value="<?php
                                                            if (isset($current_data)) {
                                                                echo $current_data["itemActive"];
                                                            }
                                                            ?>" readOnly name="itemActive">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <label>Description:</label>
                                                        <div class="form-group">
                                                            <textarea class="form-control" rows="5" id="itemDescription" name="itemDescription" readonly><?php
                                                                if (isset($current_data)) {
                                                                    echo $current_data["itemDescription"];
                                                                }
                                                                ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <button class="btn btn-dark" style="width:100%" id="btnback" onclick="back()">Back</button>
                                        </div>
                                    </div>

                                    <div class="col-md-9"></div>

                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <button class="btn btn-warning" style="width:100%" id="btncancel" onclick="cancel()" disabled>Cancel</button>
                                        </div>
                                    </div>

                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <button class="btn btn-primary" style="width:100%" id="btnsave" onclick="editorsave()">Edit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <?php include 'footer.php'; ?>
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

        function back() {
            var btnoption = document.getElementById("btnsave").textContent;
            if (btnoption === "Save") {
                if (confirm("Confirm to unsave ?")) {
                    window.location.href = "item_list.php";
                }
            } else {
                window.location.href = "item_list.php";
            }
        }

        function editable() {
            document.getElementById("btncancel").disabled = false;
            document.getElementById("btnsave").textContent = "Save";
            document.getElementById("img").disabled = false;
            document.getElementById("itemname").readOnly = false;
            document.getElementById("catname").disabled = false;
            document.getElementById("itemCondition").disabled = false;
            document.getElementById("value").readOnly = false;
            document.getElementById("itemDescription").readOnly = false;
            document.getElementById("brand").readOnly = false;
            document.getElementById("colour").readOnly = false;
            document.getElementById("size").readOnly = false;
            document.getElementById("favour").disabled = false;
            document.getElementById("tradeItem").disabled = false;
            document.getElementById("tradeOption").disabled = false;
        }

        function editorsave() {
            var btnoption = document.getElementById("btnsave").textContent;
            if (btnoption === "Save") {
                var fullfill = true;
                document.getElementById("itemname").style.borderColor = "";
                document.getElementById("brand").style.borderColor = "";
                document.getElementById("itemCondition").style.borderColor = "";
                document.getElementById("size").style.borderColor = "";
                document.getElementById("colour").style.borderColor = "";
                document.getElementById("value").style.borderColor = "";
                document.getElementById("itemDescription").style.borderColor = "";
                document.getElementById("validate_img").style.borderColor = "";

                if (!document.getElementById("itemname").value || document.getElementById("itemname").value === "") {
                    document.getElementById("itemname").style.borderColor = "red";
                    fullfill = false;
                }
                if (!document.getElementById("brand").value || document.getElementById("brand").value === "") {
                    document.getElementById("brand").style.borderColor = "red";
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
                if (!document.getElementById("itemDescription").value || document.getElementById("itemDescription").value === "") {
                    document.getElementById("itemDescription").style.borderColor = "red";
                    fullfill = false;
                }

                if (fullfill) {
                    if (confirm("Confirm to save the changes?")) {
                        document.getElementById("form").submit();
                    }
                }
            } else {
                editable();
            }
        }

        function cancel() {
            if (confirm("Confirm to unsave current information!")) {
                if (isnew) {
                    window.location.href = "item_list.php";
                } else {
                    window.location.href = currentURL;
                }
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

//        var loadFile = function (event) {
//            var image = document.getElementById('img_display');
//            image.src = URL.createObjectURL(event.target.files[0]);
//        };

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
    </script>
</html>