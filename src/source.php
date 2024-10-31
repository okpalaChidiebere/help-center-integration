<?php

namespace HelpCenter_Intergrations;

/**
 * Class Source
 *
 * @since 1.1.0
 * @package HelpCenter_Intergrations
 */
abstract class Source {

	/**
	 * A base point for monitoring the events
	 *
	 * @return void
	 */
	abstract public function listen();

	public function index_source( int $articleId, string $source ) {
		$helpCenter = new HelpCenter_Client();
		$helpCenter->index_article($articleId, $source);
	}

	public function delete_source( int $articleId, string $source ) {
		$helpCenter = new HelpCenter_Client();
		$helpCenter->delete_article($articleId, $source);
	}

	protected function post_type_check( $edit_post = null, $source_edit_post ) {
		global $typenow;

		if ( ! empty( $edit_post ) ) {
			if ( ( is_a( $edit_post, 'WP_Post' ) ) && ( $source_edit_post === $edit_post->post_type ) ) {
				return true;
			} elseif ( ( is_string( $edit_post ) ) && ( $source_edit_post === $edit_post ) ) {
				return true;
			}
		} elseif ( ( ! empty( $typenow ) ) && ( $typenow === $source_edit_post ) ) {
			return true;
		}
		return false;
	}

	protected function save_post(){
		// bail out if this is an autosave
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return false;
		}

		// Check the logged in user has permission to edit this post
		if ( ! current_user_can( 'administrator' ) ) {
			return false;
		}

		/**
		 * bail out if its update because sometimes this hook gets triggered when moving a post to trash which is an update
		 *  @see https://wordpress.stackexchange.com/questions/48678/check-for-update-vs-new-post-on-save-post-action
		 */
		//check if new post so insert
		// $isNewPost = strpos( wp_get_raw_referer(), 'post-new' ) > 0;
		// if( !$isNewPost ){
		// 	return false;
		// }
		//No Need to check for if a post is new  or updated because the user might change the tages for a post and we want to re-index if so.
		return true;
	}
}