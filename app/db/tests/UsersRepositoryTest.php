<?php 

declare(strict_types = 1);

namespace App\db\tests;

use PHPUnit\Framework\TestCase;
use App\db\UsersRepository;
use App\db\Connector;
use App\dao\User;

class UsersRepositoryTest extends TestCase {
  public function testDoesEnvokeFetchAll() {
    $mockConnector = $this->createStub(Connector::class);
    $mockStatement = $this->createStub(\PDOStatement::class);
    $mockPdo = $this->createStub(\PDO::class);

    $mockConnector->method('getConnection')->willReturn($mockPdo);
    $mockPdo->method('query')->willReturn($mockStatement);
    $mockStatement->method('fetchAll')->willReturn([['name' => 'mock']]);

    $repo = new UsersRepository($mockConnector);
    $result = $repo->selectAll();
    $this->assertEquals([['name' => 'mock']], $result);
  }

  public function testDoesInvokePrepareExecuteAndFetch() {
    $mockConnector = $this->createStub(Connector::class);
    $mockStatement = $this->createStub(\PDOStatement::class);
    $mockPdo = $this->createStub(\PDO::class);

    $mockConnector->method('getConnection')->willReturn($mockPdo);
    $mockPdo->method('prepare')->willReturn($mockStatement);

    $testUser = ['password' => \password_hash('mockpw', PASSWORD_DEFAULT)];
    $mockStatement->method('fetch')->willReturn($testUser);
    $repo = new UsersRepository($mockConnector);

    $result = $repo->selectOne('someemail', 'mockpw');
    $this->assertEquals(['success' => true, 'user' => $testUser], $result);
  }

  public function testDoesReturnSuccessFalse() {
    $mockConnector = $this->createStub(Connector::class);
    $mockStatement = $this->createStub(\PDOStatement::class);
    $mockPdo = $this->createStub(\PDO::class);

    $mockConnector->method('getConnection')->willReturn($mockPdo);
    $mockPdo->method('prepare')->willReturn($mockStatement);

    $testUser = ['password' => \password_hash('mockpw', PASSWORD_DEFAULT)];
    $mockStatement->method('fetch')->willReturn($testUser);
    $repo = new UsersRepository($mockConnector);

    $result = $repo->selectOne('someemail', 'mockp');
    $this->assertEquals(['success' => false, 'error' => new \Exception('user not found')], $result);
  }

  public function testDoesReturnSuccessFalseWhenExceptionThrown() {
    $mockConnector = $this->createStub(Connector::class);
    $mockStatement = $this->createStub(\PDOStatement::class);
    $mockPdo = $this->createStub(\PDO::class);

    $mockConnector->method('getConnection')->willReturn($mockPdo);
    $mockPdo->method('prepare')->willReturn($mockStatement);

    $mockStatement->method('fetch')->willThrowException(new \PDOException());
    $repo = new UsersRepository($mockConnector);

    $result = $repo->selectOne('someemail', 'mockp');
    $this->assertEquals(['success' => false, 'error' => new \PDOException()], $result);
  }

  public function testDoesInvokePrepareExecuteAndFetchForInsert() {
    $mockConnector = $this->createStub(Connector::class);
    $mockStatement = $this->createStub(\PDOStatement::class);
    $mockPdo = $this->createStub(\PDO::class);

    $mockConnector->method('getConnection')->willReturn($mockPdo);
    $mockPdo->method('prepare')->willReturn($mockStatement);
    $mockPdo->method('lastInsertId')->willReturn('testid');
    $mockStatement->method('execute')->willReturn([]);
    
    $testUser = new User();
    $testUser->setFirstName('testfn');
    $testUser->setLastName('testln');
    $testUser->setEmail('testemail');
    $testUser->setPassword('testpw');

    $repo = new UsersRepository($mockConnector);

    $result = $repo->insert($testUser);
    $this->assertEquals(['success' => true, 'id' => 'testid'], $result);
  }

  public function testDoesReturnSuccessFalseForInsert() {
    $mockConnector = $this->createStub(Connector::class);
    $mockStatement = $this->createStub(\PDOStatement::class);
    $mockPdo = $this->createStub(\PDO::class);

    $mockConnector->method('getConnection')->willReturn($mockPdo);
    $mockPdo->method('prepare')->willReturn($mockStatement);
    $mockPdo->method('lastInsertId')->willReturn('testid');
    $mockStatement->method('execute')->willThrowException(new \PDOException());
    
    $testUser = new User();
    $testUser->setFirstName('testfn');
    $testUser->setLastName('testln');
    $testUser->setEmail('testemail');
    $testUser->setPassword('testpw');

    $repo = new UsersRepository($mockConnector);

    $result = $repo->insert($testUser);
    $this->assertEquals(['success' => false, 'error' => new \PDOException()], $result);
  }
}