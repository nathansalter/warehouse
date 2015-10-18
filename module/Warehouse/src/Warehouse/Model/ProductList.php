<?php

namespace Warehouse\Model;

class ProductList implements \IteratorAggregate, \Countable
{
	
	/**
	 * 
	 * @var Product
	 */
	private $products;
	
	/**
	 * Builds the product, can be passed a list of products to automatically add them to the list
	 * 
	 * In PHP 5.6, this could be updated to show that it's a variadic function 
	 */
	public function __construct(/*Product ...$products*/)
	{
		$this->products = [];
		foreach(func_get_args() as $product) {
			$this->add($product);
		}
	}
	
	/**
	 * 
	 * @return Product[]
	 */
	public function getAll()
	{
		return array_values($this->products);
	}
	
	/**
	 * 
	 * @param Product $product
	 * @return $this
	 */
	public function add(Product $product)
	{
		$this->products[] = $product;
		return $this;
	}
	
	/**
	 * 
	 * @param Product $product
	 * @return boolean
	 */
	public function has(Product $product)
	{
		return in_array($product, $this->getAll());
	}
	
	/**
	 * 
	 * @param Product $product
	 * @return $this
	 */
	public function remove(Product $product)
	{
		$this->products = array_filter(function(Product $check) use ($product) {
			return $check != $product;
		}, $this->getAll());
		return $this;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see IteratorAggregate::getIterator()
	 */
	public function getIterator()
	{
		return new \ArrayIterator($this->getAll());
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Countable::count()
	 */
	public function count()
	{
		return count($this->getAll());
	}
	
}