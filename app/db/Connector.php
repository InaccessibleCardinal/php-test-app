<?php
declare(strict_types = 1);

namespace App\db;


class Connector {
  private ?\PDO $pdo;

  public function __construct() {
    try {
      $dbHost = \getenv('DB_HOST');
      $dbUser = \getenv('DB_USERNAME');
      $dbPassword = \getenv('DB_PASSWORD');
      $db = \getenv('DB_DATABASE');
      $dsn = "mysql:host=$dbHost;dbname=$db;charset=UTF8";
      $pdo = new \PDO($dsn, $dbUser, $dbPassword, [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]);
      if ($pdo) {
        $this->pdo = $pdo;
      }
    } catch (PDOException $ex) {
      echo $ex->getMessage();
    }
  }

  public function getConnection() {
    return $this->pdo;
  }

}