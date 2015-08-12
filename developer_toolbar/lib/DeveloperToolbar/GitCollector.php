<?php

/**
 *
 */

namespace DeveloperToolbar;

use DebugBar\DataCollector\DataCollector;
use DebugBar\DataCollector\Renderable;

/**
 * Collects info about current git state.
 */
class GitCollector extends DataCollector implements Renderable {

  /**
   * Extract the branch we currently have checked out.
   */
  public function getBranch() {
    static $branch;
    if (!$branch) {
      $file = '../.git/HEAD';
      if (is_readable($file) && $data = file_get_contents($file)) {
        list(, $branch) = explode('refs/heads/', $data);
      }
    }
    return $branch;
  }

  /**
   * {@inheritDoc}
   */
  public function collect()   {
    return array(
      'branch_str' => $this->getBranch(),
    );
  }

  /**
   * {@inheritDoc}
   */
  public function getName() {
    return 'git';
  }

  /**
   * {@inheritDoc}
   */
  public function getWidgets() {
    return array(
      'git' => array(
        'icon' => 'sitemap',
        'tooltip' => 'Git branch',
        'map' => 'git.branch_str',
        'default' => 'null'
      )
    );
  }

}
