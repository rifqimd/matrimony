<?php
if(!defined('ABSPATH')) {
    return;
}
use H5APPlayer\Helper\Functions;

if(!class_exists('H5AP_Block')){
    class H5AP_Block{
        function __construct(){
            add_action('init', [$this, 'enqueue_script']);
            add_action('enqueue_block_assets', [$this, 'enqueue_block_assets']);
            add_action('enqueue_block_editor_assets', [$this, 'enqueue_block_editor_assets']);
        }


        function enqueue_block_editor_assets(){
            wp_register_style( 'h5ap-blocks', H5AP_PRO_PLUGIN_DIR. 'dist/blocks.css' , array('bplugins-plyrio', 'h5ap-player'), H5AP_PRO_VERSION );
        }

        function enqueue_block_assets(){ 
            // mp3 player
            wp_register_script( 'bpmp-mp3-player-script', plugins_url( 'dist/script.js', __FILE__ ), [], H5AP_PRO_VERSION, true ); // Frontend Script
            wp_register_style( 'bpmp-mp3-player-style', plugins_url( 'dist/style.css', __FILE__ ), [], H5AP_PRO_VERSION ); // Style
            wp_register_style( 'bpmp-mp3-player-editor-style', plugins_url( 'dist/editor.css', __FILE__ ), [ 'bpmp-mp3-player-style' ], H5AP_PRO_VERSION ); // Backend Style


            // plyrio library 
            wp_register_script( 'bplugins-plyrio', H5AP_PRO_PLUGIN_DIR. 'js/plyr-v3.7.2.js' , array(), '3.7.2', false );
            wp_register_style( 'bplugins-plyrio', H5AP_PRO_PLUGIN_DIR . 'assets/css/plyr-v3.7.2.css', array(), '3.7.2', 'all' );
            
            // single player
            wp_register_script( 'h5ap-player', H5AP_PRO_PLUGIN_DIR. 'dist/player.js' , array('jquery', 'bplugins-plyrio'), H5AP_PRO_VERSION, true );
            wp_register_style( 'h5ap-player', H5AP_PRO_PLUGIN_DIR. 'dist/player.css' , array('bplugins-plyrio'), H5AP_PRO_VERSION );

            

            // playlist
            wp_register_script( 'h5ap-playlist', H5AP_PRO_PLUGIN_DIR .'dist/playlist.js', ['bplugins-plyrio'], H5AP_PRO_VERSION );
            wp_register_style( 'h5ap-playlist', H5AP_PRO_PLUGIN_DIR .'dist/playlist.css', ['bplugins-plyrio'], H5AP_PRO_VERSION );

            wp_localize_script('h5ap-player', 'h5apPlayer', [
                'speed' => explode(',', Functions::getSetting('speed', '0.5, 1, 1.5, 2.0, 2.5')),
                'multipleAudio' => (boolean) Functions::getSetting('multipleAudio', false),
                'plyrio_js' => H5AP_PRO_PLUGIN_DIR. 'js/player.js',
                'plyr_js' => H5AP_PRO_PLUGIN_DIR. 'dist/player.js',
                'isPipe' => h5ap_fs()->can_use_premium_code()
            ]);

            

            if($this->has_block( 'h5ap/audioplaylist' ) || $this->has_block( 'h5ap/playlistnarrow' ) || $this->has_block( 'h5ap/playlistextensive' )){
                wp_enqueue_script('h5ap-playlist');
                wp_enqueue_style('h5ap-playlist');
            }


            if($this->has_block( 'h5ap/audioplayer', get_the_ID())){
                wp_enqueue_script('h5ap-player');
                wp_enqueue_style('h5ap-player');
            }
        }

        function enqueue_script(){

            register_block_type(H5AP_PRO_PATH .'blocks/audioplayer', array(
                'editor_style' => 'h5ap-blocks',
                'render_callback' => function($attrs){
                    return  H5APPlayer\Template\AudioPlayer::get($attrs);
                }
            ));

            register_block_type(H5AP_PRO_PATH .'blocks/audioplaylist', array(
                'editor_style' => 'h5ap-blocks',
                'render_callback' => function($attrs){

                    $infos = [
                        'autoplayNextTrack' => true
                    ];

                    ob_start();
                    ?>
                    <style><?php echo esc_html($attrs['CSS']); ?></style>
                    <div data-infos="<?php echo esc_attr(wp_json_encode($infos)); ?>" class="audioPlaylistCard h5ap_playlist" id="<?php echo esc_attr($attrs['uniqueId']) ?>" data-items="<?php echo esc_attr(wp_json_encode($attrs['audios'])) ?>">
                        <audio></audio>
                    </div>
                    <?php
                    return ob_get_clean();
                }
            ));

            register_block_type(H5AP_PRO_PATH .'blocks/playlist-narrow', array(
                'editor_style' => 'h5ap-blocks',
                'render_callback' => function($attrs){
                    extract($attrs);

                    $infos = [
                        'autoplayNextTrack' => true
                    ];

                    ob_start();

                    ?>
                    <style><?php echo esc_html($CSS); ?></style>
                    <div id="<?php echo esc_attr($uniqueId) ?>" class="h5ap_playlist align<?php echo esc_attr($align); ?>">
                        <div data-infos="<?php echo esc_attr(wp_json_encode($infos)); ?>" class="simplePlaylist audioPlaylist theme-<?php echo esc_attr( strtolower($theme)) ?>" data-items="<?php echo esc_attr(wp_json_encode( $audios )) ?>">
                            <audio></audio>
                            <ul>
                                <?php foreach($audios as $index => $audio){ ?>
                                    <li data-audio-item data-index=<?php echo esc_attr($index) ?>>
                                        <span class="title"><?php echo esc_html($audio['title']); ?></span>
                                        <?php if($audio['artist']){ ?>
                                            <span class='artist'>by <?php echo esc_html($audio['artist']) ?></span>
                                        <?php } ?>
                                        <?php if($hideDownload){ ?>
                                            <a class="download" download href={source}>
                                                <svg role="presentation" focusable="false">
                                                    <use href="#plyr-download"></use>
                                                </svg>
                                            </a>
                                        <?php } ?>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                    <?php
                    return ob_get_clean();
                }
            ));

            register_block_type(H5AP_PRO_PATH .'blocks/playlist-extensive', array(
                'editor_style' => 'h5ap-blocks',
                'render_callback' => function($attrs){
                    $infos = [
                        'autoplayNextTrack' => true
                    ];
                    ob_start();
                    ?>
                    <style><?php echo esc_html($attrs['CSS']) ?></style>
                    <div id="<?php echo esc_attr($attrs['uniqueId']) ?>" class="h5ap_playlist">
                        <div data-infos="<?php echo esc_attr(wp_json_encode($infos)); ?>" class="bluePlaylist hextensive-<?php echo strtolower(esc_attr($attrs['theme'])) ?>" data-items="<?php echo esc_attr(wp_json_encode($attrs['audios'])) ?>">
                            <audio></audio>
                        </div>
                    </div>
                    <?php
                    return ob_get_clean();
                }
            ));

            
            register_block_type( H5AP_PRO_PATH .'blocks/mp3-player', [
                'editor_style'		=> 'bpmp-mp3-player-style',
                'render_callback'	=> [$this, 'render']
            ] ); // Register Block

            if(class_exists('Functions')){
                wp_localize_script('h5ap-blocks', 'h5apPlayer', [
                    'speed' => explode(',', Functions::getSetting('speed', '0.5, 1, 1.5, 2.0, 2.5')),
                    'multipleAudio' => (boolean) Functions::getSetting('multipleAudio', false),
                ]);
                
                wp_localize_script('h5ap-playlist', 'h5apPlayer', [
                    'speed' => explode(',', Functions::getSetting('speed', '0.5, 1, 1.5, 2.0, 2.5')),
                    'multipleAudio' => (boolean) Functions::getSetting('multipleAudio', false),
                ]);
            }
        }

        function has_block( $block_name ){
            if( get_the_ID() ){
                if(has_block($block_name, get_the_ID())){
                    return true;
                }else if ( has_block( 'block', get_the_ID() ) ){
                    // Check reusable blocks
                    $content = get_post_field( 'post_content', get_the_ID() );
                    $blocks = parse_blocks( $content );
        
                    if ( !is_array( $blocks ) || empty( $blocks ) ) {
                        return false;
                    }
        
                    foreach ( $blocks as $block ) {
                        if ( $block['blockName'] === 'core/block' && ! empty( $block['attrs']['ref'] ) ) {
                            if( has_block( $block_name, $block['attrs']['ref'] ) ){
                                return true;
                            }
                        }
                    }
                }
            }

            return false;
	    }

        function render( $attributes ){
            extract( $attributes );
    
            // Enqueue assets where has block
            wp_enqueue_script( 'bpmp-mp3-player-script' );
            wp_enqueue_style( 'bpmp-mp3-player-style' );
    
            $className = $className ?? '';
            $blockClassName = 'wp-block-bpmp-mp3-player ' . $className . ' align' . $align;
    
            $styles = "#bpMp3Player-$cId { text-align: $alignment; } #bpMp3Player-$cId .bpMp3Player { width: $width; }";

            $infos = [
                'autoplayNextTrack' => true
            ];
    
            ob_start(); ?>

            <div class='<?php echo esc_attr( $blockClassName ); ?>' data-infos="<?php echo esc_attr(wp_json_encode($infos)) ?>" id='bpMp3Player-<?php echo esc_attr( $cId ); ?>' data-attributes='<?php echo esc_attr( wp_json_encode( $attributes ) ); ?>'>
                <style><?php echo esc_html( $styles ); ?></style>
    
                <div class='bpMp3Player'>
                    <div class='coverBox'>
                        <img id='cover' />
                    </div>
    
                    <div class='contentBox'>
                        <audio id='disc'></audio>
            
                        <div class='info'>
                            <h2 id='title'></h2>
                            <h3 id='artist'></h3>
    
                            <div id='progressContainer'>
                                <div id='progress'></div>
                            </div>
    
                            <div class='timeBar'>
                                <span id='timer'>0:00</span>
                                <span id='duration'></span>
                            </div>
                        </div>
    
                        <div class='controls'>
                            <span class='prevBtn'>
                                <svg xmlns='http://www.w3.org/2000/svg' class='navBtn' id='prev' viewBox='0 0 512 512'>
                                    <path d='M11.5 280.6l192 160c20.6 17.2 52.5 2.8 52.5-24.6V96c0-27.4-31.9-41.8-52.5-24.6l-192 160c-15.3 12.8-15.3 36.4 0 49.2zm256 0l192 160c20.6 17.2 52.5 2.8 52.5-24.6V96c0-27.4-31.9-41.8-52.5-24.6l-192 160c-15.3 12.8-15.3 36.4 0 49.2z' />
                                </svg>
                            </span>
                            <span class='playPauseBtn'>
                                <svg xmlns='http://www.w3.org/2000/svg' class='playBtn' id='play' viewBox='0 0 448 512'>
                                    <path class='playPath' d='M424.4 214.7L72.4 6.6C43.8-10.3 0 6.1 0 47.9V464c0 37.5 40.7 60.1 72.4 41.3l352-208c31.4-18.5 31.5-64.1 0-82.6z' />
                                    <path class='pausePath' d='M144 479H48c-26.5 0-48-21.5-48-48V79c0-26.5 21.5-48 48-48h96c26.5 0 48 21.5 48 48v352c0 26.5-21.5 48-48 48zm304-48V79c0-26.5-21.5-48-48-48h-96c-26.5 0-48 21.5-48 48v352c0 26.5 21.5 48 48 48h96c26.5 0 48-21.5 48-48z'
                                />
                                </svg>
                            </span>
                            <span class='nextBtn'>
                                <svg xmlns='http://www.w3.org/2000/svg' class='navBtn' id='next' viewBox='0 0 512 512'>
                                    <path d='M500.5 231.4l-192-160C287.9 54.3 256 68.6 256 96v320c0 27.4 31.9 41.8 52.5 24.6l192-160c15.3-12.8 15.3-36.4 0-49.2zm-256 0l-192-160C31.9 54.3 0 68.6 0 96v320c0 27.4 31.9 41.8 52.5 24.6l192-160c15.3-12.8 15.3-36.4 0-49.2z' />
                                </svg>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
    
            <?php return ob_get_clean();
        } // Render

    }

    new H5AP_Block();
}
