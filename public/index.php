<?php

$context = PHP_SAPI === 'cli-server' ? 'html-app' : 'prod-html-app';
require dirname(__DIR__) . '/bootstrap/bootstrap.php';
