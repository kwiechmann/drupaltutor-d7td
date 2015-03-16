<?php

/**
 * Returns HTML for a recent node to be displayed in the recent content block.
 *
 * @param $variables
 *   An associative array containing:
 *   - node: A node object.
 *
 * @ingroup themeable
 */
function d7td_node_recent_content($variables) {
  $node = $variables['node'];
  $account = user_load($node->uid);

  $output = '<div class="node-title">';
  $output .= l($node->title, 'node/' . $node->nid);
  $output .= theme('mark', array('type' => node_mark($node->nid, $node->changed)));
  $output .= '</div>';
  $output .= '<div class="node-author">';
  $output .= theme('username', array('account' => $account));
  $output .= '</div>';
  $output .= '<div class="node-created">';
  $output .= format_date($node->created);
  $output .= '</div>';

  return $output;
}

/**
 * Returns HTML for a marker for new or updated content.
 *
 * @param $variables
 *   An associative array containing:
 *   - type: Number representing the marker type to display. See MARK_NEW,
 *     MARK_UPDATED, MARK_READ.
 */
function d7td_mark($variables) {
  $type = $variables['type'];
  global $user;
  if ($user->uid) {
    if ($type == MARK_NEW) {
      return ' <span class="marker marker-new">' . t('**') . '</span>';
    }
    elseif ($type == MARK_UPDATED) {
      return ' <span class="marker marker-updated">' . t('*') . '</span>';
    }
  }
}

/**
 * Preprocesses variables for theme_username().
 *
 * Modules that make any changes to variables like 'name' or 'extra' must insure
 * that the final string is safe to include directly in the output by using
 * check_plain() or filter_xss().
 *
 * @see template_process_username()
 */
function d7td_preprocess_username(&$variables) {
  $account = $variables['account'];

  if (!empty($account->mail)) {
    $variables['extra'] .= ' <span clsss="user-email">(' . $account->mail . ')</span>';
  }
  else {
    $account = user_load($account->uid);
    $variables['account'] = $account;
    if (!empty($account->mail)) {
      $variables['extra'] .= ' <span clsss="user-email">(' . $account->mail . ')</span>';
    }
  }
}

/**
 * Preprocesses variables for theme_username().
 *
 * Modules that make any changes to variables like 'name' or 'extra' must insure
 * that the final string is safe to include directly in the output by using
 * check_plain() or filter_xss().
 *
 * @see template_process_username()
 */
function d7td_process_username(&$variables) {
  if (!empty($variables['extra'])) {
    $variables['extra'] = str_replace('@', '+spam@', $variables['extra']);
  } 
}



