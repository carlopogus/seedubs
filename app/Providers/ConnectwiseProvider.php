<?php

namespace App\Providers;
use Illuminate\Support\ServiceProvider;

class ConnectwiseProvider extends ServiceProvider {

  public $requestUrl;

  public $cw_host;
  public $cw_release;
  public $cw_api_version;
  public $cw_COID;
  public $cw_api_key;
  public $cw_api_secret;

  public function __construct() {

  }

  /**
   * Construct the connectwise api request url.
   *
   * @return this.
   */
  private function constructRequestUrl() {
    $this->requestUrl = 'https://' . $this->cw_host . '/' . $this->cw_release . '/apis/' . $this->cw_api_version . '/';
    return $this;
  }

  /**
   * Make the call to the connectwise api.
   *
   * @return object
   */
  public function makeCall($action = 'GET', $endpoint, $data = []) {
    $url = $this->constructRequestUrl()->requestUrl;
    $headers = $this->buildHeaders($action, $data);
    $client = new \GuzzleHttp\Client(['base_uri' => $url]);
    // dd($client);
    try {
      $res = $client->request($action, $endpoint, $headers);
    } catch (\GuzzleHttp\Exception\ClientException $e) {
      $response = $e->getResponse();
      return $response->getBody();
    }
    return json_decode($res->getBody());
  }

  /**
   * Make a get request to the connectwise api.
   *
   * @return object
   */
  public function get($endpoint, $conditions = []) {
    return $this->makeCall('GET', $endpoint, $conditions);
  }

  /**
   * Build request headers.
   *
   * @return array
   */
  private function buildHeaders($action, $data) {
    $headers = array();
    $this->buildHeadersAuth($headers);
    if (!empty($data)) {
      $this->buildHeadersData($headers, $action, $data);
    }
    return $headers;
  }

  /**
   * Build the query to send with the request.
   *
   * @return object
   */
  private function buildHeadersAuth(&$headers) {
    $user = $this->cw_COID . '+' . $this->cw_api_key;
    $pass = $this->cw_api_secret;
    $headers['auth'] = [$user, $pass];
  }

  /**
   * Build the query to send with the request.
   *
   * @return object
   */
  private function buildHeadersData(&$headers, $action, $data) {
    switch ($action) {
      case 'GET':
        $conditions = implode(' and ', $data);
        $headers['query'] = ['conditions' => $conditions];
      break;
    }
  }

  /**
   * Bootstrap any application services.
   *
   * @return void
   */
  public function boot()
  {

  }

  /**
   * Register any application services.
   *
   * @return void
   */
  public function register()
  {

  }
}

?>
