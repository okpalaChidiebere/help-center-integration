<?php

namespace HelpCenter_Intergrations\Source;

use HelpCenter_Intergrations\Source;

/**
 * Class WP_Foro_Origin
 *
 * @since 1.1.0
 * @package HelpCenter_Intergrations
 */
class WP_Foro_Origin extends Source {

	protected $source = 'ORIGINS_COMMUNITY_WP';

    /**
     * @see plugins/wpforo/wpf-includes/class-topics.php
     */
    public function add_wpForo_topic_to_help_center($args) {
        try {
            if(!$args['private'] && ($args['forumid'] === 11 || $args['forumid'] === 6 || $args['forumid'] === 7)){
               $this->index_source( intval($args['topicid']), $this->source );
            }
        } catch (Exception $e) {
            trigger_error('Caught exception: ',  $e->getMessage(), "\n", E_USER_NOTICE);
        }

    }

    /**
     * @see plugins/wpforo/wpf-includes/class-posts.php
     */
    public function remove_wpForo_topic_from_help_center($post) {
        try {
            if($post['is_first_post']){
                $this->delete_source( intval($post['topicid']), $this->source );
            }
        } catch (Exception $e) {
            trigger_error('Caught exception: ',  $e->getMessage(), "\n", E_USER_NOTICE);
            //error_log(print_r('Caught exception: ',  $e->getMessage(), "\n", true));
        }
    }

    /**
	 * A base point for monitoring the events
	 * @return void
	 */
	function listen() {
        // add_action('wpforo_after_add_topic', array( $this, 'add_wpForo_topic_to_help_center' ));
        add_action('wpforo_after_delete_post', array( $this, 'remove_wpForo_topic_from_help_center' ));
	}
}