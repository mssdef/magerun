<?php

/**
 * CLI run: php bin/magerun.php "YourVendor\YourModule\Stock\Import"
 * CLI run: php bin/magerun.php "YourVendor\YourModule\VirtualType\Product\Export" downloadStockFeed
**/
use Magento\Framework\App\Bootstrap;
use Magento\Framework\App\State;

require __DIR__ . '/../app/bootstrap.php';

$bootstrap = Bootstrap::create(BP, $_SERVER);
$obj = $bootstrap->getObjectManager();

// Set the area code
// AREA_FRONTEND
$state = $obj->get(State::class);
$state->setAreaCode('crontab'); // Replace 'frontend' with the desired area code


if (!isset($argv[1])) {
    die('Please add the class of the cron job you want to execute enclosed IN DOUBLE QUOTES as a parameter.' . PHP_EOL);
} else {
    define('CRONJOBCLASS', $argv[1]);
}

$cron = $obj->create(CRONJOBCLASS);
var_dump(get_class($cron));

$cron->{(isset($argv[2]) ? $argv[2] : 'execute')}();
