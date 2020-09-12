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
	</div>
		
	<div class="shortcodes">
		<table>
            <thead>
                <tr>
                    <th colspan="2"><h2 class=""><?php echo _e( "AVAILABLE SHORTCODES", FOURSQUARE_INTEGRATION_L10N ); ?></h2></th>
                </tr>
                <tr>
                    <th><?php echo _e( "Shortcode", FOURSQUARE_INTEGRATION_L10N ); ?></th>
                    <th><?php echo _e( "Frontend Method", FOURSQUARE_INTEGRATION_L10N ); ?></th>
                </tr>
            </thead>
            <tbody>
            	<?php foreach($available_shortcodes as $available_shortcode): ?>
            		<tr>
            			<?php foreach($available_shortcode as $shortcode => $method): ?>
                        	<td>[<?php echo $shortcode;?>]</td>
                        	<td><?php echo $method;?></td>
                        <?php endforeach; ?>
                    </tr>
				<?php endforeach; ?>
            </tbody>
        </table>
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
 
		<?php submit_button(); ?>

	</form>
</div>

<hr />

<p>
	<span class="dashicons dashicons-wordpress"> </span>
	<span><?php _e( "Author", 'foursquare_integration' ); ?>:</span>
	<a href="https://www.giuseppemaccario.com/" target="_blank">Giuseppe Maccario</a>
</p>