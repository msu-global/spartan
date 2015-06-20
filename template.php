<?php
/**
 * @file
 * template.php
 */

/**
 *  Adds responsive class to all images.
 */
function spartan_preprocess_image_style(&$vars) {
  $vars['attributes']['class'][] = 'img-responsive';
}

/**
 * Implements hook_preprocess_page().
 */
function spartan_preprocess_page(&$variables) {
  $variables['theme_path'] = drupal_get_path('theme',$GLOBALS['theme']);
}

/**
 * Returns HTML for an individual media widget.
 *
 * @param $variables
 *   An associative array containing:
 *   - element: A render element representing the widget.
 *
 * @ingroup themeable
 */
function spartan_media_widget($variables) {
  $element = $variables['element'];
  $output = '';
  // The "form-media" class is required for proper Ajax functionality.
  $output .= '<div id="' . $element['#id'] . '" class="media-widget form-media clearfix">';
  $element['browse_button']['#title'] = t('Browse for resources');
  foreach ($element['browse_button']['#attributes']['class'] as $class) {
    if ($class == 'button') {
      unset($class);
    }
  }
  $element['browse_button']['#attributes']['class'][] = 'btn';
  $element['browse_button']['#attributes']['class'][] = 'btn-primary';
  $output .= drupal_render_children($element);
  $output .= '</div>';
  return $output;
}

/**
 * Implements hook_process_region().
 */
function spartan_process_region(&$variables) {

  switch ($variables['region']) {
    case 'navigation':
      $variables['classes_array'][] = 'navbar-right';
      $content_strings = array();

      // Form an array of markup strings to modify.
      foreach ($variables['elements'] as &$element) {
        if (!empty($element['#markup'])) {
          $content_strings[] = $element['#markup'];
        }
      }
      $content_strings[] = &$variables['content'];

      // Remove the word 'clearfix' anywhere it appears in the content.
      // Yes, anywhere.
      foreach ($content_strings as &$content_string) {
        $content_string = str_replace('clearfix', '', $content_string);
      }
      break;
  }
}

/**
 * Theme function to add a class to the user menu.
 */
function spartan_menu_tree__user_menu(&$variables) {
  return '<ul class="menu nav user-menu">' . $variables['tree'] . '</ul>';
}

/**
 * Theme function to show list of types that can be posted in forum.
 */
function spartan_advanced_forum_node_type_create_list(&$variables) {
  $forum_id = $variables['forum_id'];

  // Get the list of node types to display links for.
  $type_list = advanced_forum_node_type_create_list($forum_id);

  $output = '';
  if (is_array($type_list)) {
    foreach ($type_list as $type => $item) {
      $output .= '<div class="forum-add-node forum-add-' . $type . '">';
      $output .= theme('advanced_forum_l', array(
        'text' => t('New @node_type', array('@node_type' => $item['name'])),
        'path' => $item['href'],
        'options' => NULL,
        'button_class' => 'btn-success',
        ));
      $output .= '</div>';
    }
  }
  else {
    // User did not have access to create any node types in this fourm so
    // we just return the denial text / login prompt.
    $output = $type_list;
  }

  return $output;
}


/**
 * Theme function to format the reply link at the top/bottom of topic.
 *
 * Overridden to use Bootstrap button classes, and remove 'active' class.
 */
function spartan_advanced_forum_reply_link(&$variables) {
  $node = $variables['node'];

  // Get the information about whether the user can reply and the link to do
  // so if the user is allowed to.
  $reply_link = advanced_forum_get_reply_link($node);

  if (is_array($reply_link)) {
    // Reply is allowed. Variable contains the link information.
    $output = '<div class="topic-reply-allowed">';
    $output .= theme('advanced_forum_l', array(
      'text' => $reply_link['title'],
      'path' => $reply_link['href'],
      'options' => $reply_link['options'],
      'button_class' => 'btn-default',
    ));
    $output .= '</div>';
    // This will filter out all occurrences of the word 'active'.
    return str_replace('active', '', $output);
  }
  elseif ($reply_link == 'reply-locked') {
    // @TODO: The double span here is icky but I don't know how else to get
    // around the fact that there's no "a" to put the button class on.
    return '<div class="topic-reply-locked"><span class="btn btn-sm btn-danger"><span>' . t('Topic locked') . '</span></span></div>';
  }
  elseif ($reply_link == 'reply-forbidden') {
    // User is not allowed to reply to this topic.
    return theme('comment_post_forbidden', array('node' => $node));
  }
}

/**
 * Theme function to display a link, optionally buttonized.
 *
 * Overridden to use Bootstrap button classes.
 */
function spartan_advanced_forum_l(&$variables) {
  $text = $variables['text'];
  $path = empty($variables['path']) ? NULL : $variables['path'];
  $options = empty($variables['options']) ? array() : $variables['options'];
  $button_class = empty($variables['button_class']) ? NULL : $variables['button_class'];
  $l = '';
  if (!isset($options['attributes'])) {
    $options['attributes'] = array();
  }
  if (!is_null($button_class)) {
    // Buttonized link: add our button class and the span.
    if (!isset($options['attributes']['class'])) {
      $options['attributes']['class'] = array('btn', 'btn-xs', $button_class);
    }
    else {
      $options['attributes']['class'][] = 'btn';
      $options['attributes']['class'][] = 'btn-xs';
      $options['attributes']['class'][] = 'btn-default';
    }
    $options['html'] = TRUE;
    $l = l($text, $path, $options);
  }
  else {
    // Standard link: just send it through l().
    $l = l($text, $path, $options);
  }

  return $l;
}

