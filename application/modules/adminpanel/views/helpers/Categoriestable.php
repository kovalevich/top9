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
class Zend_View_Helper_Categoriestable
{

    /**
     *
     * @var Zend_View_Interface
     */
    public $view;

    /**
     */
    public function categoriestable ($entries)
    {
        $html = '
        <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Заголовок</th>
                  <th>Описание</th>
                  <th>Количество статей</th>
                  <th>Количество сайтов</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>';

        if (count($entries)) {
            foreach ($entries as $entry) {
                $html .= '
                        <tr>
                            <td>' . $entry->id . '</td>
        	                <td>' . $entry->title . '</td>
                            <td>' . $entry->description . '</td>
                            <td>' . $entry->count . '</td>
                            <td>' . $entry->sites_count . '</td>
                            <td>
                                ' . $this->view->edit('category', $entry) . '
                                ' . $this->view->delete('category', $entry) . '
                            </td>
                        </tr>
        	            ';
            }
        }
        else {
            $html .= '
                        <tr>
                            <td colspan="6">Нет категорий</td>
                        </tr>
                    ';
        }

        $html .='
              </tbody>
            </table>
          </div>
        ';

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
