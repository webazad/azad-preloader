<?php
defined('ABSPATH') || exit;
class Azad_Preloader_Settings{
    public $page_slug = 'azad-preloader';
    public function __construct(){
        add_action('admin_menu',array($this,'azad_preloader_settings_menu'));
        // add_action('plugins_loaded',array($this,'admin'),4);
    }
    public function azad_preloader_settings_menu(){
        add_submenu_page(
            'options-general.php',
            esc_html__( 'Azad Preloader Settings', 'azad-preloader' ),
            esc_html__( 'Azad Preloader', 'azad-preloader' ),
            'manage_options',
            $this->page_slug,
            array($this,'azad_preloader_settings_page')
        );
        if ( isset( $_GET['page'] ) && $_GET['page'] == $this->page_slug ) {
            if ( isset( $_REQUEST['save-option'] ) && $_REQUEST['save-option'] != "" ) {
                if ( isset( $_REQUEST['azad-preloader-style'] ) ) {
                    update_option( 'azad-preloader-style', $_REQUEST['azad-preloader-style'] );
                }
                if ( isset( $_REQUEST['azad-preloader-display'] ) ) {
                    update_option( 'azad-preloader-display', $_REQUEST['azad-preloader-display'] );
                }
            }
        }
    }
    public function azad_preloader_settings_page(){ 
        $preloaders = apply_filters('azad_prealoader',array(
            array(
                'key_name'=>'modern-flat',
                'title_name'=>'Modern Flat'
            )//,
            // array(
            //     'key_name'=>'flat',
            //     'title_name'=>'Flat'
            // ),
            // array(
            //     'key_name'=>'emoji',
            //     'title_name'=>'Emoji'
            // )
        ));
        $style = get_option('azad-preloader-style');
        $display = get_option('azad-preloader-display');
        ?>
        <div class="wp-preloading-wrapper">
            <h1><?php esc_html_e('Azad Preloader Settings','azad-preloader'); ?></h1>
            <form method="post">
                <?php foreach($preloaders as $preloader){ ?>
                    <div class="wp-preloading-section">
                        <h2><?php echo $preloader['title_name']; ?></h2>                    
                        <ul class="azad-preloader">
                            <?php $icon_dir_path = AZAD_PRELOADER_PLUGIN_PATH . '/assets/images/' . $preloader['key_name']; ?>
                            <?php $icon_dir_url = AZAD_PRELOADER_PLUGIN_URL . '/assets/images/' . $preloader['key_name']; ?>
                            <?php foreach(glob($icon_dir_path . '/*.gif') as $file){ 
                                $icon_name  = str_replace($icon_dir_path . '/','',$file);
                                $icon_id    = sanitize_title($icon_name);
                                $icon_url   = $icon_dir_url . '/' . $icon_name;
                                $icon_value = $preloader['key_name'].'/'.$icon_name;
                            ?>
                                <li class="preloader-item">
                                    <label for="<?php echo $icon_id; ?>">
                                        <img src="<?php echo $icon_url; ?>" />
                                    </label>
                                    <input id="<?php echo $icon_id; ?>" type="radio" name="azad-preloader-style" value="<?php echo $icon_value; ?>" <?php checked($icon_value,$style); ?>/>
                                </li>
                            <?php } ?>
                        </ul>                    
                    </div>
                <?php } ?>
                <div class="wp-preloading-section">
                    <h2><?php esc_html_e('More Settings','azad-preloader'); ?></h2>
                    <label for="azad-preloader-display"><?php esc_html_e('Preloader will be appeared on','azad-preloader'); ?></label>
                    <select name="azad-preloader-display" id="preloader-display">
                        <option value="all" <?php selected('all',$display); ?> > <?php esc_html_e('All pages','azad-preloader'); ?></option>
                        <option value="home" <?php selected('home',$display); ?> > <?php esc_html_e('Home','azad-preloader'); ?></option>
                    </select>
                </div>
                <input type="submit" class="button-prymary" name="save-option" value="Save Changes"/>
            </form>
        </div>
<?php    }
    public function __destruct(){}
}
new Azad_Preloader_Settings();
