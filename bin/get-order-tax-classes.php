<?php

/**
 * CLI run: php bin/get-order-tax-classes.php
**/
use Magento\Framework\App\Bootstrap;

require __DIR__ . '/../app/bootstrap.php';



$bootstrap = Bootstrap::create(BP, $_SERVER);
$obj = $bootstrap->getObjectManager();

//$orderId = 87;
$orderId = 88;
$orderRepository = $obj->create(Magento\Sales\Api\OrderRepositoryInterface::class);


/**
 * @var $order Magento\Sales\Model\Order
 */
$order = $orderRepository->get($orderId);

/**
 * @var $tax Magento\Tax\Model\Sales\Total\Quote\Tax
 */
$tax = $obj->create(\Magento\Tax\Model\Sales\Total\Quote\Tax::class);


/**
 * @var $item Magento\Sales\Model\Order\Item
 */
$item = null;
$appliedTaxRules = [];

/**
 * @var $taxItem Magento\Sales\Model\ResourceModel\Order\Tax\Item
 */
$taxItem = $obj->create(\Magento\Sales\Model\ResourceModel\Order\Tax\Item::class);
$appliedTaxRules = $taxItem->getTaxItemsByOrderId($orderId);

var_dump($appliedTaxRules);

