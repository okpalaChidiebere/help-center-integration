<?php

namespace HelpCenter_Intergrations\Source;

use HelpCenter_Intergrations\Source;

/**
 * Class LD_Lesson_Origin
 *
 * @since 1.1.0
 * @package HelpCenter_Intergrations
 */
class LD_Lesson_Origin extends Source {

	protected $source = 'ORIGINS_ACADEMY_LESSON_WP';
    private $mPost_type = 'sfwd-lessons';


    public function add_ld_lesson_to_help_center( $post_id, $post ) {
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

    public function remove_ld_lesson_from_help_center( $post_id ) {
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
        // add_action( 'save_post', array( $this, 'add_ld_lesson_to_help_center' ) , 15, 2 );
        /**
         * @see https://developer.wordpress.org/reference/hooks/delete_post/
         */
        add_action('delete_post', array( $this, 'remove_ld_lesson_from_help_center' ));
	}
}
