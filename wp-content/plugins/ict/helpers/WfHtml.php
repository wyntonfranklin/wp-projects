<?php
/**
 * Created by PhpStorm.
 * User: shady
 * Date: 4/29/2018
 * Time: 7:34 PM
 * A helper class with basic wordpress functions.
 * Add rendering capabilities similar to yii.
 * Layouts are expected to be a the layouts folder relative to the plugin main directory
 */

class WfHtml {

	function __construct() {

	}


	static function wf_text_input($attribute, $value, $htmlOptions=array()){
		$options = self::wf_addHtmlOptions( $htmlOptions );
		return '<input type="text" name="'.$attribute.'" value="'.$value.'" '.$options.' >';
	}

	static function check_box(){
		return '<input id="checkBox" type="checkbox">';
	}

	static function wf_submitButton( $name="submit", $value="Save Changes"){
		return '<p class="submit">
			<input type="submit" name="'.$name.'" id="submit" class="button button-primary" value="'.$value.'"></p>';
	}

	static function renderFileTest( $file_name ){
		$o = '';
		try{
			$o = file_get_contents(plugin_dir_path(__DIR__) . 'layouts/'. $file_name .'.php');
		}catch (Exception $e){

		}
		return $o;
	}

	static function wf_render($file_name, $variables = array(), $print = true) {
		$filePath = plugin_dir_path(__DIR__) . 'layouts/'. $file_name .'.php';
		return self::wf_renderFile($filePath, $variables, $print);
	}

	static function wf_renderLayout($file_name, $variables = array(), $print = true) {
		$filePath = plugin_dir_path(__DIR__) . 'layouts/'. $file_name .'.php';
		return self::wf_renderFile($filePath, $variables, $print);
	}

	static function wf_renderView($file_name, $variables = array(), $print = true){
		$filePath = plugin_dir_path(__DIR__) . 'view/'. $file_name .'.php';
		return self::wf_renderFile($filePath, $variables, $print);
	}

	static function wf_renderFile($filePath, $variables, $print){
		$output = NULL;
		if(file_exists($filePath)){
			extract($variables);
			ob_start();
			include $filePath;
			$output = ob_get_clean();
		}
		if ( $print ) {
			echo $output;
		}else{
			return $output;
		}
		return false;
	}

	static function adminPageRedirect($type , $page, $admin_page, $msg=true){
		if( $msg ){
			wp_redirect(add_query_arg(array('page'=>$page,'message'=>1),admin_url($admin_page)));
		}else{
			wp_redirect(add_query_arg($type,$page,admin_url($admin_page)));
		}
	}

	static function wf_beginForm( $method="post", $action="admin-post.php", $id='', $hiddenSubmit='save_form'){
		echo '<form method="'.$method.'" action="'.$action.'" id="'.$id.'">
			<input type="hidden" name="action" value="'.$hiddenSubmit.'">';
	}

	static function wf_endForm(){
		echo '</form>';
	}

	static function wf_beginFormTable(){
		echo '	<table class="form-table">
		<tbody>';
	}

	static function wf_endFromTable(){
		echo '</tbody>
			</table>';
	}

	static function formMessage( $message='Done'){
		return '<div id="message" class="updated fade">
			<p><strong>'.$message.'</strong></p>
		</div>';
	}

	static function loggedIn(){
		return is_user_logged_in();
	}

	static function redirectAddress(){
		return (empty($_POST['_wf_http_referer']) ? site_url() : $_POST['_wp_http_referer']);
	}

	static function frontMessage(){
		return '<div style="margin:8px; border: 1px solid #ddd; background-color:#ff0"> Tank you for yours </div>';
	}

	static function wf_getPageUrl( $page ){
		return menu_page_url($page,false);
	}

	static function adminUrl( $page, $params=array()){
		$queryParams = array_merge($params, array('page'=>$page));
		return add_query_arg($queryParams,
			admin_url('admin.php'));
	}

	static function wf_registerScript($name, $path, $version){
		wp_enqueue_script($name, $path, array( 'jquery' ), $version);
	}

	static function wf_registerStyle( $name, $path, $version){
		wp_enqueue_style($name,$path,array(),$version);
	}

	static function createPluginUrl(){

	}

	static function limit_text(){

	}

	private static function wf_addHtmlOptions( $options )
	{
		$classOptions = '';
		foreach( $options as $option=>$value){
			if( !empty( $value ) ){
				$classOptions .= $option.'='.'"'.$value.'"'.' ';
			}
		}
		return $classOptions;
	}

	public static function getPageUrl( $page ){
		return menu_page_url($page,false);
	}

	public static function wf_dropDownBox($name='', $value='', $data, $htmlOptions=array()){
		$o ='<select '.self::wf_addHtmlOptions($htmlOptions) . ' name="'.$name.'">';
		$o .= self::wf_selectOptions($data, $value);
		$o .= '</select>';
		return $o;
	}

	public static function wf_selectOptions($data, $selected){
		$o = "";
		foreach($data as $key=>$value){
		    if( $key == $selected ){
                $o .= '<option value="'.$key.'" selected>'.$value.'</option>';
            }else{
                $o .= '<option value="'.$key.'">'.$value.'</option>';
            }
		}
		return $o;
	}

	public static function wf_textArea($name='', $value='', $htmlOptions=array()){
	    return ' <textarea name="'.$name.'" '.self::wf_addHtmlOptions($htmlOptions).'>'.$value.'</textarea> ';
    }

    public static function wf_limitText($text, $limit) {
        if (str_word_count($text, 0) > $limit) {
            $words = str_word_count($text, 2);
            $pos = array_keys($words);
            $text = substr($text, 0, $pos[$limit]) . '...';
        }
        return $text;
    }

    public static function wf_checkBox( $name='', $value=''){
	    if( !empty($value) ){
            return '<input name="'.$name.'" id="checkBox" type="checkbox" checked>';
        }else{
            return '<input name="'.$name.'" id="checkBox" type="checkbox">';
        }
    }


}