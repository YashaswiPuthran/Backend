<?php

namespace Drupal\controller_task\Controller;

use Drupal\controller_task\Form\TaskForm;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Form\FormBuilderInterface;
use Drupal\node\NodeInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Controller for handling tasks related to ControllerTask module.
 */
class ControllerTaskController extends ControllerBase {

  /**
   * The form builder service.
   *
   * @var \Drupal\Core\Form\FormBuilderInterface
   */
  protected $formBuilder;

  /**
   * ControllerTaskController constructor.
   *
   * @param \Drupal\Core\Form\FormBuilderInterface $form_builder
   *   The form builder service.
   */
  public function __construct(FormBuilderInterface $form_builder) {
    $this->formBuilder = $form_builder;
  }

  /**
   * Creates a new instance of the ControllerTaskController.
   *
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   *   The container interface.
   *
   * @return \Drupal\controller_task\Controller\ControllerTaskController
   *   A new instance of the ControllerTaskController.
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('form_builder')
    );
  }

  /**
   * Displays the task form for a specific node.
   *
   * @param \Drupal\node\NodeInterface $node
   *   The node for which the task form is being displayed.
   *
   * @return array
   *   The rendered form array.
   */
  public function taskTwo(NodeInterface $node) {
    // Get the task form for the specified node.
    $form = $this->formBuilder->getForm(TaskForm::class, $node);
    return $form;
  }

}
