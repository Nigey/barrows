<?php 

// Register the Custom Saved Property Post Type
 
function register_cpt_saved_property() {
 
    $labels = array(
        'name' => _x( 'Saved Properties', 'saved_property' ),
        'singular_name' => _x( 'Saved Property', 'saved_property' ),
        'add_new' => _x( 'Add New', 'saved_property' ),
        'add_new_item' => _x( 'Add New Saved Property', 'saved_property' ),
        'edit_item' => _x( 'Edit Saved Property', 'saved_property' ),
        'new_item' => _x( 'New Saved Property', 'saved_property' ),
        'view_item' => _x( 'View Saved Property', 'saved_property' ),
        'search_items' => _x( 'Search Saved Properties', 'saved_property' ),
        'not_found' => _x( 'No saved_property found', 'saved_property' ),
        'not_found_in_trash' => _x( 'No saved_property found in Trash', 'saved_property' ),
        'parent_item_colon' => _x( 'Parent Saved Property:', 'saved_property' ),
        'menu_name' => _x( 'Saved Properties', 'saved_property' ),
    );
 
    $args = array(
        'labels' => $labels,
        'hierarchical' => true,
        'description' => 'Saved Properties',
        'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'page-attributes' ),
        'taxonomies' => array( 'saved_property_type' ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-format-quote',
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post'
    );
 
    register_post_type( 'saved_property', $args );
}
 
add_action( 'init', 'register_cpt_saved_property' );

function yop_saved_property_meta_box_enqueues($hook) {
	global $post_type;
	if ( 'post.php' == $hook || 'post-new.php' == $hook ) {
		wp_enqueue_style('settings-css', '/wp-content/plugins/yop-properties/assets/css/settings.css');
	}
}
add_action('admin_enqueue_scripts', 'yop_saved_property_meta_box_enqueues');
function yop_saved_property_meta_boxes(){
	add_meta_box( 'yop_saved_property_main_meta', __( 'Saved Property Information', 'yop-saved_property' ), 'saved_property_main_meta_callback', 'saved_property', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'yop_saved_property_meta_boxes' );

/**
 * Outputs the content of the main meta box
 */

function saved_property_main_meta_callback( $post ) {
	wp_nonce_field( basename( __FILE__ ), 'saved_property_main_nonce' );
	$saved_property_stored_meta = get_post_meta( $post->ID );
	?>

	<div class="container half" id="yop_property_main_meta">
		<div class="property-row">
			<div class="property-row-content">
				<label for="saved_property_user"><?php _e( 'Saved Property User', 'yop-saved_property' )?></label>
				<input type="text" name="saved_property_user" id="saved_property_user" value="<?php if ( isset ( $saved_property_stored_meta['saved_property_user'] ) ) echo $saved_property_stored_meta['saved_property_user'][0]; ?>" />
			</div>
		</div>
		<div class="property-row">
			<div class="property-row-content">
				<label for="saved_property_property_id"><?php _e( 'Saved Property ID', 'yop-saved_property' )?></label>
				<input type="text" name="saved_property_property_id" id="saved_property_property_id" value="<?php if ( isset ( $saved_property_stored_meta['saved_property_property_id'] ) ) echo $saved_property_stored_meta['saved_property_property_id'][0]; ?>" />
			</div>
		</div>
		<div class="property-row">
			<div class="property-row-content">
				<label for="saved_property_name"><?php _e( 'Saved Property Name', 'yop-saved_property' )?></label>
				<input type="text" name="saved_property_name" id="saved_property_name" value="<?php if ( isset ( $saved_property_stored_meta['saved_property_name'] ) ) echo $saved_property_stored_meta['saved_property_name'][0]; ?>" />
			</div>
		</div>
		<div class="property-row">
			<div class="property-row-content">
				<label for="saved_property_price"><?php _e( 'Saved Property Name', 'yop-saved_property' )?></label>
				<input type="text" name="saved_property_price" id="saved_property_price" value="<?php if ( isset ( $saved_property_stored_meta['saved_property_price'] ) ) echo $saved_property_stored_meta['saved_property_price'][0]; ?>" />
			</div>
		</div>
		<div class="property-row">
			<div class="property-row-content">
				<label for="saved_property_photo"><?php _e( 'Saved Property Photo', 'yop-saved_property' )?></label>
				<input type="text" name="saved_property_photo" id="saved_property_photo" value="<?php if ( isset ( $saved_property_stored_meta['saved_property_photo'] ) ) echo $saved_property_stored_meta['saved_property_photo'][0]; ?>" />
			</div>
		</div>
	</div>
	</div>
<?php
}

/**
 * Saves the custom team meta input
 */
function yop_properties_saved_property_meta_save( $post_id ) {
 
	// Checks save status
	$is_autosave = wp_is_post_autosave( $post_id );
	$is_revision = wp_is_post_revision( $post_id );
	$is_valid_nonce = ( isset( $_POST[ 'yop_properties_saved_property_main_nonce' ] ) && wp_verify_nonce( $_POST[ 'yop_properties_saved_property_main_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';

	// Exits script depending on save status
	if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
		return;
	}

	// Checks for input and sanitizes/saves if needed
	if( isset( $_POST[ 'saved_property_user' ] ) ) {
		update_post_meta( $post_id, 'saved_property_user', $_POST[ 'saved_property_user' ] );
	} else {
		delete_post_meta( $post_id, 'saved_property_user' );
	}
	// Checks for input and sanitizes/saves if needed
	if( isset( $_POST[ 'saved_property_property_id' ] ) ) {
		update_post_meta( $post_id, 'saved_property_property_id', $_POST[ 'saved_property_property_id' ] );
	} else {
		delete_post_meta( $post_id, 'saved_property_property_id' );
	}
	// Checks for input and sanitizes/saves if needed
	if( isset( $_POST[ 'saved_property_name' ] ) ) {
		update_post_meta( $post_id, 'saved_property_name', $_POST[ 'saved_property_name' ] );
	} else {
		delete_post_meta( $post_id, 'saved_property_name' );
	}
	// Checks for input and sanitizes/saves if needed
	if( isset( $_POST[ 'saved_property_price' ] ) ) {
		update_post_meta( $post_id, 'saved_property_price', $_POST[ 'saved_property_price' ] );
	} else {
		delete_post_meta( $post_id, 'saved_property_price' );
	}
	// Checks for input and sanitizes/saves if needed
	if( isset( $_POST[ 'saved_property_photo' ] ) ) {
		update_post_meta( $post_id, 'saved_property_photo', $_POST[ 'saved_property_photo' ] );
	} else {
		delete_post_meta( $post_id, 'saved_property_photo' );
	}

}
add_action( 'save_post', 'yop_properties_saved_property_meta_save' );


?>