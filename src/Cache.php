<?php

namespace Phpf\Cache;

use Phpf\Common\SingletonInterface;
use Phpf\Cache\Driver\CacheDriverInterface;

class Cache implements SingletonInterface
{
	
	/**
	 * Default TTL (2 days)
	 * @var int
	 */
	const DEFAULT_TTL = 172800;
	
	/**
	 * Default group ('default').
	 * @var string
	 */
	const DEFAULT_GROUP = 'default';

	/**
	 * Cache driver
	 * @var \Phpf\Cache\Driver\CacheDriverInterface
	 */
	protected $driver;
	
	/**
	 * Singleton instance.
	 * @var \Phpf\Cache
	 */
	protected static $instance;

	final public static function instance() {
		if (! isset(static::$instance))
			static::$instance = new static();
		return static::$instance;
	}

	protected function __construct() {
	}

	public function setDriver(CacheDriverInterface $driver) {
		$this->driver = $driver;
	}

	public function getPrefix($group = self::DEFAULT_GROUP) {
		return $this->driver->getPrefix($group);
	}

	public function exists($id, $group = self::DEFAULT_GROUP) {
		return $this->driver->exists($id, $group);
	}

	public function get($id, $group = self::DEFAULT_GROUP) {
		return $this->driver->get($id, $group);
	}

	public function set($id, $value, $group = self::DEFAULT_GROUP, $ttl = self::DEFAULT_TTL) {
		return $this->driver->set($id, $value, $group, $ttl);
	}

	public function delete($id, $group = self::DEFAULT_GROUP) {
		return $this->driver->delete($id, $group);
	}

	public function incr($id, $val = 1, $group = self::DEFAULT_GROUP, $ttl = self::DEFAULT_TTL) {
		return $this->driver->incr($id, $val, $group, $ttl);
	}

	public function decr($id, $val = 1, $group = self::DEFAULT_GROUP, $ttl = self::DEFAULT_TTL) {
		return $this->driver->decr($id, $val, $group, $ttl);
	}

	public function flush() {
		return $this->driver->flush();
	}

	public function flushGroup($group) {
		return $this->driver->flushGroup($group);
	}

}
