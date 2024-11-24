<?php

use App\Domain\ProductsAggregate\Brand;
use App\Domain\ProductsAggregate\Category;
use App\Domain\ProductsAggregate\Product;
use App\Domain\ProductsAggregate\AttributeSet;
use App\Domain\ProductsAggregate\AttributeValue;
use App\Domain\ProductsAggregate\ProductAttributeValue;
use App\Domain\ProductsAggregate\ProductImage;

$entityManager = require __DIR__ . '/../config/doctrine.php';

$jsonData = file_get_contents(__DIR__ . '/data.json');
$data = json_decode($jsonData, true);


foreach ($data['data']['categories'] as $categoryData) {
    $category = $entityManager->getRepository(Category::class)->findOneBy(['name' => $categoryData['name']]);
    if (!$category) {
        $category = new Category($categoryData['name']);
        $entityManager->persist($category);
    }
    $entityManager->flush();
}

foreach ($data['data']['products'] as $productData) {
    $brand = $entityManager->getRepository(Brand::class)->findOneBy(['name' => $productData['brand']]);
    if (!$brand) {
        $brand = new Brand($productData['brand']);
        $entityManager->persist($brand);
    }

    $product = new Product(
        $productData['name'],
        $productData['description'],
        $productData['inStock'],
        $productData['prices'][0]['amount']
    );

    $product->setCategory($entityManager->getRepository(
        Category::class
    )->findOneBy(['name' => $productData['category']]));

    $product->setBrand($brand);

    foreach ($productData['gallery'] as $index => $image) {
        $productImage = new ProductImage($image, $index, $product);
//        $product->addImage($productImage);
        $entityManager->persist($productImage);
    }

    foreach ($productData['attributes'] as $attributeSetData) {
        $attributeSet = $entityManager->getRepository(AttributeSet::class)->
        findOneBy(['name' => $attributeSetData['name']]);

        if (!$attributeSet) {
            $attributeSet = new AttributeSet($attributeSetData['name'], $attributeSetData['type']);
            $entityManager->persist($attributeSet);
        }

        foreach ($attributeSetData['items'] as $attributeData) {
            $attributeValue = $entityManager->getRepository(AttributeValue::class)
                ->findOneBy(['value' => $attributeData['value'], 'attributeSet' => $attributeSet]);

            if (!$attributeValue) {
                $attributeValue = new AttributeValue(
                    $attributeData['value'],
                    $attributeData['displayValue']
                );

                $attributeValue->setAttributeSet($attributeSet);
                $entityManager->persist($attributeValue);
            }

            $productAttributeValue = new ProductAttributeValue();
            $productAttributeValue->setProduct($product);
            $productAttributeValue->setAttributeSet($attributeSet);
            $productAttributeValue->setAttributeValue($attributeValue);
            $entityManager->persist($productAttributeValue);
        }
    }

    $entityManager->persist($product);
}

$entityManager->flush();
