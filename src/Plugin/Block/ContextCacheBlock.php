<?php

namespace Drupal\block_cache_example\Plugin\Block;

use Drupal\Component\Serialization\Json;
use Drupal\Core\Block\BlockBase;

/**
 * Provides a block to test caching.
 *
 * @Block(
 *   id = "block_cache_example_contextcache",
 *   admin_label = @Translation("Example Cache Block: Context caching")
 * )
 */
class ContextCacheBlock extends BlockBase {

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
      if ($person['firstName'] == \Drupal::request()->query->get('firstname')) {
        $build['#items'][] = [
          '#markup' => $person['firstName'] . ' ' . $person['lastName'] . ', ' . $person['age'],
        ];
      }
    }

    return $build;
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheContexts() {
    return ['url.query_args:firstname'];
  }

}
