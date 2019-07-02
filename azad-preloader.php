<?php
/* 
Plugin Name: Azad Preloader
Description: A very simple preloader
Plugin URi: gittechs.com/plugin/azad-preloader
Author: Md. Abul Kalam Azad
Author URI: gittechs.com/author
Author Email: webdevazad@gmail.com
Version: 0.0.0.1
Text Domain: azad-preloader
*/
defined('ABSPATH') || exit;


class Azad_Preloader{
    public function __construct(){
        //add_action('plugins_loaded',array($this,'i18n'),2);
        add_action('plugins_loaded',array($this,'constants'),1);
        add_action('plugins_loaded',array($this,'includes'),2);
        add_action('admin_enqueue_scripts',array($this,'azad_admin_scripts'));
        add_action('wp_enqueue_scripts',array($this,'azad_public_scripts'));
        add_action('wp_head',array($this,'azad_preloader_output'),1000);
        //add_action('plugins_loaded',array($this,'admin'),4);
    }
    public function constants(){
        define('AZAD_PRELOADER_PLUGIN_PATH',plugin_dir_path(__FILE__));
        define('AZAD_PRELOADER_PLUGIN_URL',plugin_dir_url(__FILE__));
        define('AZAD_PRELOADER_VERSION','0.0.0.1');
    }
    public function i18n(){
        //echo 'i18n';
    }
    public function azad_preloader_output(){
        $style = get_option('azad-preloader-style','flat/flat_1.gif');
        echo '<div id="azad-preloader-overlay"><img src="' . AZAD_PRELOADER_PLUGIN_URL . '/assets/images/' . $style . '" /></div>';
    }
    public function azad_admin_scripts(){
        wp_register_style('azad_preloader_style', AZAD_PRELOADER_PLUGIN_URL . '/assets/css/admin.css', null, AZAD_PRELOADER_VERSION, 'all');
        wp_enqueue_style('azad_preloader_style');
    }
    public function azad_public_scripts(){
        wp_register_style('azad_public_style', AZAD_PRELOADER_PLUGIN_URL . '/assets/css/public.css', null, AZAD_PRELOADER_VERSION, 'all');
        wp_enqueue_style('azad_public_style');

        wp_register_script('azad_preloader_script', AZAD_PRELOADER_PLUGIN_URL . '/assets/js/azad-preloader.js', array('jquery'), AZAD_PRELOADER_VERSION, true);
        wp_enqueue_script('azad_preloader_script');
    }
    public function includes(){
        define('ADMIN',plugin_dir_path(__FILE__));
        require_once(ADMIN.'azad-preloader-settings.php');
    }
    public function admin(){
        if(is_admin()){
            //require_once(ADMIN.'admin/admin.php');            
        }
    }
    public function __destruct(){}
}
new Azad_Preloader();
