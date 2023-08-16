<?php

declare(strict_types = 1);

namespace Drupal\drush_generated_module\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Entity\EntityDisplayRepositoryInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\node\Entity\Node;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a block.
 *
 * @Block(
 *   id = "yes",
 *   admin_label = @Translation("New Plugin Task"),
 *   category = @Translation("Custom"),
 * )
 */
final class YesBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * The entity display repository service.
   *
   * @var \Drupal\Core\Entity\EntityDisplayRepositoryInterface
   */
  protected $entityDisplayRepository;

  /**
   * The entity type manager service.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Constructs a new ExampleBlock object.
   *
   * @param array $configuration
   *   The plugin configuration.
   * @param string $plugin_id
   *   The plugin ID.
   * @param mixed $plugin_definition
   *   The plugin definition.
   * @param \Drupal\Core\Entity\EntityDisplayRepositoryInterface $entity_display_repository
   *   The entity display repository service.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager service.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, EntityDisplayRepositoryInterface $entity_display_repository, EntityTypeManagerInterface $entity_type_manager) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->entityDisplayRepository = $entity_display_repository;
    $this->entityTypeManager = $entity_type_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('entity_display.repository'),
      $container->get('entity_type.manager')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
      'node_reference' => '',
      'display_type' => "teaser",
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form['node_reference'] = [
      '#type' => 'entity_autocomplete',
      '#title' => 'Select Node',
      '#default_value' => Node::load($this->configuration['node_reference']),
      '#target_type' => 'node',
    ];
    $display_types = $this->entityDisplayRepository->getViewModeOptions('node');
    $form['display_type'] = [
      '#type' => 'radios',
      '#title' => 'View Mode',
      '#default_value' => $this->configuration['display_type'],
      '#options' => $display_types,
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['node_reference'] = $form_state->getValue('node_reference');
    $this->configuration['display_type'] = $form_state->getValue('display_type');
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $node_reference = $this->configuration['node_reference'];
    $display_type = $this->configuration['display_type'];
    $node = Node::load($node_reference);
    $display_type_build = $this->entityTypeManager->getViewBuilder('node');
    $node_view = $display_type_build->view($node, $display_type);
    return $node_view;
  }

}
