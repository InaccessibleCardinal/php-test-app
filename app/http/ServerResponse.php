<?php declare(strict_types = 1);

namespace App\http;

class ServerResponse {
  const DEFAULT_COOKIE_TIME = 86400;
  const DEFAULT_COOKIE_DIR = '/';

  public function setStatus(int $code) {
    http_response_code($code);
    return $this;
  }

  public function setHeaders(array $headers) {
    foreach($headers as $headerName => $headerValue) {
      header($headerName . ':' . $headerValue);
      return $this;
    }
    return $this;
  }

  public function setCookies(
    array $cookies, 
    ?int $time = self::DEFAULT_COOKIE_TIME,
    ?string $dir = self::DEFAULT_COOKIE_DIR
  ) {
    foreach($cookies as $cookieName => $cookieValue) {
      setcookie($cookieName, $cookieValue, time() + $time, $dir);
      return $this;
    }
  }

  public function sendJson($body) {
    echo json_encode($body, JSON_PRETTY_PRINT);
  }

  public function sendText(string $body) {
    echo $body;
  }
}