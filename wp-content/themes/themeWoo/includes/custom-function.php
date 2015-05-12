<?php
	// Loading child theme textdomain
	load_child_theme_textdomain( CURRENT_THEME, get_stylesheet_directory() . '/languages' );
	$tm_curr_theme = wp_get_theme();
	$tm_theme_texdomain = $tm_curr_theme->Name;


	// Include scripts and styles for Child Theme
	add_action( 'wp_enqueue_scripts', 'tm_enqueue_custom_script', 30 );
	function tm_enqueue_custom_script() {
		//wp_deregister_script('jquery');
		//wp_register_script( 'jquery', false, array( 'jquery-core', 'jquery-migrate' ), '1.10.2'  );
		//wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'custom-script', get_stylesheet_directory_uri() . '/js/custom-script.js', array( 'jquery' ), '1.0', true );
	}
	add_action( 'admin_enqueue_scripts', 'tm_enqueue_custom_css', 20 );
	function tm_enqueue_custom_css() {
		wp_enqueue_style( 'custom-admin', get_stylesheet_directory_uri() . '/includes/admin/custom-admin.css', false, '1.0' );
	}

	
	//Activate shop menu after data import
	function set_top_menu_on_import() {
	    	
    	if ( false === get_option( 'menus_seted' ) ) {
			$menus = get_terms('nav_menu');
			$save = array();
			foreach($menus as $menu) {
				if ($menu->name == 'Header Menu') {
			        $save['header_menu'] = $menu->term_id;
			    } elseif ($menu->name == 'Footer Menu') {
			        $save['footer_menu'] = $menu->term_id;
			    } elseif ($menu->name == 'Shop Menu') {
			    	$save['shop_menu'] = $menu->term_id;
			    }
			}
			if($save){
				remove_theme_mod( 'nav_menu_locations' );
			    set_theme_mod( 'nav_menu_locations', array_map( 'absint', $save ) );
			}
			add_option( 'menus_seted', 'true' );
		}

	}
	add_action( 'generate_rewrite_rules', 'set_top_menu_on_import', 30 );

	// Shop Options Management
	include_once ( CHILD_DIR . '/includes/options-management.php' );

	// Works only if Woocommerce activated
	if (class_exists('Woocommerce')) {

		add_filter('body_class','tm_add_plugin_name_to_body_class');
		function tm_add_plugin_name_to_body_class($classes) {
			if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
				$classes[] = 'has_woocommerce has_shop';
			}
			return $classes;
		}

		// Empty cart message
		add_action( 'wp_footer', 'empty_cart', 80 );
		function empty_cart() {
			$empty_cart_mess = of_get_option( 'empty_cart_mess' );
			?>
			<script>
			(function($) {
				$(window).load(function() {
					if ($('.widget_shopping_cart_content').is(':empty')) {
						$('.widget_shopping_cart_content').text('<?php echo $empty_cart_mess; ?>');
					}
				});
			})(jQuery);
			</script>
			<?php
		}

		// Products per page
		add_filter( 'loop_shop_per_page', 'tm_product_per_page', 20 );
		function tm_product_per_page() {
			$prod_number = of_get_option( 'prod_per_page' );
			if (!$prod_number) $prod_number = 8;
			return $prod_number;
		}

		// Theme Actions
		get_template_part( 'includes/theme-actions' );
		// Theme Shortcodes
		get_template_part( 'includes/child-shortcodes' );

		// Template Wrappers
		function tm_open_shop_content_wrappers(){
			echo '<div class="motopress-wrapper content-holder clearfix woocommerce">
					<div class="container">
						<div class="row">
							<div class="span12" data-motopress-type="static" data-motopress-static-file="static/static-title.php">';
								echo get_template_part("static/static-title");
			echo 			'</div>
						</div>
						<div class="row">
							<div class="span8" id="content">';
		}
		function tm_close_shop_content_wrappers(){
			echo			'</div>
							<div class="span4 sidebar" id="sidebar" data-motopress-type="static-sidebar"  data-motopress-sidebar-file="sidebar.php">';
								get_sidebar();
			echo			'</div>
						</div>
					</div>
				</div>';
		}

		function tm_prepare_shop_wrappers(){
			/* Woocommerce */
			remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
			remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
			remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5, 0);
			remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);
			remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);

			add_action('woocommerce_before_main_content', 'tm_open_shop_content_wrappers', 10);
			add_action('woocommerce_after_main_content', 'tm_close_shop_content_wrappers', 10);
			/* end Woocommerce */	
		}
		add_action('wp_head', 'tm_prepare_shop_wrappers');
		add_theme_support( 'woocommerce' );

		add_action('woocommerce_share', 'tm_product_share');
		function tm_product_share() {
			get_template_part( 'includes/post-formats/share-buttons' );
		}


		// Custom Links for Shop Menu
		function login_out_function ($nav, $args){
			
		  if( 'shop_menu' === $args -> theme_location ) {
			if(of_get_option("login_display_id")=="yes"){
	      		$username = (get_current_user_id()!=0) ? get_userdata(get_current_user_id())->user_login : '';
	      		$user_title = str_replace("%username%", $username, of_get_option("site_admin"));
			    $link_string_site = "<a href=\"".get_bloginfo('wpurl')."/wp-admin/index.php\" class='register-link' title=\"".$user_title."\">".$user_title."</a>";
				$link_string_logout = '<a href="'. wp_logout_url($_SERVER['REQUEST_URI']) .'" title="'.of_get_option("log_out").'">'.of_get_option("log_out").'</a>';
				$link_string_register = "<a href=\"".get_bloginfo('wpurl')."/wp-login.php?action=register&amp;redirect_to=".$_SERVER['REQUEST_URI']."\" class='register-link' title=\"".of_get_option("sign_up")."\">".of_get_option("sign_up")."</a>";
				$link_string_login = "<a href=\"".get_bloginfo('wpurl')."/wp-login.php?action=login&amp;redirect_to=".$_SERVER['REQUEST_URI']."\" title=\"".of_get_option("sign_in")."\">".of_get_option("sign_in")."</a>";
		
				if (!is_user_logged_in()) {
		        	$login_links = "<li>".$link_string_register."</li><li>".$link_string_login."</li>";
		     	}else{
		        	$login_links = "<li>".$link_string_site."</li><li>".$link_string_logout."</li>";
				}
				$nav = $login_links.$nav;
				return $nav;
			} else {
				return $nav;
			}
		  } else {
			  return $nav;
		  }
		}
		add_filter('wp_nav_menu_items','login_out_function', 10, 2);

	}

	// WP Pointers
	add_action('admin_enqueue_scripts', 'myHelpPointers');
	function myHelpPointers() {
	//First we define our pointers 
	$pointers = array(
	   	array(
	       'id' => 'xyz1',   // unique id for this pointer
	       'screen' => 'options-permalink', // this is the page hook we want our pointer to show on
	       'target' => '#submit', // the css selector for the pointer to be tied to, best to use ID's
	       'title' => theme_locals("submit_permalink"),
	       'content' => theme_locals("submit_permalink_desc"),
	       'position' => array( 
	                          'edge' => 'top', //top, bottom, left, right
	                          'align' => 'left', //top, bottom, left, right, middle
	                          'offset' => '0 5'
	                          )
	       ),

	    array(
	       'id' => 'xyz2',   // unique id for this pointer
	       'screen' => 'themes', // this is the page hook we want our pointer to show on
	       'target' => '#toplevel_page_options-framework', // the css selector for the pointer to be tied to, best to use ID's
	       'title' => theme_locals("import_sample_data"),
	       'content' => theme_locals("import_sample_data_desc"),
	       'position' => array( 
	                          'edge' => 'bottom', //top, bottom, left, right
	                          'align' => 'top', //top, bottom, left, right, middle
	                          'offset' => '0 -10'
	                          )
	       ),

	    array(
	       'id' => 'xyz3',   // unique id for this pointer
	       'screen' => 'toplevel_page_options-framework', // this is the page hook we want our pointer to show on
	       'target' => '#toplevel_page_options-framework', // the css selector for the pointer to be tied to, best to use ID's
	       'title' => theme_locals("import_sample_data"),
	       'content' => theme_locals("import_sample_data_desc_2"),
	       'position' => array( 
	                          'edge' => 'left', //top, bottom, left, right
	                          'align' => 'top', //top, bottom, left, right, middle
	                          'offset' => '0 18'
	                          )
	       )
	    // more as needed
	    );
		//Now we instantiate the class and pass our pointer array to the constructor 
		$myPointers = new WP_Help_Pointer($pointers); 
	};
?>