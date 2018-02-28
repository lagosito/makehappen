<?php
/******************************************************************************************
 * Copyright (C) Smackcoders 2014 - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * You can contact Smackcoders at email address info@smackcoders.com.
 *******************************************************************************************/
if ( ! defined( 'ABSPATH' ) )
	exit; // Exit if accessed directly
$impObj = new WPAdvImporter_includes_helper();
$nonceKey = $impObj->create_nonce_key();
if(! wp_verify_nonce($nonceKey, 'wp_advance_nonce'))
	die('You are not allowed to do this operation.Please contact your admin.');
$impCheckobj = CallWPAdvImporterObj::checkSecurity();
if($impCheckobj != 'true')
	die($impCheckobj);

$post = $page = $custompost = $users = $eshop = $settings = $support = $dashboard = false;
$active_plugins = get_option('active_plugins');
$custompost = true;
$impCEM = CallWPAdvImporterObj::getInstance();
$get_settings = array();
$get_settings = $impCEM->getSettings();
$mod = isset($_REQUEST['__module']) ? sanitize_text_field($_REQUEST['__module']) : '';
$module = $manager = '';
if( is_array($get_settings) && !empty($get_settings) ) {
	foreach ($get_settings as $key) {
		$$key = true;
	}
}
if (isset($_POST['post_csv']) && sanitize_text_field($_POST['post_csv']) == 'Import') {
	$dashboard = 'activate';
} else {
	if (isset($_REQUEST['action'])) {
		$action = sanitize_text_field($_REQUEST['action']);

		$$action = 'activate';
	} else {
		if (isset($mod) && !empty($mod)) {
			$module_array = array('post','page','custompost','users','custompost','customtaxonomy','customerreviews','comments','eshop','wpcommerce','woocommerce','marketpress','filemanager','schedulemapping','mappingtemplate' ,'dashboard');
			foreach($module_array as $val) {
				if($val == $mod) {
					$$mod = 'activate';
					if( $mod!= 'filemanager' &&  $mod != 'schedulemapping' &&  $mod != 'mappingtemplate' && $mod != 'support' && $mod != 'export' && $mod != 'settings' && $mod != 'dashboard') {
						$module = 'activate';
						$manager = 'deactivate';
						$dashboard = 'deactivate';
					}
					else if($mod != 'support' && $mod != 'export' && $mod != 'settings' && $mod != 'dashboard') {
						$manager = 'activate';
						$module = 'deactivate';
						$dashboard = 'deactivate';
					}
					else if($mod == 'dashboard') {
						$manager = 'deactivate';
						$module = 'deactivate';
					}
				}
			}
		} else {
			if (!isset($_REQUEST['action'])) {
				$dashboard = 'deactivate';
			}
		}
	}
}
$tab_inc = 1;
$menuHTML = "<nav class='navbar navbar-default' role='navigation'>
   <div>
      <ul class='nav navbar-nav'>

         <li  class = '".sanitize_html_class($dashboard)."' ><a href='".esc_url(add_query_arg(array('page' => WP_CONST_ADVANCED_XML_IMP_SLUG .'/index.php','__module' => 'dashboard'),$impObj->base_admin_URL))."'>".esc_html__('Dashboard','wp-advanced-importer')."</a></li>
         <li class='dropdown'".sanitize_html_class($module)."'>
            <a href='#'  data-toggle='dropdown'>
               ". esc_html__('Imports','wp-advanced-importer')."
               <b class='caret'></b>
            </a>
            <ul class='dropdown-menu'>
		<li class= '".sanitize_html_class($post)."'><a href='".esc_url(add_query_arg(array('page' => WP_CONST_ADVANCED_XML_IMP_SLUG .'/index.php','__module' => 'post','step'=>'uploadfile'),$impObj->base_admin_URL))."'> ".esc_html__('Post','wp-advanced-importer')."</a></li>
	        <li class= '".sanitize_html_class($page)."'><a href='".esc_url(add_query_arg(array('page' => WP_CONST_ADVANCED_XML_IMP_SLUG .'/index.php','__module' => 'page','step'=>'uploadfile'),$impObj->base_admin_URL))."'> ".esc_html__('Page','wp-advanced-importer')."</a></li>";
if($custompost){
	$menuHTML .= "<li class = '".sanitize_html_class($custompost)."'><a href = '".esc_url(add_query_arg(array('page' => WP_CONST_ADVANCED_XML_IMP_SLUG . '/index.php','__module' => 'custompost','step' => 'uploadfile'),$impObj->base_admin_URL))."'>". esc_html__('Custom Post','wp-advanced-importer')."</a></li>";
}
$menuHTML .= "<li class= '".sanitize_html_class($users)."'><a href='".esc_url(add_query_arg(array('page' => WP_CONST_ADVANCED_XML_IMP_SLUG .'/index.php','__module' => 'users','step'=>'uploadfile'),$impObj->base_admin_URL))."'> ".esc_html__('Users','wp-advanced-importer')."</a></li>";
$menuHTML .= "</ul></li>";
$menuHTML .= " <li class= '".sanitize_html_class($settings)."'><a href='".esc_url(add_query_arg(array('page' => WP_CONST_ADVANCED_XML_IMP_SLUG .'/index.php','__module' => 'settings'),$impObj->base_admin_URL))."'> ".esc_html__('Settings','wp-advanced-importer')."</a></li>";
$menuHTML .= "<li class=  '".sanitize_html_class($support)."'><a href=".esc_url('https://smackcoders.freshdesk.com')." target=_blank  />". esc_html__('Support','wp-advanced-importer')."</a></li>
	<li ><a href=".esc_url('https://www.wpultimatecsvimporter.com')." target='_blank'>". esc_html__('Go Pro Now','wp-simple-csv-importer')."</a></li>
         <li ><a href=".esc_url('http://demo.smackcoders.com/wordpressdemofour/wp-admin/admin.php?page=wp-ultimate-csv-importer-pro%2Findex.php&__module=dashboard')." target='_blank'>" . esc_html__('Try Live Demo Now','wp-simple-csv-importer')."</a></li>
      </ul>";
$plugin_version = get_option('ULTIMATE_CSV_IMP_VERSION');
$menuHTML .= "</div>";
$menuHTML .= "<div class='msg' id = 'showMsg' style = 'display:none;'></div>";
$menuHTML .= "<input type='hidden' id='current_url' name='current_url' value='" . get_admin_url() . "admin.php?page=" . WP_CONST_ADVANCED_XML_IMP_SLUG . "/index.php&__module=" . $_REQUEST['__module'] . "&step=uploadfile'/>";
$menuHTML .= "<input type='hidden' name='checkmodule' id='checkmodule' value='" . sanitize_text_field($_REQUEST['__module']) . "' />";

$menuHTML .=  "
</nav>";
echo $menuHTML;
