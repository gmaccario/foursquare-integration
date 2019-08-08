<div class="foursquare_integration wrap">

	<div class="intro">
		<h1><?php _e( FOURSQUARE_INTEGRATION_NAME, FOURSQUARE_INTEGRATION_L10N); ?></h1>
		
		<hr />
		
		<hr class="wp-header-end">
	
		<?php if( 'update' == $action ): ?>
			<div id="message" class="updated">
				<p><?php _e( "Settings saved", FOURSQUARE_INTEGRATION_L10N ); ?></p>
			</div>
		<?php endif; ?>
		
		<div class="shortcodes">
			<h2 class=""><?php echo __( 'AVAILABLE SHORTCODES' ); ?></h2>

			<div class="shortcodes">
				<ul>
					<li>
						<span>[default_template_shortcode]</span>: 
						<span><?php echo __( 'Default widget', FOURSQUARE_INTEGRATION_L10N ); ?>.</span>
					</li>
				</ul>
			</div>
		</div>

		<hr />

		<form name="form" class="form" method="post" action=""> <?php /* WARNING: using options.php in action attribute causes a problem with passing values parameters */ ?>
			<?php settings_fields( FOURSQUARE_INTEGRATION_OPT_SETTINGS_FIELDS ); ?>
			
			<h4><?php echo __( 'Foursquare API keys', FOURSQUARE_INTEGRATION_L10N ); ?></h4>
			<p>
    			<label for="client_id" class="text"><?php echo __( 'Client ID', 'fsi' ); ?></label>
    			
    			<input type="text" id="client_id" class="client_id" value="<?php echo $value_client_id; ?>" name="<?php echo FOURSQUARE_INTEGRATION_OPT_CLIENT_ID; ?>">
    		</p>
    
    		<p>
    			<label for="client_secret" class="text"><?php echo __( 'Secret Key', 'fsi' ); ?></label>
    			
    			<input type="text" id="client_secret" class="client_secret" value="<?php echo $value_secret_key; ?>" name="<?php echo FOURSQUARE_INTEGRATION_OPT_SECRET_KEY; ?>">
    		</p>
			
			<h4><?php echo __( 'Debug', FOURSQUARE_INTEGRATION_L10N ); ?></h4>
			<p>
				<input type="radio" class="debug" value="1" name="<?php echo FOURSQUARE_INTEGRATION_OPT_DEBUG; ?>" id="debug_enable" <?php echo ( $value_debug == 1 ) ? 'checked="checked"' : ''; ?>>
				<label for="debug_enable" class="radio"><?php echo __( 'Enable', FOURSQUARE_INTEGRATION_L10N ); ?></label>
			</p>
			<p>
				<input type="radio" class="debug" value="0" name="<?php echo FOURSQUARE_INTEGRATION_OPT_DEBUG; ?>" id="debug_disable" <?php echo ( $value_debug == 0 ) ? 'checked="checked"' : ''; ?>>
				<label for="debug_disable" class="radio"><?php echo __( 'Disable', FOURSQUARE_INTEGRATION_L10N ); ?></label>
			</p>
	 
			<?php submit_button(); ?>

		</form>

	</form>
</div>

<hr />

<p>
	<span class="dashicons dashicons-wordpress"> </span>
	<span><?php _e( "Author", 'foursquare_integration' ); ?>:</span>
	<a href="https://www.giuseppemaccario.com/" target="_blank">Giuseppe Maccario</a>
</p>