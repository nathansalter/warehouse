<?php

namespace Warehouse\Model;

class Warehouse
{

    const PASSABLE = ' ';

    /**
     *
     * @var array
     */
    private $map;

    /**
     * @var WarehouseRouteMap[]
     */
    private $routeMaps;

    const MAP_FORMAT = '%s::%s';

    public function __construct()
    {
        $this->map = [];
        $this->routeMaps = [];
    }

    public function setRouteMap($x, $y, WarehouseRouteMap $routeMap)
    {
        $this->routeMaps[sprintf(self::MAP_FORMAT, $x, $y)] = $routeMap;
        return $this;
    }

    public function hasRouteMap($x, $y)
    {
        return isset($this->routeMaps[sprintf(self::MAP_FORMAT, $x, $y)]);
    }

    public function getRouteMap($x, $y)
    {
        if(! $this->hasRouteMap($x, $y)) {
            throw new \RuntimeException(sprintf('%s() has no route map available for %d,%d', $x, $y));
        }
        return $this->routeMaps[sprintf(self::MAP_FORMAT, $x, $y)];
    }

    /**
     * .
     * @param int $x
     * @param int $y
     * @return $this
     */
    public function setPassable($x, $y)
    {
        if (!isset($this->map[$x])) {
            $this->map[$x] = [];
        }
        $this->map[$x][$y] = self::PASSABLE;
        return $this;
    }

    /**
     *
     * @param int $x
     * @param int $y
     * @return bool
     */
    public function isPassable($x, $y)
    {
        if (!isset($this->map[$x]) || !isset($this->map[$y])) {
            return false;
        }
        return $this->map[$x][$y] === self::PASSABLE || $this->map[$x][$y] instanceof PickingStation;
    }

    /**
     *
     * @param int $x
     * @param int $y
     * @param ProductBin $bin
     * @throws \InvalidArgumentException
     * @return $this
     */
    public function addBin($x, $y, ProductBin $bin)
    {
        if (!$this->isPassable($x, $y)) {
            throw new \InvalidArgumentException(sprintf('%s() Cannot set anything in %d,%d, location already filled!', __METHOD__, $x, $y));
        }
        $this->map[$x][$y] = $bin;
        return $this;
    }

    /**
     * @param ProductBin $bin
     * @return array|bool
     */
    public function findBin(ProductBin $bin)
    {
        foreach($this->map as $x => $mapY) {
            foreach($mapY as $y => $thing) {
                if($thing instanceof ProductBin && $thing == $bin) {
                    return [$x, $y];
                }
            }
        }
        return false;
    }

    /**
     * @param Product $product
     * @return ProductBin|bool
     */
    public function findProductBin(Product $product)
    {
        foreach($this->map as $x => $mapY) {
            foreach($mapY as $y => $thing) {
                if($thing instanceof ProductBin && $thing->hasProduct() && $thing->getProduct() == $product) {
                    return $thing;
                }
            }
        }
        return false;
    }

    /**
     *
     * @param int $x
     * @param int $y
     * @param PickingStation $station
     * @throws \InvalidArgumentException
     * @return $this
     */
    public function addPickingStation($x, $y, PickingStation $station)
    {
        if (!$this->isPassable($x, $y)) {
            throw new \InvalidArgumentException(sprintf('%s() Cannot set anything in %d,%d, location already filled!', __METHOD__, $x, $y));
        }
        $this->map[$x][$y] = $station;
        return $this;
    }


    /**
     * @param PickingStation $station
     * @return array|bool
     */
    public function findPickingStation(PickingStation $station)
    {
        foreach($this->map as $x => $mapY) {
            foreach($mapY as $y => $thing) {
                if($thing instanceof PickingStation && $thing == $station) {
                    return [$x, $y];
                }
            }
        }
        return false;
    }

}