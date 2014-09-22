<?php
/**
 *
 * @author kovalevich
 * @version 
 */
require_once 'Zend/View/Interface.php';

/**
 * Social helper
 *
 * @uses viewHelper Zend_View_Helper
 */
class Zend_View_Helper_Social
{

    /**
     *
     * @var Zend_View_Interface
     */
    public $view;
    public $url;

    /**
     */
    public function social ($item, $is_desire = false)
    {
        $this->setView(Zend_Layout::getMvcInstance()->getView());
        
        if ($item->type == 'univer') {
            $type_name = 'универ';
        }else
		if ($item->type == 'college') {
            $type_name = 'колледж';
        }
        else {
            $type_name = 'город';
        }
        $this->url = 'http://top9.by';
        $this->title = sprintf('Идет голосование за лучший %s!', $type_name);
		$this->text = sprintf('Я голосую за %s. %s уже набрал %s %s. Голосуй за свой %s!!!',
            $item->name,
            $item->name,
            $item->votes,
            $this->view->bycounts($item->votes, 'голос', 'голоса', 'голосов'),
            $type_name);
		$this->url .= $this->view->url(array('id'=>$item->id), $item->type);
		$links = array (
            'facebook'=>'"#" onclick="$(\'#modal\').modal(\'hide\'); window.open(\'https://www.facebook.com/sharer/sharer.php?u='.$this->url.'\', \'_blank\', \'scrollbars=0, resizable=1, menubar=0, left=200, top=200, width=550, height=440, toolbar=0, status=0\'); return false;" title="Проголосовать с помощью Facebook"',
            'vkontakte'=>'"#" onclick="$(\'#modal\').modal(\'hide\'); window.open(\'http://vk.com/share.php?title='.$this->title.'&description='.$this->text.'&url='.$this->url . ($is_desire ? '/#desire' : '' ) . '\', \'_blank\', \'scrollbars=0, resizable=1, menubar=0, left=200, top=200, width=554, height=421, toolbar=0, status=0\'); return false" title="Проголосовать с помощью В Контакте"',
            'twitter'=>'"#" onclick="$(\'#modal\').modal(\'hide\'); window.open(\'http://twitter.com/share?text='.$this->title.'&url='.$this->url.'\', \'_blank\', \'scrollbars=0, resizable=1, menubar=0, left=200, top=200, width=550, height=440, toolbar=0, status=0\'); return false" title="Проголосовать с помощью Twitter"'
		);
		$l='';
		foreach ($links as $i=>$link) $l .= '<a rel="nofollow" style="display:inline-block;vertical-align:bottom;width:58px;height:58px;margin:0 6px 6px 0;outline:none;background:url(/img/'.$i.'.png) -0px 0" href='.$link.' target="_blank"></a>';
		return $l;
    }

    /**
     * Sets the view field
     * 
     * @param $view Zend_View_Interface            
     */
    public function setView (Zend_View_Interface $view)
    {
        $this->view = $view;
    }
}
