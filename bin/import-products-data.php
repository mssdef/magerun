<?php
use Magento\Framework\App\Bootstrap;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Api\Data\ProductInterface;

require __DIR__ . '/../app/bootstrap.php';

$bootstrap = Bootstrap::create(BP, $_SERVER);
$objectManager = $bootstrap->getObjectManager();

$state = $objectManager->get('Magento\Framework\App\State');
$state->setAreaCode('frontend');

// Set the CSV file path
$csvFilePath = 'bin/csv/lagerliste-bouw.csv';

// Set the store view ID
const STORE_NL = 1;
$storeViewId = STORE_NL;

// Function to update product attribute descriptions
function updateProductDescriptions($sku, $description, $storeViewId)
{
    /**
     * @var $product Magento\Catalog\Model\Product
     * @var $productRepository ProductRepositoryInterface
     */
    $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
    $productRepository = $objectManager->get(ProductRepositoryInterface::class);
    $product = $productRepository->get($sku);

    // Check if the product exists
    if ($product->getId()) {
        // Update the attribute description for the specified store view
        $product->setStoreId($storeViewId);
        $product->setData('specs_plat', $description);
        $productRepository->save($product);
        echo "Product ID $sku updated successfully.\n";
    } else {
        echo "Product SKU {$sku} not found.\n";
    }
}

// Read and process the CSV file
if (($handle = fopen($csvFilePath, 'r')) !== false) {
    while (($data = fgetcsv($handle, 1000, ',')) !== false) {
        $productId = $data[0]; // Assuming the product ID is in the first column
        $description = $data[1]; // Assuming the description is in the second column

        // Update product attribute description
        try {
            updateProductDescriptions($productId, $description, $storeViewId);
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
    fclose($handle);
} else {
    echo "Error opening CSV file.\n";
}

echo "Script execution completed.\n";
