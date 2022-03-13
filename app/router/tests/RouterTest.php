<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\router\Router;
use App\http\IncomingRequest;
use App\http\ServerResponse;

class RouterTest extends TestCase {

  const PATH1 = '/test-path';
  const PATH2 = '/test-path-2';
  const INVOKE = '__invoke';

  public function testGetMethod() {
    $mockRequest = $this->getMockBuilder(IncomingRequest::class)
      ->disableOriginalConstructor()
      ->getMock();
    $mockRequest->method = 'GET';
    $mockRequest->path = '/test-path';
    $mockResponse = $this->getMockBuilder(ServerResponse::class)
      ->getMock();
    $mockCallback = $this->getMockBuilder('NonExistentClass')
      ->setMethods([self::INVOKE])
      ->getMock();
    $mockCallback->expects($this->once())->method('__invoke');

    $router = new Router();
    $router->get(self::PATH1, $mockCallback);
    $router->execute($mockRequest, $mockResponse);
  }

  public function testPostMethod() {
    $mockRequest = $this->getMockBuilder(IncomingRequest::class)
      ->disableOriginalConstructor()
      ->getMock();
    $mockRequest->method = 'POST';
    $mockRequest->path = '/test-path-2';
    $mockResponse = $this->getMockBuilder(ServerResponse::class)->getMock();

    $mockCallback = $this->getMockBuilder('NonExistentClass')
      ->setMethods([self::INVOKE])
      ->getMock();
    $mockCallback->expects($this->once())->method(self::INVOKE);

    $router = new Router();
    $router->post(self::PATH2, $mockCallback);
    $router->execute($mockRequest, $mockResponse);
  }
}