<?php

if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * Plugin Name:       Custom Google Places Reviews
 * Plugin URI:		  http://coresol.pk
 * Description:       Custom Google Places Reviews Display your Google business pages reviews on your website just by adding a shortcode [google_palce_reviews]
 * Version:           1.0.0
 * Author:            Mustaneer Abdullah
 * Author URI:		  https://profiles.wordpress.org/mustaneerabdullah93
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

	
function custom_google_enqueue_scripts(){
	wp_register_style( 'cgpr-custom-google-place', plugin_dir_url( __FILE__ ) . 'css/custom-google-place.css', array(), '' );
	wp_enqueue_style( 'cgpr-custom-google-place' );
}
add_action( 'wp_enqueue_scripts', 'custom_google_enqueue_scripts', 10 );

// Register Custom Post Type
function custom_cgpr_google_palce_reviews_post_type() {

    $labels = array(
        'name'                  => _x( 'Google Place Reviews', 'Post Type General Name', 'custom_googlepalcereviews' ),
        'singular_name'         => _x( 'Google Place Review', 'Post Type Singular Name', 'custom_googlepalcereviews' ),
        'menu_name'             => __( 'Google Place Reviews', 'custom_googlepalcereviews' ),
        'name_admin_bar'        => __( 'Google Place Review', 'custom_googlepalcereviews' ),
        'archives'              => __( 'Item Archives', 'custom_googlepalcereviews' ),
        'attributes'            => __( 'Item Attributes', 'custom_googlepalcereviews' ),
        'parent_item_colon'     => __( 'Parent Item:', 'custom_googlepalcereviews' ),
        'all_items'             => __( 'All Items', 'custom_googlepalcereviews' ),
        'add_new_item'          => __( 'Add New Item', 'custom_googlepalcereviews' ),
        'add_new'               => __( 'Add New', 'custom_googlepalcereviews' ),
        'new_item'              => __( 'New Item', 'custom_googlepalcereviews' ),
        'edit_item'             => __( 'Edit Item', 'custom_googlepalcereviews' ),
        'update_item'           => __( 'Update Item', 'custom_googlepalcereviews' ),
        'view_item'             => __( 'View Item', 'custom_googlepalcereviews' ),
        'view_items'            => __( 'View Items', 'custom_googlepalcereviews' ),
        'search_items'          => __( 'Search Item', 'custom_googlepalcereviews' ),
        'not_found'             => __( 'Not found', 'custom_googlepalcereviews' ),
        'not_found_in_trash'    => __( 'Not found in Trash', 'custom_googlepalcereviews' ),
        'featured_image'        => __( 'Featured Image', 'custom_googlepalcereviews' ),
        'set_featured_image'    => __( 'Set featured image', 'custom_googlepalcereviews' ),
        'remove_featured_image' => __( 'Remove featured image', 'custom_googlepalcereviews' ),
        'use_featured_image'    => __( 'Use as featured image', 'custom_googlepalcereviews' ),
        'insert_into_item'      => __( 'Insert into item', 'custom_googlepalcereviews' ),
        'uploaded_to_this_item' => __( 'Uploaded to this item', 'custom_googlepalcereviews' ),
        'items_list'            => __( 'Items list', 'custom_googlepalcereviews' ),
        'items_list_navigation' => __( 'Items list navigation', 'custom_googlepalcereviews' ),
        'filter_items_list'     => __( 'Filter items list', 'custom_googlepalcereviews' ),
    );
    $args = array(
        'label'                 => __( 'Google Place Review', 'custom_googlepalcereviews' ),
        'description'           => __( 'Google Place Review', 'custom_googlepalcereviews' ),
        'labels'                => $labels,
        'supports'              => array( 'title' ),
        'hierarchical'          => false,
        'public'                => false,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 31,
        'menu_icon'             => 'dashicons-admin-comments',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => false,
        'exclude_from_search'   => true,
        'publicly_queryable'    => false,
    );
    register_post_type( 'google_palce_reviews', $args );

}
add_action( 'init', 'custom_cgpr_google_palce_reviews_post_type', 0 );


function wpt_add_cgpr_metaboxes() {
    add_meta_box(
        'wpt_cgpr_google_palce_reviews_location',
        __( 'Google Place Reviews', 'custom_googlepalcereviews' ),
        'wpt_cgpr_google_palce_reviews_location',
        'google_palce_reviews',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'wpt_add_cgpr_metaboxes' );
/**
 * Output the HTML for the metabox.
 */
function wpt_cgpr_google_palce_reviews_location() {
    global $post;
    // Nonce field to validate form request came from current site
    wp_nonce_field( basename( __FILE__ ), 'cgpr_google_palce_reviews_fields' );
    // Get the location data if it's already been entered
    $google_palce_id = get_post_meta( $post->ID, 'google_palce_id', true );
    $google_api_key = get_post_meta( $post->ID, 'google_api_key', true );
    // Output the field
    echo '<h2 class="hndle ui-sortable-handle" style="padding-left: 0;"><span>'. __( 'Google API Key', 'custom_googlepalcereviews' ) .'</span></h2>';
    echo '<input type="text" name="google_api_key" value="' . esc_textarea( $google_api_key )  . '" class="widefat">';
	echo '<h2 class="hndle ui-sortable-handle" style="padding-left: 0;"><span>'. __( 'Google Place ID', 'custom_googlepalcereviews' ) .'</span></h2>';
    echo '<input type="text" name="google_palce_id" value="' . esc_textarea( $google_palce_id )  . '" class="widefat">';
	echo '<h1 class="hndle ui-sortable-handle" style="padding-left: 0;"><span>Shortcode</span></h1>';
    echo "<p style='font-size:16px;'>[google_palce_reviews pid=". $post->ID ."]</p>";
	echo '<h1 class="hndle ui-sortable-handle" style="padding-left: 0;">'. __( 'Get a Google API Key', 'custom_googlepalcereviews' ) .'</h1><p style="font-size:16px;">1. Go to the <a href="https://console.developers.google.com/flows/enableapi?apiid=places_backend,maps_backend,geocoding_backend,directions_backend,distance_matrix_backend,elevation_backend&keyType=CLIENT_SIDE&reusekey=true&pli=1" target="_blank">'. __( 'Get a Google API Key', 'custom_googlepalcereviews' ) .'</a></p><p style="font-size:16px;">2. Create or select a project.</p><p style="font-size:16px;">3. Click Continue to enable the API and any related services..</p><p style="font-size:16px;">4. On the Credentials page, Select API Key get a Browser key (and set the API Credentials) </p>';
	echo '<h1 class="hndle ui-sortable-handle" style="padding-left: 0;">Get a Place ID</h1><p style="font-size:16px;">1. Go to the <a href="https://developers.google.com/places/place-id" target="_blank">Get Place ID</a></p><p style="font-size:16px;">2. Enter location, copy the Place ID</p>';
    
}
/**
 * Save the metabox data
 */
function wpt_save_cgpr_google_palce_reviews_meta( $post_id, $post ) {
    // Return if the user doesn't have edit permissions.
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return $post_id;
    }
    // Verify this came from the our screen and with proper authorization,
    // because save_post can be triggered at other times.
    if ( ! isset( $_POST['google_palce_id'] ) || ! wp_verify_nonce( $_POST['cgpr_google_palce_reviews_fields'], basename(__FILE__) ) ) {
        return $post_id;
    }
    // Now that we're authenticated, time to save the data.
    // This sanitizes the data from the field and saves it into an array $cgpr_google_palce_reviews_meta.
    $cgpr_google_palce_reviews_meta['google_palce_id'] = esc_html( $_POST['google_palce_id'] );
    $cgpr_google_palce_reviews_meta['google_api_key'] = esc_html( $_POST['google_api_key'] );

    // Cycle through the $cgpr_google_palce_reviews_meta array.
    // Note, in this example we just have one item, but this is helpful if you have multiple.
    foreach ( $cgpr_google_palce_reviews_meta as $key => $value ) :

        if ( get_post_meta( $post_id, $key, false ) ) {
            // If the custom field already has a value, update it.
            update_post_meta( $post_id, $key, $value );
        } else {
            // If the custom field doesn't have a value, add it.
            add_post_meta( $post_id, $key, $value);
        }
        if ( ! $value ) {
            // Delete the meta key if there's no value
            delete_post_meta( $post_id, $key );
        }
    endforeach;
}
add_action( 'save_post', 'wpt_save_cgpr_google_palce_reviews_meta', 1, 2 );


add_filter( 'manage_google_palce_reviews_posts_columns', 'set_custom_edit_cgpr_google_palce_reviews_columns' );
function set_custom_edit_cgpr_google_palce_reviews_columns($columns) {
    unset( $columns['author'] );
    $columns['cgpr_google_palce_reviews_shortcode'] = __( 'Shortcode', 'custom_googlepalcereviews' );
    $columns['google_palce_id'] = __( 'Google Place ID', 'custom_googlepalcereviews' );
    $columns['google_api_key'] = __( 'Google API Key', 'custom_googlepalcereviews' );
	$new = array();
   
    foreach($columns as $key=>$value) {
        if($key=='date') {  // when we find the date column
           $new['cgpr_google_palce_reviews_shortcode'] = $column['cgpr_google_palce_reviews_shortcode']; 
           $new['google_api_key'] = $column['google_api_key'];
           $new['google_palce_id'] = $column['google_palce_id'];
        }    
        $new[$key]=$value;
    }  
    return $new;
}

// Add the data to the custom columns for the cgpr_google_palce_reviews post type:
add_action( 'manage_google_palce_reviews_posts_custom_column' , 'custom_cgpr_google_palce_reviews_column', 10, 2 );
function custom_cgpr_google_palce_reviews_column( $column, $post_id ) {
    switch ( $column ) {

        case 'cgpr_google_palce_reviews_shortcode' :
            $name = strtolower(get_post_meta( $post_id , 'google_palce_id' , true ));
            echo "[google_palce_reviews pid=". $post_id ."]";
            break;

        case 'google_api_key' :
            echo get_post_meta( $post_id , 'google_api_key' , true );
            break;
			
        case 'google_palce_id' :
            echo get_post_meta( $post_id , 'google_palce_id' , true );
            break;
    }
	
}

function custom_cgpr_google_palce_reviews_post_shortcode(){
	// Set the arguments for the query
	$args = array(
	  'numberposts'		=> -1, // -1 is for all
	  'post_type'		=> 'google_palce_reviews', // or 'post', 'page'
	  'orderby' 		=> 'ID', // or 'date', 'rand'
	  'order' 		=> 'ASC', // or 'DESC'
	  'post_status' => 'publish',
	);

	// Get the posts
	$myposts = get_posts($args);

	// If there are posts
	if($myposts):
		// Loop the posts
		foreach ($myposts as $mypost):			
			add_shortcode("google_palce_reviews", 'cgpr_google_palce_reviews_shortcode_function');
		endforeach;
	wp_reset_postdata();
	endif;
}

add_action( 'init', 'custom_cgpr_google_palce_reviews_post_shortcode', 0 );
function cgpr_google_palce_reviews_shortcode_function($atts){
    extract(shortcode_atts(array(
        'pid' => 0,
    ), $atts));
	
	ob_start();
		include_once( 'include/display_page.php' );	
	$datas = ob_get_clean();
	return $datas;
}

function cgpr_google_time_elapsed_string($datetime, $full = false) {
	$time_difference = time() - $datetime;

    if( $time_difference < 1 ) { return 'less than 1 second ago'; }
    $condition = array( 12 * 30 * 24 * 60 * 60 =>  'year',
                30 * 24 * 60 * 60       =>  'month',
                24 * 60 * 60            =>  'day',
                60 * 60                 =>  'hour',
                60                      =>  'minute',
                1                       =>  'second'
    );

    foreach( $condition as $secs => $str )
    {
        $d = $time_difference / $secs;

        if( $d >= 1 )
        {
            $t = round( $d );
            return 'about ' . $t . ' ' . $str . ( $t > 1 ? 's' : '' ) . ' ago';
        }
    }
}