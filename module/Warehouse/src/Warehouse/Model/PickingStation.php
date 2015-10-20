<?php

namespace Warehouse\Model;

class PickingStation
{
	
	/**
	 * 
	 * @var string
	 */
	private $name;
	
	public function __construct($name = null)
	{
		if($name !== null) {
			$this->setName($name);
		}
	}
	
	/**
	 * 
	 * @param string $name
	 * @return $this
	 */
	public function setName($name)
	{
		$this->name = $name;
		return $this;
	}
	
	/**
	 * @return bool
	 */
	public function hasName()
	{
		return $this->name !== null;
	}

	/**
	 * 
	 * @throws \RuntimeException
	 * @return $this
	 */
	public function getName()
	{
		if(! $this->hasName()) {
			throw new \RuntimeException(sprintf('%s() expects to have a name set, none set', __METHOD__));
		}
		return $this->name;
	}
	
}