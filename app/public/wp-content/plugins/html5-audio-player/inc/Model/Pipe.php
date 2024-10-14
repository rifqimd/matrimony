<?php
namespace H5APPlayer\Model;

class Pipe{
    protected $products = ['h5ap', 'h5app', 'SfOyJ'];
    protected static $permalink;
    protected static $licenseKey;
    public static function isPipe(){
        $h5vppp = \get_option('bpllch5ap', false);
        $activated = false;
        if(is_array($h5vppp)){
            $activated = in_array($h5vppp['active'], ['true', 1]) ? true : false;
        }

        self::$permalink = $h5vppp['permalink'] ?? false;
        self::$licenseKey = $h5vppp['key'] ?? 'false';

        return $activated;
    }

    public static function getPipeKey(){
        return self::$licenseKey;
    }

    public static function checkPipe(){

        if(self::$permalink){
            $remote = (array) wp_remote_post('https://api.gumroad.com/v2/licenses/verify', [
                'method'      => 'POST',
                'timeout'     => 45,
                'body'        => array(
                    'product_permalink' => self::$permalink,
                    'license_key' => self::getPipeKey()
                ),
            ]);
        }else {
            foreach($products as $product){
                $remote = (array) wp_remote_post('https://api.gumroad.com/v2/licenses/verify', [
                    'method'      => 'POST',
                    'timeout'     => 45,
                    'body'        => array(
                        'product_permalink' => $product,
                        'license_key' => self::getPipeKey()
                    ),
                ]);
    
                if($remote['body']){
                    $response = json_decode($remote['body']);
                    if(isset($response->success) && $response->success){
                        return $response->success;
                        break;
                    }
                }
            }
        }

        return true;
    }

}