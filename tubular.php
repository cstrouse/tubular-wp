<?php
/*
Plugin Name: Tubular
Plugin URI: http://caseystrouse.com/wp-plugins/tubular
Description: Let's you use YouTube videos for your site background.
Version: 0.1
Author: Casey Strouse
Author URI: http://caseystrouse.com
License: FreeBSD
*/

wp_enqueue_script('jquery_tubular', plugins_url('jquery.tubular.js', __FILE__), array('jquery'));
wp_enqueue_script('swobject', 'http://ajax.googleapis.com/ajax/libs/swfobject/2.1/swfobject.js', array('jquery'));
add_action('wp_footer', 'include_tubular');

if(function_exists('register_uninstall_hook'))
    register_uninstall_hook(__FILE__, 'tubular_uninstall_hook');

function tubular_uninstall_hook() {
	delete_option('youtube_video_id');
	delete_option('container_name');
	delete_option('z_index');
	remove_action('tubular_menu');
}

function include_tubular() {
?>
<script type="text/javascript">
	var $j = jQuery.noConflict();

	$j(document).ready(function() {
	   $j('body').tubular('<?php echo get_option('youtube_video_id', '_VKW_M_uVjw');  ?>', '<?php echo get_option('container_name', 'container');  ?>', '<?php echo get_option('z_index', '1');  ?>');
	});
</script>
<?php
}

if(is_admin()) {
	add_action('admin_menu', 'tubular_menu');
	add_action('admin_init', 'tubular_register');
	
	function tubular_menu() {
		add_options_page('Tubular', 'Tubular', 'manage_options', 'tubular', 'tubular_options');
	}

	function tubular_register() {
		register_setting('tubular_optiongroup', 'youtube_video_id');
		register_setting('tubular_optiongroup', 'container_name');
		register_setting('tubular_optiongroup', 'z_index');
	}

	function tubular_options() {
		if(!current_user_can('manage_options')) {
			wp_die(__('You do not have sufficient permissions to access this page.'));
		}
?>
	<div class="wrap">
	<h2>Tubular options</h2>
	<form method="post" action="options.php">
	<?php settings_fields('tubular_optiongroup'); ?>
	<table class="form-table">
			<tr valign="top">
				<th scope="row">YouTube Video ID: </th>
				<td><input id="youtube_video_id" name="youtube_video_id" type="text" value="<?php echo get_option('youtube_video_id'); ?>" /></td>
			</tr>

			<tr valign="top">
				<th scope="row">Container Name: </th>
				<td><input id="container_name" name="container_name" type="text" value="<?php echo get_option('container_name'); ?>" /></td>
			</tr>
			<tr>
				<th scope="row">Z-Index: </th>
				<td><input id="z_index" name="z_index" type="text" value="<?php echo get_option('z_index'); ?>"></td>
			</tr>
			<tr valign="top"><td colspan="2"><input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" /></td></tr>
	</table>
	</form>
	</div>
<?php
	}
}
?>