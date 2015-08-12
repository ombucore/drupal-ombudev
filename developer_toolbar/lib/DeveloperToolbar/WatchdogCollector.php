<?php

/**
 *
 */

namespace DeveloperToolbar;

use DebugBar\DataCollector\RequestDataCollector;
use DebugBar\DataCollector\Renderable;

/**
 * Collects info about watchdog messages.
 */
class WatchdogCollector extends RequestDataCollector implements Renderable {

  /**
   * {@inheritDoc}
   */
  public function collect()   {

    $watchdog_messages = &drupal_static('devel_debug_bar_watchdog');
    $data = array();
    foreach ((array) $watchdog_messages as $watchdog_message) {
      $data[] = print_r($watchdog_message, TRUE);
    }
    return $data;
  }

  /**
   * {@inheritDoc}
   */
  public function getName() {
    return 'watchdog';
  }

  /**
   * {@inheritDoc}
   */
  public function getWidgets() {
    return array(
      "watchdog" => array(
        "widget" => "PhpDebugBar.Widgets.VariableListWidget",
        "map" => "watchdog",
        "default" => "{}"
      )
    );
  }

}
