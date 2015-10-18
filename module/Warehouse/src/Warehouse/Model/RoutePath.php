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
	
	public function __construct($pickingStation = null/*, RouteAction ...$path*/)
	{
		if($pickingStation !== null) {
			$this->setPickingStation($pickingStation);
		}
		for($arg_num=1; $arg_num < func_num_args(); $arg_num++) {
			$this->addStep(func_get_arg($arg_num));
		}
	}
	
}