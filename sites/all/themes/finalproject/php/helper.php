<?php

$drupal_path = "../../../../.."; 
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


$CURRENT_DIR = "sites/all/themes/finalproject/php/";


?>