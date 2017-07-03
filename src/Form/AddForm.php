<?php


namespace Drupal\leap_year\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Drupal\Component\Utility\UrlHelper;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\ChangedCommand;
use Drupal\Core\Ajax\CssCommand;
use Drupal\Core\Ajax\HtmlCommand;
use Drupal\Core\Ajax\InvokeCommand;
use Drupal\Core\Form;

/**
 * Class AddForm.
 *
 * @package Drupal\age_calculator\Form\AddForm
 */
class AddForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'leap_yr_add';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form = array();



    // Date Input
    $form['inputdate'] = array(
      '#title' => $this->t('Date to check'),
      '#type' => 'date',
      '#weight' => 1,
      '#default_value' => ''
    );


    // Submit button definition.
    $form['Check'] = array(
      '#type' => 'button',
      '#value' => $this->t('Calculate'),
      '#weight' => 2,
      '#ajax' => array(
        // Function to call when event on form element triggered.
        'callback' => '::calculateyear',
        'event' => 'click',
        'progress' => array(
          'type' => 'throbber', //WUT???
          'message' => 'Checking if leap year or not..',
        ),
      ),
    );

    // Results section markup.
    $form['calculated'] = array(
      '#type' => 'markup',
      '#weight' => 3,
      '#prefix' => '<div id="leap_year_calculated">',
      '#suffix' => '</div>',// WUTTTT???
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

  }

 // Function to check if leap year or not
   public function calculateyear(array &$form, FormStateInterface $form_state) {

     $output = '';
     // If input is not empty.
     if (!empty($form_state->getValue('inputdate'))) {
       $input_array = \explode('-', $form_state->getValue('inputdate'));
       // Formatting user input.
       $input = $input_array[2] . '-' . $input_array[1] . '-' . $input_array[0];
       $year=$input_array[0];

         if(($year%400==0)||(($year%4==0) && ($year%100!=0))){
           $leap="It is a leap year";
         }
         else{
           $leap="Not a leap year";
         }

           // Getting output.
           $output = $leap;

       }

     else {
       $output = $this->t('Cannot be empty.');
     }

     $response = new AjaxResponse();
     $response->addCommand(new HtmlCommand('#leap_year_calculated', $output));
     return $response;
   }
}
