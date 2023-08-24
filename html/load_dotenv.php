<?php
require_once('vendor/autoload.php');
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
$dotenv->required(['USER_NAME', 'PASSWORD', 'DB_NAME', 'HOST_NAME']);
