<?php
/**
 *
 * @author kovalevich
 * @version 
 */
require_once 'Zend/View/Interface.php';

/**
 * Nicetime helper
 *
 * @uses viewHelper Zend_View_Helper
 */
class Zend_View_Helper_Shoppingtable
{

    /**
     *
     * @var Zend_View_Interface
     */
    public $view;
    
    private $class;

    /**
     */
    public function shoppingtable ($entries)
    {
        $user = Zend_Registry::get('user');
                               
        $head = 
            '<table cellpadding="0" cellspacing="0">
                <tr class="odd">
                    <th>#</th>
                    <th>Тема работы</th>
                    <th>Стоимость</th>
                    <th>Статус</th>
                    <th>Ссылка для скачивания</th>
                </tr>';
        $fotter = 
            '</table>';
        $body = '';
        
        if (count($entries) > 0) {
            $class = 'even';
        	foreach ($entries as $entry) {
        	    $body .= 
        	        '<tr class="' . $this->toogleClass() . '">
        	            <td>' . $entry->id . '</td>
        	            <td><a href="' . ( $entry->project ? $this->view->url(array('id'=> $entry->project->id),'project') : '#' ) . '">' . ( $entry->project ? $entry->project->name : 'Не существует' ) . '</a></td>
                        <td>' . ( $entry->project ? $this->view->currency($entry->project->price) : '-') . '</td>
                        <td>' . $this->view->purchasestatus($entry->status) . '</td>    
                        <td>' . ( $entry->project ? ($entry->status == 1 ? $this->view->projectsfiles($entry->project->getFiles(),  'full') : '<a href="/room/payment/purchase/' . $entry->id . '">Оплатить</a>') : '-' ) . '</td>
                    </tr>';
        	}
        }
        else {
            $body = 
                '<tr>
                     <td colspan="7">У вас нет покупок</td>
                 </tr>';
        }

        return $head . $body . $fotter;
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
    
    private function toogleClass ()
    {
        if ($this->class == 'even') {
        	$this->class = 'odd';
        }
        else $this->class = 'even';
        
        return $this->class;
    }
}
