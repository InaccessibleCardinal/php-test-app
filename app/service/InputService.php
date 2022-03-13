<?php declare(strict_types = 1);


namespace App\service;

class InputService {

  public function getInput() {
    return  file_get_contents('php://input');
  }
}