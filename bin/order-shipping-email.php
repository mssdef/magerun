<?php

/**
 * CLI run: php bin/order-shipping-email.php
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

$shipmentCollection = $order->getShipmentsCollection();
foreach ($shipmentCollection as $shipment) {
        $shipmentSender = $obj->create(\Magento\Sales\Model\Order\Email\Sender\ShipmentSender::class);
        $shipmentSender->send($shipment);
        echo "Shipment email sent successfully for shipment ID: " . $shipment->getId() . "\n";
}
