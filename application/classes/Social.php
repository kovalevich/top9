<?php
class Classes_Social
{
    private $_networks;
    private $_url;
    private $_result = array(0, 0);
    
    function __construct ($networks = array('vkontakte', 'facebook', 'twitter')) {
    	$this->_networks = ($networks!=null)?$networks:$this->_getAllSocials();
    }
    
    private function _getSocial_twitter() {
        if(strstr($this->_url, 'desire')) return 0;
    	if (!($request = file_get_contents('http://urls.api.twitter.com/1/urls/count.json?url='.$this->_url)))
    		return false;
    	$twitter = json_decode($request);
    	return ($twitter===NULL OR !isset($twitter->count)) ? false : $twitter->count;
    }
    
    private function _getSocial_facebook() {
        if(strstr($this->_url, 'desire')) return 0;
    	if (!($request = file_get_contents('http://api.facebook.com/restserver.php?method=links.getStats&urls='.$this->_url.'&format=json')))
    		return false;
    	$fb = json_decode($request);
    	$fb = $fb [0];
    
    
    	return $fb->share_count;
    }
    
    private function _getSocial_vkontakte() {
    	if (!($request = file_get_contents('http://vk.com/share.php?act=count&index=1&url='.$this->_url)))
    		return false;
    	$tmp = array();
    	if (!(preg_match('/^VK.Share.count\((\d+), (\d+)\);$/i',$request,$tmp)))
    		return false;
    		
    	return $tmp[2];
    }
    
    private function _getAllSocials() {
    	$exists_socials = array();
    	$methlist = get_class_methods($this);
    	foreach ($methlist as $method) {
    		$tmp = array();
    		if (preg_match('/^_getSocial_([\w\d]+)$/i',$method,$tmp))
    			$exists_socials[] = $tmp[1];
    	}
    	return $exists_socials;
    }
    
    public function get($url) {
        $this->_url = $url;
    	$this->_result = 0;
    	foreach ($this->_networks as $network) {
    		if (method_exists($this,'_getSocial_'.$network)) {
    			$this->_result += call_user_func(array($this, '_getSocial_'.$network));
    		}
    	}
    	return $this->_result;
    }
}

?>