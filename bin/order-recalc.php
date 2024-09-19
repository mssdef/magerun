<?php

/**
 * CLI run: php bin/order-recalc.php
 **/
use Magento\Framework\App\Bootstrap;

require __DIR__ . '/../app/bootstrap.php';

$bootstrap = Bootstrap::create(BP, $_SERVER);
$obj = $bootstrap->getObjectManager();

// Set the area code
$obj->get(\Magento\Framework\App\State::class)->setAreaCode('adminhtml');
$orderRepository = $obj->create(Magento\Sales\Api\OrderRepositoryInterface::class);

/**
 * @var $order Magento\Sales\Model\Order
 */


//$orderId = 87;
$orderId = 52;

$order = $orderRepository->get($orderId);
$order->setTotalsCollectedFlag(false);
//$order->setTotalRefunded(59.89);
$orderRepository->save($order);

foreach ($order->getAllItems() as $item) {
    var_dump('item_getQtyToShip', $item->getId(), $item->getQtyToShip(), $item->getQtyRefunded());
    $item->setQtyRefunded(1);
    $item->save();
}

var_dump($order->getTotalRefunded(), $order->canShip());
