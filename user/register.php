<?php
require ('../include/config.inc.php');
include '../include/header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Trim all the incoming data:
    $trimmed = array_map('trim', $_POST);

    // Assume invalid values:
//    $username = $contact = $email = $password = $gender = FALSE;
    $username = $contact = $email = $password = $state = $country = FALSE;

    $sql = "SELECT custid FROM customer ORDER BY custid DESC LIMIT 1";
    $result = $dbc->query($sql);

    if ($result->num_rows > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $latestnum = ((int) substr($row['custid'], 1)) + 1;
            $newid = "C{$latestnum}";
            break;
        }
    } else {
        $newid = "C10001";
    }

    if (filter_var($trimmed['email'], FILTER_VALIDATE_EMAIL)) {
        $email = mysqli_real_escape_string($dbc, $trimmed['email']);
    } else {
        echo '<p class="error">Please enter a valid email address!</p>';
    }

    if (preg_match('/^[A-Z \'.-]{2,20}$/i', $trimmed['username'])) {
        $username = mysqli_real_escape_string($dbc, $trimmed['username']);
    } else {
        echo '<p class="error">Please enter your username!</p>';
    }

//    if (isset($_REQUEST['gender'])) {
//        $gender = $_REQUEST['gender'];
//    } else {
//        echo '<p class="error">Please enter your gender!</p>';
////        $gender = NULL;
//    }

    if (preg_match('/^[A-Z \'.-]{2,20}$/i', $trimmed['contact'])) {
        $contact = mysqli_real_escape_string($dbc, $trimmed['contact']);
    } else {
        echo '<p class="error">Please enter your contact!</p>';
    }

    if (preg_match('/^\w{4,20}$/', $trimmed['password1'])) {
        if ($trimmed['password1'] == $trimmed['password2']) {
            $password = mysqli_real_escape_string($dbc, $trimmed['password1']);
        } else {
            echo '<script>alert("Your password did not match the confirmed password!");</script>';
        }
    } else {
        echo '<script>alert("Please enter a valid password!");</script>';
    }

    if (preg_match('/^[A-Z \'.-]{2,20}$/i', $trimmed['state'])) {
        $state = mysqli_real_escape_string($dbc, $trimmed['state']);
    } else {
//        echo '<p class="error">Please enter your state!</p>';
    }

    if (preg_match('/^[A-Z \'.-]{2,20}$/i', $trimmed['country'])) {
        $country = mysqli_real_escape_string($dbc, $trimmed['country']);
    } else {
//        echo '<p class="error">Please enter your country!</p>';
    }

    if ($username && $contact && $email && $password && $state && $country) {
        // Make sure the email address is available:
        $q = "SELECT custid FROM customer WHERE email='$email'";
        $r = mysqli_query($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));

        if (mysqli_num_rows($r) == 0) { // Available.
            // Create the activation code:
            $a = md5(uniqid(rand(), true));

            $q = "INSERT INTO customer (custid, email, pass, username, avatar, contact, state, country, active, registration_date) VALUES ('$newid', '$email', SHA1('$password'), '$username', '../avatar/default_profile.jpg', '$contact', '$state', '$country', '$a', NOW())";
            $r = mysqli_query($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));

            if (mysqli_affected_rows($dbc) == 1) {
                // Send the email:
                $body = "Thank you for registering at Tradee. To activate your account, please click on this link:\n\n";
                $body .= BASE_URL . 'user/activate.php?x=' . urlencode($email) . "&y=$a";
                mail($trimmed['email'], 'Registration Confirmation', $body, 'From: admin@sitename.com');

                echo '<script>alert("Thank you for registering!\nA confirmation email has been sent to your address. Please click on the link in that email in order to activate your account.");window.location.href="../user/logout.php";</script>';
//                echo '<h3>Thank you for registering! A confirmation email has been sent to your address. Please click on the link in that email in order to activate your account.</h3>';
//                include ('../include/footer.php');
                exit();
            } else {
                echo '<script>alert("You could not be registered due to a system error. We apologize for any inconvenience.");</script>';
            }
        } else {
            echo '<script>alert("That email address has already been registered. If you have forgotten your password, use the link at right to have your password sent to you.");</script>';
        }
    } else {
//        echo '<p class="error">Please try again.</p>';
    }
    mysqli_close($dbc);
}
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Sign Up - Tradee</title>
    </head>
    <body>
        <header class="page-header gradient py-5 mt-2">
            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-5">
                        <img src="../img/register/worldwide.svg" class="img-fluid" alt="Header image"/>
                    </div>

                    <div class="col-5 border bg-white rounded shadow-lg p-0 mb-2">
                        <form action="register.php" method="post" id="quickForm" novalidate="novalidate">
                            <div class="card-body pb-0">
                                <div class="form-group">
                                    <label for="inputEmail">Email address</label>
                                    <input type="email" name="email" class="form-control" id="inputEmail" placeholder="Your email" value="<?php if (isset($trimmed['email'])) echo $trimmed['email']; ?>">
                                </div>

                                <div class="form-group">
                                    <label for="inputName">Username</label>
                                    <input type="" name="username" class="form-control" id="inputName" placeholder="Your username" value="<?php if (isset($trimmed['username'])) echo $trimmed['username']; ?>">
                                </div>

                                <!--                                <div class="form-group">
                                                                    <label for="inputGender">Gender</label>
                                                                    <div class="d-flex flex-row bd-highlight">
                                                                        <div class="form-check col-3">
                                                                            <input class="form-check-input" type="radio" name="gender" value="M">
                                                                            <label class="form-check-label">Male</label>
                                                                        </div>
                                                                        <div class="form-check col-3">
                                                                            <input class="form-check-input" type="radio" name="gender" value="F">
                                                                            <label class="form-check-label">Female</label>
                                                                        </div>
                                                                    </div>
                                                                </div>-->

                                <div class="form-group">
                                    <label for="inputContact">Phone No</label>
                                    <input type="tel" name="contact" class="form-control" id="inputContact" placeholder="Your contact" value="<?php if (isset($trimmed['contact'])) echo $trimmed['contact']; ?>">
                                </div>

                                <div class="form-group">
                                    <label for="inputPassword1">Password</label>
                                    <input type="password" name="password1" class="form-control" id="inputPassword1" placeholder="Your password" value="<?php if (isset($trimmed['password1'])) echo $trimmed['password1']; ?>">
                                </div>

                                <div class="form-group">
                                    <label for="inputPassword2">Confirm Password</label>
                                    <input type="password" name="password2" class="form-control" id="inputPassword2" placeholder="Retype password" value="<?php if (isset($trimmed['password2'])) echo $trimmed['password2']; ?>">
                                </div>


                                <label>Location</label>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="state" style="display: none;"></label>
                                            <input type="text" name="state" class="form-control" id="state" placeholder="State" value="<?php if (isset($trimmed['state'])) echo $trimmed['state']; ?>">
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="country" style="display: none;"></label>
                                            <input type="text" name="country" class="form-control" id="country" placeholder="Country" value="<?php if (isset($trimmed['country'])) echo $trimmed['country']; ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-check p-0">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" name="terms" class="custom-control-input" id="checkTerms">
                                        <label class="custom-control-label" for="checkTerms" style="font-weight: lighter;">By registering, I confirm that I accept Vinted's Terms & Conditions, have read the Privacy Policy.</label>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer " style="background: none; border: none;">
                                <button type="submit" class="btn btn-signup" value="Register">Sign up</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </header>
        <?php include '../include/footer.php'; ?>
    </body>
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
                        email: true
                    },
                    username: {
                        required: true,
                        minlength: 5
                    },
//                    gender: {
//                        required: true
//                    },
                    contact: {
                        required: true,
                        minlength: 5,
//                        tell?
                        tel: true
                    },
                    password1: {
                        required: true,
                        minlength: 5
                    },
                    password2: {
                        required: true,
                        minlength: 5
                    },
                    state: {
                        required: true,
                        minlength: 5
                    },
                    country: {
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
                    username: {
                        required: "Please enter your username",
                        minlength: "Your username must be at least 5 characters long"
                    },
//                    gender: {
//                        required: "Please select your gender"
//                    },
                    contact: {
                        required: "Please enter your contact",
                        minlength: "Please enter the correct phone number"
                    },
                    password1: {
                        required: "Please provide a password",
                        minlength: "Your password must be at least 5 characters long"
                    },
                    password2: {
                        required: "Please retype your password"
                    },
                    state: {
                        required: "Please provide your state location",
                        minlength: "Please provide a valid state"
                    },
                    country: {
                        required: "Please provide your country",
                        minlength: "Please provide a valid country"
                    },
                    terms: {
                        required: "",
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
    <style>
        .gradient {
            background: rgb(148, 242, 145);
            background: linear-gradient(
                155deg,
                #00ffdd 0%,
                rgba(148, 242, 145) 50%
                );
        }

        .page-header {
            /*font-size: 1.25rem;*/
            /*color: #fff;*/
        }

        .btn-signup{
            width: 100%;
            border-radius: 4px;
            color: #09B1BA;
            border-color: #09B1BA;
            font-size: 0.9em;
        }

        .btn-signup:hover{
            background: #09B1BA;
            transition: 0.5s;
            color: #fff
        }
    </style>
</html>