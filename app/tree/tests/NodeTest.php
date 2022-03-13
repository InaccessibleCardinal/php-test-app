<?php declare(strict_types = 1);

namespace App\tree\tests;

use PHPUnit\Framework\TestCase;
use App\tree\Node;

class NodeTest extends TestCase {
  public function testCanCreateNode() {
    $data = 99;
    $testNode = new Node($data);
    $this->assertEquals(99, $testNode->data);
    $this->assertNull($testNode->left);
    $this->assertNull($testNode->right);
  }

  public function testCanAddLeftAndRight() {
    $data = 99;
    $testNode = new Node($data);
    $this->assertEquals(99, $testNode->data);
    $left = new Node(98);
    $right = new Node(100);
    $testNode->setLeft($left);
    $testNode->setRight($right);
    $this->assertEquals(98, $testNode->left->data);
    $this->assertEquals(100, $testNode->right->data);
    $this->assertNull($left->left);
    $this->assertNull($left->right);
    $this->assertNull($right->left);
    $this->assertNull($right->right);
  }
}