<?php /* Static Name: Search */ ?>
<div class="inner_wrap">
	<!-- BEGIN SEARCH FORM -->
	<?php if ( of_get_option('g_search_box_id') == 'yes') { ?>
		<div class="search-form search-form__h">
			<form id="search-header" method="get" action="<?php echo home_url(); ?>/" accept-charset="utf-8">
				<input type="text" name="s" placeholder="<?php echo theme_locals('search'); ?>" class="search-form_it">
				<a href="#" id="search-form_is" onClick="document.getElementById('search-header').submit()"><i class="icon-search"></i></a>
			</form>
		</div>
	<?php } ?>
	<!-- END SEARCH FORM -->
	<?php dynamic_sidebar( 'cart-holder' ); ?>
</div>