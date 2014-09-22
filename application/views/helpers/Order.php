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
class Zend_View_Helper_Order
{

    /**
     *
     * @var Zend_View_Interface
     */
    public $view;
    
    private $class;

    /**
     */
    public function order ($entry)
    {
        $html = '';
        
        if ($entry->user->id == $this->view->user->id) {
            
            $files = '';
            $f = $entry->getFiles();
            if ($f)
                foreach ($f as $file) {
                	$files .= '<p><a href="' . $file->getLinc() . '">' . $file->name . '</a> - ' . $this->view->nicetime($file->loadet) . '</p>';
                }
            
            $finalfile = $entry->finalfile ? $entry->status > 3 ? '<a href="' . $entry->finalfile->getLinc() . '">' . $entry->finalfile->name . '</a>' : $entry->finalfile->name : '-';

            $html .= '
    			<table>
        			<tbody>
                    <tr> <td>Номер заказа</td>  <td>' . $entry->id . '</td> </tr>
        			<tr> <td>Статус заказа</td>  <td>' . $this->view->orderstatus($entry->status) . '</td> </tr>
        			<tr> <td>Исполнитель</td>  <td>' . ($entry->author ? $entry->author->name : 'не назначен') . '</td> </tr>
        			<tr> <td>Стоимость работы</td>  <td>' . $this->view->currency($entry->price) . '</td> </tr>
        			<tr> <td>Срок выполнения</td>  <td>' . $this->view->nicetime($entry->term) . '</td> </tr>
        			<tr> <td>Прикрепленные файлы</td>  <td>' . $files . '</td> </tr>
        			<tr> <td>Скачать готовую работу</td>  <td>' . $finalfile . '</td> </tr>
    				</tbody>
                </table>';
        	/*
        	 * */
        }
        else 
            if ($entry->author->id == $this->view->user->id) {

                $files = '';
                $f = $entry->getFiles();
                if ($f)
                    foreach ($f as $file) {
                        $files .= '<p><a href="' . $file->getLinc() . '">' . $file->name . '</a> - ' . $this->view->nicetime($file->loadet) . '</p>';
                    }
            
            	$finalfile = $entry->finalfile ? '<a href="' . $entry->finalfile->getLinc() . '">' . $entry->finalfile->name . '</a>' : '-';
            
            	$html .= '
    			<table>
        			<tbody>
                    <tr> <td>Номер заказа</td>  <td>' . $entry->id . '</td> </tr>
        			<tr> <td>Статус заказа</td>  <td>' . $this->view->orderstatus($entry->status) . '</td> </tr>
        			<tr> <td>Заказчик</td>  <td>' . ($entry->user ? $entry->user->name : 'не назначен') . '</td> </tr>
        			<tr> <td>Стоимость работы</td>  <td>' . $this->view->currency($entry->reward_author) . '</td> </tr>
        			<tr> <td>Срок выполнения</td>  <td>' . $this->view->nicetime($entry->term) . '</td> </tr>
        			<tr> <td>Прикрепленные файлы</td>  <td>' . $files . '</td> </tr>
        			<tr> <td>Описание</td>  <td>' . $entry->description . '</td> </tr>
        			<tr> <td>Файл готовой работы</td>  <td>' . $finalfile . '</td> </tr>
    				</tbody>
                </table>';
            	/*
            	 * */
            }
        return $html;
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
