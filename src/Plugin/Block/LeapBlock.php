<?php

namespace Drupal\leap_year\Plugin\Block;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'leap_year' block.
 *
 * @Block(
 *   id = "leap_year_block",
 *   admin_label = @Translation("Leap Year"),
 * )
 */
class LeapBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  protected function blockAccess(AccountInterface $account) {
    return AccessResult::allowedIfHasPermission($account, 'access content');
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $form = \Drupal::formBuilder()->getForm('Drupal\leap_year\Form\AddForm');

    return [
      'add_this_page' => $form,
    ];
  }

}
