<?php
declare(strict_types = 1);

namespace App\db;

use App\dao\User;

interface RepositoryInterface {
  public function selectAll();
  public function selectOne(string $a, string $b);
  public function insert(User $u);
}