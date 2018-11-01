<?php 


include_once(DRUPAL_ROOT . '/includes/bootstrap.inc');
drupal_bootstrap(DRUPAL_BOOTSTRAP_DATABASE); //generates active connection

// next line redundant
db_set_active('default');


global $user;

$res = db_select('appointment', 'a')
->fields('a', array('patient_id','doctor_id'))
->condition('doctor_id', $user->uid)
->condition('checked', '0')
->execute();
$num_of_results = $res->rowCount();

//if($num_of_results)
$notification = '<div class="appointment-notification">You have <strong>'. $num_of_results .' appointments</strong></div>';

echo $notification;
?>