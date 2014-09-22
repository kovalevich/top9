<?php 
class Application_Plugin_Cache extends Zend_Controller_Plugin_Abstract{
  public function dispatchLoopShutdown(){
    $frontendOptions = array(
      'lifetime' => null,
      'debug_header' => false,
        'regexps' => array(
        		'^/pages/' => array('cache' => true), 
                '^/catalog/'=> array('cache' => true),
                '^/catalog/add'=> array('cache' => false),
                '^/catalog/search'=> array('cache' => false),
        ),
      'default_options' => array(
        'cache' => false
      )
    );

    $backendOptions = array(
      'cache_dir' => './tmp/',
    );
        
    $cache_id=$_SERVER['REQUEST_URI'];
        
    $lastSymbol = $cache_id{strlen($cache_id)-1};
    
    if($lastSymbol=='/'){
      $cache_id = substr($cache_id, 0, -1);
    }
        
    $cache = Zend_Cache::factory('Page', 'File', $frontendOptions, $backendOptions);
      
    $cache->start(md5($cache_id));
  }
}
?>