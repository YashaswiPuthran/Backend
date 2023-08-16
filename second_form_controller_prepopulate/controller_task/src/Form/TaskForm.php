<?php

namespace Drupal\controller_task\Form;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\node\Entity\Node;
use Drupal\node\NodeInterface;
use Drupal\user\Entity\User;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Form class for creating and editing tasks using the TaskForm form.
 */
class TaskForm extends FormBase {

  /**
   * The entity type manager service.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * The current user object.
   *
   * @var \Drupal\Core\Session\AccountInterface
   */
  protected $currentUser;

  /**
   * The Database service.
   *
   * @var Drupal\Core\Database\Connection
   */
  protected $database;

  /**
   * Constructs a TaskForm object.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager service.
   * @param \Drupal\Core\Session\AccountInterface $current_user
   *   The current user object.
   */
  public function __construct(EntityTypeManagerInterface $entity_type_manager, AccountInterface $current_user) {
    $this->entityTypeManager = $entity_type_manager;
    $this->currentUser = $current_user;
    $this->database = $database;
  }

  /**
   * Creates a new instance of the TaskForm class.
   *
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   *   The container interface.
   *
   * @return \Drupal\controller_task\Form\TaskForm
   *   A new instance of the TaskForm class.
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity_type.manager'),
      $container->get('current_user'),
      $container->get('database'),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'controller_task_two_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, NodeInterface $node = NULL) {
    // Build the form elements.
    $form['title'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Title'),
      '#required' => TRUE,
      '#default_value' => $node ? $node->getTitle() : '',
    ];

    $user_reference = User::load($this->currentUser->id());

    $form['user_reference'] = [
      '#type' => 'entity_autocomplete',
      '#title' => $this->t('User Reference'),
      '#target_type' => 'user',
      '#required' => TRUE,
      '#default_value' => $user_reference,
    ];

    // If the user reference has been configured, set its default value.
    if (!empty($this->config['user_reference'])) {
      $form['user_reference']['#default_value'] = Node::load($this->configuration['user_reference']);
    }

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->database->insert("form_table")->fields([
      'title' => $form_state->getValue("title"),
      'user_reference' => $form_state->getValue("user_reference"),
    ])->execute();
  }

}
