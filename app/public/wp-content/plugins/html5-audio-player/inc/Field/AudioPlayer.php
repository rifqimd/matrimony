<?php
namespace H5APPlayer\Field;

use H5APPlayer\Model\Pipe;

class AudioPlayer{

    public function register(){

        if (!class_exists('CSF')){
            return false;
        }

        $prefix = '_h5ap_plyr';
        \CSF::createMetabox($prefix, array(
            'title' => 'Player Configuration',
            'post_type' => 'audioplayer',
        ));


        $this->configure($prefix);

    }

    public function configure($prefix){
      
      \CSF::createSection($prefix, array(
        'fields' => array(
          
          array(
            'id' => 'h5vp_default_audio',
            'type' => 'upload',
            'title' => 'Audio source',
            'library' => 'audio',
            'dependency' => array(
              'h5ap_player_type',
              '!=',
              'opt-2'
            ) ,
            'placeholder' => 'http://',
            'button_title' => 'Add Audio',
            'remove_title' => 'Remove Audio',
          ),
          array(
            'id' => 'width',
            'type' => 'dimensions',
            'height' => false,
            'units' => array(
              'px',
              '%'
            ) ,
            'title' => 'Player Width',
            'default' => array(
              'width' => '100',
              'unit' => '%',
            ) ,
            'dependency' => array(
              'h5ap_player_type',
              '==',
              'opt-1',
              'all'
            )
          ),
         
          array(
            'id' => 'autoplay',
            'type' => 'switcher',
            'title' => esc_html__('AutoPlay', 'h5ap') ,
            'desc' => 'AutoPlay will only work if you keep the player muted according the the latest autoplay policy. <a href="https://developers.google.com/web/updates/2017/09/autoplay-policy-changes" target="_blank" >Read More</a>',
            'default' => false,
            'dependency' => array('h5ap_player_type','==','opt-1')
          ),
          array(
            'id' => 'repeat',
            'type' => 'switcher',
            'title' => esc_html__('Repeat', 'h5ap') ,
            'default' => '0',
            'dependency' => array(
              'h5ap_player_type',
              '!=',
              'opt-2',
              'all'
            ),
          ),

          array(
            'id' => 'disable_loader',
            'type' => 'switcher',
            'title' => esc_html__('Disable Loader', 'h5ap'),
            'desc' => 'Enable this option if you want to disable the loading animation',
            'default' => '0',
            'dependency' => array('h5ap_player_type','==','opt-1')
          ),
          array(
            'id' => 'h5ap_player_type',
            'type' => 'button_set',
            'title' => 'Player Type',
            'class' => 'abu-button-set-trigger bplugins-meta-readonly', // IMPORTANT Add a classname to button set.
            'options' => array(
              'opt-1' => 'Standard Player',
              'opt-2' => 'Playlist Player',
              'opt-3' => 'Sticky Player',
            ) ,
            'default' => 'opt-1',
          ), 
          
          array(
            'id' => 'sticky_poster',
            'type' => 'upload',
            'class' => 'bplugins-meta-readonly',
            'library' => 'image',
            'title' => esc_html__('Poster', 'h5ap') ,
            'button_title' => esc_html__('Add or Upload Poster Image', 'h5ap') ,
            'remove_title' => esc_html__('Remove', 'h5ap') ,
            'desc' => esc_html__('100x100 px photo is the standard poster size, accepted file type .png, .jpeg, .jpg ', 'h5ap') ,
            'dependency' => array(
              'h5ap_player_type',
              '!=',
              'opt-2'
            ) ,
          ),
          array(
            'id' => 'title',
            'type' => 'text',
            'class' => 'bplugins-meta-readonly',
            'title' => esc_html__('Title', 'h5ap') ,
            'default' => 'Audio Title',
            'desc' => esc_html__('Enter the title of the audio', 'h5ap') ,
            'dependency' => array(
              'h5ap_player_type',
              '!=',
              'opt-2'
            ) ,
          ),
          array(
            'id' => 'author',
            'type' => 'text',
            'class' => 'bplugins-meta-readonly',
            'title' => esc_html__('Author', 'h5ap') ,
            'default' => 'Author Name',
            'desc' => esc_html__('Enter the author of the audio', 'h5ap') ,
            'dependency' => array(array( 'h5ap_player_type', '==', 'opt-1'), array( 'standard_skin', '==', 'wave')),
          ) ,
          array(
            'id' => 'standard_skin',
            'type' => 'button_set',
            'title' => 'Player Skin',
            'class' => 'bplugins-meta-readonly',
            'options' => array(
              'default' => 'Default',
              'fusion' => 'Fusion',
              'stamp' => 'Stamp',
              'wave' => 'Wave'
            ) ,
            'default' => 'default',
          ) ,
          array(
            'id' => 'background',
            'type' => 'color',
            'class' => 'bplugins-meta-readonly',
            'title' => 'Background color',
            'default' => '#333',
            'dependency' => array('h5ap_player_type|standard_skin','==|any','opt-1|wave'
            ) ,
          ),
          
    
          array(
            'id' => 'disable_pause',
            'type' => 'switcher',
            'class' => 'bplugins-meta-readonly',
            'title' => esc_html__('Disable Pause', 'h5ap'),
            'desc' => 'Enable this option if you want user can\'t pause the audio',
            'default' => '0',
            'dependency' => array('h5ap_player_type','==','opt-1')
          ),
    
    
          array(
            'id' => 'controls',
            'type' => 'button_set',
            'class' => 'bplugins-meta-readonly',
            'title' => 'Control buttons and Components',
            'multiple' => true,
            'options' => array(
              'restart' => 'Restart',
              'rewind' => 'Rewind',
              'play' => 'Play',
              'fast-forward' => 'Fast Forwards',
              'progress' => 'Progressbar',
              'duration' => 'Duration',
              'current-time' => 'Current Time',
              'mute' => 'Mute Button',
              'volume' => 'Volume Control',
              'settings' => 'Setting Button',
              'download' => 'Download Button',
            ) ,
            'default' => array(
              'play',
              'progress',
              'duration',
              'mute',
              'volume',
              'settings'
            ) ,
            'help' => 'Click on the item to turn ON/OFF',
            'dependency' => array(
              'h5ap_player_type|standard_skin',
              '==|==',
              'opt-1|default',
              'all'
            )
          ),

          array(
            'id' => 'seektime',
            'type' => 'number',
            'class' => 'bplugins-meta-readonly',
            'title' => 'Seek time',
            'unit' => 'sec',
            'output' => '.heading',
            'output_mode' => 'width',
            'default' => 500,
            'default' => 10,
            'dependency' => array(
              'h5ap_player_type',
              '==',
              'opt-1',
              'all'
            ) ,
            'help' => 'The time, in seconds, to seek when a user hits fast forward or rewind. Deafult value is 10 Sec',
            'desc' => 'The time, in seconds, to seek when a user hits fast forward or rewind. Deafult value is 10 Sec'
          ) ,
          array(
            'id' => 'preload',
            'type' => 'radio',
            'class' => 'bplugins-meta-readonly',
            'title' => 'Preload',
            'options' => array(
              'auto' => 'Auto - Browser should load the entire audio file when the page loads.',
              'metadata' => 'Metadata - Browser should load only metadata when the page loads.',
              'none' => 'None - Browser should NOT load the audio file when the page loads.',
            ) ,
            'default' => 'auto',
            'dependency' => array('h5ap_player_type','==','opt-1')
          ),
    
          array(
            'id' => 'radius',
            'type' => 'slider',
            'class' => 'bplugins-meta-readonly',
            'title' => 'Border radius',
            'desc' => 'Defines the radius of the Player\'s corners.',
            'min' => 0,
            'max' => 50,
            'step' => 1,
            'unit' => 'px',
            'default' => 10,
            'dependency' => array('h5ap_player_type','==','opt-1')
          ) ,
          //playlist
          array(
            'id' => 'playlist_type',
            'type' => 'button_set',
            'title' => 'Playlist ',
            'options' => array(
              'create' => 'Create Playlist',
              'select' => 'Select From playlist',
            ) ,
            'default' => 'create',
            'dependency' => array('h5ap_player_type','==','opt-2') ,
          ),
    
          array(
            'id' => 'playlist_in_metabox',
            'type' => 'group',
            'title' => 'Create Playlist',
            // 'desc' => 'Please click on the + icon to add playlist items',
            'fields' => array(

              array(
                'id' => 'pl_audio_title',
                'type' => 'text',
                'title' => 'Title',
                'placeholder' => 'Enter the audio title here',
              ),

              array(
                'id' => 'pl_audio_file',
                'type' => 'upload',
                'title' => 'Source',
                'library' => 'audio',
                'placeholder' => 'http://',
                'button_title' => 'Add Audio',
                'remove_title' => 'Remove Audio',
              ),
    
              array(
                'id' => 'pl_audio_poster',
                'type' => 'upload',
                'title' => 'Poster image',
                'library' => 'image',
                'placeholder' => 'http://',
                'button_title' => 'Add poster',
                'remove_title' => 'Remove poster',
              ),

              array(
                'id' => 'pl_audio_artist',
                'type' => 'text',
                'title' => 'Artist',
                'placeholder' => 'Enter the artists name here',
              ) ,
    
            ) ,
            'dependency' => array('h5ap_player_type|playlist_type','==|==','opt-2|create')
          ) ,
    
          // Select with CPT (custom post type) pages
          array(
            'id' => 'selected_audio',
            'type' => 'select',
            'title' => 'Select audio',
            'placeholder' => 'Select audio',
            'ajax' => false,
            'options' => 'posts',
            'query_args' => array(
              'post_type' => 'audiolist'
            ) ,
            'multiple' => true,
            'chosen' => true,
            'dependency' => array(
              'h5ap_player_type|playlist_type',
              '==|==',
              'opt-2|select',
              'all'
            )
          ),
    
          array(
            'id' => 'plp_autoplay_next_track',
            'type' => 'switcher',
            'title' => __("Autoplay next track", 'h5ap'),
            'default' => true,
            'dependency' => array('h5ap_player_type','==','opt-2'),
          ),

          array(
            'id' => 'playlist_hide_download',
            'type' => 'switcher',
            'title' => __('Hide Download', 'h5ap'),
            'default' => 0,
            'dependency' => array('h5ap_player_type','==','opt-2'),
          ),

          array(
            'id' => 'player_skin',
            'type' => 'button_set',
            'title' => 'Player Skin',
            'multiple' => false,
            'options' => array(
              'narrow' => 'Narrow',
              'extensive' => 'Extensive',
            ) ,
            'default' => array('narrow'),
            'dependency' => array('h5ap_player_type','==','opt-2') ,
          ) ,
          array(
            'id' => 'player_theme',
            'type' => 'button_set',
            'title' => 'Player Theme',
            'multiple' => false,
            'options' => array(
              'light' => 'Light',
              'dark' => 'Dark',
              'custom' => 'Custom'
            ) ,
            'default' => array(
              'dark'
            ) ,
            'dependency' => array(
              'h5ap_player_type',
              '==',
              'opt-2',
              'all'
            ) ,
          ) ,
    
          array(
            'id'       => 'narrow_controls',
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
            ),
            'default'  => array('play','progress','current-time', 'mute','volume', 'settings'),
            'help'=> 'Click on the item to turn ON/OFF',
            'dependency' => array(
              'h5ap_player_type|player_skin',
              '==|==',
              'opt-2|narrow',
              'all'
            )
          ),

          array(
            'id' => 'forward_rewind_change_audio',
            'type' => 'switcher',
            'title' => __("Use forward/rewind button to change audio", "h5ap"),
            'dependency' => array(
              'h5ap_player_type',
              '==',
              'opt-2',
              'all'
            )
          ),
    
          array(
            'id' => 'narrow_custom_brand_color',
            'type' => 'color',
            'default' => '#19BAFF',
            'title' => esc_html__('Brand Color', 'h5ap') ,
            'dependency' => array(
              'h5ap_player_type|player_theme',
              '==|==',
              'opt-2|custom',
              'all'
            )
          ),
          array(
            'id' => 'narrow_custom_bg',
            'type' => 'color',
            'default' => '#222',
            'title' => esc_html__('Background', 'h5ap') ,
            'dependency' => array(
              'h5ap_player_type|player_theme|player_skin',
              '==|==',
              'opt-2|custom|narrow',
              'all'
            )
          ),
          array(
            'id' => 'narrow_custom_color',
            'type' => 'color',
            'default' => '#fff',
            'title' => esc_html__('Item Text Color', 'h5ap') ,
            'dependency' => array(
              'h5ap_player_type|player_theme',
              '==|==',
              'opt-2|custom',
              'all'
            )
          ),
          array(
            'id' => 'narrow_custom_hover_bg',
            'type' => 'color',
            'default' => '#30336b',
            'title' => esc_html__('Item Hover Background', 'h5ap') ,
            'dependency' => array(
              'h5ap_player_type|player_theme',
              '==|==',
              'opt-2|custom',
              'all'
            )
          ),
          array(
            'id' => 'narrow_custom_hover_color',
            'type' => 'color',
            'default' => '#fff',
            'title' => esc_html__('Item Hover Text Color', 'h5ap') ,
            'dependency' => array('h5ap_player_type|player_theme', '==|==', 'opt-2|custom', 'all')
          ),
          array(
            'id' => 'narrow_odd_bg',
            'type' => 'color',
            'default' => '#3e4243',
            'title' => esc_html__('Odd Item Background', 'h5ap') ,
            'dependency' => array('h5ap_player_type|player_theme|player_skin', '==|==', 'opt-2|custom|narrow', 'all')
          ),
          array(
            'id' => 'narrow_even_bg',
            'type' => 'color',
            'default' => '#1f1f1f',
            'title' => esc_html__('Even Item Background', 'h5ap') ,
            'dependency' => array('h5ap_player_type|player_theme|player_skin', '==|==', 'opt-2|custom|narrow', 'all')
          ),

          array(
            'id' => 'narrow_radius',
            'type' => 'slider',
            'title' => 'Border radius',
            'desc' => 'Defines the radius of the Player\'s corners.',
            'min' => 0,
            'max' => 50,
            'step' => 1,
            'unit' => 'px',
            'default' => 0,
            'dependency' => array( 'h5ap_player_type|player_theme|player_skin', '==|==', 'opt-2|custom|narrow', 'all' )
          ),
    
          array(
            'id' => 'plp_width',
            'type' => 'slider',
            'title' => 'Player Width',
            'min' => 150,
            'max' => 1500,
            'step' => 1,
            'unit' => 'px',
            'default' => 500,
            'dependency' => array( 'h5ap_player_type', '==', 'opt-2', 'all'),
          ),

          array(
            'id' => 'plp_align',
            'type' => 'button_set',
            'class' => 'bplugins-meta-readonly',
            'title' => 'Player Aligment',
            'options' => [
              'start' => 'Left',
              'center' => 'Center',
              'end' => 'Right'
            ],
            'default' => 'center'
          ),
          array(
            'id' => 'plp_volume',
            'type' => 'slider',
            'title' => 'Initial Volume',
            'min' => 0,
            'max' => 100,
            'step' => 1,
            'unit' => '%',
            'default' => 50,
            'help' => 'Set the initial volume of the player',
            'dependency' => array(
              'h5ap_player_type',
              '==',
              'opt-2',
              'all'
            ),
          ) ,
    
          // STICKY PLAYER
          array(
            'id' => 'sticky_download',
            'type' => 'switcher',
            'title' => esc_html__('Download Button', 'h5ap') ,
            'default' => 0,
            'dependency' => array(
              array('h5ap_player_type','==','opt-3'),
            ) ,
          ),

          array(
            'id' => 'fusion_download',
            'type' => 'switcher',
            'title' => esc_html__('Download Button', 'h5ap') ,
            'default' => 1,
            'dependency' => array(
              array('h5ap_player_type|standard_skin','==|==','opt-1|fusion')
            ) ,
          ),

          array(
            'id' => 'sticky_volume',
            'type' => 'slider',
            'class' => 'bplugins-meta-readonly',
            'title' => esc_html__('Initial Volume', 'h5ap') ,
            'default' => '65',
            'min' => '0',
            'max' => '100',
            'unit' => '%',
            'dependency' => array(
              'h5ap_player_type',
              '==',
              'opt-3',
              'all'
            ) ,
          ) ,
          
        )
    ));
    }
}


// require_once (__DIR__ . '/song-meta.php');

