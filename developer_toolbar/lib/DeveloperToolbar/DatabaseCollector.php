<?php

namespace DeveloperToolbar;

use DebugBar\DataCollector\DataCollector;
use DebugBar\DataCollector\Renderable;

/**
 * Display number of database queries.
 */
class DatabaseCollector extends DataCollector implements Renderable {
  /**
   * {@inheritDoc}
   */
  public function collect() {
    $queries = \Database::getLog('developer_toolbar', 'default');
    return array(
      'database_str' => count($queries),
    );
  }

  /**
   * {@inheritDoc}
   */
  public function getName() {
    return 'database';
  }

  /**
   * {@inheritDoc}
   */
  public function getWidgets() {
    return array(
      'database' => array(
        'icon' => 'database',
        'tooltip' => 'Database queries',
        'map' => 'database.database_str',
        'default' => 'null'
      )
    );
  }

}
