<?php
declare(strict_types = 1);

namespace App\controller;

use App\http\IncomingRequest;
use App\http\ServerResponse;
use App\service\RemoteUsersService;

class RemoteUsersController {
  const JSON = 'application/json';
  private RemoteUsersService $service;

  public function __construct(RemoteUsersService $service) {
    $this->service = $service;
  }

  public function handleGet(IncomingRequest $req, ServerResponse $res) {
    $response = $this->service->get();
    if ($response['success']) {
      $res
        ->setStatus(200)
        ->setHeaders(['Content-Type' => self::JSON])
        ->sendJson($response['users']);
        return;
    }
    $res
      ->setStatus(500)
      ->setHeaders(['Content-Type' => self::JSON])
      ->sendJson($response);
  }

  public function handlePost(IncomingRequest $req, ServerResponse $res) {
    $response = $this->service->post($req->body);
    if ($response['success']) {
      $res
        ->setStatus(201)
        ->setHeaders(['Content-Type' => self::JSON])
        ->sendJson($response['data']);
        return;
    }
    $res
      ->setStatus(500)
      ->setHeaders(['Content-Type' => self::JSON])
      ->sendJson($response);
  }
}