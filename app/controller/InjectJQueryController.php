<?php
declare(strict_types = 1);

namespace App\controller;

class InjectJQueryController {
  private static $script = '<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="crossorigin="anonymous"></script>';
  
  public static function inject() {
    $app = '<script>' . file_get_contents(__DIR__ . '/../../public/js/app.js') . '</script>';
    echo '<h1>jQuery example</h1><a href="/">Home</a>';
    echo self::$script;
    echo $app;
  }
}