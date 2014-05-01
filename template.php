<?php
/**
 * @file
 * Theme functions
 */

require_once dirname(__FILE__) . '/includes/structure.inc';
require_once dirname(__FILE__) . '/includes/comment.inc';
require_once dirname(__FILE__) . '/includes/form.inc';
require_once dirname(__FILE__) . '/includes/menu.inc';
require_once dirname(__FILE__) . '/includes/node.inc';
require_once dirname(__FILE__) . '/includes/panel.inc';
require_once dirname(__FILE__) . '/includes/user.inc';
require_once dirname(__FILE__) . '/includes/view.inc';

/**
 * Implements hook_css_alter().
 */
function unary_css_alter(&$css) {
  $radix_path = drupal_get_path('theme', 'radix');

  // Radix now includes compiled stylesheets for demo purposes.
  // We remove these from our subtheme since they are already included 
  // in compass_radix.
  unset($css[$radix_path . '/assets/stylesheets/radix-style.css']);
  unset($css[$radix_path . '/assets/stylesheets/radix-print.css']);
}

/**
 * Implements template_preprocess_page().
 */
function unary_preprocess_page(&$variables) {
  // Add copyright to theme.
  if ($copyright = theme_get_setting('copyright')) {
    $variables['copyright'] = check_markup($copyright['value'], $copyright['format']);
  }

  // Separate primary and secondary tabs.
  if (isset($variables['tabs'])) {
    $variables['primary_tabs'] = $variables['tabs'];
    $variables['secondary_tabs'] = $variables['tabs'];
    if (isset($variables['primary_tabs']['#secondary'])) {
      unset($variables['primary_tabs']['#secondary']);
    }
    if (isset($variables['secondary_tabs']['#primary'])) {
      unset($variables['secondary_tabs']['#primary']);
    }
  }

  // Theme action links as buttons.
  foreach ($variables['action_links'] as $key => &$link) {
    $link['#link']['localized_options']['attributes'] = array('class' => array('btn', 'btn-primary', 'btn-md'));
  }
}
