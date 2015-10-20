<?php

namespace Warehouse\Model;

class ProductBin
{
	
	/**
	 * 
	 * @var string
	 */
	private $name;
	
	/**
	 * 
	 * @var Product
	 */
	private $product;
	
	/**
	 * 
	 * @param string $name
	 * @param Product $product
	 */
	public function __construct($name = null, Product $product = null)
	{
		if($name !== null) {
			$this->setName($name);
		}
		
		if($product !== null) {
			$this->setProduct($product);
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
			throw new \RuntimeException(sprintf('%s() expects to have a name set, none set', __METHOD__));
		}
		return $this->name;
	}
	
	/**
	 * 
	 * @param Product $product
	 * @return $this
	 */
	public function setProduct(Product $product)
	{
		$this->product = $product;
		return $this;
	}
	
	/**
	 * @return bool
	 */
	public function hasProduct()
	{
		return $this->product instanceof Product;
	}
	
	/**
	 * 
	 * @throws \RuntimeException
	 * @return Product
	 */
	public function getProduct()
	{
		if(! $this->hasProduct()) {
			throw new \RuntimeException(sprintf('%s() expects to have a product set, none set', __METHOD__));
		}
		return $this->product;
	}
	
}