<?php declare(strict_types = 1);

namespace App\service;

use App\dao\User;

class SignupService {

  const USERS_JSON = '/fake-users/users.json';
  /**
   * @description
   */
  public function __construct() {}

  public function submitNewUser(array $userData) {
    try {
      $user = new User(
        $userData['firstName'], 
        $userData['lastName'], 
        $userData['email'], 
        password_hash($userData['password'], PASSWORD_DEFAULT)
      );
      $userArray = (array) $user;
      $usersArray = $this->getUserFile();
      $this->addUserToFile($userArray, $usersArray);
      return ['success' => true];
    } catch (Exception $ex) {
      return ['success' => false, 'error' => $ex];
    }
  }

  public function getUserFile() {
    $json = file_get_contents(__DIR__ . self::USERS_JSON);
    return json_decode($json, true);
  }

  private function addUserToFile(array $userArray, array $usersArray) {
    array_push($usersArray, $userArray);
    file_put_contents(__DIR__ . self::USERS_JSON, json_encode($usersArray));
  }

}