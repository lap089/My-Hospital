<?php
/**
 * @file
 * Contains the theme's functions to manipulate Drupal's default markup.
 *
 * Complete documentation for this file is available online.
 * @see https://drupal.org/node/1728096
 */


/**
 * Override or insert variables into the maintenance page template.
 *
 * @param array $variables
 *   Variables to pass to the theme template.
 * @param string $hook
 *   The name of the template being rendered ("maintenance_page" in this case.)
 */
/* -- Delete this line if you want to use this function
function finalproject_preprocess_maintenance_page(&$variables, $hook) {
  // When a variable is manipulated or added in preprocess_html or
  // preprocess_page, that same work is probably needed for the maintenance page
  // as well, so we can just re-use those functions to do that work here.
  finalproject_preprocess_html($variables, $hook);
  finalproject_preprocess_page($variables, $hook);
}
// */

/**
 * Override or insert variables into the html templates.
 *
 * @param array $variables
 *   Variables to pass to the theme template.
 * @param string $hook
 *   The name of the template being rendered ("html" in this case.)
 */
/* -- Delete this line if you want to use this function
function finalproject_preprocess_html(&$variables, $hook) {
  $variables['sample_variable'] = t('Lorem ipsum.');

  // The body tag's classes are controlled by the $classes_array variable. To
  // remove a class from $classes_array, use array_diff().
  $variables['classes_array'] = array_diff($variables['classes_array'],
    array('class-to-remove')
  );
}
// */

/**
 * Override or insert variables into the page templates.
 *
 * @param array $variables
 *   Variables to pass to the theme template.
 * @param string $hook
 *   The name of the template being rendered ("page" in this case.)
 */
// -- Delete this line if you want to use this function
// function finalproject_preprocess_page(&$variables, $hook) {
//   $variables['sample_variable'] = t('Lorem ipsum.');

// }


/**
 * Override or insert variables into the region templates.
 *
 * @param array $variables
 *   Variables to pass to the theme template.
 * @param string $hook
 *   The name of the template being rendered ("region" in this case.)
 */
/* -- Delete this line if you want to use this function
function finalproject_preprocess_region(&$variables, $hook) {
  // Don't use Zen's region--no-wrapper.tpl.php template for sidebars.
  if (strpos($variables['region'], 'sidebar_') === 0) {
    $variables['theme_hook_suggestions'] = array_diff(
      $variables['theme_hook_suggestions'], array('region__no_wrapper')
    );
  }
}
// */

/**
 * Override or insert variables into the block templates.
 *
 * @param array $variables
 *   Variables to pass to the theme template.
 * @param string $hook
 *   The name of the template being rendered ("block" in this case.)
 */
/* -- Delete this line if you want to use this function
function finalproject_preprocess_block(&$variables, $hook) {
  // Add a count to all the blocks in the region.
  // $variables['classes_array'][] = 'count-' . $variables['block_id'];

  // By default, Zen will use the block--no-wrapper.tpl.php for the main
  // content. This optional bit of code undoes that:
  if ($variables['block_html_id'] == 'block-system-main') {
    $variables['theme_hook_suggestions'] = array_diff(
      $variables['theme_hook_suggestions'], array('block__no_wrapper')
    );
  }
}
// */

/**
 * Override or insert variables into the node templates.
 *
 * @param array $variables
 *   Variables to pass to the theme template.
 * @param string $hook
 *   The name of the template being rendered ("node" in this case.)
 */
/* -- Delete this line if you want to use this function
function finalproject_preprocess_node(&$variables, $hook) {
  $variables['sample_variable'] = t('Lorem ipsum.');

  // Optionally, run node-type-specific preprocess functions, like
  // finalproject_preprocess_node_page() or finalproject_preprocess_node_story().
  $function = __FUNCTION__ . '_' . $variables['node']->type;
  if (function_exists($function)) {
    $function($variables, $hook);
  }
}
// */

/**
 * Override or insert variables into the comment templates.
 *
 * @param array $variables
 *   Variables to pass to the theme template.
 * @param string $hook
 *   The name of the template being rendered ("comment" in this case.)
 */
/* -- Delete this line if you want to use this function
function finalproject_preprocess_comment(&$variables, $hook) {
  $variables['sample_variable'] = t('Lorem ipsum.');
}
// */


function finalproject_preprocess_page(&$vars) {
  //watchdog('preprocess page', '<pre>'. print_r($vars['node']->type, TRUE) . '</pre>' );
  // switch($vars['node']->type) {

	// 	// Embedded AJAX views require manual js injection into the header
	// 	// See http://drupal.org/node/386388
	// 	case 'nodeTypeWhichHasTheEmbeddedAJAXView':
	// 		views_add_js('dependent');
	// 		views_add_js('ajax_view');
	// 		$vars['scripts'] = drupal_get_js();
	// 		break;
  // }

      views_add_js('ajax_view');
      $vars['scripts'] = drupal_get_js();
      return $vars;
}


function finalproject_get_views_js_settings() {
	// Get a list of all the javascript drupal should be adding to the page.
	// Our missing views ajax settings should be in here.
	$javascript = drupal_add_js(NULL, NULL, 'header');
	// $javascript structure is the one used in /includes/common.inc

	// Go through $javascript and pluck out the views settings.
	// We'll print out only these ones (probably only one, since there's usually only one ajax view on the page).
	foreach ($javascript as $type=>$data) {
		if ($type=='setting') {
			foreach($data as $setting) {
				if (isset($setting['views'])) {
					if (!$js) {
						$js = array('setting' => array());
					}

					$js['setting'][] = $setting;
				}
			}
		}
	}

	if ($js) {
		return drupal_get_js('header', $js);
	}
}