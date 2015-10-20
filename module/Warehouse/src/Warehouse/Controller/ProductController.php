<?php

namespace Warehouse\Controller;


use Warehouse\Storage\ProductStorage;
use Warehouse\Storage\WarehouseStorage;

class ProductController
{

    public function queryAction()
    {

        $name = $this->getParam('name');

        /** @var ProductStorage $productStorage */
        $productStorage = $this->getServiceLocator(ProductStorage::class);
        /** @var WarehouseStorage $warehouseStorage */
        $warehouseStorage = $this->getServiceLocator(WarehouseStorage::class);

        try {
            $product = $productStorage->findProduct($name);
        } catch (\Exception $e) {
            printf('Cannot find product by name %s%s', $name, PHP_EOL);
            exit(1);
        }

        $warehouse = $warehouseStorage->getWarehouse();

        printf('Product:%s', PHP_EOL);
        printf('ID: %s%s', $product->getId(), PHP_EOL);
        printf('Name: %s%s', $product->getName(), PHP_EOL);
        printf('Stock Level: %d%s', $product->getStockLevel(), PHP_EOL);
        printf('Product Bin: %s%s', $warehouse->findProductBin($product)->getName(), PHP_EOL);
        printf('Last Updated: %s%s', $product->getLastUpdated()->format(\DateTime::ISO8601));

        return $this->getResponse();

    }

}