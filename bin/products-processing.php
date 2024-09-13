<?php
use Magento\Framework\App\Bootstrap;
use Magento\Framework\App\Area;
require __DIR__ . '/../app/bootstrap.php';
  
$bootstrap = Bootstrap::create(BP, $_SERVER);

$objectManager = $bootstrap->getObjectManager();

// Set the area code to the adminhtml area
// AREA_FRONTEND
$areaCode = Area::AREA_ADMINHTML;
$objectManager->get('Magento\Framework\App\State')->setAreaCode($areaCode);

$productRepository = $objectManager->create('Magento\Catalog\Api\ProductRepositoryInterface');
$productCollectionFactory = $objectManager->create('Magento\Catalog\Model\ResourceModel\Product\CollectionFactory');
$productCollection = $productCollectionFactory->create();
$productCollection->setStoreId(1); 
$productCollection->addAttributeToFilter('name', ['like' => '%FORTIS%']);

$n = 0;
foreach ($productCollection as $product) {
    $n++;
    if ($n > 2) continue;

    echo "Product: " . $product->getSku() . ' | ' . $product->getName() . "\n";

    // Load the product to make sure you are working with the latest data
    $productId = $product->getId();
    $product = $objectManager->create('Magento\Catalog\Model\Product')
        ->load($productId)
        ;
    
    var_dump($product->getSpecialPrice(), $product->getPrice());
    $product->setSpecialPrice(null);
    $productRepository->save($product);
    $productRepository->save($product);
}
