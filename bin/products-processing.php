<?php
use Magento\Framework\App\Bootstrap;
require __DIR__ . '/../app/bootstrap.php';

$bootstrap = Bootstrap::create(BP, $_SERVER);

$objectManager = $bootstrap->getObjectManager();
$productCollectionFactory = $objectManager->create('Magento\Catalog\Model\ResourceModel\Product\CollectionFactory');
$productCollection = $productCollectionFactory->create();
$productCollection->addAttributeToFilter('name', ['like' => '%FORTIS%']);

foreach ($productCollection as $product) {
    echo "Product ID: " . $product->getId() . "\n";
    echo "Product Name: " . $product->getName() . "\n";
    // Add more information as needed
    echo "-----------------\n";
}
