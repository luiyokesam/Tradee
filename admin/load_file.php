<?php
DEFINE ('DB_USER', 'root');
DEFINE ('DB_PASSWORD', '');
DEFINE ('DB_HOST', 'localhost');
DEFINE ('DB_NAME', 'tradee_db');

// Make the connection:
$dbc = mysqli_connect (DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// If no connection could be made, trigger an error:
if (!$dbc) {
	trigger_error ('Could not connect to MySQL: ' . mysqli_connect_error() );
} else { // Otherwise, set the encoding:
	mysqli_set_charset($dbc, 'utf8');
}


if(isset($_GET['id'])){
    $feedbackid = $_GET['id'];
    
    $query = "SELECT * FROM feedback where feedbackid = '$feedbackid'";
    $result_feedback = mysqli_query($dbc, $query);
    $data= mysqli_fetch_assoc($result_feedback);
    
    echo $data['document'];
    
    $file = $data['document'];
//    if(file_exists($file)){
////        header('Content-Description: '. $data['gender']);
////        header('Content-Type: '.$data['city']);
//        header('Content-Disposition: '.$data['status'].'; filename="'.basename($file).'"');
////        header('Expires'. $data['birthday']);
////        header('Cache-Control: '.date['cache']);
////        header('Pragma:'.$data['address']);
//        header('Content-Lenght: '.filesize($file));
//        readfile($file);
//        exit();
//        
//    }
}
?>