<?php /* Static Name: Home Banner */ ?>
<?php
	if ( '' != of_get_option('home_banner_img') ) {
	echo "<figure class='home_page_banner'>";
	if ( '' != of_get_option('home_banner_url') ) {
		echo "<a href='" . esc_url( of_get_option('home_banner_url') ) . "'>";
	}
		echo "<img src='" . esc_url( of_get_option('home_banner_img') ) . "' alt=''>";
	if ( '' != of_get_option('home_banner_url') ) {
		echo "</a>";
	}
	echo "</figure>";
	}
?>