<?php
session_start();
if (session_destroy()) {
    header("Location:../user/login.php");
}
?>
<?php
//require ('../include/config.inc.php');
//
//ob_start();
//session_start();
//
//$page_title = 'Logout';
//include ('../include/header.php');
//
//// If no first_name session variable exists, redirect the user:
//if (!isset($_SESSION['username'])) {
//    $url = BASE_URL . 'index.php';
//    ob_end_clean(); // Delete the buffer.
//    header("Location: $url");
//    exit();
//} else {
//    $_SESSION = array(); // Destroy the variables.
//    session_destroy(); // Destroy the session itself.
//    setcookie(session_name(), '', time() - 3600); // Destroy the cookie.
//}
//
//echo '<h3>You are now logged out.</h3>';
//
//include ('../include/footer.php');
?>