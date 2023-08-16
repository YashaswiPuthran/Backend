<?php

namespace Drupal\field_task\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'Field_formatter' formatter.
 *
 * @FieldFormatter(
 *   id = "",
 *   label = @Translation("New Formatter"),
 *   field_types = {
 *     "integer"
 *   }
 * )
 */
class FieldFormatterTask extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [
      'concat' => 'dividing by 100   ',
    ] + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $form['concat'] = [
      '#type' => 'textfield',
      '#title' => 'concatenate with',
      '#default_value' => $this->getSetting('concat'),
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = [];
    $summary[] = $this->t("concatenate with : @concat", ["@concat" => $this->getSetting('concat')]);
    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];

    foreach ($items as $delta => $item) {
      $value = $item->value / 100;
      $concatenate = $this->getSetting('concat');
      $elements[$delta] = [
        '#markup' => '<p>' . $concatenate . $value . '</p>',
      ];
    }

    return $elements;
  }

}
