<?php
require ('../include/config.inc.php');
include '../include/header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//    require (MYSQL);
    $uid = FALSE;

    if (!empty($_POST['email'])) {
        $q = 'SELECT custid FROM customer WHERE email="' . mysqli_real_escape_string($dbc, $_POST['email']) . '"';
        $r = mysqli_query($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));

        if (mysqli_num_rows($r) == 1) {
            list($uid) = mysqli_fetch_array($r, MYSQLI_NUM);
        } else {
            echo '<p class="error">The submitted email address does not match those on file!</p>';
        }
    } else {
        echo '<p class="error">You forgot to enter your email address!</p>';
    }

    if ($uid) {
        $p = substr(md5(uniqid(rand(), true)), 3, 10);

        $q = "UPDATE customer SET pass=SHA1('$p') WHERE custid=('$uid') LIMIT 1";
        $r = mysqli_query($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));

        if (mysqli_affected_rows($dbc) == 1) { // If it ran OK.
// Send an email:
            $body = "Your password to log into Tradee has been temporarily changed to '$p'. Please log in using this password and this email address. Then you may change your password to something more familiar.";
            mail($_POST['email'], 'Your temporary password.', $body, 'From: admin@tradee.com');

// Print a message and wrap up:
            echo '<h3>Your password has been changed. You will receive the new, temporary password at the email address with which you registered. Once you have logged in with this password, you may change it by clicking on the "Change Password" link.</h3>';
            mysqli_close($dbc);
            include ('../include/footer.php');
            exit();
        } else {
            echo '<p class="error">Your password could not be changed due to a system error. We apologize for any inconvenience.</p>';
        }
    } else {
        echo '<p class="error">Please try again.</p>';
    }

    mysqli_close($dbc);
}
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Forgot Password - Tradee</title>
    </head>
    <body>
        <header class="page-header gradient">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 220">
            <path fill="#fff" fill-opacity="1" d="M0,96L34.3,106.7C68.6,117,137,139,206,122.7C274.3,107,343,53,411,53.3C480,53,549,107,617,117.3C685.7,128,754,96,823,96C891.4,96,960,128,1029,154.7C1097.1,181,1166,203,1234,202.7C1302.9,203,1371,181,1406,170.7L1440,160L1440,0L1405.7,0C1371.4,0,1303,0,1234,0C1165.7,0,1097,0,1029,0C960,0,891,0,823,0C754.3,0,686,0,617,0C548.6,0,480,0,411,0C342.9,0,274,0,206,0C137.1,0,69,0,34,0L0,0Z"></path>
            </svg>
            <div class=" container p-3">
                <form action="password_recovery.php" method="post">
                    <div class="row align-items-center justify-content-center">
                        <div class="col-lg-4 col-md-7 bg-white shadow-lg pt-3 px-3 rounded">
                            <div class="h3">Reset Your Password</div>

                            <div class="form-group mt-2">
                                <label for="inputEmail">Email address</label>
                                <input class="form-control" type="email" name="email" id="email" placeholder="Enter email" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>">
                            </div>

                            <!--<div align="center"><input type="submit" name="submit" value="Reset My Password" /></div>-->
                            <button type="submit" name="submit" class="btn btn-next-fg">Reset</button>

                            <div class="border-top mt-3">
                                <div class="text-center p-2 pb-0 mb-0 h6">Try again?
                                    <a href="login.php" class="txt-sign-up-login" style="text-decoration: none;">Sign Up</a>
                                </div> 
                            </div>
                        </div>
                    </div>
                </form>
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
            /*color: #fff;*/
        }

        .btn-next-fg{
            width: 100%;
            border-radius: 4px;
            color: #09B1BA;
            border-color: #09B1BA;
            font-size: 0.9em;
        }

        .btn-next-fg:hover{
            background: #09B1BA;
            transition: 0.5s;
            color: #fff
        }

        .txt-login-fg{
            color: #09B1BA;
            /*color: #11ff00;*/
        }

        .txt-login-fg:hover{
            /*color: #09B1BA;*/
            /*color: #11ff00;*/
        }
    </style>
</html>