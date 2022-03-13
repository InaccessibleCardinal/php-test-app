<?php

declare(strict_types = 1);

namespace App\tree;

use App\tree\Node;

class BinarySearchTree {
  public ?Node $root;

  public function __construct() {
    $this->root = null;
  }

  public function insert(int $data) {
    $newNode = new Node($data);
    if ($this->root === null) {
        return $this->root = $newNode;
    }
    $this->insertRecursive($newNode, $this->root);
  }

  private function insertRecursive(Node $newNode, Node $start = null) {
    if ($newNode->data === $start->data) {
      throw new Exception('data value already in tree');
    }
    if ($newNode->data < $start->data) {
        if ($start->left === null) {
            $start->setLeft($newNode);
        } else {
           $this->insertRecursive($newNode, $start->left); 
        }
    }
    if ($newNode->data > $start->data) {
        if ($start->right === null) {
            $start->setRight($newNode);
        } else {
            $this->insertRecursive($newNode, $start->right);            
        }
    }
  }

  public function search(int $searchData) {
    return $this->searchRecursive($searchData, $this->root);
  }

  private function searchRecursive(int $searchData, Node $start = null) {
    if (!$start) {
      return ['found' => false];
    }
    if ($searchData === $start->data) {
      return ['found' => true, 'node' => $start];
    }
    if ($searchData < $start->data) {
      return $this->searchRecursive($searchData, $start->left);
    }
    if ($searchData > $start->data) {
      return $this->searchRecursive($searchData, $start->right);
    }
  }
}