<?php

namespace Drupal\views_custom_filter\Plugin\views\filter;
use Drupal\views\Plugin\views\display\DisplayPluginBase;
use Drupal\views\Plugin\views\filter\StringFilter;
use Drupal\views\ViewExecutable;
use Drupal\views\Views;

/**
 * Filters by given list of node title options.
 *
 * @ingroup views_filter_handlers
 *
 * @ViewsFilter("d8views_node_titles")
 */
class NodeTitles extends StringFilter {
  /**
   * {@inheritdoc}
   */
  public function init(ViewExecutable $view, DisplayPluginBase $display, array &$options = NULL) {
    parent::init($view, $display, $options);
  }
  /**
   * Override the query so that no filtering takes place if the user doesn't
   * select any options.
   */
  public function query() {
    if (!empty($this->value)) {
      $this->ensureMyTable();
      $field = "$this->tableAlias.nid";

      $configuration = array(
        'type' => 'INNER',
        'table' => 'menu_link_content_data',
        'field' => 'link__uri',
        'left_table' => 'node_field_data',
        'left_field' => 'nid',
        'operator' => '=',
      );
      $join = Views::pluginManager('join')->createInstance('standard', $configuration);
      $this->query->addRelationship('my_uu', $join, 'node_field_data');
      $this->query->addWhere($this->options['group'], $field, $this->value, '=');
    }
  }
  /**
   * Skip validation if no options have been chosen so we can use it as a
   * non-filter.
   */
  public function validate() {
    if (!empty($this->value)) {
      parent::validate();
    }
  }
}