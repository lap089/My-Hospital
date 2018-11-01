<?php

include 'helper.php';



if(isset($_POST['postData'])) {
    $postData = $_POST['postData'];
    $doctorId = $postData['doctorId'];
    $selectedData = $postData['selectedData'];
    $problemId = $postData['problemId'];
    $patientId = $postData['patientId'];

    db_delete('patient_medical_items')
    ->condition('doctor_id', $doctorId)
    ->condition('patient_id', $patientId)
    ->condition('problem_id', $problemId)
    ->execute();

    foreach($selectedData as $value) {
        db_insert('patient_medical_items')
        ->fields([
            'doctor_id' => $doctorId,
            'patient_id' => $patientId,
            'problem_id' => $problemId,
            'medical_item_model' => $value,
            'created' => REQUEST_TIME
        ])
        ->execute();
    }

    db_update('appointment')
    ->condition('doctor_id', $doctorId)
    ->condition('patient_id', $patientId)
    ->condition('problem_id', $problemId)
    ->fields([
        'checked' => '1',
    ])
    ->execute();

    echo 200;
}



?>