<?php

/*
 * bootstrapping the test suite with composer
 */

if (!$loader = @include __DIR__ . '/../vendor/autoload.php') {
    die('You must set up the project dependencies, run the following commands:' . PHP_EOL .
            'curl -s http://getcomposer.org/installer | php' . PHP_EOL .
            'php composer.phar install' . PHP_EOL);
}

$loader->add('tests\\Yuurei\\', dirname(__DIR__));
$loader->add('tests\\Alkahest\\', dirname(__DIR__) . '/vendor/trismegiste/alkahest/');
