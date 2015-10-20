<?php

namespace Warehouse\Map;

use Warehouse\Model\Warehouse;
use Warehouse\Model\PickingStation;
use Warehouse\Model\ProductBin;
use Warehouse\Model\WarehouseRouteMap;

/**
 * Class to map the map file into a Warehouse Model 
 *  
 * @author Nathan Salter
 *
 */
class Mapper
{
	
	/**
	 * 
	 * @var string
	 */
	private $mapFile;
	
	/**
	 * 
	 * @var string
	 */
	const PICKING_STATION = '[';

	/**
	 * @var int
	 */
	const ORIGIN_COST = 0;
	
	public function __construct($mapFile = null)
	{
		if($mapFile !== null) {
			$this->setMapFile($mapFile);
		}
	}
	
	public function setMapFile($mapFile)
	{
		$this->mapFile = $mapFile;
		return $this;
	}
	
	public function hasMapFile()
	{
		return $this->mapFile !== null;
	}
	
	public function getMapFile()
	{
		if(! $this->hasMapFile()) {
			throw new \RuntimeException(sprintf('%s() expects to have a Map File available, none available', __METHOD__));
		}
		return $this->mapFile;
	}

	/**
	 * Generate a cost map for the given location in the map file
	 *
	 * @param int $x
	 * @param int $y
	 * @return WarehouseRouteMap
	 */
	public function buildMap($x, $y)
	{

		$warehouse = $this->buildWarehouse();

		$map = new WarehouseRouteMap();

		if(! $warehouse->isPassable($x, $y)) {
			throw new \RuntimeException(sprintf('%s() cannot start from location %s, %s', __METHOD__, $x, $y));
		}

		$this->updateCost($warehouse, $map, $x, $y, self::ORIGIN_COST);

		return $map;

	}

	/**
	 * @param Warehouse $warehouse
	 * @param WarehouseRouteMap $map
	 * @param $x
	 * @param $y
	 */
	private function updateCost(Warehouse $warehouse, WarehouseRouteMap $map, $x, $y, $cost)
	{

		// Check to make sure we can go there
		if(! $warehouse->isPassable($x, $y)) {
			return;
		}

		// Already more efficient route to this location
		if($map->hasCost($x, $y) && $map->getCost($x, $y) < $cost) {
			return;
		}

		// Set this as the new most efficient cost (or set one if none exist)
		$map->setCost($x, $y, $cost);

		// Update other directions
		$directions = WarehouseRouteMap::DEPTH_MATRIX;
		foreach($directions as $direction) {

			$newX = $x + $direction[WarehouseRouteMap::X];
			$newY = $y + $direction[WarehouseRouteMap::Y];

			$this->updateCost($warehouse, $map, $newX, $newY, $cost + 1);

		}

		return;

	}
	
	public function buildWarehouse()
	{
		
		$warehouse = new Warehouse();
		
		$csv = fopen($this->getMapFile(), 'r');
		
		$y = 0;
		while($yRow = fgetcsv($csv)) {
			
			for($x = 0; $x < count($yRow); $x++) {
				
				if($yRow[$x] == Warehouse::PASSABLE) {
					$warehouse->setPassable($x, $y);
				} elseif (substr($yRow[$x], 0, 1) == self::PICKING_STATION) {
					$warehouse->addPickingStation($x, $y, new PickingStation(preg_replace('/[^0-9a-z]/i', '', $yRow[$x])));
				} else {
					$warehouse->addBin($x, $y, new ProductBin($yRow[$x]));
				}
				
			}
			
			$y++;
			
		}
		
		return $warehouse;
		
	}
	
}