<?php

namespace Phpf\Cache\Driver;

use Phpf\Cache\Cache;
use Phpf\Util\Str;

class XCacheDriver extends AbstractDriver {
	
	public function getEngine(){
		return 'xcache';
	}
	
	public function getPrefix( $group = Cache::DEFAULT_GROUP ){
		
		return $this->prefix . $group . '|';
	}
	
	public function exists( $id, $group = Cache::DEFAULT_GROUP ){
		
		return xcache_isset( $this->getPrefix($group) . $id );	
	}
	
	public function getGroup( $group = Cache::DEFAULT_GROUP ){
		return xcache_get( $this->getPrefix($group) );
	}
	
	public function get( $id, $group = Cache::DEFAULT_GROUP ){
		
		$value = xcache_get( $this->getPrefix($group) . $id );	
		
		if ( Str::isSerialized($value, false) ){
			#$unserializer = $this->unserializer;
			$value = unserialize($value);
		}
		
		return $value;
	}
		
	public function set( $id, $value, $group = Cache::DEFAULT_GROUP, $ttl = Cache::DEFAULT_TTL ){
		
		if ( is_array($value) || is_object($value) ){
			#$serializer = $this->serializer;
			$value = serialize($value);
		}
		
		return xcache_set( $this->getPrefix($group) . $id, $value, $ttl );		
	}
			
	public function delete( $id, $group = Cache::DEFAULT_GROUP ){
		
		return xcache_unset( $this->getPrefix($group) . $id );	
	}
	
	public function incr( $id, $val = 1, $group = Cache::DEFAULT_GROUP, $ttl = Cache::DEFAULT_TTL ){
		
		return xcache_inc( $this->getPrefix($group) . $id, $val, $ttl );	
	}
	
	public function decr( $id, $val = 1, $group = Cache::DEFAULT_GROUP, $ttl = Cache::DEFAULT_TTL ){
		
		return xcache_dec( $this->getPrefix($group) . $id, $val, $ttl );	
	}
	
	public function flush(){
		
		return xcache_unset_by_prefix($this->prefix);
	}
	
	public function flushGroup( $group ){
		
		return xcache_unset_by_prefix( $this->getPrefix($group) );
	}
		
}