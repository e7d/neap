<?php
$appConfig = include 'application.config.php';
$appConfig['module_listener_options']['config_glob_paths'][] = 'config/phpunit/phpunit.conf.php';
return $appConfig;
