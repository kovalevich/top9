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
class Zend_View_Helper_Universtable
{

    /**
     *
     * @var Zend_View_Interface
     */
    public $view;

    private $class;

    /**
     */
    public function universtable ($entries)
    {
        $html = '
        <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Аббревиатура</th>
                  <th>Название</th>
                  <th>Ссылка</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>';

        if (count($entries)) {
            foreach ($entries as $entry) {
                $html .= '
                        <tr>
                            <td>' . $entry->id . '</td>
        	                <td>' . $entry->name . '</td>
        	                <td>' . $entry->full_name . '</td>
                            <td><a href="/univers/' . $entry->id . '">/univers/' . $entry->id . '</a></td>
                            <td>
                                ' . $this->view->edit('univer', $entry) . '
                                ' . $this->view->delete('univer', $entry) . '
                            </td>
                        </tr>
        	            ';
            }
        }
        else {
            $html .= '
                        <tr>
                            <td colspan="5">Нет универов</td>
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
