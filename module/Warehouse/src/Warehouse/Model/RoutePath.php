<?php

namespace Warehouse\Model;

class RoutePath implements \IteratorAggregate
{
	
	/**
	 * 
	 * @var PickingStation
	 */
	private $pickingStation;
	
	/**
	 * 
	 * @var RouteAction[]
	 */
	private $path;
	
	/**
	 * 
	 * @param string $pickingStation
	 */
	public function __construct($pickingStation = null/*, RouteAction ...$path*/)
	{
		$this->path = [];
		if($pickingStation !== null) {
			$this->setPickingStation($pickingStation);
		}
		for($arg_num=1; $arg_num < func_num_args(); $arg_num++) {
			$this->addStep(func_get_arg($arg_num));
		}
	}
	
	/**
	 * 
	 * @param PickingStation $pickingStation
	 * @return $this
	 */
	public function setPickingStation(PickingStation $pickingStation)
	{
		$this->pickingStation = $pickingStation;
		return $this;
	}
	
	/**
	 * @return bool
	 */
	public function hasPickingStation()
	{
		return $this->pickingStation instanceof PickingStation;
	}
	
	/**
	 * 
	 * @throws \RuntimeException
	 * @return PickingStation
	 */
	public function getPickingStation()
	{
		if(! $this->hasPickingStation()) {
			throw new \RuntimeException(sprintf('%s() expects Picking Station to be set, none set', __METHOD__));
		}
		return $this->pickingStation;
	}
	
	/**
	 * 
	 * @param RouteAction $action
	 * @return $this
	 */
	public function addAction(RouteAction $action)
	{
		$this->path[] = $action;
		return $this;
	}
	
	/**
	 * 
	 * @param int $x
	 * @param int $y
	 */
	public function hasAction($x, $y)
	{
		foreach($this->path as $action) {
			/** @var RouteAction $action */
			if($action->getX() == $x && $action->getY() == $y) {
				return true;
			}
		}
		return false;
	}
	
	/**
	 * 
	 * @param int $x
	 * @param int $y
	 */
	public function getAction($x, $y)
	{
		foreach($this->path as $action) {
			/** @var RouteAction $action */
			if($action->getX() == $x && $action->getY() == $y) {
				return $action;
			}
		}
		throw new \InvalidArgumentException(sprintf('%s(%d, %d) is not a valid action for this path', __METHOD__, $x, $y)); 
	}
	
	/**
	 * 
	 * @param RoutePath $path
	 * @return $this
	 */
	public function appendPath(RoutePath $path)
	{
		foreach($path as $action) {
			$this->addAction($action);
		}
		return $this;
	}
	
	/**
	 * @return RouteAction[]
	 */
	public function getPath()
	{
		return $this->path;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see IteratorAggregate::getIterator()
	 */
	public function getIterator()
	{
		return new \ArrayIterator($this->getPath());
	}
	
	/**
	 * @return int
	 */
	public function getLength()
	{
		return $this->hasPickingStation() + count($this->getPath()) + $this->hasPickingStation();
	}
	
}