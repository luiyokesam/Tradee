<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Test</title>

        <!--favicon-->
        <link rel="shortcut icon" href="../img/icon/favicon.ico" type="image/x-icon">
        <!--<link rel="icon" href="../img/icon/favicon.ico" type="image/x-icon">-->


        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="../bootstrap/plugins/fontawesome-free/css/all.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="../bootstrap/dist/css/adminlte.min.css">
    </head>
    <body>
        <?php
        include '../include/header.php';
        ?>

        <div class="product">
            <div class="product-small-img">
                <img src="../img/test-shirt/test_shirt_5.jpg" onclick="myFunction(this)">
                <img src="../img/test-shirt/test_shirt_6.jpg" onclick="myFunction(this)">
                <img src="../img/test-shirt/test_shirt_7.jpg" onclick="myFunction(this)">
                <img src="../img/test-shirt/test_shirt_8.jpg" onclick="myFunction(this)">
            </div>

            <div class="img-container">
                <img src="../img/test-shirt/test_shirt_5.jpg" id="imageBox" onclick="myFunction(this)">
            </div>
        </div>

        <div class="container-lg my-3">
            <div class="row row-cols-xl-5 row-cols-lg-4 row-cols-md-3 row-cols-sm-2">
                <div class="col px-1 py-2">
                    <a href="../user/profile.php" style="text-decoration:none;">
                        <ul class="list-inline mb-0 p-1">
                            <img src="../img/header/user-icon.png" class="" style="width: 22px;" alt="...">
                            <li class="list-inline-item" style="font-size:0.7em; color:#969696;">Username</li>
                        </ul>
                    </a>
                    <div class="item-img-box">
                        <a href="../user/item_portfolio.php">
                            <img src="../img/test-shirt/test_shirt_5.jpg" class="img-fluid item-img" alt="...">
                        </a>
                    </div>
                    <div class="d-flex bd-highlight align-items-center p-1 pb-0">
                        <div class="flex-grow-1 bd-highlight" style="font-size:0.8em;">Item Name</div>
                        <div class="d-flex bd-highlight align-items-center">
                            <i class="far fa-heart me-auto" style="font-size:0.9em;"></i>
                            <!--<i class="fas fa-heart me-auto" style="font-size:0.9em;"></i>-->
                            <div class="flex-grow-1 bd-highlight ps-1" style="font-size:0.8em;"> 2</div>
                        </div>
                    </div>
                    <ul class="list-inline p-1 pt-0 mb-0">
                        <div class="flex-grow-1 bd-highlight" style="font-size:0.7em; color:#969696;">Size</div>
                        <div class="flex-grow-1 bd-highlight" style="font-size:0.7em; color:#969696;">Brand</div>
                    </ul>
                </div>
                <div class="col px-1 py-2">
                    <a href="../user/profile.php" style="text-decoration:none;">
                        <ul class="list-inline mb-0 p-1">
                            <img src="../img/header/user-icon.png" class="" style="width: 22px;" alt="...">
                            <li class="list-inline-item" style="font-size:0.7em; color:#969696;">Username</li>
                        </ul>
                    </a>
                    <div class="item-img-box">
                        <a href="../user/item_portfolio.php">
                            <img src="../img/test-shirt/test_shirt_3.jpg" class="item-img" alt="...">
                        </a>
                    </div>
                    <div class="d-flex bd-highlight align-items-center p-1 pb-0">
                        <div class="flex-grow-1 bd-highlight" style="font-size:0.8em;">Item Name</div>
                        <div class="d-flex bd-highlight align-items-center">
                            <i class="far fa-heart me-auto" style="font-size:0.9em;"></i>
                            <div class="flex-grow-1 bd-highlight ps-1" style="font-size:0.8em;"> 2</div>
                        </div>
                    </div>
                    <ul class="list-inline p-1 pt-0 mb-0">
                        <div class="flex-grow-1 bd-highlight" style="font-size:0.7em; color:#969696;">Size</div>
                        <div class="flex-grow-1 bd-highlight" style="font-size:0.7em; color:#969696;">Brand</div>
                    </ul>
                </div>
                <div class="col px-1 py-2">
                    <a href="../user/profile.php" style="text-decoration:none;">
                        <ul class="list-inline mb-0 p-1">
                            <img src="../img/header/user-icon.png" class="" style="width: 22px;" alt="...">
                            <li class="list-inline-item" style="font-size:0.7em; color:#969696;">Username</li>
                        </ul>
                    </a>
                    <div class="item-img-box">
                        <a href="../user/item_portfolio.php">
                            <img src="../img/test-shirt/test_shirt_4.jpg" class="item-img" alt="...">
                        </a>
                    </div>
                    <div class="d-flex bd-highlight align-items-center p-1 pb-0">
                        <div class="flex-grow-1 bd-highlight" style="font-size:0.8em;">Item Name</div>
                        <div class="d-flex bd-highlight align-items-center">
                            <i class="far fa-heart me-auto" style="font-size:0.9em;"></i>
                            <div class="flex-grow-1 bd-highlight ps-1" style="font-size:0.8em;"> 2</div>
                        </div>
                    </div>
                    <ul class="list-inline p-1 pt-0 mb-0">
                        <div class="flex-grow-1 bd-highlight" style="font-size:0.7em; color:#969696;">Size</div>
                        <div class="flex-grow-1 bd-highlight" style="font-size:0.7em; color:#969696;">Brand</div>
                    </ul>
                </div>
                <div class="col px-1 py-2">
                    <a href="../user/profile.php" style="text-decoration:none;">
                        <ul class="list-inline mb-0 p-1">
                            <img src="../img/header/user-icon.png" class="" style="width: 22px;" alt="...">
                            <li class="list-inline-item" style="font-size:0.7em; color:#969696;">Username</li>
                        </ul>
                    </a>
                    <div class="item-img-box">
                        <a href="../user/item_portfolio.php">
                            <img src="../img/test-shirt/test_shirt_5.jpg" class="item-img" alt="...">
                        </a>
                    </div>
                    <div class="d-flex bd-highlight align-items-center p-1 pb-0">
                        <div class="flex-grow-1 bd-highlight" style="font-size:0.8em;">Item Name</div>
                        <div class="d-flex bd-highlight align-items-center">
                            <i class="far fa-heart me-auto" style="font-size:0.9em;"></i>
                            <div class="flex-grow-1 bd-highlight ps-1" style="font-size:0.8em;"> 2</div>
                        </div>
                    </div>
                    <ul class="list-inline p-1 pt-0 mb-0">
                        <div class="flex-grow-1 bd-highlight" style="font-size:0.7em; color:#969696;">Size</div>
                        <div class="flex-grow-1 bd-highlight" style="font-size:0.7em; color:#969696;">Brand</div>
                    </ul>
                </div>
                <div class="col px-1 py-2">
                    <a href="../user/profile.php" style="text-decoration:none;">
                        <ul class="list-inline mb-0 p-1">
                            <img src="../img/header/user-icon.png" class="" style="width: 22px;" alt="...">
                            <li class="list-inline-item" style="font-size:0.7em; color:#969696;">Username</li>
                        </ul>
                    </a>
                    <div class="item-img-box">
                        <a href="../user/item_portfolio.php">
                            <img src="../img/test-shirt/test_shirt_6.jpg" class="item-img" alt="...">
                        </a>
                    </div>
                    <div class="d-flex bd-highlight align-items-center p-1 pb-0">
                        <div class="flex-grow-1 bd-highlight" style="font-size:0.8em;">Item Name</div>
                        <div class="d-flex bd-highlight align-items-center">
                            <i class="far fa-heart me-auto" style="font-size:0.9em;"></i>
                            <div class="flex-grow-1 bd-highlight ps-1" style="font-size:0.8em;"> 2</div>
                        </div>
                    </div>
                    <ul class="list-inline p-1 pt-0 mb-0">
                        <div class="flex-grow-1 bd-highlight" style="font-size:0.7em; color:#969696;">Size</div>
                        <div class="flex-grow-1 bd-highlight" style="font-size:0.7em; color:#969696;">Brand</div>
                    </ul>
                </div>
                <div class="col px-1 py-2">
                    <a href="../user/profile.php" style="text-decoration:none;">
                        <ul class="list-inline mb-0 p-1">
                            <img src="../img/header/user-icon.png" class="" style="width: 22px;" alt="...">
                            <li class="list-inline-item" style="font-size:0.7em; color:#969696;">Username</li>
                        </ul>
                    </a>
                    <div class="item-img-box">
                        <a href="../user/item_portfolio.php">
                            <img src="../img/test-shirt/test_shirt_7.jpg" class="item-img" alt="...">
                        </a>
                    </div>
                    <div class="d-flex bd-highlight align-items-center p-1 pb-0">
                        <div class="flex-grow-1 bd-highlight" style="font-size:0.8em;">Item Name</div>
                        <div class="d-flex bd-highlight align-items-center">
                            <i class="far fa-heart me-auto" style="font-size:0.9em;"></i>
                            <div class="flex-grow-1 bd-highlight ps-1" style="font-size:0.8em;"> 2</div>
                        </div>
                    </div>
                    <ul class="list-inline p-1 pt-0 mb-0">
                        <div class="flex-grow-1 bd-highlight" style="font-size:0.7em; color:#969696;">Size</div>
                        <div class="flex-grow-1 bd-highlight" style="font-size:0.7em; color:#969696;">Brand</div>
                    </ul>
                </div>
                <div class="col px-1 py-2">
                    <a href="../user/profile.php" style="text-decoration:none;">
                        <ul class="list-inline mb-0 p-1">
                            <img src="../img/header/user-icon.png" class="" style="width: 22px;" alt="...">
                            <li class="list-inline-item" style="font-size:0.7em; color:#969696;">Username</li>
                        </ul>
                    </a>
                    <div class="item-img-box">
                        <a href="../user/item_portfolio.php">
                            <img src="../img/test-shirt/test_shirt_8.jpg" class="item-img" alt="...">
                        </a>
                    </div>
                    <div class="d-flex bd-highlight align-items-center p-1 pb-0">
                        <div class="flex-grow-1 bd-highlight" style="font-size:0.8em;">Item Name</div>
                        <div class="d-flex bd-highlight align-items-center">
                            <i class="far fa-heart me-auto" style="font-size:0.9em;"></i>
                            <div class="flex-grow-1 bd-highlight ps-1" style="font-size:0.8em;"> 2</div>
                        </div>
                    </div>
                    <ul class="list-inline p-1 pt-0 mb-0">
                        <div class="flex-grow-1 bd-highlight" style="font-size:0.7em; color:#969696;">Size</div>
                        <div class="flex-grow-1 bd-highlight" style="font-size:0.7em; color:#969696;">Brand</div>
                    </ul>
                </div>
                <div class="col px-1 py-2">
                    <a href="../user/profile.php" style="text-decoration:none;">
                        <ul class="list-inline mb-0 p-1">
                            <img src="../img/header/user-icon.png" class="" style="width: 22px;" alt="...">
                            <li class="list-inline-item" style="font-size:0.7em; color:#969696;">Username</li>
                        </ul>
                    </a>
                    <div class="item-img-box">
                        <a href="../user/item_portfolio.php">
                            <img src="../img/test-shirt/test_shirt_7.jpg" class="item-img" alt="...">
                        </a>
                    </div>
                    <div class="d-flex bd-highlight align-items-center p-1 pb-0">
                        <div class="flex-grow-1 bd-highlight" style="font-size:0.8em;">Item Name</div>
                        <div class="d-flex bd-highlight align-items-center">
                            <i class="far fa-heart me-auto" style="font-size:0.9em;"></i>
                            <div class="flex-grow-1 bd-highlight ps-1" style="font-size:0.8em;"> 2</div>
                        </div>
                    </div>
                    <ul class="list-inline p-1 pt-0 mb-0">
                        <div class="flex-grow-1 bd-highlight" style="font-size:0.7em; color:#969696;">Size</div>
                        <div class="flex-grow-1 bd-highlight" style="font-size:0.7em; color:#969696;">Brand</div>
                    </ul>
                </div>
                <div class="col px-1 py-2">
                    <a href="../user/profile.php" style="text-decoration:none;">
                        <ul class="list-inline mb-0 p-1">
                            <img src="../img/header/user-icon.png" class="" style="width: 22px;" alt="...">
                            <li class="list-inline-item" style="font-size:0.7em; color:#969696;">Username</li>
                        </ul>
                    </a>
                    <div class="item-img-box">
                        <a href="../user/item_portfolio.php">
                            <img src="../img/test-shirt/test_shirt_5.jpg" class="item-img" alt="...">
                        </a>
                    </div>
                    <div class="d-flex bd-highlight align-items-center p-1 pb-0">
                        <div class="flex-grow-1 bd-highlight" style="font-size:0.8em;">Item Name</div>
                        <div class="d-flex bd-highlight align-items-center">
                            <i class="far fa-heart me-auto" style="font-size:0.9em;"></i>
                            <div class="flex-grow-1 bd-highlight ps-1" style="font-size:0.8em;"> 2</div>
                        </div>
                    </div>
                    <ul class="list-inline p-1 pt-0 mb-0">
                        <div class="flex-grow-1 bd-highlight" style="font-size:0.7em; color:#969696;">Size</div>
                        <div class="flex-grow-1 bd-highlight" style="font-size:0.7em; color:#969696;">Brand</div>
                    </ul>
                </div>
                <div class="col px-1 py-2">
                    <a href="../user/profile.php" style="text-decoration:none;">
                        <ul class="list-inline mb-0 p-1">
                            <img src="../img/header/user-icon.png" class="" style="width: 22px;" alt="...">
                            <li class="list-inline-item" style="font-size:0.7em; color:#969696;">Username</li>
                        </ul>
                    </a>
                    <div class="item-img-box">
                        <a href="../user/item_portfolio.php">
                            <img src="../img/test-shirt/test_shirt_3.jpg" class="item-img" alt="...">
                        </a>
                    </div>
                    <div class="d-flex bd-highlight align-items-center p-1 pb-0">
                        <div class="flex-grow-1 bd-highlight" style="font-size:0.8em;">Item Name</div>
                        <div class="d-flex bd-highlight align-items-center">
                            <i class="far fa-heart me-auto" style="font-size:0.9em;"></i>
                            <div class="flex-grow-1 bd-highlight ps-1" style="font-size:0.8em;"> 2</div>
                        </div>
                    </div>
                    <ul class="list-inline p-1 pt-0 mb-0">
                        <div class="flex-grow-1 bd-highlight" style="font-size:0.7em; color:#969696;">Size</div>
                        <div class="flex-grow-1 bd-highlight" style="font-size:0.7em; color:#969696;">Brand</div>
                    </ul>
                </div>
                <div class="col px-1 py-2">
                    <a href="../user/profile.php" style="text-decoration:none;">
                        <ul class="list-inline mb-0 p-1">
                            <img src="../img/header/user-icon.png" class="" style="width: 22px;" alt="...">
                            <li class="list-inline-item" style="font-size:0.7em; color:#969696;">Username</li>
                        </ul>
                    </a>
                    <div class="item-img-box">
                        <a href="../user/item_portfolio.php">
                            <img src="../img/test-shirt/test_shirt_4.jpg" class="item-img" alt="...">
                        </a>
                    </div>
                    <div class="d-flex bd-highlight align-items-center p-1 pb-0">
                        <div class="flex-grow-1 bd-highlight" style="font-size:0.8em;">Item Name</div>
                        <div class="d-flex bd-highlight align-items-center">
                            <i class="far fa-heart me-auto" style="font-size:0.9em;"></i>
                            <div class="flex-grow-1 bd-highlight ps-1" style="font-size:0.8em;"> 2</div>
                        </div>
                    </div>
                    <ul class="list-inline p-1 pt-0 mb-0">
                        <div class="flex-grow-1 bd-highlight" style="font-size:0.7em; color:#969696;">Size</div>
                        <div class="flex-grow-1 bd-highlight" style="font-size:0.7em; color:#969696;">Brand</div>
                    </ul>
                </div>
            </div>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Quick Example <small>jQuery Validation</small></h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form id="quickForm" novalidate="novalidate">
                <div class="card-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email address</label>
                        <input type="email" name="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Password</label>
                        <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Password</label>
                        <input type="tel" name="test" class="form-control" id="exampleInput" placeholder="Password">
                    </div>
                    <div class="form-group mb-0">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" name="terms" class="custom-control-input" id="exampleCheck1">
                            <label class="custom-control-label" for="exampleCheck1">I agree to the <a href="#">terms of service</a>.</label>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>

        <?php
        include '../include/footer.php';
        ?>
        <!-- jQuery -->
        <script src="../bootstrap/plugins/jquery/jquery.min.js"></script>
        <!-- Bootstrap 4 -->
        <script src="../bootstrap/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- jquery-validation -->
        <script src="../bootstrap/plugins/jquery-validation/jquery.validate.min.js"></script>
        <script src="../bootstrap/plugins/jquery-validation/additional-methods.min.js"></script>
        <!-- AdminLTE App -->
        <script src="../bootstrap/dist/js/adminlte.min.js"></script>
        <!-- AdminLTE for demo purposes -->
        <script src="../bootstrap/dist/js/demo.js"></script>
        <!-- Page specific script -->
        <script>
                    function myFunction(smallImg) {
                        var fullImg = document.getElementById("imageBox");
                        fullImg.src = smallImg.src;
                    }
        </script>
        <script>
            $(function () {
                $.validator.setDefaults({
                    submitHandler: function () {
                        alert("Form successful submitted!");
                    }
                });
                $('#quickForm').validate({
                    rules: {
                        email: {
                            required: true,
                            email: true,
                        },
                        password: {
                            required: true,
                            minlength: 5
                        },
                        test: {
                            required: true,
                            minlength: 5
                        },
                        terms: {
                            required: true
                        },
                    },
                    messages: {
                        email: {
                            required: "Please enter a email address",
                            email: "Please enter a vaild email address"
                        },
                        password: {
                            required: "Please provide a password",
                            minlength: "Your password must be at least 5 characters long"
                        },
                        terms: "Please accept our terms"
                    },
                    errorElement: 'span',
                    errorPlacement: function (error, element) {
                        error.addClass('invalid-feedback');
                        element.closest('.form-group').append(error);
                    },
                    highlight: function (element, errorClass, validClass) {
                        $(element).addClass('is-invalid');
                    },
                    unhighlight: function (element, errorClass, validClass) {
                        $(element).removeClass('is-invalid');
                    }
                });
            });
        </script>
    </body>
    <style>
        .item-img-box{
            /*width: 192px;*/
            /*height: 192px;*/
            /*            width: 142px;
                        height: 142px;*/
            background: whitesmoke;
            /*background: #e8e8e8;*/
            text-align: center;
            /*object-fit: cover;*/
        }

        .item-img{
            /*            width: 230px;
                        height: 350px*/
            /*width: 100%;*/
            max-width: 255px;
            /*min-height: 370px;*/
            max-height: 370px;
            /*height: auto;*/
            background-size: 100% 100%;
        }

        .fa-heart:hover{
            color: red;
        }

        .product-small-img img{
            height: 92px;
            margin: 10px 0;
            cursor: pointer;
            display: block;
            opacity: 0.6;
        }

        .product-small-img img:hover{
            opacity: 1;
        }

        .product-small-img{
            float: left;
        }

        .product{

        }

        .img-container img{
            height: 500px;
        }

        .img-container{
            /*float: right;*/
            padding: 10px;
        }
    </style>
</html>