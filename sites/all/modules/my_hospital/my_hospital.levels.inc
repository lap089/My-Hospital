<?php

/**
 * @file
 *
 * Functions that return data used in the my_hospital field.
 */

/**
 * Return an array in the form
 *
 * array(
 *   ...
 * );
 */

function my_hospital_symptom_levels() {
  return _my_hospital_levels_make_assoc(array(
    'None', 'Slight', 'Medium', 'Terrible',
  ));
}

function _my_hospital_levels_make_assoc($arr) {
  $newarr = array();
  foreach ($arr as $el) {
    $newarr[my_hospital_make_machine_name($el)] = $el;
  }
  return $newarr;
}

function my_hospital_make_machine_name($name) {
  return str_replace(' ', '_', strtolower($name));
}

function my_hospital_make_html_name($name) {
  return str_replace(' ', '-', strtolower($name));
}

