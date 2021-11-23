<?php
include '../include/header.php';

$sql = "SELECT * FROM feedback ORDER BY feedbackid DESC LIMIT 1";
$result = $dbc->query($sql);
if ($result->num_rows > 0) {
    while ($row = mysqli_fetch_array($result)) {
        $latestnum = ((int) substr($row['feedbackid'], 1)) + 1;
        $newid = "F{$latestnum}";
        break;
    }
} else {
    $newid = "F10001";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $img = $_FILES['file']['name'];

    // image file directory
    $target = "../data/feedback/" . basename($img);

    $sql = "INSERT INTO feedback(feedbackid, custid, tradeid, position, enquirytype, email, comment, feedbackdate, document, status)VALUES("
            . "'" . $newid . "',"
            . "'" . $_SESSION['loginuser']['custid'] . "',"
            . "'" . $_POST['tradeid'] . "',"
            . "'" . $_POST['position'] . "',"
            . "'" . $_POST['enquirytype'] . "',"
            . "'" . $_POST['email'] . "',"
            . "'" . $_POST['comment'] . "',"
            . "'" . $_POST['feedbackdate'] . "',"
            . "'../data/feedback/" . $img . "',"
//            . "'" . $img . "',"
            . "'Pending')";

//    echo '<script>alert("' . $sql . '");</script>';

    if ($dbc->query($sql)) {
        if (move_uploaded_file($_FILES['file']['tmp_name'], $target)) {
            echo '<script>alert("Thanks for your feedback. We will provide get to you soon.");window.location.href="../php/index.php";</script>';
        }
    } else {
        echo '<script>alert("Insert fail !\nContact IT department for maintainence")</script>';
    }
}
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Contact Us - Tradee</title>
    </head>
    <body>
        <!--                <header class="page-header gradient">
                        <div class=" container-lg pt-3">
                            <div class="row align-items-center justify-content-center">
                                <div class="col-md-5">
                                    <div class="display-5 py-3 px-5">Barter Customer Service Team</div>
                                    <div class ="blockquote py-3 px-5">
                                        Have a question/problem? Please write here, and we will reply back soonest.
                                    </div>
                                </div>
                                <div class="col-md-5 col-sm-12">
                                    <img src="../img/contact/contact-header.svg" alt="Header image"/>
                                </div>
                            </div>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 250">
                        <path
                            fill="#fff"
                            fill-opacity="1"
                            d="M0,128L48,117.3C96,107,192,85,288,80C384,75,480,85,576,112C672,139,768,181,864,181.3C960,181,1056,139,1152,122.7C1248,107,1344,117,1392,122.7L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"
                            ></path>
                        </svg>
                   </header>
                <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15934.136098617879!2d101.7289611!3d3.2162248!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x2dc5e067aae3ab84!2sTunku%20Abdul%20Rahman%20University%20College!5e0!3m2!1sen!2smy!4v1622994581220!5m2!1sen!2smy" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>-->

        <section class="services text-white" style="background-color: #6de66a;"> 
            <div class="container-lg pt-5">
                <div class="row align-items-center justify-content-center" style="text-align: center;">
                    <div class="col-md-12 text-lg-center h1">Barter Customer Service Team</div>
                    <div class="col-md-12 text-lg-center h4">Have a question/problem? Please write here, and we will reply back soonest.</div>
                </div>

                <div class="row align-items-center justify-content-center">
                    <form class="row g-3 needs-validation justify-content-center" method="post" id="form" enctype="multipart/form-data">
                        <div class="col-10 mt-3">
                            <label for="position" class="form-label">Are you a buyer or seller?</label>
                            <select class="custom-select" id="position" name="position" required>
                                <option value="">-- Select option --</option>
                                <option value="Seller">Seller</option>
                                <option value="Buyer">Buyer</option>
                            </select>
                            <div class="invalid-feedback">
                                Please select a valid position.
                            </div>
                        </div>

                        <div class="col-10 mt-4">
                            <label for="enquirytype" class="form-label">What is your enquiry about?</label>
                            <select class="form-select custom-select" id="enquirytype" name="enquirytype" required>
                                <option value="">-- Select option --</option>
                                <option value="Payments & Escrow">Payments & Escrow</option>
                                <option value="Shipping & Delivery">Shipping & Delivery</option>
                                <option value="Campaigns & Seller Related">Campaigns & Seller Related</option>
                                <option value="Web & App Performance">Web & App Performance</option>
                                <option value="General Enquiries">General Enquiries</option>
                                <option value="Account & Security">Account & Security</option>
                                <option value="Returns & Refunds">Returns & Refunds</option>
                                <option value="Product Content & Legal">Product Content & Legal</option>
                            </select>
                            <div class="invalid-feedback">
                                Please select a valid enquiry.
                            </div>
                        </div>

                        <div class="col-10 mt-4">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="email" placeholder="Your email address" name="email" required>
                            <div class="invalid-feedback">
                                Please provide a valid email.
                            </div>
                        </div>

                        <div class="col-10 mt-4">
                            <label for="tradeid" class="form-label">Trade ID</label>
                            <input name="tradeid" class="form-control" id="tradeid" placeholder="Trade ID (if any)">
                        </div>

                        <div class="col-10 mt-4">
                            <label for="comment" class="form-label">Comment</label>
                            <textarea class="form-control" id="comment" name="comment" minlength="50" rows="5" placeholder="Tell us more about your enquiry/problem" required></textarea>
                            <div class="invalid-feedback">
                                Please enter a message in the comment.
                            </div>
                        </div>

                        <div class="col-10 mt-4">
                            <label for="formFileMultiple validationFile" class="form-label">Maximum number of attachment is 1. The attachment must be smaller than 4.5MB. Allowed file types: jpg / jpeg / png / pdf / mp4.</label>
                            <div class="form-group">
                                <img class="img-fluid mb-12" alt="Photo" style="width: 100%; height: 500px; padding-top: 10px; display: none;" id="file_display" name="file_display">
                                <div class="custom-file">
                                    <!--accept="image/*"-->
                                    <input type="file" accept="*" class="custom-file-input" id="file" name="file">
                                    <label class="custom-file-label" id="validate_file">Choose file</label>
                                    <div class="invalid-feedback">
                                        Please attach a valid form of file.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-10 mt-3" style="display: none;">
                            <label class="form-label">Date</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                </div>
                                <input type="text" class="form-control" placeholder="dd/mm/yyyy" id="feedbackdate" maxlength="10" value="" readOnly name="feedbackdate">
                            </div>
                        </div>

                        <div class="col-10 mt-4">
                            <button class="btn btn-outline-light" type="button" id="btnsave" onclick="editorsave()">Submit</button>
                        </div>
                    </form>
                </div>
            </div>

            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 220">
            <path fill="#fff" fill-opacity="1" d="M0,96L34.3,106.7C68.6,117,137,139,206,122.7C274.3,107,343,53,411,53.3C480,53,549,107,617,117.3C685.7,128,754,96,823,96C891.4,96,960,128,1029,154.7C1097.1,181,1166,203,1234,202.7C1302.9,203,1371,181,1406,170.7L1440,160L1440,320L1405.7,320C1371.4,320,1303,320,1234,320C1165.7,320,1097,320,1029,320C960,320,891,320,823,320C754.3,320,686,320,617,320C548.6,320,480,320,411,320C342.9,320,274,320,206,320C137.1,320,69,320,34,320L0,320Z"></path>
            </svg>
        </section>
        <?php include '../include/footer.php'; ?>
    </body>
    <script>
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0');
        var yyyy = today.getFullYear();
        document.getElementById("feedbackdate").value = dd + '/' + mm + '/' + yyyy;

        function editorsave() {
            var fullfill = true;
            var message = "";
            document.getElementById("validate_file").style.borderColor = "";
            document.getElementById("position").style.borderColor = "";
            document.getElementById("enquirytype").style.borderColor = "";
            document.getElementById("email").style.borderColor = "";
            document.getElementById("comment").style.borderColor = "";

            if (!document.getElementById("position").value || document.getElementById("position").value === "") {
                document.getElementById("position").style.borderColor = "red";
                message += "Please select your position.\n";
                fullfill = false;
            }
            if (!document.getElementById("enquirytype").value || document.getElementById("enquirytype").value === "") {
                document.getElementById("enquirytype").style.borderColor = "red";
                message += "Please select your enquiry.\n";
                fullfill = false;
            }

            if (!document.getElementById('email').value || document.getElementById('email').value === "") {
                document.getElementById('email').style.borderColor = "red";
                fulfill = false;
                message += "Email is required.\n";
            } else {
                var mailformat = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
                if (!document.getElementById("email").value.match(mailformat)) {
                    document.getElementById("email").style.borderColor = "red";
                    fulfill = false;
                    message += "Invalid email!\n";
                }
            }

            if (!document.getElementById("comment").value || document.getElementById("comment").value === "") {
                fullfill = false;
                message += "Comment is a required field.\n";
                document.getElementById("comment").style.borderColor = "red";
            } else {
                if (document.getElementById("comment").length < 50) {
                    fulfill = false;
                    message += "Your comment must be consist of at least 50 words.\n";
                    document.getElementById("month").style.borderColor = "red";
                }
            }
            if (!document.getElementById("file").value || document.getElementById("file").value === "") {
                if (document.getElementById('file').src === "") {
                    message += "Please input a document as a prove.\n";
                    document.getElementById("validate_file").style.borderColor = "red";
                    fullfill = false;
                }
            }

            if (fullfill) {
                if (confirm("Confirm to submit the feedback?")) {
                    document.getElementById("form").submit();
                }
            } else {
                alert("Please enter all required information for a better feedback.\n" + message);
            }
        }
    </script>
    <style>
        .gradient {
            background: rgb(0, 97, 242);
            background: linear-gradient(
                135deg,
                #00ffdd 0%,
                rgba(105, 0, 199, 1) 100%
                );
        }

        .page-header {
            font-size: 1.25rem;
            color: #fff;
        }
    </style>
</html>