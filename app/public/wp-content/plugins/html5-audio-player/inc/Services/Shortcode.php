<?php
namespace H5APPlayer\Services;
class Shortcode{
    protected static $_instance = null;

    /**
     * construct function
     */
    function register(){
        add_shortcode('audio_player', [$this, 'audioPlayer']);
    }

    /**
     * Create instance function
     */
    static function instance(){
        if(self::$_instance === null){
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * [audio_player] shotcode
     */
    function audioPlayer($attrs){
        extract( shortcode_atts( array(
            'id' => null,
            'file' => null,
            'src' => null,
            'width' => '100%',
            'controls' => null
        ), $attrs ) );
    
        wp_enqueue_style( 'h5ap-player');
        wp_enqueue_script( 'h5ap-player');

        $code_controls = $controls ? explode(',', $controls) : null;
    
        ob_start(); 
        
        if (empty($id)){$id=uniqid();}

        if($file){
            $src = $file;
        }

        if(empty($src)){
            return false;
        }

        $repeat = '';
        $autoplay = '';
        $preload = 'metadata';
        $muted = '';

        $controls = ['play','progress','current-time', 'mute','volume', 'settings'];
        
        $options = array(
            'controls' => $controls,
        );

        ?>
        <div class="skin_default" id="skin_default">
            <div class="h5ap_quick_player" data-options='<?php echo esc_html(wp_json_encode($options)) ?>' style="width:<?php echo esc_html($width); ?>">
                <audio playsinline controls class="player<?php echo esc_attr($id);?>" preload="<?php echo esc_html($preload); ?>" <?php echo esc_html($repeat.$autoplay.$muted); ?> >
                <source src="<?php echo esc_html($src); ?>" type="audio/mp3">
                Your browser does not support the audio element.
                </audio>
            </div>
        </div>
        <?php $output = ob_get_clean();return $output;?>
        <?php
    }
}
