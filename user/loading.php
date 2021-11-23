<?php
date_default_timezone_set('Etc/GMT+8');
$current_date = new DateTime('tomorrow');
$current_date->setTime(0, 0);

$sql = "SELECT * FROM event WHERE status = 'In-Progress'";
$result = $dbc->query($sql);
if ($result->num_rows > 0) {
    while ($row = mysqli_fetch_array($result)) {
        $str = str_replace("/", "-", $row['endEvent']);
        $enddate = new DateTime($str);
//        print_r($current_date);
//        print_r($enddate);
        
        if ($current_date >= $enddate) {
            $endevent = "UPDATE event SET status = 'Ended' WHERE eventid = '{$row["eventid"]}'";
            $dbc->query($endevent);
        }
    }
}
?>