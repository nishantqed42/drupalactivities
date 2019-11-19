<?php

namespace Drupal\activities\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\activities\Services\WeatherInformation;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a 'Weather Information' Block.
 *
 * @Block(
 *   id = "weather_block",
 *   admin_label = @Translation("Weather Information Block"),
 *   category = @Translation("Weather"),
 * )
 */
class WeatherInformationBlock extends BlockBase implements ContainerFactoryPluginInterface {
  /**
   * @var weatherInformation
   */
  private $weatherInformation;

  public function __construct(array $configuration, $plugin_id, $plugin_definition, WeatherInformation $weatherInfo) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->weatherInformation = $weatherInfo;
  }

  public function build() {
    $cityWeatherInfo = $this->weatherInformation->getWeatherInformation($this->getConfiguration()['city_name']);
    return [
      '#theme' => 'weather_block',
      '#city' => $this->getConfiguration()['city_name'],
      '#temp' => $cityWeatherInfo['temp'],
      '#pressure' => $cityWeatherInfo['pressure'],
      '#humidity' => $cityWeatherInfo['humidity'],
      '#temp_min' => $cityWeatherInfo['temp_min'],
      '#temp_max' => $cityWeatherInfo['temp_max'],
      '#attached' => [
        'library' => 'activities/weather-library',
      ],
    ];
  }
  public function blockForm($form, FormStateInterface $form_state) {
    $form = parent::blockForm($form, $form_state);
    $config = $this->getConfiguration();
    $form['city_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('City Name'),
      '#description' => $this->t('Which City weather you want to see?'),
      '#default_value' => isset($config['city_name']) ? $config['city_name'] : '',
    ];
    return $form;
  }

  public function blockSubmit($form, FormStateInterface $form_state) {
    parent::blockSubmit($form, $form_state);
    $values = $form_state->getValues();
    $this->configuration['city_name'] = $values['city_name'];
  }
  
  /**
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   * @param array $configuration
   * @param string $plugin_id
   * @param mixed $plugin_definition
   *
   * @return static
   */
  
  /**
   * @inheritDoc
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('activities.weatherinformation')
    );
  }
}