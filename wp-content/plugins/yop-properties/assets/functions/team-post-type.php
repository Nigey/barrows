<?php 

// Register the Custom Team Member Post Type
 
function register_cpt_team_member() {
 
    $labels = array(
        'name' => _x( 'Team Members', 'team_member' ),
        'singular_name' => _x( 'Team Member', 'team_member' ),
        'add_new' => _x( 'Add New', 'team_member' ),
        'add_new_item' => _x( 'Add New Team Member', 'team_member' ),
        'edit_item' => _x( 'Edit Team Member', 'team_member' ),
        'new_item' => _x( 'New Team Member', 'team_member' ),
        'view_item' => _x( 'View Team Member', 'team_member' ),
        'search_items' => _x( 'Search Team Members', 'team_member' ),
        'not_found' => _x( 'No Team Member found', 'team_member' ),
        'not_found_in_trash' => _x( 'No Team Member found in Trash', 'team_member' ),
        'parent_item_colon' => _x( 'Parent Team Member:', 'team_member' ),
        'menu_name' => _x( 'Team Members', 'team_member' ),
    );
 
    $args = array(
        'labels' => $labels,
        'hierarchical' => true,
        'description' => 'Team Members',
        'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'page-attributes' ),
        'taxonomies' => array( 'team_member_type' ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-admin-users',
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post'
    );
 
    register_post_type( 'team_member', $args );
}
 
add_action( 'init', 'register_cpt_team_member' );

function yop_team_member_meta_box_enqueues($hook) {
	global $post_type;
	if ( 'post.php' == $hook || 'post-new.php' == $hook ) {
		wp_enqueue_style('settings-css', '/wp-content/plugins/yop-properties/assets/css/settings.css');
	}
}
add_action('admin_enqueue_scripts', 'yop_team_member_meta_box_enqueues');
function yop_team_member_meta_boxes(){
	add_meta_box( 'yop_team_member_main_meta', __( 'Team Member Information', 'yop-team_member' ), 'team_member_main_meta_callback', 'team_member', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'yop_team_member_meta_boxes' );

/**
 * Outputs the content of the main meta box
 */

function team_member_main_meta_callback( $post ) {
	wp_nonce_field( basename( __FILE__ ), 'team_member_main_nonce' );
	$team_member_stored_meta = get_post_meta( $post->ID );
	?>

	<div class="container half" id="yop_property_main_meta">
		<h3>Team Member Details</h3>
		<div class="team_member-row">
			<div class="team_member-row-content">
				<label for="team_member-email"><?php _e( 'Team Member Email', 'yop-team_member' )?></label>
				<input type="text" name="team_member-email" id="team_member-email" value="<?php if ( isset ( $team_member_stored_meta['team_member-email'] ) ) echo $team_member_stored_meta['team_member-email'][0]; ?>" />
			</div>
		</div>
		<div class="team_member-row">
			<div class="team_member-row-content">
				<label for="team_member-twitter"><?php _e( 'Team Member Twitter', 'yop-team_member' )?></label>
				<input type="text" name="team_member-twitter" id="team_member-twitter" value="<?php if ( isset ( $team_member_stored_meta['team_member-twitter'] ) ) echo $team_member_stored_meta['team_member-twitter'][0]; ?>" />
			</div>
		</div>
		<div class="team_member-row">
			<div class="team_member-row-content">
				<label for="team_member-linkedin"><?php _e( 'Team Member LinkedIn', 'yop-team_member' )?></label>
				<input type="text" name="team_member-linkedin" id="team_member-linkedin" value="<?php if ( isset ( $team_member_stored_meta['team_member-linkedin'] ) ) echo $team_member_stored_meta['team_member-linkedin'][0]; ?>" />
			</div>
		</div>
	</div>
<?php
}

/**
 * Saves the custom team meta input
 */
function yop_properties_team_member_meta_save( $post_id ) {
 
	// Checks save status
	$is_autosave = wp_is_post_autosave( $post_id );
	$is_revision = wp_is_post_revision( $post_id );
	$is_valid_nonce = ( isset( $_POST[ 'yop_properties_team_member_main_nonce' ] ) && wp_verify_nonce( $_POST[ 'yop_properties_team_member_main_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';

	// Exits script depending on save status
	if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
		return;
	}

	// Checks for input and sanitizes/saves if needed
	if( isset( $_POST[ 'team_member-email' ] ) ) {
		update_post_meta( $post_id, 'team_member-email', $_POST[ 'team_member-email' ] );
	} else {
		delete_post_meta( $post_id, 'team_member-email' );
	}
	// Checks for input and sanitizes/saves if needed
	if( isset( $_POST[ 'team_member-twitter' ] ) ) {
		update_post_meta( $post_id, 'team_member-twitter', $_POST[ 'team_member-twitter' ] );
	} else {
		delete_post_meta( $post_id, 'team_member-twitter' );
	}
	// Checks for input and sanitizes/saves if needed
	if( isset( $_POST[ 'team_member-linkedin' ] ) ) {
		update_post_meta( $post_id, 'team_member-linkedin', $_POST[ 'team_member-linkedin' ] );
	} else {
		delete_post_meta( $post_id, 'team_member-linkedin' );
	}

}
add_action( 'save_post', 'yop_properties_team_member_meta_save' );


?>