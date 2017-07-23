<?php
/*
 * file_cache.php
 * 
 * cache objects via json with filesystem 
 * author: hydon lee
 * */

/*
class FileCache
 
examples:
	$cache = new FileCache('../myfolder/cache_file.txt');
	$cache->set('username', 'lihd', time()+3600);
	$username = $cache->get('username'); 
	echo $username;
*/
class FileCache{
	private $cache_file;
	
	private function load(){
		if(file_exists($this->cache_file)){
			$content = file_get_contents($this->cache_file);
			
			if (strlen($content) > 0){
				$data = json_decode($content);
		
				return $data;
			}
		}
		
		return array();
	}
	
	private function save($data){
		$content = json_encode($data);
		return file_put_contents($this->cache_file, $content);
	}
	
	public function __construct($filename) { 
		$this->cache_file = $filename;
	}

	public function get($key){
		$data = $this->load();
		
		foreach($data as $item){
			if ($item->key == $key){
				if ($item->expire_time > time()){
					return $item->value;
				}
				
				break;
			}
		}
		
		return NULL;
	}
	
	public function set($key, $value, $expire_time=NULL){
		$data = $this->load();
		
		$obj = NULL;
		foreach($data as $item){
			if ($item->key == $key){
				$obj = $item;
				
				$obj->value = $value;
				if ($expire_time != NULL){
						$obj->expire_time = $expire_time;
				}
				
				break;
			}
		}
		
		if ($obj == NULL){
			$obj = new CacheItem($key, $value, $expire_time);
			array_push($data, $obj);
		}
			
		return $this->save($data);
	}
}

class CacheItem{
	public $key; 
	public $value;
	public $expire_time;
	
	public function __construct($key, $value, $expire_time) { 
		$this->key = $key;
		$this->value = $value;
		$this->expire_time = $expire_time;
	}
}
?>