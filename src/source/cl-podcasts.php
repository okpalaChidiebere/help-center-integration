<?php

namespace HelpCenter_Intergrations\Source;

use HelpCenter_Intergrations\Source;

/**
 * Class CL_Podcasts
 *
 * @since 1.2.0
 * @package HelpCenter_Intergrations
 */
class CL_Podcasts_Origin extends Source {

	protected $source = 'ORIGINS_PODCASTS_WP';
    private $mPost_type = 'podcast';


    public function add_podcast_to_help_center( $post_id, $post ) {
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

    public function remove_podcast_from_help_center( $post_id ) {
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
        add_action( 'save_post', array( $this, 'add_podcast_to_help_center' ) , 15, 2 );
        add_action('delete_post', array( $this, 'remove_podcast_from_help_center' ));
	}
}
