<?php

namespace Warehouse\Route;


use Warehouse\Model\PickingStation;
use Warehouse\Model\ProductBin;
use Warehouse\Model\RoutePath;
use Warehouse\Model\Warehouse;

interface RoutePlannerInterface
{

    /**
     * @param Warehouse $warehouse
     * @return $this
     */
    public function setWarehouse(Warehouse $warehouse);

    /**
     * @param ProductBin $bin
     * @return $this
     */
    public function addRequiredProductBin(ProductBin $bin);

    /**
     * @param PickingStation $station
     * @return $this
     */
    public function addOptionalPickingStation(PickingStation $station);

    /**
     * @return RoutePath
     */
    public function getRoute();

}