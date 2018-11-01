<?php

drupal_add_js('sites/all/themes/finalproject/js/prescription-list.js');
drupal_add_css('sites/all/themes/finalproject/css/prescription-list.css');

global $user;



if( in_array('patient', $user->roles) || in_array('administrator', $user->roles)) {
    $res = db_select('appointment', 'a')
    ->fields('a')
    ->condition('patient_id', $user->uid)
    ->execute();

    $userList = '<section class="problem-list"> ';
    if($res && $res->rowCount()>0) {
       
        while($row = $res->fetchAssoc()) {
            $problemId = $row['problem_id'];
            $doctorId = $row['doctor_id'];
            $user_fields = user_load($doctorId);
            
            if(isset($user_fields->picture)) {
                $imageUrl = file_create_url($user_fields->picture->uri);
            } else {
                $imageUrl = '/sites/default/files/pictures/doctor.png';
            }

            if(isset($user_fields->field_mobile_phone['und'])) {
                $phone = $user_fields->field_mobile_phone['und']['0']['value'];
            }


            $userList .= '
            <div class="user-list-row clearfix">';
          

            // User Info
            $userList .= '<div class="user-list-row-info-detail">
            <h3>Doctor: '  . $user_fields->name . '</h3>
            <img src="' .  $imageUrl . '">
            <div>
            <strong>E-mail:</strong>
            <a href="mailto:'. $user_fields->mail .'">'. $user_fields->mail .'</a>
            </div>

            </div>';


            // Problem and Symptoms
            $records = db_select('patient_records', 'pr')
            ->fields('pr')
            ->condition('entity_id', $problemId)
            ->condition('uid', $user->uid)
            ->execute();
            $problem = node_load($problemId);
            $userList .= '<div class="patient-symptom-list">';
            $userList .= '<strong>Problem: </strong>'. $problem->title;
            $userList .= '<label>Symptoms:</label>
                <ul>';
            while($record = $records->fetchAssoc()) {
                $userList .= '<li><span><strong>'. $record['symptom_name'] .': </strong>'. $record['symptom_level'] .'</span></li>';
            }
            $userList .= '</ul></div>';

            
            // Prescription
            if($row['checked'] == '1') {

                $items = db_select('patient_medical_items', 'pm')
                ->fields('pm', array('medical_item_model'))
                ->condition('problem_id', $problemId)
                ->condition('patient_id', $user->uid)
                ->condition('doctor_id', $doctorId)
                ->execute();
                $itemsResult = $items->fetchAll(PDO::FETCH_ASSOC);

                
                $userList .= '<div class="product-prescription-list">
                <button class="btn collapsible">Show Prescription</button>
                <div class="content">
                ';
                $stringModel = '';
                foreach($itemsResult as $itemResult) {
                    $stringModel .= '+' . trim($itemResult['medical_item_model']);
                }
                $stringModel = trim($stringModel, '+');
            
                watchdog('Prescription', '<pre>'. print_r($stringModel, TRUE) . '</pre>' );
                $userList .= views_embed_view('prescription_list','block_prescription', $stringModel);


                $userList .= '</div></div>';
            } 
            else {
                $userList .= '<div class="btn-container"> <button class="btn btn-disabled collapsible">Please wait for your doctor</button></div>';
            }



            $userList .= '</div>';
        }
        
        
    } else if($res && $res->rowCount()==0) {
        $userList.= '<h4>There are no prescription at the moment</h4>';
    }
    $userList .= '</section>';
    echo $userList;


    $prescribe = '
    <section class="form-popup" id="myForm">    
    <div class="form-container">
    <div id="prescription-form-id">
    </div>
    <button type="button" id="btn-appointment-id" class="btn">Buy</button>
    <button type="button" id="close-form-id" class="btn cancel">Close</button>
    </div>
    
    </section>';

    print $prescribe;


}



?>