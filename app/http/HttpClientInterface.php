<?php 
declare(strict_types = 1);

namespace App\http;

interface HttpClientInterface {
  public function get(string $url);
  public function post(string $url, string $data);
  public function setHeaders(array $h);
  public function execute();
}