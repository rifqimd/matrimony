<?php

/**
 * WordPress settings API demo class
 *
 * @author Tareq Hasan
 */
if ( !class_exists('WeDevs_Settings_API_Test' ) ):
class WeDevs_Settings_API_Test {

    private $settings_api;

    function __construct() {
        $this->settings_api = new WeDevs_Settings_API;

        add_action( 'admin_init', array($this, 'admin_init') );
        add_action( 'admin_menu', array($this, 'admin_menu') );
    }

    function admin_init() {

        //set the settings
        $this->settings_api->set_sections( $this->get_settings_sections() );
        $this->settings_api->set_fields( $this->get_settings_fields() );

        //initialize settings
        $this->settings_api->admin_init();
    }

    function admin_menu() {
        add_options_page( 'Html5 Audio Player Settings', 'Html5 Audio Player Settings', 'delete_posts', 'html5ap_settings', array($this, 'plugin_page') );
    }

    function get_settings_sections() {
        $sections = array(
            array(
                'id' => 'quick_player',
                'title' => __( 'Quick Player Configuration', 'wedevs' )
            ),
			array(
                'id' => 'wedevs_basics',
                'title' => __( 'Color Settings', 'wedevs' )
            ),
			array(
                'id' => 'style_settings',
                'title' => __( 'Style Settings', 'wedevs' )
            ),
			array(
                'id' => 'h5ap_translations',
                'title' => __( 'Player Translation', 'wedevs' )
            ),				
        );
        return $sections;
    }

    /**
     * Returns all the settings fields
     *
     * @return array settings fields
     */
    function get_settings_fields() {
        $settings_fields = array(
            'wedevs_basics' => array(
                array(
                    'name'    => 'color_one',
                    'label'   => __( 'Player Primary Color', 'wedevs' ),
                    'desc'    => __( 'Change the primary color of the player.', 'wedevs' ),
                    'type'    => 'color',
                    'default' => '#4f5b5f'
                ),
                array(
                    'name'    => 'color_two',
                    'label'   => __( 'Secondery Color ( Hover color )', 'wedevs' ),
                    'desc'    => __( 'Change the secondery color of the player.', 'wedevs' ),
                    'type'    => 'color',
                    'default' => '#1aafff'
                ),
                array(
                    'name'    => 'bg_color',
                    'label'   => __( 'Background Color', 'wedevs' ),
                    'desc'    => __( 'Change the background color of the player.', 'wedevs' ),
                    'type'    => 'color',
                    'default' => '#'
                ),				

            ),
			
			
			'quick_player' => array(
				array(
                    'name'    => 'repeat',
                    'label'   => __( 'Repeat', 'wedevs' ),
                    'desc'    => __( 'Select Loop to specify that the audio will start over again, every time it is finished', 'wedevs' ),
                    'type'    => 'radio',
                    'options' => array(
                        ''  => 'Repeat Once',
						'loop' => 'Loop'
                        
                    )
                ),
				array(
                    'name'  => 'muted',
                    'label' => __( 'Muted', 'wedevs' ),
                    'desc'  => __( 'Check if you want the audio output should be muted', 'wedevs' ),
                    'type'  => 'checkbox'
                ),
				array(
                    'name'  => 'autoplay',
                    'label' => __( 'Autoplay', 'wedevs' ),
                    'desc'  => __( ' Check if you want audio will start playing as soon as it is ready', 'wedevs' ),
                    'type'  => 'checkbox'
                ),
                array(
                    'name'              => 'width',
                    'label'             => __( 'Player Width', 'wedevs' ),
                    'desc'              => __( 'Define the width of the audio player, Enter 0 if you want the player width will cover the parents container.', 'wedevs' ),
                    'placeholder'       => __( '0', 'wedevs' ),
                    'min'               => 0,
                    'max'               => 50000,
                    'step'              => '1',
                    'type'              => 'number',
                    'default'           => '0',
                    'sanitize_callback' => 'floatval'
                ),
				array(
                    'name'  => 'restart',
                    'label' => __( 'Show Restart Button', 'wedevs' ),
                    'desc'  => __( 'Check if you want to show Restart button in the player.', 'wedevs' ),
                    'type'  => 'checkbox'
                ),
				array(
                    'name'  => 'rewind_button',
                    'label' => __( 'Show Rewind Button', 'wedevs' ),
                    'desc'  => __( 'Check if you want to show the rewind button in the player.', 'wedevs' ),
                    'type'  => 'checkbox'
                ),
				array(
                    'name'  => 'fast_forward_button',
                    'label' => __( 'Show Fast Forward Button', 'wedevs' ),
                    'desc'  => __( 'Check if you want to show the fast forward button in the player.', 'wedevs' ),
                    'type'  => 'checkbox'
                ),
                array(
                    'name'              => 'seek_time',
                    'label'             => __( 'Seek Time', 'wedevs' ),
                    'desc'              => __( 'The time, in seconds, to seek when a user hits fast forward or rewind. Deafult value is 10 Sec', 'wedevs' ),
                    'placeholder'       => __( '10', 'wedevs' ),
                    'min'               => 1,
                    'max'               => 50000,
                    'step'              => '1',
                    'type'              => 'number',
                    'default'           => '10',
                    'sanitize_callback' => 'intval'
                ),
				array(
                    'name'  => 'progress_bar',
                    'label' => __( 'Disable Progressbar', 'wedevs' ),
                    'desc'  => __( 'Check if you want to hide the progressbar in the player.', 'wedevs' ),
                    'type'  => 'checkbox'
                ),	
				array(
                    'name'  => 'duration',
                    'label' => __( 'Hide duration', 'wedevs' ),
                    'desc'  => __( 'Check if you want to hide the track duration in the player.', 'wedevs' ),
                    'type'  => 'checkbox'
                ),	
				array(
                    'name'  => 'current_time',
                    'label' => __( 'Show Current Time', 'wedevs' ),
                    'desc'  => __( 'Check if you wish to show the current time', 'wedevs' ),
                    'type'  => 'checkbox'
                ),	
				array(
                    'name'  => 'mute_button',
                    'label' => __( 'Hide Mute Button', 'wedevs' ),
                    'desc'  => __( 'Check if you want to hide the Mute button in the player.', 'wedevs' ),
                    'type'  => 'checkbox'
                ),	
				array(
                    'name'  => 'volume_hide',
                    'label' => __( 'Hide volume Control', 'wedevs' ),
                    'desc'  => __( 'Check if you want to hide the volume control in the player.', 'wedevs' ),
                    'type'  => 'checkbox'
                ),	
				array(
                    'name'  => 'setting',
                    'label' => __( 'Show Setting Button', 'wedevs' ),
                    'desc'  => __( 'Check if you want to show the Setting button in the player.', 'wedevs' ),
                    'type'  => 'checkbox'
                ),	
				array(
                    'name'  => 'download',
                    'label' => __( 'Hide Download Button', 'wedevs' ),
                    'desc'  => __( 'Check if you want to hide the audio download button in the player.', 'wedevs' ),
                    'type'  => 'checkbox'
                ),	
				array(
                    'name'    => 'preload',
                    'label'   => __( 'Preload', 'wedevs' ),
                    'desc'    => __( 'Specify how the audio file should be loaded when the page loads.', 'wedevs' ),
                    'type'    => 'radio',
					'default'           => 'auto',
                    'options' => array(
                        'auto'  => 'Auto - Browser should load the entire audio file when the page loads.',
						'metadata' => 'Metadata - Browser should load only metadata when the page loads.',
						'none' => 'None - Browser should NOT load the audio file when the page loads.',
                        
                    )
                ),				

            ),
            'style_settings' => array(
                array(
                    'name'    => 'custom_css',
                    'label'   => __( 'Custom CSS', 'wedevs' ),
                    'type'    => 'textarea',
                    'default' => '/*Your custom CSS code here*/'
                ),
            ),
            'h5ap_translations' => array(
                array(
                    'name'    => 'restart',
                    'label'   => __( 'Restart', 'wedevs' ),
                    'default' => 'Restart',
                    'type'    => 'text',					
                ),
                array(
                    'name'    => 'rewind ',
                    'label'   => __( 'Rewind {seektime}s', 'wedevs' ),
                    'default' => 'Rewind {seektime}s',
                    'type'    => 'text',					
                ),
                array(
                    'name'    => 'play',
                    'label'   => __( 'Play', 'wedevs' ),
                    'default' => 'Play',
                    'type'    => 'text',					
                ),
                array(
                    'name'    => 'pause',
                    'label'   => __( 'Pause', 'wedevs' ),
                    'default' => 'Pause',
                    'type'    => 'text',					
                ),
                array(
                    'name'    => 'fastForward',
                    'label'   => __( 'Forward {seektime}s', 'wedevs' ),
                    'default' => 'Forward {seektime}s',
                    'type'    => 'text',					
                ),
                array(
                    'name'    => 'seek',
                    'label'   => __( 'Seek', 'wedevs' ),
                    'default' => 'Seek',
                    'type'    => 'text',					
                ),
                array(
                    'name'    => 'seekLabel',
                    'label'   => __( '{currentTime} of {duration}', 'wedevs' ),
                    'default' => '{currentTime} of {duration}',
                    'type'    => 'text',					
                ),
                array(
                    'name'    => 'played',
                    'label'   => __( 'Played', 'wedevs' ),
                    'default' => 'Played',
                    'type'    => 'text',					
                ),
                array(
                    'name'    => 'buffered',
                    'label'   => __( 'Buffered', 'wedevs' ),
                    'default' => 'Buffered',
                    'type'    => 'text',					
                ),
                array(
                    'name'    => 'currentTime',
                    'label'   => __( 'Current time', 'wedevs' ),
                    'default' => 'Current time',
                    'type'    => 'text',					
                ),
                array(
                    'name'    => 'duration',
                    'label'   => __( 'Duration', 'wedevs' ),
                    'default' => 'Duration',
                    'type'    => 'text',					
                ),
                array(
                    'name'    => 'volume',
                    'label'   => __( 'Volume', 'wedevs' ),
                    'default' => 'Volume',
                    'type'    => 'text',					
                ),
                array(
                    'name'    => 'mute',
                    'label'   => __( 'Mute', 'wedevs' ),
                    'default' => 'Mute',
                    'type'    => 'text',					
                ),
                array(
                    'name'    => 'unmute',
                    'label'   => __( 'Unmute', 'wedevs' ),
                    'default' => 'Unmute',
                    'type'    => 'text',					
                ),
                array(
                    'name'    => 'enableCaptions',
                    'label'   => __( 'Enable captions', 'wedevs' ),
                    'default' => 'Enable captions',
                    'type'    => 'text',					
                ),
                array(
                    'name'    => 'disableCaptions',
                    'label'   => __( 'Disable captions', 'wedevs' ),
                    'default' => 'Disable captions',
                    'type'    => 'text',					
                ),
                array(
                    'name'    => 'download',
                    'label'   => __( 'Download', 'wedevs' ),
                    'default' => 'Download',
                    'type'    => 'text',					
                ),
                array(
                    'name'    => 'enterFullscreen',
                    'label'   => __( 'Enter fullscreen', 'wedevs' ),
                    'default' => 'Enter fullscreen',
                    'type'    => 'text',					
                ),
                array(
                    'name'    => 'exitFullscreen',
                    'label'   => __( 'Exit fullscreen', 'wedevs' ),
                    'default' => 'Exit fullscreen',
                    'type'    => 'text',					
                ),
                array(
                    'name'    => 'frameTitle',
                    'label'   => __( 'Player for {title}', 'wedevs' ),
                    'default' => 'Player for {title}',
                    'type'    => 'text',					
                ),
                array(
                    'name'    => 'captions',
                    'label'   => __( 'Captions', 'wedevs' ),
                    'default' => 'Captions',
                    'type'    => 'text',					
                ),
                array(
                    'name'    => 'settings',
                    'label'   => __( 'Settings', 'wedevs' ),
                    'default' => 'Settings',
                    'type'    => 'text',					
                ),
                array(
                    'name'    => 'pip',
                    'label'   => __( 'PIP', 'wedevs' ),
                    'default' => 'PIP',
                    'type'    => 'text',					
                ),
                array(
                    'name'    => 'menuBack',
                    'label'   => __( 'Go back to previous menu', 'wedevs' ),
                    'default' => 'Go back to previous menu',
                    'type'    => 'text',					
                ),	
                array(
                    'name'    => 'speed',
                    'label'   => __( 'Speed', 'wedevs' ),
                    'default' => 'Speed',
                    'type'    => 'text',					
                ),	
                array(
                    'name'    => 'normal',
                    'label'   => __( 'Normal', 'wedevs' ),
                    'default' => 'Normal',
                    'type'    => 'text',					
                ),	
                array(
                    'name'    => 'quality',
                    'label'   => __( 'Quality', 'wedevs' ),
                    'default' => 'Quality',
                    'type'    => 'text',					
                ),	
                array(
                    'name'    => 'loop',
                    'label'   => __( 'Loop', 'wedevs' ),
                    'default' => 'Loop',
                    'type'    => 'text',					
                ),	
                array(
                    'name'    => 'start',
                    'label'   => __( 'Start', 'wedevs' ),
                    'default' => 'Start',
                    'type'    => 'text',					
                ),	
                array(
                    'name'    => 'End',
                    'label'   => __( 'End', 'wedevs' ),
                    'default' => 'End',
                    'type'    => 'text',					
                ),	
                array(
                    'name'    => 'all',
                    'label'   => __( 'All', 'wedevs' ),
                    'default' => 'All',
                    'type'    => 'text',					
                ),	
                array(
                    'name'    => 'reset',
                    'label'   => __( 'Reset', 'wedevs' ),
                    'default' => 'Reset',
                    'type'    => 'text',					
                ),	
                array(
                    'name'    => 'disabled',
                    'label'   => __( 'Disabled', 'wedevs' ),
                    'default' => 'Disabled',
                    'type'    => 'text',					
                ),	
                array(
                    'name'    => 'enabled',
                    'label'   => __( 'Enabled', 'wedevs' ),
                    'default' => 'Enabled',
                    'type'    => 'text',					
                ),	
                array(
                    'name'    => 'advertisement',
                    'label'   => __( 'Ad', 'wedevs' ),
                    'default' => 'Ad',
                    'type'    => 'text',					
                ),	













				
            ),

			

        );

        return $settings_fields;
    }

    function plugin_page() {
        echo '<div class="wrap"><h2>Html5 Audio Player Settings</h2>';

        $this->settings_api->show_navigation();
        $this->settings_api->show_forms();

        echo '</div>';
    }

    /**
     * Get all the pages
     *
     * @return array page names with key value pairs
     */
    function get_pages() {
        $pages = get_pages();
        $pages_options = array();
        if ( $pages ) {
            foreach ($pages as $page) {
                $pages_options[$page->ID] = $page->post_title;
            }
        }

        return $pages_options;
    }

}
endif;
new WeDevs_Settings_API_Test();