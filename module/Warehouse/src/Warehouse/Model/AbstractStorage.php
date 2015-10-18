<?php

namespace Warehouse\Model;

abstract class AbstractStorage
{
	
	/**
	 * The characters to use for the random string
	 * @var string
	 */
	const CHARACTERS = 'ABCDEFGHIJKLMNOPQRSTUVYWXYZ0123456789';
	
	/**
	 * The length of the random string
	 * @var int
	 */
	const LENGTH = 32;
	
	/**
	 * 
	 * @var string
	 */
	private $id;
	
	/**
	 * Creates a random unique identifier. Prefix is used to easily distinguish between different id types
	 * 
	 * @param string $prefix
	 */
	protected function createId($prefix = '0')
	{
		$id = $prefix;
		
		for($i = 1; $i < self::LENGTH; $i++) {
			$id .= substr(self::CHARACTERS, mt_rand(0, strlen(self::CHARACTERS)), 1);
		}
		
		$this->setId($id);
		return $this;
		
	}
	
	/**
	 * 
	 * @param string $id
	 * @return $this
	 */
	protected function setId($id)
	{
		$this->id = $id;
		return $this;
	}
	
	/**
	 * 
	 * @throws \RuntimeException
	 * return string
	 */
	public function getId()
	{
		if(is_null($this->id)) {
			throw new \RuntimeException(sprintf('%s() must have an id available', __METHOD__));
		}
		return $this->id;
	}
	
}