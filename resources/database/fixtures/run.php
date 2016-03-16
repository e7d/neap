<?php
ini_set('memory_limit', '256M');

require_once(__DIR__ . '/UUID.class.php');
require_once(__DIR__ . '/DateConverter.class.php');
require_once(__DIR__ . '/Generator.class.php');

$output = __DIR__ . '/../fixtures.sql';
$fixturesGenerator = new Fixtures\Generator($output);
$fixturesGenerator->generate();
