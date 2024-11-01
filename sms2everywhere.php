<?php
/**
 * Plugin Name: Sms2everywhere
 * Plugin URI: http://wordpress.org/plugins/Sms2everywhere/
 * Description: this plugin enable you to send sms worldwide.
 * Version: 1.0
 * Author: ahmed azzeh
 * Author URI: http://sms2everywhere.com
 * License: GPL2
 */
 /*  Copyright 2014  ahmed azzeh  (email : ahmed_azzeh2000@hotmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

 defined('ABSPATH') or die("No script !");
 
/* Runs when plugin is activated */
register_activation_hook(__FILE__,'sms2everywhere_install'); 

/* Runs on plugin deactivation*/
register_deactivation_hook( __FILE__, 'sms2everywhere_remove' );

function sms2everywhere_install() {
add_option("sms2everywhere", 'Default', '', 'yes');
add_option("sms2everywhere_username", '', '', 'yes');
add_option("sms2everywhere_password", '', '', 'yes');
}
function sms2everywhere_remove() {
delete_option('sms2everywhere');
delete_option('sms2everywhere_username');
delete_option('sms2everywhere_password');
}


add_action( 'admin_menu', 'sms2everywhere_plugin_menu' );

function sms2everywhere_plugin_menu() {
	  add_submenu_page('options-general.php', 'sms2everywhere account', 'sms2everywhere account', 'manage_options', 'sms2everywhere', 'sms2everywhere_account');

	}
	
	function sms2everywhere_account(){
		echo '<div class="wrap"><div id="icon-tools" class="icon32"></div>';
		echo '<h2>sms2everywhere</h2>
		<br><br>';
	if(isset($_POST['saveaccount']) AND $_POST['saveaccount']){
	$user_username=$_POST['user_username'];  
	$user_password=$_POST['user_password']; 
	update_option( 'sms2everywhere_username', $user_username );
	update_option( 'sms2everywhere_password', $user_password );
	echo '<div id="message" class="updated below-h2"><p>sms2everywhere.com account information have been updated</p></div>';
	}
	$user_username = get_option( 'sms2everywhere_username' );
	$user_password = get_option( 'sms2everywhere_password' );

		echo '<p>set your account information on <a href="http://www.sms2everywhere.com/" target="_blank">sms2everywhere.com</a>, if you have not any account yet, please go <a href="http://www.sms2everywhere.com/?pageid=4" target="_blank">here</a>, register and activate your account and then set the information below.</p>
		<br><br>
		<form method="POST" action="">
		<label for="user_username" style="margin-right: 50px;">Username <span class="description">(required)</span></label>
		<input name="user_username" type="text" id="user_username" value="'.$user_username.'" aria-required="true">
		<br><br>
		<label for="user_password" style="margin-right: 52px;">Password <span class="description">(required)</span></label>
		<input name="user_password" type="text" id="user_password" value="'.$user_password.'" aria-required="true">
		<br><br>
		<input type="submit" name="saveaccount" id="saveaccount" class="button button-primary" value=" Save ">
		</form>
		<p>set this shortcode [sms2everywhere_display] on any page or post you want the form to be shown</p>
		';
		
	echo '</div>';
	}
	
function js_scripts() {
	wp_enqueue_script(
		'sms2everywhere',
		plugins_url( '/sms2everywhere.js' , __FILE__ )
	);
}

add_action( 'wp_enqueue_scripts', 'js_scripts' );	
	


function register_plugin_styles() {
	wp_register_style( 'sms2everywhere', plugins_url( '/sms2everywhere/sms2everywhere.css' ) );
	wp_enqueue_style( 'sms2everywhere' );
}

add_action( 'wp_enqueue_scripts', 'register_plugin_styles' );
  
	function sms2everywhere_display(){
	if(isset($_POST['SheduleTheSmsNow']) AND $_POST['SheduleTheSmsNow']){
$sms2everywhere_numbers=$_POST['sms2everywhere_numbers'];  
$sms2everywhere_message=$_POST['sms2everywhere_message']; 
$sms2everywhere_encodingtype=$_POST['sms2everywhere_encodingtype']; 
$user_username = get_option( 'sms2everywhere_username' );
$user_password = get_option( 'sms2everywhere_password' );
$variabls='user_username='.$user_username.'&user_password='.$user_password.'&sms2everywhere_numbers='.$sms2everywhere_numbers.'&sms2everywhere_message='.$sms2everywhere_message.'&sms2everywhere_encodingtype='.$sms2everywhere_encodingtype;
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,"http://sms2everywhere.com/api/send.php");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $variabls);
$page = curl_exec($ch);
echo $page;
curl_close($ch);
	}
	echo '
<form method="POST" action="">
Language:<br>
<input type="radio" name="sms2everywhere_encodingtype" value="def" checked  onclick="textcounter();">English<input type="radio" name="sms2everywhere_encodingtype" value="uni" onclick="textcounter();">Other Languages
<br>
Insert Numbers( seperate them by , ) format example: 00447123456789<br>
<textarea rows="2" name="sms2everywhere_numbers" id="sms2everywhere_numbers" cols="100"></textarea>			
Message: <br>
<textarea name="sms2everywhere_message" id="sms2everywhere_message" class="textareamessage" onkeyup="textcounter();"></textarea>
<br><br>
Letters number : <input type="text" name="remLen1" id="remLen1" readonly><br><br>
Message number : <input type="text" name="remLen2" id="remLen2" readonly>	
<br><br><input type="submit" value=" Send Now " name="SheduleTheSmsNow">
</form>
';
	
	}
	
	
	
	
	
	add_shortcode( 'sms2everywhere_display', 'sms2everywhere_display' );

?>