<?php

namespace Drupal\activities\Services;
use Drupal\Component\Serialization\Json;
use Drupal\Core\Config\ConfigFactory;
use GuzzleHttp\Client;

class WeatherInformation {
  protected $httpClient;
  protected $configfactory;
  public function __construct(Client $httpClient, ConfigFactory $config_factory) {
    $this->httpClient = $httpClient;
    $this->configfactory = $config_factory;
  }

  public function getWeatherInformation($city_name = 'Mumbai') {
    $app_id = $this->configfactory->get('activities.settings')->get('appid_config');
    $url = "https://api.openweathermap.org/data/2.5/weather?q=" . $city_name . "&appid=" . $app_id;
    $result = $this->httpClient->get($url);
    return Json::decode($result->getBody()->getContents())['main'];
  }
}