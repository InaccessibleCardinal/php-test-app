<?php
declare(strict_types = 1);

namespace App\controller;

use Karriere\JsonDecoder\JsonDecoder;
use App\http\IncomingRequest;
use App\http\ServerResponse;
use App\service\DbUsersService;
use App\dao\User;

class LoginController {
  private DbUsersService $dbUsersService;
  /**
   * @description
   */
  public function __construct(DbUsersService $dbUsersService) {
    $this->dbUsersService = $dbUsersService;
  }

  public function handleGetLogin(IncomingRequest $req, ServerResponse $res) {
    $res
      ->setStatus(200)
      ->setHeaders(['Content-Type' => 'text/html'])
      ->sendText(file_get_contents(__DIR__ .'/../views/login.html'));
  }

  public function handlePostLogin(IncomingRequest $req, ServerResponse $res) {
    $decoder = new JsonDecoder();
    $userLogin = $decoder->decode($req->body, \stdClass::class);
    $userResponse = $this->dbUsersService->getUser($userLogin->email, $userLogin->password);
    if ($userResponse['success']) {
      $res
        ->setStatus(200)
        ->setHeaders(['Content-Type' => 'application/json'])
        ->sendJson(['message' => 'successful login']);
        return;
    }
    $res
      ->setStatus(500)
      ->setHeaders(['Content-Type' => 'application/json'])
      ->sendJson($userResponse);
  }
}