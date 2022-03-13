<?php declare(strict_types = 1);

namespace App\http;

class HttpUtils {
  public array $headers = [];
  
  public function setHeaders(array $headers) {
    foreach($headers as $headerName => $headerValue) {
      $actualHeader = $headerName . ':' . $headerValue;
      array_push($this->headers, $actualHeader);
      header($actualHeader);
    }
  }

  public function clearHeaders() {
    $this->headers = [];
  }
}