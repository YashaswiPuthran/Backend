<?php

namespace Drupal\controller_task\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Token Form.
 */
class TokenForm extends ConfigFormBase {

  /**
   * Settings Variable.
   */
  const CONFIGNAME = "token_form.settings";

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return "token_form_settings";
  }

  /**
   * {@inheritdoc}
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
      '#title' => 'Sub Text',
      '#default_value' => $config->get("subject"),
    ];
    $form['textarea'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Textarea'),
      '#default_value' => $config->get('textarea'),
    ];

    // Token support.
    if (\Drupal::moduleHandler()->moduleExists('token')) {
      $form['tokens'] = [
        '#title' => $this->t('Tokens'),
        '#type' => 'container',
      ];
      $form['tokens']['help'] = [
        '#theme' => 'token_tree_link',
        '#token_types' => [
          'node',
          'site',
        ],
            // '#token_types' => 'all'
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
