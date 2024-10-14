<?php
namespace H5APPlayer;


class Init{
   
    public static function get_services(){
        return [
            Base\GlobalAction::class,
            Base\HelpUsages::class,
            // Base\BlackFriday::class,
            Base\Loader::class,
            Elementor\Widgets\Register::class,
            Elementor\Controls\Register::class,
            PostType\AudioPlayer::class,
            PostType\AudioList::class,
            Field\AudioPlayer::class,
            Field\AudioList::class,
            Field\Settings::class,
            Services\AdminNotice::class,
            Services\Shortcode::class,
            Services\EnqueueAssets::class,
            Model\GlobalChanges::class,
            Helper\Functions::class,
        ];
    }

    public static function register_services(){
        foreach(self::get_services() as $class){
            $services = self::instantiate($class);
            if(method_exists($services, 'register')){
                $services->register();
            }
        }

    }

    private static function instantiate($class){
        if(class_exists($class."Pro") && h5ap_fs()->can_use_premium_code()){
            $class = $class."Pro";
        }
        if(class_exists($class)){
            return new $class();
        }
        return new \stdClass();
        
    }
}


