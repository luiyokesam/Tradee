<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
        <div class="col-md-2">
            <div class="d-flex align-items-start justify-content-md-start justify-content-center">
                <nav class="nav flex-column nav-pills">
                    <!--<a class="nav-link active" aria-current="page" href="../user/setting.php">Profile details</a>-->
                    <a class="nav-link" href="../user/setting_profile.php"><div class="<?php if($page == 'setting_profile') { echo 'active-now'; } ?>">Profile details</div></a>
                    <a class="nav-link" href="../user/setting_account.php"><div class="<?php if($page == 'setting_account') { echo 'active-now'; } ?>">Account settings</div></a>
                    <a class="nav-link" href="../user/setting_shipping.php"><div class="<?php if($page == 'setting_shipping') { echo 'active-now'; } ?>">Shipping</div></a>
                    <!--<a class="nav-link" href="#">Disabled</a>-->
                </nav>
            </div>
        </div>
    </body>
    <style>
        .active-now{
            color: #09B1BA;
            font-weight: bold;
        }
    </style>
</html>