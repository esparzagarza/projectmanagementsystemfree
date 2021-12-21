<?php

define("DB_HOST", "localhost");

define("DB_NAME", "pm-system-free");

define("DB_USERNAME", "root");

define("DB_PASSWORD", "");

define("DB_ENCODE", "utf8");

define("PRO_NOMBRE", "Project Management System");

define("DB_DSN", "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME);

define(

	"DB_OPTIONS",

	[

		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,

		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,

		PDO::ATTR_EMULATE_PREPARES => false,

		PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"

	]

);
