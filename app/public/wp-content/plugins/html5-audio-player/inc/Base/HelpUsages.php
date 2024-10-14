<?php
namespace H5APPlayer\Base;

class HelpUsages{

    public function register(){
        add_action('admin_menu', [$this, 'h5ap_support_page']);   
    }

    function h5ap_support_page(){
        add_submenu_page('edit.php?post_type=audioplayer', 'Help', 'Help', 'manage_options', 'h5ap-support', [$this, 'h5ap_support_page_callback']);
    }

    function h5ap_support_page_callback(){
        ?>
        <div class="bplugins-container">
            <div class="row">
                <div class="bplugins-features">
                    <div class="col col-12">
                        <div class="bplugins-feature center">
                            <h1><?php _e("Help & Usages", "h5ap"); ?></h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="bplugins-container">
            <div class="row">
                <div class="bplugins-features">
                    <div class="col col-4">
                        <div class="bplugins-feature center">
                            <i class="fa fa-life-ring"></i>
                            <h3><?php _e('Need any Assistance?', 'h5ap'); ?></h3>
                            <p><?php _e('Our Expert Support Team is always ready to help you out promptly.', 'h5ap'); ?></p>
                            <a href="https://bplugins.com/support/" target="_blank" class="button
                            button-primary"><?php _e('Contact Support', 'h5ap') ?></a>
                        </div>
                    </div>
                    <div class="col col-4">
                        <div class="bplugins-feature center">
                            <i class="fa fa-file-text"></i>
                            <h3><?php _e('Looking for Documentation?', 'h5ap') ?></h3>
                            <p><?php echo _e("We have detailed documentation on every aspects of HTML5 Audio Player.", "h5ap") ?></p>
                            <a href="https://audioplayerwp.com/docs/" target="_blank" class="button button-primary"><?php _e("Documentation", "h5ap") ?></a>
                        </div>
                    </div>
                    <div class="col col-4">
                        <div class="bplugins-feature center">
                            <i class="fa fa-thumbs-up"></i>
                            <h3><?php _e("Like This Plugin?", "h5ap"); ?></h3>
                            <p><?php _e("If you like HTML5 Audio Player, please leave us a 5 &#11088; rating.", "h5ap") ?></p>
                            <a href="https://wordpress.org/support/plugin/html5-audio-player/reviews/#new-post" target="_blank" class="button
                            button-primary"><?php _e("Rate the Plugin", "h5ap"); ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="bplugins-container">
            <div class="row">
                <div class="bplugins-features">
                    <div class="col col-12">
                        <div class="bplugins-feature center" style="padding:5px;">
                            <h2 style="font-size:22px;"><?php _e("Looking For Demo?", "h5ap"); ?> <a href="https://audioplayerwp.com/" target="_blank"><?php _e("Click Here", "h5ap"); ?></a></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="bplugins-container">
            <div class="row">
                <div class="bplugins-features">
                    <div class="col col-12">
                        <div class="bplugins-feature center">
                            <h1><?php _e("Video Tutorials", "h5ap"); ?></h1><br/>
                            <div class="embed-container"><iframe width="100%" height="700px" src="https://www.youtube.com/embed/MbY9oyERJck" frameborder="0"
                            allowfullscreen></iframe></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
    <?php
    } 
}