<?php

namespace Warehouse\Map;

use Warehouse\Model\Warehouse;
use Warehouse\Model\PickingStation;
use Warehouse\Model\ProductBin;

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
	
	public function buildMap($x, $y)
	{
		
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