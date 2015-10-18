<?php

namespace Warehouse\Model;

class Route extends AbstractStorage
{
	
	/**
	 * 
	 * @var PickingStation
	 */
	private $pickingStation;
	
	/**
	 * 
	 * @var RoutePath[]
	 */
	private $bins;
	
}