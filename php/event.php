<?php
include '../include/header.php';
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Event - Tradee</title>
    </head>
    <body class="bg-white">
        <div class="container-lg" style="min-height: 700px;">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3">
                <!--                <div class="col">
                                    <div class="card" style="border: none; border-radius: 0px; box-shadow: none;">
                                        <svg class="bd-placeholder-img card-img-top" width="100%" height="225" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#55595c"></rect><text x="50%" y="50%" fill="#eceeef" dy=".3em">Thumbnail</text></svg>
                                        <img class="" src="../img/event/event_1.jpg">
                                        <div class="card-body px-0 py-2">
                                            <div class="" style="font-size: 1em; font-weight: bold;">1 Jan 2021</div>
                                            <div class="" style="font-size: 1em;">Rumah Charis - Home For The Children</div>
                                            <div class="card-text py-1" style="font-size: 0.9em;">Lot 10064, Jalan Awan Pintal, Taman Yarl, 58200 Kuala Lumpur.</div>
                                            <div class="card-text">Tel: 03-7971 9167</div>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="btn-group">
                                                    <a href="#" type="button" class="btn btn-sm btn-outline-secondary">View</a>
                                                    <button type="button" class="btn btn-sm btn-outline-secondary">Edit</button>
                                                </div>
                                                <small class="text-muted">Tel: 03-7971 9167</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>-->

                <?php
                $get_event = "SELECT * FROM event e WHERE (e.status = 'Pending' OR e.status = 'In-Progress')";
                $result = $dbc->query($get_event);
                if ($result->num_rows > 0) {
                    while ($row = mysqli_fetch_array($result)) {
                        $address = "{$row['address1']}, {$row['address2']}, {$row['postcode']}, {$row['state']}, {$row['country']}";
                        echo "<div class='col'>"
                        . "<div class='card' style='border: none; border-radius: 0px; box-shadow: none;'>"
                        . "<img class='event-img' src='../data/event_img/" . $row['eventid'] . "_0'>"
                        . "<div class='card-body px-0 py-2'>"
                        . "<div class='' style='font-size: 1em; font-weight: bold;'>" . $row["endEvent"] . "</div>"
                        . "<div class='' style='font-size: 1em;'>" . $row["title"] . "</div>"
                        . "<div class='card-text py-1' style='font-size: 0.9em;'>" . $address . "</div>"
                        . "<div class='d-flex justify-content-between align-items-center'>"
                        . "<div class='btn-group'>"
                        . "<a href='../user/event_profile.php?id=" . $row["eventid"] . "' type='button' class='btn btn-sm btn-outline-secondary'>View</a>"
                        . "</div>"
                        . "<small class='text-muted'>Tel: " . $row["contact"] . "</small>"
                        . "</div>"
                        . "</div>"
                        . "</div>"
                        . "</div>";
                    }
                }
                ?>
            </div>
        </div>
        <?php include '../include/footer.php'; ?>
    </body>
    <style>
        .fa-heart:hover{
            color: red;
        }
        
        .event-img{
            max-height: 245px;
            min-height: 245px;
            width: 100%;
            height: 100%;
            text-align: center;
            background-size: contain;
            background-repeat:   no-repeat;
            background: whitesmoke;
        }

        .img-event{
            max-width: 100%;
            height: auto;
            align-self: flex-end;
            text-align: center;
            background: whitesmoke;
        }

        .img-event-box{
            max-width: 500px;
            max-height: 300px;
            display: flex;
        }
    </style>
</html>