<?php

declare(strict_types = 1);

namespace Drupal\thirteen_custom\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a Thirteen custom form.
 */
final class ExampleForm extends FormBase {

  /**
   * Logger channel.
   *
   * @var \Psr\Log\LoggerInterface
   */

  protected $logger;

  /**
   * Constructs a CustomLogger object.
   *
   * @param \Drupal\Core\Log\LoggerInterface $logger
   *   The logger service.
   */
  public function __construct(LoggerInterface $logger) {
    $this->logger = $logger;
  }

  /**
   * {@inheritDoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('logger.factory')->get('thirteen_custom')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId(): string {
    return 'thirteen_custom_example';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state): array {
    $form["#attached"]["library"][] = "thirteen_custom/js_lib";
    $form['first_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('First name'),
      '#required' => TRUE,
    ];

    $form['has_last'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Has Name or Not'),
      '#attributes' => ['id' => 'has_last'],
    ];

    $form['last_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Last name'),
      // '#states' => [
      // 'visible'=> [
      // ':input[name="has_last"]' => ['checked' => FALSE],
      // ],
      // ]
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state): void {
    // @todo Validate the form here.
    // Example:
    // @code
    //   if (mb_strlen($form_state->getValue('message')) < 10) {
    //     $form_state->setErrorByName(
    //       'message',
    //       $this->t('Message should be at least 10 characters.'),
    //     );
    //   }
    // @endcode
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state): void {
    $this->logger->warning($this->t('message'));
    $this->logger->error($this->t('error'));
    $this->logger->notice($this->t('notice'));
    $this->messenger()->addStatus($this->t('submitted'));
  }

}
