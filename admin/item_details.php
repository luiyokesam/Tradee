<?php
include 'navbar.php';

$category_array = array();
$sql = "SELECT name FROM category";
$result = $dbc->query($sql);
if ($result->num_rows > 0) {
    while ($row = mysqli_fetch_array($result)) {
        $category_array[] = $row['name'];
    }
}

$trade_option_array = array();
$sql = "SELECT tradeOption FROM item";
$result = $dbc->query($sql);
if ($result->num_rows > 0) {
    while ($row = mysqli_fetch_array($result)) {
        $trade_option_array[] = $row['tradeOption'];
    }
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM item i, item_image m WHERE i.itemid = m.itemid AND i.itemid = '$id' LIMIT 1";
    $result = $dbc->query($sql);
    if ($result->num_rows > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $current_data = $row;
            $title = "Item detail ({$current_data['itemid']})";
            echo '<script>var current_data = ' . json_encode($current_data) . ';</script>';
            $view = true;
            break;
        }
    } else {
        echo '<script>alert("Extract data error !\nContact IT department for maintainence");window.location.href = "item_details.php";</script>';
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

        $sql = "UPDATE item"
                . " SET img = '" . $newimg . "', "
                . " itemname= '" . $_POST['itemname'] . "', "
                . "brand = '" . $_POST['brand'] . "', "
                . "catname = '" . $_POST['catname'] . "', "
                . "itemCondition = '" . $_POST['itemCondition'] . "', "
                . "quantity = " . $_POST['quantity'] . ", "
                . "weight = " . $_POST['weight'] . ", "
                . "value = " . $_POST['value'] . ", "
                . "tradeItem = '" . $_POST['tradeItem'] . "', "
                . "tradeOption = '" . $_POST['tradeOption'] . "', "
                . "itemDescription = '" . $_POST['itemDescription'] . "' "
                . "WHERE itemid = '" . $current_data["itemid"] . "'";
        
        echo '<script>alert("' . $sql . '");</script>';

        if ($dbc->query($sql)) {
            if ($img) {
                move_uploaded_file($_FILES['img']['tmp_name'], "../item_img/$img");
            }
            echo '<script>alert("Successfuly update !");window.location.href="item_details.php?id=' . $_POST['itemid'] . '";</script>';
            exit();
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
    <body class="hold-transition sidebar-mini layout-fixed" onload="addnew()">
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
                                        } else {
                                            echo "(New) " . $newid;
                                        }
                                        ?>
                                    </h4>
                                </div>

                                <div class="card-body">
                                    <form method="post" id="form" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="col-md-12">
                                                            <img class="img-fluid mb-12" src="<?php
                                                            if (isset($current_data)) {
                                                                echo $current_data["img"];
                                                            }
                                                            ?>" alt="Photo" style="width: 100%; height: 500px; padding-top: 10px" id="img_display" name="img_display">
                                                        </div>
                                                        <div class="col-md-12" >
                                                            <div class="form-group" style="padding-top: 15px">
                                                                <div class="custom-file">
                                                                    <input type="file" accept="image/*" onchange="loadFile(event)" class="custom-file-input" id="img" disabled name="img">
                                                                    <label class="custom-file-label" id="validate_img">Choose file</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-9">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label>Customer ID :</label>
                                                        <div class="form-group">
                                                            <input class="form-control" id="custid" name="custid" readOnly value="<?php
                                                            if (isset($current_data)) {
                                                                echo $current_data["custid"];
                                                            }
                                                            ?>" name="custid">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-5">
                                                        <label>Item Name : </label>
                                                        <div class="form-group">                                             
                                                            <input class="form-control" id="itemname" name="itemname" readOnly value="<?php
                                                            if (isset($current_data)) {
                                                                echo $current_data["itemname"];
                                                            }
                                                            ?>">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label>Brand :</label>
                                                        <div class="form-group">
                                                            <input class="form-control" id="brand" name="brand" readOnly value="<?php
                                                            if (isset($current_data)) {
                                                                echo $current_data["brand"];
                                                            }
                                                            ?>" name="brand">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <label>Category :</label>
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

                                                    <div class="col-md-2">
                                                        <label>Condition :</label>
                                                        <div class="form-group">                                             
                                                            <input class="form-control" id="itemCondition" readOnly onkeypress="return isNumberKey(event)" value="<?php
                                                            if (isset($current_data)) {
                                                                echo $current_data["itemCondition"];
                                                            }
                                                            ?>" name="itemCondition"> 
                                                        </div>
                                                    </div>

                                                    <div class="col-md-2">
                                                        <label>Quantity :</label>
                                                        <div class="form-group">                                             
                                                            <input class="form-control" id="quantity" readOnly onkeypress="return isNumberKey(event)"  value="<?php
                                                            if (isset($current_data)) {
                                                                echo $current_data["quantity"];
                                                            }
                                                            ?>" name="quantity">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-2">
                                                        <label>Weight :</label>
                                                        <div class="form-group">                                             
                                                            <input class="form-control" id="weight" readOnly onkeypress="return isNumberKey(event)" value="<?php
                                                            if (isset($current_data)) {
                                                                echo $current_data["weight"];
                                                            }
                                                            ?>" name="weight">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-2">
                                                        <label>Value :</label>
                                                        <div class="form-group">                                             
                                                            <input class="form-control" id="value" readOnly onkeypress="return isNumberKey(event)" value="<?php
                                                            if (isset($current_data)) {
                                                                echo $current_data["value"];
                                                            }
                                                            ?>" name="value">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-1">
                                                        <label>Favour :</label>
                                                        <div class="form-group">                                             
                                                            <input class="form-control" id="favour" readOnly onkeypress="return isNumberKey(event)" value="<?php
                                                            if (isset($current_data)) {
                                                                echo $current_data["favour"];
                                                            }
                                                            ?>" name="favour">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label>Trade item :</label>
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
                                                        <label>Trade Option :</label>
                                                        <select class="custom-select" id="tradeOption" name="tradeOption" disabled>
                                                            <?php
                                                            foreach ($trade_option_array as $selection) {
                                                                $selected = ($current_data["tradeOption"] == $selection) ? "selected" : "";
                                                                echo '<option ' . $selected . ' value="' . $selection . '">' . $selection . '</option>';
                                                            }
                                                            echo '</select>';
                                                            ?>
                                                        </select>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <label>Post Date :</label>
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
                                                        <label>Active :</label>
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" id="itemActive" value="<?php
                                                            if (isset($current_data)) {
                                                                echo $current_data["itemActive"];
                                                            }
                                                            ?>" readOnly name="itemActive">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <label>Description :</label>
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
        var currentURL = window.location.href;
        var isnew = false;

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
            document.getElementById("brand").readOnly = false;
            document.getElementById("catname").disabled = false;
            document.getElementById("itemCondition").readOnly = false;
            document.getElementById("quantity").readOnly = false;
            document.getElementById("weight").readOnly = false;
            document.getElementById("favour").disabled = false;
            document.getElementById("value").readOnly = false;
            document.getElementById("tradeItem").disabled = false;
            document.getElementById("tradeOption").disabled = false;
            document.getElementById("itemDescription").readOnly = false;
        }

        function editorsave() {
            var btnoption = document.getElementById("btnsave").textContent;
            if (btnoption === "Save") {
                var fullfill = true;
                document.getElementById("itemname").style.borderColor = "";
                document.getElementById("brand").style.borderColor = "";
                document.getElementById("itemCondition").style.borderColor = "";
                document.getElementById("quantity").style.borderColor = "";
                document.getElementById("weight").style.borderColor = "";
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
                if (!document.getElementById("quantity").value || document.getElementById("quantity").value === "") {
                    document.getElementById("quantity").style.borderColor = "red";
                    fullfill = false;
                }
                if (!document.getElementById("weight").value || document.getElementById("weight").value === "") {
                    document.getElementById("weight").style.borderColor = "red";
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
                    if (confirm("Confirm to save ?")) {
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

        var loadFile = function (event) {
            var image = document.getElementById('img_display');
            image.src = URL.createObjectURL(event.target.files[0]);
        };
    </script>
</html>