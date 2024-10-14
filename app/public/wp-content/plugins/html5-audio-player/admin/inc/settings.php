<?php 

use H5APPlayer\Model\Pipe;
use H5APPlayer\Helper\Functions;
// Control core classes for avoid errors
if( class_exists( 'CSF' ) ) {

  //
  // Set a unique slug-like ID
  $prefix = 'h5ap_settings';
  

  //audio_player 
  // Create options
  CSF::createOptions( $prefix, array(
    // framework title
    'framework_title'         => 'Html5 Audio Player Settings',  
    'menu_title' => 'Settings',
    'menu_slug'  => 'html5-audio-player-settings',
    'menu_parent' => 'edit.php?post_type=audioplayer',
    'menu_type' => 'submenu',
    'theme' => 'light',
    'show_bar_menu' => false
  ) );

  if(!h5ap_fs()->can_use_premium_code()){
    CSF::createSection($prefix, array(
        'title' => '',
        'fields' => array(
            array(
                'type' => 'heading',
                'content' => '<p style="color:#7B2F31;background:#F8D7DA;padding:15px">HTML5 Audio Player Pro is not activated yet. Please active the license key by navigating to Plugins > HTML5 Audio Player Pro> Active License. 
                Once you activate the plugin you will get all the options availble here. </p>'
            ),
        ),
    ));
    return false;
  }

  //
  // Create a top-tab
  CSF::createSection( $prefix, array(
    'id'    => 'primary_tab', // Set a unique slug-like ID
    'title' => 'Quick Player',
    'fields' => array(
      array(
        'type' => 'heading',
        'content' => '[audio_player file="audio_file_url_here"]'
      ),
      array(
        'id' => 'h5ap_repeat',
        'title' => 'Repeat',
        'type' => 'button_set',
        'options' => array(
          'loop' => 'Repeat',
          'once' => 'Once'
        ),
        'default' => 'once'
      ),
      array(
        'id' => 'h5ap_muted',
        'title' => 'Muted',
        'type' => 'switcher',
        'default' => '0',
      ),
      array(
        'id' => 'h5ap_player_width',
        'title' => 'Width',
        'type' => 'dimensions',
        'height' => false,
        'default' => array(
          'width' => 100,
          'unit' => '%'
        ),
        'units' => array('%', 'px', 'em')
      ),
      array(
        'id' => 'h5ap_seektime',
        'title' => 'Seek Time',
        'type' => 'number',
        'default' => '10',
      ),
      array(
        'id' => 'h5ap_autoplay',
        'title' => 'Autoplay',
        'type' => 'switcher',
        'default' => '',
      ),
      array(
        'id'       => 'h5ap_controls',
        'type'     => 'button_set',
        'title'    => 'Control buttons and Components',    
        'multiple' => true,
        'options'  => array(
          'restart' => 'Restart',  
          'rewind'   => 'Rewind',    
          'play' => 'Play', 
          'fast-forward'   => 'Fast Forwards',
          'progress' => 'Progressbar',     
          'duration'   => 'Duration',
          'current-time'   => 'Current Time',
          'mute' => 'Mute Button',
          'volume' => 'Volume Control',
          'settings' => 'Setting Button',
          'download' => 'Download Button',
        ),
        'default'  => array('play','progress','current-time', 'mute','volume', 'settings'),
        'help'=> 'Click on the item to turn ON/OFF',
      ),
      array(
        'id'         => 'h5ap_preload',
        'type'       => 'radio',
        'title'      => 'Preload',
        'options'    => array(
          'auto' => 'Auto - Browser should load the entire audio file when the page loads.',
          'metadata' => 'Metadata - Browser should load only metadata when the page loads.',
          'none' => 'None - Browser should NOT load the audio file when the page loads.',
        ),
        'default'    => 'auto',
        ),
    )
  ) );

  //
  // Create a sub-tab
  CSF::createSection( $prefix, array(
    // 'parent' => 'primary_tab', // The slug id of the parent section
    'title'  => 'Color',
    'fields' => array(
      // A text field
      array(
        'type' => 'heading',
        'content' => 'Standard Player'
      ),
      array(
        'id'    => 'h5ap_primary_color',
        'type'  => 'color',
        'title' => 'Primary Color',
        'default' => '#4f5b5f'
      ),
      array(
        'id'    => 'h5ap_hover_color',
        'type'  => 'color',
        'title' => 'Hover Color',
        'default' => '#1aafff'
      ),
      array(
        'id'    => 'h5ap_background_color',
        'type'  => 'color',
        'title' => 'Background Color',
        'default' => '#fff'
      ),
      // array(
      //   'type' => 'heading',
      //   'content' => 'Playlist'
      // ),
      // array(
      //   'id'    => 'h5ap_playlist_primary_color',
      //   'type'  => 'color',
      //   'title' => 'Primary Color',
      //   'default' => '#4f5b5f'
      // ),
      // array(
      //   'id'    => 'h5ap_playlist_hover_color',
      //   'type'  => 'color',
      //   'title' => 'Hover Color',
      //   'default' => '#1aafff'
      // ),
      // array(
      //   'id'    => 'h5ap_playlist_background_color',
      //   'type'  => 'color',
      //   'title' => 'Background Color',
      //   'default' => '#fff'
      // ),
    )
  ) );

  //
  // Create a sub-tab
  CSF::createSection( $prefix, array(
    // 'parent' => 'primary_tab',
    'title'  => 'Custom CSS',
    'fields' => array(
      array(
        'id'    => 'h5ap_custom_css',
        'type'  => 'code_editor',
        'title' => 'Custom CSS',
        'mode' => 'css',
        'theme' => 'monikai'
      ),

    )
  ) );

  $settings = [
    'size' => Functions::getSetting('button_size', 25),
    'color' => Functions::getSetting('button_color', '#ffffff'),
    'background' => Functions::getSetting('button_background', '#000'),
    'dimention' => Functions::getSetting('dimention', ['width' => 50, 'height' => 50, 'unit' => 'px']),
    'radius' => Functions::getSetting('radius', ['width' => 50, 'unit' => 'px']),
  ];

  $settings = wp_json_encode($settings);
  $audio = get_site_url().'/wp-content/plugins/html5-audio-player-pro/assets/koyal-bird-voice.mp3';

  // Create a sub-tab
  CSF::createSection( $prefix, array(
    'title'  => 'Single Play Button Only',
    'fields' => array(
      array(
        'type' => 'content',
        'content' => "<div data-settings='$settings' class='h5ap_single_button' title='title will go here'><audio class=''><source src='$audio' type='audio/mp3'></audio><span class='play'><svg viewBox='0 0 163.861 163.861'> <path d='M34.857,3.613C20.084-4.861,8.107,2.081,8.107,19.106v125.637c0,17.042,11.977,23.975,26.75,15.509L144.67,97.275 c14.778-8.477,14.778-22.211,0-30.686L34.857,3.613z'/></svg></span><span class='pause'><svg version='1.1' viewBox='0 0 47.607 47.607'><path d='M17.991,40.976c0,3.662-2.969,6.631-6.631,6.631l0,0c-3.662,0-6.631-2.969-6.631-6.631V6.631C4.729,2.969,7.698,0,11.36,0 l0,0c3.662,0,6.631,2.969,6.631,6.631V40.976z'/> <path d='M42.877,40.976c0,3.662-2.969,6.631-6.631,6.631l0,0c-3.662,0-6.631-2.969-6.631-6.631V6.631 C29.616,2.969,32.585,0,36.246,0l0,0c3.662,0,6.631,2.969,6.631,6.631V40.976z'/></svg></span></div>"
      ),
      array(
        'type' => 'content',
        'content' => '<h3>[single_button file="file"]</h3>'
      ),
      array(
        'id'      => 'button_size',
        'type'    => 'number',
        'title'   => 'Font Size',
        'default' => 25,
        'unit' => 'px'
      ),
      array(
        'id'       => 'radius',
        'type'     => 'dimensions',
        'title'    => 'Border Radius',
        'default'  => array(
          'width'  => '50',
          'unit'   => '%',
        ),
        'height' => false,
        'width_icon' => 'radius'
      ),
      array(
        'id'    => 'button_color',
        'type'  => 'color',
        'title' => 'Button Color',
      ),
      array(
        'id'    => 'button_background',
        'type'  => 'color',
        'title' => 'Button Background',
      ),
      array(
        'id'       => 'dimention',
        'type'     => 'dimensions',
        'title'    => 'Height and Width ',
        'default'  => array(
          'width'  => '50',
          'height' => '50',
          'unit'   => 'px',
        ),
      ),
    )
  ) );

  //
  // Create a top-tab
  CSF::createSection( $prefix, array(
    // 'id'    => 'secondry_tab', // Set a unique slug-like ID
    'title' => 'Player Translation',
    'fields' => array(
      array(
        'id' => 'h5apt_restart',
        'title' => 'Restart',
        'type' => 'text',
        'default' => 'Restart',
      ),
      array(
        'id' => 'h5apt_rewind',
        'title' => 'Rewind {seektime}s',
        'type' => 'text',
        'default' => 'Rewind {seektime}s',
      ),
      array(
        'id' => 'h5apt_play',
        'title' => 'Play',
        'type' => 'text',
        'default' => 'Play',
      ),
      array(
        'id' => 'h5apt_pause',
        'title' => 'Pause',
        'type' => 'text',
        'default' => 'Pause',
      ),
      array(
        'id' => 'h5apt_forward_seektime',
        'title' => 'Forward {seektime}s',
        'type' => 'text',
        'default' => 'Forward {seektime}s',
      ),
      array(
        'id' => 'h5apt_seek',
        'title' => 'Seek',
        'type' => 'text',
        'default' => 'Seek',
      ),
      array(
        'id' => 'h5apt_currenttime_of_duration',
        'title' => '{currentTime} of {duration}',
        'type' => 'text',
        'default' => '{currentTime} of {duration}',
      ),
      array(
        'id' => 'h5apt_played',
        'title' => 'Played',
        'type' => 'text',
        'default' => 'Played',
      ),
      array(
        'id' => 'h5apt_buffered',
        'title' => 'Buffered',
        'type' => 'text',
        'default' => 'Buffered',
      ),
      array(
        'id' => 'h5apt_current_time',
        'title' => 'Current Time',
        'type' => 'text',
        'default' => 'Current Time',
      ),
      array(
        'id' => 'h5apt_duration',
        'title' => 'Duration',
        'type' => 'text',
        'default' => 'Duration',
      ),
      array(
        'id' => 'h5apt_volume',
        'title' => 'Volume',
        'type' => 'text',
        'default' => 'Volume',
      ),
      array(
        'id' => 'h5apt_mute',
        'title' => 'Mute',
        'type' => 'text',
        'default' => 'Mute',
      ),
      array(
        'id' => 'h5apt_unmute',
        'title' => 'Unmute',
        'type' => 'text',
        'default' => 'Unmute',
      ),
      array(
        'id' => 'h5apt_enable_captions',
        'title' => 'Enable captions',
        'type' => 'text',
        'default' => 'Enable captions',
      ),
      array(
        'id' => 'h5apt_disable_captions',
        'title' => 'Disable captions',
        'type' => 'text',
        'default' => 'Disable captions',
      ),
      array(
        'id' => 'h5apt_download',
        'title' => 'Download',
        'type' => 'text',
        'default' => 'Download',
      ),
      array(
        'id' => 'h5apt_enter_fullscreen',
        'title' => 'Enter fullscreen',
        'type' => 'text',
        'default' => 'Enter fullscreen',
      ),
      array(
        'id' => 'h5apt_exit_fullscreen',
        'title' => 'Exit fullscreen',
        'type' => 'text',
        'default' => 'Exit fullscreen',
      ),
      array(
        'id' => 'h5apt_player_for',
        'title' => 'Player for {title}',
        'type' => 'text',
        'default' => 'Player for {title}',
      ),
      array(
        'id' => 'h5apt_captions',
        'title' => 'Captions',
        'type' => 'text',
        'default' => 'Captions',
      ),
      array(
        'id' => 'h5apt_settings',
        'title' => 'Settings',
        'type' => 'text',
        'default' => 'Settings',
      ),
      array(
        'id' => 'h5apt_pip',
        'title' => 'PIP',
        'type' => 'text',
        'default' => 'PIP',
      ),
      array(
        'id' => 'h5apt_go_back',
        'title' => 'Go back to previous menu',
        'type' => 'text',
        'default' => 'Go back to previous menu',
      ),
      array(
        'id' => 'h5apt_speed',
        'title' => 'Speed',
        'type' => 'text',
        'default' => 'Speed',
      ),
      array(
        'id' => 'h5apt_normal',
        'title' => 'Normal',
        'type' => 'text',
        'default' => 'Normal',
      ),
      array(
        'id' => 'h5apt_quality',
        'title' => 'Quality',
        'type' => 'text',
        'default' => 'Quality',
      ),
      array(
        'id' => 'h5apt_loop',
        'title' => 'Loop',
        'type' => 'text',
        'default' => 'Loop',
      ),
      array(
        'id' => 'h5apt_start',
        'title' => 'Start',
        'type' => 'text',
        'default' => 'Start',
      ),
      array(
        'id' => 'h5apt_end',
        'title' => 'End',
        'type' => 'text',
        'default' => 'End',
      ),
      array(
        'id' => 'h5apt_all',
        'title' => 'All',
        'type' => 'text',
        'default' => 'All',
      ),
      array(
        'id' => 'h5apt_reset',
        'title' => 'Reset',
        'type' => 'text',
        'default' => 'Reset',
      ),
      array(
        'id' => 'h5apt_disabled',
        'title' => 'Disabled',
        'type' => 'text',
        'default' => 'Disabled',
      ),
      array(
        'id' => 'h5apt_enabled',
        'title' => 'Enabled',
        'type' => 'text',
        'default' => 'Enabled',
      ),
      array(
        'id' => 'h5apt_ad',
        'title' => 'Ad',
        'type' => 'text',
        'default' => 'Ad',
      ),
    )
  ) );

  CSF::createSection( $prefix, array(
    // 'parent' => 'primary_tab',
    'title'  => 'Search Form',
    'fields' => array(
      array(
        // 'id'    => 'h5ap_custom_css',
        'type'  => 'content',
        'title' => 'Search Form',
        'content' => '[h5ap_search_form]'
      ),
      array(
        // 'id'    => 'h5ap_custom_css',
        'type'  => 'content',
        'title' => 'Style',
        'content' => "[h5ap_search_form width='400px' placeholder='Search Audio']"
      ),

    )
  ) );

  CSF::createSection( $prefix, array(
    // 'parent' => 'primary_tab',
    'title'  => 'Settings',
    'fields' => array(
      array(
        'id'    => 'speed',
        'type'  => 'text',
        'title' => 'Speed',
        'default' => '0.5, 1, 1.5, 2.0, 2.5'
      ),
      array(
        'id' => 'multipleAudio',
        'type' => 'switcher',
        'title' => 'Multiple audio at the same time',
        'default' => false
      )

    )
  ) );
  
}
