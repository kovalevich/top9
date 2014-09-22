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
class Zend_View_Helper_ProjectsTable
{

    /**
     *
     * @var Zend_View_Interface
     */
    public $view;
    
    private $class;

    /**
     */
    public function projectstable ($entries, $type = 0)
    {
        if ($type == 0)
            $head = 
                '<table cellpadding="0" cellspacing="0">
                    <tr class="odd">
                        <th>Тип работы</th>
                        <th>Тема</th>
                        <th>Объём</th>
                        <th>Год сдачи</th>
                        <th>Автор</th>
                        <th>Где сдавалось</th>
                        <th>Цена</th>
                        <th></th>
                    </tr>';
        if ($type == 1)
        	$head =
        	'<table cellpadding="0" cellspacing="0">
                    <tr class="odd">
                        <th>Тип работы</th>
                        <th>Тема</th>
                        <th>Объём</th>
                        <th>Цена</th>
                        <th>Количество продаж</th>
        	            <th></th>
                    </tr>';
        $fotter = 
            '</table>';
        $body = '';
        
        if (count($entries) > 0) {
            $class = 'even';
        	foreach ($entries as $entry) {
        	    if ($type == 0)
            	    $body .= 
            	        '<tr class="' . $this->toogleClass() . '">
                            <td>' . $entry->type->name . '</td>
                            <td><a href="' . $this->view->url(array('id' => $entry->id),'project') . '">' . $entry->name . '</a></td>
                            <td>' . $entry->sheets . '</td>
                            <td>' . $entry->year . '</td>
                            <td>' . $entry->author->name . '</td>
                            <td>' . $entry->institut . '</td>
                            <td>' . $this->view->currency($entry->price) . '</td>
                            <td><a href="/room' . $this->view->url(array('id'=>$entry->id), 'projectpayment') . '" class="to-cart">Купить</a></td>
                        </tr>';
        	    if ($type == 1)
        	    	$body .=
        	    	'<tr class="' . $this->toogleClass() . '">
                            <td>' . $entry->type->name . '</td>
                            <td><a href="' . $this->view->url(array('id' => $entry->id),'project') . '">' . $entry->name . '</a> ' . ($entry->status == 0 ? '(на модерации)' : '') . '</td>
                            <td>' . $entry->sheets . '</td>
                            <td>' . $this->view->currency($entry->price) . '</td>
                            <td>' . $entry->sales . '</td>
                            <td>' . $this->view->delete('project', $entry) . '</td>
                        </tr>';
        	}
        }
        else {
            if ($type == 0)
                $body = 
                    '<tr>
                         <td colspan="8">Нет ни одного проекта</td>
                     </tr>';
            if ($type == 1)
            	$body =
            	    '<tr>
                         <td colspan="6">Нет ни одного проекта на продажу</td>
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
