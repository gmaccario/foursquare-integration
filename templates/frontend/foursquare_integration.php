<div id="foursquare-integration" class="container-fluid">
	<div class="wrapper">
		<div v-if="!geolocation_enabled">
			<div class="row">
				<div class="col-xs-12 col-md-12">
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
            	<div class="col-sm-9 col-sm-push-3">
            		<fs-content :config="config" :geolocation_enabled="geolocation_enabled"></fs-content>
            	</div>
            	<div class="col-sm-3 col-sm-pull-9">
            		<fs-sidebar :config="config" :geolocation_enabled="geolocation_enabled"></fs-sidebar>
            	</div>
        	</div>
		</div>
	</div>
</div>