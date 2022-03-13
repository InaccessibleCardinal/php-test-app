<?php declare(strict_types = 1);

namespace App\controller;

use App\http\IncomingRequest;
use App\http\ServerResponse;
use App\service\SignupService;

class SignupPostController {

  private SignupService $service;

  public function __construct(SignupService $service) {
    $this->service = $service;
  }

  public function handleSignup(IncomingRequest $req, ServerResponse $res) {
    $body = $req->body;
    $userArray = [];
    parse_str($body, $userArray);
    $result = $this->service->submitNewUser($userArray);
    if ($result['success']) {
      $res
        ->setStatus(200)
        ->setHeaders(['Content-Type' => 'text/html'])
        ->sendText(\file_get_contents(__DIR__ . '/../views/signup-success.html'));
      return;
    }
    header('Location: http://localhost:3000/error');
  }

  public function handleIntrospect(IncomingRequest $req, ServerResponse $res) {
    $result = $this->service->getUserFile();
    $res
      ->setStatus(200)
      ->setHeaders(['Content-Type' => 'application/json'])
      ->sendJson($result);
  }
}