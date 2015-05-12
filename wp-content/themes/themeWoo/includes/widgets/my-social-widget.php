<?php
// =============================== My Social Networks Widget ====================================== //
class My_SocialNetworksWidget extends WP_Widget {

	function My_SocialNetworksWidget() {
		$widget_ops = array('classname' => 'social_networks_widget', 'description' => theme_locals("social_networks_desc"));
		$this->WP_Widget('social_networks', theme_locals("social_networks"), $widget_ops);
	}

	function widget( $args, $instance ) {
		extract($args);
		$title = apply_filters('widget_title', $instance['title']);
		
		$message = $instance['message'];
		$soc_title = $instance['soc_title'];

		$networks['Twitter']['link'] = $instance['twitter'];
		$networks['Facebook']['link'] = $instance['facebook'];
		$networks['Pinterest']['link'] = $instance['pinterest'];
		$networks['Linkedin']['link'] = $instance['linkedin'];
		$networks['Google+']['link'] = $instance['google'];
		$networks['Instagram']['link'] = $instance['instagram'];
		$networks['rss']['link'] = $instance['rss'];
		
		$networks['Twitter']['label'] = $instance['twitter_label'];
		$networks['Facebook']['label'] = $instance['facebook_label'];
		$networks['Pinterest']['label'] = $instance['pinterest_label'];
		$networks['Linkedin']['label'] = $instance['linkedin_label'];
		$networks['Google+']['label'] = $instance['google_label'];
		$networks['Instagram']['label'] = $instance['instagram_label'];
		$networks['rss']['label'] = $instance['rss_label'];

		$display = $instance['display'];
		
		echo $before_widget;
		if ( $title )
			echo $before_title . $title . $after_title;
		?>
			<!-- BEGIN SOCIAL NETWORKS -->
			<?php if ($display == "both" or $display =="labels") {
				$addClass = "social__list";
			} elseif ($display == "icons") { 
				$addClass = "social__row clearfix";
			} ?>
			<?php if ($message) { ?>
			<div class="social_message">
				<i class="icon-home"></i>
				<p><?php echo $message; ?></p>
			</div>
			<?php } 

			if ( $soc_title )
			echo $before_title . $soc_title . $after_title;
			?>
			<ul class="social <?php echo $addClass ?> unstyled">
				
			<?php foreach(array("Google+", "Pinterest", "Twitter", "Facebook", "Feed", "Linkedin", "rss", "Instagram") as $network) : ?>
	    		<?php if (!empty($networks[$network]['link'])) : ?>
				<li class="social_li">

					<?php 
						$network_icon = $network;
						if($network == 'Google+') {
							$network_icon = "google-plus";
						} 
					?>
					<a class="social_link social_link__<?php echo strtolower($network); ?>" rel="tooltip" data-original-title="<?php echo strtolower($network); ?>" href="<?php echo $networks[$network]['link']; ?>">
				    	<?php if (($display == "both") or ($display =="icons")) { ?>
							<i class="icon-<?php echo strtolower($network_icon);?>"></i>
						<?php } if (($display == "labels") or ($display == "both")) { ?> 
							<span class="social_label"><?php if (($networks[$network]['label'])!=="") { echo $networks[$network]['label']; } else { echo $network; } ?></span>
						<?php } ?>
					</a>
				</li>
				<?php endif; ?>
			<?php endforeach; ?>
			  
		</ul>
		<!-- END SOCIAL NETWORKS -->
	  
		<?php
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		
		$instance['message'] = $new_instance['message'];
		$instance['soc_title'] = $new_instance['soc_title'];

		$instance['twitter'] = $new_instance['twitter'];
		$instance['facebook'] = $new_instance['facebook'];
		$instance['pinterest'] = $new_instance['pinterest'];
		$instance['linkedin'] = $new_instance['linkedin'];
		$instance['google'] = $new_instance['google'];
		$instance['instagram'] = $new_instance['instagram'];
		$instance['rss'] = $new_instance['rss'];
		
		$instance['twitter_label'] = $new_instance['twitter_label'];
		$instance['facebook_label'] = $new_instance['facebook_label'];
		$instance['pinterest_label'] = $new_instance['pinterest_label'];
		$instance['linkedin_label'] = $new_instance['linkedin_label'];
		$instance['google_label'] = $new_instance['google_label'];
		$instance['instagram_label'] = $new_instance['instagram_label'];
		$instance['rss_label'] = $new_instance['rss_label'];

		$instance['display'] = $new_instance['display'];

		return $instance;
	}

	function form( $instance ) {
		/* Set up some default widget settings. */
		$defaults = array( 'title' => '', 'twitter' => '', 'twitter_label' => '', 'facebook' => '', 'facebook_label' => '', 'Pinterest' => '', 'Pinterest_label' => '', 'feed' => '', 'feed_label' => '', 'linkedin' => '', 'linkedin_label' => '', 'delicious' => '', 'delicious_label' => '', 'youtube' => '', 'youtube_label' => '', 'google' => '', 'google_label' => '', 'display' => 'icons', 'text' => '');
		$instance = wp_parse_args( (array) $instance, $defaults );
		
		$message = $instance['message'];
		$soc_title = $instance['soc_title'];

		$twitter = $instance['twitter'];		
		$facebook = $instance['facebook'];
		$pinterest = $instance['pinterest'];		
		$linkedin = $instance['linkedin'];	
		$google = $instance['google'];
		$instagram = $instance['instagram'];
		$rss = $instance['rss'];
		
		$twitter_label = $instance['twitter_label'];
		$facebook_label = $instance['facebook_label'];
		$pinterest_label = $instance['pinterest_label'];
		$linkedin_label = $instance['linkedin_label'];
		$google_label = $instance['google_label'];
		$instagram_label = $instance['instagram_label'];
		$rss_label = $instance['rss_label'];

		$display = $instance['display'];		
		$title = strip_tags($instance['title']);
		$text = format_to_edit($instance['text']);
?>
	<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php theme_locals("title") ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>

	<p><label for="<?php echo $this->get_field_id('message'); ?>"><?php echo 'Message text:' ?></label>
	<textarea class="widefat" id="<?php echo $this->get_field_id('message'); ?>" name="<?php echo $this->get_field_name('message'); ?>"><?php echo esc_attr($message); ?></textarea>

	<p><label for="<?php echo $this->get_field_id('soc_title'); ?>"><?php echo 'Socials list title' ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('soc_title'); ?>" name="<?php echo $this->get_field_name('soc_title'); ?>" type="text" value="<?php echo esc_attr($soc_title); ?>" /></p>

	<fieldset style="border:1px solid #dfdfdf; padding:10px 10px 0; margin-bottom:1em;">
		<legend style="padding:0 5px;"><?php echo 'Facebook' ?>:</legend>
		
		<p><label for="<?php echo $this->get_field_id('facebook'); ?>"><?php echo 'Facebook URL:' ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('facebook'); ?>" name="<?php echo $this->get_field_name('facebook'); ?>" type="text" value="<?php echo esc_attr($facebook); ?>" /></p>
		
		<p><label for="<?php echo $this->get_field_id('facebook_label'); ?>"><?php echo 'Facebook '.theme_locals("label") ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('facebook_label'); ?>" name="<?php echo $this->get_field_name('facebook_label'); ?>" type="text" value="<?php echo esc_attr($facebook_label); ?>" /></p>
	</fieldset>	
	
	<fieldset style="border:1px solid #dfdfdf; padding:10px 10px 0; margin-bottom:1em;">
		<legend style="padding:0 5px;"><?php echo 'Twitter' ?>:</legend>	
	<p><label for="<?php echo $this->get_field_id('twitter'); ?>"><?php echo 'Twitter URL:' ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('twitter'); ?>" name="<?php echo $this->get_field_name('twitter'); ?>" type="text" value="<?php echo esc_attr($twitter); ?>" /></p>
	<p><label for="<?php echo $this->get_field_id('twitter_label'); ?>"><?php echo 'Twitter '.theme_locals("label") ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('twitter_label'); ?>" name="<?php echo $this->get_field_name('twitter_label'); ?>" type="text" value="<?php echo esc_attr($twitter_label); ?>" /></p>
	</fieldset>	
	
	<fieldset style="border:1px solid #dfdfdf; padding:10px 10px 0; margin-bottom:1em;">
			<legend style="padding:0 5px;"><?php echo 'Linkedin' ?>:</legend>
	<p><label for="<?php echo $this->get_field_id('linkedin'); ?>"><?php echo 'Linkedin URL:' ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('linkedin'); ?>" name="<?php echo $this->get_field_name('linkedin'); ?>" type="text" value="<?php echo esc_attr($linkedin); ?>" /></p>
		<p><label for="<?php echo $this->get_field_id('linkedin_label'); ?>"><?php echo 'Linkedin '.theme_locals("label") ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('linkedin_label'); ?>" name="<?php echo $this->get_field_name('linkedin_label'); ?>" type="text" value="<?php echo esc_attr($linkedin_label); ?>" /></p>
	</fieldset>	
	
	<fieldset style="border:1px solid #dfdfdf; padding:10px 10px 0; margin-bottom:1em;">
		<legend style="padding:0 5px;"><?php echo 'Google+'; ?>:</legend>
		<p>
			<label for="<?php echo $this->get_field_id('google'); ?>"><?php echo 'Google+ URL:'; ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('google'); ?>" name="<?php echo $this->get_field_name('google'); ?>" type="text" value="<?php echo esc_attr($google); ?>" /></p>
		<p>
			<label for="<?php echo $this->get_field_id('google_label'); ?>"><?php echo 'Google+ '.theme_locals("label"); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('google_label'); ?>" name="<?php echo $this->get_field_name('google_label'); ?>" type="text" value="<?php echo esc_attr($google_label); ?>" />
		</p>
	</fieldset>

	<fieldset style="border:1px solid #dfdfdf; padding:10px 10px 0; margin-bottom:1em;">
		<legend style="padding:0 5px;"><?php echo 'Pinterest' ?>:</legend>
	<p><label for="<?php echo $this->get_field_id('pinterest'); ?>"><?php echo 'Pinterest URL:' ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('pinterest'); ?>" name="<?php echo $this->get_field_name('pinterest'); ?>" type="text" value="<?php echo esc_attr($pinterest); ?>" /></p>
	<p><label for="<?php echo $this->get_field_id('pinterest_label'); ?>"><?php echo 'Pinterest '.theme_locals("label") ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('pinterest_label'); ?>" name="<?php echo $this->get_field_name('pinterest_label'); ?>" type="text" value="<?php echo esc_attr($pinterest_label); ?>" /></p>
	</fieldset>

	<fieldset style="border:1px solid #dfdfdf; padding:10px 10px 0; margin-bottom:1em;">
		<legend style="padding:0 5px;"><?php echo 'RSS' ?>:</legend>
	<p><label for="<?php echo $this->get_field_id('rss'); ?>"><?php echo 'RSS URL:' ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('rss'); ?>" name="<?php echo $this->get_field_name('rss'); ?>" type="text" value="<?php echo esc_attr($rss); ?>" /></p>
	<p><label for="<?php echo $this->get_field_id('pinterest_label'); ?>"><?php echo 'RSS '.theme_locals("label") ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('rss_label'); ?>" name="<?php echo $this->get_field_name('rss_label'); ?>" type="text" value="<?php echo esc_attr($rss_label); ?>" /></p>
	</fieldset>

	<fieldset style="border:1px solid #dfdfdf; padding:10px 10px 0; margin-bottom:1em;">
		<legend style="padding:0 5px;"><?php echo 'Instagram' ?>:</legend>
	<p><label for="<?php echo $this->get_field_id('instagram'); ?>"><?php echo 'Instagram URL:' ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('instagram'); ?>" name="<?php echo $this->get_field_name('instagram'); ?>" type="text" value="<?php echo esc_attr($instagram); ?>" /></p>
	<p><label for="<?php echo $this->get_field_id('instagram_label'); ?>"><?php echo 'Instagram '.theme_locals("label") ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('instagram_label'); ?>" name="<?php echo $this->get_field_name('instagram_label'); ?>" type="text" value="<?php echo esc_attr($instagram_label); ?>" /></p>
	</fieldset>


		<p><?php echo theme_locals("display") ?></p>
		<label for="<?php echo $this->get_field_id('icons'); ?>"><input type="radio" name="<?php echo $this->get_field_name('display'); ?>" value="icons" id="<?php echo $this->get_field_id('icons'); ?>" <?php checked($display, "icons"); ?>></input>  <?php echo theme_locals("icons") ?></label>
		<label for="<?php echo $this->get_field_id('labels'); ?>"><input type="radio" name="<?php echo $this->get_field_name('display'); ?>" value="labels" id="<?php echo $this->get_field_id('labels'); ?>" <?php checked($display, "labels"); ?>></input> <?php echo theme_locals("labels") ?></label>
		<label for="<?php echo $this->get_field_id('both'); ?>"><input type="radio" name="<?php echo $this->get_field_name('display'); ?>" value="both" id="<?php echo $this->get_field_id('both'); ?>" <?php checked($display, "both"); ?>></input> <?php echo theme_locals("both") ?></label>


<?php
	}
}

add_action('widgets_init', create_function('', 'return register_widget("My_SocialNetworksWidget");'));
?>