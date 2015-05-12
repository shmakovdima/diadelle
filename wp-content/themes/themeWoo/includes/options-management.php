<?php
/**
 * Shop Options Managment 
*/

//Init shop options BackUp post type
add_action( 'init', 'initOptionsPost', 10);
function initOptionsPost() {
	register_post_type( 'shop_options',
		array( 
			'label'               => 'shop_options', 
			'singular_label'      => 'shop_options',
			'exclude_from_search' => true, // Exclude from Search Results
			'capability_type'     => 'page',
			'public'              => true, 
			'show_ui'             => false,
			'show_in_nav_menus'   => false,
			'supports'  => array('title', 'custom-fields')
		)
	);
}

//Create post for shop options
add_action( 'woocommerce_update_options', 'createOptionsPost', 40);
function createOptionsPost() {
	$args = array( 'posts_per_page' => 1, 'post_type'=> 'shop_options' );
	$opt_post = get_posts( $args );
	if ( !$opt_post ) {
		$post = array(
		  'post_name' => 'shop-options',
		  'post_title' => 'shop-options',
		  'post_type' => 'shop_options',
		  'post_status' => 'publish'
		);
		$post_id = wp_insert_post( $post );
	}

}

//First time write options top post
add_action( 'woocommerce_update_options', 'addOptions', 50);
function addOptions() {
	$args = array( 'posts_per_page' => 1, 'post_type'=> 'shop_options' );
	$opt_post = get_posts( $args );
	$opt_to_rewrite = array('woocommerce_default_country', 'woocommerce_currency', 'woocommerce_shop_page_id', 'woocommerce_cart_page_id', 'woocommerce_checkout_page_id', 'woocommerce_pay_page_id', 'woocommerce_thanks_page_id', 'woocommerce_myaccount_page_id', 'woocommerce_edit_address_page_id', 'woocommerce_view_order_page_id', 'woocommerce_change_password_page_id', 'woocommerce_logout_page_id', 'woocommerce_lost_password_page_id', 'woocommerce_default_catalog_orderby');
	$s_opt_to_rewrite = array('shop_catalog_image_size', 'shop_single_image_size', 'shop_thumbnail_image_size');
	if ( $opt_post ) {
		$all_options = wp_load_alloptions();
		foreach ( $opt_post as $post ) {
			foreach( $all_options as $name => $value ) {
				if( in_array($name, $opt_to_rewrite)) {
					$already_exist = get_post_meta( $post->ID, $name );
					if( empty( $already_exist ) ) {
						add_post_meta($post->ID, $name, $value, true);
					} 
				} elseif ( in_array($name, $s_opt_to_rewrite)) {
					$already_exist = get_post_meta( $post->ID, $name );
					if( empty( $already_exist ) ) {
						$value = unserialize($value);
						add_post_meta($post->ID, $name, $value, true);
					}
				}
			}
		}
	}
}

//Update shop options backup in post meta
add_action( 'woocommerce_update_options', 'updateOptions', 60);
function updateOptions() {

	$args = array( 'posts_per_page' => 1, 'post_type'=> 'shop_options' );
	$opt_post = get_posts( $args );
	$opt_to_rewrite = array('woocommerce_default_country', 'woocommerce_currency', 'woocommerce_shop_page_id', 'woocommerce_cart_page_id', 'woocommerce_checkout_page_id', 'woocommerce_pay_page_id', 'woocommerce_thanks_page_id', 'woocommerce_myaccount_page_id', 'woocommerce_edit_address_page_id', 'woocommerce_view_order_page_id', 'woocommerce_change_password_page_id', 'woocommerce_logout_page_id', 'woocommerce_lost_password_page_id', 'woocommerce_default_catalog_orderby');
	$s_opt_to_rewrite = array('shop_catalog_image_size', 'shop_single_image_size', 'shop_thumbnail_image_size');
	if ( $opt_post ) {
		$all_options = wp_load_alloptions();
		foreach ( $opt_post as $post ) {
			foreach( $all_options as $name => $value ) {
				if ( in_array($name, $opt_to_rewrite)) {
					update_post_meta($post->ID, $name, $value);
				} elseif ( in_array($name, $s_opt_to_rewrite)) {
					$value = unserialize($value);
					update_post_meta($post->ID, $name, $value);
				}
			}
		}
	}
		
}

//Remove old shop pages when new are imported
add_action( 'import_start', 'removeShopPages');
function removeShopPages() {
	$shop_pages = array('woocommerce_shop_page_id', 'woocommerce_terms_page_id', 'woocommerce_cart_page_id', 'woocommerce_checkout_page_id', 'woocommerce_pay_page_id', 'woocommerce_thanks_page_id', 'woocommerce_myaccount_page_id', 'woocommerce_edit_address_page_id', 'woocommerce_view_order_page_id', 'woocommerce_change_password_page_id', 'woocommerce_logout_page_id', 'woocommerce_lost_password_page_id');
	$pages_removed = get_option( 'pages_removed' );
	if ( ( false != $shop_pages ) && ( false === $pages_removed ) ) {
		foreach($shop_pages as $page) {
			$page_id = get_option($page);
			wp_delete_post( $page_id, true );
		}
		update_option( 'pages_removed', 'removed' );
	}
}

//Rewrite shop options on import
add_action( 'import_post_meta', 'extractOptions', 30, 3);
function extractOptions($post_id, $key, $value) {
	$args = array( 'posts_per_page' => 1, 'post_type'=> 'shop_options' );
	$opt_post = get_posts( $args );
	$opt_to_rewrite = array('woocommerce_default_country', 'woocommerce_currency', 'woocommerce_shop_page_id', 'woocommerce_cart_page_id', 'woocommerce_checkout_page_id', 'woocommerce_pay_page_id', 'woocommerce_thanks_page_id', 'woocommerce_myaccount_page_id', 'woocommerce_edit_address_page_id', 'woocommerce_view_order_page_id', 'woocommerce_change_password_page_id', 'woocommerce_logout_page_id', 'woocommerce_lost_password_page_id', 'woocommerce_default_catalog_orderby');
	$s_opt_to_rewrite = array('shop_catalog_image_size', 'shop_single_image_size', 'shop_thumbnail_image_size');
	if ( $opt_post ) {
		foreach ( $opt_post as $post ) {
			$meta_options = get_post_meta( $post->ID );
			if ($post_id == $post->ID) {
				if( in_array($key, $opt_to_rewrite)) {
					update_option( $key, $value );
					//echo $name . "-" . $value[0];
				} elseif ( in_array($key, $s_opt_to_rewrite)) {
					$single_meta = get_post_meta( $post->ID, $key, true );
					//$value = unserialize($value[0]);
					//echo $name . ":";
					$new_values = array();
					foreach ($single_meta as $new_key => $new_value) {
						$new_values[$new_key] = $new_value;
					}
					//$name = '_'.$name;
					update_option( $key, $new_values );
				}
			}
		}
	}
}

//Regenerate catalog images on permalinks update
add_action('generate_rewrite_rules', 'regenerate_catalog_images');
function regenerate_catalog_images() {
	$regenerated = get_option('regenerated_attach');
	if (false == $regenerated ) { 
		if (!function_exists('wp_generate_attachment_metadata')) {
			include( ABSPATH . 'wp-admin/includes/image.php' );
		}
		$post_args = array(
			'posts_per_page'   => -1,
			'post_type'        => 'product'
		);
		$all_products = get_posts( $post_args );
		$attach_num = 0;
		$last_product = 0;
		$last_attach = 0;
		foreach($all_products as $product) {
			$img_args = array(
				'posts_per_page'   => -1,
				'post_type'        => 'attachment',
				'post_parent'	   => $product->ID
			);
			$last_product = $product->ID;
			$prod_attach = get_posts( $img_args );
			foreach($prod_attach as $attach) {
				$attach_id = $attach->ID;
				$filename = get_attached_file( $attach_id );
				$attach_data = wp_generate_attachment_metadata( $attach_id, $filename );
				wp_update_attachment_metadata( $attach_id,  $attach_data );	
				$last_attach = $attach_id;
				$attach_num ++;
			}
		}
		update_option('regenerated_attach', $attach_num);
		delete_transient( 'wc_attribute_taxonomies' );
		//update_option('last_prod', $last_product);
		//update_option('last_attach', $last_attach);
	}
}

//Import product attributes fix for woocommerce
add_action('import_start', 'tm_import_start', 10);
function tm_import_start() {
	global $wpdb;

	if (!isset($_POST['import_id'])) return;
	if (!class_exists('WXR_Parser')) return;

	$id = (int) $_POST['import_id'];
	$file = get_attached_file( $id );

	$parser = new WXR_Parser();
	$import_data = $parser->parse( $file );

	if (isset($import_data['posts'])) :
		$posts = $import_data['posts'];

		if ($posts && sizeof($posts)>0) foreach ($posts as $post) :

			if ($post['post_type']=='product') :

				if ($post['terms'] && sizeof($post['terms'])>0) :

					foreach ($post['terms'] as $term) :

						$domain = $term['domain'];

						if (strstr($domain, 'pa_')) :

							// Make sure it exists!
							if (!taxonomy_exists( $domain )) :

								$nicename = strtolower(sanitize_title(str_replace('pa_', '', $domain)));

								$exists_in_db = $wpdb->get_var( $wpdb->prepare( "SELECT attribute_id FROM " . $wpdb->prefix . "woocommerce_attribute_taxonomies WHERE attribute_name = %s;", $nicename ) );

								if (!$exists_in_db) :

									// Create the taxonomy
									$wpdb->insert( $wpdb->prefix . "woocommerce_attribute_taxonomies", array( 'attribute_name' => $nicename, 'attribute_label' => $nicename, 'attribute_type' => 'select', 'attribute_orderby' => 'menu_order' ), array( '%s', '%s', '%s' ) );

								endif;

								// Register the taxonomy now so that the import works!
								register_taxonomy( $domain,
							        apply_filters( 'woocommerce_taxonomy_objects_' . $domain, array('product') ),
							        apply_filters( 'woocommerce_taxonomy_args_' . $domain, array(
							            'hierarchical' => true,
							            'show_ui' => false,
							            'query_var' => true,
							            'rewrite' => false,
							        ) )
							    );

							endif;

						endif;

					endforeach;

				endif;

			endif;

		endforeach;

	endif;

}

//Check if Woocommerce is not activated on import start
add_action( 'check_shop_activation', 'check_woo' );
function check_woo() {
	if ( !in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
		echo "<div class='note'>" . theme_locals('woocommerce_attention') . "</div>";
	}
}
?>