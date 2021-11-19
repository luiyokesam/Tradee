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
                    <a class="nav-link <?php if($page == 'setting_profile') { echo 'active'; } ?>" href="../user/setting_profile.php">Profile details</a>
                    <a class="nav-link <?php if($page == 'setting_account') { echo 'active'; } ?>" href="../user/setting_account.php">Account settings</a>
                    <a class="nav-link <?php if($page == 'setting_shipping') { echo 'active'; } ?>" href="../user/setting_shipping.php">Shipping</a>
                    <!--<a class="nav-link" href="#">Disabled</a>-->
                </nav>
            </div>
        </div>
    </body>
</html>