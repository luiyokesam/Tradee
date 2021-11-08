<?php
include ('../include/header.php');

if (isset($_SESSION['userid'])) {
    echo '<script>window.location.href = "../user/profile.php";</script>';
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//    require (MYSQL);

    if (!empty($_POST['email'])) {
        $e = mysqli_real_escape_string($dbc, $_POST['email']);
    } else {
        $e = FALSE;
        echo '<p class="error">You forgot to enter your email address!</p>';
    }

    if (!empty($_POST['pass'])) {
        $p = mysqli_real_escape_string($dbc, $_POST['pass']);
    } else {
        $p = FALSE;
        echo '<p class="error">You forgot to enter your password!</p>';
    }

    if ($e && $p) {
        $q = "SELECT * FROM customer WHERE (email='$e' AND pass=SHA1('$p')) AND active IS NULL";
        $r = mysqli_query($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));

        if (@mysqli_num_rows($r) == 1) {
            // Register the values:
            $_SESSION['loginuser'] = mysqli_fetch_array($r, MYSQLI_ASSOC);
            echo '<script>alert("Login successfully!")</script>';
            mysqli_free_result($r);
            mysqli_close($dbc);

            // Redirect the user:
            $url = '../php/index.php';
            ob_end_clean();
            header("Location: $url");
            exit();
        } else {
            echo '<script>alert("Either the email address and password entered do not match those on file or you have not yet activated your account.");</script>';
        }
    } else {
        echo '<script>alert("Please try again.");</script>';
    }

    mysqli_close($dbc);
}
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Log In - Tradee</title>
    </head>
    <body>
        <header class="page-header gradient pt-5">
            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-md-5 p-5">    
                        <img src="../img/login/28.svg" class="img-fluid" alt="Header image"/>
                        <div class="h4 text-center text-white ps-3 pe-3">Your trusted online barter trading <br> platform in the world</div>
                    </div>

                    <div class="col-md-4 bg-white shadow-lg pt-3 px-3 rounded">
                        <div class="h2">Log In</div>

                        <form class="login-form" action="login.php" method="post" id="quickForm" >
                            <div class="form-group mt-2">
                                <label for="inputEmail">Email address</label>
                                <input type="email" name="email" class="form-control" id="inputEmail" placeholder="Enter email">
                            </div>

                            <div class="form-group mb-1">
                                <label for="inputPassword">Password</label>
                                <input type="password" name="pass" class="form-control" id="inputPassword" placeholder="Password">
                            </div>

                            <div class="mb-3">
                                <a href="../user/password_recovery.php" class="txt-fp-login" style="text-decoration:none;">Forgot Password</a>
                            </div>

                            <button type="button submit" name="submit" value="submit" class="btn btn-login-login btn-block">Login</button>
                        </form>

                        <div class="border-top mt-3">
                            <div class="text-center p-2 pb-0 mb-0 h6">New to Barter? 
                                <a href="register.php" class="txt-sign-up-login" style="text-decoration: none;">Sign Up</a>
                            </div> 
                        </div>
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
        <?php include '../include/footer.php'; ?>
    </body>
    <script>
        $(function () {
            $.validator.setDefaults({
                submitHandler: function () {
                    ($_SERVER['REQUEST_METHOD'] == 'POST');
                }
            });
            $('#quickForm').validate({
                rules: {
                    email: {
                        required: true,
                        email: true
                    },
                    pass: {
                        required: true,
                        minlength: 5
                    }
                },
                messages: {
                    email: {
                        required: "Please enter your email address",
                        email: "Please enter a vaild email address"
                    },
                    pass: {
                        required: "Please provide your password",
                        minlength: "Please enter your correct password"
                    }
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

        /*        .gradient {
                    background: rgb(0, 97, 242);
                    background: linear-gradient(
                        135deg,
                        #00ffdd 0%,
                        rgba(105, 0, 199, 1) 100%
                        );
                }*/

        .page-header {
            font-size: 1.25rem;
            /*color: #fff;*/
        }

        .txt-fp-login{
            /*text-decoration: none;*/
            font-size: 0.7em;
        }

        .txt-fp-login:hover{
            color: #09B1BA;
            transition: 0.5s;
        }

        .btn-login-login{
            color: #09B1BA;
            border-color: #09B1BA;
            background-color: #fff;
        }

        .btn-login-login:hover{
            color: #fff;
            border-color: #7cf279;
            background-color: #7cf279;
            transition-duration: 0.2s;
        }

        .txt-sign-up-login{
            color: #09B1BA;
        }
    </style>
</html>