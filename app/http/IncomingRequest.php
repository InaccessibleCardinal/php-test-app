<?php declare(strict_types = 1);

namespace App\http;

use App\service\InputService;

class IncomingRequest {
  public string $method;
  public string $path;
  public $body;
  public array $headers;

  public function __construct(array $server, InputService $inputService) {
    foreach($server as $key => $value) {
      if ($key === 'REQUEST_METHOD') {
        $this->method = $value;
      }
      if ($key === 'REQUEST_URI') {
        $this->path = $value;
      }
      if (str_starts_with($key, 'HTTP')) {
        $this->headers[$key] = $value;
      }
    }
    $this->body = $inputService->getInput();
  }
}