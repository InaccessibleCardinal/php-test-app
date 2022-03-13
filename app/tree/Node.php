<?php 

declare(strict_types = 1);

namespace App\tree;

class Node {
  public int $data;
  public ?Node $left;
  public ?Node $right;
  public function __construct(int $data) {
    $this->data = $data;
    $this->left = null;
    $this->right = null;
  }

  public function setLeft(Node $node) {
    $this->left = $node;
  }

  public function setRight(Node $node) {
    $this->right = $node;
  }
}