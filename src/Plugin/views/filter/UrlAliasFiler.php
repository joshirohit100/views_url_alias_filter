<?php

namespace Drupal\views_url_alias_filter\Plugin\views\filter;

use Drupal\views\Plugin\views\display\DisplayPluginBase;
use Drupal\views\Plugin\views\filter\StringFilter;
use Drupal\views\ViewExecutable;
use Drupal\views\Views;

/**
 * Filter nodes based on url alias.
 *
 * @ingroup views_filter_handlers
 *
 * @ViewsFilter("views_url_alias_filter")
 */
class UrlAliasFiler extends StringFilter {

  /**
   * {@inheritdoc}
   */
  public function init(ViewExecutable $view, DisplayPluginBase $display, array &$options = NULL) {
    parent::init($view, $display, $options);
  }

  /**
   * {@inheritdoc}
   */
  public function query() {
    if (!empty($this->value)) {
      $configuration = array(
        'type' => 'INNER',
        'table' => 'url_alias',
        'field' => 'source',
        'left_table' => 'node_field_data',
        'left_field' => 'nid',
        'operator' => 'LIKE',
        'left_query' => 'CONCAT(\'/node/\' . node_field_data.nid)',
      );

//      $configuration = array(
//        'type' => 'INNER',
//        'table' => 'url_alias',
//        'field' => 'SUBSTRING(source, 6)',
//        'left_table' => 'node_field_data',
//        'left_field' => 'nid',
//        'operator' => '=',
//        'extra' => array(
//          0 => array(
//            'field' => 'source',
//            'value' => '/node/%',
//            'operator' => 'LIKE',
//          ),
//        ),
//      );
      $join = Views::pluginManager('join')->createInstance('subquery', $configuration);
      $this->query->addRelationship('url_alias', $join, 'node_field_data');

      $info = $this->operators();
      $field = 'url_alias.alias';
      if (!empty($info[$this->operator]['method'])) {
        $this->{$info[$this->operator]['method']}($field);
      }
    }
  }

  /**
   * {@inheritdoc}
   */
  public function validate() {
    if (!empty($this->value)) {
      parent::validate();
    }
  }
}
