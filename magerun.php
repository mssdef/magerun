<?php

/**
 * CLI run: php bin/magerun.php "YourVendor\YourModule\Stock\Import"
**/
use Magento\Framework\App\Bootstrap;
require __DIR__ . '/../app/bootstrap.php';

if (!isset($argv[1])) {
    die('Please add the class of the cron job you want to execute enclosed IN DOUBLE QUOTES as a parameter.' . PHP_EOL);
} else {
    define('CRONJOBCLASS', $argv[1]);
}

$bootstrap = Bootstrap::create(BP, $_SERVER);
$obj = $bootstrap->getObjectManager();

$cron = $obj->create(CRONJOBCLASS);

$cron->execute();
