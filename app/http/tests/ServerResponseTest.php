<?php declare(strict_types = 1);

namespace App\http\tests;

use PHPUnit\Framework\TestCase;
use App\http\ServerResponse;
use App\http\HttpUtils;

class ServerResponseTest extends TestCase {
  public function testServerResponse200() {
    $res = new ServerResponse();
    $arr = ['message' => 'good test'];
    $res->setStatus(200)->sendJson($arr);
    $this->assertEquals(200, http_response_code());
    $this->expectOutputString(\json_encode($arr, JSON_PRETTY_PRINT));
  }

  public function testServerResponse200Text() {
    $res = new ServerResponse();
    $body = '<p>some markup</p>';
    $res->setStatus(201)->sendText($body);
    $this->assertEquals(201, http_response_code());
    $this->expectOutputString($body);
  }
}