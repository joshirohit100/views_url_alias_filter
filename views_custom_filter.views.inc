<?php

/**
 * Implements hook_views_data_alter().
 */
function views_custom_filter_views_data_alter (array &$data) {
  $data['node_field_data']['nodes_titles'] = array(
    'title' => t('Node titles Rohit'),
    'group' => t('Content'),
    'filter' => array(
      'title' => t('Node titles Rohit'),
      'help' => t('Specify a list of titles a node can have.'),
      'field' => 'title',
      'id' => 'd8views_node_titles'
    ),
  );
}
