<?php
include '../include/header.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $img = $_FILES['img']['name'];
    if ($img) {
        $newimg = "../data/avatar/$img";
    } else {
        $newimg = $_SESSION['loginuser']["avatar"];
    }

    $sql = "UPDATE customer"
            . " SET avatar= '" . $newimg . "',"
            . "username='" . $_POST['username'] . "',"
            . "description='" . $_POST['description'] . "' "
            . "WHERE custid ='" . $_SESSION['loginuser']['custid'] . "'";

    if ($dbc->query($sql)) {
        $_SESSION['loginuser']['avatar'] = $newimg;
        $_SESSION['loginuser']['username'] = $_POST['username'];
        $_SESSION['loginuser']['description'] = $_POST['description'];
        if ($img) {
            move_uploaded_file($_FILES['img']['tmp_name'], "../data/avatar/$img");
        }
        echo '<script>alert("Your profile has been updated.");var currentURL = window.location.href;window.location.href = currentURL;</script>';
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
        <title>Profile Settings - Tradee</title>
    </head>
    <body class="layout-footer-fixed hold-transition">
        <div class="setting bg-light">
            <div class="container-lg py-3">
                <form method="post" id="form" enctype="multipart/form-data">
                    <div class="row justify-content-center">
                        <?php
                        $page = 'setting_profile';
                        include '../include/sidenav.php';
                        ?>
                        <div class="col-lg-8 col-md-10">
                            <div class="mb-3 border-dark bg-white">
                                <div class="d-flex bd-highlight p-3 border-bottom align-items-center">
                                    <div class="me-auto p-2 bd-highlight flex-grow-1">Your photo</div>

                                    <div class="p-2 bd-highlight">
                                        <img class="img-fluid mb-12" src="<?php
                                        if ($_SESSION['loginuser']['avatar'] !== null) {
                                            echo "{$_SESSION['loginuser']['avatar']}";
                                        } else {
                                            echo '../img/header/user-icon.png';
                                        }
                                        ?>" style="width: 50px;" id="img_display" name="img_display">
                                    </div>
                                    <div class="p-2 custom-file" style="width: 25%;">
                                        <input type="file" accept="image/*" onchange="loadFile(event)" class="custom-file-input" id="img" name="img" disabled>
                                        <label class="custom-file-label" id="validate_img">Choose file</label>
                                    </div>
                                </div>

                                <div class="d-flex bd-highlight border-bottom p-3 align-items-center">
                                    <div class="p-2 flex-grow-1">Username</div>
                                    <div class="p-2">
                                        <input class="form-control" id="username" name="username" readonly value="<?php
                                        if ($_SESSION['loginuser']['username'] !== null) {
                                            echo $_SESSION['loginuser']['username'];
                                        }
                                        ?>">
                                    </div>
                                </div>

                                <div class="row p-3">
                                    <div class="col-md-6 p-3">About you</div>
                                    <div class="col-md-6 py-3">
                                        <textarea class="form-control" id="description" name="description" rows="5" readonly value="" placeholder="Tell us more about yourself"><?php
                                            if ($_SESSION['loginuser']['description'] !== null) {
                                                echo $_SESSION['loginuser']['description'];
                                            }
                                            ?></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="bd-highlight float-right" style="margin-bottom: 220px;">
                                <button class="btn btn-primary" type="button" style="width: 70px" id="btnsave" onclick="editorsave()">Edit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <?php include '../include/footer.php'; ?>
    </body>
    <script>
        function editable() {
            document.getElementById("img").disabled = false;
            document.getElementById("username").readOnly = false;
            document.getElementById("description").readOnly = false;
            document.getElementById("btnsave").textContent = "Save";
        }

        function editorsave() {
            var btnoption = document.getElementById("btnsave").textContent;
            console.log(document.getElementById("btnsave").textContent);

            if (btnoption === "Save") {
                var fullfill = true;
//                document.getElementById("validate_img").style.borderColor = "";
                document.getElementById("username").style.borderColor = "";
//                document.getElementById("description").style.borderColor = "";

                if (!document.getElementById("username").value || document.getElementById("username").value === "") {
                    document.getElementById("username").style.borderColor = "red";
                    fullfill = false;
                }
//                if (!document.getElementById("description").value || document.getElementById("description").value === "") {
//                    document.getElementById("description").style.borderColor = "red";
//                    fullfill = false;
//                }
//                var img = document.getElementById('img_display');
//                if (!document.getElementById("img").value || document.getElementById("img").value === "") {
//                    if (img.getAttribute('src') === "") {
//                        document.getElementById("validate_img").style.borderColor = "red";
//                        fullfill = false;
//                    }
//                }

                if (fullfill) {
                    if (confirm("Confirm to update your profile?")) {
                        if (!document.getElementById("username").value) {
                            document.getElementById("username").value = null;
                        }
//                        if (!document.getElementById("description").value) {
//                            document.getElementById("description").value = null;
//                        }
                        document.getElementById("form").submit();
                    }
                }
            } else {
                editable();
            }
        }

        var loadFile = function (event) {
            var image = document.getElementById('img_display');
            image.src = URL.createObjectURL(event.target.files[0]);
        }
    </script>
</html>