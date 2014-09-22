<?php
/**
 *
 * @author kovalevich
 * @version 
 */
 
 
class Zend_View_Helper_FormWysiwyg extends Zend_View_Helper_FormElement
{
 
    public function formWysiwyg($name = null, $value = null, $attribs = null)
    {
        if (is_null($name) && is_null($value) && is_null($attribs)) {
            return $this;
        }
        $info = $this->_getInfo($name, $value, $attribs);
        extract($info); // name, value, attribs, options, listsep, disable
 
        $html = '<textarea class="tinymce" name="' . $name . '">' . $value . '</textarea>
	<script type="text/javascript" src="/scripts/tinymce/tinymce.min.js"></script>
	<script type="text/javascript">
	tinymce.PluginManager.load("moxiemanager", "/scripts/tinymce/plugins/moxiemanager/plugin.min.js");
	tinymce.init({
	    selector: ".tinymce",
	    plugins: [
		"advlist autolink lists link image charmap print preview anchor",
		"searchreplace visualblocks code fullscreen",
		"insertdatetime media table contextmenu paste moxiemanager textcolor"
	    ],
	    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | sizeselect | fontselect |  fontsizeselect | forecolorpicker | forecolor",
	    //theme_advanced_font_sizes: "10px,12px,13px,14px,16px,18px,20px",
	    //font_size_style_values: "12px,13px,14px,16px,18px,20px",
	    autosave_ask_before_unload: false,
	    max_height: 2000,
	    min_height: 160,
	    height : 200,
	    max_width: 800,
	    min_width: 500,
	    width : 1100
	 });
	</script>
        ';
 
        // $value значение по умолчанию
        return $html;
    }
 
}
