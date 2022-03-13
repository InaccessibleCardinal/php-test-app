<?php 
declare(strict_types = 1);

namespace App\service;

use App\http\CurlWrapper;

class RemoteUsersService {
  const PATH = '/users';
  private CurlWrapper $client;
  private string $url;

  public function __construct(CurlWrapper $client) {
    $this->client = $client;
    $this->url = getenv('REMOTE_URI') . self::PATH;
  }

  public function get() {
    try {
      $response = $this->client 
        ->get($this->url)
        ->setHeaders(['Authorization: fake-auth'])
        ->execute();
      if (!$response['data']) {
        return ['success' => false, 'error' => new \Exception('swing and miss')];
      }
      return ['success' => true, 'users' => $response['data']];
    } catch (\Exception $ex) {
      return ['success' => false, 'error' => $ex];
    }
  }

  public function post(string $data) {
    try {
      $response = $this->client 
        ->post($this->url, $data)
        ->setHeaders(['Authorization: fake-auth'])
        ->execute();
      if (!$response['data']) {
        return ['success' => false, 'error' => new \Exception('swing and miss')];
      }
      return ['success' => true, 'data' => $response['data']];
    } catch (\Exception $ex) {
      return ['success' => false, 'error' => $ex];
    }
  }

}