<?php 

declare(strict_types = 1);

namespace App\service\tests;

use PHPUnit\Framework\TestCase;
use App\service\DbUsersService;
use App\db\UsersRepository;
use App\dao\User;

class DbUsersServiceTest extends TestCase {
  public function testDoesInvokeRepoSelectAll() {
    $mockRepo = $this->createStub(UsersRepository::class);
    $mockRepo->method('selectAll')->willReturn([['first_name' => 'ken'], ['first_name' => 'sam']]);
    $service = new DbUsersService($mockRepo);
    $testReturn = $service->getUsers();
    $this->assertEquals('ken', $testReturn[0]['first_name']);
    $this->assertEquals('sam', $testReturn[1]['first_name']);
  }

  public function testDoesInvokeRepoSelectOne() {
    $mockRepo = $this->createStub(UsersRepository::class);
    $mockRepo->method('selectOne')->willReturn([['first_name' => 'ken']]);
    $service = new DbUsersService($mockRepo);
    $testReturn = $service->getUser('k@l.com', 'somepw');
    $this->assertEquals('ken', $testReturn[0]['first_name']);
  }

  public function testDoesInvokeRepoInsert() {
    $mockRepo = $this->createStub(UsersRepository::class);
    $mockRepo->method('insert')->willReturn(['success' => true, 'id' => 1]);
    $service = new DbUsersService($mockRepo);
    $user = new User();
    $user->setFirstName('test-fn');
    $user->setlastName('test-ln');
    $user->setEmail('test-em');
    $user->setPassword('test-pw');
    $testReturn = $service->addUser($user);
    $this->assertEquals(['success' => true, 'id' => 1], $testReturn);
  }
}