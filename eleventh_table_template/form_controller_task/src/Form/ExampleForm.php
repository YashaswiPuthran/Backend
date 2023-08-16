<?php

declare(strict_types=1);

namespace Drupal\form_controller_task\Form;

use Drupal\Core\Database\Connection;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Messenger\MessengerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a Form controller task form.
 */
final class ExampleForm extends FormBase {

  /**
   * The messenger service.
   *
   * @var \Drupal\Core\Messenger\MessengerInterface
   */
  protected $messenger;

  /**
   * The database connection service.
   *
   * @var \Drupal\Core\Database\Connection
   */
  protected $database;

  /**
   * Constructor.
   */
  public function __construct(MessengerInterface $messenger, Connection $database) {
    $this->messenger = $messenger;
    $this->database = $database;
  }

  /**
   * Create an instance of the form.
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('messenger'),
      $container->get('database')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId(): string {
    return 'form_controller_task_example';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state): array {
    // Form fields definition.
    $form['firstname'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Firstname'),
      '#required' => TRUE,
    ];

    $form['lastname'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Lastname'),
      '#required' => TRUE,
    ];

    // ... (more field definitions)
    $form['gender'] = [
      '#type' => 'select',
      '#title' => $this->t('Gender'),
      '#required' => TRUE,
      '#options' => [
        'male' => 'male',
        'female' => 'female',
      ],
    ];

    // Actions section.
    $form['actions'] = [
      '#type' => 'actions',
      'submit' => [
        '#type' => 'submit',
        '#value' => $this->t('Send'),
      ],
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state): void {
    // Form submission logic.
    $this->messenger->addMessage('This is sent');
    $this->database->insert("form_controller")->fields([
      'firstname' => $form_state->getValue("firstname"),
      'lastname' => $form_state->getValue("lastname"),
      'email' => $form_state->getValue("email"),
      'phonenum' => $form_state->getValue("phonenum"),
      'gender' => $form_state->getValue("gender"),
    ])->execute();
    // $form_state->setRedirect('<front>');
  }

}
