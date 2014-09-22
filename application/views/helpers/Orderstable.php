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
class Zend_View_Helper_OrdersTable
{

    /**
     *
     * @var Zend_View_Interface
     */
    public $view;
    
    private $class;

    /**
     */
    public function orderstable ($entries)
    {
        $user = Zend_Registry::get('user');
                               
        $head = 
            '<table cellpadding="0" cellspacing="0">
                <tr class="odd">
                    <th>#</th>
                    <th>Статус заявки</th>
                    <th>Тема работы</th>
                    <th>Предмет</th>
                    <th>Тип работы</th>
                    <th>Дата заявки</th>
                    <th>' . ($user->role == 'author' ? 'Вознаграждение' : 'Стоимость') . '</th>
                    <th>Срок выполнения</th>
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
        	            <td>' . $this->view->orderstatus($entry->status) . '</td>
        	            <td><a href="' . $this->view->url(array('id'=>$entry->id), 'order') . '">' . $entry->title . '</a>
                        <td>' . $entry->theme->title . '</td>
                        <td>' . $entry->type->name . '</td>
                        <td>' . $this->view->nicetime($entry->created) . '</td>
                        <td>' . $this->view->currency($user->role == 'author' ? $entry->reward_author : $entry->price) . '</td>
                        <td>' . $this->view->nicetime($entry->term) . '</td>       
                    </tr>';
        	}
        }
        else {
            $body = 
                '<tr>
                     <td colspan="8">У вас нет ни одной заявки</td>
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
