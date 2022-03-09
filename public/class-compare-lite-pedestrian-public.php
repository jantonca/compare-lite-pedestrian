<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://pedestriangroup.com.au/
 * @since      1.1.0
 *
 * @package    Compare_Lite_Pedestrian
 * @subpackage Compare_Lite_Pedestrian/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Compare_Lite_Pedestrian
 * @subpackage Compare_Lite_Pedestrian/public
 * @author     Jose Anton <jose.anton@pedestriangroup.com.au>
 */
class Compare_Lite_Pedestrian_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.1.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.1.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.1.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.1.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Compare_Lite_Pedestrian_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Compare_Lite_Pedestrian_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/compare-lite-pedestrian-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.1.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Compare_Lite_Pedestrian_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Compare_Lite_Pedestrian_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		//wp_enqueue_script( 'jquery-js', plugin_dir_url( __FILE__ ) . 'js/jQuery-latest.js', array( 'jquery' ), $this->version, false );
		//wp_enqueue_script( 'jquery-ui', plugin_dir_url( __FILE__ ) . 'js//jquery-ui.min-latest.js', array( 'jquery' ), $this->version, false );
		//wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/compare-lite-pedestrian-public.js', array( 'jquery' ), $this->version, false );
/* 		wp_localize_script(
			$this->plugin_name,
			'compareLiteGlobalObject', // Array containing dynamic data for a JS Global.
			[
				'pluginDirPath' => plugin_dir_path( __DIR__ ),
				'pluginDirUrl'  => plugin_dir_url( __DIR__ ),
				// Add more data here that you want to access from `cgbGlobal` object.
			]
		); */

	}

	public function register_shortcodes() {

		add_shortcode( 'compare_lite_pedestrian', array( $this, 'compare_lite_shortcode') );

	}

	// function that runs when shortcode is called
	public  function compare_lite_shortcode( $atts = [], $content = null, $tag = '') {

		// normalize attribute keys, lowercase
		$atts = array_change_key_case( (array) $atts, CASE_LOWER );
		// override default attributes with user attributes
		$default_atts = shortcode_atts(
			array(
				'main_title' => 'Where are you located?',
				'placeholder_text' => 'Enter your postcode or suburb',
				'button_text' => 'Get Started',
				'currently_available_text' => 'Currently available in ddd, ACT, SA, VIC, parts of QLD, TAS &amp; WA (only Gas).',
				'not_available_text' => 'Not available in Ergon Area (QLD), NT and embedded networks or non-quotable meters. ',
				'utm_source' => 'lifehacker',
				'url_final' => 'https://www.econnex.com.au/',
				'amp' => 'true',
				'inputId' => uniqid()
			), $atts, $tag
		);

		ob_start(); // Turn on output buffering

		?>

		<?php if( $this->is_amp_active() ): ?>
			
			<?php if( $default_atts['amp'] === 'true' ): ?>
				<div class="amp-cimet-form" style="background-color: #f5f5f5; padding:10px;max-width: 350px;margin-bottom:1rem;">
					<h5 style="margin-bottom: 1rem;"><?php echo esc_html( $default_atts['main_title'] ); ?></h5>
					<form class="sample-form" method="get" action="<?php echo esc_url( $default_atts['url_final'] ); ?><?php echo esc_html( $default_atts['utm_source'] ); ?>" target="_blank">
					<div class="input-field" style="width: 100%;margin-bottom: 1rem;" >
						<amp-autocomplete 
							highlight-user-entry 
							on="select:AMP.setState({
								chosenPostCode_<?php echo esc_attr( $default_atts['inputId'] ); ?>: event.value 
							})" 
							filter="substring" 
							min-characters="3" 
							filter-value="postCode" 
							src="<?php echo esc_url( plugin_dir_url( __DIR__ ) ); ?>public/js/postcodes.json" 
							style="min-width: 100%;"
						>
							<input name="postcode" placeholder="<?php echo esc_attr( $default_atts['placeholder_text'] ); ?>" required style="min-width: 100%;padding: 20px 15px;border-radius: 0px;">
							<template type="amp-mustache" id="amp-template-custom">
								<div class="city-item" data-value="{{postCode}}">
									<div>{{postCode}}</div>
								</div>
							</template>
						</amp-autocomplete>
						<input hidden name="utm_source" value="<?php echo esc_attr( $default_atts['utm_source'] ); ?>"><br>
					</div>
					<input 
						class="btn btn-primary main-btn" 
						style="padding: 20px 15px;border-radius: 0px;font-size: 1rem;background-color: #f1b734;border: none;color: darkslategrey;" 
						disabled [disabled]="!chosenPostCode_<?php echo esc_attr( $default_atts['inputId'] ); ?>"  
						type="submit" value="<?php echo esc_attr( $default_atts['button_text'] ); ?>"
					>
					<p 
						style="font-size: 0.85rem;margin-top:0.5rem" 
						[text]="chosenPostCode_<?php echo esc_attr( $default_atts['inputId'] ); ?> != null ? 'Your selected area: ' + chosenPostCode_<?php echo esc_attr( $default_atts['inputId'] ); ?> : 'No area selected'"
					></p>
					</form>
					<p style="font-size: 0.7rem;margin-top: 1rem;">
						<?php echo esc_html( $default_atts['currently_available_text'] ); ?>
						<span><?php echo esc_html( $default_atts['not_available_text'] ); ?></span>
					</p>
				</div>
			<?php else: ?>
				<div class="amp-cimet-form no-amp" style="max-width: 400px;padding: 10px; background-color: #f5f5f5";>
					<h5 style="margin-bottom: 1rem;"><?php echo esc_html( $default_atts['main_title'] ); ?></h5>
					<a 
						class="btn" 
						href="<?php echo esc_url( $default_atts['url_final'] ); ?><?php echo esc_html( $default_atts['utm_source'] ); ?> " 
						style="background-color: #f1b734;padding: 10px 25px;text-decoration: none;" 
						target="_blank" 
					><?php echo esc_html( $default_atts['button_text'] ); ?></a>
					<p style="font-size: 0.7rem;margin-top: 1rem;">
						<?php echo esc_html( $default_atts['currently_available_text'] ); ?>
						<span><?php echo esc_html( $default_atts['not_available_text'] ); ?></span>
					</p>
				</div>
			<?php endif; ?>

		<?php else: ?>

			<script>

				var pluginDirUrl = '<?php echo esc_url( plugin_dir_url( __DIR__ ) ); ?>';
				var postId = '<?php echo get_the_ID(); ?>';
				var urlFinal = '<?php echo esc_url( $default_atts['url_final'] ); ?>';
				var utmSource = '<?php echo esc_html( $default_atts['utm_source'] ); ?>';

				function addStyle ( filename, id ) {
					// house-keeping: if style is already exist do nothing
					if( document.getElementsByTagName('head')[0].innerHTML.toString().includes( filename + ".css" ) ) {

						console.log("style: " + id + "is already exist in head tag!");

					} else {

						// add the style
						loadStyle( filename + ".css", id );

					}
				}

				function loadStyle( filename, id ) {
					var node = document.createElement('link');
					node.href = filename;
					node.id = id;
					node.rel = 'stylesheet';
					node.media = 'all';
					document.getElementsByTagName('head')[0].appendChild(node);
					console.log("style: " + id + " is added");
				}

				function addScript ( filename, id ) {
					// house-keeping: if script is already exist do nothing
					if( document.getElementsByTagName('head')[0].innerHTML.toString().includes( filename + ".js" ) ) {

						console.log("script: " + id + "is already exist in head tag!");
						loadCompareLite();

					} else {

						// add the script
						loadScript( filename + ".js", id );

					}
				}

				function loadScript(filename, id) {
					var node = document.createElement('script');
					node.src = filename;
					node.id = id;
					document.getElementsByTagName('head')[0].appendChild(node);
					console.log("script: " + id + " is added");
				}

				addStyle('<?php echo esc_url( plugin_dir_url( __FILE__ ) ); ?>css/compare-lite-pedestrian-public', 'compare-lite-pedestrian-public');
				addScript('<?php echo esc_url( plugin_dir_url( __FILE__ ) ); ?>js/jQuery-latest', 'jQuery-latest');
				setTimeout(function() {
					addScript('<?php echo esc_url( plugin_dir_url( __FILE__ ) ); ?>js/jquery-ui.min-latest' , 'jquery-ui.min-latest');
				}, 300 );
				setTimeout(function() {
					addScript('<?php echo esc_url( plugin_dir_url( __FILE__ ) ); ?>js/compare-lite-pedestrian-public', 'compare-lite-pedestrian-public');
				}, 700);
		
			</script>

			<div class="compare_lite_main_input">
				<h5 class="compare_lite_small_heading"><?php echo esc_html( $default_atts['main_title'] ); ?></h5>
				<input type="text"  class="compare_lite_postcode_search" name="post_code" placeholder="<?php echo esc_attr( $default_atts['placeholder_text'] ); ?>" class="form-control post-code-home ui-autocomplete-input ui-autocomplete-loading" autocomplete="off" disabled>
				<!-- <label for="postcode">Enter your postcode or suburb</label> -->
				<span class="fielderrormain error_compare_lite_post_code"></span>
				<button  class="btn btn-primary main-btn  common-cursor-class compare_lite_postcode_submit" disabled ><span><?php echo esc_html( $default_atts['button_text'] ); ?></span></button>
				<p class="compare_lite_field_note">
					<?php echo esc_html( $default_atts['currently_available_text'] ); ?>
					<span><?php echo esc_html( $default_atts['not_available_text'] ); ?></span>
				</p>
			</div>

		<?php endif; ?>

		<?php

		/* END HTML OUTPUT */
		$output = ob_get_contents(); // collect output
		ob_end_clean(); // Turn off ouput buffer
		return $output; // Print output

	}

	/**
	 * Checks whether the current view is served in AMP context.
	 *
	 * @return bool True if AMP, false otherwise.
	 */
	public static function is_amp_active() {
		if ( function_exists( 'amp_is_request' ) && amp_is_request() || function_exists( 'ampforwp_is_amp_endpoint' ) && ampforwp_is_amp_endpoint() ) {
			return true;
		}
		return false;
	}

}
