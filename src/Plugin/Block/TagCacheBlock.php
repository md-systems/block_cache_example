<?php

namespace Drupal\block_cache_example\Plugin\Block;

use Drupal\Component\Serialization\Json;
use Drupal\Core\Block\BlockBase;

/**
 * Provides a block to test caching.
 *
 * @Block(
 *   id = "block_cache_example_tagcache",
 *   admin_label = @Translation("Example Cache Block: Tag caching")
 * )
 */
class TagCacheBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $content = \Drupal::state()->get('block_cache_example_people');
    if (!$content) {
      return ['#markup' => $this->t('No data, run cron!')];
    }
    $data = Json::decode($content);

    $build = [
      '#theme' => 'item_list',
      '#items' => [],
    ];
    foreach ($data['people'] ?? [] as $person) {
      $build['#items'][] = [
        '#markup' => $person['firstName'] . ' ' . $person['lastName'] . ', ' . $person['age'],
      ];
    }

    return $build;
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheTags() {
    return ['block_cache_example_people'];
  }

}
