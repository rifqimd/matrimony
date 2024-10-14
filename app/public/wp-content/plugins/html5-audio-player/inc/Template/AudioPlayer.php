<?php
namespace H5APPlayer\Template;

class AudioPlayer {

    public function register(){
        
    }

    public static function get($attrs){
        extract($attrs);

        wp_enqueue_script('h5ap-player');
        wp_enqueue_style('h5ap-player');

        $options = esc_attr(wp_json_encode(wp_parse_args( [
                'skin' =>   strtolower($skin),
                'controls' =>  self::controls($controls),
                'fusionDownload' =>   $download,
            ], compact('color', 'primaryColor', 'seekTime', 'repeat', 'title', 'artist', 'poster', 'bgColor', 'startTime') )));

        $type = self::type($source);
        $attributes = self::getAttrs($attrs);

        $loader = null;

        if($attrs['loader']){
            $loader = "<div class='h5ap_lp'>
            <div class='bar bar-1'></div>
            <div class='bar bar-1'></div>
        </div>";
        }


        return "<style>$CSS</style>
        <div id='$uniqueId' class='skin_".strtolower($skin)." h5ap-player'>
            <div class='h5ap_standard_player align$align' data-poster='$poster' data-song='$source' data-options='$options'>
            <audio src='$source' volume download='false' playsinline preload='metadata' $attributes>
                <source src='$source' type='$type'></source>
            </audio>
           $loader
            </div>
        </div>";

    }

    public static function type($src){
        $type = 'audio/mp3';
        $ext = pathinfo($src, PATHINFO_EXTENSION);
        if($ext === 'm4a'){
            $type = 'audio/mp4';
        }
        return $type;
    }

    public static function controls($controls){
        $newControls = [];
        foreach($controls as $control => $enabled){
            if($enabled){
                $newControls[] = $control;
            }
        }
        return $newControls;
    }

    public static function getAttrs($attrs){
        $attributes = '';
        if($attrs['autoplay']){
            $attributes .= 'autoplay';
        }
        if($attrs['repeat']){
            $attributes .= ' loop';
        }
        if($attrs['muted']){
            $attributes .= ' muted';
        }

        return $attributes;
    }
}