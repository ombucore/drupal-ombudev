<?php

namespace DeveloperToolbar;

use DebugBar\DataCollector\DataCollector;
use DebugBar\DataCollector\Renderable;

/**
 * Displays current environment.
 */
class EnvironmentIndicator extends DataCollector implements Renderable {
  /**
   * {@inheritDoc}
   */
  public function collect() {
    return array(
      'environment_str' => variable_get('environment', ''),
    );
  }

  /**
   * {@inheritDoc}
   */
  public function getName() {
    return 'environment';
  }

  /**
   * {@inheritDoc}
   */
  public function getWidgets() {
    return array(
      'environment' => array(
        'icon' => 'compass',
        'tooltip' => 'Environment',
        'map' => 'environment.environment_str',
        'default' => 'null'
      )
    );
  }

}
