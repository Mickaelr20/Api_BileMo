<?php

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__)
    ->exclude('var')
    ->exclude('node_modules');

$config = new PhpCsFixer\Config();
return $config->setRules([
    '@Symfony' => true,
    'full_opening_tag' => false,
])
    ->setIndent("\t")
    ->setLineEnding("\r\n")
    ->setFinder($finder);
