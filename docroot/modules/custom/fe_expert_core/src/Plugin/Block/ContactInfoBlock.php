<?php

namespace Drupal\fe_expert_core\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a 'ContactInfoBlock' block.
 *
 * @Block(
 *   id = "contact_info_block",
 *   admin_label = @Translation("Contact Info Block"),
 * )
 */
class ContactInfoBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
      'fe_expert_contact_info' =>[
        'email' => 'information@untitled.tld',
        'phone' => '(000) 000-0000 x12387',
        'address' => t('1234 Somewhere Road #5432<br/>
                      Nashville, TN 00000<br/>
                      United States of America'),
         'address_format' => 'full_html'
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form = parent::blockForm($form, $form_state);
    $form['email'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Email'),
      '#default_value' => $this->configuration['fe_expert_contact_info']['email'],
      '#description' => $this->t('Website Email address'),
    ];

    $form['phone'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Phone'),
      '#default_value' => $this->configuration['fe_expert_contact_info']['phone'],
      '#description' => $this->t('Website phone number'),
    ];

    $form['address'] = [
      '#type' => 'text_format',
      '#format' => $this->configuration['fe_expert_contact_info']['address_format'] ? $this->configuration['fe_expert_contact_info']['address_format'] : 'full_html',
      '#title' => $this->t('Phone'),
      '#title' => $this->t('Address'),
      '#description' => $this->t('Website Address'),
      '#default_value' => $this->configuration['fe_expert_contact_info']['address'],
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['email'] = $form_state->getValue('email');
    $this->configuration['phone'] = $form_state->getValue('phone');
    $this->configuration['address'] = $form_state->getValue('address');
    parent::blockSubmit($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build[] = [
      '#theme' => 'contact_info',
      '#email' => $this->configuration['fe_expert_contact_info']['email'],
      '#phone' => $this->configuration['fe_expert_contact_info']['phone'],
      '#address' => $this->configuration['fe_expert_contact_info']['address'],
      '#cache' => [
        '#cache' => [
          'tags' => $this->getCacheTags(),
        ],
      ],
    ];

    return $build;
  }
}
