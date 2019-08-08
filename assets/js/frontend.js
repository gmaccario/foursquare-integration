/* *****************************************************************************************
 *  
 *  Event EventBus
 *  
 *  
 */
const EventBus = new Vue();


/* *****************************************************************************************
 *  
 *  Child Components 
 *  
 *  
 */

/**
 * Manual Search
 */
const FSManualSearch = Vue.component('fs-manual-search',{
	props: {
		
	},
	data(){
		return {
			valid: false,
			city_or_zip_code: "",
			error_message: ""
		}
	},
	created() {
		
    },
	methods: {
		/**
    	 * @name validateForm
    	 * @description Validate form input
    	 */
		validateForm(evt) {

			evt.preventDefault();

			if(this.city_or_zip_code.match(/^[\w\-\s]+$/) !== null){

				this.valid = true;

				this.error_message = "";

				EventBus.$emit('update-venues-by-manual-search', this.city_or_zip_code);
			}
			else {

				this.valid = false;

				this.error_message = "City or zip code unknown. Please, try with a different one.";
			}
    	}
	},
	template:`
		<form action="#" name="manual-search" method="post" @submit="validateForm">

			<h3>Manual search</h3>

			<div class="form-group">
				<label for="city_or_zip_code_input" v-show="false">City or zip code</label>
				<input type="text" v-model.trim="city_or_zip_code" class="form-control" id="city_or_zip_code_input" aria-describedby="city_or_zip_code_input" placeholder="Enter city or zip code" />
			</div>

			<p class="alert alert-danger">{{ error_message }}</p>

			<button type="submit" class="btn btn-primary">Search</button>
		</form>`
});

/**
 * Current Location
 */
const FSCurrentLocation = Vue.component('fs-current-location',{
	props: {
		config: {
			type: Object,
			required: true
		},
		geolocation_enabled: {
			type: Boolean,
			required: true
		},
	},
	data(){
		return {
			location_name: '',
			location: {}
		}
	},
	created() {
		if(this.geolocation_enabled)
		{
			this.setWhereIAm();
		}
    },
	methods: {
		/**
    	 * @name setWhereIAm
    	 * @description More precise info on where the user is located.
    	 */
		setWhereIAm() {
			
			// ES2017 async/await support
			// @note Reverse Geocoding
			// check also https://wiki.openstreetmap.org/wiki/Nominatim#Reverse_Geocoding_.2F_Address_lookup
			const params = new URLSearchParams();
			params.append('action', 'foursquare_results');
			params.append('what', 'where_am_i');
			params.append('ll', this.config.latitude + "," + this.config.longitude);
			params.append('intent', 'checkin');
			params.append('limit', 1);
			
			axios.post(ajaxurl, params).then((response) => {
				if(response.data.response.venues[0])
				{					
					this.location_name = response.data.response.venues[0].name;
					this.location = response.data.response.venues[0].location;	
				}
			});
    	}
	},
  	template:`  	
  		<div class="wrapper current-location">
		  	<h3>Current Location</h3>
		  	
			<div class="welcome">

				<div class="col-xs-12 col-md-12" v-show="!location_name">
					<span>Loading...</span>
				</div>

				<div class="col-xs-12 col-md-2">
					<i class="fa fa-map-marker" aria-hidden="true"></i>
				</div>
				  
				<div class="col-xs-12 col-md-10">
					<div class="location" v-if="location_name">
						<span>You are in </span>
						<span>{{ location_name }}</span>
						<span> - </span>
						<span v-if="location.city">{{ location.city }}</span>
						<span v-if="location.city">, </span>
						<span>{{ location.country }}</span>
						<span> </span>
						<span>({{ location.cc }})</span>
					</div>
				</div>
		  	</div>
		  	
		  	<div class="where-am-i">
			  	<p>Here your precise location:</p>
			  	<ul>
			  		<li><span class="label">Latitude: </span><span class="value">{{ config.latitude }}</span></li>
			  		<li><span class="label">Longitude: </span><span class="value">{{ config.longitude }}</span></li>
			  		<li><span class="label">Accuracy: </span><span class="value">&cong; {{ parseInt(config.accuracy) }} meters</span></li>
			  	</ul>
  			</div>
  		</div>`
});

/**
 * Categories
 */
const FSCategories = Vue.component('fs-categories',{
	props: {
		config: {
			type: Object,
			required: true
		},
		geolocation_enabled: {
			type: Boolean,
			required: true
		}
	},
	data(){
		return {
			categories: [],
			categoryId: 0
		}
	},
	created() {
		if(this.geolocation_enabled)
		{
			this.getCategories();
		}		
	},
	methods: {
		
		/**
    	 * @name getCategories
    	 * @description Get categories
    	 */
		getCategories() {
			
			// ES2017 async/await support
			const params = new URLSearchParams();
			params.append('action', 'foursquare_results');
			params.append('what', 'get_categories');
			params.append('ll', this.config.latitude + "," + this.config.longitude);
			params.append('intent', 'checkin');
			
			axios.post(ajaxurl, params).then((response) => {
				this.categories = response.data.response.categories;
			});
		},
		
    	/**
    	 * @name getVenuesByCategory
    	 * @description Get the list of venue by category
    	 */
    	getVenuesByCategory(category_id) {
    		
			this.categoryId = category_id;

			EventBus.$emit('update-venues-by-category', category_id);
    	}
	},
  	template:`  	
  		<div class="wrapper categories" v-if="categories.length > 0">
		  	<h3>Categories</h3>
		  	
  			<p v-show="!categories.length">Loading...</p>
  			
		  	<div class="row" v-for="category in categories">
				<div class="col-xs-12 col-md-4">
					<a href="#" @click="getVenuesByCategory(category.id);">
						<img :src="category.icon.prefix + '32' + category.icon.suffix" />
					</a>
				</div>
				<div class="col-xs-12 col-md-8 text-right">
					<a href="#" @click="getVenuesByCategory(category.id);">
						<span class="shortName" :class="(categoryId == category.id) ? 'current' : ''">
							{{ category.shortName }}
						</span>
					</a>
				</div>
			</div>
  		</div>`
});

/**
 * Venue Details
 */
const FSVenueDetails = Vue.component('fs-venue-details',{
	props: {

	},
	data(){
		return {
			venue: {}
		}
	},
	created() {

		EventBus.$on('get-venue-by-id', (venue_id) => {

			this.getVenueById(venue_id);
		});

		EventBus.$on('reset-venue', () => {

			this.venue = {};
		});
	},
	methods: {

		/**
    	 * @name getVenueById
    	 * @description Get venues near you
    	 */
		getVenueById(venue_id) {

    		// ES2017 async/await support
			const params = new URLSearchParams();
			params.append('action', 'foursquare_results');
			params.append('what', 'get_venue_details');
			params.append('id_venue', venue_id);
			params.append('intent', 'checkin');
			
			axios.post(ajaxurl, params).then((response) => {				
				
				if(response.data.meta.code != 429){
					this.venue = response.data.response.venue;
				}
				else {
					Vue.set(this.venue, 'error', response.data.meta.code);
				}
			});
		}
	},
  	template:`  	
  		<div class="wrapper venue-details" v-if="venue.error || venue.id">
		  	<h3>Venue Details</h3>
		  	
		  	<div class="details">
		  	
			  	<p class="error" v-if="venue.error">
			  		<span v-if="venue.error == 429">Free account here! Currently over the daily call quota limit (950 calls per day).</span>
			  	</p>
		  	
				<div v-if="!venue.error">
				  	<div class="row">
            			<div class="col-xs-12 col-md-4">
							<div class="venue best-photo">
								<img class="icon" 
									v-if="venue.bestPhoto" 
									v-bind:src="venue.bestPhoto.prefix + '64' + venue.bestPhoto.suffix" 
									:alt="venue.name" 
									:title="venue.name" />
									
								<img class="icon" 
									v-if="!venue.bestPhoto" 
									src="https://via.placeholder.com/64" 
									:alt="venue.name" 
									:title="venue.name" />
							</div>
							
							<div class="contact">
								<a :href="'tel:' + venue.contact.phone" v-if="venue.contact.phone">
									<i class="fa fa-phone" aria-hidden="true"></i>
								</a>
								
								<a :href="'https://www.facebook.com/profile.php?id=' + venue.contact.facebook" v-if="venue.contact.facebook" target="_blank" >
									<i class="fa fa-facebook" aria-hidden="true"></i>
								</a>
								
								<a :href="'https://twitter.com/' + venue.contact.twitter" v-if="venue.contact.twitter" target="_blank">
									<i class="fa fa-twitter" aria-hidden="true"></i>
								</a>
							</div>
						</div>

						<div class="col-xs-12 col-md-8">
							<h5 class="text-right">
								<a :href="venue.shortUrl" target="_blank">
									<span><strong>{{ venue.name }}</strong></span>
								</a>
							</h5>
							
							<h6 class="text-right" v-if="venue.categories[0]" >
								<i v-if="venue.verified" class="fa fa-check verified" aria-hidden="true" alt="Verified" title="Verified"></i>
								{{ venue.categories[0].name }}
							</h6>
							
							<div class="address text-right">
								<span v-if="venue.location.address">{{ venue.location.address }}</span>
								<span v-if="venue.location.address"><br /></span> 
								<span v-if="venue.location.city">{{ venue.location.city }}</span>
								<span v-if="venue.location.city">-</span> 
								<span v-if="venue.location.state">{{ venue.location.state }}</span> 
								<span v-if="venue.location.state">-</span>
								<span v-if="venue.location.country">{{ venue.location.country }}</span> 
							</div>
							
							<div class="likes text-right" v-if="venue.likes.count > 0">
								<span class="value">{{ venue.likes.count }}</span>
								<span> </span>
								<span class="label">likes</span>
							</div>
							
							<div class="rating text-right" v-if="venue.likes.rating > 0">
								<span class="label">Rating</span>
								<span> </span>
								<span class="value">{{ venue.rating }}</span>
							</div>
							
							<div class="other text-right" v-if="venue.hereNow.count > 0">
								<span class="alert alert-success hereNow">
									<i aria-hidden="true" class="fa fa-star"></i> 
									<span>{{ venue.hereNow.summary }}</span>
								</span>
							</div>
						</div>

						<div class="col-xs-12 col-md-12">
							<div class="tips text-left" v-if="venue.tips.count > 0">
								<span>Tips: </span>
								<span>{{ venue.tips.groups[0].items[0].text }}</span>
								<span> </span>
								<span v-if="venue.tips.groups[0].items[0].likes.summary">({{ venue.tips.groups[0].items[0].likes.summary }})</span>
							</div>
						</div>
					</div>
		  		</div>
		  	</div>
  		</div>`
});

/**
 * Venues Near You
 */
const FSVenuesNearYou = Vue.component('fs-venues-near-you',{
	props: {
		config: {
			type: Object,
			required: true
		},
		geolocation_enabled: {
			type: Boolean,
			required: true
		},
	},
	data(){
		return {
			venues: []
		}
	},
	watch: {
    	
	},
	created() {
		if(this.geolocation_enabled){
			this.getVenuesNearYou();
		}

		EventBus.$on('update-venues-by-category', (categoryId) => {

			this.getVenuesNearYou(categoryId);
		});

		EventBus.$on('update-venues-by-manual-search', (city_or_zip_code) => {

			this.updateVenuesNearYouByManualSearch(city_or_zip_code);
		});
	},
	methods: {
		
		/**
    	 * @name getVenueById
    	 * @description Get venues near you
    	 */
		getVenueById(venue_id) {

			EventBus.$emit('get-venue-by-id', venue_id);
		},

		/**
    	 * @name compareToSortByDistance
    	 * @description Compare the venues distance to sort the venues by distance
    	 */
		compareToSortByDistance( a, b ) {
			if ( a.location.distance < b.location.distance ){
				return -1;
			}
			if ( a.location.distance > b.location.distance ){
				return 1;
			}
			return 0;
		},

		/**
    	 * @name getVenuesNearYou
    	 * @description Get venues near you
    	 */
		getVenuesNearYou(categoryId) {

			// ES2017 async/await support
			const params = new URLSearchParams();
			params.append('action', 'foursquare_results');
			params.append('ll', this.config.latitude + "," + this.config.longitude);
			params.append('radius', 5000);
			params.append('intent', 'checkin');

			if(!categoryId){
				params.append('what', 'get_venues_per_coords');
			}
			else {
				params.append('what', 'get_venues_by_category');
				params.append('categoryId', categoryId);
			}

			axios.post(ajaxurl, params).then((response) => {

				this.venues = response.data.response.venues.sort(this.compareToSortByDistance);

				EventBus.$emit('reset-venue');
			});
		},

		/**
    	 * @name updateVenuesNearYouByManualSearch
    	 * @description Get new venues from manual search
    	 */
		updateVenuesNearYouByManualSearch(city_or_zip_code) {
			
			// ES2017 async/await support
			const params = new URLSearchParams();
			params.append('action', 'foursquare_results');
			params.append('what', 'search_near_to');
			params.append('radius', 5000);
			params.append('near', city_or_zip_code);
			params.append('intent', 'checkin');

			axios.post(ajaxurl, params).then((response) => {				

				this.venues = response.data.response.venues.sort(this.compareToSortByDistance);
			});
		},
	},
  	template:`  	
  		<div class="wrapper venues-near-you" v-if="venues.length > 0">
		  	<h3>Venues Near You</h3>
		  	
		  	<p v-show="!venues.length">Loading...</p>
			
			<div class="row" v-for="(venue, index) in venues">
				  
				<div class="col-xs-12 col-md-4">
					<div class="category icon">
						<img class="icon" 
							v-if="venue.categories[0]" 
							v-bind:src="venue.categories[0].icon.prefix + '64' + venue.categories[0].icon.suffix" 
							alt="venue.categories[0].name" 
							:title="venue.categories[0].name" />
							
						<img class="icon" 
							v-if="!venue.categories[0]" 
							src="https://via.placeholder.com/64" 
							alt="No category" 
							title="No category" />
					</div>
				
					<div class="distance" v-if="venue.location.distance">
						<span>in </span>
						<span>{{ venue.location.distance }} </span>
						<span>meters</span>
					</div>
				</div>

				<div class="col-xs-12 col-md-8 details">
					<h4 class="text-right">
						<a href="#" @click="getVenueById(venue.id);">
							<span><strong>{{ venue.name }}</strong></span>
						</a>
					</h4>
					
					<h6 class="text-right" v-if="venue.categories[0]" >{{ venue.categories[0].name }}</h6>
					
					<div class="address text-right">
						<span v-if="venue.location.address">{{ venue.location.address }}</span>
						<span v-if="venue.location.address"><br /></span> 
						<span v-if="venue.location.city">{{ venue.location.city }}</span>
						<span v-if="venue.location.city">-</span> 
						<span v-if="venue.location.state">{{ venue.location.state }}</span> 
						<span v-if="venue.location.state">-</span>
						<span v-if="venue.location.country">{{ venue.location.country }}</span> 
					</div>
					
					<div class="other text-right">
						<span v-if="venue.hereNow.count > 0" class="alert alert-success hereNow">
							<i aria-hidden="true" class="fa fa-star"></i> 
							<span>{{ venue.hereNow.summary }}</span>
						</span>
					</div>
				</div>
				
				<div class="col-xs-12 col-md-12">
					<p class="text-right nmb">{{ index + 1 }}</p>
				</div>
			</div>
  		</div>`
});

/* *****************************************************************************************
 *  
 *  Main Components 
 *  
 *  
 */
/**
 * Sidebar
 */
const FSSidebar = Vue.component('fs-sidebar',{
	components: {
		FSCurrentLocation, 
		FSCategories
	},
	props: {
		config: {
			type: Object,
			required: true
		},
		geolocation_enabled: {
			type: Boolean,
			required: true
		}
	},
  	template:`  	
  		<div class="wrapper sidebar">
		  	<fs-current-location :config="config" :geolocation_enabled="geolocation_enabled"></fs-current-location>
		  	<fs-categories :config="config" :geolocation_enabled="geolocation_enabled"></fs-categories>
  		</div>`
});

/**
 * Content
 */
const FSContent = Vue.component('fs-content',{
	components: {
		FSVenueDetails, 
		FSVenuesNearYou
	},
	props: {
		config: {
			type: Object,
			required: true
		},
		geolocation_enabled: {
			type: Boolean,
			required: true
		},
	},
  	template:`  	
  		<div class="wrapper content">
		  	<fs-venue-details></fs-venue-details>
		  	<fs-venues-near-you :config="config" :geolocation_enabled="geolocation_enabled"></fs-venues-near-you>
  		</div>`
});

/* *****************************************************************************************
 *  
 *  Vm is responsible to get the coordinates to the users and set up the config object 
 *  that will be pass to the other components.
 *  
 */
let foursquareDomElement = document.getElementById('foursquare-integration');

if(foursquareDomElement)
{
	const vm = new Vue({
		el: '#foursquare-integration',
		components: {
			'fs-sidebar': FSSidebar,
			'fs-content': FSContent,
			'fs-manual-search': FSManualSearch
		},
		data: {
			config: {
				latitude: 0,
				longitude: 0,
				accuracy: 0
			},
			
			geolocation_enabled: false
		},
		created(){
			this.getCurrentPosition();
		},
		methods: {
			/**
			 * @name getCurrentPosition
			 * @description Get the current position of the user and set up config variable if user geolocation is enabled.
			 */
			getCurrentPosition() {
				
				let options = {
						enableHighAccuracy: true,
						timeout: 5000,
						maximumAge: 0
					};
				return navigator.geolocation.getCurrentPosition( 
					this.getCurrentPositionSuccess, 
					this.getCurrentPositionError, options 
				);
			},
			/**
			 * @name getCurrentPositionSuccess
			 * @description In case of geolocalization enabled.
			 */
			getCurrentPositionSuccess(pos) {
				var crd = pos.coords;
				
				this.config.latitude = crd.latitude;
				this.config.longitude = crd.longitude;
				this.config.accuracy = crd.accuracy;

				this.geolocation_enabled = true;
			},
			/**
			 * @name getCurrentPositionError
			 * @description In case of geolocalization disabled.
			 */
			getCurrentPositionError(err) {
				
				this.geolocation_enabled = false;
				
				console.log("Geolocalization disabled!");
			}
		}
	});
}