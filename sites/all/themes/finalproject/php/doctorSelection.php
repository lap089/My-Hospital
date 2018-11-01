<?php

include_once 'helper.php';

// $query = db_select('users', 'u');
// $query->join('users_roles', 'ur', 'u.uid = ur.uid');
// $query->join('role', 'r', 'r.rid = ur.rid AND r.name=:name', array(':name' => "doctor"));
// $query->fields('u');
// $result = $query->execute();

// $list = '
// <section>
// ';

// if($result) {
//     while($res = $result->fetchAssoc()) {
//         $list .= '<div class="doctor-selection-list" onclick="openForm()">
//         ' .
//         '<h3>' . $res['name'] . '</h3>' .
//         '<span><label> Mail: </label>' . '<p> ' . $res['mail'] . '</p></span>' .  
//         '</div>
//         ';
//     }
// }

// $list .= '
// </section>
// ';

// echo $list;

if(isset($_GET['uid'])) {



    $uid = $_GET['uid'];
    //$uid = filter_var($fields['uid']->content, FILTER_SANITIZE_NUMBER_INT);
    $user_fields = user_load($uid);


  
watchdog('Doctor', '<pre>'. print_r($user_fields, TRUE) . '</pre>' );

if(isset($user_fields->picture->uri)) {
    $imageUrl = str_replace($CURRENT_DIR,'',file_create_url($user_fields->picture->uri));
} else {
    $imageUrl = '/sites/default/files/pictures/doctor.png';
}

$phone = $user_fields->field_mobile_phone['und']['0']['value'];
$summary = $user_fields->field_summary['und']['0']['value'];
//watchdog('Doctor', '<pre>'. print_r($imageUrl , TRUE) . '</pre>' );

$detailForm = '
<h1>Doctor: '  . $user_fields->name . '</h1>
<img src="' .  $imageUrl . '">
<div>
<span><strong>E-mail:</strong></span>
<a href="mailto:'. $user_fields->mail .'">'. $user_fields->mail .'</a>
</div>

<div>
<span><strong>Mobile Phone:</strong></span>
<a href="tel:'. $phone .'">'. $phone .'</a>
</div>

<div>
<label>Summary:</label>
<p>'. $summary .'</p>
</div>

';


echo $detailForm;

} 
else if(isset($_POST['appointmentData'])) {

    $appointmentData = $_POST['appointmentData'];
    //print_r($appointmentData);

    $problemId =     variable_get('problem_id', -1);
    if($problemId == -1) {
        print "Cannot get problem Id";
        return;
    }

    db_merge('appointment')
    ->key([
        'patient_id' => $appointmentData['patientId'],
        'problem_id' => $problemId,
        'doctor_id' => $appointmentData['doctorId']
    ])
    ->fields(array(
        'message' => $appointmentData['message'],
        'created' => REQUEST_TIME
    ))
    ->execute();

    drupal_set_message(t('You just make an appointment!'),'status', TRUE);
    echo 200;
}



?>

