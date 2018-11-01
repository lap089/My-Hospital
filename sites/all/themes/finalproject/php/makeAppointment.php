<?php

include_once 'helper.php';



if(isset($_POST['patientId']) && isset($_POST['doctorId']) && isset($_POST['problemId'])) {
    print REQUEST_TIME;
    $patientId = $_POST['patientId'];
    $doctorId = $_POST['doctorId'];
    $problemId = $_POST['problemId'];
    $message = $_POST['message'];
    print $patientId . $message . $doctorId ;

    db_delete('appointment')
    ->condition('doctor_id', $doctorId)
    ->condition('patient_id', $patientId)
    ->condition('problem_id', $problemId)
    ->execute();

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