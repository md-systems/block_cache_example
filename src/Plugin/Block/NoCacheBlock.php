<?php

namespace Drupal\block_cache_example\Plugin\Block;

use Drupal\Component\Serialization\Json;
use Drupal\Core\Block\BlockBase;

/**
 * Provides a block to test caching.
 *
 * @Block(
 *   id = "block_cache_example_nocache",
 *   admin_label = @Translation("Example Cache Block: No caching")
 * )
 */
class NoCacheBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $content = (string) \Drupal::httpClient()->get('https://filesamples.com/samples/code/json/sample4.json')->getBody();

    $data = Json::decode($content);

    $build = [
      '#theme' => 'item_list',
      '#items' => [],
    ];
    foreach ($data['people'] as $person) {
      $build['#items'][] = [
        '#markup' => $person['firstName'] . ' ' . $person['lastName'] . ', ' . $person['age'],
      ];
    }

    return $build;
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheMaxAge() {
    return 0;
  }

}
