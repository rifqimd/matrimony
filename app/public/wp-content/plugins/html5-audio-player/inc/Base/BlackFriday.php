<?php
namespace H5APPlayer\Base;

class BlackFriday{

    public function register(){
        add_action('admin_enqueue_scripts', [$this, 'admin_assets']);
    }

    function admin_assets(){
        wp_enqueue_script('black-friday',  H5AP_PRO_PLUGIN_DIR . 'dist/black-friday.js', ['wp-element'], H5AP_PRO_VERSION);
        wp_enqueue_style('black-friday',  H5AP_PRO_PLUGIN_DIR . 'dist/black-friday.css', [], H5AP_PRO_VERSION);
    }
}

if( !h5ap_fs()->can_use_premium_code() ){
    add_action( 'admin_bar_menu', function ( \WP_Admin_Bar $admin_bar ) {
        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }
        $admin_bar->add_menu( array(
            'id'    => 'h5ap_offer_menu',
            'parent' => 'top-secondary',
            'group'  => null,
            'title' => '40% Off Black Friday!', //you can use img tag with image link. it will show the image icon Instead of the title.
            'href'  => admin_url('edit.php?post_type=audioplayer&page=audio-player-pricing-manual'),
            'meta' => [
                'title' => __( '40% Off Black Friday!', 'h5vp' ), //This title will show on hover
            ]
        ) );
    }, 500 );

    add_action('init', function(){
        add_submenu_page(
            '',
            __( 'Upgrade', 'textdomain' ),
            __( 'Upgrade', 'textdomain' ),
            'manage_options',
            'audio-player-pricing-manual',
            function(){
                ?>
                <div id="apbUpgradePage">
                    <div id="fsUpgradePrice">
                        <iframe src="https://wp.freemius.com/pricing/?plugin_id=14260&plugin_public_key=pk_ea4da01be073820a5edf59346b675&plugin_version=2.3.7&home_url=https%3A%2F%2Fborrowhome.s4-tastewp.com&post_type=audioplayer&page=html5-audio-player-pricing&next=https%3A%2F%2Fborrowhome.s4-tastewp.com%2Fwp-admin%2Fedit.php%3Fpost_type%3Daudioplayer%26fs_action%3Dhtml5-audio-player_sync_license%26page%3Dhtml5-audio-player-account&billing_cycle=annual&is_network_admin=false&currency=usd&discounts_model=absolute#https%3A%2F%2Fborrowhome.s4-tastewp.com%2Fwp-admin%2Fedit.php%3Fpost_type%3Daudioplayer%26page%3Dhtml5-audio-player-pricing" width="100%" height="800px" scrolling="no" frameborder="0" style="background: transparent; width: 1px; min-width: 100%; height: 1100px;"></iframe>
                    </div>
                </div>
            <?php
            }, 13
        );
    }, 500);

}