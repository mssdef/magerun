<?php

$this->storeManager->setCurrentStore(0);
        $searchCriteria = $this->searchCriteriaBuilder->create();
        $productList = $this->productRepository->getList($searchCriteria);

        foreach ($productList->getItems() as $product) {
            $product->setStoreId(0);
            if ($product->getSku() == '8717752017386') {
                $baseImage = $product->getCustomAttribute('image') ? $product->getCustomAttribute('image')->getValue() : '';
                if (!$baseImage || $baseImage == 'no_selection') {
                    var_dump($product->getSku(), $baseImage);
                    $images = $product->getMediaGalleryEntries();

                    // @var Magento\Catalog\Model\Product\Gallery\Entry $image
                    $image = $images[0];
                    $image->setTypes(['image', 'small_image', 'thumbnail']);
                    $images[0] = $image;

                    $product->setStoreId(0);
                    $product->setCustomAttribute('image', $image->getFile());
                    $product->setSmallImage($image->getFile())
                        ->setThumbnail($image->getFile())
                        ->setImage($image->getFile());
                    $product->setMediaGalleryEntries($images);
                    $this->productRepository->save($product);
                }
            }
        }
