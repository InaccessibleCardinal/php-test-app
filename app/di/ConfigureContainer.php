<?php declare(strict_types = 1);

namespace App\di;

use App\di\Container;
use App\controller\SignupPostController;
use App\service\SignupService;
use App\controller\LoginController;
use App\service\DbUsersService;
use App\db\RepositoryInterface;
use App\db\UsersRepository;
use App\db\Connector;
use App\controller\RemoteUsersController;
use App\service\RemoteUsersService;
use App\http\HttpClientInterface;
use App\http\CurlWrapper;

class ConfigureContainer {
  public static function create() {
    $config = [
      SignupService::class => ['class' => SignupService::class],
      SignupPostController::class => ['class' => SignupPostController::class],
      LoginController::class => ['class' => LoginController::class],
      DbUsersService::class => ['class' => DbUsersService::class],
      RepositoryInterface::class => ['class' => UsersRepository::class],
      Connector::class => ['class' => Connector::class],
      RemoteUsersController::class => ['class' => RemoteUsersController::class],
      RemoteUsersService::class => ['class' => RemoteUsersService::class],
      HttpClientInterface::class => ['class' => CurlWrapper::class],
    ];
    
    return new Container($config);
  }
}