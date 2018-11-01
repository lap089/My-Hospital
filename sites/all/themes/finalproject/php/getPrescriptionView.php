

<?php
include_once 'helper.php';

global $user;

if(isset($_POST['doctorId']) && isset($_POST['problemId'])) {
    
    $patientId = '1';
    $doctorId = $_POST['doctorId'];
    $problemId = $_POST['problemId'];

   
    watchdog('Prescription', '<pre>'. print_r($itemResult['medical_item_model'], TRUE) . '</pre>' );
   

    $items = db_select('patient_medical_items', 'pm')
    ->fields('pm', array('medical_item_model'))
    ->condition('problem_id', $problemId)
    ->condition('patient_id', $patientId)
    ->condition('doctor_id', $doctorId)
    ->execute();
    $itemsResult = $items->fetchAll(PDO::FETCH_ASSOC);

    $stringModel = '';
    foreach($itemsResult as $itemResult) {
        $stringModel .= '+' . trim($itemResult['medical_item_model']);
        //watchdog('Prescription', '<pre>'. print_r($itemResult['medical_item_model'], TRUE) . '</pre>' );
    }
    $stringModel = trim($stringModel, '+');

//    variable_set('prescription_models', 'LAP-5087890743-SKU');

    watchdog('Prescription', '<pre>'. print_r($stringModel, TRUE) . '</pre>' );
    echo views_embed_view('prescription_list','block_prescription', $stringModel);

}


?>