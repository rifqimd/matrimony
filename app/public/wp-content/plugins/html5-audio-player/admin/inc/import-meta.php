<?php

 function h5ap_import_data_ajax(){
    h5ap_import_data();
    h5ap_import_settings();
    echo wp_json_encode(array(
        'success' => true,
    ));
    die();
}
add_action("wp_ajax_h5ap_import_data", 'h5ap_import_data_ajax');

function h5ap_import_data(){
    $players = new WP_Query(array(
        'post_type' => 'audioplayer',
        'post_status' => 'any',
        'posts_per_page' => -1
    ));

    while ($players->have_posts()): $players->the_post();

        $id = get_the_ID();
        // $_h5ap_plyr = get_post_meta($id, '_h5ap_plyr', true);
        $source = get_post_meta($id, '_ahp_audio-file', true);
        $repeat = get_post_meta($id, '_ahp_audio-repeat', true) === 'loop' ? '1' : '0';
        $muted = get_post_meta($id, '_ahp_audio-muted', true) === 'on' ? '1' : '0';
        $autoplay = get_post_meta($id, '_ahp_audio-autoplay', true) === 'on' ? '1' : '0';
        $width = get_post_meta($id, '_ahp_audio-size', true);
        $width_unit = 'px';
        $matches[0][0] = 300;
        preg_match_all('!\d+!', $width, $matches);
        if(is_array($matches[0]) && count($matches[0]) < 1){
            $matches[0][0] = 100;
            $width_unit = '%';
        }
        $fast_forward = get_post_meta($id, '_ahp_fast_forward', true) === 'on' ? 'true': 'false';
        $rewind = get_post_meta($id, '_ahp_rewin_button', true) === 'on' ? 'true': 'false';
        $seek_time = get_post_meta($id, '_ahp_seek_time', true);
        $restart = get_post_meta($id, '_ahp_restart_button', true) === 'on' ? 'true': 'false';
        $progressbar = get_post_meta($id, '_ahp_progress_bar', true) === 'on' ? 'false': 'true';
        $duration = get_post_meta($id, '_ahp_duration', true) === 'on' ? 'false': 'true';
        $current_time = get_post_meta($id, '_ahp_current_time', true) === 'on' ? 'true': 'false';
        $mute = get_post_meta($id, '_ahp_mute_button', true) === 'on' ? 'false': 'true';
        $volume = get_post_meta($id, '_ahp_volume', true) === 'on' ? 'false': 'true';
        $settings = get_post_meta($id, '_ahp_setting_button', true) === 'on' ? 'true': 'false';
        $download = get_post_meta($id, '_ahp_download_button', true) === 'on' ? 'false': 'true';
        $preload = get_post_meta($id, '_ahp_preload', true);

        

        $controls = [];
        if($restart === 'true'){
            array_push($controls, 'restart');
        }
        if($rewind === 'true'){
            array_push($controls, 'rewind');
        }
        array_push($controls, 'play');
        if($fast_forward === 'true'){
            array_push($controls, 'fast-forward');
        }
        if($progressbar === 'true'){
            array_push($controls, 'progress');
        }
        if($duration === 'true'){
            array_push($controls, 'duration');
        }
        if($current_time === 'true'){
            array_push($controls, 'current-time');
        }
        if($mute === 'true'){
            array_push($controls, 'mute');
        }
        if($volume === 'true'){
            array_push($controls, 'volume');
        }
        if($settings === 'true'){
            array_push($controls, 'settings');
        }
        if($download === 'true'){
            array_push($controls, 'download');
        }

        $newData = array(
            'h5ap_player_type' => 'opt-1',
            'h5vp_default_audio' => $source,
            'sticky_poster' => '',
            'title' => '',
            'standard_skin' => 'default',
            'disable_download' => '0',
            'color' => 'skyblue',
            'muted' => $muted,
            'autoplay' => $autoplay,
            'width' => array(
                    'width' => $matches[0][0],
                    'unit' => $width_unit,
                ),
            'controls' => $controls,
            'seektime' => $seek_time,
            'preload' => $preload,
            'radius' => 0,
            'playlist_type' => 'create',
            'playlist_in_metabox' => [],
            'selected_audio' => [],
            'plp_autoplay' => '',
            'player_skin' => 'narrow',
            'player_theme' => 'light',
            'plp_width' => 500,
            'plp_volume' => 50,
            'repeat' => $repeat,
            'download' => '0',
            'sticky_volume' => 65,
        );

        // echo "<pre>";
        // echo "ID: $id";
        // print_r($_h5ap_plyr);
        // print_r($newData);
        // echo "</pre>";

        if (false == metadata_exists('post', $id, '_h5ap_plyr')) {
            update_post_meta($id, '_h5ap_plyr', $newData);
        }
    endwhile;
}

function h5ap_import_settings(){
    $updateSetting = get_option('h5ap_settings');
    $quick = (array)get_option('quick_player');
    $translation = (array)get_option('h5ap_translations');
    $color = (array)get_option('wedevs_basics');
    $custom_css = (array)get_option('style_settings');


    $repeat = get_o_option($quick, 'repeat');
    $muted = get_o_option($quick, 'muted');
    $autoplay = get_o_option($quick, 'autoplay');
    $width = get_o_option($quick, 'width');
    $fast_forward = get_o_option($quick, 'fast_forward_button') === 'on' ? 'true': 'false';
    $rewind = get_o_option($quick, 'rewind_button') === 'on' ? 'true': 'false';
    $seek_time = get_o_option($quick, 'seek_time');
    $restart = get_o_option($quick, 'restart') === 'on' ? 'true': 'false';
    $progressbar = get_o_option($quick, 'progress_bar') === 'on' ? 'false': 'true';
    $duration = get_o_option($quick, 'duration') === 'on' ? 'false': 'true';
    $current_time = get_o_option($quick, 'current_time') === 'on' ? 'true': 'false';
    $mute = get_o_option($quick, 'mute_button') === 'on' ? 'false': 'true';
    $volume = get_o_option($quick, 'volume_hide') === 'on' ? 'false': 'true';
    $settings = get_o_option($quick, 'setting') === 'on' ? 'true': 'false';
    $download = get_o_option($quick, 'download') === 'on' ? 'false': 'true';
    $preload = get_o_option($quick, 'preload');

    
    $controls = [];
    if($restart === 'true'){
        array_push($controls, 'restart');
    }
    if($rewind === 'true'){
        array_push($controls, 'rewind');
    }
    array_push($controls, 'play');
    if($fast_forward === 'true'){
        array_push($controls, 'fast-forward');
    }
    if($progressbar === 'true'){
        array_push($controls, 'progress');
    }
    if($duration === 'true'){
        array_push($controls, 'duration');
    }
    if($current_time === 'true'){
        array_push($controls, 'current-time');
    }
    if($mute === 'true'){
        array_push($controls, 'mute');
    }
    if($volume === 'true'){
        array_push($controls, 'volume');
    }
    if($settings === 'true'){
        array_push($controls, 'settings');
    }
    if($download === 'true'){
        array_push($controls, 'download');
    }

    $newData = array(
        'h5ap_repeat' => 'loop',
        'h5ap_muted' => 1,
        'h5ap_player_width' => array(
            'width' => $width,
            'unit' => 'px',
        ),
        'h5ap_seektime' => 10,
        'h5ap_autoplay' => '',
        'h5ap_controls' => $controls,
        'h5ap_preload' => 'auto',
        'h5ap_primary_color' => get_o_option($color, 'color_one', ''),
        'h5ap_hover_color' => get_o_option($color, 'color_two', ''),
        'h5ap_background_color' => get_o_option($color, 'bg_color', ''),
        'h5ap_custom_css' => get_o_option($custom_css, 'custom_css', ''),
        'h5apt_restart' => get_o_option($translation, 'restart', 'Restart'),
        'h5apt_rewind' => get_o_option($translation, 'rewind ', 'Rewind {seektime}s'),
        'h5apt_play' => get_o_option($translation, 'play', 'play'),
        'h5apt_pause' => get_o_option($translation, 'pause', 'Pause'),
        'h5apt_forward_seektime' => get_o_option($translation, 'fastForward', 'Forward {seektime}s'),
        'h5apt_seek' => get_o_option($translation, 'seek', 'Seek'),
        'h5apt_currenttime_of_duration' => get_o_option($translation, 'seekLabel', '{currentTime} of {duration}'),
        'h5apt_played' => get_o_option($translation, 'played', 'Played'),
        'h5apt_buffered' => get_o_option($translation, 'buffered', 'Buffered'),
        'h5apt_current_time' => get_o_option($translation, 'currentTime', 'Current Time'),
        'h5apt_duration' => get_o_option($translation, 'duration', 'Duration'),
        'h5apt_volume' => get_o_option($translation, 'volume', 'Volume'),
        'h5apt_mute' => get_o_option($translation, 'mute', 'Mute'),
        'h5apt_unmute' => get_o_option($translation, 'unmute', 'Unmute'),
        'h5apt_enable_captions' => get_o_option($translation, 'enableCaptions', 'Enable captions'),
        'h5apt_disable_captions' => get_o_option($translation, 'disableCaptions', 'Disable captions'),
        'h5apt_download' => get_o_option($translation, 'download', 'Download'),
        'h5apt_enter_fullscreen' => get_o_option($translation, 'enterFullscreen', 'Enter fullscreen'),
        'h5apt_exit_fullscreen' => get_o_option($translation, 'exitFullscreen', 'Exit fullscreen'),
        'h5apt_player_for' => get_o_option($translation, 'frameTitle', 'Player for {title}'),
        'h5apt_captions' => get_o_option($translation, 'captions', 'Captions'),
        'h5apt_settings' => get_o_option($translation, 'settings', 'Settings'),
        'h5apt_pip' => get_o_option($translation, 'pip', 'PIP'),
        'h5apt_go_back' => get_o_option($translation, 'menuBack', 'Go back to previous menu'),
        'h5apt_speed' => get_o_option($translation, 'speed', 'Speed'),
        'h5apt_normal' => get_o_option($translation, 'normal', 'Normal'),
        'h5apt_quality' => get_o_option($translation, 'quality', 'Quality'),
        'h5apt_loop' => get_o_option($translation, 'loop', 'Loop'),
        'h5apt_start' => get_o_option($translation, 'start', 'Start'),
        'h5apt_end' => get_o_option($translation, 'End', 'End'),
        'h5apt_all' => get_o_option($translation, 'all', 'All'),
        'h5apt_reset' => get_o_option($translation, 'reset', 'Reset'),
        'h5apt_disabled' => get_o_option($translation, 'disabled', 'Disabled'),
        'h5apt_enabled' => get_o_option($translation, 'enabled', 'Enabled'),
        'h5apt_ad' => get_o_option($translation, 'advertisement', 'Ad'),
    );


	if(get_option('h5ap_settings') === false){		
        update_option('h5ap_settings', $newData);
	}

}
add_action('init', 'h5ap_import_settings');


function get_o_option($array, $key = array(), $default = null){
    if(array_key_exists($key, $array)){
        return $array[$key];
    }
    return $default;
}