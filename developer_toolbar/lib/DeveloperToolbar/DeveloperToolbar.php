<?php

namespace DeveloperToolbar;

use DebugBar\DebugBar;
use DebugBar\DataCollector\PhpInfoCollector;
use DebugBar\DataCollector\MessagesCollector;
use DebugBar\DataCollector\TimeDataCollector;
use DebugBar\DataCollector\RequestDataCollector;
use DebugBar\DataCollector\MemoryCollector;
use DebugBar\DataCollector\ExceptionsCollector;

use DeveloperToolbar\GitCollector;
use DeveloperToolbar\EnvironmentIndicator;
use DeveloperToolbar\DatabaseCollector;


/**
 *
 */
class DeveloperToolbar extends DebugBar{

  protected static $instance;

  /**
   *
   */
  public function __construct() {

    if (self::$instance) {
      throw new \Exception('Debug bar instance already exists');
    }

    // PHP debug bar collectors.
    $this->addCollector(new PhpInfoCollector());
    // $this->addCollector(new MessagesCollector());
    $this->addCollector(new RequestDataCollector());
    $this->addCollector(new TimeDataCollector());
    $this->addCollector(new MemoryCollector());

    // Custom database toolbar collectors.
    $this->addCollector(new DatabaseCollector());
    // $gitCollector = new GitCollector();
    // if ($gitCollector->getBranch()) {
    //   $this->addCollector($gitCollector);
    // }
    $this->addCollector(new EnvironmentIndicator());

    self::$instance = $this;
  }

  /**
   *
   */
  public static function getInstance() {
    if (!self::$instance) {
      self::$instance = new static();
    }
    return self::$instance;
  }

} 
