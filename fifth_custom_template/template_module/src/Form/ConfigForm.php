<?php

namespace Drupal\template_module\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class ConfigForm is defined.
 */
class ConfigForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['template_module.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'template_module_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('template_module.settings');

    $form['title'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Title'),
      '#default_value' => $config->get('title'),
      '#required' => TRUE,
    ];

    $form['color_code'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Color Code'),
      '#default_value' => $config->get('color_code'),
      '#required' => TRUE,
      '#description' => $this->t('Enter a color code'),
    ];

    $form['paragraph'] = [
      '#type' => 'text_format',
      '#title' => $this->t('Paragraph'),
      '#default_value' => $config->get('paragraph')['value'],
      '#format' => $config->get('paragraph')['format'] ?: 'full_html',
      '#description' => $this->t('Paragraph Rich Field'),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('template_module.settings')
      ->set('title', $form_state->getValue('title'))
      ->set('color_code', $form_state->getValue('color_code'))
      ->set('paragraph', $form_state->getValue('paragraph'))
      ->save();

    parent::submitForm($form, $form_state);
  }

}
