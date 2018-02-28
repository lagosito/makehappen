<?php
/*****************************************************************************
 * WP Advanced Importer is a Tool for importing XML for the Wordpress
 * plugin developed by Smackcoders. Copyright (C) 2014 Smackcoders.
 *
 * WP Advanced Importer is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Affero General Public License version 3
 * as published by the Free Software Foundation with the addition of the
 * following permission added to Section 15 as permitted in Section 7(a): FOR
 * ANY PART OF THE COVERED WORK IN WHICH THE COPYRIGHT IS OWNED BY WP Advanced
 * Importer, WP Advanced Importer DISCLAIMS THE WARRANTY OF NON
 * INFRINGEMENT OF THIRD PARTY RIGHTS.
 *
 * WP Advanced Importer is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY
 * or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public
 * License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program; if not, see http://www.gnu.org/licenses or write
 * to the Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor,
 * Boston, MA 02110-1301 USA.
 *
 * You can contact Smackcoders at email address info@smackcoders.com.
 *
 * The interactive user interfaces in original and modified versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License
 * version 3, these Appropriate Legal Notices must retain the display of the
 * WP Advanced Importer copyright notice. If the display of the logo is
 * not reasonably feasible for technical reasons, the Appropriate Legal
 * Notices must display the words
 * "Copyright Smackcoders. 2015. All rights reserved".
 ********************************************************************************/
$impObj = new WPAdvImporter_includes_helper();
$nonceKey = $impObj->create_nonce_key();
if(! wp_verify_nonce($nonceKey, 'wp_advance_nonce'))
	die('You are not allowed to do this operation.Please contact your admin.');
?>

	<style> #ui-datepicker-div { display:none } </style>
	<div id = 'notification_wp_csv'> </div>
<?php
$impCEM = CallWPAdvImporterObj::getInstance();
$impCEM->renderMenu();
if(isset($_REQUEST['action'])){
	$impCEM->requestedAction($_REQUEST['action'], isset($_REQUEST['step']));
} else if(isset($_REQUEST['__module'])) {
	#		print_r($skinny_content);
	if (isset($_REQUEST['__module'])) {
		if ( current_user_can( 'administrator' ) ) { //uthor' ) && current_user_can( 'editor' ) ) {
			print_r($skinny_content);
		} else {
			if(sanitize_text_field($_REQUEST['__module']) == 'users' || sanitize_text_field($_REQUEST['__module']) == 'settings') {
				die('<p id="warning-msg" class="alert alert-warning" style="margin-top:50px;">You are not having the permission to access this page. Please, Contact your administrator.</p>');
			} else {
				print_r($skinny_content);
			}
		}
	}
}
else
{
	echo "<div align='center' style='width:100%;'> <p class='warnings' style='width:50%;text-align:center;color:red;'>".esc_html__('This feature is only available in PRO!.','wp-advanced-importer')."</p></div>";
}