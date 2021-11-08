<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

        <title>Track delivery</title>
    </head>
    <body>
        <?php
        include '../include/header.php';
        ?>

        <div class="bg-navbar mb-3">
            <div class="container-lg">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb py-2 mb-0">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Profile</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Track my order</li>
                    </ol>
                </nav>
            </div>
        </div>
        
        <div class="container-fluid">
            <h2 class="text-center display-4">Search</h2>
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <!--<form action="simple-results.html">-->
                    <form action="">
                        <div class="input-group">
                            <input type="search" class="form-control form-control-lg" placeholder="Type your keywords here">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-lg btn-default">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="container-lg">
            <div class="row row-cols-auto py-3">
                <div class="col">
                    <div>Tracking Code</div>
                    <div>T00001</div>
                </div>
                <div class="col">
                    <div>Estimated Delivery date</div>
                    <div>23/6/2021</div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="stepper-wrapper">
                        <div class="stepper-item completed">
                            <div class="step-counter"><i class="fa fa-truck" style="font-size:25px;color:white"></i></div>
                            <div class="step-name"><b>Pickup</b></div>
                        </div>
                        <div class="stepper-item completed">
                            <div class="step-counter"><i class="material-icons" style="font-size:30px;color:white">compare_arrows</i></div>
                            <div class="step-name"><b>In Transit</b></div>
                        </div>
                        <div class="stepper-item active">
                            <div class="step-counter"><i class='fas fa-shipping-fast' style='font-size:25px;color:white'></i></div>
                            <div class="step-name"><b>Shipping</b></div>
                        </div>
                        <div class="stepper-item">
                            <div class="step-counter"><i class="fa fa-check" style="font-size:30px;color:white"></i></div>
                            <div class="step-name"><b>Delivered</b></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row pb-5">
                <div class="col pt-3">
                    <h1  style="font-size:20px; text-align: center; padding-left:60px; padding-right:20px;">Your items is ready for pickup and ready for packaging</h1>
                </div>
                <div class="col pt-3">
                    <h1  style="font-size:20px; text-align: center; padding-left:60px; padding-right:20px;">Your items has been packaged and ready for delivery</h1>
                </div>
                <div class="col pt-3">
                    <h1  style="font-size:20px; text-align: center; padding-left:60px; padding-right:20px;"> Your package is being shipped to its final destination</h1>
                </div>
                <div class="col pt-3">
                    <h1  style="font-size:20px; text-align: center; padding-left:60px; padding-right:20px;"> The delivery has arrived at its final destination</h1>
                </div>
            </div>
            <div class="row pb-3">
                <div class="col">
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label"><b>Please write a short description if there are any problems:</b></label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="6"></textarea>
                    </div>
                </div>
            </div>
            <div class="row pb-5">
                <div class="col-10"><button type="button" class="btn btn-primary btn-lg" style="background-color: #ff6666; width:100px">Back</button></div>
                <div class="col-1">
                </div>
                <div class="col-1">
                    <button type="button" class="btn btn-primary btn-lg" style="background-color:#00cccc;">Submit</button>
                </div>
            </div>
        </div>

        <?php
        include '../include/footer.php';
        ?>
    </body>
    <style>
        .bg-navbar{
            background: whitesmoke;
        }

        form.example input[type=text] {
            padding: 10px;
            font-size: 15px;
            border: 1px solid grey;
            float: left;
            width: 80%;
            background: white;
        }

        form.example button {
            float: left;
            width: 20%;
            padding: 10px;
            background: #FFD580;
            color: white;
            font-size: 15px;
            border: 1px solid grey;
            border-left: none;
            cursor: pointer;
        }

        form.example button:hover {
            background: #FFA500;
        }

        form.example::after {
            content: "";
            clear: both;
            display: table;
        }

        .stepper-wrapper {
            font-family: Arial;
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .stepper-item {
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            flex: 1;


        }

        .stepper-item::before {
            position: absolute;
            content: "";
            border-bottom: 2px solid #ccc;
            width: 100%;
            top: 20px;
            left: -50%;
            z-index: 2;
        }

        .stepper-item::after {
            position: absolute;
            content: "";
            border-bottom: 2px solid #ccc;
            width: 100%;
            top: 20px;
            left: 50%;
            z-index: 2;
        }

        .stepper-item .step-counter {
            position: relative;
            z-index: 5;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #ccc;
            margin-bottom: 6px;
        }

        .stepper-item.active {
            font-weight: bold;
        }

        .stepper-item.completed .step-counter {
            background-color: #40E0D0;
        }

        .stepper-item.completed::after {
            position: absolute;
            content: "";
            border-bottom: 2px solid #00cccc;
            width: 100%;
            top: 20px;
            left: 50%;
            z-index: 3;
        }

        .stepper-item:first-child::before {
            content: none;
        }
        .stepper-item:last-child::after {
            content: none;
        }
    </style>
</html>
