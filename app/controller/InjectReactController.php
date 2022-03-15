<?php
declare(strict_types = 1);

namespace App\controller;

class InjectReactController {
  private static $reactScript = '<script crossorigin src="https://unpkg.com/react@17/umd/react.development.js"></script>';
  private static $reacDOMScript = '<script crossorigin src="https://unpkg.com/react-dom@17/umd/react-dom.development.js"></script>';

  public static function inject() {
    echo self::$reactScript;
    echo self::$reacDOMScript;
    echo '<div><h1>Some non react markup</h1><a style="display:block;padding-bottom: 20px;" href="/">Home</a></div><div id="root"></div>';
    $reactApp = file_get_contents(__DIR__ . '/../../public/js/reactSilliness.js');
    echo '<script>' . $reactApp . '</script><p>some other server rendered content...</p>';
  }
}