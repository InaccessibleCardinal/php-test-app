<?php 

declare(strict_types = 1);

namespace App\service\tests;

use PHPUnit\Framework\TestCase;
use App\service\RemoteUsersService;
use App\http\CurlWrapper;

class RemoteUsersServiceTest extends TestCase {
  public function testInvokesClientGet() {
    $mockCurl = $this->createStub(CurlWrapper::class);
    $mockCurl->method('get')->willReturn($mockCurl);
    $mockCurl->method('setHeaders')->willReturn($mockCurl);
    $mockResponse = ['headers' => [], 'data' => [['name' => 'testname']]];
    $mockCurl->method('execute')->willReturn($mockResponse);

    $service = new RemoteUsersService($mockCurl);
    $result = $service->get();
    $this->assertEquals($mockResponse['data'], $result['users']);
  }

  public function testInvokesClientGetBadResponse() {
    $mockCurl = $this->createStub(CurlWrapper::class);
    $mockCurl->method('get')->willReturn($mockCurl);
    $mockCurl->method('setHeaders')->willReturn($mockCurl);
    $mockResponse = ['headers' => [], 'data' => null];
    $mockCurl->method('execute')->willReturn($mockResponse);

    $service = new RemoteUsersService($mockCurl);
    $result = $service->get();
    $this->assertEquals(new \Exception('swing and miss'), $result['error']);
  }

  public function testInvokesClientGetHandlesException() {
    $mockCurl = $this->createStub(CurlWrapper::class);
    $mockCurl->method('get')->willReturn($mockCurl);
    $mockCurl->method('setHeaders')->willReturn($mockCurl);
    
    $mockCurl->method('execute')->willThrowException(new \Exception('badness'));

    $service = new RemoteUsersService($mockCurl);
    $result = $service->get();
    $this->assertEquals(new \Exception('badness'), $result['error']);
  }

  public function testInvokesClientPost() {
    $mockCurl = $this->createStub(CurlWrapper::class);
    $mockCurl->method('post')->willReturn($mockCurl);
    $mockCurl->method('setHeaders')->willReturn($mockCurl);
    $mockResponse = ['headers' => [], 'data' => ['message' => 'created']];
    $mockCurl->method('execute')->willReturn($mockResponse);

    $service = new RemoteUsersService($mockCurl);
    $result = $service->post('[]');
    $this->assertEquals($mockResponse['data'], $result['data']);
  }
}