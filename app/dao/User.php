<?php declare(strict_types = 1);

namespace App\dao;

class User {
  public string $firstName;
  public string $lastName;
  public string $email;
  public string $password;

  public function serialize() {
    return json_encode($this);
  }

  public function setFirstName(string $fn) {
    $this->firstName = $fn;
  }
 
  public function setLastName(string $ln) {
    $this->lastName = $ln;
  }

  public function setEmail(string $e) {
    $this->email = $e;
  }

  public function setPassword(string $pw) {
    $this->password = $pw;
  }
}