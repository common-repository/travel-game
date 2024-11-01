<?php 
    /*
    Plugin Name: Travel Game
    Plugin URI: https://ideal-escapes.com/travel-game-wordpress/
    Description: Try to hit the hottest destination and plan vacation early with a recreational travel game.
    Author: idealescapes
    Version: 1.1
    Author URI: https://ideal-escapes.com/
    */



// Include Files
$files = array(
    '/classes/wscg-main',
   '/classes/wscg-setting',
   '/classes/wscg-widget'
);

foreach ($files as $file) {
    require_once plugin_dir_path( __FILE__ ).$file.'.php';
}
if ( class_exists( 'wscg_Main' ) ) {
    new wscg_Main();
 }
add_action('widget_init','wscg_game_widget_init');
function wscg_game_widget_init()
{
    register_widget('wscg_game_widget');
}
register_deactivation_hook(__FILE__,'wscg_remove_option');
function wscg_remove_option()
{
    delete_option('WSCG_SETTING');
}

?>