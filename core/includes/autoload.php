<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use Symfony\Component\Dotenv\Dotenv;

$dotenv = new Dotenv();
$env = __DIR__.'/../../.env';
!file_exists($env) ?: $dotenv->load($env);