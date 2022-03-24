<?php

namespace Drupal\fe_expert_core\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Custom form for JS Assignment.
 */
class JsAssignmentForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'js_assignment_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $options = [
      '' => '--SELECT--',
    ];

    $parentTags = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadTree('tags', 0, 1, TRUE);

    foreach($parentTags as $parentTag) {
      $options[$parentTag->id()] = $parentTag->name->value;
    }

    $form['type'] = [
      '#type' => 'select',
      '#title' => $this->t('Tag'),
      '#options' => $options,
      '#ajax' => [
        'callback'  => '::getChildTag',
        'wrapper'   => ['autocomplete-childtag-wrapper'],
      ]
    ];


    $form['childtag'] = [
      '#type' => 'textfield',
      '#disabled' => TRUE,
      '#value' => '',
      '#prefix' => '<div id="autocomplete-childtag-wrapper">',
      '#suffix' => '</div>',
    ];

    // Based on the tag display child tags only
    if (!empty($pid = $form_state->getValue('type', false))) {
      $form['childtag'] = [
        '#type' => 'textfield',
        '#prefix' => '<div id="autocomplete-childtag-wrapper">',
        '#suffix' => '</div>',
        '#autocomplete_route_name' => 'fe_expert_core.autocomplete',
        '#autocomplete_route_parameters' => ['pid' => $pid],
      ];
    }


    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
      '#button_type' => 'primary',
      '#attributes' => [
        'id' => 'assignmentSubmit',
      ],
      '#disabled' => TRUE,
    ];
    // Attach the library necessary for this test.
    $form['#attached']['library'][] = 'fe_expert_core/fe_expert_core_lib';

    return $form;
  }

  function getChildTag(array &$form, FormStateInterface $form_state) {
    $form['childtag']['#value'] = '';
    return $form['childtag'];
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    \Drupal::messenger()->addMessage(t("Form submission Done!! Submitted Values are:"));
 	  foreach ($form_state->getValues() as $key => $value) {
 	    \Drupal::messenger()->addMessage($key . ': ' . $value);
    }
  }

}
