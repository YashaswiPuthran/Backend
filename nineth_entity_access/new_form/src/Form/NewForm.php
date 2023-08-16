<?php

namespace Drupal\new_form\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\node\Entity\NodeType;

/**
 * Implements the Example configuration form.
 */
class NewForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'new_task_form';
  }

  /**
   * Comment.
   */
  protected function getEditableConfigNames() {
    return ['new_form.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $selected_role = $this->getRoles();
    $selected_content_types = $this->getContentTypes();

    $form['selected_roles'] = [
      '#type' => 'select',
      '#title' => 'Select a Role',
      '#options' => $selected_role,
    ];

    $form['selected_content_types'] = [
      '#type' => 'checkboxes',
      '#title' => $this->t('Select Content Types'),
      '#options' => $selected_content_types,
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Save Configuration'),
    ];

    return $form;
  }

  /**
   * Comment.
   */
  private function getRoles() {
    $selected_role = [];
    foreach (user_roles(TRUE) as $role) {
      $selected_role[$role->id()] = $role->label();
    }
    return $selected_role;
  }

  /**
   * Comment.
   */
  private function getContentTypes() {
    $selected_content_types = [];
    $node_types = NodeType::loadMultiple();
    foreach ($node_types as $node_type) {
      $selected_content_types[$node_type->id()] = $node_type->label();
    }
    return $selected_content_types;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $selected_role = $form_state->getValue('selected_roles');
    $selected_content_types = $form_state->getValue('selected_content_types');
    \Drupal::configFactory()->getEditable('new_form.settings')
      ->set('selected_roles', $selected_role)
      ->set('selected_content_types', $selected_content_types)
      ->save();

  }

}
