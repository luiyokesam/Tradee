<?php
include 'navbar.php';
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Contact details</title>
    </head>
    <body class="hold-transition sidebar-mini layout-fixed" onload="addnew()">
        <div class="wrapper">
            <div class="content-wrapper">
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0 text-dark">Product detail</h1>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="product_list.php">Products</a></li>
                                    <li class="breadcrumb-item active">Product detail</li>
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
                                    <h3 class="card-title" id="titleid">Contact Details</h3>
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
                                                            ?>" alt="Photo" style="width: 100%;height:500px;padding-top: 10px" id="img_display" name="img_display">
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

                                                    <div class="col-md-6">
                                                        <label>Customer ID </label>
                                                        <div class="form-group">                                             
                                                            <input class="form-control" readonly value="">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label>Customer Type</label>
                                                        <div class="form-group">                                             
                                                            <input class="form-control" id="name" name="name" readOnly value="">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label>Email Address</label>
                                                        <div class="form-group">                                             
                                                            <input class="form-control" id="name" name="name" readOnly value="">
                                                        </div>
                                                        </div>
                                                    

                                                    <div class="col-md-6">
                                                        <label>Order SN</label>
                                                        <div class="form-group">                                             
                                                            <input class="form-control" id="size" readOnly onkeypress="return isNumberKey(event)" value="<?php
                                                            if (isset($current_data)) {
                                                                echo $current_data["size"];
                                                            }
                                                            ?>" name="size"> 
                                                        </div>
                                                    </div>

                                                   

                                                    <div class="col-md-12">
                                                        <label>Description :</label>
                                                        <div class="form-group">
                                                            <textarea class="form-control" rows="5" id="description" readOnly name="description"><?php
                                                                if (isset($current_data)) {
                                                                    echo $current_data["description"];
                                                                }
                                                                ?></textarea>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-12">
                                                        <label>Reply</label>
                                                        <div class="form-group">
                                                            <textarea class="form-control" rows="10" id="description" readOnly name="description"><?php
                                                                if (isset($current_data)) {
                                                                    echo $current_data["description"];
                                                                }
                                                                ?></textarea>
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
                                         
                                        </div>
                                    </div>

                                    <div class="col-md-9"></div>

                                    <div class="col-md-1">
                                        <div class="form-group">
                                          
                                        </div>
                                    </div>

                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <button class="btn btn-primary" style="width:100%">Send</button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </section>
    </div>
</div>
<?php include 'footer.php'; ?>
</body>
</html>

<script>
    var currentURL = window.location.href;
    var input = document.getElementById("release_date");
    var isnew = false;
    function back() {
        var btnoption = document.getElementById("btnsave").textContent;
        if (btnoption === "Save") {
            if (confirm("Confirm to unsave ?")) {
                window.location.href = "product_list.php";
            }
        } else {
            window.location.href = "product_list.php";
        }
    }

    var dateInputMask = function dateInputMask(elm) {
        elm.addEventListener('keypress', function (e) {
            if (e.keyCode < 47 || e.keyCode > 57) {
                e.preventDefault();
            }

            var len = elm.value.length;

            if (len !== 1 || len !== 3) {
                if (e.keyCode === 47) {
                    e.preventDefault();
                }
            }

            if (len === 2) {
                elm.value += '/';
            }

            if (len === 5) {
                elm.value += '/';
            }
        });
    };

    dateInputMask(input);

    function editable() {
        document.getElementById("btnsave").textContent = "Save";
        document.getElementById("btncancel").disabled = false;
        document.getElementById("img").disabled = false;
        document.getElementById("name").readOnly = false;
        document.getElementById("release_date").readOnly = false;
        document.getElementById("size").readOnly = false;
        document.getElementById("weight").readOnly = false;
        document.getElementById("price").readOnly = false;
        document.getElementById("discount").readOnly = false;
        document.getElementById("qty").readOnly = false;
        document.getElementById("category").disabled = false;
        document.getElementById("description").readOnly = false;
        document.getElementById("customRadio1").disabled = false;
        document.getElementById("customRadio1").checked = true;
        document.getElementById("customRadio2").disabled = false;
    }

    function addnew() {
        var params = new window.URLSearchParams(window.location.search);
        if (!params.get('id')) {
            isnew = true;
            editable();
            var today = new Date();
            var dd = String(today.getDate()).padStart(2, '0');
            var mm = String(today.getMonth() + 1).padStart(2, '0');
            var yyyy = today.getFullYear();
            document.getElementById("release_date").value = dd + '/' + mm + '/' + yyyy;
        }
    }

    function editorsave() {
        var btnoption = document.getElementById("btnsave").textContent;
        if (btnoption === "Save") {
            var fullfill = true;
            document.getElementById("name").style.borderColor = "";
            document.getElementById("price").style.borderColor = "";
            document.getElementById("category").style.borderColor = "";
            document.getElementById("validate_img").style.borderColor = "";

            if (!document.getElementById("name").value || document.getElementById("name").value === "") {
                document.getElementById("name").style.borderColor = "red";
                fullfill = false;
            }
            if (!document.getElementById("price").value || document.getElementById("price").value === "") {
                document.getElementById("price").style.borderColor = "red";
                fullfill = false;
            }
            if (!document.getElementById("category").value || document.getElementById("category").value === "") {
                document.getElementById("category").style.borderColor = "red";
                fullfill = false;
            }
            var img = document.getElementById('img_display');
            if (!document.getElementById("img").value || document.getElementById("img").value === "") {
                if (img.getAttribute('src') === "") {
                    document.getElementById("validate_img").style.borderColor = "red";
                    fullfill = false;
                }
            }

            if (fullfill) {
                if (confirm("Confirm to save ?")) {
                    if (!document.getElementById("size").value) {
                        document.getElementById("size").value = "'null'";
                    }
                    if (!document.getElementById("weight").value) {
                        document.getElementById("weight").value = "'null'";
                    }
                    if (!document.getElementById("description").value) {
                        document.getElementById("description").value = null;
                    }
                    if (!document.getElementById("discount").value) {
                        document.getElementById("discount").value = "'null'";
                    }
                    if (!document.getElementById("qty").value) {
                        document.getElementById("qty").value = "'null'";
                    }
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
                window.location.href = "product_list.php";
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

    function cal() {

        if (document.getElementById("discount").value > 100) {
            alert("Discount not more than 100");
            document.getElementById("discount").value = null;
        } else {
            var price = document.getElementById("price").value;
            var discount = price * (document.getElementById("discount").value / 100);
            document.getElementById("actual_price").value = Number(price).toFixed(2) - Number(discount).toFixed(2);
        }

    }

    var loadFile = function (event) {
        var image = document.getElementById('img_display');
        image.src = URL.createObjectURL(event.target.files[0]);
    };
</script>

