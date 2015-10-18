<?php

namespace Warehouse\Model;

class Product extends AbstractStorage
{
	
	const PREFIX = 'P';
	
	/**
	 * 
	 * @var string
	 */
	private $name;
	
	/**
	 * 
	 * @var int
	 */
	private $stockLevel;
	
	/**
	 * 
	 * @var \DateTime
	 */
	private $lastUpdated;
	
	/**
	 * Create the product, params are helpers to set the values 
	 * 
	 * @param string $id
	 * @param string $name
	 * @param string $stockLevel
	 * @param \DateTime $lastUpdated
	 */
	public function __construct($id = null, $name = null, $stockLevel = null, \DateTime $lastUpdated = null)
	{
		if($id !== null) {
			$this->setId($id);
		} else {
			$this->createId(self::PREFIX);
		}
		if($name !== null) {
			$this->setName($name);
		}
		if($stockLevel !== null) {
			$this->setStockLevel($stockLevel);
		}
		if($lastUpdated !== null) {
			$this->setLastUpdated($lastUpdated);
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
	 * @return string 
	 */
	public function getName()
	{
		if(! $this->hasName()) {
			throw new \RuntimeException(sprintf('%s() expects a name to be set, none set', __METHOD__));
		}
		return $this->name;
	}
	
	/**
	 * 
	 * @param int $level
	 * @return $this
	 */
	public function setStockLevel($stockLevel)
	{
		if($level < 0) {
			throw new \InvalidArgumentException(sprintf('%s(%d) cannot be sent a negative stock level', __METHOD__, $stockLevel));
		}
		$this->stockLevel = $stockLevel;
		return $this;
	}
	
	/**
	 * 
	 * @param int $by
	 * @return $this
	 */
	public function decreaseStockLevel($by)
	{
		$this->setStockLevel($this->getStockLevel() - $by);
		return $this;
	}
	
	/**
	 * @return bool
	 */
	public function hasStockLevel()
	{
		return $this->stockLevel !== null;
	}
	
	/**
	 * 
	 * @throws \RuntimeException
	 * @return int
	 */
	public function getStockLevel()
	{
		if(! $this->hasStockLevel()) {
			throw new \RuntimeException(sprintf('%s() expects stock level to be set, none set', __METHOD__));
		}
		return $this->stockLevel;
	}
	
	/**
	 * 
	 * @param \DateTime $lastUpdated
	 * @return $this
	 */
	public function setLastUpdated(\DateTime $lastUpdated)
	{
		$this->lastUpdated = $lastUpdated;
		return $this;
	}
	
	/**
	 * @return bool
	 */
	public function hasLastUpdated()
	{
		return $this->lastUpdated instanceof \DateTime;
	}
	
	/**
	 * 
	 * @throws \RuntimeException
	 * @return \DateTime
	 */
	public function getLastUpdated()
	{
		if(! $this->hasLastUpdated()) {
			throw new \RuntimeException(sprintf('%s() expects last updated time to be set, none set', __METHOD__));
		}
		return $this->lastUpdated;
	}
}