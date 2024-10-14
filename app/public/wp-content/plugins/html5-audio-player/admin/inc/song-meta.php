<?php
use H5APPlayer\Model\Pipe;

if( class_exists( 'CSF' ) ) {

    //-------------------------------------------------------------------------
    //   Player type 
    // ------------------------------------------------------------------------
    $prefix = '_h5ap_audio';
  
    CSF::createMetabox( $prefix, array(
      'title'     => 'Playlist',
      'post_type' => 'audiolist',
      'data_type' => 'unserialize'
    ) );

    if(!h5ap_fs()->can_use_premium_code()){
        CSF::createSection($prefix, array(
            'title' => '',
            'fields' => array(
                array(
                    'type' => 'heading',
                    'content' => '<p style="color:#7B2F31;background:#F8D7DA;padding:15px">HTML5 Audio Player Pro is not activated yet. Please active the license key by navigating to Plugins > HTML5 Audio Player Pro> Active License. 
                    Once you activate the plugin you will get all the options availble here. </p>'
                ),
            ),
        ));
        return false;
    }

    CSF::createSection($prefix, array(
        'title' => '',
        'fields' => array(
           array(
               'id' => '_h5applaylist',
               'type' => 'group',
               'title' => '',
               'fields' => array(
                   array(
                        'id' => 'title',
                        'title' => 'Title',
                        'type' => 'text',
                        'default' => 'Title'
                   ),
                    array(
                        'id' => 'audio',
                        'title' => 'Add Audio',
                        'type' => 'upload',
                        'placeholder' => 'audio url'
                    ),
                    array(
                        'id' => 'poster',
                        'title' => 'Add Poster',
                        'type' => 'upload',
                        'placeholder' => 'poster url'
                    ),
                    array(
                        'id' => 'artist',
                        'title' => 'Artist',
                        'type' => 'text',
                        'placeholder' => 'artist'
                    )
                ),
           )
        )
    ));
}