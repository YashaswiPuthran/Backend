<?php

namespace Drupal\email_task\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Implements the example form.
 */
class MailForm extends ConfigFormBase {
  const CONFIGNAME = "email_task.settings";

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'email_task_form';
  }

  /**
   * Function.
   */
  protected function getEditableConfigNames() {
    return [
      static::CONFIGNAME,
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config(static::CONFIGNAME);
    $form['subject'] = [
      '#type' => 'textfield',
      '#title' => 'Subject',
      '#default_value' => $config->get("subject"),
    ];

    $text_format = 'full_html';
    if ($config->get('textarea')['format']) {
      $text_format = $config->get('textarea')['format'];
    }
    $form['textarea'] = [
      '#type' => 'text_format',
      '#title' => 'Text',
      '#format' => $text_format,
      '#default_value' => $config->get("textarea")['value'],
    ];

    if (\Drupal::moduleHandler()->moduleExists('token')) {
      $form['tokens'] = [
        '#title' => $this->t('Tokens'),
        '#type' => 'container',
      ];
      $form['tokens']['help'] = [
        '#theme' => 'token_tree_link',
        '#token_types' => [
          'node',
        ],
        '#global_types' => FALSE,
        '#dialog' => TRUE,
      ];
    }

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = $this->config(static::CONFIGNAME);
    $config->set("subject", $form_state->getValue('subject'));
    $config->set("textarea", $form_state->getValue('textarea'));
    $config->save();
  }

}
