<?php declare(strict_types = 1);

namespace App\http\tests;

use PHPUnit\Framework\TestCase;
use App\http\IncomingRequest;
use App\service\InputService;

class IncomingRequestTest extends TestCase {

  const PATH = '/test-path';

  public function testGetsValuesFromSERVERGetReq() {
    $mockServerGlobal = [
      'REQUEST_METHOD' => 'GET',
      'REQUEST_URI' => self::PATH,
      'HTTP_ACCEPT' => '*'
    ];
    $mockInput = $this
      ->getMockBuilder(InputService::class)
      ->setMethods(['getInput'])
      ->getMock();
    $mockInput->expects($this->once())
      ->method('getInput')
      ->will($this->returnValue(null));
    $req = new IncomingRequest($mockServerGlobal, $mockInput);
    $this->assertSame('GET', $req->method);
    $this->assertSame(self::PATH, $req->path);
    $this->assertSame('*', $req->headers['HTTP_ACCEPT']);
    $this->assertSame(null, $req->body);
  }

  public function testGetsValuesFromSERVERPostReq() {
    $mockServerGlobal = [
      'REQUEST_METHOD' => 'POST',
      'REQUEST_URI' => self::PATH,
      'HTTP_ACCEPT' => '*'
    ];
    $mockBody = '{"somekey": "somevalue"}';
    $mockInput = $this
      ->getMockBuilder(InputService::class)
      ->setMethods(['getInput'])
      ->getMock();
    $mockInput->expects($this->once())
      ->method('getInput')
      ->will($this->returnValue($mockBody));
    $req = new IncomingRequest($mockServerGlobal, $mockInput);
    $this->assertSame('POST', $req->method);
    $this->assertSame(self::PATH, $req->path);
    $this->assertSame('*', $req->headers['HTTP_ACCEPT']);
    $this->assertSame($mockBody, $req->body);
  }
}