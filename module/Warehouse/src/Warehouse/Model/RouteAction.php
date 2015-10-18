<?php

namespace Warehouse\Model;

class RouteAction
{
	
	/**
	 *
	 * @var int
	 */
	private $x;
	
	/**
	 *
	 * @var int
	 */
	private $y;
	
	/**
	 * 
	 * @var ProductBin
	 */
	private $productBin;
	
	/**
	 *
	 * @param int $x
	 * @param int $y
	 * @param ProductBin $productBin
	 */
	public function __construct($x = null, $y = null, $productBin = null)
	{
		if($x !== null) {
			$this->setX($x);
		}
		if($y !== null) {
			$this->setY($y);
		}
		if($productBin !== null) {
			$this->setProductBin($productBin);
		}
	}
	
	/**
	 *
	 * @param int $x
	 */
	public function setX($x)
	{
		$this->x = $x;
		return $this;
	}
	
	/**
	 *
	 * @throws \RuntimeException
	 * @return int
	 */
	public function getX()
	{
		if(is_null($this->x)) {
			throw new \RuntimeException('Route Path must have x coordinate');
		}
		return $this->x;
	}
	
	/**
	 *
	 * @param int $y
	 */
	public function setY($y)
	{
		$this->y = $y;
		return $this;
	}
	
	/**
	 *
	 * @throws \RuntimeException
	 * @return int
	 */
	public function getY()
	{
		if(is_null($this->y)) {
			throw new \RuntimeException('Route Path must have y coordinate');
		}
		return $this->y;
	}
	
	/**
	 * 
	 * @param ProductBin $productBin
	 * @return $this
	 */
	public function setProductBin(ProductBin $productBin)
	{
		$this->productBin = $productBin;
		return $this;
	}
	
	/**
	 * 
	 * @return bool
	 */
	public function hasProductBin()
	{
		return $this->productBin instanceof ProductBin;
	}
	
	/**
	 * 
	 * @throws \RuntimeException
	 * @return ProductBin
	 */
	public function getProductBin()
	{
		if(! $this->hasProductBin()) {
			throw new \RuntimeException(sprintf('%s() does not have a product bin. Use %s::hasProductBin() first', __METHOD__, static::class));
		}
		return $this->productBin;
	}
	
}