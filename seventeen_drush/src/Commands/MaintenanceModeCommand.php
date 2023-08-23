<?php

namespace Drupal\seventeen_drush\Commands;

use Drupal\Core\Messenger\MessengerInterface;
use Drupal\Core\State\StateInterface;
use Drush\Commands\DrushCommands;

/**
 * Drush command.
 */
class MaintenanceModeCommand extends DrushCommands {

  /**
   * The messenger service.
   *
   * @var \Drupal\Core\Messenger\MessengerInterface
   */
  protected $messenger;

  /**
   * The state service.
   *
   * @var \Drupal\Core\State\StateInterface
   */
  protected $state;

  /**
   * Constructor for the DrushHelpersCommands class.
   *
   * @param \Drupal\Core\Messenger\MessengerInterface $messenger
   *   The messenger service.
   * @param \Drupal\Core\State\StateInterface $state
   *   The state service.
   */
  public function __construct(MessengerInterface $messenger, StateInterface $state) {
    $this->messenger = $messenger;
    $this->state = $state;
    parent::__construct();
  }

  /**
   * Put the site into maintenance mode.
   *
   * @command maintenance-mode:enable
   * @aliases mme
   * @usage drush maintenance-mode:enable
   */
  public function enableMaintenanceMode() {
    $this->state->set('system.maintenance_mode', TRUE);
    $this->messenger->addStatus('Maintenance Mode Enabled.');
  }

}
