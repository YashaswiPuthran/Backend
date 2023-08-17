<?php

namespace Drupal\dependent_dropdown_task\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;

/**
 * Class of Dependent.
 */
class Dependent extends FormBase
{

    /**
     * {@inheritdoc}
     */
    public function getFormId()
    {
        return 'dep_form';
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state)
    {
        $selected_item_id = $form_state->getValue("electronic_items");
        $selected_model_id = $form_state->getValue("models");
        $form['electronic_items'] = [
            '#type' => 'select',
            '#title' => $this->t('Electronic Items'),
            '#options' => $this->getElectronics(),
            '#empty_option' => $this->t('- Select -'),
            '#ajax' => [
                'callback' => [$this, 'ajaxModelDropdownCallback'],
                'wrapper' => 'model-dropdown-wrapper',
                'event' => 'change',
                'progress' => [
                    'type' => 'throbber',
                    'message' => $this->t('Loading...'),
                ],
            ],
        ];

        $form['models'] = [
            '#type' => 'select',
            '#title' => $this->t('Mobile Model'),
            '#options' => $this->getModels($selected_item_id),
            '#empty_option' => $this->t('- Select -'),
            '#prefix' => '<div id="model-dropdown-wrapper">',
            '#suffix' => '</div>',
            '#ajax' => [
                'callback' => [$this, 'ajaxColorDropdownCallback'],
                'wrapper' => 'color-dropdown-wrapper',
                'event' => 'change',
                'progress' => [
                    'type' => 'throbber',
                    'message' => $this->t('Loading...'),
                ],
            ],
        ];

        $form['colors'] = [
            '#type' => 'select',
            '#title' => $this->t('Choose Color'),
            '#options' => $this->getColors($selected_model_id),
            '#prefix' => '<div id="color-dropdown-wrapper">',
            '#suffix' => '</div>',
            '#empty_option' => $this->t('- Select -'),
        ];

        $form['submit'] = [
            '#type'=> 'submit',
            '#value' => $this->t('Submit'),
        ];

        return $form;
    }

    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state)
    {
        // Submit logic
    }


    public function ajaxModelDropdownCallback(array &$form, FormStateInterface $form_state)
    {
        return $form['models'];
    }


    public function ajaxColorDropdownCallback(array &$form, FormStateInterface $form_state)
    {
        return $form['colors'];
    }


    private function getElectronics()
    {
        $query = Database::getConnection()->select('electronic_items', 'e');
        $query->fields('e', ['id', 'name']);
        $result = $query->execute();
        $item = [];

        foreach ($result as $row) {
            $item[$row->id] = $row->name;
        }

        return $item;
    }
    private function getModels($selected_item_id)
    {

        $query = Database::getConnection()->select('models', 'm');
        $query->fields('m', ['id', 'name']);
        $query->condition('m.item_id',  $selected_item_id);
        $result = $query->execute();

        $model = [];
        foreach ($result as $row) {
            $model[$row->id] = $row->name;
        }
        return $model;
    }

    function getColors($selected_model_id)
    {
        $query = Database::getConnection()->select('colors', 'c');
        $query->fields('c', ['id', 'color']);
        $query->condition('c.model_id', $selected_model_id);
        $result = $query->execute();

        $color = [];
        foreach ($result as $row) {
            $color[$row->id] = $row->color;
        }

        return $color;
    }
}
