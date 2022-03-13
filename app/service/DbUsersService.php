<?php
declare(strict_types = 1);

namespace App\service;

use App\db\UsersRepository;

class DbUsersService {
  private UsersRepository $repository;

  public function __construct(UsersRepository $repository) {
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