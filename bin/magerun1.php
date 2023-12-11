<?php
require_once('app/Mage.php'); // Path to Mage.php file

// Initialize Magento
Mage::app();

// Your CLI script logic here
$model = Mage::getModel('tradebyteconnectorOms/import_invoice');
$model->_importInvoices();
