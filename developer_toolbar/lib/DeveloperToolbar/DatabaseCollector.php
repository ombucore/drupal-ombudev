<?php

namespace DeveloperToolbar;

use DebugBar\DataCollector\DataCollector;
use DebugBar\DataCollector\Renderable;

/**
 * Display number of database queries.
 */
class DatabaseCollector extends DataCollector implements Renderable {
  /**
   * Flag to format SQL with parameters.
   */
  protected $formatWithParameters = FALSE;

  /**
   * {@inheritDoc}
   */
  public function collect() {
    $statements = array();
    $total_duration = 0;

    $queries = \Database::getLog('developer_toolbar', 'default');
    foreach ($queries as $query) {
      $total_duration += $query['time'];
      // $statements[] = array(
      //   'sql' => $this->formatWithParameters ? $this->formatSql($query) : $query['query'],
      //   'params' => (object) $query['args'],
      //   'duration' => $this->formatDuration($query['time']),
      //   'caller' => $query['caller'],
      //   'connection' => $query['target'],
      // );
    }

    return array(
      'total_statements' => count($queries),
      'statements' => $statements,
      'total_duration' => $this->formatDuration($total_duration),
    );
  }

  /**
   * Helper function to format sql statements with parameters.
   */
  protected function formatSql($query, $quotationChar = '<>') {
    if (($l = strlen($quotationChar)) > 1) {
      $quoteLeft = substr($quotationChar, 0, $l / 2);
      $quoteRight = substr($quotationChar, $l / 2);
    } else {
      $quoteLeft = $quoteRight = $quotationChar;
    }

    $sql = $query['query'];
    foreach ($query['args'] as $k => $v) {
      $v = "$quoteLeft$v$quoteRight";
      if (!is_numeric($k)) {
        $sql = str_replace($k, $v, $sql);
      } else {
        $p = strpos($sql, '?');
        $sql = substr($sql, 0, $p) . $v. substr($sql, $p + 1);
      }
    }
    return $sql;
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
        'widget' => 'DeveloperToolbar.Widgets.DatabaseWidget',
        'map' => 'database',
        'default' => '[]'
      ),
      'database:badge' => array(
        'map' => 'database.total_statements',
        'default' => 0,
      )
    );
  }
}
