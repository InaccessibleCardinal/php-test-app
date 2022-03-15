<?php
declare(strict_types = 1);

namespace App\service;

use App\db\RepositoryInterface;

class DbUsersService {
  private RepositoryInterface $repository;

  public function __construct(RepositoryInterface $repository) {
    $this->repository = $repository;
  }

  public function getUsers() {
    return $this->repository->selectAll();
  }

  public function getUser(string $email, string $password) {
    return $this->repository->selectOne($email, $password);
  }

  public function addUser(\App\dao\User $user) {
    return $this->repository->insert($user); 
  }
}