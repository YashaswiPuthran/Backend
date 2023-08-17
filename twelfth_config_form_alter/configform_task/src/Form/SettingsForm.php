<?php

declare(strict_types=1);

namespace Drupal\configform_task\Form;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Configure Configform task settings for this site.
 */
final class SettingsForm extends ConfigFormBase {

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Constructor for SettingsForm.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The configuration factory.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager.
   */
  public function __construct(ConfigFactoryInterface $config_factory, EntityTypeManagerInterface $entity_type_manager) {
    parent::__construct($config_factory);
    $this->entityTypeManager = $entity_type_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('config.factory'),
      $container->get('entity_type.manager')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId(): string {
    return 'configform_task_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames(): array {
    return ['configform_task.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state): array {
    $config = $this->config('configform_task.settings');
    $tag_reference = $config->get('tag_reference');

    $form['default_title'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Default Title'),
      '#default_value' => $config->get('default_title'),
    ];

    $form['advanced_box'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Advanced Checkbox'),
      '#default_value' => $config->get('advanced_box'),
    ];

    $form['tag_reference'] = [
      '#type' => 'entity_autocomplete',
      '#target_type' => 'taxonomy_term',
      '#title' => $this->t('Taxonomy Reference'),
      '#default_value' => $this->entityTypeManager->getStorage('taxonomy_term')->load($tag_reference),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state): void {
    $this->config('configform_task.settings')
      ->set('default_title', $form_state->getValue('default_title'))
      ->set('advanced_box', $form_state->getValue('advanced_box'))
      ->set('tag_reference', $form_state->getValue('tag_reference'))
      ->save();

    parent::submitForm($form, $form_state);
  }

}
