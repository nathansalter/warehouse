<?php

namespace Warehouse\Model;

class Order extends AbstractStorage
{
	
	const PREFIX = 'O';
	
	/**
	 * 
	 * @var \DateTime
	 */
	private $createdTime;
	
	/**
	 * 
	 * @var PickSheet
	 */
	private $pickSheet;
	
	/**
	 * 
	 * @var \DateTime
	 */
	private $completedTime;
	
	/**
	 * 
	 * @var ProductList
	 */
	private $products;
	
	public function __construct($id = null, \DateTime $createdTime = null, PickSheet $pickSheet = null, \DateTime $completedTime = null, ProductList $products = null)
	{
		if($id !== null) {
			$this->setId($id);
		} else {
			$this->createId(self::PREFIX);
		}
		if($createdTime !== null) {
			$this->setCreatedTime($createdTime);
		}
		if($pickSheet !== null) {
			$this->setPickSheet($pickSheet);
		}
		if($completedTime !== null) {
			$this->setCompletedTime($completedTime);
		}
		if($products !== null) {
			$this->setProducts($products);
		}
	}
	
	/**
	 * 
	 * @param \DateTime $createdTime
	 * @return $this
	 */
	public function setCreatedTime(\DateTime $createdTime)
	{
		$this->createdTime = $createdTime;
		return $this;
	}
	
	/**
	 * @return \DateTime
	 */
	public function getCreatedTime()
	{
		if(! $this->createdTime instanceof \DateTime) {
			$this->setCreatedTime(new \DateTime());
		}
		return $this->createdTime;
	}
	
	/**
	 * 
	 * @param PickSheet $pickSheet
	 * @return $this
	 */
	public function setPickSheet(PickSheet $pickSheet)
	{
		$this->pickSheet = $pickSheet;
		return $this;
	}
	
	/**
	 * @return bool
	 */
	public function hasPickSheet()
	{
		return $this->pickSheet instanceof PickSheet;
	}

	/**
	 * 
	 * @throws \RuntimeException
	 * @return PickSheet
	 */
	public function getPickSheet()
	{
		if(! $this->hasPickSheet()) {
			throw new \RuntimeException(sprintf('%s() expects to have a pick sheet set, none set', __METHOD__));
		}
		return $this->pickSheet;
	}
	
	/**
	 * 
	 * @param \DateTime $completedTime
	 * @return $this
	 */
	public function setCompletedTime(\DateTime $completedTime)
	{
		$this->completedTime = $completedTime;
		return $this;
	}
	
	/**
	 * @return bool
	 */
	public function hasCompletedTime()
	{
		return $this->completedTime instanceof \DateTime;
	}
	
	/**
	 * @return bool
	 */
	public function isCompleted()
	{
		return $this->hasCompletedTime();
	}
	
	/**
	 * 
	 * @throws \RuntimeException
	 * @return \DateTime
	 */
	public function getCompletedTime()
	{
		if(! $this->hasCompletedTime()) {
			throw new \RuntimeException(sprintf('%s() expects completed time to be set, none set', __METHOD__));
		}
		return $this->completedTime;
	}
	
	/**
	 * 
	 * @param ProductList $products
	 * @return $this
	 */
	public function setProducts(ProductList $products)
	{
		$this->products = $products;
		return $this;
	}
	
	/**
	 * @return ProductList
	 */
	public function getProducts()
	{
		if(! $this->products instanceof ProductList) {
			$this->products = new ProductList();
		}
		return $this->products;
	}
	
}