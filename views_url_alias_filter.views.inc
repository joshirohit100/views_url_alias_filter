<?php

/**
 * @file
 */

/**
 * Implements hook_views_data_alter().
 */
function views_url_alias_filter_views_data_alter (array &$data) {
  $data['node_field_data']['node_url_alias'] = array(
    'title' => t('Node URL Alias'),
    'group' => t('Content'),
    'filter' => array(
      'title' => t('Node URL Alias'),
      'help' => t('Filter nodes based on url alias.'),
      'field' => 'nid',
      'id' => 'views_url_alias_filter'
    ),
  );
}
