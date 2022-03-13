<?php declare(strict_types = 1);

namespace App\di\tests;

use PHPUnit\Framework\TestCase;
use App\di\Container;

class MockDep1 {
  public function t1() {
    return 'MockDep1 t1 method working';
  }
}

class MockDep2 {
  public function t2(array $arg) {
    return 'MockDep2 t2 method working: '. json_encode($arg);
  }
}

class MockDep3 {
  private MockDep1 $mock1;
  public function __construct(MockDep1 $m1) {
    $this->mock1 = $m1;
  }
  public function t3(array $arg) {
    return 'MockDep3 t3 method working: '. json_encode($arg);
  }
  public function t4() {
    return $this->mock1->t1();
  }
}

class TstClass1 {
  private MockDep1 $mock1;
  private MockDep2 $mock2;
  public function __construct(MockDep1 $m1, MockDep2 $m2) {
    $this->mock1 = $m1;
    $this->mock2 = $m2;
  }
  public function useDep1() {
    return $this->mock1->t1();
  }
  public function useDep2(array $arg) {
    return $this->mock2->t2($arg);
  }
}

class TstClass2 {
  private MockDep2 $mock2;
  private MockDep3 $mock3;
  public function __construct(MockDep2 $m2, MockDep3 $m3) {
    $this->mock2 = $m2;
    $this->mock3 = $m3;
  }
  
  public function useDep2(array $arg) {
    return $this->mock2->t2($arg);
  }
  public function useDep3() {
    return $this->mock3->t4();
  }
}

class ContainerTest extends TestCase {

  public function testDoesAutowire() {
    $config = [
      TstClass1::class => [
        'class' => TstClass1::class
      ]
    ];

    $container = new Container($config);
    $tst = $container->getInstance(TstClass1::class);
    $output1 =  $tst->useDep1();
    $output2 =  $tst->useDep2(['some' => 'json']);
    $this->assertEquals('MockDep1 t1 method working', $output1);
    $this->assertEquals('MockDep2 t2 method working: '. json_encode(['some' => 'json']), $output2);
  }

  public function testDoesAutowireTransitively() {
    $config = [
      MockDep3::class => [
        'class' => MockDep3::class
      ],
      TstClass1::class => [
        'class' => TstClass1::class
      ],
      TstClass2::class => [
        'class' => TstClass2::class
      ]
    ];
    $container = new Container($config);
    $tst2 = $container->getInstance(TstClass2::class);
    $output1 = $tst2->useDep3();
    $this->assertEquals('MockDep1 t1 method working', $output1);
    $output2 = $tst2->useDep2(['problems' => 99]);
    $this->assertEquals('MockDep2 t2 method working: '. json_encode(['problems' => 99]), $output2);
    // now try other class
    $tst1 = $container->getInstance(TstClass1::class);
    $output3 = $tst1->useDep1();
    $this->assertEquals('MockDep1 t1 method working', $output3);
  }

  public function testThatContainerThrowsOnUnknown() {
    $config = [
      TstClass2::class => ['class' => TstClass2::class]
    ];
    $container = new Container($config);
    $this->expectException(\Exception::class);
    $container->getInstance(TstClass1::class);
  }
}