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
	
	public function __construct($sizeX, $sizeY)
	{
		$this->map = array_fill(0, $sizeX, array_fill(0, $sizeY, self::PASSABLE));
	}
	
	public function isPassable($x, $y)
	{
		return $this->map[$x][$y] === self::PASSABLE;
	}
	
	public function addBin($x, $y, ProductBin $bin)
	{
		if(! $this->isPassable($x, $y)) {
			throw new \InvalidArgumentException(sprintf('%s() Cannot set anything in %d,%d, location already filled!', __METHOD__, $x, $y));
		}
		$this->map[$x][$y] = $bin;
		return $this;
	}
	
	public function addPickingStation($x, $y, PickingStation $station)
	{
		if(! $this->isPassable($x, $y)) {
			throw new \InvalidArgumentException(sprintf('%s() Cannot set anything in %d,%d, location already filled!', __METHOD__, $x, $y));
		}
		$this->map[$x][$y] = $station;
		return $this;
	}
	
}