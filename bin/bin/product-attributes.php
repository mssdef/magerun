<?php

use Magento\Eav\Api\AttributeManagementInterface;
use Magento\Eav\Model\AttributeRepository;
use Magento\Catalog\Model\ResourceModel\Product\Attribute\Collection as AttributeCollection;
use Magento\Catalog\Model\ResourceModel\Product\Attribute\CollectionFactory as AttributeCollectionFactory;
use Magento\Framework\App\Bootstrap;

require __DIR__ . '/../app/bootstrap.php';

$bootstrap = Bootstrap::create(BP, $_SERVER);

$objectManager = $bootstrap->getObjectManager();

/** @var AttributeCollectionFactory $attributeCollectionFactory */
$attributeCollectionFactory = $objectManager->get(AttributeCollectionFactory::class);
$attributeManagement = $objectManager->get(AttributeRepository::class);

/** @var AttributeCollection $attributeCollection */
$attributeCollection = $attributeCollectionFactory->create();

// Set the entity type code for products
$attributeCollection->setEntityTypeFilter($objectManager->create('Magento\Catalog\Model\Product')->getResource()->getTypeId());

// Fetch all attributes
$attributes = $attributeCollection->getItems();

// Output attribute codes
$n = 0;
foreach ($attributes as $attribute) {
    if (preg_match('~^product_(?!merk$|to_type$).*~', $attribute->getAttributeCode())) {
        if ($n++ >= 2) {
            echo "Attribute #{$n} to delete: " . $attribute->getAttributeCode() . "\n";
            continue;
        } else {
            echo "DELETED : " . $attribute->getAttributeCode() . "\n";
            //$attribute = $this->attributeRepository->get('catalog_product', $attributeCode);
            $attributeManagement->delete($attribute);
        }   
    }   
}

