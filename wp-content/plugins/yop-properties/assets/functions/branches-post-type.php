<?php 

// Register the Custom Branch Post Type
 
function register_cpt_branch() {
 
    $labels = array(
        'name' => _x( 'Branches', 'branch' ),
        'singular_name' => _x( 'Branch', 'branch' ),
        'add_new' => _x( 'Add New', 'branch' ),
        'add_new_item' => _x( 'Add New Branch', 'branch' ),
        'edit_item' => _x( 'Edit Branch', 'branch' ),
        'new_item' => _x( 'New Branch', 'branch' ),
        'view_item' => _x( 'View Branch', 'branch' ),
        'search_items' => _x( 'Search Branches', 'branch' ),
        'not_found' => _x( 'No branch found', 'branch' ),
        'not_found_in_trash' => _x( 'No branch found in Trash', 'branch' ),
        'parent_item_colon' => _x( 'Parent Branch:', 'branch' ),
        'menu_name' => _x( 'Branches', 'branch' ),
    );
 
    $args = array(
        'labels' => $labels,
        'hierarchical' => true,
        'description' => 'Branches',
        'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'page-attributes' ),
        'taxonomies' => array( 'branch_type' ),
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
 
    register_post_type( 'branch', $args );
}
 
add_action( 'init', 'register_cpt_branch' );

function yop_branch_meta_box_enqueues($hook) {
	global $post_type;
	if ( 'post.php' == $hook || 'post-new.php' == $hook ) {
		wp_enqueue_style('settings-css', '/wp-content/plugins/yop-properties/assets/css/settings.css');
		wp_enqueue_script('settings-js', '/wp-content/plugins/yop-properties/assets/js/settings.js', array('jquery', 'jquery-ui-sortable'));
	}
}
add_action('admin_enqueue_scripts', 'yop_branch_meta_box_enqueues');
function yop_branch_meta_boxes(){
	add_meta_box( 'yop_branch_main_meta', __( 'Branch Information', 'yop-branch' ), 'branch_main_meta_callback', 'branch', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'yop_branch_meta_boxes' );

/**
 * Outputs the content of the main meta box
 */

function branch_main_meta_callback( $post ) {
	wp_nonce_field( basename( __FILE__ ), 'branch_main_nonce' );
	$branch_stored_meta = get_post_meta( $post->ID );
	?>

	<div class="container half" id="yop_property_main_meta">
		<h3>Branch Details</h3>
		<div class="branch-row">
			<div class="branch-row-content">
				<label for="branch-name"><?php _e( 'Branch Name', 'yop-branch' )?></label>
				<input type="text" name="branch-name" id="branch-name" value="<?php if ( isset ( $branch_stored_meta['branch-name'] ) ) echo $branch_stored_meta['branch-name'][0]; ?>" />
			</div>
		</div>
		<div class="branch-row">
			<div class="branch-row-content">
				<label for="branch-address"><?php _e( 'Branch Address', 'yop-branch' )?></label>
				<input type="text" name="branch-address" id="branch-address" value="<?php if ( isset ( $branch_stored_meta['branch-address'] ) ) echo $branch_stored_meta['branch-address'][0]; ?>" />
			</div>
		</div>
		<div class="branch-row">
			<div class="branch-row-content">
				<label for="branch-postcode"><?php _e( 'Branch Postcode', 'yop-branch' )?></label>
				<input type="text" name="branch-postcode" id="branch-postcode" value="<?php if ( isset ( $branch_stored_meta['branch-postcode'] ) ) echo $branch_stored_meta['branch-postcode'][0]; ?>" />
			</div>
		</div>
		<div class="branch-row">
			<div class="branch-row-content">
				<label for="branch-latitude"><?php _e( 'Branch Latitude', 'yop-branch' )?></label>
				<input type="text" name="branch-latitude" id="branch-latitude" value="<?php if ( isset ( $branch_stored_meta['branch-latitude'] ) ) echo $branch_stored_meta['branch-latitude'][0]; ?>" />
			</div>
		</div>
		<div class="branch-row">
			<div class="branch-row-content">
				<label for="branch-longitude"><?php _e( 'Branch Longitude', 'yop-branch' )?></label>
				<input type="text" name="branch-longitude" id="branch-longitude" value="<?php if ( isset ( $branch_stored_meta['branch-longitude'] ) ) echo $branch_stored_meta['branch-longitude'][0]; ?>" />
			</div>
		</div>
		<h3>Contact Details</h3>
		<h3>Sales</h3>
		<div class="branch-row">
			<div class="branch-row-content">
				<label for="branch-sales-phone"><?php _e( 'Branch Sales-phone', 'yop-branch' )?></label>
				<input type="text" name="branch-sales-phone" id="branch-sales-phone" value="<?php if ( isset ( $branch_stored_meta['branch-sales-phone'] ) ) echo $branch_stored_meta['branch-sales-phone'][0]; ?>" />
			</div>
		</div>
		<div class="branch-row">
			<div class="branch-row-content">
				<label for="branch-sales-email"><?php _e( 'Branch Sales-email', 'yop-branch' )?></label>
				<input type="text" name="branch-sales-email" id="branch-sales-email" value="<?php if ( isset ( $branch_stored_meta['branch-sales-email'] ) ) echo $branch_stored_meta['branch-sales-email'][0]; ?>" />
			</div>
		</div>
		<div class="branch-row">
			<div class="branch-row-content">
				<label for="branch-sales-fax"><?php _e( 'Branch Sales-fax', 'yop-branch' )?></label>
				<input type="text" name="branch-sales-fax" id="branch-sales-fax" value="<?php if ( isset ( $branch_stored_meta['branch-sales-fax'] ) ) echo $branch_stored_meta['branch-sales-fax'][0]; ?>" />
			</div>
		</div>
		<h3>Lettings</h3>
		<div class="branch-row">
			<div class="branch-row-content">
				<label for="branch-lettings-phone"><?php _e( 'Branch Lettings-phone', 'yop-branch' )?></label>
				<input type="text" name="branch-lettings-phone" id="branch-lettings-phone" value="<?php if ( isset ( $branch_stored_meta['branch-lettings-phone'] ) ) echo $branch_stored_meta['branch-lettings-phone'][0]; ?>" />
			</div>
		</div>
		<div class="branch-row">
			<div class="branch-row-content">
				<label for="branch-lettings-email"><?php _e( 'Branch Lettings-email', 'yop-branch' )?></label>
				<input type="text" name="branch-lettings-email" id="branch-lettings-email" value="<?php if ( isset ( $branch_stored_meta['branch-lettings-email'] ) ) echo $branch_stored_meta['branch-lettings-email'][0]; ?>" />
			</div>
		</div>
		<div class="branch-row">
			<div class="branch-row-content">
				<label for="branch-lettings-fax"><?php _e( 'Branch Lettings-fax', 'yop-branch' )?></label>
				<input type="text" name="branch-lettings-fax" id="branch-lettings-fax" value="<?php if ( isset ( $branch_stored_meta['branch-lettings-fax'] ) ) echo $branch_stored_meta['branch-lettings-fax'][0]; ?>" />
			</div>
		</div>
	</div>
<?php
}

/**
 * Saves the custom team meta input
 */
function yop_properties_branch_meta_save( $post_id ) {
 
	// Checks save status
	$is_autosave = wp_is_post_autosave( $post_id );
	$is_revision = wp_is_post_revision( $post_id );
	$is_valid_nonce = ( isset( $_POST[ 'yop_properties_branch_main_nonce' ] ) && wp_verify_nonce( $_POST[ 'yop_properties_branch_main_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';

	// Exits script depending on save status
	if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
		return;
	}

	// Checks for input and sanitizes/saves if needed
	if( isset( $_POST[ 'branch-name' ] ) ) {
		update_post_meta( $post_id, 'branch-name', $_POST[ 'branch-name' ] );
	} else {
		delete_post_meta( $post_id, 'branch-name' );
	}
	// Checks for input and sanitizes/saves if needed
	if( isset( $_POST[ 'branch-address' ] ) ) {
		update_post_meta( $post_id, 'branch-address', $_POST[ 'branch-address' ] );
	} else {
		delete_post_meta( $post_id, 'branch-address' );
	}
	// Checks for input and sanitizes/saves if needed
	if( isset( $_POST[ 'branch-postcode' ] ) ) {
		update_post_meta( $post_id, 'branch-postcode', $_POST[ 'branch-postcode' ] );
	} else {
		delete_post_meta( $post_id, 'branch-postcode' );
	}
	// Checks for input and sanitizes/saves if needed
	if( isset( $_POST[ 'branch-latitude' ] ) ) {
		update_post_meta( $post_id, 'branch-latitude', $_POST[ 'branch-latitude' ] );
	} else {
		delete_post_meta( $post_id, 'branch-latitude' );
	}
	// Checks for input and sanitizes/saves if needed
	if( isset( $_POST[ 'branch-longitude' ] ) ) {
		update_post_meta( $post_id, 'branch-longitude', $_POST[ 'branch-longitude' ] );
	} else {
		delete_post_meta( $post_id, 'branch-longitude' );
	}
	// Checks for input and sanitizes/saves if needed
	if( isset( $_POST[ 'branch-sales-phone' ] ) ) {
		update_post_meta( $post_id, 'branch-sales-phone', $_POST[ 'branch-sales-phone' ] );
	} else {
		delete_post_meta( $post_id, 'branch-sales-phone' );
	}
	// Checks for input and sanitizes/saves if needed
	if( isset( $_POST[ 'branch-sales-email' ] ) ) {
		update_post_meta( $post_id, 'branch-sales-email', $_POST[ 'branch-sales-email' ] );
	} else {
		delete_post_meta( $post_id, 'branch-sales-email' );
	}
	// Checks for input and sanitizes/saves if needed
	if( isset( $_POST[ 'branch-sales-fax' ] ) ) {
		update_post_meta( $post_id, 'branch-sales-fax', $_POST[ 'branch-sales-fax' ] );
	} else {
		delete_post_meta( $post_id, 'branch-sales-fax' );
	}
	// Checks for input and sanitizes/saves if needed
	if( isset( $_POST[ 'branch-lettings-phone' ] ) ) {
		update_post_meta( $post_id, 'branch-lettings-phone', $_POST[ 'branch-lettings-phone' ] );
	} else {
		delete_post_meta( $post_id, 'branch-lettings-phone' );
	}
	// Checks for input and sanitizes/saves if needed
	if( isset( $_POST[ 'branch-lettings-email' ] ) ) {
		update_post_meta( $post_id, 'branch-lettings-email', $_POST[ 'branch-lettings-email' ] );
	} else {
		delete_post_meta( $post_id, 'branch-lettings-email' );
	}
	// Checks for input and sanitizes/saves if needed
	if( isset( $_POST[ 'branch-lettings-fax' ] ) ) {
		update_post_meta( $post_id, 'branch-lettings-fax', $_POST[ 'branch-lettings-fax' ] );
	} else {
		delete_post_meta( $post_id, 'branch-lettings-fax' );
	}

}
add_action( 'save_post', 'yop_properties_branch_meta_save' );


?>