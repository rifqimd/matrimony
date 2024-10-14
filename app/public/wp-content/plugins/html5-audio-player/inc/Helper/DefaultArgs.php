<?php
namespace H5APPlayer\Helper;

class DefaultArgs{

    public static function parseArgs($data){
        $default = self::get();
        $data = wp_parse_args( $data, $default );
        $data['options'] = wp_parse_args( $data['options'], $default['options'] );
        $data['infos'] = wp_parse_args( $data['infos'], $default['infos'] );
        $data['template'] = wp_parse_args( $data['template'], $default['template'] );

		return $data;
    }

    public static function get(){
        $options = [
            'controls' => ['rewind', 'play', 'fast-forward', 'progress', 'current-time', 'mute', 'volume', 'settings'],
            'autoplay' => false,
            'loop' => [
                'active' => true
            ],
            'seekTime' => 10,
            'volume' => 1
        ];

        $infos = [
            'source' => '',
            'poster' => '',
            'skin' => 'default',
            'title' => '',
        ];

        $tempalte = [
            'width' => '100%',
            'skin' => 'default',
            'title' => ''
        ];

        return [
            'options' => $options,
            'infos' => $infos,
            'template' => $template
        ];

    }
}