<?php
include 'navbar.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM feedback WHERE feedbackid = '$id' LIMIT 1";
    $result = $dbc->query($sql);
    if ($result->num_rows > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $current_data = $row;
            $title = "Feedback Details - {$current_data['feedbackid']}";
            echo '<script>var current_data = ' . json_encode($current_data) . ';</script>';
            break;
        }
    } else {
        echo '<script>alert("Extract data fail !\nContact IT department for maintainence");window.location.href = "feedback_list.php";</script>';
    }
} else {
    $sql = "SELECT feedbackid FROM feedback ORDER BY feedbackid DESC LIMIT 1";
    $result = $dbc->query($sql);
    if ($result->num_rows > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $latestnum = ((int) substr($row['feedbackid'], 1)) + 1;
            $newid = "C{$latestnum}";
            $title = "Feedback ({$newid})";
            echo '<script>var current_data = null;</script>';
            $current_data = null;
            break;
        }
    } else {
        $newid = "F10001";
        $title = "Feedback Details - {$newid}";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sql = "UPDATE feedback SET "
            . "status='" . $_POST['status'] . "'"
            . "WHERE feedbackid ='" . $current_data['feedbackid'] . "'";

    if ($dbc->query($sql)) {
        echo '<script>alert("Successfuly update!");var currentURL = window.location.href;window.location.href=currentURL;</script>';
    } else {
        echo '<script>alert("Update fail!\nContact IT department for maintainence")</script>';
    }
}
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo $current_data['feedbackid'] ?> - Tradee</title>
    </head>
    <body class="hold-transition sidebar-mini layout-fixed" onload="addnew()">
        <div class="wrapper">
            <div class="content-wrapper">
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="feedback_list.php">Feedback list</a></li>
                                    <li class="breadcrumb-item active">Feedback details</li>
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
                                    <h3 class="card-title" id="titleid"><?php echo $title; ?></h3>
                                </div>

                                <div class="card-body">
                                    <form method="post" id="form" enctype="multipart/form-data">
                                        <div class="row">
<!--                                            <div class="col-md-3">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="col-md-12">
                                                            <img class="img-fluid mb-12" src="<?php
                                                            if (isset($current_data)) {
                                                                echo $current_data["file"];
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
                                            </div>-->

                                            <div class="col-md-7">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label>Customer ID :</label>
                                                        <div class="form-group">                                             
                                                            <input class="form-control" id="name" name="custid" readOnly value="<?php
                                                            if (isset($current_data)) {
                                                                echo $current_data["custid"];
                                                            }
                                                            ?>">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label>Trade ID :</label>
                                                        <div class="form-group">                                             
                                                            <input class="form-control" id="name" name="tradeid" readOnly value="<?php
                                                            if (isset($current_data)) {
                                                                echo $current_data["tradeid"];
                                                            }
                                                            ?>">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label>Position :</label>
                                                        <div class="form-group">                                             
                                                            <input class="form-control" id="name" name="position" readOnly value="<?php
                                                            if (isset($current_data)) {
                                                                echo $current_data["position"];
                                                            }
                                                            ?>">
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-6">
                                                        <label>Enquiry :</label>
                                                        <div class="form-group">                                             
                                                            <input class="form-control" id="enquirytype" name="enquirytype" readOnly value="<?php
                                                            if (isset($current_data)) {
                                                                echo $current_data["enquirytype"];
                                                            }
                                                            ?>">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label>Email:</label>
                                                        <div class="form-group">                                             
                                                            <input class="form-control" id="email" name="email" readOnly value="<?php
                                                            if (isset($current_data)) {
                                                                echo $current_data["email"];
                                                            }
                                                            ?>">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label>Feedback Date :</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                                            </div>
                                                            <input type="text" class="form-control" name="feedbackdate" placeholder="dd/mm/yyyy" id="release_date" maxlength="10" value="<?php
                                                            if (isset($current_data)) {
                                                                echo $current_data["feedbackdate"];
                                                            }
                                                            ?>" readOnly name="feedbackdate">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-auto pt-1">
                                                        <label>Status:</label>
                                                        <div class="form-group row" style="padding-left: 5px">   
                                                            <div class="custom-control custom-radio col-md-8">
                                                                <input class="custom-control-input" type="radio" id="customRadio1" name="status" disabled value="Completed"<?php
                                                                if (isset($current_data)) {
                                                                    if ($current_data["status"] == 'Completed') {
                                                                        echo 'checked';
                                                                    }
                                                                }
                                                                ?>>
                                                                <label for="customRadio1" class="custom-control-label">Completed</label>
                                                            </div>

                                                            <div class="custom-control custom-radio col-md-4">
                                                                <input class="custom-control-input" type="radio" id="customRadio2" name="status" disabled value="Pending"<?php
                                                                if (isset($current_data)) {
                                                                    if ($current_data["status"] == 'Pending') {
                                                                        echo 'checked';
                                                                    }
                                                                }
                                                                ?>>
                                                                <label for="customRadio2" class="custom-control-label">Pending</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-5">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label>Comment :</label>
                                                        <div class="form-group">
                                                            <textarea class="form-control" rows="10" id="description" readOnly name="comment"><?php
                                                                if (isset($current_data)) {
                                                                    echo $current_data["comment"];
                                                                }
                                                                ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                                            
                                                            
                                                            <a href="Filedownload.php?feedbackid=<?= $current_data['feedbackid'] ?>" 
                                               class="btn btn_edit"><i class="fas fa-edit">view</i></a>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <button type="button" class="btn btn-dark" style="width:100%" id="btnback" onclick="back()">Back</button>
                                        </div>
                                    </div>

                                    <div class="col-md-9"></div>

                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <button type="button" class="btn btn-warning" style="width:100%" id="btncancel" onclick="cancel()" disabled>Cancel</button>
                                        </div>
                                    </div>

                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <button type="button" class="btn btn-primary" style="width:100%" id="btnsave" onclick="editorsave()">Edit</button>
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
    <script>
        var currentURL = window.location.href;

        var isnew = false;
        function back() {
            var btnoption = document.getElementById("btnsave").textContent;
            if (btnoption === "Save") {
                if (confirm("Confirm to unsave ?")) {
                    window.location.href = "feedback_list.php";
                }
            } else {
                window.location.href = "feedback_list.php";
            }
        }

        function editable() {
            document.getElementById("btnsave").textContent = "Save";
            document.getElementById("btncancel").disabled = false;
            document.getElementById("customRadio1").disabled = false;
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
                    window.location.href = "feedback_list.php";
                } else {
                    window.location.href = currentURL;
                }
            }
        }

        var loadFile = function (event) {
            var image = document.getElementById('img_display');
            image.src = URL.createObjectURL(event.target.files[0]);
        };
    </script>
</html>