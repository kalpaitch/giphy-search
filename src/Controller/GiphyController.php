<?php

namespace Drupal\giphy\Controller;

use Drupal\Core\Controller\ControllerBase;
use rfreebern\Giphy as Giphy;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Component\Utility\UrlHelper;

/**
 * A controller for handling all requests to giphy routes.
 */
class GiphyController extends ControllerBase {

  /**
   * The entity repository.
   *
   * @var Giphy
   *   The giphy api wrapper.
   */
  protected $giphy;

  /**
   * The search limit.
   *
   * @var int
   *   The number of results to return.
   */
  protected $limit = 10;

  /**
   * The Giphy display format.
   *
   * @var string
   *   The giphy format to use for display.
   */
  protected $display = 'fixed_width_small';

  /**
   * Constructs the site core controller.
   *
   * @param Giphy $giphy
   *   The giphy api wrapper.
   */
  public function __construct(Giphy $giphy) {
    $this->giphy = $giphy;
  }

  public static function create(ContainerInterface $container) {
    /** @var Giphy $giphy */
    $giphy = $container->get('giphy.api');
    return new static($giphy);
  }

  public function search($term = '') {
    $build = [];

    $build['form'] = \Drupal::formBuilder()->getForm('\Drupal\giphy\Form\GiphyForm', $term);

    $media = $this->giphy->search($term, $this->limit);

    if ($media) {
      foreach ($media->data as $gif) {
        $url = $gif->images->{$this->display}->url;
        $build['list'][] = [
          '#markup' => "<img src='$url' s/>",
        ];
      }
    }

    return $build;
  }

}
