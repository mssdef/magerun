<?php

/**
 * CLI run: php bin/get-customer.php
 **/
use Magento\Framework\App\Bootstrap;
use Magento\Customer\Model\EmailNotificationInterface;

require __DIR__ . '/../app/bootstrap.php';

$bootstrap = Bootstrap::create(BP, $_SERVER);
$obj = $bootstrap->getObjectManager();

$customerRepository = $obj->get(\Magento\Customer\Api\CustomerRepositoryInterface::class);
$emailNotification = $obj->get(EmailNotificationInterface::class);

// Set the area code
$obj->get(\Magento\Framework\App\State::class)->setAreaCode('frontend');

$storeId = 3;
$customerId = 1382;
$customer = $customerRepository->getById($customerId);

$emailNotification->newAccount(
    $customer,
    EmailNotificationInterface::NEW_ACCOUNT_EMAIL_REGISTERED,
    '',
    null,
    $storeId
);
