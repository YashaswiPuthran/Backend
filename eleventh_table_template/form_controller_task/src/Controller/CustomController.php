<?php

namespace Drupal\form_controller_task\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Connection;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Controller to display custom content.
 */
class CustomController extends ControllerBase {

  /**
   * The database connection service.
   *
   * @var \Drupal\Core\Database\Connection
   */
  protected $database;

  /**
   * Constructor.
   */
  public function __construct(Connection $database) {
    $this->database = $database;
  }

  /**
   * Create an instance of the controller.
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('database')
    );
  }

  /**
   * Display content.
   */
  public function content() {
    // Retrieve data from the database.
    $query = $this->database->select('form_controller', 'fc')
      ->fields('fc')
      ->execute();
    $rows = [];

    // Iterate over query results and build rows.
    foreach ($query as $row) {
      $rows[] = [
        'id' => $row->id,
        'firstname' => $row->firstname,
        'lastname' => $row->lastname,
        'email' => $row->email,
        'phonenum' => $row->phonenum,
        'gender' => $row->gender,
      ];
    }

    // Build the renderable array.
    $result = [
      // Uncomment and use this for default table theme.
      // '#theme' => 'table',
      // Use this custom theme for rendering the content.
      '#theme' => 'task_control',
      '#rows' => $rows,
    ];

    return $result;
  }

}
