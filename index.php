<?php

include_once 'vendor/autoload.php';

use MorningCoffee\Coffee;

$my_coffee = new Coffee();

$my_template_file = "./test_file.html";
// Define a key/value object as template context
$context = [
    'name' => 'Kitty',
    'greeting' => 'Hello'
];

echo $my_coffee->render($my_template_file, $context);
