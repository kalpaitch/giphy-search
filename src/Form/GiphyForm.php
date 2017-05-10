<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 10/05/17
 * Time: 18:46
 */

namespace Drupal\giphy\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Giphy form.
 */
class GiphyForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'giphy_search_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, $term = '') {
    $form['term'] = array(
      '#type' => 'textfield',
      '#title' => t('Search'),
      '#required' => TRUE,
      '#default_value' => $term,
    );
    $form['search'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Search'),
    );

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {

  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $term = $form_state->getValue('term');
    return $form_state->setRedirect('giphy.search', [
      'term' => $term,
    ]);
  }

}
