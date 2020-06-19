<?php

include_once 'vendor/autoload.php';

use MorningCoffee\Coffee;

$my_coffee = new Coffee();
// FIXME: Should be coming from argv
$my_template_file = $argv[1];
// Define a key/value object as template context
$context = [
    'name' => 'Kitty',
    'greeting' => 'Hello'
];

echo $my_coffee->render($my_template_file, $context);
