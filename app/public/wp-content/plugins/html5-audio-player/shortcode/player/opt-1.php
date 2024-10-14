<?php 
use H5APPlayer\Helper\Functions;
$attr = '';
$classes = '';
$width = Functions::playerMeta($id, 'width', ['width' => '100', 'unit' => '%']);
$preload = Functions::playerMeta($id, 'preload', 'metadata');
$loop = Functions::playerMeta($id, 'repeat', '0') === '1' ? ' loop ': '';
$autoplay = Functions::playerMeta($id, 'autoplay', '0');
$disablePause = (boolean) Functions::playerMeta($id, 'disable_pause', '0');
$startTime =  (int)Functions::playerMeta($id, 'startTime', '0');
$disableLoader = (boolean) Functions::playerMeta($id, 'disable_loader', '0');
$muted = Functions::playerMeta($id, 'muted', '0');
$controls = Functions::playerMeta($id, 'controls', ['play', 'progress', 'duration', 'mute', 'volume', 'settings']);
$seektime = (int) Functions::playerMeta($id, 'seektime', 10);
$radius = Functions::playerMeta($id, 'radius');
$skin = Functions::playerMeta($id, 'standard_skin', 'default');
$source = Functions::playerMeta($id, 'h5vp_default_audio');
$title = Functions::playerMeta($id, 'title');
$color = Functions::playerMeta($id, 'color', 'skyblue');
$disable_download = (boolean)Functions::playerMeta($id, 'disable_download', '0');
$fusion_download = (boolean)Functions::playerMeta($id, 'fusion_download', '0');

$poster = Functions::playerMeta($id, 'sticky_poster') === '' ? plugin_dir_url(__FILE__).'sticky-default.jpg': Functions::playerMeta($id, 'sticky_poster');

// set audio type 
$type = 'audio/mp3';
$ext = pathinfo($source, PATHINFO_EXTENSION);
if($ext == 'm4a'){
    $type = 'audio/mp4';
}

$options = array(
  'controls' => $controls,
  'seekTime' => $seektime,
  'skin' => $skin,
  'title' => $title,
  'author' => Functions::playerMeta($id, 'author'),
  'disableDownload' => $disable_download,
  'fusionDownload' => $fusion_download,
  'color' => $color,
  'background' => Functions::playerMeta($id, 'background'),
  'repeat' => (boolean)$loop,
  'type' => $player_type,
  'autoplay' => (boolean) $autoplay,
  'muted' => (boolean) $muted,
  'disablePause' => $disablePause,
  'startTime' => $startTime
);

if($skin === 'fusion'){
  $loop = '';
}

if((boolean) $muted){
  $attr .= ' muted';
}
if((boolean) $autoplay){
  $attr .= ' autoplay';
}
?>
<style>
 <?php echo ".player$id  .plyr__controls" ?>,
 <?php echo ".player$id .StampAudioPlayerSkin" ?>{
  border-radius: <?php echo $radius;  ?>px;
  overflow: hidden;
 }
 <?php echo ".player$id" ?>{
  <?php echo esc_html($alignCSS);  ?>
 }
 <?php echo ".player$id .plyr__controls .plyr__controls" ?> {
   border-radius: none;
   overflow: visible;
 }
 <?php echo ".skin_default .player$id .plyr__controls" ?> {
   overflow: visible;
 }
 <?php if($skin == 'wave'): ?>
  .skin_wave .info .title-author h2,.skin_wave .info .title-author p, .skin_wave .plyr__time  {
   color: <?php echo esc_html($color) ?>
 }
 .skin_wave .info .play button {
   border-color: <?php echo esc_html($color); ?>;
 }
 .skin_wave .info .volume_controls button, .skin_wave .info .volume_controls .plyr__volume input {
   color: <?php echo esc_html($color); ?>;
 }
 .skin_wave .info .play button svg {
   fill: <?php echo esc_html($color); ?>;
 }
 .skin_wave {
   background: <?php echo esc_html($options['background']); ?>;
   width: <?php echo esc_attr($width['width'].$width['unit']); ?>;
   max-width: 100%;
   <?php echo esc_html($alignCSS);  ?>
 }
 <?php endif; ?>
</style>
<div class="skin_<?php echo esc_attr($skin); ?>" id="skin_<?php echo esc_attr($skin); ?>">
  <div style="width:<?php echo esc_attr($width['width'].$width['unit']); ?>;--plyr-color-bg:<?php echo esc_attr($options['background']) ?>" class="h5ap_standard_player player<?php echo esc_attr($id); ?>" 
  data-poster="<?php echo esc_attr($poster); ?>" 
  data-skin="<?php echo esc_attr($skin) ?>" 
  data-title="<?php echo esc_attr($title) ?>" 
  data-song="<?php echo esc_attr($source); ?>" 
  data-id="<?php echo esc_attr($id); ?>" 
  data-options='<?php echo esc_attr(wp_json_encode($options)) ?>'>
    <audio <?php echo esc_html($attr); ?> playsinline preload="<?php echo esc_attr($preload); ?>" class="player<?php echo esc_attr($id);?>" id="player<?php echo esc_attr($id); ?>">
      <source src="<?php echo esc_attr($source); ?>" type="<?php echo esc_attr($type); ?>">
        Your browser does not support the audio element.
    </audio>
    <?php if(!$disableLoader){?>
      <div class="h5ap_lp">
        <div class="bar bar-1"></div>
        <div class="bar bar-1"></div>
      </div>
    <?php } ?>
  </div>
</div>