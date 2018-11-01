<?php
$drupal_path = "../../../.."; 
chdir($drupal_path);

// include needed files
   include('includes/bootstrap.inc');
   include('includes/database/database.inc');
   include('includes/database/mysql/database.inc');

// Launch drupal start: configuration and database bootstrap
    define('DRUPAL_ROOT', getcwd());
    header('Access-Control-Allow-Origin: *');
    include_once DRUPAL_ROOT . '/includes/bootstrap.inc';
    drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);


$PATH = "http://localhost/drupal";
$CURRENT_DIR = "sites/all/themes/finalproject/php/";



drupal_goto('<front>');
print 200;


if(isset($_POST['patientId']) && isset($_POST['doctorId']) && isset($_POST['problemId'])) {
    print REQUEST_TIME;
    $patientId = $_POST['patientId'];
    $doctorId = $_POST['doctorId'];
    $problemId = $_POST['problemId'];
    $message = $_POST['message'];
    print $patientId . $message . $doctorId ;

    db_insert('appointment')
    ->fields(array(
        'patient_id' => $patientId,
        'doctor_id' => $doctorId,
        'problem_id' => $problemId,
        'message' => $message,
        'created' => REQUEST_TIME
        )
    )
    ->execute();
    
    //db_query("DELETE FROM {cache_field}");
}


?>