<?php
/** this file is depreciated until it become required. */

function expt_settings_array(){
	return array("apiUrl" => getbaseurl(), "version" => "v0", "basename" => "api");
}

function buildlink($model, $pagesize=30){
	$settings = expt_settings_array();
	return $settings["apiUrl"]."/".$settings["version"]."/".$settings["basename"]."/"
	       .$model."?per_page=".$pagesize.'&page='.get_query_var('paged');
}

function buildnopagelink($model, $pagesize=30){
	$settings = expt_settings_array();
	return $settings["apiUrl"]."/".$settings["version"]."/".$settings["basename"]."/".$model . "?per_page=".$pagesize;
}

function buildajaxlink($model, $pagesize=30){
	$settings = expt_settings_array();
	return $settings["apiUrl"]."/".$settings["version"]."/".$settings["basename"]."/"
	       .$model."?per_page=".$pagesize.'&page='.getVars("page");
}

function formparams($params){
	$paramString = "";

	foreach ($params as $key => $value) {
		if($value!=null || $value!=""){
			$paramString.= "&".$key."=".$value;
		}
	}
	return $paramString;
}

function getfilter($filter){
	if (isset($filter)) {
		return $filter;
	}
	return "";
}

function getbaseurl(){
	return "http://ict.xhuma.co";
}
?>
