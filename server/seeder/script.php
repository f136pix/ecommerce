<?php

use App\Domain\ProductsAggregate\AttributeSet;
use App\Domain\ProductsAggregate\AttributeValue;
use App\Domain\ProductsAggregate\Brand;
use App\Domain\ProductsAggregate\Category;
use App\Domain\ProductsAggregate\Product;
use App\Domain\ProductsAggregate\ProductAttributeValue;
use App\Domain\ProductsAggregate\ProductImage;

$entityManager = require __DIR__ . '/../src/Infraestructure/Persistence/doctrine.php';

$jsonData = file_get_contents(__DIR__ . '/data.json');
$data = json_decode($jsonData, true);

// If is there already any seeded data, not running it again
$existingCategories = $entityManager->getRepository(Category::class)->findAll();
if (count($existingCategories) > 0) {
    die('Data already seeded.');
}


foreach ($data['data']['categories'] as $categoryData) {
    $category = $entityManager->getRepository(Category::class)->findOneBy(['name' => $categoryData['name']]);
    if (!$category) {
        $category = new Category();
        $category->setName($categoryData['name']);
        $entityManager->persist($category);
    }
    $entityManager->flush();
}

foreach ($data['data']['products'] as $productData) {
    $brand = $entityManager->getRepository(Brand::class)->findOneBy(['name' => $productData['brand']]);
    if (!$brand) {
        $brand = new Brand();
        $brand->setName($productData['brand']);
        $entityManager->persist($brand);
    }
    $entityManager->flush();

    $product = new Product();
    $product->setName($productData['name']);
    $product->setDescription($productData['description']);
    $product->setInStock($productData['inStock']);
    $product->setPrice($productData['prices'][0]['amount']);

    $product->setCategory($entityManager->getRepository(
        Category::class
    )->findOneBy(['name' => $productData['category']]));

    $product->setBrand($brand);

    $entityManager->persist($product);
    $entityManager->flush();

    foreach ($productData['gallery'] as $index => $image) {
        $productImage = new ProductImage();
        $productImage->setUrl($image);
        $productImage->setPosition($index);
        $productImage->setProduct($product);
        $entityManager->persist($productImage);
        $entityManager->flush();
    }

    foreach ($productData['attributes'] as $attributeSetData) {
        $attributeSet = $entityManager->getRepository(AttributeSet::class)
            ->findOneBy(['name' => $attributeSetData['name']]);

        if (!$attributeSet) {
            $attributeSet = new AttributeSet();
            $attributeSet->setName($attributeSetData['name']);
            $attributeSet->setType($attributeSetData['type']);
            $entityManager->persist($attributeSet);
            $entityManager->flush();
        }

        foreach ($attributeSetData['items'] as $attributeData) {
            $attributeValue = $entityManager->getRepository(AttributeValue::class)
                ->findOneBy(['value' => $attributeData['value'], 'attributeSet' => $attributeSet]);

            if (!$attributeValue) {
                $attributeValue = new AttributeValue();
                $attributeValue->setValue($attributeData['value']);
                $attributeValue->setDisplayValue($attributeData['displayValue']);

                $attributeValue->setAttributeSet($attributeSet);
                $entityManager->persist($attributeValue);
                $entityManager->flush();
            }

            $productAttributeValue = new ProductAttributeValue();
            $productAttributeValue->setProduct($product);
            $productAttributeValue->setAttributeSet($attributeSet);
            $productAttributeValue->setAttributeValue($attributeValue);
            $entityManager->persist($productAttributeValue);
            $entityManager->flush();
        }
    }

    $entityManager->persist($product);
    $entityManager->flush();
}

$entityManager->flush();
