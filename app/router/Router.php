<?php declare(strict_types = 1);

namespace App\router;

use App\http\IncomingRequest;
use App\http\ServerResponse;

class Router {

  private array $handlers;

  public function __construct() {
    $this->handlers = [];
  }

  public function get(string $path, callable $handlerFunc) {
    $this->handlers['GET' . $path] = $handlerFunc;
  }

  public function post(string $path, callable $handlerFunc) {
    $this->handlers['POST' . $path] = $handlerFunc;
  }

  public function execute(IncomingRequest $req, ServerResponse $res) {
    $method = $req->method;
    $path = $req->path;
    $handlerExists = array_key_exists($method . $path, $this->handlers);

    if ($handlerExists) {
      $func = $this->handlers[$method . $path];
      call_user_func($func, $req, $res);
    } else {
      echo file_get_contents(__DIR__.'/../views/notfound.html');
    }
  }
}
