<?php

namespace HelpCenter_Intergrations\Source;

use HelpCenter_Intergrations\Source;

/**
 * Class BP_MEMBERS_Origin
 *
 * @since 1.1.0
 * @package HelpCenter_Intergrations
 */
class BP_Members_Origin extends Source {

	protected $source = 'ORIGINS_BP_MEMBERS_WP';

    public function add_bp_member_to_help_center( $user_id ) {
        try {
            if ( !is_wp_error( $user_id ) ) {
                $this->index_source( intval($user_id), $this->source );
            }
        } catch (Exception $e) {
            trigger_error('Caught exception: ',  $e->getMessage(), "\n", E_USER_NOTICE);
        }

    }

    public function remove_bp_member_from_help_center( $user_id ) {
        try {
            $this->delete_source( $user_id, $this->source );
        } catch (Exception $e) {
            trigger_error('Caught exception: ',  $e->getMessage(), "\n", E_USER_NOTICE);
        }
    }

    /**
	 * A base point for monitoring the events
	 * @return void
	 */
	public function listen() {
        add_action('user_register', array($this, 'add_bp_member_to_help_center'), 10, 1); //triggered when the wp_insert_user method runs which is triggered by the open-generic-conect plugin when partners signs up
        add_action('edit_user_created_user', array($this, 'add_bp_member_to_help_center'), 10, 1 );  //trigged when a user is created via the admin dashboard

        /**
         * @see https://developer.wordpress.org/reference/hooks/delete_user/
         */
        add_action('delete_user', array( $this, 'remove_bp_member_from_help_center' ));
	}
}
