<h1><?php _e( FOURSQUARE_INTEGRATION_NAME, FOURSQUARE_INTEGRATION_L10N); ?></h1>

<p>It's working!</p>

<div id="foursquare-integration" class="container-fluid">
	<div class="wrapper">
		<div v-if="!geolocation_enabled">
			<div class="row">
				<div class="col-sm-12">
					<fs-manual-search></fs-manual-search>
					
					<div class="wrapper content">
						<fs-venue-details></fs-venue-details>
            		  	<fs-venues-near-you :config="config" :geolocation_enabled="geolocation_enabled"></fs-venues-near-you>
              		</div>
				</div>
			</div>
		</div>
		<div v-else>
			<div class="row">
            	<div class="col-sm-4">
            		<fs-sidebar :config="config" :geolocation_enabled="geolocation_enabled"></fs-sidebar>
            	</div>
            	<div class="col-sm-8">
            		<fs-content :config="config" :geolocation_enabled="geolocation_enabled"></fs-content>
            	</div>
        	</div>
		</div>
	</div>
</div>