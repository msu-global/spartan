<?php
/**
 * @file
 * template.php
 */

/**
 *  Adds responsize class to all images.
 */
function spartan_preprocess_image_style(&$vars) {
  $vars['attributes']['class'][] = 'img-responsive';
}

/**
 * Implements template_preprocess_page().
 */
 function spartan_preprocess_page(&$variables) {
    if (module_exists('page_manager') && sizeof(page_manager_get_current_page())) {
      // Add containerless page template for specific layouts.
      //$variables['theme_hook_suggestions'][] = 'page__panels';
    }
 }
