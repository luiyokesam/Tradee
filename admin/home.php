<?php
$page = 'home';
include 'navbar.php';

$sql_location = "SELECT COUNT(custid), country FROM customer WHERE active = 1 GROUP BY country;";
$result_location = $dbc->query($sql_location);

$sql_brand = "SELECT COUNT(itemid), brand FROM item GROUP BY brand;";
$result_brand = $dbc->query($sql_brand);

$sql_category = "SELECT COUNT(i.itemid), c.name FROM item i, category c WHERE i.catname = c.name AND c.active = 1 GROUP BY c.name";
$result_category = $dbc->query($sql_category);

$sql_delivery = "SELECT * FROM delivery";
$result_delivery = $dbc->query($sql_delivery);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Dashboard</title>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
            google.charts.load('current', {'packages': ['geochart'], });
            google.charts.setOnLoadCallback(drawRegionsMap);

            function drawRegionsMap() {
                var data = google.visualization.arrayToDataTable([
                    ['Country', 'Number'], <?php
while ($row_location = mysqli_fetch_array($result_location)) {
    echo "['" . $row_location[1] . "', " . $row_location[0] . "],";
}
?>]);
                var options = {title: 'Percentage of Male and Female Employee', colors: ['yellow', 'red']};
                var chart = new google.visualization.GeoChart(document.getElementById('regions_div'));
                chart.draw(data, options);
            }
        </script>

        <script type="text/javascript">
            google.charts.load('current', {'packages': ['corechart']});
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {

                var data = google.visualization.arrayToDataTable([
                    ['Category', 'Number'],<?php
while ($row_brand = mysqli_fetch_array($result_brand)) {
    echo "['" . $row_brand[1] . "', " . $row_brand[0] . "],";
}
?>]);

                var options = {};
                var chart = new google.visualization.PieChart(document.getElementById('piechart'));

                chart.draw(data, options);
            }
        </script>

        <script type="text/javascript">
            google.charts.load("current", {packages: ["corechart"]});
            google.charts.setOnLoadCallback(drawChart);
            function drawChart() {
                var data = google.visualization.arrayToDataTable([
                    ['Category', 'Number'], <?php
while ($row_category = mysqli_fetch_array($result_category)) {
    echo "['" . $row_category[1] . "', " . $row_category[0] . "],";
}
?>]);

                var options = {pieHole: 0.4};

                var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
                chart.draw(data, options);
            }
        </script>

        <script type="text/javascript">
            google.charts.load('current', {'packages': ['corechart']});
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {
                var data = google.visualization.arrayToDataTable([
                    ['Month', 'Sales'],
                    ['Jan', <?php
$sql_delivery = "SELECT * FROM delivery";
$result_delivery = $dbc->query($sql_delivery);
if ($result_delivery->num_rows > 0) {
    $amount = 0;
    while ($row_delivery = mysqli_fetch_array($result_delivery)) {
        $curYear = date('Y');
        $curMonth = "01";
        $year = substr($row_delivery["paymentDate"], 6, 9);
        $month = substr($row_delivery["paymentDate"], 3, 2);

        if ($curYear == $year && $curMonth == $month) {
            $amount += $row_delivery['totalAmount'];
        }
    }
    echo $amount;
} else {
    echo 0;
}
?>],
                    ['Feb', <?php
$sql_delivery = "SELECT * FROM delivery";
$result_delivery = $dbc->query($sql_delivery);
if ($result_delivery->num_rows > 0) {
    $amount = 0;
    while ($row_delivery = mysqli_fetch_array($result_delivery)) {
        $curYear = date('Y');
        $curMonth = "02";
        $year = substr($row_delivery["paymentDate"], 6, 9);
        $month = substr($row_delivery["paymentDate"], 3, 2);

        if ($curYear == $year && $curMonth == $month) {
            $amount += $row_delivery['totalAmount'];
        }
    }
    echo $amount;
} else {
    echo 0;
}
?>],
                    ['Mar', <?php
$sql_delivery = "SELECT * FROM delivery";
$result_delivery = $dbc->query($sql_delivery);
if ($result_delivery->num_rows > 0) {
    $amount = 0;
    while ($row_delivery = mysqli_fetch_array($result_delivery)) {
        $curYear = date('Y');
        $curMonth = "03";
        $year = substr($row_delivery["paymentDate"], 6, 9);
        $month = substr($row_delivery["paymentDate"], 3, 2);

        if ($curYear == $year && $curMonth == $month) {
            $amount += $row_delivery['totalAmount'];
        }
    }
    echo $amount;
} else {
    echo 0;
}
?>],
                    ['Apr', <?php
$sql_delivery = "SELECT * FROM delivery";
$result_delivery = $dbc->query($sql_delivery);
if ($result_delivery->num_rows > 0) {
    $amount = 0;
    while ($row_delivery = mysqli_fetch_array($result_delivery)) {
        $curYear = date('Y');
        $curMonth = "04";
        $year = substr($row_delivery["paymentDate"], 6, 9);
        $month = substr($row_delivery["paymentDate"], 3, 2);

        if ($curYear == $year && $curMonth == $month) {
            $amount += $row_delivery['totalAmount'];
        }
    }
    echo $amount;
} else {
    echo 0;
}
?>],
                    ['May', <?php
$sql_delivery = "SELECT * FROM delivery";
$result_delivery = $dbc->query($sql_delivery);
if ($result_delivery->num_rows > 0) {
    $amount = 0;
    while ($row_delivery = mysqli_fetch_array($result_delivery)) {
        $curYear = date('Y');
        $curMonth = "05";
        $year = substr($row_delivery["paymentDate"], 6, 9);
        $month = substr($row_delivery["paymentDate"], 3, 2);

        if ($curYear == $year && $curMonth == $month) {
            $amount += $row_delivery['totalAmount'];
        }
    }
    echo $amount;
} else {
    echo 0;
}
?>],
                    ['Jun', <?php
$sql_delivery = "SELECT * FROM delivery";
$result_delivery = $dbc->query($sql_delivery);
if ($result_delivery->num_rows > 0) {
    $amount = 0;
    while ($row_delivery = mysqli_fetch_array($result_delivery)) {
        $curYear = date('Y');
        $curMonth = "06";
        $year = substr($row_delivery["paymentDate"], 6, 9);
        $month = substr($row_delivery["paymentDate"], 3, 2);

        if ($curYear == $year && $curMonth == $month) {
            $amount += $row_delivery['totalAmount'];
        }
    }
    echo $amount;
} else {
    echo 0;
}
?>],
                    ['Jul', <?php
$sql_delivery = "SELECT * FROM delivery";
$result_delivery = $dbc->query($sql_delivery);
if ($result_delivery->num_rows > 0) {
    $amount = 0;
    while ($row_delivery = mysqli_fetch_array($result_delivery)) {
        $curYear = date('Y');
        $curMonth = "07";
        $year = substr($row_delivery["paymentDate"], 6, 9);
        $month = substr($row_delivery["paymentDate"], 3, 2);

        if ($curYear == $year && $curMonth == $month) {
            $amount += $row_delivery['totalAmount'];
        }
    }
    echo $amount;
} else {
    echo 0;
}
?>],
                    ['Aug', <?php
$sql_delivery = "SELECT * FROM delivery";
$result_delivery = $dbc->query($sql_delivery);
if ($result_delivery->num_rows > 0) {
    $amount = 0;
    while ($row_delivery = mysqli_fetch_array($result_delivery)) {
        $curYear = date('Y');
        $curMonth = "08";
        $year = substr($row_delivery["paymentDate"], 6, 9);
        $month = substr($row_delivery["paymentDate"], 3, 2);

        if ($curYear == $year && $curMonth == $month) {
            $amount += $row_delivery['totalAmount'];
        }
    }
    echo $amount;
} else {
    echo 0;
}
?>],
                    ['Sept', <?php
$sql_delivery = "SELECT * FROM delivery";
$result_delivery = $dbc->query($sql_delivery);
if ($result_delivery->num_rows > 0) {
    $amount = 0;
    while ($row_delivery = mysqli_fetch_array($result_delivery)) {
        $curYear = date('Y');
        $curMonth = "09";
        $year = substr($row_delivery["paymentDate"], 6, 9);
        $month = substr($row_delivery["paymentDate"], 3, 2);

        if ($curYear == $year && $curMonth == $month) {
            $amount += $row_delivery['totalAmount'];
        }
    }
    echo $amount;
} else {
    echo 0;
}
?>],
                    ['Oct', <?php
$sql_delivery = "SELECT * FROM delivery";
$result_delivery = $dbc->query($sql_delivery);
if ($result_delivery->num_rows > 0) {
    $amount = 0;
    while ($row_delivery = mysqli_fetch_array($result_delivery)) {
        $curYear = date('Y');
        $curMonth = "10";
        $year = substr($row_delivery["paymentDate"], 6, 9);
        $month = substr($row_delivery["paymentDate"], 3, 2);

        if ($curYear == $year && $curMonth == $month) {
            $amount += $row_delivery['totalAmount'];
        }
    }
    echo $amount;
} else {
    echo 0;
}
?>],
                    ['Nov', <?php
$sql_delivery = "SELECT * FROM delivery";
$result_delivery = $dbc->query($sql_delivery);
if ($result_delivery->num_rows > 0) {
    $amount = 0;
    while ($row_delivery = mysqli_fetch_array($result_delivery)) {
        $curYear = date('Y');
        $curMonth = "11";
        $year = substr($row_delivery["paymentDate"], 6, 9);
        $month = substr($row_delivery["paymentDate"], 3, 2);

//        echo $year;
//        echo $month;
//        echo $curYear;
//        echo $curMonth;
//        echo '<script>console.log("' . $year . '");</script>';
//        echo '<script>console.log("' . $month . '");</script>';
//        echo '<script>console.log("' . $curYear . '");</script>';
//        echo '<script>console.log("' . $curMonth . '");</script>';

        if ($curYear == $year && $curMonth == $month) {
            $amount += $row_delivery['totalAmount'];
        }
    }
    echo $amount;
} else {
    echo 0;
}
?>],
                    ['Dec', <?php
$sql_delivery = "SELECT * FROM delivery";
$result_delivery = $dbc->query($sql_delivery);
if ($result_delivery->num_rows > 0) {
    $amount = 0;
    while ($row_delivery = mysqli_fetch_array($result_delivery)) {
        $curYear = date('Y');
        $curMonth = "12";
        $year = substr($row_delivery["paymentDate"], 6, 9);
        $month = substr($row_delivery["paymentDate"], 3, 2);
        if ($curYear == $year && $curMonth == $month) {
            $amount += $row_delivery['totalAmount'];
        }
    }
    echo $amount;
} else {
    echo 0;
}
?>]
                ]);

                var options = {curveType: 'function', legend: {position: 'bottom'}};
                var chart = new google.visualization.LineChart(document.getElementById('curve_chart1'));
                chart.draw(data, options);
            }
        </script>

        <script type="text/javascript">
            google.charts.load('current', {'packages': ['corechart']});
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {
                var data = google.visualization.arrayToDataTable([
                    ['Year', 'Success', 'Failed'],
                    ['Jan', <?php
$sql_trade = "SELECT * FROM trade WHERE status != 'Rejected'";
$result_trade = $dbc->query($sql_trade);
if ($result_trade->num_rows > 0) {
    $count = 0;
    while ($row_trade = mysqli_fetch_array($result_trade)) {
        $curYear = date('Y');
        $curMonth = "01";
        $year = substr($row_trade["tradeDate"], 6, 9);
        $month = substr($row_trade["tradeDate"], 3, 2);
        if ($curYear == $year && $curMonth == $month) {
            $count += 1;
        }
    }
    echo $count;
} else {
    echo 0;
}
?>, <?php
$sql_trade = "SELECT * FROM trade WHERE status = 'Rejected'";
$result_trade = $dbc->query($sql_trade);
if ($result_trade->num_rows > 0) {
    $count = 0;
    while ($row_trade = mysqli_fetch_array($result_trade)) {
        $curYear = date('Y');
        $curMonth = "01";
        $year = substr($row_trade["tradeDate"], 6, 9);
        $month = substr($row_trade["tradeDate"], 3, 2);
        if ($curYear == $year && $curMonth == $month) {
            $count += 1;
        }
    }
    echo $count;
} else {
    echo 0;
}
?>],
                    ['Feb', <?php
$sql_trade = "SELECT * FROM trade WHERE status != 'Rejected'";
$result_trade = $dbc->query($sql_trade);
if ($result_trade->num_rows > 0) {
    $count = 0;
    while ($row_trade = mysqli_fetch_array($result_trade)) {
        $curYear = date('Y');
        $curMonth = "02";
        $year = substr($row_trade["tradeDate"], 6, 9);
        $month = substr($row_trade["tradeDate"], 3, 2);
        if ($curYear == $year && $curMonth == $month) {
            $count += 1;
        }
    }
    echo $count;
} else {
    echo 0;
}
?>, <?php
$sql_trade = "SELECT * FROM trade WHERE status = 'Rejected'";
$result_trade = $dbc->query($sql_trade);
if ($result_trade->num_rows > 0) {
    $count = 0;
    while ($row_trade = mysqli_fetch_array($result_trade)) {
        $curYear = date('Y');
        $curMonth = "02";
        $year = substr($row_trade["tradeDate"], 6, 9);
        $month = substr($row_trade["tradeDate"], 3, 2);
        if ($curYear == $year && $curMonth == $month) {
            $count += 1;
        }
    }
    echo $count;
} else {
    echo 0;
}
?>],
                    ['Mar', <?php
$sql_trade = "SELECT * FROM trade WHERE status != 'Rejected'";
$result_trade = $dbc->query($sql_trade);
if ($result_trade->num_rows > 0) {
    $count = 0;
    while ($row_trade = mysqli_fetch_array($result_trade)) {
        $curYear = date('Y');
        $curMonth = "03";
        $year = substr($row_trade["tradeDate"], 6, 9);
        $month = substr($row_trade["tradeDate"], 3, 2);
        if ($curYear == $year && $curMonth == $month) {
            $count += 1;
        }
    }
    echo $count;
} else {
    echo 0;
}
?>, <?php
$sql_trade = "SELECT * FROM trade WHERE status = 'Rejected'";
$result_trade = $dbc->query($sql_trade);
if ($result_trade->num_rows > 0) {
    $count = 0;
    while ($row_trade = mysqli_fetch_array($result_trade)) {
        $curYear = date('Y');
        $curMonth = "03";
        $year = substr($row_trade["tradeDate"], 6, 9);
        $month = substr($row_trade["tradeDate"], 3, 2);
        if ($curYear == $year && $curMonth == $month) {
            $count += 1;
        }
    }
    echo $count;
} else {
    echo 0;
}
?>],
                    ['Apr', <?php
$sql_trade = "SELECT * FROM trade WHERE status != 'Rejected'";
$result_trade = $dbc->query($sql_trade);
if ($result_trade->num_rows > 0) {
    $count = 0;
    while ($row_trade = mysqli_fetch_array($result_trade)) {
        $curYear = date('Y');
        $curMonth = "04";
        $year = substr($row_trade["tradeDate"], 6, 9);
        $month = substr($row_trade["tradeDate"], 3, 2);
        if ($curYear == $year && $curMonth == $month) {
            $count += 1;
        }
    }
    echo $count;
} else {
    echo 0;
}
?>, <?php
$sql_trade = "SELECT * FROM trade WHERE status = 'Rejected'";
$result_trade = $dbc->query($sql_trade);
if ($result_trade->num_rows > 0) {
    $count = 0;
    while ($row_trade = mysqli_fetch_array($result_trade)) {
        $curYear = date('Y');
        $curMonth = "04";
        $year = substr($row_trade["tradeDate"], 6, 9);
        $month = substr($row_trade["tradeDate"], 3, 2);
        if ($curYear == $year && $curMonth == $month) {
            $count += 1;
        }
    }
    echo $count;
} else {
    echo 0;
}
?>],
                    ['May', <?php
$sql_trade = "SELECT * FROM trade WHERE status != 'Rejected'";
$result_trade = $dbc->query($sql_trade);
if ($result_trade->num_rows > 0) {
    $count = 0;
    while ($row_trade = mysqli_fetch_array($result_trade)) {
        $curYear = date('Y');
        $curMonth = "05";
        $year = substr($row_trade["tradeDate"], 6, 9);
        $month = substr($row_trade["tradeDate"], 3, 2);
        if ($curYear == $year && $curMonth == $month) {
            $count += 1;
        }
    }
    echo $count;
} else {
    echo 0;
}
?>, <?php
$sql_trade = "SELECT * FROM trade WHERE status = 'Rejected'";
$result_trade = $dbc->query($sql_trade);
if ($result_trade->num_rows > 0) {
    $count = 0;
    while ($row_trade = mysqli_fetch_array($result_trade)) {
        $curYear = date('Y');
        $curMonth = "05";
        $year = substr($row_trade["tradeDate"], 6, 9);
        $month = substr($row_trade["tradeDate"], 3, 2);
        if ($curYear == $year && $curMonth == $month) {
            $count += 1;
        }
    }
    echo $count;
} else {
    echo 0;
}
?>],
                    ['Jun', <?php
$sql_trade = "SELECT * FROM trade WHERE status != 'Rejected'";
$result_trade = $dbc->query($sql_trade);
if ($result_trade->num_rows > 0) {
    $count = 0;
    while ($row_trade = mysqli_fetch_array($result_trade)) {
        $curYear = date('Y');
        $curMonth = "06";
        $year = substr($row_trade["tradeDate"], 6, 9);
        $month = substr($row_trade["tradeDate"], 3, 2);
        if ($curYear == $year && $curMonth == $month) {
            $count += 1;
        }
    }
    echo $count;
} else {
    echo 0;
}
?>, <?php
$sql_trade = "SELECT * FROM trade WHERE status = 'Rejected'";
$result_trade = $dbc->query($sql_trade);
if ($result_trade->num_rows > 0) {
    $count = 0;
    while ($row_trade = mysqli_fetch_array($result_trade)) {
        $curYear = date('Y');
        $curMonth = "06";
        $year = substr($row_trade["tradeDate"], 6, 9);
        $month = substr($row_trade["tradeDate"], 3, 2);
        if ($curYear == $year && $curMonth == $month) {
            $count += 1;
        }
    }
    echo $count;
} else {
    echo 0;
}
?>],
                    ['Jul', <?php
$sql_trade = "SELECT * FROM trade WHERE status != 'Rejected'";
$result_trade = $dbc->query($sql_trade);
if ($result_trade->num_rows > 0) {
    $count = 0;
    while ($row_trade = mysqli_fetch_array($result_trade)) {
        $curYear = date('Y');
        $curMonth = "07";
        $year = substr($row_trade["tradeDate"], 6, 9);
        $month = substr($row_trade["tradeDate"], 3, 2);
        if ($curYear == $year && $curMonth == $month) {
            $count += 1;
        }
    }
    echo $count;
} else {
    echo 0;
}
?>, <?php
$sql_trade = "SELECT * FROM trade WHERE status = 'Rejected'";
$result_trade = $dbc->query($sql_trade);
if ($result_trade->num_rows > 0) {
    $count = 0;
    while ($row_trade = mysqli_fetch_array($result_trade)) {
        $curYear = date('Y');
        $curMonth = "07";
        $year = substr($row_trade["tradeDate"], 6, 9);
        $month = substr($row_trade["tradeDate"], 3, 2);
        if ($curYear == $year && $curMonth == $month) {
            $count += 1;
        }
    }
    echo $count;
} else {
    echo 0;
}
?>],
                    ['Aug', <?php
$sql_trade = "SELECT * FROM trade WHERE status != 'Rejected'";
$result_trade = $dbc->query($sql_trade);
if ($result_trade->num_rows > 0) {
    $count = 0;
    while ($row_trade = mysqli_fetch_array($result_trade)) {
        $curYear = date('Y');
        $curMonth = "08";
        $year = substr($row_trade["tradeDate"], 6, 9);
        $month = substr($row_trade["tradeDate"], 3, 2);
        if ($curYear == $year && $curMonth == $month) {
            $count += 1;
        }
    }
    echo $count;
} else {
    echo 0;
}
?>, <?php
$sql_trade = "SELECT * FROM trade WHERE status = 'Rejected'";
$result_trade = $dbc->query($sql_trade);
if ($result_trade->num_rows > 0) {
    $count = 0;
    while ($row_trade = mysqli_fetch_array($result_trade)) {
        $curYear = date('Y');
        $curMonth = "08";
        $year = substr($row_trade["tradeDate"], 6, 9);
        $month = substr($row_trade["tradeDate"], 3, 2);
        if ($curYear == $year && $curMonth == $month) {
            $count += 1;
        }
    }
    echo $count;
} else {
    echo 0;
}
?>],
                    ['Sept', <?php
$sql_trade = "SELECT * FROM trade WHERE status != 'Rejected'";
$result_trade = $dbc->query($sql_trade);
if ($result_trade->num_rows > 0) {
    $count = 0;
    while ($row_trade = mysqli_fetch_array($result_trade)) {
        $curYear = date('Y');
        $curMonth = "09";
        $year = substr($row_trade["tradeDate"], 6, 9);
        $month = substr($row_trade["tradeDate"], 3, 2);
        if ($curYear == $year && $curMonth == $month) {
            $count += 1;
        }
    }
    echo $count;
} else {
    echo 0;
}
?>, <?php
$sql_trade = "SELECT * FROM trade WHERE status = 'Rejected'";
$result_trade = $dbc->query($sql_trade);
if ($result_trade->num_rows > 0) {
    $count = 0;
    while ($row_trade = mysqli_fetch_array($result_trade)) {
        $curYear = date('Y');
        $curMonth = "09";
        $year = substr($row_trade["tradeDate"], 6, 9);
        $month = substr($row_trade["tradeDate"], 3, 2);
        if ($curYear == $year && $curMonth == $month) {
            $count += 1;
        }
    }
    echo $count;
} else {
    echo 0;
}
?>],
                    ['Oct', <?php
$sql_trade = "SELECT * FROM trade WHERE status != 'Rejected'";
$result_trade = $dbc->query($sql_trade);
if ($result_trade->num_rows > 0) {
    $count = 0;
    while ($row_trade = mysqli_fetch_array($result_trade)) {
        $curYear = date('Y');
        $curMonth = "10";
        $year = substr($row_trade["tradeDate"], 6, 9);
        $month = substr($row_trade["tradeDate"], 3, 2);
        if ($curYear == $year && $curMonth == $month) {
            $count += 1;
        }
    }
    echo $count;
} else {
    echo 0;
}
?>, <?php
$sql_trade = "SELECT * FROM trade WHERE status = 'Rejected'";
$result_trade = $dbc->query($sql_trade);
if ($result_trade->num_rows > 0) {
    $count = 0;
    while ($row_trade = mysqli_fetch_array($result_trade)) {
        $curYear = date('Y');
        $curMonth = "10";
        $year = substr($row_trade["tradeDate"], 6, 9);
        $month = substr($row_trade["tradeDate"], 3, 2);
        if ($curYear == $year && $curMonth == $month) {
            $count += 1;
        }
    }
    echo $count;
} else {
    echo 0;
}
?>],
                    ['Nov', <?php
$sql_trade = "SELECT * FROM trade WHERE status != 'Rejected'";
$result_trade = $dbc->query($sql_trade);
if ($result_trade->num_rows > 0) {
    $count = 0;
    while ($row_trade = mysqli_fetch_array($result_trade)) {
        $curYear = date('Y');
        $curMonth = "11";
        $year = substr($row_trade["tradeDate"], 6, 9);
        $month = substr($row_trade["tradeDate"], 3, 2);
        if ($curYear == $year && $curMonth == $month) {
            $count += 1;
        }
    }
    echo $count;
} else {
    echo 0;
}
?>, <?php
$sql_trade = "SELECT * FROM trade WHERE status = 'Rejected'";
$result_trade = $dbc->query($sql_trade);
if ($result_trade->num_rows > 0) {
    $count = 0;
    while ($row_trade = mysqli_fetch_array($result_trade)) {
        $curYear = date('Y');
        $curMonth = "11";
        $year = substr($row_trade["tradeDate"], 6, 9);
        $month = substr($row_trade["tradeDate"], 3, 2);
        if ($curYear == $year && $curMonth == $month) {
            $count += 1;
        }
    }
    echo $count;
} else {
    echo 0;
}
?>],
                    ['Dec', <?php
$sql_trade = "SELECT * FROM trade WHERE status != 'Rejected'";
$result_trade = $dbc->query($sql_trade);
if ($result_trade->num_rows > 0) {
    $count = 0;
    while ($row_trade = mysqli_fetch_array($result_trade)) {
        $curYear = date('Y');
        $curMonth = "12";
        $year = substr($row_trade["tradeDate"], 6, 9);
        $month = substr($row_trade["tradeDate"], 3, 2);
        if ($curYear == $year && $curMonth == $month) {
            $count += 1;
        }
    }
    echo $count;
} else {
    echo 0;
}
?>, <?php
$sql_trade = "SELECT * FROM trade WHERE status = 'Rejected'";
$result_trade = $dbc->query($sql_trade);
if ($result_trade->num_rows > 0) {
    $count = 0;
    while ($row_trade = mysqli_fetch_array($result_trade)) {
        $curYear = date('Y');
        $curMonth = "12";
        $year = substr($row_trade["tradeDate"], 6, 9);
        $month = substr($row_trade["tradeDate"], 3, 2);
        if ($curYear == $year && $curMonth == $month) {
            $count += 1;
        }
    }
    echo $count;
} else {
    echo 0;
}
?>]
                ]);

                var options = {curveType: 'function', legend: {position: 'bottom'}};
                var chart = new google.visualization.LineChart(document.getElementById('curve_chart2'));
                chart.draw(data, options);
            }
        </script>
    </head>
    <body class="hold-transition sidebar-mini layout-fixed">
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Dashboard</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Dashboard v1</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3><?php
                                        $sql = "SELECT COUNT(itemid) FROM item";
                                        $result = $dbc->query($sql);
                                        if ($result->num_rows > 0) {
                                            while ($row = mysqli_fetch_array($result)) {
                                                echo $row[0];
                                            }
                                        }
                                        ?></h3>
                                    <p>Total Uploads</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <!--<a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>-->
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h3><?php
                                        $sql = "SELECT COUNT(custid) FROM customer";
                                        $result = $dbc->query($sql);
                                        if ($result->num_rows > 0) {
                                            while ($row = mysqli_fetch_array($result)) {
                                                echo $row[0];
                                            }
                                        }
                                        ?></h3>
                                    <p>User Registrations</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                                <!--<a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>-->
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-danger">
                                <div class="inner">
                                    <h3><?php
                                        $sql1 = "SELECT COUNT(tradeid) FROM trade WHERE status != 'Rejected'";
                                        $result1 = $dbc->query($sql1);
                                        if ($result1->num_rows > 0) {
                                            while ($row1 = mysqli_fetch_array($result1)) {
                                                $success = $row1[0];
                                            }
                                        }

                                        $sql2 = "SELECT COUNT(tradeid) FROM trade WHERE status = 'Rejected'";
                                        $result2 = $dbc->query($sql2);
                                        if ($result2->num_rows > 0) {
                                            while ($row2 = mysqli_fetch_array($result2)) {
                                                $faild = $row2[0];
                                            }
                                        }

                                        $sql3 = "SELECT COUNT(tradeid) FROM trade";
                                        $result3 = $dbc->query($sql3);
                                        if ($result3->num_rows > 0) {
                                            while ($row3 = mysqli_fetch_array($result3)) {
                                                $total = $row3[0];
                                            }
                                        }

                                        $rate = ($success / $total) * 100;
                                        echo $rate;
                                        ?><sup style="font-size: 20px"> %</sup></h3>
                                    <p>Trade Rate</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-pie-graph"></i>
                                </div>
                                <!--<a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>-->
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3><sup style="font-size: 20px">RM </sup><?php
                                        $sql = "SELECT SUM(totalAmount) FROM delivery";
                                        $result = $dbc->query($sql);
                                        if ($result->num_rows > 0) {
                                            while ($row = mysqli_fetch_array($result)) {
                                                $delivery1 = $row[0];
                                            }
                                        }

                                        $sql2 = "SELECT SUM(totalAmount) FROM donation_delivery";
                                        $result2 = $dbc->query($sql2);
                                        if ($result2->num_rows > 0) {
                                            while ($row2 = mysqli_fetch_array($result2)) {
                                                $delivery2 = $row2[0];
                                            }
                                        }

                                        $total = $delivery1 + $delivery2;
                                        echo $total;
                                        ?></h3>
                                    <p>Revenue Generated</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>
                                <!--<a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>-->
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <section class="col-lg-6 connectedSortable">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <i class="fas fa-truck mr-1"></i>Delivery Performance
                                    </h3>
                                    <div class="card-body">
                                        <div id="curve_chart1" style="width: auto; height: auto"></div>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <section class="col-lg-6 connectedSortable">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <i class="fas fa-handshake mr-1"></i>Trade Performance
                                    </h3>
                                    <div class="card-body">
                                        <div id="curve_chart2" style="width: auto; height: auto"></div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>

                    <div class="row">
                        <section class="col-lg-7 connectedSortable">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <i class="fas fa-users mr-1"></i>Customer
                                    </h3>
                                    <div class="card-body">
                                        <div id="regions_div" style="width: 100%; height: 500px;"></div>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <section class="col-lg-5 connectedSortable">
                            <div class="card">
                                <div class="card-header pb-1 pr-1">
                                    <h3 class="card-title">
                                        <i class="fas fa-chart-pie mr-1"></i>Brand
                                    </h3>
                                    <div class="card-body px-0 pb-0">
                                        <div id="piechart" style="width: 100%; height: auto;"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header pb-1 pr-1">
                                    <h3 class="card-title">
                                        <i class="fas fa-tshirt mr-1"></i>Category
                                    </h3>
                                    <div class="card-body px-0 pb-0">
                                        <div id="donutchart" style="width: 100%; height: auto;"></div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </section>
        </div>
        <footer class="main-footer">
            <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 3.1.0
            </div>
        </footer>

        <script src="plugins/jquery/jquery.min.js"></script>
        <script src="plugins/jquery-ui/jquery-ui.min.js"></script>
        <script>
            $.widget.bridge('uibutton', $.ui.button)
        </script>
        <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="plugins/chart.js/Chart.min.js"></script>
        <script src="plugins/sparklines/sparkline.js"></script>
        <script src="plugins/jqvmap/jquery.vmap.min.js"></script>
        <script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
        <script src="plugins/jquery-knob/jquery.knob.min.js"></script>
        <script src="plugins/moment/moment.min.js"></script>
        <script src="plugins/daterangepicker/daterangepicker.js"></script>
        <script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
        <script src="plugins/summernote/summernote-bs4.min.js"></script>
        <script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
        <script src="dist/js/adminlte.js"></script>
        <script src="dist/js/demo.js"></script>
        <script src="dist/js/pages/dashboard.js"></script>
    </body>
</html>