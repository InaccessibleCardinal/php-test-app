<?php 
declare(strict_types = 1);

namespace App\tree\tests;

use PHPUnit\Framework\TestCase;
use App\tree\Node;
use App\tree\BinarySearchTree;

class BinarySearchTreeTest extends TestCase {
  public function testCanInsertNodesInTree() {
    $tree = new BinarySearchTree();
    $this->assertEquals(null, $tree->root);
    $tree->insert(99);
    $tree->insert(101);
    $tree->insert(42);
    $this->assertEquals(99, $tree->root->data);
    $this->assertEquals(42, $tree->root->left->data);
    $this->assertEquals(101, $tree->root->right->data);
  }

  public function testCanSearchForValues() {
    $tree = new BinarySearchTree();
    $tree->insert(99);
    $tree->insert(42);
    $tree->insert(101);
    $tree->insert(55);
    $tree->insert(77);
    $tree->insert(22);
    $tree->insert(38);

    $result99 = $tree->search(99);
    $this->assertEquals(true, $result99['found']);
    $result101 = $tree->search(101);
    $this->assertEquals(true, $result101['found']);
    $result22 = $tree->search(22);
    $this->assertEquals(true, $result22['found']);
    $this->assertEquals('object', gettype($result22['node']));
  }

  public function testReturnsFalseOnUnsuccessfulSearch() {
    $tree = new BinarySearchTree();
    $tree->insert(99);
    $tree->insert(42);
    $result = $tree->search(999);
    $this->assertEquals(false, $result['found']);
  }
}