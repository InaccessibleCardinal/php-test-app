<?php declare(strict_types = 1);

namespace App\controller;

use App\http\IncomingRequest;
use App\http\ServerResponse;

class UiController {

  const HTML = 'text/html';

  public static function handleHome(IncomingRequest $req, ServerResponse $res) {
    $res
      ->setStatus(200)
      ->setHeaders(['Content-Type' => self::HTML])
      ->sendText(file_get_contents(__DIR__ .'/../views/index.html'));
  }

  public static function handleLogin(IncomingRequest $req,  ServerResponse $res) {
    $res  
      ->setStatus(200)
      ->setHeaders(['Content-Type' => self::HTML])
      ->sendText(file_get_contents(__DIR__ .'/../views/login.html'));
  }

  public static function handleSignup(IncomingRequest $req,  ServerResponse $res) {
    $res  
      ->setStatus(200)
      ->setHeaders(['Content-Type' => self::HTML])
      ->sendText(file_get_contents(__DIR__ .'/../views/signup.html'));
  }

  public static function handleSignupSuccess(IncomingRequest $req,  ServerResponse $res) {
    $res  
      ->setStatus(200)
      ->setHeaders(['Content-Type' => self::HTML])
      ->sendText(file_get_contents(__DIR__ .'/../views/signup-success.html'));
  }

  public static function handleNotFound(IncomingRequest $req,  ServerResponse $res) {
    $res  
      ->setStatus(200)
      ->setHeaders(['Content-Type' => self::HTML])
      ->sendText(file_get_contents(__DIR__ .'/../views/notfound.html'));
  }
}