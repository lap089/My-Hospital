<?php
include_once(DRUPAL_ROOT . '/includes/bootstrap.inc');
drupal_bootstrap(DRUPAL_BOOTSTRAP_DATABASE); //generates active connection

// next line redundant
db_set_active('default');

drupal_add_js('sites/all/themes/finalproject/js/index.js');
drupal_add_css('sites/all/themes/finalproject/css/overlay-section.css');


$query='SELECT nid, title FROM {node} WHERE type=:type';

global $user;

$select = '<div class="medical-problems-list" >';

if($user->uid && in_array('patient', $user->roles) || in_array('administrator', $user->roles)) {
  $select .= '
<h2>Hi '.$user->name.'! What is your medical problem?</h2>
<select id="medical-problems-list-id">
';
$result = db_query($query, array(':type' => 'medical_problem'));
//echo "<table border=1>\n";
  if ($result) {
    $select .= '<option value="-1" selected disabled hidden>Select a medical problem</option>';  
    while ($row = $result->fetchAssoc()) {
     // echo   "<tr><td>", $row['nid'], "</td><td>", $row['title'], "</td></tr>\n";
      $select.='
      <option value="' . $row['nid']. '">' . $row['title'] . '</option>  
      ';  
    }
}

$select .= '
</select>
<button id="medical-problem-list-button-id" >Start your treatment</button>
';
} 
else if($user->uid && in_array('doctor', $user->roles) || in_array('administrator', $user->roles)) {
    $res = db_select('appointment', 'a')
  ->fields('a', array('patient_id','doctor_id'))
  ->condition('doctor_id', $user->uid)
  ->condition('checked', '0')
  ->execute();
  $num_of_results = $res->rowCount();

if($num_of_results) {
  $select .= '<h2>Hi '.$user->name.'! You have '. $num_of_results .' appointments. Please check with your patients!</h2>';
} else {
  $select .= '<h2>Hi '.$user->name.'! You have no appointment at the moment</strong></h2>';
}


}
else {


$select .= '<h2>Login now to start your treatment!</h2>';

$loginBlock =  drupal_get_form('user_login_block');
$select .= drupal_render($loginBlock);
}

$select .= '</div>';

//watchdog('Table Problems',  print_r( (string)$select, TRUE) );

//echo "</table>\n";

//echo '<br/>';

echo $select;



?>