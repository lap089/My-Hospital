
<?php


drupal_add_css('sites/all/themes/finalproject/css/patient-info.css');
drupal_add_js('sites/all/themes/finalproject/js/patient-info.js');
drupal_add_js('sites/all/themes/finalproject/js/product-selection.js');
drupal_add_css('sites/all/themes/finalproject/css/product-selection.css');

global $user;

if( in_array('doctor', $user->roles) || in_array('administrator', $user->roles)) {
    $res = db_select('appointment', 'a')
    ->fields('a')
    ->condition('doctor_id', $user->uid)
    ->execute();

    $userList = '<section class="patient-list"> ';
    if($res && $res->rowCount()>0) {
       
        while($row = $res->fetchAssoc()) {
            $problemId = $row['problem_id'];
            $patientId = $row['patient_id'];
            $user_fields = user_load($patientId);
            //watchdog('PatientList', '<pre>'. print_r($user_fields, TRUE) . '</pre>' );
            $imageUrl = "";
            $phone = "";
            if(isset($user_fields->picture->uri)) {
                $imageUrl = file_create_url($user_fields->picture->uri);
            } else {
                $imageUrl = '/sites/default/files/pictures/patient.png';
            }
            if(isset($user_fields->field_mobile_phone['und'])) {
                $phone = $user_fields->field_mobile_phone['und']['0']['value'];
            }


            $userList .= '
            <div class="patient-list-row clearfix">';

              // Buttons
            $userList .= '<div class="patient-actions btn-container">';
            if($row['checked'] == '1') {
                $userList .= '<button class="btn btn-prescribe" data-button=\'{"problemId": '. $problemId .', "patientId": '. $patientId .'}\'>Edit Prescription</button>';
            } else {
                $userList .= '<button class="btn btn-prescribe" data-button=\'{"problemId": '. $problemId .', "patientId": '. $patientId .'}\'>Prescribe</button>';
            }
            $userList .= '<button class="btn chat">Chat</button>
            </div>';

            // User info
            $userList .= '<div>
            <h3>Patient: '  . $user_fields->name . '</h3>
            <img src="' .  $imageUrl . '">
            
            <div>
            <span><strong>E-mail: </strong></span>
            <a href="mailto:'. $user_fields->mail .'">'. $user_fields->mail .'</a>
            </div>

            <div>
            <span><strong>Mobile: </strong></span>
            <a href="tel:'. $phone .'">'. $phone .'</a>
            </div>

            </div>
            ';

          

            // Problems and Symptoms
            $records = db_select('patient_records', 'pr')
            ->fields('pr')
            ->condition('entity_id', $problemId)
            ->condition('uid', $patientId)
            ->execute();
            $problem = node_load($problemId);
            $userList .= '<strong>Problem: </strong>'. $problem->title;
            $userList .= '<div class="patient-symptom-list">
                <h4>Symptoms:</h4>
                <ul>';
            while($record = $records->fetchAssoc()) {
                $userList .= '<li><span><strong>'. $record['symptom_name'] .': </strong>'. $record['symptom_level'] .'</span></li>';
            }
            $userList .= '</ul></div>';

        
            $userList .= '</div>';
        }
        
        
    } else if($res && $res->rowCount()==0) {
        $userList.= '<h4>There are no patients at the moment</h4>';
    }
    $userList .= '</section>';
    echo $userList;

//     $view = views_get_view('product_selection');
// $display_id = 'block_products';
// $view->set_display($display_id);
// $view->init_handlers();
// $view->pre_execute();
// $view->execute();
// $form_state = array(
//   'view' => $view,
//   'display' => $view->display_handler->display,
//   'exposed_form_plugin' => $view->display_handler->get_plugin('exposed_form'),
//   'method' => 'get',
//   'rerender' => TRUE,
//   'no_redirect' => TRUE,
// );
// $form = drupal_build_form('views_exposed_form', $form_state);

// print drupal_render($form);


$view = views_get_view('product_selection','block_products');
$view->override_path = $_GET['q'];


// $view_filters = $view->display_handler->get_option('filters');
// $view_filters['model']['value'] = 'LAP-2417396267-SKU';
// $overrides = array();
//   $overrides['filters'] = $view_filters;
//   foreach ($overrides as $option => $definition) {
//     $view->display_handler->override_option($option, $definition);
// }

$viewsoutput = $view->preview();
//views_embed_view('product_selection','block_products') 
//print $viewsoutput;

    $prescribe = '
    <section class="form-popup animate-bottom" id="myForm">
    
    <div class="form-container">
    <div id="product-selection-form-id">
    '. $viewsoutput .'
    </div>    
    </div>
    
    </section>';

    print $prescribe;


}

?>

