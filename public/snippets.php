<?php

function buildTable($usersArray, $headerValues) {
  $table = '<table><tr>';
  foreach($headerValues as $key) {
    $table = $table . '<th>'. $key . '</th>';
  }
  $table = $table . '</tr>';

  foreach($usersArray as $user) {
    $table = $table . '<tr>';
    foreach($headerValues as $header) {
      $table = $table . '<td>' . $user[$header] . '</td>';
    }
    $table = $table . '</tr>';
  }
  return $table;
}

function buildForm() {
  $form = '<form method="POST" action="test">' .
    '<h3>Add a user</h3>' . 
    '<label>Name <input name="name" /></label></br>' . 
    '<label>Username <input name="username" /></label></br>' .
    '<label>Email <input name="email" /></label></br>' .
    '<label>Website <input name="website" /></label></br>' .
    '<button>Submit</button>' .
    '</form>';
    return $form;
}
