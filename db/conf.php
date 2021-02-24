<?php
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__. '/../');
$dotenv->load();

$dbInfo	= [
			"url"=> $_ENV['DATABASE_URL']
];

define("CONFIG_DATABASE_MYSQL", $dbInfo);