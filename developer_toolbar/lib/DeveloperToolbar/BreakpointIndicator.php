<?php

namespace DeveloperToolbar;

use DebugBar\DataCollector\DataCollector;
use DebugBar\DataCollector\Renderable;

/**
 * Displays current breakpint.
 *
 * Logic handled in current theme CSS.
 */
class BreakpointIndicator extends DataCollector implements Renderable {
  /**
   * {@inheritDoc}
   */
  public function collect() {
    return array(
      'breakpoint_str' => '',
    );
  }

  /**
   * {@inheritDoc}
   */
  public function getName() {
    return 'breakpoint';
  }

  /**
   * {@inheritDoc}
   */
  public function getWidgets() {
    return array(
      'breakpoint' => array(
        'icon' => 'mobile',
        'tooltip' => 'Breakpoint',
        'map' => 'breakpoint.breakpoint_str',
        'default' => 'null'
      )
    );
  }

}
