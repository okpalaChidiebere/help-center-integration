<?php

namespace HelpCenter_Intergrations\Source;

use HelpCenter_Intergrations\Source;

/**
 * Class BP_Groups_Origin
 *
 * @since 1.2.0
 * @package HelpCenter_Intergrations
 */
class BP_Groups_Origin extends Source {

	protected $source = 'ORIGINS_BP_GROUP_WP';

    /**
     * @see https://www.buddyboss.com/resources/reference/hooks/groups_group_create_complete/
     * https://www.buddyboss.com/resources/reference/functions/groups_create_group/
     */
    public function add_bp_group_to_help_center($new_group_id) {
        try {
            $this->index_source( $new_group_id, $this->source );
        } catch (Exception $e) {
            trigger_error('Caught exception: ',  $e->getMessage(), "\n", E_USER_NOTICE);
        }

    }

    /**
     * @see https://www.buddyboss.com/resources/reference/hooks/groups_delete_group/
     */
    public function remove_bp_group_from_help_center($group_id) {
        try {
            $this->delete_source($group_id, $this->source );
        } catch (Exception $e) {
            trigger_error('Caught exception: ',  $e->getMessage(), "\n", E_USER_NOTICE);
        }
    }

    /**
	 * A base point for monitoring the events
	 * @return void
	 */
	function listen() {
        add_action('groups_group_create_complete', array( $this, 'add_bp_group_to_help_center' ));
        add_action('groups_delete_group', array( $this, 'remove_bp_group_from_help_center' ));
	}
}