<?php
include '../include/header.php';

$sql = "SELECT * FROM delivery WHERE deliveryid = '" . $_GET['id'] . "' LIMIT 1";
$result = $dbc->query($sql);
if ($result->num_rows > 0) {
    while ($row = mysqli_fetch_array($result)) {
        $deliveryid = $row;
        break;
    }
} else {
    echo '<script>alert("Extract data error !\nContact IT department for maintainence");</script>';
}

//        if ($_SERVER["REQUEST_METHOD"] == "POST") {
//            $sql = "SELECT `feedbackid` FROM `feedback` ORDER BY `feedbackid` DESC LIMIT 1";
//            $result = $dbc->query($sql);
//            if ($result->num_rows > 0) {
//                while ($row = mysqli_fetch_array($result)) {
//                    $latestnum = ((int) substr($row['feedbackid'], 1)) + 1;
//                    $New_Id = "F{$latestnum}";
//                    break;
//                }
//            }
//
//            $sql = "INSERT INTO `feedback`(`feedbackid`, `custid`, `tradeid`, `comment`, `feedbackdate`, `status`) VALUES"
//                    . " ('{$New_Id}','{$_SESSION["loginuser"]["custid"]}','{$deliveryid["tradeid"]}','{$_POST["comment"]}','{$_POST["DateTime"]}','Pending')";
//            if ($dbc->query($sql)) {
//                echo '<script>alert("Succesfully submit!");</script>';
//                exit();
//            }
//        } else {
//            echo '<script>alert("Update failed !\nContact IT department for maintainence")</script>';
//        }
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

        <title>Track delivery</title>
    </head>
    <body>

        <div class="bg-navbar mb-3">
            <div class="container-lg">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb py-2 mb-0">
                        <li class="breadcrumb-item"><a href="../php/index.php">Home</a></li>
                        <li class="breadcrumb-item"><a href="../user/trade_list.php">My delivery list</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Track my delivery</li>
                    </ol>
                </nav>
            </div>
        </div>



        <div class="container-lg">
            <div class="row row-cols-auto py-3">
                <div class="col-6">
                    <div><b>Delivery ID: <?php echo $deliveryid["deliveryid"] ?></b></div>

                </div>
                <div class="col-4">
                    <div style="text-align:right;"> Estimated Receive Date : <?php echo $deliveryid["receiveDate"] ?> |</div>

                </div>
                <div class="col-2">
                    <div style="text-align:left; color:red"><b>Trade ID: <?php echo $deliveryid["tradeid"] ?> </b> </div>

                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="stepper-wrapper">
                        <div class="stepper-item <?php
                        if ($deliveryid["deliveryStatus"] == "Pickup") {
                            echo"active";
                        } else {
                            echo"completed";
                        }
                        ?>">
                            <div class="step-counter"><i class="fa fa-truck" style="font-size:25px;color:white"></i></div>
                            <div class="step-name"><b>Pickup</b></div>
                        </div>
                        <div class="stepper-item <?php
                        if ($deliveryid["deliveryStatus"] == "In Transit") {
                            echo"active";
                        } else {
                            if ($deliveryid["deliveryStatus"] == "Shipping" || $deliveryid["deliveryStatus"] == "Delivered") {
                                echo"completed";
                            }
                        }
                        ?>">
                            <div class="step-counter"><i class="material-icons" style="font-size:30px;color:white">compare_arrows</i></div>
                            <div class="step-name"><b>In Transit</b></div>
                        </div>
                        <div class="stepper-item <?php
                        if ($deliveryid["deliveryStatus"] == "Shipping") {
                            echo"active";
                        } else {
                            if ($deliveryid["deliveryStatus"] == "Delivered") {
                                echo"completed";
                            }
                        }
                        ?>">
                            <div class="step-counter"><i class='fas fa-shipping-fast' style='font-size:25px;color:white'></i></div>
                            <div class="step-name"><b>Shipping</b></div>
                        </div>
                        <div class="stepper-item <?php
                        if ($deliveryid["deliveryStatus"] == "Delivered") {
                            echo"completed";
                        }
                        ?>">
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

            <form method="post" id="form">
                <input type="text" class="form-control" id="DateTime" name="DateTime" style="display:none">

                <div class="row pb-3">
                    <div class="col">
                        <div class="mb-3">
                            <label for="exampleFormControlTextarea1" class="form-label"><b>Please write a short description if there are any problems:</b></label>
                            <textarea class="form-control" id="comment" name="comment" required rows="6"></textarea>
                        </div>
                    </div>
                </div>
                <div class="row pb-5">
                    <div class="col-10"><button type="button" onclick="back()" id="btnback" class="btn btn-primary btn-lg" style="background-color: #ff6666; width:100px">Back</button></div>
                    <div class="col-1">
                    </div>
                    <div class="col-1">
                        <button type="button" onclick="submit_comment()" class="btn btn-primary btn-lg" style="background-color:#00cccc;">Submit</button>
                    </div>
                </div>
            </form>

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
        .stepper-item.active .step-counter {
            background-color: #40E0D0;
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
    <script>
        function submit_comment() {
            var fullfill = true;
            var Today = new Date();
            var Today_Date = Today.getFullYear() + '/' + (Today.getMonth() + 1) + '/' + Today.getDate();
            document.getElementById("DateTime").value = Today_Date;
            if (!document.getElementById("comment").value || document.getElementById("comment").value === "") {
                document.getElementById("comment").style.borderColor = "red";
                fullfill = false;
            } else
                document.getElementById("form").submit();
        }

        var currentURL = window.location.href;

        function back() {
            window.location.href = "../user/trade_list.php";
        }



    </script>
</html>
