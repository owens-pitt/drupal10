<?php

namespace Drupal\layout_builder_simple\Plugin\Layout;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\layout_builder_base\Plugin\Layout\DefaultLayoutBase;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Configurable layout plugin class.
 *
 * @internal
 *   Plugin classes are internal.
 */
class BaseFullbleedLayout extends DefaultLayoutBase implements ContainerFactoryPluginInterface {

  /**
   * The module handler service.
   *
   * @var \Drupal\Core\Extension\ModuleHandlerInterface
   */
  protected $moduleHandler;

  /**
   * Constructs a BaseRowLayout object.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *    The config factory service.
   * @param \Drupal\Core\Extension\ModuleHandlerInterface $account
   *    The module handler service.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, ConfigFactoryInterface $config_factory, ModuleHandlerInterface $module_handler) {
    $this->moduleHandler = $module_handler;
    parent::__construct($configuration, $plugin_id, $plugin_definition, $config_factory);
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('config.factory'),
      $container->get('module_handler')
    );
  }

  /**
   * {@inheritdoc}
   */
  protected function getBackgroundOverlayOptions() {
    $options = [
      'layout--background-overlay--none' => $this->t('None'),
      'layout--background-fullbleed layout--background-fullbleed--lightgraytorn' => $this->t('Light Gray Torn Edges'),
      'layout--background-fullbleed layout--background-fullbleed--graygrit' => $this->t('Dark Gray Grit'),
      'layout--background-fullbleed layout--background-fullbleed--goldgrit' => $this->t('Gold Grit'),  
      'layout--background-fullbleed layout--background-fullbleed--gray' => $this->t('Dark Gray Solid'),
      'layout--background-fullbleed layout--background-fullbleed--gold' => $this->t('Gold Solid'),      ];
    $this->moduleHandler->alter('layout_builder_base_background_overlay', $options);

    return $options;
  }


  /**
   * {@inheritdoc}
   */
/*
  protected function getBackgroundOptions() {
    $options = [
      'layout--background--none' => $this->t('None'),
      'layout--background--white' => $this->t('White'),
      'layout--background--blue' => $this->t('Pitt Blue'),
      'layout--background--gold' => $this->t('Pitt Gold'),
      'layout--background--gray' => $this->t('Pitt Gray'),
    ];
    $this->moduleHandler->alter('layout_builder_base_background', $options);

    return $options;
  }
*/

  /**
   * {@inheritdoc}
   */

  protected function getBackgroundAttachmentOptions() {
    $options = [
      'layout--background-attachment--default' => $this->t('Default'),
      'layout--background-attachment--fixed' => $this->t('Fixed'),
    ];

    $this->moduleHandler->alter('layout_builder_base_background_attachment', $options);

    return $options;
  }

  /**
   * {@inheritdoc}
   */
  protected function getBackgroundPositionOptions() {
    $options = [
      'layout--background-position--default' => $this->t('Default'),
      'layout--background-position--center' => $this->t('Center'),
    ];
    $this->moduleHandler->alter('layout_builder_base_background_position', $options);

    return $options;
  }

  /**
   * {@inheritdoc}
   */
/*
  protected function getColorsOptions() {
    $options = [
      'layout--color--default' => $this->t('Default'),
      'layout--color--black' => $this->t('Black'),
      'layout--color--white' => $this->t('White'),
      'layout--color--grey' => $this->t('Grey'),
    ];
    $this->moduleHandler->alter('layout_builder_base_color', $options);

    return $options;
  }
*/

  /**
   * {@inheritdoc}
   */
/*
  protected function getAlignmentOptions() {
    $options = [
      '' => $this->t('Default'),
      'layout--alignment--left' => $this->t('Left'),
      'layout--alignment--right' => $this->t('Right'),
      'layout--alignment--center' => $this->t('Center'),
      'layout--alignment--justify' => $this->t('Justify'),
    ];
    $this->moduleHandler->alter('layout_builder_base_alignment', $options);

    return $options;
  }
*/

  /**
   * {@inheritdoc}
   */
  protected function enableImageBackground() {
    return TRUE;
  }

  /**
   * {@inheritdoc}
   */
  public function build(array $regions) {
    $build = parent::build($regions);
    $build['#attached']['library'][] = 'layout_builder_simple/layout-builder-simple';
    return $build;
  }

}