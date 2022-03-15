<?php 
declare(strict_types = 1);

namespace App\http;

use App\http\HttpClientInterface;

class CurlWrapper implements HttpClientInterface {
  private \CurlHandle $handle;
  private array $responseHeaders = [];

  /**
   * #description
   */
  public function __construct() {}

  private function handleResponseHeaders() {
    \curl_setopt($this->handle, CURLOPT_HEADERFUNCTION,
    function($curl, $header) {
      $length = strlen($header);
      $header = explode(':', $header, 2);
      if (count($header) < 2) {
        return $length;
      }
      $this->responseHeaders[trim($header[0])] = trim($header[1]);

      return $length;
    });
  }
  
  private function tryParseJson($data) {
    try {
        return \json_decode($data, true);
    } catch (Exception $ex) {
        return $data;
    }
  }

  public function get(string $url) {
    $this->handle = curl_init();
    \curl_setopt($this->handle, CURLOPT_URL, $url);
    \curl_setopt($this->handle, CURLOPT_RETURNTRANSFER, true);
    return $this;
  }

  public function post(string $url, string $data) {
    $this->handle = curl_init();
    \curl_setopt($this->handle, CURLOPT_URL, $url);
    \curl_setopt($this->handle, CURLOPT_POST, true);
    \curl_setopt($this->handle, CURLOPT_POSTFIELDS, $data);
    \curl_setopt($this->handle, CURLOPT_RETURNTRANSFER, true);
    return $this;
  }

  public function setHeaders(array $headers) {
    \curl_setopt($this->handle, CURLOPT_HTTPHEADER, $headers);
    return $this;
  }
  
  public function execute() {
    $this->handleResponseHeaders();
    $response = \curl_exec($this->handle);
    \curl_close($this->handle);
    return [
        'headers' => $this->responseHeaders, 
        'data' => $this->tryParseJson($response)
    ];
  }
}