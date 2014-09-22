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
class Zend_View_Helper_Sitestable
{

    /**
     *
     * @var Zend_View_Interface
     */
    public $view;

    private $class;

    /**
     */
    public function sitestable ($entries)
    {
        $html = '
        <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Название</th>
                  <th>Ссылка на страницу</th>
                  <th>Категория</th>
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
                            <td><a href="/sites/' . $entry->category->id . '/' . $entry->id . '.html">/sites/' . $entry->category->id . '/' . $entry->id . '.html</a></td>
                            <td>' . $entry->category->title . '</td>
                            <td>
                                ' . $this->view->edit('site', $entry) . '
                                ' . $this->view->delete('site', $entry) . '
                            </td>
                        </tr>
        	            ';
            }
        }
        else {
            $html .= '
                        <tr>
                            <td colspan="5">Нет сайтов</td>
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
