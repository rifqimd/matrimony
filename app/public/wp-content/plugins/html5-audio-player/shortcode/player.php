<?php
use H5APPlayer\Helper\Functions;
//Lets register Shortcode 
function h5ap_cpt_content_func($atts){
	extract( shortcode_atts( array(
		'id' => null,
	), $atts ) );
  wp_enqueue_style( 'h5ap-player');
  wp_enqueue_script( 'h5ap-player');
  // wp_enqueue_script( 'bplugins-plyrio');


  $player_type = Functions::playerMeta($id, 'h5ap_player_type', 'opt-1');
  if($player_type === ''){
    $player_type = 'opt-1';
  }

$align = Functions::playerMeta($id, 'plp_align', 'center');
$alignCSS = '';
if($align === 'start'){
  $alignCSS = "margin-left: 0;";
}else if ($align === 'end'){
  $alignCSS = "margin-left: auto;";
} else if($align === 'center'){
  $alignCSS = "margin: 0 auto;";
}


ob_start();

if(file_exists(__DIR__.'/player/'.$player_type.'.php')){
  include __DIR__.'/player/'.$player_type.'.php';
}

$output = ob_get_clean();return $output;

}
add_shortcode('player','h5ap_cpt_content_func');
