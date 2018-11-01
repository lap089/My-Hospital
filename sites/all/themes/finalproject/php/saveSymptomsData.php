<?php

$drupal_path = "../../../../..";  // <---- change this one to fit yours 
chdir($drupal_path);
// $dire = getcwd();
// echo $dire;                 //just to check which directory you are at 

// include needed files
   include('includes/bootstrap.inc');
   include('includes/database/database.inc');
   include('includes/database/mysql/database.inc');

// Launch drupal start: configuration and database bootstrap
   //conf_init();
//    drupal_bootstrap(DRUPAL_BOOTSTRAP_CONFIGURATION);
//    drupal_bootstrap(DRUPAL_BOOTSTRAP_DATABASE);

    define('DRUPAL_ROOT', getcwd());
    header('Access-Control-Allow-Origin: *');
    include_once DRUPAL_ROOT . '/includes/bootstrap.inc';
    drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);

// Now you can use drupal database with drupal's dbal:
// Unlock user admin if blocked

// db_update('field_data_field_symptom_list')
//         ->fields(array(
//             'field_symptom_list_symptom_level' => $symptomObject['value']
//             )
//         )
//         ->condition('field_symptom_list_symptom_name', $symptomObject['title'])
//         ->condition('entity_id', $nodeId)
//         ->execute();

if(isset($_POST['symptoms']) && isset($_POST['nodeId']) && isset($_POST['uid'])) {
    $symptomObjects = $_POST['symptoms'];
    $nodeId = $_POST['nodeId'];
    $uid = $_POST['uid'];
    // print_r($nodeId);
    // print_r($symptomObjects);
    for ($index=0; $index < count($symptomObjects); $index++) { 
        $symptomObject = $symptomObjects[$index];
        
        db_merge('patient_records')
        ->key([
            'uid' => $uid,
            'entity_id' => $nodeId,
            'symptom_name' => $symptomObject['title']
        ])
        ->fields(array(
            'symptom_level' => $symptomObject['value'],
        ))
        ->execute();
    }
    variable_set('problem_id', $nodeId);

    $breadcrumb =  drupal_get_breadcrumb();
    $breadcrumb[] = l('Survey Symptoms', '/node/' . $nodeId);
    variable_set('breadcrumb', $breadcrumb);
    drupal_set_breadcrumb($breadcrumb);

//    db_query("DELETE FROM {cache_field}");
}

?>