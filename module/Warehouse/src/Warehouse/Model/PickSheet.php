<?php

namespace Warehouse\Model;

class PickSheet
{
	
	/**
	 * 
	 * @var RoutePath
	 */
	private $routePath;
	
	public function __construct(RoutePath $routePath = null)
	{
		if($routePath !== null) {
			$this->setRoutePath($routePath);
		}
	}
	
	public function setRoutePath(RoutePath $routePath)
	{
		$this->routePath = $routePath;
		return $this;
	}
	
	public function hasRoutePath()
	{
		return $this->routePath instanceof RoutePath;
	}
	
	public function getRoutePath()
	{
		if(! $this->hasRoutePath()) {
			throw new \RuntimeException(sprintf('%s() expects to have a route path, none available', __METHOD__));
		}
		return $this->routePath;
	} 
	
}