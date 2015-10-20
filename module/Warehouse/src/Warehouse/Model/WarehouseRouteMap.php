<?php

namespace Warehouse\Model;

class WarehouseRouteMap
{
	
	/**
	 * This Matrix defines all of the possible moves from the current (X,Y) location
	 * 
	 * @var array
	 */
	const DEPTH_MATRIX = [
				 [0, -1],
		[-1, 0],/*[X,Y]*/[1, 0],
				 [0,  1], 
	];
	
	/**
	 * Defines the array index for X coord 
	 * @var int
	 */
	const X = 0;
	
	/**
	 * Defines the array index for Y coord
	 * @var int
	 */
	const Y = 1;
	
	
	/**
	 * 
	 * @var array
	 */
	private $cells;
	
	public function __construct()
	{
		$this->cells = [];
	}
	
	/**
	 * 
	 * @param int $x
	 * @param int $y
	 * @param int $cost
	 * @throws \InvalidArgumentException
	 * @return $this
	 */
	public function setCost($x, $y, $cost)
	{
		if($cost < 0) {
			throw new \InvalidArgumentException(sprintf('%s(%d,%d,%d) must be given a positive cost', __METHOD__, $x, $y, $cost));
		}
		if(! isset($this->cells[$x])) {
			$this->cells[$x] = [];
		}
		$this->cells[$x][$y] = $cost;
		return $this;
	}
	
	/**
	 * 
	 * @param int $x
	 * @param int $y
	 * @throws \InvalidArgumentException
	 * @return int
	 */
	public function getCost($x, $y)
	{
		if(!$this->hasCost($x, $y)) {
			throw new \InvalidArgumentException(sprintf('%s(%d, %d) is not a valid cell', __METHOD__, $x, $y));
		}
		return $this->cells[$x][$y];
	}
	
	/**
	 * 
	 * @param int $x
	 * @param int $y
	 * @return bool
	 */
	public function hasCost($x, $y)
	{
		return isset($this->cells[$x]) && isset($this->cells[$x][$y]);
	}
	
	/**
	 * @return array
	 */
	public function getCostMap()
	{
		return $this->cells;
	}
	
	/**
	 * Simple depth-first-search function to find a route from the 'from' X,Y to the 'to' X,Y
	 * 
	 * @param int $fromX
	 * @param int $fromY
	 * @param int $toX
	 * @param int $toY
	 * @return RoutePath|null
	 */
	public function getRoutePath($fromX, $fromY, $toX, $toY)
	{
		
		// Add the current position into the route
		$route = new RoutePath();
		$route->addAction(new RouteAction($fromX, $fromY));
		
		// Base Case: Check that we've not arrived
		if($fromX == $toX && $fromY == $toY) {
			return $route;
		}
		
		// Check that we're going the correct way
		if($this->getCost($fromX, $fromY) >= $this->getCost($toX, $toY)) {
			return null;
		}
		
		// Go in each possible direction
		$matrix = self::DEPTH_MATRIX;
		foreach ($matrix as $dir) {

			$newX = $fromX + $dir[self::X];
			$newY = $fromY + $dir[self::Y];
			
			// Check cost available
			if($this->hasCost($newX, $newY)) {
				$ret = $this->getRoutePath($newX, $newY, $toX, $toY);
				if($ret instanceof RoutePath) {
					// Correct path
					return $route->appendPath($ret);
				}
			}
			
		}
		
		// End of line
		return null;
		
	}
	
}