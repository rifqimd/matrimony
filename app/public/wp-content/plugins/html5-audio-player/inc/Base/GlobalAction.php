<?php
namespace H5APPlayer\Base;

class GlobalAction {

    public function register(){
        add_action('wp_head', [$this, 'css_for_player']);
        add_action('wp_footer', [$this, 'wp_footer']);
    }

    public function css_for_player(){
        ?>
            <style>
                .mejs-container:has(.plyr){height: auto; background: transparent} .mejs-container:has(.plyr) .mejs-controls {display: none}
                .h5ap_all {
                    --shadow-color: 197deg 32% 65%;
                    border-radius: 6px;
                    box-shadow: 0px 0px 9.6px hsl(var(--shadow-color)/.36),0 1.7px 1.9px 0px hsl(var(--shadow-color)/.36),0 4.3px 1.8px -1.7px hsl(var(--shadow-color)/.36),-0.1px 10.6px 11.9px -2.5px hsl(var(--shadow-color)/.36);
                    margin: 16px auto;
                }
            </style>
        <?php
    }

    function wp_footer(){
        ?>
            <script>
                // ios old devices
                document.addEventListener('DOMContentLoaded', function() {
                    setTimeout(() => {
                        document.querySelectorAll('audio:not(.plyr audio)').forEach(function(audio, index) {
                        audio.setAttribute('controls','')
                    });
                    }, 3000);
                });
            </script>
        <?php
    }
}
