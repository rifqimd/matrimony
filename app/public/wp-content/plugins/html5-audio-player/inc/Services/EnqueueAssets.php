<?php
namespace H5APPlayer\Services;
use H5APPlayer\Helper\LocalizeScript;
use H5APPlayer\Helper\Functions;

class EnqueueAssets{
    protected static $_instance = null;

    /**
     * construct function
     */
    public function register(){
        add_action("wp_enqueue_scripts", [$this, 'publicAssets']);
        add_action("admin_enqueue_scripts", [$this, 'adminAssets']);
    }

    /**
     * Create instance function
     */
    public static function instance(){
        if(self::$_instance === null){
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * Public Assets
     */
    public function publicAssets(){
        wp_enqueue_style('h5ap-public', H5AP_PRO_PLUGIN_DIR .'assets/css/style.css', array(), H5AP_PRO_VERSION);
        wp_register_script( 'bplugins-plyrio', H5AP_PRO_PLUGIN_DIR. 'js/player.js' , array('jquery'), H5AP_PRO_VERSION, false );
        wp_register_script( 'h5ap-player', H5AP_PRO_PLUGIN_DIR. 'dist/player.js' , array('jquery'), H5AP_PRO_VERSION, true );

        wp_register_script( 'h5ap-all', H5AP_PRO_PLUGIN_DIR. 'dist/h5ap-all.js' , array(), H5AP_PRO_VERSION, true );
        
        wp_register_style( 'bplugins-plyrio', H5AP_PRO_PLUGIN_DIR . 'assets/css/player.min.css', array(), H5AP_PRO_VERSION, 'all' );
        wp_register_style( 'h5ap-player', H5AP_PRO_PLUGIN_DIR. 'dist/player.css' , array('bplugins-plyrio'), H5AP_PRO_VERSION );

        // playlist
        wp_register_script( 'h5ap-playlist', H5AP_PRO_PLUGIN_DIR .'dist/playlist.js', ['bplugins-plyrio'], H5AP_PRO_VERSION );
        wp_register_style( 'h5ap-playlist', H5AP_PRO_PLUGIN_DIR .'dist/playlist.css', ['bplugins-plyrio'], H5AP_PRO_VERSION );

        wp_localize_script('h5ap-player', 'h5ap_i18n', LocalizeScript::translatedText());
        
        wp_localize_script('h5ap-player', 'h5apPlayer', [
            'speed' => explode(',', Functions::getSetting('speed', '0.5, 1, 1.5, 2.0, 2.5')),
            'multipleAudio' => (boolean) Functions::getSetting('multipleAudio', false),
            'plyrio_js' => H5AP_PRO_PLUGIN_DIR. 'js/player.js',
            'plyr_js' => H5AP_PRO_PLUGIN_DIR. 'dist/player.js',
        ]);

        wp_localize_script('h5ap-playlist', 'h5apPlayer', [
            'speed' => explode(',', Functions::getSetting('speed', '0.5, 1, 1.5, 2.0, 2.5')),
            'multipleAudio' => (boolean) Functions::getSetting('multipleAudio', false),
            'plyrio_js' => H5AP_PRO_PLUGIN_DIR. 'js/player.js',
            'plyr_js' => H5AP_PRO_PLUGIN_DIR. 'dist/player.js',
        ]);


        wp_localize_script('h5ap-all', 'h5apAll', [
            'speed' => explode(',', Functions::getSetting('speed', '0.5, 1, 1.5, 2.0, 2.5')),
            'multipleAudio' => (boolean) Functions::getSetting('multipleAudio', false),
            'plyrio_js' => H5AP_PRO_PLUGIN_DIR. 'js/player.js',
            'plyrio_css' => H5AP_PRO_PLUGIN_DIR . 'assets/css/player.min.css',
            'options' => [
                'controls' => Functions::getSetting('h5ap_controls', []),
                'preload' => Functions::getSetting('h5ap_preload', 'metadata'),
                'seekTime' => (int) Functions::getSetting('h5ap_seektime', 10),
            ]
        ]);

        if(Functions::getSetting('all_h5vp', false) && h5ap_fs()->can_use_premium_code()){
            wp_enqueue_script('h5ap-all');
        }
    }

    /**
     * Admin Assets
     */
    public function adminAssets($screen){
        $current_screen = get_current_screen();

		if($current_screen->post_type === 'audioplayer' || $screen === 'plugins.php'){
            wp_enqueue_style('h5ap-admin', H5AP_PRO_PLUGIN_DIR .'assets/css/style.css', array(), H5AP_PRO_VERSION);
			wp_enqueue_script('h5ap-admin',  H5AP_PRO_PLUGIN_DIR . 'dist/admin.js');
			wp_localize_script('h5ap-admin', 'h5apAdmin', array(
				'ajaxUrl' => admin_url('admin-ajax.php'),
				'website' => site_url()
			));
			wp_enqueue_style('h5ap-help', H5AP_PRO_PLUGIN_DIR . 'admin/css/style.css');
		}

        if ('settings_page_html5ap_settings'==$screen){
            $cm_settings['codeEditor'] = wp_enqueue_code_editor(array('type' => 'text/css'));
            wp_localize_script('jquery', 'cm_settings', $cm_settings);
            wp_enqueue_script('wp-theme-plugin-editor');
            wp_enqueue_style('wp-codemirror');
            wp_enqueue_script('h5ap-codemirror', H5AP_PRO_PLUGIN_DIR.'admin/js/codemirror-init.js', array('jquery'), H5AP_PRO_VERSION, true); 
        }

        $settings = get_option('h5ap_settings', []);

        wp_localize_script('h5ap-audioplayer-editor-script', 'h5apEditor', [
            'color' => [
                'primary' => $settings['h5ap_primary_color'] ?? '#4A5464',
                'bg' => $settings['h5ap_background_color'] ?? '#EEEEEE',
            ]
        ]);
    }
}
