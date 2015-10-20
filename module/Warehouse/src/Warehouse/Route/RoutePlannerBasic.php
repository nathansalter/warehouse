<?php

namespace Warehouse\Route;

use Warehouse\Model\PickingStation;
use Warehouse\Model\ProductBin;
use Warehouse\Model\RoutePath;
use Warehouse\Model\Warehouse;

class RoutePlannerBasic implements RoutePlannerInterface
{

    /**
     * @var
     */
    protected $warehouse;

    /**
     * @var ProductBin[]
     */
    protected $requiredProductBins;

    /**
     * @var PickingStation[]
     */
    protected $pickingStationOption;

    public function __construct()
    {
        $this->requiredProductBins = [];
        $this->pickingStationOption = [];
    }

    /**
     * @param Warehouse $warehouse
     * @return $this
     */
    public function setWarehouse(Warehouse $warehouse)
    {
        $this->warehouse = $warehouse;
    }

    /**
     * @return Warehouse
     */
    protected function getWarehouse()
    {
        if(! $this->warehouse instanceof Warehouse) {
            throw new \RuntimeException(sprintf('%s must be injected with a Warehouse before usage', static::class));
        }
        return $this->warehouse;
    }

    /**
     * @param ProductBin $bin
     * @return $this
     */
    public function addRequiredProductBin(ProductBin $bin)
    {
        $this->requiredProductBins[] = $bin;
        return $this;
    }

    protected function getPossibleRoutes()
    {
        $binRoutes = $this->getRouteTrees();

        $finalRoutes = [];

        foreach($this->pickingStationOption as $pickingStation) {
            foreach($binRoutes as $route) {
                $finalRoutes = array_merge([$pickingStation], $route, [$pickingStation]);
            }
        }

        return $finalRoutes;

    }

    private function getRouteTrees(array $currentRoute = [])
    {

        if(count($currentRoute) == count($this->requiredProductBins)) {
            return [$currentRoute];
        }

        $trees = [];

        foreach($this->requiredProductBins as $productBin) {
            if(! in_array($productBin, $currentRoute, true)) {
                $currentRoute[] = $productBin;
                foreach($this->getRouteTrees($currentRoute) as $lowerRoute) {
                    $trees[] = $lowerRoute;
                }
            }
        }

        return $trees;
    }

    /**
     * @param PickingStation $station
     * @return $this
     */
    public function addOptionalPickingStation(PickingStation $station)
    {
        $this->pickingStationOption[] = $station;
        return $this;
    }

    protected function getCoords($routeLocation)
    {
        if($routeLocation instanceof PickingStation) {
            return $this->getWarehouse()->findPickingStation($routeLocation);
        }

        if($routeLocation instanceof ProductBin) {
            return $this->getWarehouse()->findBin($routeLocation);
        }

        throw new \RuntimeException(sprintf('%s() expects route location to be a valid location', __METHOD__));
    }

    /**
     * @return RoutePath
     */
    public function getRoute()
    {

        $shortestRoute = null;
        $heldRoute = null;

        // Work out what the shortest route is
        foreach($this->getPossibleRoutes() as $possibleRoute) {

            $routeLength = 0;

            // Work out the length of this route
            for($i =0; $i < count($possibleRoute) - 1; $i++) {

                list($startX, $startY) = $this->getCoords($possibleRoute[$i]);
                list($endX, $endY) = $this->getCoords($possibleRoute[$i + 1]);

                $routeLength += $this->getWarehouse()->getRouteMap($startX, $startY)->getCost($endX, $endY);

            }

            // Check to see if it's the shortest route
            if($shortestRoute === null || $routeLength < $shortestRoute) {
                $shortestRoute = $routeLength;
                $heldRoute = $possibleRoute;
            }

        }

        // Build up a list of each actual action along the path
        $routePath = new RoutePath();
        for($i =0; $i < count($heldRoute) - 1; $i++) {

            $routeAction = $heldRoute[$i];
            $routeNextAction = $heldRoute[$i + 1];

            list($startX, $startY) = $this->getCoords($routeAction);
            list($endX, $endY) = $this->getCoords($routeNextAction);

            if($routeAction instanceof PickingStation) {
                $routePath->setPickingStation($routeAction);
            }

            $path = $this->getWarehouse()->getRouteMap($startX, $startY)->getRoutePath($startX, $startY, $endX, $endY);

            if($routeAction instanceof ProductBin) {
                $path->getAction($startX, $startY)->setProductBin($routeAction);
            }

            $routePath->appendPath($path);

        }

        return $routePath;

    }


}