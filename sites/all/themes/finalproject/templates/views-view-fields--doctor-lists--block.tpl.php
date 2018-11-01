<?php

/**
 * @file
 * Default simple view template to all the fields as a row.
 *
 * - $view: The view in use.
 * - $fields: an array of $field objects. Each one contains:
 *   - $field->content: The output of the field.
 *   - $field->raw: The raw data for the field, if it exists. This is NOT output safe.
 *   - $field->class: The safe class id to use.
 *   - $field->handler: The Views field handler object controlling this field. Do not use
 *     var_export to dump this object, as it can't handle the recursion.
 *   - $field->inline: Whether or not the field should be inline.
 *   - $field->inline_html: either div or span based on the above flag.
 *   - $field->wrapper_prefix: A complete wrapper containing the inline_html to use.
 *   - $field->wrapper_suffix: The closing tag for the wrapper.
 *   - $field->separator: an optional separator that may appear before a field.
 *   - $field->label: The wrap label text to use.
 *   - $field->label_html: The full HTML of the label to use including
 *     configured element type.
 * - $row: The raw result object from the query, with all data it fetched.
 *
 * @ingroup views_templates
 */
?>

<?php 


drupal_add_js('sites/all/themes/finalproject/js/doctor-selection.js');
drupal_add_css('sites/all/themes/finalproject/css/doctor-selection.css');

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

// watchdog('Doctor base', '<pre>'. print_r($GLOBALS['base_url'], TRUE) . '</pre>' );
// watchdog('Doctor dir path', '<pre>'. print_r(variable_get('file_public_path'), TRUE) . '</pre>' );
// watchdog('Doctor con', '<pre>'. print_r(conf_path(), TRUE) . '</pre>' );


?>





<?php
$uid = filter_var($fields['uid']->content, FILTER_SANITIZE_NUMBER_INT);
print '<div class="doctor-selection-list" data-uid=' . $uid . '>';
?>

<?php foreach ($fields as $id => $field): ?>
<?php if($id == 'uid') continue;?>
  <?php if (!empty($field->separator)): ?>
    <?php print $field->separator; ?>
  <?php endif; ?>

  <?php print $field->label_html; ?>
  <?php print $field->content; ?>

<?php endforeach; ?>

</div>

