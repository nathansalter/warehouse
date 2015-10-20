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
	
	public function __construct()
	{
		$this->map = [];
	}
	
	/**
	 * .
	 * @param int $x
	 * @param int $y
	 * @return $this
	 */
	public function setPassable($x, $y)
	{
		if(! isset($this->map[$x])) {
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
		return $this->map[$x][$y] === self::PASSABLE;
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
		if(! $this->isPassable($x, $y)) {
			throw new \InvalidArgumentException(sprintf('%s() Cannot set anything in %d,%d, location already filled!', __METHOD__, $x, $y));
		}
		$this->map[$x][$y] = $bin;
		return $this;
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
		if(! $this->isPassable($x, $y)) {
			throw new \InvalidArgumentException(sprintf('%s() Cannot set anything in %d,%d, location already filled!', __METHOD__, $x, $y));
		}
		$this->map[$x][$y] = $station;
		return $this;
	}
	
}