<?php
declare(strict_types = 1);

namespace App\db;

use App\db\RepositoryInterface;

class UsersRepository implements RepositoryInterface {
  const TABLE = 'users';

  private \PDO $pdo;
  
  public function __construct(Connector $connector) {
    $this->pdo = $connector->getConnection();
  }

  public function selectAll() {
    try {
      $sql = 'SELECT * from '. self::TABLE;
      $statement = $this->pdo->query($sql);
      return $statement->fetchAll(\PDO::FETCH_ASSOC);
    } catch (Exception $ex) {
      echo $ex->getMessage();
    }
  }

  public function selectOne(string $email, string $postedPassword) {
    try {
      $sql = 'SELECT * from ' . self::TABLE . ' WHERE email=:email';
      $statement = $this->pdo->prepare($sql);
      $statement->execute([':email' => $email]);
      $user = $statement->fetch();
      if(!$user || !\password_verify($postedPassword, $user['password'])) {
        return ['success' => false, 'error' => new \Exception('user not found')];
      }
      return ['success' => true, 'user' => $user];
    } catch (\PDOException $ex) {
      return ['success' => false, 'error' => $ex];
    }
  }

  public function insert(\App\dao\User $user) {
    try {
      $sql = 'INSERT into ' . self::TABLE .'(first_name, last_name, email, password) ' . 
        'VALUES (:firstName, :lastName, :email, :password)';
      $statement = $this->pdo->prepare($sql);
      $statement->execute([
        ':firstName' => $user->firstName,
        ':lastName' => $user->lastName,
        ':email' => $user->email,
        ':password' => \password_hash($user->password, PASSWORD_DEFAULT)
      ]);
      return ['success' => true, 'id' => $this->pdo->lastInsertId()];
    } catch (\PDOException $ex) {
      return ['success' => false, 'error' => $ex];
    } 
  }
}