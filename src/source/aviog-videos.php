<?php

namespace HelpCenter_Intergrations\Source;

use HelpCenter_Intergrations\Source;

/**
 * Class AVIOG_Videos_Origin
 *
 * @since 1.1.0
 * @package HelpCenter_Intergrations
 */
class AVIOG_Videos_Origin extends Source {

	protected $source = 'ORIGINS_VIDEO_WP';
    private $mPost_type = 'aiovg_videos';

    public function add_aviog_video_to_help_center( $post_id, $post ) {
        try {
            if ( ! $this->post_type_check( $post, $this->mPost_type )  ) {
                return;
            }

            if ( ! parent::save_post() ) {
				return;
			}
            $this->index_source( $post_id, $this->source );
        } catch (Exception $e) {
            trigger_error('Caught exception: ',  $e->getMessage(), "\n", E_USER_NOTICE);
        }

    }

    public function remove_aviog_video_from_help_center( $post_id ) {
        try {
            if ( get_post_type( $post_id ) === $this->mPost_type ) {
                $this->delete_source( $post_id, $this->source );
            }            
        } catch (Exception $e) {
            trigger_error('Caught exception: ',  $e->getMessage(), "\n", E_USER_NOTICE);
        }
    }

    /**
	 * A base point for monitoring the events
	 * @return void
	 */
	public function listen() {
        add_action( 'save_post', array( $this, 'add_aviog_video_to_help_center' ) , 15, 2 );
        /**
         * @see https://developer.wordpress.org/reference/hooks/delete_post/
         */
        add_action('delete_post', array( $this, 'remove_aviog_video_from_help_center' ));
	}
}
